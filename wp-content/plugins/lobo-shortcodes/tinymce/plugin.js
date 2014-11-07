(function() {
"use strict";  
 
    tinymce.PluginManager.add( 'loboShortcodes', function( editor, url ) {

    	editor.addCommand("loboPopup", function ( a, params ) {

			var popup = params.identifier;
		
			// load thickbox
			tb_show("lobo Shortcodes", url + "/popup.php?popup=" + popup + "&width=700");

			jQuery('#custom-tb').remove();

			jQuery('head').append('<style id="custom-tb">#lobo-popup { height: ' + (document.documentElement.clientHeight-120) + 'px !important; } #TB_ajaxContent { background: #fff; }</style>');

		});

		// Create values array

		var valuesArr = Array();

		for(var i = 0; i < loboShortcodes.shortcodesList.length; i++) {

			valuesArr[i] = {
				text: loboShortcodes.shortcodesList[i][0],
				id: loboShortcodes.shortcodesList[i][1],
				onClick: function(){
					tb_show("lobo Shortcodes", url + "/popup.php?popup=" + this._id + "&width=700");
					jQuery('#custom-tb').remove();
					jQuery('head').append('<style id="custom-tb">#lobo-popup { height: ' + (document.documentElement.clientHeight-120) + 'px !important; } #TB_ajaxContent { background: #fff; }</style>');
				}
			};

		}

        editor.addButton( 'lobo_button', {
            type: 'listbox',
            text: 'Insert Shortcode',
            icon: 'ks',
            onselect: function(e) {},
            values: valuesArr
        });
 
    });
 
})();