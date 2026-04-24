<?php

function sm_register_cpt() {
    register_post_type('sinh_vien', array(
        'labels' => array(
            'name' => 'Sinh viên',
            'singular_name' => 'Sinh viên'
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-id',
        'supports' => array('title', 'editor')
    ));
}
add_action('init', 'sm_register_cpt');