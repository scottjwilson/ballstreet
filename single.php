<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
  <?php 
  $post_data = get_single_post_data();
  set_query_var('post_data', $post_data);
  ?>

  <main class="site-main">
    <?php get_template_part('template-parts/post', 'header'); ?>
    
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
              <?php if (!empty($post_data['categories']['all'])) : ?>
                <div class="post-categories-list">
                  <span class="categories-label">Categories:</span>
                  <?php foreach ($post_data['categories']['all'] as $category) : ?>
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
    
    <?php 
    set_query_var('related_posts', $post_data['related_posts']);
    get_template_part('template-parts/related', 'posts');
    ?>
  </main>

<?php endwhile; ?>

<?php get_footer(); ?>
