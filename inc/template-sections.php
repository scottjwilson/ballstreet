<?php
/**
 * Template Section Functions
 * Hero, Featured Stories, Coverage Areas, Newsletter
 */

function getHeroSection($args = array()) {
    // Set default values
    $defaults = array(
        'badge' => 'BREAKING NEWS',
        'title' => 'Where Sports Meets Business Intelligence',
        'subtitle' => 'In-depth coverage of NIL deals, athlete contracts, betting markets, and the billion-dollar business behind professional and college athletics.',
        'primary_button_text' => 'Read Latest',
        'primary_button_link' => '#',
        'secondary_button_text' => 'Free Newsletter',
        'secondary_button_link' => '#',
        'show_market_watch' => true, // Option to hide/show the market watch section
    );
    
    // Merge defaults with passed arguments
    $args = wp_parse_args($args, $defaults);
    
    echo '<section class="hero">
        <div class="container">
            <div class="hero-grid">
                <div>
                    <div class="breaking-badge">
                        ' . esc_html($args['badge']) . '
                    </div>
                    <h1 class="hero-title">
                        ' . esc_html($args['title']) . '
                    </h1>
                    <p class="hero-subtitle">
                        ' . esc_html($args['subtitle']) . '
                    </p>
                    <div class="hero-buttons">
                        <a href="' . esc_url($args['primary_button_link']) . '" class="btn-primary">
                            ' . esc_html($args['primary_button_text']) . '
                        </a>
                        <a href="' . esc_url($args['secondary_button_link']) . '" class="btn-secondary">
                            ' . esc_html($args['secondary_button_text']) . '
                        </a>
                    </div>
                </div>';
    
    // Conditionally show market watch section
    if ($args['show_market_watch']) {
        echo '<div class="market-watch">
                    <div class="market-label">MARKET WATCH</div>
                    <div class="market-stats">
                        <div class="market-item">
                            <span class="market-name">NBA Salary Cap</span>
                            <span class="market-value">$136M ↑ 3.5%</span>
                        </div>
                        <div class="market-item">
                            <span class="market-name">NIL Market Value</span>
                            <span class="market-value">$1.2B ↑ 18%</span>
                        </div>
                        <div class="market-item">
                            <span class="market-name">Sports Betting Rev</span>
                            <span class="market-value">$7.5B ↑ 25%</span>
                        </div>
                    </div>
                </div>';
    }
    
    echo '</div>
        </div>
    </section>';
}

function getFeaturedStories() {
    // Featured stories code
}

function getCoverageAreas() {
    // Coverage areas code
}

function getHeaderSection($title = 'title', $subtitle = 'subtitle') {
    // Header section code here
    // You can customize the HTML output based on your needs
    echo '<section class="header-section">
        <div class="container">
            <h2 class="header-title">' . esc_html($title) . '</h2>
            <p class="header-subtitle">' . esc_html($subtitle) . '</p>
        </div>
    </section>';
}

function getNewsletter(){
    echo '<section class="newsletter">
          <div class="newsletter-container">
              <h2 class="newsletter-title">Stay Ahead of the Game</h2>
              <p class="newsletter-description">
                  Get daily insights on the business of sports delivered to your inbox
              </p>
              <form class="newsletter-form">
                  <input 
                      type="email" 
                      placeholder="Enter your email" 
                      class="newsletter-input"
                  />
                  <button type="submit" class="newsletter-btn">
                      Subscribe Free
                  </button>
              </form>
              <p class="newsletter-note">Join 50,000+ sports business professionals</p>
          </div>
      </section>';
}

function getCategoryEmoji($category_name) {
    // Map category names to emojis
    $emoji_map = array(
        'NIL' => '🎓',
        'Contracts' => '📝',
        'Betting' => '🎲',
        'Trades' => '🔄',
        'Business' => '💼',
    );
    
    // Try exact match first
    if (isset($emoji_map[$category_name])) {
        return $emoji_map[$category_name];
    }
    
    // Try case-insensitive match
    foreach ($emoji_map as $key => $emoji) {
        if (strcasecmp($category_name, $key) === 0) {
            return $emoji;
        }
    }
    
    // Default emoji if no match found
    return '📰';
}