<?php
/**
 * Register navigation menus
 */
function ball_street_register_menus()
{
    register_nav_menus([
        "menuTop" => "Top Navigation Menu",
    ]);
    add_theme_support("post-thumbnails");
    add_theme_support("title-tag");
}
add_action("after_setup_theme", "ball_street_register_menus");
function ball_street_font_preconnect()
{
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' .
        "\n";
}
add_action("wp_head", "ball_street_font_preconnect", 1);
/**
 * Custom excerpt length
 */
function wpdocs_custom_excerpt_length($length)
{
    return 15;
}
add_filter("excerpt_length", "wpdocs_custom_excerpt_length", 999);
