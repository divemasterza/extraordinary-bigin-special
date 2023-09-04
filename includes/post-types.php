<?php
// This function will create the 'Specials' custom post type
function hs_create_specials_post_type() {
    register_post_type('specials',
        array(
            'labels' => array(
                'name' => __('Specials'),
                'singular_name' => __('Special')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
            'rewrite' => array('slug' => 'specials'),
        )
    );
}
add_action('init', 'hs_create_specials_post_type');
