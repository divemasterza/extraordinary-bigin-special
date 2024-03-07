<?php
// This function will create the 'Specials' custom post type
function hs_create_specials_post_type()
{
    $labels = array(
        'name' => __('Exclusive Offers'),
        'singular_name' => __('Exclusive Offer')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'exclusive-offers'),
    );

    register_post_type('exclusive-offers', $args);
}
add_action('init', 'hs_create_specials_post_type');
