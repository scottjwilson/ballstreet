<?php
/**
 * Vite Integration for WordPress
 */

class ViteAssetLoader {
    private $manifest = null;
    private $dev_server = 'http://localhost:3000';
    
    public function __construct() {
        $this->load_manifest();
    }
    
    /**
     * Load the Vite manifest file
     */
    private function load_manifest() {
        $manifest_path = get_template_directory() . '/dist/manifest.json';
        
        if (file_exists($manifest_path)) {
            $this->manifest = json_decode(file_get_contents($manifest_path), true);
        }
    }
    
    /**
     * Check if we're in development mode
     */
    public function is_dev_mode() {
        // Check if Vite dev server is running
        $dev_mode = defined('WP_ENV') && WP_ENV === 'development';
        
        if ($dev_mode) {
            // Try to connect to Vite server
            $ch = curl_init($this->dev_server);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 1);
            curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            return $http_code === 200;
        }
        
        return false;
    }
    
    /**
     * Get asset URL
     */
    public function get_asset_url($entry) {
        if ($this->is_dev_mode()) {
            return $this->dev_server . '/' . $entry;
        }
        
        if ($this->manifest && isset($this->manifest[$entry])) {
            return get_template_directory_uri() . '/dist/' . $this->manifest[$entry]['file'];
        }
        
        return '';
    }
    
    /**
     * Enqueue a CSS file
     */
    public function enqueue_style($handle, $entry, $deps = array(), $version = null) {
        $url = $this->get_asset_url($entry);
        
        if ($url) {
            wp_enqueue_style($handle, $url, $deps, $version);
        }
    }
    
    /**
     * Enqueue a JS file
     */
    public function enqueue_script($handle, $entry, $deps = array(), $version = null, $in_footer = true) {
        $url = $this->get_asset_url($entry);
        
        if ($url) {
            if ($this->is_dev_mode()) {
                wp_enqueue_script($handle, $url, $deps, $version, $in_footer);
                wp_script_add_data($handle, 'type', 'module');
            } else {
                wp_enqueue_script($handle, $url, $deps, $version, $in_footer);
            }
        }
    }
    
    /**
     * Add Vite client for HMR in dev mode
     */
    public function add_vite_client() {
        if ($this->is_dev_mode()) {
            echo '<script type="module" src="' . esc_url($this->dev_server . '/@vite/client') . '"></script>' . "\n";
        }
    }
}

// Initialize Vite loader
$vite = new ViteAssetLoader();

// Add Vite client to head in dev mode
add_action('wp_head', function() use ($vite) {
    $vite->add_vite_client();
}, 1);