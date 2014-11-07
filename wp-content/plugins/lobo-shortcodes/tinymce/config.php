<?php

$current_theme = wp_get_theme();
if ( file_exists( $current_theme->get_template_directory() . '/includes/lobo-shortcodes-config.php' ) ) {
	include_once( $current_theme->get_template_directory() . '/includes/lobo-shortcodes-config.php' );
}


$iconsArray = Array(
	"none" => "None",
	"fa-adjust" => "Adjust",
	"fa-adn" => "Adn",
	"fa-align-center" => "Align Center",
	"fa-align-justify" => "Align Justify",
	"fa-align-left" => "Align Left",
	"fa-align-right" => "Align Right",
	"fa-ambulance" => "Ambulance",
	"fa-anchor" => "Anchor",
	"fa-android" => "Android",
	"fa-angellist" => "Angellist",
	"fa-angle-double-down" => "Angle Double Down",
	"fa-angle-double-left" => "Angle Double Left",
	"fa-angle-double-right" => "Angle Double Right",
	"fa-angle-double-up" => "Angle Double Up",
	"fa-angle-down" => "Angle Down",
	"fa-angle-left" => "Angle Left",
	"fa-angle-right" => "Angle Right",
	"fa-angle-up" => "Angle Up",
	"fa-apple" => "Apple",
	"fa-archive" => "Archive",
	"fa-area-chart" => "Area Chart",
	"fa-arrow-circle-down" => "Arrow Circle Down",
	"fa-arrow-circle-left" => "Arrow Circle Left",
	"fa-arrow-circle-o-down" => "Arrow Circle O Down",
	"fa-arrow-circle-o-left" => "Arrow Circle O Left",
	"fa-arrow-circle-o-right" => "Arrow Circle O Right",
	"fa-arrow-circle-o-up" => "Arrow Circle O Up",
	"fa-arrow-circle-right" => "Arrow Circle Right",
	"fa-arrow-circle-up" => "Arrow Circle Up",
	"fa-arrow-down" => "Arrow Down",
	"fa-arrow-left" => "Arrow Left",
	"fa-arrow-right" => "Arrow Right",
	"fa-arrow-up" => "Arrow Up",
	"fa-arrows" => "Arrows",
	"fa-arrows-alt" => "Arrows Alt",
	"fa-arrows-h" => "Arrows H",
	"fa-arrows-v" => "Arrows V",
	"fa-asterisk" => "Asterisk",
	"fa-at" => "At",
	"fa-automobile" => "Automobile",
	"fa-backward" => "Backward",
	"fa-ban" => "Ban",
	"fa-bank" => "Bank",
	"fa-bar-chart" => "Bar Chart",
	"fa-bar-chart-o" => "Bar Chart O",
	"fa-barcode" => "Barcode",
	"fa-bars" => "Bars",
	"fa-beer" => "Beer",
	"fa-behance" => "Behance",
	"fa-behance-square" => "Behance Square",
	"fa-bell" => "Bell",
	"fa-bell-o" => "Bell O",
	"fa-bell-slash" => "Bell Slash",
	"fa-bell-slash-o" => "Bell Slash O",
	"fa-bicycle" => "Bicycle",
	"fa-binoculars" => "Binoculars",
	"fa-birthday-cake" => "Birthday Cake",
	"fa-bitbucket" => "Bitbucket",
	"fa-bitbucket-square" => "Bitbucket Square",
	"fa-bitcoin" => "Bitcoin",
	"fa-bold" => "Bold",
	"fa-bolt" => "Bolt",
	"fa-bomb" => "Bomb",
	"fa-book" => "Book",
	"fa-bookmark" => "Bookmark",
	"fa-bookmark-o" => "Bookmark O",
	"fa-briefcase" => "Briefcase",
	"fa-btc" => "Btc",
	"fa-bug" => "Bug",
	"fa-building" => "Building",
	"fa-building-o" => "Building O",
	"fa-bullhorn" => "Bullhorn",
	"fa-bullseye" => "Bullseye",
	"fa-bus" => "Bus",
	"fa-cab" => "Cab",
	"fa-calculator" => "Calculator",
	"fa-calendar" => "Calendar",
	"fa-calendar-o" => "Calendar O",
	"fa-camera" => "Camera",
	"fa-camera-retro" => "Camera Retro",
	"fa-car" => "Car",
	"fa-caret-down" => "Caret Down",
	"fa-caret-left" => "Caret Left",
	"fa-caret-right" => "Caret Right",
	"fa-caret-square-o-down" => "Caret Square O Down",
	"fa-caret-square-o-left" => "Caret Square O Left",
	"fa-caret-square-o-right" => "Caret Square O Right",
	"fa-caret-square-o-up" => "Caret Square O Up",
	"fa-caret-up" => "Caret Up",
	"fa-cc" => "Cc",
	"fa-cc-amex" => "Cc Amex",
	"fa-cc-discover" => "Cc Discover",
	"fa-cc-mastercard" => "Cc Mastercard",
	"fa-cc-paypal" => "Cc Paypal",
	"fa-cc-stripe" => "Cc Stripe",
	"fa-cc-visa" => "Cc Visa",
	"fa-certificate" => "Certificate",
	"fa-chain" => "Chain",
	"fa-chain-broken" => "Chain Broken",
	"fa-check" => "Check",
	"fa-check-circle" => "Check Circle",
	"fa-check-circle-o" => "Check Circle O",
	"fa-check-square" => "Check Square",
	"fa-check-square-o" => "Check Square O",
	"fa-chevron-circle-down" => "Chevron Circle Down",
	"fa-chevron-circle-left" => "Chevron Circle Left",
	"fa-chevron-circle-right" => "Chevron Circle Right",
	"fa-chevron-circle-up" => "Chevron Circle Up",
	"fa-chevron-down" => "Chevron Down",
	"fa-chevron-left" => "Chevron Left",
	"fa-chevron-right" => "Chevron Right",
	"fa-chevron-up" => "Chevron Up",
	"fa-child" => "Child",
	"fa-circle" => "Circle",
	"fa-circle-o" => "Circle O",
	"fa-circle-o-notch" => "Circle O Notch",
	"fa-circle-thin" => "Circle Thin",
	"fa-clipboard" => "Clipboard",
	"fa-clock-o" => "Clock O",
	"fa-close" => "Close",
	"fa-cloud" => "Cloud",
	"fa-cloud-download" => "Cloud Download",
	"fa-cloud-upload" => "Cloud Upload",
	"fa-cny" => "Cny",
	"fa-code" => "Code",
	"fa-code-fork" => "Code Fork",
	"fa-codepen" => "Codepen",
	"fa-coffee" => "Coffee",
	"fa-cog" => "Cog",
	"fa-cogs" => "Cogs",
	"fa-columns" => "Columns",
	"fa-comment" => "Comment",
	"fa-comment-o" => "Comment O",
	"fa-comments" => "Comments",
	"fa-comments-o" => "Comments O",
	"fa-compass" => "Compass",
	"fa-compress" => "Compress",
	"fa-copy" => "Copy",
	"fa-copyright" => "Copyright",
	"fa-credit-card" => "Credit Card",
	"fa-crop" => "Crop",
	"fa-crosshairs" => "Crosshairs",
	"fa-css3" => "Css3",
	"fa-cube" => "Cube",
	"fa-cubes" => "Cubes",
	"fa-cut" => "Cut",
	"fa-cutlery" => "Cutlery",
	"fa-dashboard" => "Dashboard",
	"fa-database" => "Database",
	"fa-dedent" => "Dedent",
	"fa-delicious" => "Delicious",
	"fa-desktop" => "Desktop",
	"fa-deviantart" => "Deviantart",
	"fa-digg" => "Digg",
	"fa-dollar" => "Dollar",
	"fa-dot-circle-o" => "Dot Circle O",
	"fa-download" => "Download",
	"fa-dribbble" => "Dribbble",
	"fa-dropbox" => "Dropbox",
	"fa-drupal" => "Drupal",
	"fa-edit" => "Edit",
	"fa-eject" => "Eject",
	"fa-ellipsis-h" => "Ellipsis H",
	"fa-ellipsis-v" => "Ellipsis V",
	"fa-empire" => "Empire",
	"fa-envelope" => "Envelope",
	"fa-envelope-o" => "Envelope O",
	"fa-envelope-square" => "Envelope Square",
	"fa-eraser" => "Eraser",
	"fa-eur" => "Eur",
	"fa-euro" => "Euro",
	"fa-exchange" => "Exchange",
	"fa-exclamation" => "Exclamation",
	"fa-exclamation-circle" => "Exclamation Circle",
	"fa-exclamation-triangle" => "Exclamation Triangle",
	"fa-expand" => "Expand",
	"fa-external-link" => "External Link",
	"fa-external-link-square" => "External Link Square",
	"fa-eye" => "Eye",
	"fa-eye-slash" => "Eye Slash",
	"fa-eyedropper" => "Eyedropper",
	"fa-facebook" => "Facebook",
	"fa-facebook-square" => "Facebook Square",
	"fa-fast-backward" => "Fast Backward",
	"fa-fast-forward" => "Fast Forward",
	"fa-fax" => "Fax",
	"fa-female" => "Female",
	"fa-fighter-jet" => "Fighter Jet",
	"fa-file" => "File",
	"fa-file-archive-o" => "File Archive O",
	"fa-file-audio-o" => "File Audio O",
	"fa-file-code-o" => "File Code O",
	"fa-file-excel-o" => "File Excel O",
	"fa-file-image-o" => "File Image O",
	"fa-file-movie-o" => "File Movie O",
	"fa-file-o" => "File O",
	"fa-file-pdf-o" => "File Pdf O",
	"fa-file-photo-o" => "File Photo O",
	"fa-file-picture-o" => "File Picture O",
	"fa-file-powerpoint-o" => "File Powerpoint O",
	"fa-file-sound-o" => "File Sound O",
	"fa-file-text" => "File Text",
	"fa-file-text-o" => "File Text O",
	"fa-file-video-o" => "File Video O",
	"fa-file-word-o" => "File Word O",
	"fa-file-zip-o" => "File Zip O",
	"fa-files-o" => "Files O",
	"fa-film" => "Film",
	"fa-filter" => "Filter",
	"fa-fire" => "Fire",
	"fa-fire-extinguisher" => "Fire Extinguisher",
	"fa-flag" => "Flag",
	"fa-flag-checkered" => "Flag Checkered",
	"fa-flag-o" => "Flag O",
	"fa-flash" => "Flash",
	"fa-flask" => "Flask",
	"fa-flickr" => "Flickr",
	"fa-floppy-o" => "Floppy O",
	"fa-folder" => "Folder",
	"fa-folder-o" => "Folder O",
	"fa-folder-open" => "Folder Open",
	"fa-folder-open-o" => "Folder Open O",
	"fa-font" => "Font",
	"fa-forward" => "Forward",
	"fa-foursquare" => "Foursquare",
	"fa-frown-o" => "Frown O",
	"fa-futbol-o" => "Futbol O",
	"fa-gamepad" => "Gamepad",
	"fa-gavel" => "Gavel",
	"fa-gbp" => "Gbp",
	"fa-ge" => "Ge",
	"fa-gear" => "Gear",
	"fa-gears" => "Gears",
	"fa-gift" => "Gift",
	"fa-git" => "Git",
	"fa-git-square" => "Git Square",
	"fa-github" => "Github",
	"fa-github-alt" => "Github Alt",
	"fa-github-square" => "Github Square",
	"fa-gittip" => "Gittip",
	"fa-glass" => "Glass",
	"fa-globe" => "Globe",
	"fa-google" => "Google",
	"fa-google-plus" => "Google Plus",
	"fa-google-plus-square" => "Google Plus Square",
	"fa-google-wallet" => "Google Wallet",
	"fa-graduation-cap" => "Graduation Cap",
	"fa-group" => "Group",
	"fa-h-square" => "H Square",
	"fa-hacker-news" => "Hacker News",
	"fa-hand-o-down" => "Hand O Down",
	"fa-hand-o-left" => "Hand O Left",
	"fa-hand-o-right" => "Hand O Right",
	"fa-hand-o-up" => "Hand O Up",
	"fa-hdd-o" => "Hdd O",
	"fa-header" => "Header",
	"fa-headphones" => "Headphones",
	"fa-heart" => "Heart",
	"fa-heart-o" => "Heart O",
	"fa-history" => "History",
	"fa-home" => "Home",
	"fa-hospital-o" => "Hospital O",
	"fa-html5" => "Html5",
	"fa-ils" => "Ils",
	"fa-image" => "Image",
	"fa-inbox" => "Inbox",
	"fa-indent" => "Indent",
	"fa-info" => "Info",
	"fa-info-circle" => "Info Circle",
	"fa-inr" => "Inr",
	"fa-instagram" => "Instagram",
	"fa-institution" => "Institution",
	"fa-ioxhost" => "Ioxhost",
	"fa-italic" => "Italic",
	"fa-joomla" => "Joomla",
	"fa-jpy" => "Jpy",
	"fa-jsfiddle" => "Jsfiddle",
	"fa-key" => "Key",
	"fa-keyboard-o" => "Keyboard O",
	"fa-krw" => "Krw",
	"fa-language" => "Language",
	"fa-laptop" => "Laptop",
	"fa-lastfm" => "Lastfm",
	"fa-lastfm-square" => "Lastfm Square",
	"fa-leaf" => "Leaf",
	"fa-legal" => "Legal",
	"fa-lemon-o" => "Lemon O",
	"fa-level-down" => "Level Down",
	"fa-level-up" => "Level Up",
	"fa-life-bouy" => "Life Bouy",
	"fa-life-buoy" => "Life Buoy",
	"fa-life-ring" => "Life Ring",
	"fa-life-saver" => "Life Saver",
	"fa-lightbulb-o" => "Lightbulb O",
	"fa-line-chart" => "Line Chart",
	"fa-link" => "Link",
	"fa-linkedin" => "Linkedin",
	"fa-linkedin-square" => "Linkedin Square",
	"fa-linux" => "Linux",
	"fa-list" => "List",
	"fa-list-alt" => "List Alt",
	"fa-list-ol" => "List Ol",
	"fa-list-ul" => "List Ul",
	"fa-location-arrow" => "Location Arrow",
	"fa-lock" => "Lock",
	"fa-long-arrow-down" => "Long Arrow Down",
	"fa-long-arrow-left" => "Long Arrow Left",
	"fa-long-arrow-right" => "Long Arrow Right",
	"fa-long-arrow-up" => "Long Arrow Up",
	"fa-magic" => "Magic",
	"fa-magnet" => "Magnet",
	"fa-mail-forward" => "Mail Forward",
	"fa-mail-reply" => "Mail Reply",
	"fa-mail-reply-all" => "Mail Reply All",
	"fa-male" => "Male",
	"fa-map-marker" => "Map Marker",
	"fa-maxcdn" => "Maxcdn",
	"fa-meanpath" => "Meanpath",
	"fa-medkit" => "Medkit",
	"fa-meh-o" => "Meh O",
	"fa-microphone" => "Microphone",
	"fa-microphone-slash" => "Microphone Slash",
	"fa-minus" => "Minus",
	"fa-minus-circle" => "Minus Circle",
	"fa-minus-square" => "Minus Square",
	"fa-minus-square-o" => "Minus Square O",
	"fa-mobile" => "Mobile",
	"fa-mobile-phone" => "Mobile Phone",
	"fa-money" => "Money",
	"fa-moon-o" => "Moon O",
	"fa-mortar-board" => "Mortar Board",
	"fa-music" => "Music",
	"fa-navicon" => "Navicon",
	"fa-newspaper-o" => "Newspaper O",
	"fa-openid" => "Openid",
	"fa-outdent" => "Outdent",
	"fa-pagelines" => "Pagelines",
	"fa-paint-brush" => "Paint Brush",
	"fa-paper-plane" => "Paper Plane",
	"fa-paper-plane-o" => "Paper Plane O",
	"fa-paperclip" => "Paperclip",
	"fa-paragraph" => "Paragraph",
	"fa-paste" => "Paste",
	"fa-pause" => "Pause",
	"fa-paw" => "Paw",
	"fa-paypal" => "Paypal",
	"fa-pencil" => "Pencil",
	"fa-pencil-square" => "Pencil Square",
	"fa-pencil-square-o" => "Pencil Square O",
	"fa-phone" => "Phone",
	"fa-phone-square" => "Phone Square",
	"fa-photo" => "Photo",
	"fa-picture-o" => "Picture O",
	"fa-pie-chart" => "Pie Chart",
	"fa-pied-piper" => "Pied Piper",
	"fa-pied-piper-alt" => "Pied Piper Alt",
	"fa-pinterest" => "Pinterest",
	"fa-pinterest-square" => "Pinterest Square",
	"fa-plane" => "Plane",
	"fa-play" => "Play",
	"fa-play-circle" => "Play Circle",
	"fa-play-circle-o" => "Play Circle O",
	"fa-plug" => "Plug",
	"fa-plus" => "Plus",
	"fa-plus-circle" => "Plus Circle",
	"fa-plus-square" => "Plus Square",
	"fa-plus-square-o" => "Plus Square O",
	"fa-power-off" => "Power Off",
	"fa-print" => "Print",
	"fa-puzzle-piece" => "Puzzle Piece",
	"fa-qq" => "Qq",
	"fa-qrcode" => "Qrcode",
	"fa-question" => "Question",
	"fa-question-circle" => "Question Circle",
	"fa-quote-left" => "Quote Left",
	"fa-quote-right" => "Quote Right",
	"fa-ra" => "Ra",
	"fa-random" => "Random",
	"fa-rebel" => "Rebel",
	"fa-recycle" => "Recycle",
	"fa-reddit" => "Reddit",
	"fa-reddit-square" => "Reddit Square",
	"fa-refresh" => "Refresh",
	"fa-remove" => "Remove",
	"fa-renren" => "Renren",
	"fa-reorder" => "Reorder",
	"fa-repeat" => "Repeat",
	"fa-reply" => "Reply",
	"fa-reply-all" => "Reply All",
	"fa-retweet" => "Retweet",
	"fa-rmb" => "Rmb",
	"fa-road" => "Road",
	"fa-rocket" => "Rocket",
	"fa-rotate-left" => "Rotate Left",
	"fa-rotate-right" => "Rotate Right",
	"fa-rouble" => "Rouble",
	"fa-rss" => "Rss",
	"fa-rss-square" => "Rss Square",
	"fa-rub" => "Rub",
	"fa-ruble" => "Ruble",
	"fa-rupee" => "Rupee",
	"fa-save" => "Save",
	"fa-scissors" => "Scissors",
	"fa-search" => "Search",
	"fa-search-minus" => "Search Minus",
	"fa-search-plus" => "Search Plus",
	"fa-send" => "Send",
	"fa-send-o" => "Send O",
	"fa-share" => "Share",
	"fa-share-alt" => "Share Alt",
	"fa-share-alt-square" => "Share Alt Square",
	"fa-share-square" => "Share Square",
	"fa-share-square-o" => "Share Square O",
	"fa-shekel" => "Shekel",
	"fa-sheqel" => "Sheqel",
	"fa-shield" => "Shield",
	"fa-shopping-cart" => "Shopping Cart",
	"fa-sign-in" => "Sign In",
	"fa-sign-out" => "Sign Out",
	"fa-signal" => "Signal",
	"fa-sitemap" => "Sitemap",
	"fa-skype" => "Skype",
	"fa-slack" => "Slack",
	"fa-sliders" => "Sliders",
	"fa-slideshare" => "Slideshare",
	"fa-smile-o" => "Smile O",
	"fa-soccer-ball-o" => "Soccer Ball O",
	"fa-sort" => "Sort",
	"fa-sort-alpha-asc" => "Sort Alpha Asc",
	"fa-sort-alpha-desc" => "Sort Alpha Desc",
	"fa-sort-amount-asc" => "Sort Amount Asc",
	"fa-sort-amount-desc" => "Sort Amount Desc",
	"fa-sort-asc" => "Sort Asc",
	"fa-sort-desc" => "Sort Desc",
	"fa-sort-down" => "Sort Down",
	"fa-sort-numeric-asc" => "Sort Numeric Asc",
	"fa-sort-numeric-desc" => "Sort Numeric Desc",
	"fa-sort-up" => "Sort Up",
	"fa-soundcloud" => "Soundcloud",
	"fa-space-shuttle" => "Space Shuttle",
	"fa-spinner" => "Spinner",
	"fa-spoon" => "Spoon",
	"fa-spotify" => "Spotify",
	"fa-square" => "Square",
	"fa-square-o" => "Square O",
	"fa-stack-exchange" => "Stack Exchange",
	"fa-stack-overflow" => "Stack Overflow",
	"fa-star" => "Star",
	"fa-star-half" => "Star Half",
	"fa-star-half-empty" => "Star Half Empty",
	"fa-star-half-full" => "Star Half Full",
	"fa-star-half-o" => "Star Half O",
	"fa-star-o" => "Star O",
	"fa-steam" => "Steam",
	"fa-steam-square" => "Steam Square",
	"fa-step-backward" => "Step Backward",
	"fa-step-forward" => "Step Forward",
	"fa-stethoscope" => "Stethoscope",
	"fa-stop" => "Stop",
	"fa-strikethrough" => "Strikethrough",
	"fa-stumbleupon" => "Stumbleupon",
	"fa-stumbleupon-circle" => "Stumbleupon Circle",
	"fa-subscript" => "Subscript",
	"fa-suitcase" => "Suitcase",
	"fa-sun-o" => "Sun O",
	"fa-superscript" => "Superscript",
	"fa-support" => "Support",
	"fa-table" => "Table",
	"fa-tablet" => "Tablet",
	"fa-tachometer" => "Tachometer",
	"fa-tag" => "Tag",
	"fa-tags" => "Tags",
	"fa-tasks" => "Tasks",
	"fa-taxi" => "Taxi",
	"fa-tencent-weibo" => "Tencent Weibo",
	"fa-terminal" => "Terminal",
	"fa-text-height" => "Text Height",
	"fa-text-width" => "Text Width",
	"fa-th" => "Th",
	"fa-th-large" => "Th Large",
	"fa-th-list" => "Th List",
	"fa-thumb-tack" => "Thumb Tack",
	"fa-thumbs-down" => "Thumbs Down",
	"fa-thumbs-o-down" => "Thumbs O Down",
	"fa-thumbs-o-up" => "Thumbs O Up",
	"fa-thumbs-up" => "Thumbs Up",
	"fa-ticket" => "Ticket",
	"fa-times" => "Times",
	"fa-times-circle" => "Times Circle",
	"fa-times-circle-o" => "Times Circle O",
	"fa-tint" => "Tint",
	"fa-toggle-down" => "Toggle Down",
	"fa-toggle-left" => "Toggle Left",
	"fa-toggle-off" => "Toggle Off",
	"fa-toggle-on" => "Toggle On",
	"fa-toggle-right" => "Toggle Right",
	"fa-toggle-up" => "Toggle Up",
	"fa-trash" => "Trash",
	"fa-trash-o" => "Trash O",
	"fa-tree" => "Tree",
	"fa-trello" => "Trello",
	"fa-trophy" => "Trophy",
	"fa-truck" => "Truck",
	"fa-try" => "Try",
	"fa-tty" => "Tty",
	"fa-tumblr" => "Tumblr",
	"fa-tumblr-square" => "Tumblr Square",
	"fa-turkish-lira" => "Turkish Lira",
	"fa-twitch" => "Twitch",
	"fa-twitter" => "Twitter",
	"fa-twitter-square" => "Twitter Square",
	"fa-umbrella" => "Umbrella",
	"fa-underline" => "Underline",
	"fa-undo" => "Undo",
	"fa-university" => "University",
	"fa-unlink" => "Unlink",
	"fa-unlock" => "Unlock",
	"fa-unlock-alt" => "Unlock Alt",
	"fa-unsorted" => "Unsorted",
	"fa-upload" => "Upload",
	"fa-usd" => "Usd",
	"fa-user" => "User",
	"fa-user-md" => "User Md",
	"fa-users" => "Users",
	"fa-video-camera" => "Video Camera",
	"fa-vimeo-square" => "Vimeo Square",
	"fa-vine" => "Vine",
	"fa-vk" => "Vk",
	"fa-volume-down" => "Volume Down",
	"fa-volume-off" => "Volume Off",
	"fa-volume-up" => "Volume Up",
	"fa-warning" => "Warning",
	"fa-wechat" => "Wechat",
	"fa-weibo" => "Weibo",
	"fa-weixin" => "Weixin",
	"fa-wheelchair" => "Wheelchair",
	"fa-wifi" => "Wifi",
	"fa-windows" => "Windows",
	"fa-won" => "Won",
	"fa-wordpress" => "Wordpress",
	"fa-wrench" => "Wrench",
	"fa-xing" => "Xing",
	"fa-xing-square" => "Xing Square",
	"fa-yahoo" => "Yahoo",
	"fa-yelp" => "Yelp",
	"fa-yen" => "Yen",
	"fa-youtube" => "Youtube",
	"fa-youtube-play" => "Youtube Play",
	"fa-youtube-square" => "Youtube Square"
);

