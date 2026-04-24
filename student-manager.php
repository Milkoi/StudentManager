<?php
/*
Plugin Name: Student Manager
Description: Plugin quản lý sinh viên
Version: 1.0
Author: Your Name
*/

if (!defined('ABSPATH')) exit;

// Include file
require_once plugin_dir_path(__FILE__) . 'includes/cpt.php';
require_once plugin_dir_path(__FILE__) . 'includes/metabox.php';
require_once plugin_dir_path(__FILE__) . 'includes/shortcode.php';

// Load CSS
function sm_load_assets() {
    wp_enqueue_style('sm-style', plugin_dir_url(__FILE__) . 'assets/style.css');
}
add_action('wp_enqueue_scripts', 'sm_load_assets');