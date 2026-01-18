<?php
/**
 * Vite Integration
 *
 * Handles Vite dev server detection and asset loading for both
 * development (HMR) and production (manifest-based) environments.
 */

/**
 * Detect if Vite dev server is running and get the base path
 *
 * @return array{running: bool, base: string, server: string}
 */
function the_theme_detect_vite_server(): array
{
    $vite_server = "http://localhost:3000";

    $response = @wp_remote_get($vite_server . "/src/js/main.js", [
        "timeout" => 1,
        "sslverify" => false,
        "redirection" => 0,
    ]);

    if (
        is_wp_error($response) ||
        wp_remote_retrieve_response_code($response) !== 200
    ) {
        return ["running" => false, "base" => "/", "server" => $vite_server];
    }

    // Try @vite/client at root
    $client_response = @wp_remote_get($vite_server . "/@vite/client", [
        "timeout" => 1,
        "sslverify" => false,
        "redirection" => 0,
    ]);

    if (
        !is_wp_error($client_response) &&
        wp_remote_retrieve_response_code($client_response) === 200
    ) {
        return ["running" => true, "base" => "/", "server" => $vite_server];
    }

    // Try with theme base path
    $client_response = @wp_remote_get(
        $vite_server . "/wp-content/themes/clean-vite/@vite/client",
        [
            "timeout" => 1,
            "sslverify" => false,
            "redirection" => 0,
        ],
    );

    if (
        !is_wp_error($client_response) &&
        wp_remote_retrieve_response_code($client_response) === 200
    ) {
        return [
            "running" => true,
            "base" => "/wp-content/themes/clean-vite/",
            "server" => $vite_server,
        ];
    }

    return ["running" => true, "base" => "/", "server" => $vite_server];
}

/**
 * Check if we're in a local development environment
 *
 * @return bool
 */
function the_theme_is_local_environment(): bool
{
    $home_url = home_url();
    return strpos($home_url, "localhost") !== false ||
        strpos($home_url, "127.0.0.1") !== false ||
        strpos($home_url, ".local") !== false ||
        strpos($home_url, ".dev") !== false;
}

/**
 * Output Vite client scripts in head for HMR (local development only)
 */
function the_theme_output_vite_scripts(): void
{
    // Only run on local environments
    if (!the_theme_is_local_environment()) {
        return;
    }

    // Skip if production manifest exists
    if (file_exists(get_theme_file_path("dist/.vite/manifest.json"))) {
        return;
    }

    // On local dev, always output Vite scripts (browser will handle if server is down)
    $vite_server = "http://localhost:3000";

    echo '<script type="module" src="' .
        esc_url($vite_server . "/@vite/client") .
        '"></script>' .
        "\n";
    echo '<script type="module" src="' .
        esc_url($vite_server . "/src/js/main.js") .
        '"></script>' .
        "\n";
}
add_action("wp_head", "the_theme_output_vite_scripts", 1);

/**
 * Load Vite assets from manifest in production
 */
function the_theme_load_vite_production_assets(): void
{
    $manifest_path = get_theme_file_path("dist/.vite/manifest.json");

    if (!file_exists($manifest_path)) {
        return;
    }

    // Only skip if Vite dev server is actually running (local dev only)
    if (the_theme_is_local_environment()) {
        $vite = the_theme_detect_vite_server();
        if ($vite["running"]) {
            return;
        }
    }

    $manifest = json_decode(file_get_contents($manifest_path), true);

    if (!$manifest || !isset($manifest["src/js/main.js"])) {
        return;
    }

    $entry = $manifest["src/js/main.js"];

    // Enqueue CSS files
    if (isset($entry["css"]) && is_array($entry["css"])) {
        foreach ($entry["css"] as $index => $css_file) {
            $css_path = get_theme_file_path("dist/" . $css_file);
            wp_enqueue_style(
                "vite-style-" . $index,
                get_theme_file_uri("dist/" . $css_file),
                [],
                file_exists($css_path) ? filemtime($css_path) : null,
            );
        }
    }

    // Enqueue JS
    $js_path = get_theme_file_path("dist/" . $entry["file"]);
    wp_enqueue_script(
        "vite-main",
        get_theme_file_uri("dist/" . $entry["file"]),
        [],
        file_exists($js_path) ? filemtime($js_path) : null,
        true,
    );
}
add_action("wp_enqueue_scripts", "the_theme_load_vite_production_assets", 100);

/**
 * Add type="module" attribute to Vite scripts
 *
 * @param string $tag    Script HTML tag
 * @param string $handle Script handle
 * @param string $src    Script source URL
 * @return string Modified script tag
 */
function the_theme_vite_script_module_type(
    string $tag,
    string $handle,
    string $src,
): string {
    if (strpos($handle, "vite-") !== 0) {
        return $tag;
    }

    if (
        strpos($tag, 'type="module"') !== false ||
        strpos($tag, "type='module'") !== false
    ) {
        return $tag;
    }

    return str_replace("<script ", '<script type="module" ', $tag);
}
add_filter("script_loader_tag", "the_theme_vite_script_module_type", 10, 3);
