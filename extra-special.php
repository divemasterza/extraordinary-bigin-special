<?php
/*
Plugin Name: Extraordinary Specials
Plugin URI: https://bigambitions.co.za/
Description: This is a custom plugin that creates a 'Specials' post type with custom fields.
Version: 1.2.1
Author: Steph & Ash
Author URI: https://bigambitions.co.za/
*/

// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
    echo 'Hi there! I\'m just a plugin, not much I can do when called directly.';
    exit;
}

// Define plugin directory for easy includes
define('ES_PLUGIN_DIR', plugin_dir_path(__FILE__));

require_once(ES_PLUGIN_DIR . 'includes/post-types.php');
require_once(ES_PLUGIN_DIR . 'includes/meta-boxes.php');

// Enqueue plugin style file
function es_enqueue_styles()
{
    wp_enqueue_style('es_styles', plugin_dir_url(__FILE__) . 'styles.css');
    wp_enqueue_script('lightbox', plugin_dir_url(__FILE__) . '/vendors/lightbox2/js/lightbox.js', array('jquery'), '2.11.4', true);
    wp_enqueue_script('specials', plugin_dir_url(__FILE__) . '/js/admin-specials.js', array('jquery'), '1.0.0', true);
    wp_enqueue_style('lightbox', plugin_dir_url(__FILE__) . '/vendors/lightbox2/css/lightbox.css');

    $accent_color = get_option('es_accent_color', '#f04e23');

    $custom_css = "
    .price-line {
        color: {$accent_color};
        font-size: 18px;
        font-weight: bold;
        background-color: #fff;
        padding: 10px;
        margin-top: 20px;
    }";

    wp_add_inline_style('es_styles', $custom_css);
}
add_action('wp_enqueue_scripts', 'es_enqueue_styles');


function enqueue_custom_scripts()
{
    $property_name = get_option('es_property_name');
    $data_array = array('property_name' => $property_name);

    wp_enqueue_script('es-custom-script', plugin_dir_url(__FILE__) . '/js/bigin.js', array('jquery'), '', true);
    wp_localize_script('es-custom-script', 'es_php_vars', $data_array);
}

add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');



