<?php
/**
 * Register navigation menus
 */
function ball_street_theme_setup()
{
    register_nav_menus([
        "menuTop" => "Top Navigation Menu",
        "menuFooter" => "Footer Navigation Menu",
    ]);
    add_theme_support("post-thumbnails");
    add_theme_support("title-tag");
    add_theme_support("automatic-feed-links");
    add_theme_support("html5", [
        "search-form",
        "comment-form",
        "comment-list",
        "gallery",
        "caption",
        "style",
        "script",
    ]);
    add_theme_support("custom-logo", [
        "height" => 100,
        "width" => 400,
        "flex-height" => true,
        "flex-width" => true,
    ]);
}
add_action("after_setup_theme", "ball_street_theme_setup");
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

/**
 * Enqueue base styles and scripts
 */
function the_theme_enqueue_assets(): void
{
    // Google Fonts
    wp_enqueue_style(
        "google-fonts",
        "https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap",
        [],
        null,
    );

    // Main stylesheet (required by WordPress)
    wp_enqueue_style("the-theme-style", get_stylesheet_uri());

    // Check if Vite handles assets
    if (function_exists("the_theme_detect_vite_server")) {
        $vite = the_theme_detect_vite_server();
        $has_manifest = file_exists(
            get_theme_file_path("dist/.vite/manifest.json"),
        );

        if ($vite["running"] || $has_manifest) {
            return;
        }
    }

    // Fallback: enqueue CSS directly if Vite is not available
    wp_enqueue_style(
        "variables",
        get_template_directory_uri() . "/src/css/variables.css",
        ["google-fonts"],
        "1.0.0",
    );
    wp_enqueue_style(
        "base",
        get_template_directory_uri() . "/src/css/base.css",
        ["variables"],
        "1.0.0",
    );
    wp_enqueue_style(
        "layout",
        get_template_directory_uri() . "/src/css/layout.css",
        ["base"],
        "1.0.0",
    );
    wp_enqueue_style(
        "components",
        get_template_directory_uri() . "/src/css/components.css",
        ["base"],
        "1.0.0",
    );
    wp_enqueue_style(
        "header",
        get_template_directory_uri() . "/src/css/header.css",
        ["base"],
        "1.0.0",
    );
    wp_enqueue_style(
        "footer",
        get_template_directory_uri() . "/src/css/footer.css",
        ["base"],
        "1.0.0",
    );
    wp_enqueue_style(
        "template-sections",
        get_template_directory_uri() . "/src/css/template-sections.css",
        ["base"],
        "1.0.0",
    );

    // Conditional page-specific styles
    if (is_front_page()) {
        wp_enqueue_style(
            "front-page",
            get_template_directory_uri() . "/src/css/front-page.css",
            ["base"],
            "1.0.0",
        );
    }

    if (is_home()) {
        wp_enqueue_style(
            "home",
            get_template_directory_uri() . "/src/css/home.css",
            ["base"],
            "1.0.0",
        );
    }

    if (is_singular("post")) {
        wp_enqueue_style(
            "single",
            get_template_directory_uri() . "/src/css/single.css",
            ["base"],
            "1.0.0",
        );
    }

    if (is_singular("athlete")) {
        wp_enqueue_style(
            "single-athlete",
            get_template_directory_uri() . "/src/css/single-athlete.css",
            ["base"],
            "1.0.0",
        );
    }

    if (is_post_type_archive("athlete")) {
        wp_enqueue_style(
            "archive-athlete",
            get_template_directory_uri() . "/src/css/archive-athlete.css",
            ["base"],
            "1.0.0",
        );
    }

    if (is_archive() && !is_post_type_archive("athlete")) {
        wp_enqueue_style(
            "archive",
            get_template_directory_uri() . "/src/css/archive.css",
            ["base"],
            "1.0.0",
        );
    }

    if (is_page() && !is_front_page()) {
        wp_enqueue_style(
            "page",
            get_template_directory_uri() . "/src/css/page.css",
            ["base"],
            "1.0.0",
        );
    }
}
add_action("wp_enqueue_scripts", "the_theme_enqueue_assets");
