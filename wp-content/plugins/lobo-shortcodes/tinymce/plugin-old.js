(function ()
{
	// create loboShortcodes plugin
	tinymce.create("tinymce.plugins.loboShortcodes",
	{
		init: function ( ed, url )
		{
			ed.addCommand("loboPopup", function ( a, params )
			{
				var popup = params.identifier;
				
				// load thickbox
				tb_show("lobo Shortcodes", url + "/popup.php?popup=" + popup + "&width=700");

				jQuery('#custom-tb').remove();

				jQuery('head').append('<style id="custom-tb">#lobo-popup { height: ' + (document.documentElement.clientHeight-120) + 'px !important; } #TB_ajaxContent { background: #fff; }</style>');

			});
		},
		createControl: function ( btn, e )
		{
			if ( btn == "lobo_button" )
			{	
				var a = this;

				var btn = e.createSplitButton('lobo_button', {
                    title: "lobo Shortcodes",
					image: loboShortcodes.pluginFolder +"/tinymce/images/icon.png",
					icons: false
                });

                btn.onRenderMenu.add(function (c, b)
				{					

					for(var i = 0; i < loboShortcodes.shortcodesList.length; i++){
						a.addWithPopup( b, loboShortcodes.shortcodesList[i][0], loboShortcodes.shortcodesList[i][1] );
					}

				});
                
                return btn;
			}
			
			return null;
		},
		addWithPopup: function ( ed, title, id ) {
			ed.add({
				title: title,
				onclick: function () {
					tinyMCE.activeEditor.execCommand("loboPopup", false, {
						title: title,
						identifier: id
					})
				}
			})
		},
		addImmediate: function ( ed, title, sc) {
			ed.add({
				title: title,
				onclick: function () {
					tinyMCE.activeEditor.execCommand( "mceInsertContent", false, sc )
				}
			})
		},
		getInfo: function () {
			return {
				longname: 'lobo Shortcodes',
				author: 'Ruben Bristian',
				authorurl: 'http://rubenbristian.com',
				infourl: 'http://wiki.moxiecode.com/',
				version: "1.0"
			}
		}
	});
	
	// add loboShortcodes plugin
	tinymce.PluginManager.add("loboShortcodes", tinymce.plugins.loboShortcodes);

})();