function enqueue_slick_assets()
{
    if (!is_admin()) {
        wp_enqueue_style('swiper-css', 'https://unpkg.com/swiper/swiper-bundle.min.css');
        wp_enqueue_script('swiper-js', 'https://unpkg.com/swiper/swiper-bundle.min.js', array(), null, true);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_slick_assets');
function enqueue_swiper_init_script()
{
    wp_enqueue_script('swiper-init', plugin_dir_url(__FILE__) . '/js/swiper-init.js', array('swiper-js'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_swiper_init_script');


// This function will return the path to the 'specials' templates in the plugin
function es_get_template($template)
{
    if (get_post_type() === 'exclusive-offers') {
        if (is_archive()) {
            // Checks if the file exists in the theme first
            if ($theme_file = locate_template(array('archive-specials.php'))) {
                $template = $theme_file;
            } else {
                // Use the plugin file
                $template = ES_PLUGIN_DIR . 'templates/archive-specials.php';
            }
        } else if (is_single()) {
            if ($theme_file = locate_template(array('single-specials.php'))) {
                $template = $theme_file;
            } else {
                $template = ES_PLUGIN_DIR . 'templates/single-specials.php';
            }
        }
    }
    return $template;
}
add_filter('template_include', 'es_get_template');

// This function checks if a special's validity date is within the next n days, where n is the value of 'es_ending_soon_days'
function es_check_expiring_specials()
{
    // WP Query to get all 'specials' posts
    $args = array(
        'post_type' => 'exclusive-offers',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    );
    $specials_query = new WP_Query($args);

    // Get the number of days from the settings, or default to 7 if it's not set
    $ending_soon_days = get_option('es_ending_soon_days', 7);

    // The Loop
    if ($specials_query->have_posts()) {
        while ($specials_query->have_posts()) {
            $specials_query->the_post();

            // Get the validity date of the special and convert it to a DateTime object
            $validity_date = get_post_meta(get_the_ID(), '_validity_date', true);
            $validity_date = DateTime::createFromFormat('Y-m-d', $validity_date);

            // Get the date n days from now
            $date_in_future = new DateTime('now');
            $date_in_future->modify('+' . $ending_soon_days . ' day');

            // If the validity date is earlier than the date n days from now, set '_ending_soon' to 'true'
            if ($validity_date < $date_in_future) {
                update_post_meta(get_the_ID(), '_ending_soon', 'true');
            } else {
                delete_post_meta(get_the_ID(), '_ending_soon');
            }
        }
    }
    // Restore original Post Data
    wp_reset_postdata();
}
add_action('es_daily_event', 'es_check_expiring_specials');

// This function will schedule our event if it's not already scheduled
function es_schedule_ending_soon_check()
{
    if (!wp_next_scheduled('es_daily_event')) {
        wp_schedule_event(time(), 'daily', 'es_daily_event');
    }
}
add_action('wp', 'es_schedule_ending_soon_check');

// This function will create a settings page under the 'Settings' menu
function es_create_settings_page()
{
    add_options_page(
        'Extraordinary Specials Settings',
        'Extraordinary Specials',
        'manage_options',
        'extraordinary-specials',
        'es_render_settings_page'
    );
}
add_action('admin_menu', 'es_create_settings_page');

// This function will render the settings page
function es_render_settings_page()
{
?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('extraordinary-specials');
            do_settings_sections('extraordinary-specials');
            submit_button('Save Settings');
            ?>
        </form>
    </div>
<?php
}

// This function will register our settings
function es_register_settings()
{
    register_setting('extraordinary-specials', 'es_ending_soon_days', 'intval');
    add_settings_section(
        'es_ending_soon_section',
        'Ending Soon Settings',
        'es_render_ending_soon_section',
        'extraordinary-specials'
    );

    add_settings_field(
        'es_ending_soon_days',
        'Number of days before special ends to start showing "Ending Soon" message',
        'es_render_ending_soon_days_field',
        'extraordinary-specials',
        'es_ending_soon_section'
    );

    register_setting('extraordinary-specials', 'es_archive_title_rads');
    add_settings_field(
        'es_archive_title_rads',
        'Hide / Show Archive Title',
        'es_render_archive_title_rad_field',
        'extraordinary-specials',
        'es_ending_soon_section'
    );

    register_setting('extraordinary-specials', 'es_accent_color', 'sanitize_hex_color');
    add_settings_field(
        'es_accent_color',
        'Accent color for the Call To Action and other elements',
        'es_render_accent_color_field',
        'extraordinary-specials',
        'es_ending_soon_section'
    );

    register_setting('extraordinary-specials', 'es_form_title');
    add_settings_field(
        'es_form_title',
        'Form Title',
        'es_render_form_title_field',
        'extraordinary-specials',
        'es_ending_soon_section'
    );
    
    register_setting('extraordinary-specials', 'es_children_rads');
    add_settings_field(
        'es_children_rads',
        'Hide / Show Children Fields',
        'es_render_children_rad_field',
        'extraordinary-specials',
        'es_ending_soon_section'
    );

    register_setting('extraordinary-specials', 'es_dynamic_placeholders');
    add_settings_field(
        'es_placeholders',
        'Enable Dynamic Placeholders',
        'es_render_placeholders_rad_field',
        'extraordinary-specials',
        'es_ending_soon_section'
    );

    register_setting('extraordinary-specials', 'es_form_code');
    add_settings_field(
        'es_form_code',
        'Bigin Code for the Form',
        'es_render_form_code_field',
        'extraordinary-specials',
        'es_ending_soon_section'
    );
    // Register the new setting
    register_setting('extraordinary-specials', 'es_property_name');
    add_settings_field(
        'es_property_name',
        'Property Name for Bigin Form',
        'es_render_property_name_field',
        'extraordinary-specials',
        'es_ending_soon_section'
    );

    // Render the setting input field
    function es_render_property_name_field()
    {
        $property_name = get_option('es_property_name', '');
        echo '<input type="text" name="es_property_name" value="' . esc_attr($property_name) . '" class="regular-text" required/>';
    }
}
add_action('admin_init', 'es_register_settings');

function es_render_ending_soon_section()
{
    echo '<p>Set the number of days before a special ends when the "Ending Soon" message should start appearing.</p>';
}

function es_render_ending_soon_days_field()
{
    $ending_soon_days = get_option('es_ending_soon_days', 7);
    echo '<input type="number" min="0" name="es_ending_soon_days" value="' . $ending_soon_days . '" />';
}

function es_render_form_title_field()
{
    $cform_title = get_option('es_form_title', '');
    echo '<input type="text" name="es_form_title" value="' . esc_attr($cform_title) . '" class="text-field" />';
}

function es_render_archive_title_rad_field()
{
    $archive_title_visbility = get_option('es_archive_title_rads', 'show');

    echo '<input type="radio" name="es_archive_title_rads" value="show" ' . checked( 'show', $archive_title_visbility, false ) . '/> Display Title &nbsp';
    echo '<input type="radio" name="es_archive_title_rads" value="hide" ' . checked( 'hide', $archive_title_visbility, false ) . '/> Hide Title';

    return $archive_title_visbility;
}

function es_render_children_rad_field()
{
    $children_visbility = get_option('es_children_rads', 'show');

    echo '<input type="radio" name="es_children_rads" value="show" ' . checked( 'show', $children_visbility, false ) . '/> Display Children &nbsp';
    echo '<input type="radio" name="es_children_rads" value="hide" ' . checked( 'hide', $children_visbility, false ) . '/> Hide Children';
}

function es_render_placeholders_rad_field()
{
    $placeholders_status = get_option('es_dynamic_placeholders', 'show');

    echo '<input type="radio" name="es_dynamic_placeholders" value="show" ' . checked( 'show', $placeholders_status, false ) . '/> Enable &nbsp';
    echo '<input type="radio" name="es_dynamic_placeholders" value="hide" ' . checked( 'hide', $placeholders_status, false ) . '/> Disable';
}

function es_render_accent_color_field()
{
    $accent_color = get_option('es_accent_color', '#f04e23');
    echo '<input type="text" name="es_accent_color" value="' . esc_attr($accent_color) . '" class="color-field" />';
}


function es_render_form_code_field()
{
    $form_code = get_option('es_form_code', '');
    echo '<textarea id="form_code" name="es_form_code" rows="10" class="large-text code">' . esc_textarea($form_code) . '</textarea>';
}

function es_enqueue_code_editor($hook_suffix)
{
    if ('settings_page_extraordinary-specials' !== $hook_suffix) return;

    $settings = wp_enqueue_code_editor(array('type' => 'text/html'));
    if (false === $settings) return;

    wp_enqueue_script('wp-theme-plugin-editor');
    wp_localize_script('wp-theme-plugin-editor', 'esFormCodeL10n', array(
        'settings' => $settings,
        'l10n'     => array(
            'saveAlert' => __('The changes you made will be lost if you navigate away from this page.'),
            'saved'     => __('Your changes have been saved.'),
        ),
    ));

    wp_add_inline_script('wp-theme-plugin-editor', '
        jQuery(document).ready(function($) {
            const editor = wp.codeEditor.initialize($("#form_code"), esFormCodeL10n.settings);
        });
    ');
}
add_action('admin_enqueue_scripts', 'es_enqueue_code_editor');

function es_bigin_form_shortcode()
{
    // Get the form code from the admin settings
    $form_code = get_option('es_form_code', '');

    // Return the form code
    return $form_code;
}
add_shortcode('bigin_form', 'es_bigin_form_shortcode');