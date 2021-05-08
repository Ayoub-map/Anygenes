<?php

function anygenes_supports()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
    // register_nav_menu('header', 'En tête de menu ');

}

function anygenes_register_assets()
{
    wp_register_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css');
    wp_register_style('flag-icon', get_template_directory_uri() . '/assets/css/flag-icon.css');
    wp_register_style('jquery','//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css');
    wp_deregister_script('jquery');
    wp_deregister_script('jquery-ui');
    wp_register_script('jquery', '//code.jquery.com/jquery-1.12.4.js', [], false, true);
    wp_register_script('jquery-ui', '//code.jquery.com/ui/1.12.1/jquery-ui.js', [], true, false);
    wp_register_script('popper', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', [], false, true);
    wp_register_script('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', ['popper'], false, true);
    

    wp_enqueue_style('bootstrap');
    wp_enqueue_style('flag-icon');
    wp_enqueue_style('jquery');
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui');
    wp_enqueue_script('bootstrap');
    wp_enqueue_script('owl-carousel-js', get_template_directory_uri() . '/assets/js/owl.carousel.min.js');
    wp_enqueue_style('strangerwp-parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('strangerwp-child-style', get_stylesheet_directory_uri() . '/style.css');
    wp_enqueue_style('owl.carousel-css', get_template_directory_uri() . '/assets/css/owl.carousel.css');
}

// function anygenes_menu_class($classes)
// {
//     $classes[] = 'nav-item';
//     return $classes;
// }

// function anygenes_menu_link_attributes($attrs)
// {
//     $attrs['class'] = 'nav-link';
//     return $attrs;
// }


function register_menus()
{
    register_nav_menus(
        array(
            'primary' => __('Primary Menu'),
            'secondary' => __( 'Secondary Menu')
        )
    );
}

function theme_prefix_setup()
{
    add_theme_support('custom-logo');
}

function themename_custom_logo_setup()
{
    $defaults = array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array('site-title', 'site-description'),
    );
    add_theme_support('custom-logo', $defaults);
}
add_action('after_setup_theme', 'themename_custom_logo_setup');

add_action('after_setup_theme', 'anygenes_supports');
add_action('wp_enqueue_scripts', 'anygenes_register_assets');
// add_filter('nav_menu_css_class', 'anygenes_menu_class');
// add_filter('nav_menu_link_attributes', 'anygenes_menu_link_attributes');
add_action('after_setup_theme', 'register_menus');
require_once  get_template_directory() . '/class-wp-bootstrap-navwalker.php';
add_action('after_setup_theme', 'theme_prefix_setup');

/**
 * Add private/draft/future/pending pages to parent dropdown.
 */
function wps_dropdown_pages_args_add_parents($dropdown_args, $post = NULL)
{
    $dropdown_args['post_status'] = array('publish', 'private',);
    return $dropdown_args;
}

add_filter('page_attributes_dropdown_pages_args', 'wps_dropdown_pages_args_add_parents', 10, 2);
add_filter('quick_edit_dropdown_pages_args', 'wps_dropdown_pages_args_add_parents');

