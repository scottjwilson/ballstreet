<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
  
  <?php
    // Get associated athlete
    $athlete = get_field('associated_athlete'); // Adjust field name if different (e.g., 'associated_athlete')
    $athlete_id = 0;
    $athlete_name = '';
    $athlete_permalink = '';
    $athlete_image = '';
    
    if ($athlete) {
      // Handle ACF relationship field (can be object, array, or ID)
      if (is_array($athlete)) {
        $athlete = $athlete[0]; // Get first athlete if multiple
      }
      if (is_object($athlete) && isset($athlete->ID)) {
        $athlete_id = $athlete->ID;
        $athlete_name = $athlete->post_title;
        $athlete_permalink = get_permalink($athlete->ID);
        $athlete_image = get_the_post_thumbnail($athlete->ID, 'thumbnail', array('class' => 'athlete-thumb'));
      } elseif (is_numeric($athlete)) {
        $athlete_id = $athlete;
        $athlete_name = get_the_title($athlete);
        $athlete_permalink = get_permalink($athlete);
        $athlete_image = get_the_post_thumbnail($athlete, 'thumbnail', array('class' => 'athlete-thumb'));
      }
    }
    
    // Get categories
    $categories = get_the_category();
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
          <?php if (!empty($categories)) : ?>
            <?php foreach (array_slice($categories, 0, 2) as $category) : ?>
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
        <?php if ($athlete_id) : ?>
          <div class="athlete-card-wrapper">
            <a href="<?php echo esc_url($athlete_permalink); ?>" class="athlete-link-card">
              <?php if ($athlete_image) : ?>
                <?php echo $athlete_image; ?>
              <?php else : ?>
                <div class="athlete-thumb-placeholder">
                  <span><?php echo strtoupper(substr($athlete_name, 0, 2)); ?></span>
                </div>
              <?php endif; ?>
              <div class="athlete-link-info">
                <div class="athlete-link-label">Related Athlete</div>
                <div class="athlete-link-name">
                  <?php echo esc_html($athlete_name); ?>
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
    $related_posts = new WP_Query(array(
      'post_type' => 'post',
      'posts_per_page' => 3,
      'post__not_in' => array(get_the_ID()),
      'category__in' => wp_list_pluck($categories, 'term_id'),
      'orderby' => 'rand'
    ));
    
    if ($related_posts->have_posts()) : ?>
      <section class="related-posts-section">
        <div class="container">
          <h2 class="related-posts-title">Related Articles</h2>
          <div class="related-posts-grid">
            <?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
              <article class="related-post-card">
                <a href="<?php the_permalink(); ?>" class="related-post-link">
                  <?php if (has_post_thumbnail()) : ?>
                    <div class="related-post-image">
                      <?php the_post_thumbnail('medium', array('class' => 'related-post-img')); ?>
                    </div>
                  <?php endif; ?>
                  <div class="related-post-body">
                    <h3 class="related-post-title">
                      <?php the_title(); ?>
                    </h3>
                    <p class="related-post-date">
                      <?php echo get_the_date('M j, Y'); ?>
                    </p>
                  </div>
                </a>
              </article>
            <?php endwhile; ?>
          </div>
        </div>
      </section>
      <?php wp_reset_postdata(); ?>
    <?php endif; ?>
    
  </main>

<?php endwhile; ?>

<?php get_footer(); ?>