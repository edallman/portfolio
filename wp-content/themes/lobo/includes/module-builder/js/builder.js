jQuery(window).load(function(){

	"use strict";

	$ = jQuery.noConflict();

	$('#postcustom input[value="kmb"]').parent().parent().css('display', 'none');

/* ----------------------------------------------------
---------- !! PACKERY !! -----------------
------------------------------------------------------- */

	var $kmbMeta = $('textarea#kmb');

	// Parse initial layout

	if ( $kmbMeta.val() != '' ) {

		var kmbMetaJson = safeParse($kmbMeta.val()),
			initDom = '',
			tempContent = '';

		for ( var i = 0; i < kmbMetaJson.length; i++ ) {

			initDom += '<div class="kmb-item uninit"';
			tempContent = '';

			$.each( kmbMetaJson[i], function( key, value ) {

				if ( key == 'kmbcontent' && kmbMetaJson[i].type == 'text' ) {
					tempContent = '<textarea style="width:100px;height:100px;">' + value + '</textarea>';
				} else {
					initDom += ' data-' + key + '="' + value + '"';
				}

			});

			initDom += '>' + tempContent + '</div>';

		}

		$('#kmb-container').append( initDom );

	}

    /* -------------------------------
    -----   Init  -----
    ---------------------------------*/

	var	$container = $('#kmb-container'),
		$containerClone = $('#kmb-container-clone'),
		$elems = $('.kmb-item'),

		moduleSize = $container.width() >= 630 ? 150 : 100,
		gutterSize = $container.width() >= 630 ? 10 : 5,

		// This is the set of module editing controls, appened to each module

		elemControls = '<div class="controls"><div class="left"><a class="decrease-width" href="#">Decrease Width</a><a class="increase-width" href="#">Increase Width</a><a class="increase-height" href="#">Increase Height</a><a class="decrease-height" href="#">Decrease Height</a></div><div class="right"><a class="edit" href="#" data-toggle="modal" data-target=".kmb-modal">Edit</a><a class="clone" href="#">Clone</a><a class="delete" href="#">Delete</a></div>';

	// Interpret initial layout

	$elems.each(function(){
		initModule($(this));
	});

	// Init packery

	$container.removeClass('loading')
		.packery({
			itemSelector: '.kmb-item',
			gutter: gutterSize,
			columnWidth: moduleSize,
			rowHeight: moduleSize,
			transitionDuration: '0'
		})
		.css('max-width', (moduleSize == 100 ? 465 : 670));
		
	$container.packery('on', 'dragItemPositioned', function(){
		rebuildMeta();
	});
	$container.packery('on', 'fitComplete', function(){
		rebuildMeta();
	});
	$container.packery('on', 'removeComplete', function(){
		rebuildMeta();
	});

	// Init draggable

	initDraggable();

	// Init resizing (for modules)

	$(window).resize(function(){

		if ( $containerClone.width() < 630 && moduleSize == 150 ) {

			moduleSize = 100;

			$container.packery({
				gutter: 7,
				columnWidth: 100,
				rowHeight: 100
			}).css('max-width', 465);

			$('.kmb-item').each(function(){
				setModuleSize($(this));
				$(this).addClass('mini');
			});

		} else if ( $containerClone.width() >= 630 && moduleSize == 100 ) {

			moduleSize = 150;

			$container.packery({
				gutter: 10,
				columnWidth: 150,
				rowHeight: 150
			}).css('max-width', 670);

			$('.kmb-item').each(function(){
				setModuleSize($(this));
				$(this).removeClass('mini');
				$container;
			});

		}

	});

	// Fix tinymce in modal window bug

	$(document).on('focusin', function(e) {
	    e.stopImmediatePropagation();
	});

    /* -------------------------------
    -----   Functions  -----
    ---------------------------------*/

    // This function inits a module

	function initModule( $this ) {

		// Removes the uninit class

		$this.removeClass('uninit');

		// Sets proper size

		setModuleSize($this);

		// Appends controls

		$this.append(elemControls);

		// Bind all events (related to controls)

		$this.find('.increase-width').on('click', {elem: $this}, increaseWidth);
		$this.find('.decrease-width').on('click', {elem: $this}, decreaseWidth)
		$this.find('.increase-height').on('click', {elem: $this}, increaseHeight);
		$this.find('.decrease-height').on('click', {elem: $this}, decreaseHeight);
		$this.find('.delete').on('click', {elem: $this}, deleteElem);
		$this.find('.edit').on('click', {elem: $this}, editElem);
		$this.find('.clone').on('click', {elem: $this}, cloneElem);

	}

	// The functions below are the ones which control the size of the module

	function increaseWidth(e) {

		var $elem = e.data.elem;

		if ( $elem.data('width') + 1 <= 4 ) {
			$elem.data('width', $elem.data('width')+1);
			setModuleSize($elem);
		}

		$container.packery();
		rebuildMeta();
		e.preventDefault();

	}

	function decreaseWidth(e) {

		var $elem = e.data.elem;

		if ( $elem.data('width') - 1 >= 1 ) {
			$elem.data('width', $elem.data('width')-1);
			setModuleSize($elem);
		}

		$container.packery();
		rebuildMeta();
		e.preventDefault();

	}

	function increaseHeight(e) {

		var $elem = e.data.elem;

		if ( $elem.data('height') + 1 <= 4 ) {
			$elem.data('height', $elem.data('height')+1);
			setModuleSize($elem);
		}

		$container.packery();
		rebuildMeta();
		e.preventDefault();

	}

	function decreaseHeight(e) {

		var $elem = e.data.elem;

		if ( $elem.data('height') - 1 >= 1 ) {
			$elem.data('height', $elem.data('height')-1);
			setModuleSize($elem);
		}

		$container.packery();
		rebuildMeta();
		e.preventDefault();

	}

	// This function deletes a module

	function deleteElem(e) {	

		if ( confirm( 'Press OK to delete module, Cancel to leave') ) {
			$container.packery( 'remove', e.data.elem );
			$container.packery();
			rebuildMeta();
		}
		e.preventDefault();

	}

	// This function edits an existing module

	var newModule = false,
		$oldModule = null;

	function editElem(e) {
		newModule = false;
		$oldModule = e.data.elem;
		createModalWindow();
		e.preventDefault();
	}

	// This function clones a module

	function cloneElem(e) {	

		e.data.elem.attr('data-width', e.data.elem.data('width'));
		e.data.elem.attr('data-height', e.data.elem.data('height'));

		var $app = e.data.elem.clone().appendTo( $container );
		$container.packery( 'appended', $app );
		$app.addClass('uninit');
		initModule($app);
		rebuildMeta();
		$container.packery();
		initDraggable();
		e.preventDefault();

	}

	// This functions sets the size of a module 

	function setModuleSize($elem) {

		$elem.css({
			'width': moduleSize * $elem.data('width'),
			'height': moduleSize * ( $elem.data('height') == 0 ? 4 : parseInt($elem.data('height')) )
		});

	}

	// This function inits the draggable features

	function initDraggable() {
		var $itemElems = $($container.packery('getItemElements'));
		$itemElems.draggable();
		$container.packery('bindUIDraggableEvents', $itemElems);
	}

/* ----------------------------------------------------
---------- !! MODULES !! -----------------
------------------------------------------------------- */

	var modules = $.kmbModules;

	// Insert the options in the dropdown

	for ( var i = 0; i < modules.length; i++ ) {
		$('#insert-module').find('ul').append('<li><a href="#" data-type="' + modules[i].type + '" data-i="' + i + '" data-toggle="modal" data-target=".kmb-modal">' + modules[i].title + '</a></li>');
	}

	// Modal window variables

	var $kmbModal = $('.kmb-modal'),
		$kmbModalTitle = $kmbModal.find('.modal-title'),
		$kmbModalContent = $kmbModal.find('.modal-body'),
		$kmbModalForm = $kmbModal.find('form'),
		$kmbModalFormBody = $kmbModal.find('.append-here'),
		$kmbModalFormContentHelper = $kmbModal.find('.fkmbcontent');

	$('#insert-module').find('ul a').click(function(){
		newModule = true;
		$oldModule = $(this);
		createModalWindow();
	});

	// This functions saves the contents of the modal window and either inserts a new element or saves the old one...

	$kmbModal.find('.save').click(function(){

		var $form = $kmbModal.find('form');

		var mDom = '<div class="kmb-item uninit" data-type="' + $form.data('type') + '" data-i="' + $form.data('i') + '"',
			tempContent = '';

		$form.find('.form-control').each(function(){

			if ( $form.data('type') == 'text' && $(this).attr('id') == 'kmbcontent' ) {

				var htmlArea = $('.form-control.textarea_html.wp-editor-area#kmbcontent'),
					content = '';

				if ( htmlArea.length && htmlArea.is(':visible') ) {
					content = htmlArea.val();
				} else {
					content = window.tinyMCE.activeEditor.getContent();
				}

				tempContent = '<textarea class="">' + content + '</textarea>';

			} else {
				mDom += ' data-' + $(this).attr('id') + '="' + $(this).val() + '"';
			}

		});

		mDom += '>' + tempContent + '</div>';

		if ( newModule ) {
			mDom = $(mDom);
			$container.append( mDom ).packery( 'appended', mDom );
		} else {
			$oldModule.replaceWith( mDom );
		}

		initModule($container.find('.uninit'));
		$container.packery('reloadItems');
		$container.packery();

		initDraggable();
		rebuildMeta();

	});

    /* -------------------------------
    -----   Functions  -----
    ---------------------------------*/

    // This function creates the modal window when required

	function createModalWindow() {

		var options = null;

		$kmbModalTitle.html( ( newModule ? 'Insert' : 'Edit' ) + ' <span>' + $oldModule.data('type') + '</span> Module');

		var temp = $.grep(modules, function(n, i){
			return n['type'] == $oldModule.data('type');
		});
		options = temp[0].options;

		// Create options form

		$kmbModalForm.data({
			'type': $oldModule.data('type'),
			'i':  $oldModule.data('i')
		});

		var oDom = '';

		for ( var i = 0; i < options.length; i++ ) {

			if ( options[i].type != 'textarea' ) {

				// Create a custom form group for all the options except the textarea

				oDom += '<div class="form-group">';
				oDom += '<label for="' + options[i].id + '">' + options[i].title + '</label>';

				var std = '';

				if ( newModule ) {
					std = options[i].std;
				} else {
					std = $oldModule.data( options[i].id );
				}

				if ( std == undefined || std == null ) {
					std = '';
				}

				switch ( options[i].type ) {

					// These are basic option types

					case 'text':
						oDom += '<input class="form-control" id="' + options[i].id + '" type="text" value="' + std + '" />';
						break;

					case 'select':
						oDom += '<select id="' + options[i].id + '" class="form-control">';
						for ( var j = 0; j < options[i].choices.length; j++ ) {
							oDom += '<option id="' + options[i].id + '" value="' + options[i].choices[j].value + '"' + ( std == options[i].choices[j].value ? ' selected' : '' ) + '>' + options[i].choices[j].label + '</option>';
						}
						oDom += '</select>';
						break;

					case 'colorpicker':
						oDom += '<div class="input-group cp"><input id="' + options[i].id + '" class="form-control" type="text" value="' + std + '" /><span class="input-group-addon"><i></i></span></div>';
						break;

					case 'upload':
						oDom += '<div class="input-group"><input id="' + options[i].id + '" class="form-control" type="text" value="' + std + '"><span class="input-group-addon"><a href="#" class="image-add" title="Insert Image"><span class="glyphicon glyphicon-upload"></span></a></span></div>';
						break;

					case 'gallery':
						oDom += '<div class="input-group gallery-add"><input id="' + options[i].id + '" class="form-control lb-gallery-value" type="hidden" value="' + std + '"><div class="btn-groups"><a href="#" class="btn btn-success btn-sm lb-gallery-edit">Create gallery</a></div></div>';
						break;

				}

				if ( options[i].description != '' ) {
					oDom += '<p class="help-block">' + options[i].description + '</p>';
				}

				oDom += '</div>';

			} else {

				// Init custom textarea

				if ( window.tinyMCE ) {

					$('.kmb-custom-tinymce').css('display', 'block');

					var htmlArea = $('.form-control.textarea_html.wp-editor-area#kmbcontent');

					if ( htmlArea.length > 0 && htmlArea.css('display') != 'none' ) {

						htmlArea.val($oldModule.find('textarea').val());

					} else {

						if ( $oldModule.find('textarea').val() == undefined || $oldModule.find('textarea').val() == '' ) {

	                    	window.tinyMCE.execCommand('mceSetContent', false, '');

						} else {

	                    	window.tinyMCE.execCommand('mceSetContent', false, $oldModule.find('textarea').val());
	                    }

	                }

					$kmbModalFormContentHelper.text(options[i].description);

				}

			}

		}

		if ( $oldModule.data('type') != 'text' ) {
			$('.kmb-custom-tinymce').css('display', 'none');
		}

		$kmbModalFormBody.html(oDom);

		if ( $oldModule.data('type') != 'image' ) {
			$kmbModalFormBody.find('#height').children('option:last-child').remove();
		}

		if ( $kmbModalContent.find('.cp').length > 0 )
			$kmbModalContent.find('.cp').colorpicker();
		if ( $kmbModalContent.find('.image-add').length > 0 )
			$kmbModalContent.find('.image-add').each(function(){$(this).imageUploader()});
		if ( $kmbModalContent.find('.gallery-add').length > 0 )
    		$kmbModalContent.find('.gallery-add').galleryCreator();

		if ( $oldModule.data('type') == 'nav' ) {
			$kmbModalFormBody.css('display', 'none');
			$kmbModalFormBody.find('#width').val('2');
			$kmbModalFormBody.find('#height').val('1');
		} else if ( $oldModule.data('type') == 'latest' || $oldModule.data('type') == 'separator' ) {
			$kmbModalFormBody.find('#width').val('4');
			$kmbModalFormBody.find('#height').val('1');
			$kmbModalFormBody.find('.form-group:nth-child(1), .form-group:nth-child(2)').css('display', 'none');
		} else {
			$kmbModalFormBody.css('display', 'block');
		}
	
	}

	// This functions rebuild the serialized array (page content by page builder) on each change

	function rebuildMeta(){

		var $itemElems = $($container.packery('getItemElements')),
			kmbMeta = Array(),
			i = 0;

		$itemElems.each(function(){

			var tempObject = {};

			// Get options

			$.each( $(this).data(), function( key, value ) {
				if( key != 'uiDraggable' ) {
					tempObject[key] = value;
				}
			});

			if ( $(this).data('type') == 'text' ) {
				tempObject.kmbcontent = $(this).find('textarea').val();
			} else {
				tempObject.kmbcontent = '';
			}

			// Update array

			kmbMeta.push(tempObject);

		});

		$kmbMeta.val(JSON.stringify(kmbMeta));

	}

	// Safely parsing JSON arrays

	function safeParse( str ) {

		var js = null;

		try {
			js = JSON.parse(str);
		} catch ( e ) {
			js = false;
		}

		return js;

	}

	// Save templates

	var $templates = $('#insert-template').find('ul');

	$('#save-template').click(function(e){

		var title = prompt('Please enter a title for this template');
		if ( title != null && title != '' ) {

			jQuery.post(
				bkdOptions.ajaxurl,
				{
					action: 'kmb-save-template',
					title: title,
					meta: $kmbMeta.val()
				}, function() {

					alert('The template was created! You need to refresh the page in order to see it in the templates list.');

				}
			);

		}

		e.preventDefault();

	});

	// Insert templates

	$templates.find('a.add').click(function(e){

		var go = confirm('All the current content will be erased when you insert a template!'),
			id = $(this).data('id');

		if ( go == true ) {

			$container.html('').css('height', 300).addClass('loading')

			jQuery.post(
				bkdOptions.ajaxurl,
				{
					action: 'kmb-insert-template',
					id: id
				}, function(r) {

					$kmbMeta.val(r);

					if ( $kmbMeta.val() != '' ) {

						var kmbMetaJson = safeParse($kmbMeta.val()),
							initDom = '',
							tempContent = '';

						for ( var i = 0; i < kmbMetaJson.length; i++ ) {

							initDom += '<div class="kmb-item uninit"';
							tempContent = '';

							$.each( kmbMetaJson[i], function( key, value ) {

								if ( key == 'kmbcontent' && kmbMetaJson[i].type == 'text' ) {
									tempContent = '<textarea style="width:100px;height:100px;">' + value + '</textarea>';
								} else {
									initDom += ' data-' + key + '="' + value + '"';
								}

							});

							initDom += '>' + tempContent + '</div>';

						}

						$container.html( initDom );
						
						$('.kmb-item').each(function(){
							initModule($(this));
						});

						$container.removeClass('loading').packery();

						
		$container.packery('reloadItems');
		$container.packery();

						initDraggable();

					}

				}
			);

		} 

		e.preventDefault();

	});

	// Remove templates

	$templates.find('a.delete').click(function(e){
		
		var go = confirm('Are you sure you want to delete this template?'),
			id = $(this).data('id'),
			$template = $(this).parent();

		if ( go == true ) {

			jQuery.post(
				bkdOptions.ajaxurl,
				{
					action: 'kmb-remove-template',
					id: id
				}, function(){
					$template.remove();
				}
			);

		}

		e.preventDefault();


	});

});