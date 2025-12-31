<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
  
  <?php
    // Get associated athlete using helper function
    $athlete = get_associated_athlete();
    
    // Get categories using helper function
    $categories_data = get_post_categories_formatted();
    $categories = $categories_data['all'];
  ?>

  <main class="site-main">
    <!-- Header Section -->
    <section class="post-header">
      <div class="container">
        <!-- Back to News Link -->
        <div class="back-link-wrapper">
          <a href="<?php echo get_post_type_archive_link('post'); ?>" class="back-link">
            <svg class="back-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to News
          </a>
        </div>
        
        <!-- Post Meta -->
        <div class="post-meta-tags">
          <?php if (!empty($categories_data['first_two'])) : ?>
            <?php foreach ($categories_data['first_two'] as $category) : ?>
              <span class="post-category-badge">
                <?php echo esc_html($category->name); ?>
              </span>
            <?php endforeach; ?>
          <?php endif; ?>
          <span class="post-date">
            <?php echo get_the_date('F j, Y'); ?>
          </span>
        </div>
        
        <!-- Post Title -->
        <h1 class="post-title">
          <?php the_title(); ?>
        </h1>
        
        <!-- Associated Athlete Link -->
        <?php if ($athlete['id']) : ?>
          <div class="athlete-card-wrapper">
            <a href="<?php echo esc_url($athlete['permalink']); ?>" class="athlete-link-card">
              <?php if ($athlete['image']) : ?>
                <?php echo $athlete['image']; ?>
              <?php else : ?>
                <div class="athlete-thumb-placeholder">
                  <span><?php echo strtoupper(substr($athlete['name'], 0, 2)); ?></span>
                </div>
              <?php endif; ?>
              <div class="athlete-link-info">
                <div class="athlete-link-label">Related Athlete</div>
                <div class="athlete-link-name">
                  <?php echo esc_html($athlete['name']); ?>
                </div>
              </div>
              <svg class="athlete-link-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </a>
          </div>
        <?php endif; ?>
      </div>
    </section>
    
    <!-- Featured Image -->
    <?php if (has_post_thumbnail()) : ?>
      <section class="featured-image-section">
        <div class="featured-image-container">
          <div class="featured-image-wrapper">
            <?php the_post_thumbnail('large', array('class' => 'featured-image')); ?>
          </div>
        </div>
      </section>
    <?php endif; ?>
    
    <!-- Main Content Section -->
    <section class="post-content-section">
      <div class="post-content-container">
        <div class="post-content">
          <?php the_content(); ?>
        </div>
        
        <!-- Post Footer -->
        <div class="post-footer">
          <div class="post-footer-content">
            <div class="post-categories">
              <?php if (!empty($categories)) : ?>
                <div class="post-categories-list">
                  <span class="categories-label">Categories:</span>
                  <?php foreach ($categories as $category) : ?>
                    <a href="<?php echo get_category_link($category->term_id); ?>" class="category-link">
                      <?php echo esc_html($category->name); ?>
                    </a>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Related Posts Section -->
    <?php
    $related_posts = get_related_posts(array(
      'posts_per_page' => 3
    ));
    
    if (!empty($related_posts)) : ?>
      <section class="related-posts-section">
        <div class="container">
          <h2 class="related-posts-title">Related Articles</h2>
          <div class="related-posts-grid">
            <?php foreach ($related_posts as $related_post) : ?>
              <article class="related-post-card">
                <a href="<?php echo esc_url($related_post['permalink']); ?>" class="related-post-link">
                  <?php if ($related_post['has_thumbnail']) : ?>
                    <div class="related-post-image">
                      <?php echo $related_post['thumbnail']; ?>
                    </div>
                  <?php endif; ?>
                  <div class="related-post-body">
                    <h3 class="related-post-title">
                      <?php echo esc_html($related_post['title']); ?>
                    </h3>
                    <p class="related-post-date">
                      <?php echo esc_html($related_post['date']); ?>
                    </p>
                  </div>
                </a>
              </article>
            <?php endforeach; ?>
          </div>
        </div>
      </section>
    <?php endif; ?>
    
  </main>

<?php endwhile; ?>

<?php get_footer(); ?>