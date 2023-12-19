<?php
// This function will create the 'Specials' custom post type
function hs_create_specials_post_type()
{
    $labels = array(
        'name' => __('Specials'),
        'singular_name' => __('Special')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'specials'),
    );

    register_post_type('specials', $args);
}
add_action('init', 'hs_create_specials_post_type');
