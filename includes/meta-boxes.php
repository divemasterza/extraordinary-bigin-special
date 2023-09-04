<?php // This function will create the meta box
function hs_add_specials_meta_box()
{
    add_meta_box(
        'specials_meta_box',
        'Specials Information',
        'hs_display_specials_meta_box',
        'specials',
        'normal',
        'high'
    );
    add_meta_box(
        'hs_specials_images',
        'Image Gallery',
        'hs_specials_images_callback',
        'specials'
    );
}
add_action('add_meta_boxes', 'hs_add_specials_meta_box');

// This function will display the meta box
function hs_display_specials_meta_box($special)
{
    // Add a nonce field so we can check for it later
    wp_nonce_field('hs_specials_nonce', 'hs_specials_nonce_field');

    // Use get_post_meta to retrieve an existing value from the database
    $validity_date = get_post_meta($special->ID, '_validity_date', true);
    $price = get_post_meta($special->ID, '_price', true);
    $packages = get_post_meta($special->ID, '_packages', true);

    // Display the form, using the current value
?>
    <label for="validity_date">Validity Date</label>
    <input type="date" id="validity_date" name="validity_date" value="<?php echo esc_attr($validity_date); ?>" size="25" />

    <label for="price">Price</label>
    <input type="number" id="price" name="price" value="<?php echo esc_attr($price); ?>" size="25" />

    <label for="packages">Packages</label>
    <textarea id="packages" name="packages" rows="4" cols="50"><?php echo esc_attr($packages); ?></textarea>
<?php
}

// This function will save the meta box
function hs_save_specials_meta_box_data($post_id)
{
    // Check if our nonce is set
    if (!isset($_POST['hs_specials_nonce_field'])) {
        return;
    }

    // Verify that the nonce is valid
    if (!wp_verify_nonce($_POST['hs_specials_nonce_field'], 'hs_specials_nonce')) {
        return;
    }

    // Check the user's permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Make sure that it is set
    if (!isset($_POST['validity_date'])) {
        return;
    }
    if (!isset($_POST['price'])) {
        return;
    }
    if (!isset($_POST['packages'])) {
        return;
    }

    // Sanitize user input
    $validity_date = sanitize_text_field($_POST['validity_date']);
    $price = sanitize_text_field($_POST['price']);
    $packages = sanitize_text_field($_POST['packages']);

    // Update the meta field in the database
    update_post_meta($post_id, '_validity_date', $validity_date);
    update_post_meta($post_id, '_price', $price);
    update_post_meta($post_id, '_packages', $packages);
    update_post_meta($post_id, '_image_ids', $_POST['image_ids']);
}
add_action('save_post', 'hs_save_specials_meta_box_data');

function hs_specials_images_callback($post)
{
    wp_nonce_field(basename(__FILE__), 'hs_specials_images_nonce');

    $image_ids = get_post_meta($post->ID, '_image_ids', true);
    $image_ids = explode(',', $image_ids);

    echo '<div id="image-gallery">';
    foreach ($image_ids as $image_id) {
        $image_src = wp_get_attachment_image_src($image_id, 'thumbnail');
        echo '<div class="gallery-image"><img src="' . $image_src[0] . '"><button class="remove-gallery-image" data-id="' . $image_id . '">Remove</button></div>';
    }
    echo '</div>';

    echo '<input type="hidden" id="image-ids" name="image_ids" value="' . implode(',', $image_ids) . '">';
    echo '<button type="button" id="add-gallery-image">Add Image</button>';
}

// Enqueue the admin scripts
function hs_admin_scripts()
{
    wp_enqueue_media();
    wp_enqueue_script('hs_admin_script', plugins_url('../js/specials.js', __FILE__), array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'hs_admin_scripts');
