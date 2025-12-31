<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <nav class="main-nav">
        <div class="container">
            <div class="site-logo">
                <a href="<?php echo home_url(); ?>">
                    <span class="logo-primary">BALL STREET</span>
                    <span class="logo-secondary">SPORTS JOURNAL</span>
                </a>
            </div>
            
            <!-- Desktop Navigation -->
            <div class="nav-desktop">
                <?php wp_nav_menu([
                    'theme_location' => 'menuTop',
                    'container' => false,
                    'menu_class' => 'nav-menu',
                    'fallback_cb' => false,
                ]); ?>
                <button class="btn-subscribe">Subscribe</button>
            </div>
            
            <!-- Mobile Menu Button -->
            <button class="mobile-menu-btn" aria-label="Toggle menu" aria-expanded="false">
                <span class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>
        </div>
        
        <!-- Mobile Navigation -->
        <div class="nav-mobile">
            <?php wp_nav_menu([
                'theme_location' => 'menuTop',
                'container' => false,
                'menu_class' => 'nav-menu',
                'fallback_cb' => false,
            ]); ?>
            <button class="btn-subscribe">Subscribe</button>
        </div>
    </nav>
</header>

<script>
// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const mobileNav = document.querySelector('.nav-mobile');
    
    if (mobileMenuBtn && mobileNav) {
        mobileMenuBtn.addEventListener('click', function() {
            const isOpen = mobileNav.classList.toggle('is-open');
            mobileMenuBtn.classList.toggle('is-active');
            mobileMenuBtn.setAttribute('aria-expanded', isOpen);
        });
    }
});
</script>