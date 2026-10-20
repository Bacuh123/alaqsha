<?php
if (!defined('ABSPATH')) exit;
function alaqsha_theme_setup() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('custom-logo');
  register_nav_menus(array('primary' => __('Menu Utama', 'al-aqsha')));
}
add_action('after_setup_theme','alaqsha_theme_setup');
function alaqsha_assets(){ wp_enqueue_style('alaqsha-style', get_stylesheet_uri(), array(), '1.0.0'); }
add_action('wp_enqueue_scripts','alaqsha_assets');