/* ------------------------
-----   Accordion    -----
------------------------------*/

if ( ! isset( $lobo_shortcodes['accordion'] ) ) {

	$lobo_shortcodes['accordion'] = array(
	    'params' => array(
			'opened' => array(
	            'std' => '0',
	            'type' => 'text',
	            'label' => __('Opened', 'textdomain'),
	            'desc' => __('You can choose which of the sections will be opened at load. "0" is the first, while "-1" will leave all sections closed.', 'textdomain')
			)
	    ),
	    'no_preview' => true,
	    'shortcode' => '[lobo_accordion opened="{{opened}}"] {{child_shortcode}} [/lobo_accordion]',
	    'popup_title' => __('Insert Accordion', 'textdomain'),
	    'child_shortcode' => array(
	        'params' => array(
	            'title' => array(
	                'std' => 'Title',
	                'type' => 'text',
	                'label' => __('Section Title', 'textdomain'),
	                'desc' => __('Title of the accordion section.', 'textdomain'),
	            ),
	            'content' => array(
	                'std' => '',
	                'type' => 'textarea',
	                'label' => __('Section Content', 'textdomain'),
	                'desc' => __('Add the accordion section content.', 'textdomain')
	            )
	        ),
	        'shortcode' => '[lobo_accordion_section title="{{title}}"] {{content}} [/lobo_accordion_section]',
	        'clone_button' => __('Add Section', 'textdomain')
	    )
	);

}

