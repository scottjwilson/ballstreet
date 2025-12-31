<?php
/**
 * Add preconnect hints for Google Fonts
 */

 /**
 * Register navigation menus
 */
function ball_street_register_menus() {
    register_nav_menus(array(
        'menuTop' => 'Top Navigation Menu',
    ));
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
}
add_action('after_setup_theme', 'ball_street_register_menus');
function ball_street_font_preconnect() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
add_action('wp_head', 'ball_street_font_preconnect', 1);


/**
 * Enqueue styles and scripts
 */
function ball_street_enqueue_assets() {
    // Enqueue Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap', array(), null);
    
    // Main stylesheet (required by WordPress)
    wp_enqueue_style('ball-street-style', get_stylesheet_uri());
    
    // CSS Variables (depends on Google Fonts to ensure font loads first)
    wp_enqueue_style('variables', get_template_directory_uri() . '/css/variables.css', array('google-fonts'), '1.0.0');
    
    // Base styles
    wp_enqueue_style('base', get_template_directory_uri() . '/css/base.css', array('variables'), '1.0.0');
    
    // Layout styles
    wp_enqueue_style('layout', get_template_directory_uri() . '/css/layout.css', array('base'), '1.0.0');
    
    // Component styles
    wp_enqueue_style('components', get_template_directory_uri() . '/css/components.css', array('base'), '1.0.0');

    // Header styles
    wp_enqueue_style('header', get_template_directory_uri() . '/css/header.css', array('base'), '1.0.0');
    
    // Footer styles
    wp_enqueue_style('footer', get_template_directory_uri() . '/css/footer.css', array('base'), '1.0.0');
    
    // Template sections
    wp_enqueue_style('template-sections', get_template_directory_uri() . '/css/template-sections.css', array('components'), '1.0.0');
    
    // Page-specific styles
    if (is_front_page()) {
        wp_enqueue_style('front-page', get_template_directory_uri() . '/css/front-page.css', array('template-sections'), '1.0.0');
    }
    
    if (is_single()) {
        wp_enqueue_style('single', get_template_directory_uri() . '/css/single.css', array('template-sections'), '1.0.0');
    }
    
    if (is_archive() || is_category() || is_tag()) {
        wp_enqueue_style('archive', get_template_directory_uri() . '/css/archive.css', array('template-sections'), '1.0.0');
    }

    if (is_home() || is_archive()) {
        wp_enqueue_style(
            'home',
            get_template_directory_uri() . '/css/home.css',
            array('template-sections'),
            '1.0.0'
        );
    }

    if (get_post_type() === 'athlete') {
        wp_enqueue_style(
            'single-athlete',
            get_template_directory_uri() . '/css/single-athlete.css',
            array('template-sections'),
            '1.0.0'
        );
    }
    
    // Main JavaScript
    wp_enqueue_script('ball-street-main', get_template_directory_uri() . '/js/main.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'ball_street_enqueue_assets');

// Include template functions
require_once get_template_directory() . '/inc/template-sections.php';

function wpdocs_custom_excerpt_length( $length ) {
	return 15;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );


