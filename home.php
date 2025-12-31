<?php get_header(); ?>

<main class="site-main">
    <!-- Header Section -->
    <?php getHeaderSection('News', 'Latest sports news, analysis, and coverage'); ?>
    
    <!-- News List Section -->
    <section class="news-list-section">
        <div class="container">
            <div class="news-layout">
                <!-- News List (2 columns) -->
                <div class="news-main">
                    <?php if (have_posts()) : ?>
                        <div class="articles-list">
                            <?php while (have_posts()) : the_post(); ?>
                                <article class="article-card">
                                    <a href="<?php the_permalink(); ?>" class="article-link">
                                        <div class="article-content">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <div class="article-image">
                                                    <?php the_post_thumbnail('medium', array('class' => 'article-thumb')); ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="article-body <?php echo has_post_thumbnail() ? 'has-image' : 'no-image'; ?>">
                                                <h2 class="article-title">
                                                    <?php the_title(); ?>
                                                </h2>
                                                <?php if (get_the_date()) : ?>
                                                    <p class="article-date">
                                                        <?php echo get_the_date('F j, Y'); ?>
                                                    </p>
                                                <?php endif; ?>
                                                <?php if (get_the_excerpt()) : ?>
                                                    <p class="article-excerpt">
                                                        <?php echo esc_html(get_the_excerpt()); ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </a>
                                </article>
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
                            <p>No news found.</p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Categories Sidebar (1 column) -->
                <div class="news-sidebar">
                    <div class="sidebar-categories">
                        <h3 class="sidebar-title">Categories</h3>
                        <?php
                        $categories = get_categories(array(
                            'orderby' => 'name',
                            'order' => 'ASC',
                            'hide_empty' => true
                        ));
                        
                        if (!empty($categories)) : ?>
                            <ul class="categories-list">
                                <?php foreach ($categories as $category) : ?>
                                    <li class="category-item">
                                        <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" 
                                           class="category-link">
                                            <span class="category-name"><?php echo esc_html($category->name); ?></span>
                                            <span class="category-count">
                                                (<?php echo $category->count; ?>)
                                            </span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else : ?>
                            <p class="no-categories">No categories found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>