/* ------------------------
-----   Content Slider    -----
------------------------------*/

if ( ! isset( $lobo_shortcodes['cslider'] ) ) {

	$lobo_shortcodes['cslider'] = array(
	    'params' => array(
	    	'style' => array(
	            'std' => 'slider',
	            'type' => 'select',
	            'label' => __('Style', 'textdomain'),
	            'desc' => __('The style of the current shortcode. It can either look as a normal slider or a tabbed slider.', 'textdomain'),
				'options' => array(
					'slider' => 'Slider',
					'tabs' => 'Tabs'
				)
			)
	    ),
	    'no_preview' => true,
	    'shortcode' => '[lobo_cslider style="{{style}}"] {{child_shortcode}} [/lobo_cslider]',
	    'popup_title' => __('Insert Content Slider', 'textdomain'),
	    'child_shortcode' => array(
	        'params' => array(
	            'title' => array(
	                'std' => '',
	                'type' => 'text',
	                'label' => __('Title', 'textdomain'),
	                'desc' => __('Add title for this slide.', 'textdomain')
	            ),
	            'icon' => array(
	                'std' => '',
	                'type' => 'select',
	                'label' => __('Icon', 'textdomain'),
                	'options' => $iconsArray,
	                'desc' => __('(optional) Select the desired icon from the given list.', 'textdomain')
	            ),
	            'content' => array(
	                'std' => '',
	                'type' => 'textarea',
	                'label' => __('Content', 'textdomain'),
	                'desc' => __('Add the  content for this slide.', 'textdomain')
	            )
	        ),
	        'shortcode' => '[lobo_cslider_slide title="{{title}}"  icon="{{icon}}"] {{content}} [/lobo_cslider_slide]',
	        'clone_button' => __('Add Slide', 'textdomain')
	    )
	);

}


