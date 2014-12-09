 (function($){
    "use strict";

    $.imgupload = $.imgupload || {};
    
    $(document).ready(function () {
         $.imgupload();
    });
$.imgupload = function(){
        // When the user clicks on the Add/Edit gallery button, we need to display the gallery editing
        $('body').on({
             click: function(event){
                var current_imgupload = $(this).closest('.kad_img_upload_widget');

                // Make sure the media gallery API exists
                if ( typeof wp === 'undefined' || ! wp.media ) {
                    return;
                }
                event.preventDefault();

                var frame;
                // Activate the media editor
                var $$ = $(this);

                // If the media frame already exists, reopen it.
                if ( frame ) {
                        frame.open();
                        return;
                    }

                    // Create the media frame.
                    frame = wp.media({
                        multiple: false,
                        library: {type: 'image'}
                    });

                        // When an image is selected, run a callback.
                frame.on( 'select', function() {

                    // Grab the selected attachment.
                    var attachment = frame.state().get('selection').first();
                    frame.close();

                    current_imgupload.find('.kad_custom_media_url').val(attachment.attributes.url);
                    current_imgupload.find('.kad_custom_media_id').val(attachment.attributes.id);
                    var thumbSrc = attachment.attributes.url;
                    if (typeof attachment.attributes.sizes !== 'undefined' && typeof attachment.attributes.sizes.thumbnail !== 'undefined') {
                        thumbSrc = attachment.attributes.sizes.thumbnail.url;
                    } else {
                        thumbSrc = attachment.attributes.icon;
                    }
                    current_imgupload.find('.kad_custom_media_image').attr('src', thumbSrc);
                });

                // Finally, open the modal.
                frame.open();
            }

        }, '.kad_custom_media_upload');
     };
})(jQuery);