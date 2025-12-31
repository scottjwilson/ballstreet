<?php get_header(); ?>

<?php
// Get current category information
$category = get_queried_object();
$category_name = $category->name;
$category_description = $category->description;
$category_emoji = getCategoryEmoji($category_name);
$category_count = $category->count;

// Build header title with emoji
$header_title = $category_emoji . ' ' . $category_name;
$header_subtitle = $category_description ?: 'Browse all posts in this category';
?>

<main class="site-main">
    <!-- Header Section -->
    <?php getHeaderSection($header_title, $header_subtitle); ?>
    
    <!-- News List Section -->
    <section class="news-list-section">
        <div class="container">
            <div class="news-layout">
                <!-- News List (2 columns) -->
                <div class="news-main">
                    <?php if (have_posts()) : ?>
                        <div class="articles-list">
                            <?php while (have_posts()) : the_post(); ?>
                                <?php 
                                $post_data = get_post_card_data();
                                set_query_var('post_data', $post_data);
                                get_template_part('template-parts/post', 'card');
                                ?>
                            <?php endwhile; ?>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="news-pagination">
                            <?php
                            the_posts_pagination(array(
                                'mid_size' => 2,
                                'prev_text' => __('← Previous', 'ball-street'),
                                'next_text' => __('Next →', 'ball-street'),
                            ));
                            ?>
                        </div>
                    <?php else : ?>
                        <div class="no-news">
                            <p>No posts found in this category.</p>
                            <a href="<?php echo esc_url(home_url()); ?>" class="back-to-home">
                                ← Back to Home
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Categories Sidebar (1 column) -->
                <div class="news-sidebar">
                    <div class="sidebar-categories">
                        <h3 class="sidebar-title">All Categories</h3>
                        <?php
                        $categories = get_categories(array(
                            'orderby' => 'name',
                            'order' => 'ASC',
                            'hide_empty' => true
                        ));
                        
                        if (!empty($categories)) : ?>
                            <ul class="categories-list">
                                <?php foreach ($categories as $cat) : 
                                    $is_current = ($cat->term_id === $category->term_id);
                                    $cat_emoji = getCategoryEmoji($cat->name);
                                ?>
                                    <li class="category-item <?php echo $is_current ? 'current-category' : ''; ?>">
                                        <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" 
                                           class="category-link">
                                            <span class="category-emoji"><?php echo $cat_emoji; ?></span>
                                            <span class="category-name"><?php echo esc_html($cat->name); ?></span>
                                            <span class="category-count">
                                                (<?php echo $cat->count; ?>)
                                            </span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else : ?>
                            <p class="no-categories">No categories found.</p>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Back to All News Link -->
                    <div class="sidebar-back-link">
                        <a href="<?php echo esc_url(get_post_type_archive_link('post')); ?>" class="back-link-sidebar">
                            ← View All News
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