/* ------------------------
-----   Images List    -----
------------------------------*/

if ( ! isset( $lobo_shortcodes['list'] ) ) {

	$lobo_shortcodes['list'] = array(
	    'no_preview' => true,
	    'shortcode' => '[lobo_list] {{child_shortcode}} [/lobo_list]',
	    'popup_title' => __('Insert Images List', 'textdomain'),
	    'child_shortcode' => array(
	        'params' => array(
	            'image' => array(
	                'std' => '',
	                'type' => 'text',
	                'label' => __('Image', 'textdomain'),
	                'desc' => __('Add an image (absolute path).', 'textdomain')
	            )
	        ),
	        'shortcode' => '[lobo_list_image image="{{image}}"]',
	        'clone_button' => __('Add Image', 'textdomain')
	    )
	);

}


/* ------------------------
-----   Tabs   -----
------------------------------*/

if ( ! isset( $lobo_shortcodes['tabs'] ) ) {

	$lobo_shortcodes['tabs'] = array(
	    'no_preview' => true,
	    'shortcode' => '[lobo_tabs] {{child_shortcode}} [/lobo_tabs]',
	    'popup_title' => __('Insert Tabs', 'textdomain'),
	    'child_shortcode' => array(
	        'params' => array(
	            'title' => array(
	                'std' => 'Title',
	                'type' => 'text',
	                'label' => __('Tab Title', 'textdomain'),
	                'desc' => __('Title of the tab.', 'textdomain'),
	            ),
	            'content' => array(
	                'std' => '',
	                'type' => 'textarea',
	                'label' => __('Tab Content', 'textdomain'),
	                'desc' => __('Add the tab content.', 'textdomain')
	            )
	        ),
	        'shortcode' => '[lobo_tabs_section title="{{title}}"] {{content}} [/lobo_tabs_section]',
	        'clone_button' => __('Add Tab', 'textdomain')
	    )
	);

}

