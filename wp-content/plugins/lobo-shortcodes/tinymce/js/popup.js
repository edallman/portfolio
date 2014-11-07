
// start the popup specefic scripts
// safe to use $
jQuery(document).ready(function($) {
    var lobos = {
    	loadVals: function()
    	{
    		var shortcode = $('#_lobo_shortcode').text(),
    			uShortcode = shortcode;
    		
    		// fill in the gaps eg {{param}}
    		$('.lobo-input').each(function() {
    			var input = $(this),
    				id = input.attr('id'),
    				id = id.replace('lobo_', ''),		// gets rid of the lobo_ prefix
    				re = new RegExp("{{"+id+"}}","g");
    				
    			uShortcode = uShortcode.replace(re, input.val());
    		});
    		
    		// adds the filled-in shortcode as hidden input
    		$('#_lobo_ushortcode').remove();
    		$('#lobo-sc-form-table').prepend('<div id="_lobo_ushortcode" class="hidden">' + uShortcode + '</div>');
    	},
    	cLoadVals: function()
    	{
    		var shortcode = $('#_lobo_cshortcode').text(),
    			pShortcode = '';
    			shortcodes = '';
    		
    		// fill in the gaps eg {{param}}
    		$('.child-clone-row').each(function() {
    			var row = $(this),
    				rShortcode = shortcode;
    			
    			$('.lobo-cinput', this).each(function() {
    				var input = $(this),
    					id = input.attr('id'),
    					id = id.replace('lobo_', '')		// gets rid of the lobo_ prefix
    					re = new RegExp("{{"+id+"}}","g");
    					
    				rShortcode = rShortcode.replace(re, input.val());
    			});
    	
    			shortcodes = shortcodes + rShortcode + "\n";
    		});
    		
    		// adds the filled-in shortcode as hidden input
    		$('#_lobo_cshortcodes').remove();
    		$('.child-clone-rows').prepend('<div id="_lobo_cshortcodes" class="hidden">' + shortcodes + '</div>');
    		
    		// add to parent shortcode
    		this.loadVals();
    		pShortcode = $('#_lobo_ushortcode').text().replace('{{child_shortcode}}', shortcodes);
    		
    		// add updated parent shortcode
    		$('#_lobo_ushortcode').remove();
    		$('#lobo-sc-form-table').prepend('<div id="_lobo_ushortcode" class="hidden">' + pShortcode + '</div>');
    	},
    	children: function()
    	{
    		// assign the cloning plugin
    		$('.child-clone-rows').appendo({
    			subSelect: '> div.child-clone-row:last-child',
    			allowDelete: false,
    			focusFirst: false
    		});
    		
    		// remove button
    		$('.child-clone-row-remove').live('click', function() {
    			var	btn = $(this),
    				row = btn.parent();
    			
    			if( $('.child-clone-row').size() > 1 )
    			{
    				row.remove();
    			}
    			else
    			{
    				alert('You need a minimum of one row');
    			}
    			
    			return false;
    		});
    		
    		// assign jUI sortable
    		$( ".child-clone-rows" ).sortable({
				placeholder: "sortable-placeholder",
				items: '.child-clone-row'
				
			});
    	},
    	resizeTB: function()
    	{
			var	ajaxCont = $('#TB_ajaxContent'),
				tbWindow = $('#TB_window'),
				loboPopup = $('#lobo-popup');

            tbWindow.css({
                height: loboPopup.outerHeight() + 50,
                width: loboPopup.outerWidth(),
                marginLeft: -(loboPopup.outerWidth()/2)
            });

			ajaxCont.css({
				paddingTop: 0,
				paddingLeft: 0,
				paddingRight: 0,
				height: (tbWindow.outerHeight()-47),
				overflow: 'auto', // IMPORTANT
				width: loboPopup.outerWidth()
			});
			
			$('#lobo-popup').addClass('no_preview');
    	},
    	load: function()
    	{
    		var	lobos = this,
    			popup = $('#lobo-popup'),
    			form = $('#lobo-sc-form', popup),
    			shortcode = $('#_lobo_shortcode', form).text(),
    			popupType = $('#_lobo_popup', form).text(),
    			uShortcode = '';
    		
    		// resize TB
    		lobos.resizeTB();
    		$(window).resize(function() { lobos.resizeTB() });
    		
    		// initialise
    		lobos.loadVals();
    		lobos.children();
    		lobos.cLoadVals();
    		
    		// update on children value change
    		$('.lobo-cinput', form).live('change', function() {
    			lobos.cLoadVals();
    		});
    		
    		// update on value change
    		$('.lobo-input', form).change(function() {
    			lobos.loadVals();
    		});
    		
    		// when insert is clicked
    		$('.lobo-insert', form).click(function() {    		 
    			if(window.tinyMCE)
				{ 
                    window.tinyMCE.execCommand('mceInsertContent', false, $('#_lobo_ushortcode', form).html());
					tb_remove();
				}
    		});
    	}
	}
    
    // run
    $('#lobo-popup').livequery( function() { lobos.load(); } );
});