jQuery(window).load(function(){
    $ = jQuery.noConflict();

   // var firstTime = true;

    ot_gallery = {
      
    frame: function (elm) {

      this._frame = wp.media({
        id:         'lb-gallery-frame'
      , frame:      'post'
      , state:      'gallery-edit'
      , title:      wp.media.view.l10n.editGalleryTitle
      , editing:    true
      , multiple:   true
      , selection:  ot_gallery.selection
      })
      
      this._frame.on('update', function () {

        var controller = ot_gallery._frame.states.get('gallery-edit')
          , library = controller.get('library')
          , ids = library.pluck('id')
          , parent = $(elm).parents('.input-group')
          , input = parent.children('.lb-gallery-value')
          , shortcode = wp.media.gallery.shortcode( ot_gallery.selection ).string().replace(/\"/g,"'")
        
        input.attr('value', ids)
                        
        if ( parent.children('.ot-gallery-list').length <= 0 )
          input.after('<ul class="ot-gallery-list" />')

        $.ajax({
          type: 'POST',
          url: ajaxurl,
          dataType: 'html',
          data: {
            action: 'gallery_update'
          , ids: ids
          },
          success: function(res) {
            parent.children('.ot-gallery-list').html(res)
            if ( input.hasClass('lb-gallery-shortcode') ) 
              input.val(shortcode)
            if ( $(elm).parent().children('.lb-gallery-delete').length <= 0 ) {
              $(elm).parent().append('<a href="#" class="btn btn-success btn-sm lb-gallery-delete">' + option_tree.delete + '</a>')
            }
            $(elm).text(option_tree.edit)
            OT_UI.init_conditions()
          }
        })
      })
        
      return this._frame
      
    }
      
  , select: function (elm) {

      var input = $(elm).parents('.input-group').children('.lb-gallery-value')
        , ids = input.attr('value')
        , _shortcode = input.hasClass('lb-gallery-shortcode') ? ids : '[gallery ids=\'' + ids + '\]'
        , shortcode = wp.shortcode.next('gallery', ( ids ? _shortcode : wp.media.view.settings.ot_gallery.shortcode ) )
        , defaultPostId = wp.media.gallery.defaults.id
        , attachments
        , selection
        
      // Bail if we didn't match the shortcode or all of the content.
      if ( ! shortcode )
        return
      
      // Ignore the rest of the match object.
      shortcode = shortcode.shortcode
      
      if ( _.isUndefined( shortcode.get('id') ) && ! _.isUndefined( defaultPostId ) )
        shortcode.set( 'id', defaultPostId )
      
      if ( _.isUndefined( shortcode.get('ids') ) && ! input.hasClass('lb-gallery-shortcode') && ids )
        shortcode.set( 'ids', ids )
      
      if ( _.isUndefined( shortcode.get('ids') ) )
        shortcode.set( 'ids', '0' )
      
      attachments = wp.media.gallery.attachments( shortcode )

      selection = new wp.media.model.Selection( attachments.models, {
        props:    attachments.props.toJSON()
      , multiple: true
      })
      
      selection.gallery = attachments.gallery
    
      // Fetch the query's attachments, and then break ties from the query to allow for sorting.
      selection.more().done( function () {
        selection.props.set({ query: false })
        selection.unmirror()
        selection.props.unset('orderby')
      })

      return selection;
      
    }
    
  , selection: null

  , open: function (elm) {

      
      ot_gallery.selection = this.select(elm);
        setTimeout(function(){
          ot_gallery.frame(elm).open()
        }, 500);
      
    }
  
  , remove: function (elm) {
      
      if ( confirm( option_tree.confirm ) ) {
        
        $(elm).parents('.input-group').children('.lb-gallery-value').attr('value', '')
        $(elm).parents('.input-group').children('.ot-gallery-list').remove()
        $(elm).next('.lb-gallery-edit').text( option_tree.create )
        $(elm).remove()
        OT_UI.init_conditions()
        
      }

    }
  
  }

    $.fn.galleryCreator = function(){

    	$(this).find('.lb-gallery-delete').on('click.ot_gallery.data-api', function(e){
			    e.preventDefault()
			    ot_gallery.remove($(this))
    	});

    	$(this).find('.lb-gallery-edit').on('click.ot_gallery.data-api', function(e){
	    e.preventDefault()
	    ot_gallery.open($(this))
	  });

      if ( $(this).find('.lb-gallery-value').val() != '' ) {

        var $elm = $(this).find('.lb-gallery-edit');

        ids = $(this).find('.lb-gallery-value').val();
        var $this = $(this);

        $.ajax({
          type: 'POST',
          url: ajaxurl,
          dataType: 'html',
          data: {
            action: 'gallery_update'
          , ids: ids.split(',')
          },
          success: function(res) {
        if ( $this.children('.ot-gallery-list').length <= 0 )
          $this.find('.btn-groups').after('<ul class="ot-gallery-list" />')
            $this.children('.ot-gallery-list').html(res);

           // if ( $input.hasClass('lb-gallery-shortcode') ) 
             // $input.val(shortcode)
            if ( $elm.parent().children('.lb-gallery-delete').length <= 0 ) {
              $elm.parent().append('<a href="#" class="btn btn-success btn-sm lb-gallery-delete">' + option_tree.delete + '</a>')
            }
            $elm.text(option_tree.edit)
            OT_UI.init_conditions()
          }
        })

      }

    }




});