/* ------------------------
-----   Team Slider    -----
------------------------------*/

if ( ! isset( $lobo_shortcodes['tslider'] ) ) {

	$lobo_shortcodes['tslider'] = array(
	    'params' => array(
			'type' => array(
				'type' => 'select',
				'label' => __('Slider Type', 'textdomain'),
				'desc' => __('There are two styles for the team slider. One features larger images with no social links, while the other one features smaller images with social links.', 'textdomain'),
				'options' => array(
					'one' => '#1',
					'two' => '#2'
				)
			)
	    ),
	    'no_preview' => true,
	    'shortcode' => '[lobo_tslider type="{{type}}"] {{child_shortcode}} [/lobo_tslider]',
	    'popup_title' => __('Insert Team Slider', 'textdomain'),
	    'child_shortcode' => array(
	        'params' => array(
	            'title' => array(
	                'std' => '',
	                'type' => 'text',
	                'label' => __('Title', 'textdomain'),
	                'desc' => __('Add title for this slide (member name).', 'textdomain')
	            ),
	            'subtitle' => array(
	                'std' => '',
	                'type' => 'text',
	                'label' => __('Subtitle', 'textdomain'),
	                'desc' => __('Add subtitle for this slide (member role).', 'textdomain')
	            ),
	            'image' => array(
	                'std' => '',
	                'type' => 'text',
	                'label' => __('Image', 'textdomain'),
	                'desc' => __('Add an image for this slide (absolute path).', 'textdomain')
	            ),
	            'content' => array(
	                'std' => '',
	                'type' => 'text',
	                'label' => __('Social icons', 'textdomain'),
	                'desc' => __('Add the social icons for this slide (through the social icons shortcode).', 'textdomain')
	            )
	        ),
	        'shortcode' => '[lobo_tslider_slide title="{{title}}" subtitle="{{subtitle}}" image="{{image}}"] {{content}} [/lobo_tslider_slide]',
	        'clone_button' => __('Add Slide', 'textdomain')
	    )
	);

}

