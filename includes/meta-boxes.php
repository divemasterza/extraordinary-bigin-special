<?php
class SpecialsMetaBox
{
    public function __construct()
    {
        add_action('add_meta_boxes', array($this, 'add'));
        add_action('save_post', array($this, 'save'));
        add_action('admin_enqueue_scripts', array($this, 'enqueueScripts'));
    }

    public function add()
    {
        add_meta_box('specials_meta_box', 'Specials Information', array($this, 'display'), 'exclusive-offers', 'normal', 'high');
        add_meta_box('hs_specials_images', 'Image Gallery', array($this, 'imagesCallback'), 'exclusive-offers');
    }

    public function display($special)
    {
        wp_nonce_field('hs_specials_nonce', 'hs_specials_nonce_field');
        $this->createField($special, 'validity_date', 'date');
        $this->createField($special, 'price', 'number');
        $this->createField($special, 'packages', 'textarea');
    }

    private function createField($special, $field, $type)
    {
        $value = get_post_meta($special->ID, "_{$field}", true);
        $label = ucfirst(str_replace('_', ' ', $field));
        echo "<label for='{$field}'>{$label}</label>";
        if ($type === 'textarea') {
            echo "<textarea id='{$field}' name='{$field}' rows='4' cols='50'>{$value}</textarea>";
        } else {
            echo "<input type='{$type}' id='{$field}' name='{$field}' value='{$value}' size='25' />";
        }
    }

    public function save($post_id)
    {
        if (!$this->userCanSave($post_id, 'hs_specials_nonce', 'hs_specials_nonce_field')) {
            return;
        }
        $this->updateField($post_id, 'validity_date');
        $this->updateField($post_id, 'price');
        $this->updateField($post_id, 'packages');
        $this->updateField($post_id, 'image_ids');
    }

    private function userCanSave($post_id, $nonceAction, $nonceField)
    {
        return isset($_POST[$nonceField]) && wp_verify_nonce($_POST[$nonceField], $nonceAction) && current_user_can('edit_post', $post_id);
    }

    private function updateField($post_id, $field)
    {
        if (isset($_POST[$field])) {
            $value = sanitize_text_field($_POST[$field]);
            update_post_meta($post_id, "_{$field}", $value);
        }
    }

    public function imagesCallback($post)
    {
        wp_nonce_field(basename(__FILE__), 'hs_specials_images_nonce');
        $image_ids = get_post_meta($post->ID, '_image_ids', true);
        $image_ids = explode(',', $image_ids);
        $this->createImageGallery($image_ids);
        echo '<input type="hidden" id="image-ids" name="image_ids" value="' . implode(',', $image_ids) . '">';
        echo '<button type="button" id="add-gallery-image">Add Image</button>';
    }

    private function createImageGallery($image_ids)
    {
        echo '<div id="image-gallery">';
        foreach ($image_ids as $image_id) {
            if (!empty($image_id)) {
                $image_src = wp_get_attachment_image_src($image_id, 'thumbnail');
                echo '<div class="gallery-image"><img src="' . $image_src[0] . '"><button class="remove-gallery-image" data-id="' . $image_id . '">Remove</button></div>';
            }
        }
        echo '</div>';
    }
    public function enqueueScripts()
    {
        wp_enqueue_media();
        wp_enqueue_script('hs_admin_script', plugins_url('../js/specials.js', __FILE__), array('jquery'), '1.0', true);
    }
}

new SpecialsMetaBox();