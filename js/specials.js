jQuery(function($) {
    var file_frame;

    // Admin side: Image addition and removal for the gallery
    $(document).on('click', '#add-gallery-image', function(event) {
        event.preventDefault();

        var image_ids = $('#image-ids').val() ? $('#image-ids').val().split(',') : [];
        if(image_ids.length >= 8) {
            alert('Max limit of 8 images reached');
            return;
        }

        file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select Images',
            button: {
                text: 'Add to gallery',
            },
            multiple: true
        });

        file_frame.on('select', function() {
            var attachments = file_frame.state().get('selection').map( 
                function( attachment ) {
                    return attachment.toJSON();
            });

            attachments.forEach(function(attachment) {
                if(image_ids.length >= 8) {
                    return;
                }

                $('#image-gallery').append('<div class="gallery-image"><img src="' + attachment.sizes.thumbnail.url + '"><button class="remove-gallery-image" data-id="' + attachment.id + '">Remove</button></div>');
                image_ids.push(attachment.id);
            });

            $('#image-ids').val(image_ids.join(','));
        });

        file_frame.open();
    });

    $(document).on('click', '.remove-gallery-image', function() {
        var image_id = $(this).data('id');
        var image_ids = $('#image-ids').val().split(',');

        $(this).parent().remove();

        var index = image_ids.indexOf(image_id.toString());
        if (index > -1) {
            image_ids.splice(index, 1);
        }
        
        $('#image-ids').val(image_ids.join(','));
    });
});