/* ------------------------
-----   Buttons    -----
------------------------------*/

if ( ! isset( $lobo_shortcodes['button'] ) ) {

	$lobo_shortcodes['button'] = array(
		'no_preview' => true,
		'params' => array(
			'url' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Button URL', 'textdomain'),
				'desc' => __('Add the button\'s url eg http://example.com.', 'textdomain')
			),
			'target' => array(
				'type' => 'select',
				'label' => __('Button Target', 'textdomain'),
				'desc' => __('_self = open in same window. _blank = open in new window.', 'textdomain'),
				'options' => array(
					'_self' => '_self',
					'_blank' => '_blank'
				)
			),
			'label' => array(
				'std' => 'Button Text',
				'type' => 'text',
				'label' => __('Button\'s Text', 'textdomain'),
				'desc' => __('Add the button\'s text.', 'textdomain'),
			),
			'bgcolor' => array(
				'type' => 'text',
				'label' => __('Background Color', 'textdomain'),
				'desc' => __('Choose the button\'s background color.', 'textdomain'),
				'std' => '#fff'
			),
			'color' => array(
				'type' => 'text',
				'label' => __('Text Color', 'textdomain'),
				'desc' => __('Choose the button\'s text color.', 'textdomain'),
				'std' => '#000'
			)
		),
		'shortcode' => '[lobo_button url="{{url}}" bgcolor="{{bgcolor}}" color="{{color}}"  target="{{target}}" label="{{label}}"]',
		'popup_title' => __('Insert Button', 'textdomain')
	);

}

/* ------------------------
-----   Contact Form    -----
------------------------------*/

if ( ! isset( $lobo_shortcodes['form'] ) ) {

	$lobo_shortcodes['form'] = array(
		'no_preview' => true,
		'params' => array(
			'email' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Recipent Email Address', 'textdomain'),
				'desc' => __('Enter the email address where you wish to receive the emails sent from this form.', 'textdomain')
			),
			'label_subject' => array(
				'std' => 'Subject Idea',
				'type' => 'textarea',
				'label' => __('Subject Options', 'textdomain'),
				'desc' => __('The subject field allows to have more than one subject for the user to choose from. Use "\n" after each subject (ex: Subject #1\nSubject #2). If you write a simple label, the drop down box will not appear.', 'textdomain')
			),
			'label_name' => array(
				'std' => 'Name',
				'type' => 'text',
				'label' => __('Name Label', 'textdomain'),
				'desc' => __('Add the text for the name input field.', 'textdomain')
			),
			'label_email' => array(
				'std' => 'Email',
				'type' => 'text',
				'label' => __('Email Label', 'textdomain'),
				'desc' => __('Add the text for the email input field.', 'textdomain')
			),
			'label_message' => array(
				'std' => 'Message',
				'type' => 'text',
				'label' => __('Message Label', 'textdomain'),
				'desc' => __('Add the text for the message input field.', 'textdomain')
			),
			'label_send' => array(
				'std' => 'Send',
				'type' => 'text',
				'label' => __('Send Button Label', 'textdomain'),
				'desc' => __('Add the text for the send button.', 'textdomain')
			),
			'success' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __('Success Message', 'textdomain'),
				'desc' => __('Add a message which appears when the email was sucessfuly sent. Use "\n" for line breaks.', 'textdomain')
			),
			'required' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Required Message', 'textdomain'),
				'desc' => __('Add a message which appears at the end of the form, explaining about required fields.', 'textdomain')
			)
		),
		'shortcode' => '[lobo_form label_name="{{label_name}}" label_email="{{label_email}}"  label_subject="{{label_subject}}" label_message="{{label_message}}" label_send="{{label_send}}" email="{{email}}" success="{{success}}" required="{{required}}"]',
		'popup_title' => __('Insert Form', 'textdomain')
	);

}

/* ------------------------
-----   Icons    -----
------------------------------*/


if ( ! isset( $lobo_shortcodes['icon'] ) ) {

	$lobo_shortcodes['icon'] = array(
		'no_preview' => true,
		'params' => array(
            'icon' => array(
                'std' => '',
                'type' => 'select',
                'label' => __('Icon', 'textdomain'),
                'desc' => __('Select the desired icon from the given list.', 'textdomain'),
                'options' => $iconsArray
            ),
            'size' => array(
                'std' => '',
                'type' => 'select',
                'label' => __('Size', 'textdomain'),
                'desc' => __('Select the icon\'s size', 'textdomain'),
				'options' => array(
					'fa-tn' => 'Tiny',
					'fa-lg' => 'Small',
					'fa-2x' => 'Regular',
					'fa-3x' => 'Medium',
					'fa-4x' => 'Large',
					'fa-5x' => 'Extra large'
				)
            ),
            'color' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Color', 'textdomain'),
                'desc' => __('Write a color of the icon. It can be any <a href="http://www.w3schools.com/cssref/css_colornames.asp" target="_blank">css color name</a> or <a href="http://www.w3schools.com/cssref/css_colors_legal.asp" target="_blank">css color value</a>.', 'textdomain')
            ),
            'break' => array(
                'std' => '',
                'type' => 'select',
                'label' => __('Wrapping', 'textdomain'),
                'desc' => __('Choose how will this icon wrap against the text.', 'textdomain'),
				'options' => array(
					'float' => 'Float around text',
					'break' => 'Break text'
				)
            )
		),
		'shortcode' => '[lobo_icon size="{{size}}" icon="{{icon}}" color="{{color}}" break="{{break}}"]',
		'popup_title' => __('Insert Icon', 'textdomain')
	);

}

/* ------------------------
-----   Team Member    -----
------------------------------*/

if ( ! isset( $lobo_shortcodes['team'] ) ) {

	$lobo_shortcodes['team'] = array(
		'no_preview' => true,
		'params' => array(
            'image' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Member Picture', 'textdomain'),
                'desc' => __('Use an absolute URL to a valid image file.', 'textdomain')
            ),
            'title' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Title', 'textdomain'),
                'desc' => __('Add the member\'s title.', 'textdomain')
            ),
            'subtitle' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Subtitle', 'textdomain'),
                'desc' => __('Add the member\'s subtitle.', 'textdomain')
            ),
            'content' => array(
                'std' => '',
                'type' => 'textarea',
                'label' => __('Content', 'textdomain'),
                'desc' => __('Add the member\'s content (it can be anything from some text or a social shortcode for example).', 'textdomain')
            )
		),
		'shortcode' => '[lobo_team image="{{image}}" title="{{title}}" subtitle="{{subtitle}}"] {{content}} [/lobo_team]',
		'popup_title' => __('Insert Team Member', 'textdomain')
	);

}

/* ------------------------
-----   Twitter Feed   -----
------------------------------*/

if ( ! isset( $lobo_shortcodes['twitter'] ) ) {

	$lobo_shortcodes['twitter'] = array(
		'no_preview' => true,
		'params' => array(
            'user' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Username', 'textdomain'),
                'desc' => __('Add the desired twitter username (just the name without any special symbols).', 'textdomain')
            ),
            'no' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Number of Tweets', 'textdomain'),
                'desc' => __('Choose the number of tweets to appear in the widget.', 'textdomain')
            )
		),
		'shortcode' => '[lobo_twitter user="{{user}}" no="{{no}}"]',
		'popup_title' => __('Insert Twitter', 'textdomain')
	);

}

?>