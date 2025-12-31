<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
  
  <?php
    // Get ACF fields
    $position = get_field('position');
    $class_year = get_field('class_year') ?: get_field('year');
    $height = get_field('height');
    $weight = get_field('weight');
    $high_school = get_field('high_school');
    $high_school_location = get_field('high_school_location');
    $nil_valuation = get_field('nil_valuation') ?: get_field('valuation');

    // Get news posts
    $news = get_field('news');
    $news_posts = array();
    if ($news) {
      if (!is_array($news)) {
        $news = array($news);
      }
      foreach ($news as $news_item) {
        $news_id = 0;
        $news_title = '';
        $news_permalink = '';
        $news_excerpt = '';
        $news_date = '';
        $news_image = '';
        
        if (is_object($news_item) && isset($news_item->ID)) {
          $news_id = $news_item->ID;
          $news_title = $news_item->post_title;
          $news_permalink = get_permalink($news_item->ID);
          $news_excerpt = get_the_excerpt($news_item->ID);
          $news_date = get_the_date('F j, Y', $news_item->ID);
          $news_image = get_the_post_thumbnail($news_id, 'medium', array('class' => 'news-thumb'));
        } elseif (is_numeric($news_item)) {
          $news_id = $news_item;
          $news_title = get_the_title($news_id);
          $news_permalink = get_permalink($news_id);
          $news_excerpt = get_the_excerpt($news_id);
          $news_date = get_the_date('F j, Y', $news_id);
          $news_image = get_the_post_thumbnail($news_id, 'medium', array('class' => 'news-thumb'));
        }
        
        if ($news_id) {
          $news_posts[] = array(
            'id' => $news_id,
            'title' => $news_title,
            'permalink' => $news_permalink,
            'excerpt' => $news_excerpt,
            'date' => $news_date,
            'image' => $news_image
          );
        }
      }
    }
    
    // Get school
    $school = get_field('school');
    $school_id = 0;
    $school_name = '';
    $school_permalink = '';
    if ($school) {
      if (is_array($school)) {
        $school = $school[0];
      }
      if (is_object($school) && isset($school->ID)) {
        $school_id = $school->ID;
        $school_name = $school->post_title;
        $school_permalink = get_permalink($school->ID);
      } elseif (is_numeric($school)) {
        $school_id = $school;
        $school_name = get_the_title($school);
        $school_permalink = get_permalink($school);
      }
    }
    
    // Get sponsors
    $sponsors = get_field('sponsors');
    $sponsor_data = array();
    if ($sponsors) {
      if (!is_array($sponsors)) {
        $sponsors = array($sponsors);
      }
      foreach ($sponsors as $sponsor) {
        $sponsor_id = 0;
        $sponsor_name = '';
        $sponsor_permalink = '';
        if (is_object($sponsor) && isset($sponsor->ID)) {
          $sponsor_id = $sponsor->ID;
          $sponsor_name = $sponsor->post_title;
          $sponsor_permalink = get_permalink($sponsor->ID);
        } elseif (is_numeric($sponsor)) {
          $sponsor_id = $sponsor;
          $sponsor_name = get_the_title($sponsor);
          $sponsor_permalink = get_permalink($sponsor);
        }
        if ($sponsor_id) {
          $sponsor_image = get_the_post_thumbnail($sponsor_id, 'medium', array('class' => 'sponsor-thumb'));
          $sponsor_data[] = array(
            'id' => $sponsor_id,
            'name' => $sponsor_name,
            'image' => $sponsor_image,
            'permalink' => $sponsor_permalink
          );
        }
      }
    }
    
    // Format physical stats
    $physical_stats = '';
    if ($height && $weight) {
      $physical_stats = $height . ' / ' . $weight;
    } elseif ($height) {
      $physical_stats = $height;
    } elseif ($weight) {
      $physical_stats = $weight;
    }
  ?>

  <main class="site-main">
    <!-- Hero Section -->
    <section class="athlete-hero">
      <div class="container">
        <div class="athlete-hero-grid">
          <!-- Athlete Photo -->
          <div class="athlete-photo-col">
            <div class="athlete-photo-card">
              <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large', array('class' => 'athlete-photo')); ?>
              <?php else : ?>
                <div class="athlete-photo-placeholder">
                  <span><?php echo strtoupper(substr(get_the_title(), 0, 2)); ?></span>
                </div>
              <?php endif; ?>
            </div>
          </div>
          
          <!-- Athlete Info -->
          <div class="athlete-info-col">
            <h1 class="athlete-name"><?php the_title(); ?></h1>
            
            <div class="athlete-meta">
              <?php if ($position) : ?>
                <span class="athlete-position-badge">
                  <?php echo esc_html($position); ?>
                </span>
              <?php endif; ?>
              
              <?php if ($class_year) : ?>
                <span class="athlete-meta-item"><?php echo esc_html($class_year); ?></span>
              <?php endif; ?>
              
              <?php if ($physical_stats) : ?>
                <span class="athlete-meta-item"><?php echo esc_html($physical_stats); ?></span>
              <?php endif; ?>
            </div>
            
            <?php if ($school_id) : ?>
              <div class="athlete-school">
                <?php 
                $school_logo = get_the_post_thumbnail($school_id, 'thumbnail', array('class' => 'school-logo-hero'));
                if ($school_logo) {
                  echo $school_logo;
                }
                ?>
                <?php if ($school_permalink) : ?>
                  <a href="<?php echo esc_url($school_permalink); ?>" class="school-name-link">
                    <?php echo esc_html($school_name); ?>
                  </a>
                <?php else : ?>
                  <span class="school-name"><?php echo esc_html($school_name); ?></span>
                <?php endif; ?>
              </div>
            <?php endif; ?>
            
            <?php if ($high_school) : ?>
              <div class="athlete-high-school">
                <span class="high-school-label">High School:</span> 
                <?php echo esc_html($high_school); ?>
                <?php if ($high_school_location) : ?>
                  <span class="high-school-location">(<?php echo esc_html($high_school_location); ?>)</span>
                <?php endif; ?>
              </div>
            <?php endif; ?>
            
            <?php if ($nil_valuation) : ?>
              <div class="nil-valuation-card">
                <div class="nil-label">NIL VALUATION</div>
                <div class="nil-value">
                  <?php 
                  if (is_numeric($nil_valuation)) {
                    if ($nil_valuation >= 1000000) {
                      echo '$' . number_format($nil_valuation / 1000000, 1) . 'M';
                    } elseif ($nil_valuation >= 1000) {
                      echo '$' . number_format($nil_valuation / 1000, 0) . 'K';
                    } else {
                      echo '$' . number_format($nil_valuation);
                    }
                  } else {
                    echo esc_html($nil_valuation);
                  }
                  ?>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Main Content Section -->
    <section class="athlete-content-section">
      <div class="container">
        <div class="athlete-layout">
          <!-- Main Content -->
          <div class="athlete-main">
            <?php if (!empty($news_posts)) : ?>
              <div class="athlete-news-section">
                <h2 class="section-heading">News</h2>
                <div class="news-list">
                  <?php foreach ($news_posts as $news_post) : ?>
                    <article class="news-card">
                      <a href="<?php echo esc_url($news_post['permalink']); ?>" class="news-link">
                        <div class="news-content">
                          <?php if ($news_post['image']) : ?>
                            <div class="news-image-wrapper">
                              <?php echo $news_post['image']; ?>
                            </div>
                          <?php endif; ?>
                          <div class="news-body">
                            <h3 class="news-title">
                              <?php echo esc_html($news_post['title']); ?>
                            </h3>
                            <?php if ($news_post['date']) : ?>
                              <p class="news-date">
                                <?php echo esc_html($news_post['date']); ?>
                              </p>
                            <?php endif; ?>
                          </div>
                        </div>
                      </a>
                    </article>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endif; ?>
            
            <!-- Additional Content Sections -->
            <?php if (get_field('bio') || get_field('achievements') || get_field('stats')) : ?>
              <div class="athlete-details">
                <?php if (get_field('bio')) : ?>
                  <div class="detail-section">
                    <h2 class="detail-heading">Biography</h2>
                    <div class="detail-content">
                      <?php the_field('bio'); ?>
                    </div>
                  </div>
                <?php endif; ?>
                
                <?php if (get_field('achievements')) : ?>
                  <div class="detail-section">
                    <h2 class="detail-heading">Achievements</h2>
                    <div class="detail-content">
                      <?php the_field('achievements'); ?>
                    </div>
                  </div>
                <?php endif; ?>
                
                <?php if (get_field('stats')) : ?>
                  <div class="detail-section">
                    <h2 class="detail-heading">Statistics</h2>
                    <div class="detail-content">
                      <?php the_field('stats'); ?>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>
          
          <!-- Sidebar -->
          <div class="athlete-sidebar">
            <!-- Sponsors Card -->
            <?php if (!empty($sponsor_data)) : ?>
              <div class="sidebar-card">
                <h3 class="sidebar-heading">Sponsors</h3>
                <div class="sponsors-list">
                  <?php foreach ($sponsor_data as $sponsor) : ?>
                    <div class="sponsor-item">
                      <?php if ($sponsor['image']) : ?>
                        <div class="sponsor-logo-wrapper">
                          <?php echo $sponsor['image']; ?>
                        </div>
                      <?php endif; ?>
                      <div class="sponsor-name-wrapper">
                        <?php if ($sponsor['permalink']) : ?>
                          <a href="<?php echo esc_url($sponsor['permalink']); ?>" class="sponsor-name-link">
                            <?php echo esc_html($sponsor['name']); ?>
                          </a>
                        <?php else : ?>
                          <span class="sponsor-name"><?php echo esc_html($sponsor['name']); ?></span>
                        <?php endif; ?>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endif; ?>
            
            <!-- Quick Stats Card -->
            <div class="sidebar-card">
              <h3 class="sidebar-heading">Quick Facts</h3>
              <dl class="quick-facts">
                <?php if ($position) : ?>
                  <div class="fact-item">
                    <dt class="fact-label">Position</dt>
                    <dd class="fact-value"><?php echo esc_html($position); ?></dd>
                  </div>
                <?php endif; ?>
                
                <?php if ($class_year) : ?>
                  <div class="fact-item">
                    <dt class="fact-label">Class</dt>
                    <dd class="fact-value"><?php echo esc_html($class_year); ?></dd>
                  </div>
                <?php endif; ?>
                
                <?php if ($height) : ?>
                  <div class="fact-item">
                    <dt class="fact-label">Height</dt>
                    <dd class="fact-value"><?php echo esc_html($height); ?></dd>
                  </div>
                <?php endif; ?>
                
                <?php if ($weight) : ?>
                  <div class="fact-item">
                    <dt class="fact-label">Weight</dt>
                    <dd class="fact-value"><?php echo esc_html($weight); ?></dd>
                  </div>
                <?php endif; ?>
                
                <?php if ($high_school) : ?>
                  <div class="fact-item">
                    <dt class="fact-label">High School</dt>
                    <dd class="fact-value fact-value-right"><?php echo esc_html($high_school); ?></dd>
                  </div>
                <?php endif; ?>
                
                <?php if ($school_name) : ?>
                  <div class="fact-item">
                    <dt class="fact-label">School</dt>
                    <dd class="fact-value fact-value-right"><?php echo esc_html($school_name); ?></dd>
                  </div>
                <?php endif; ?>
              </dl>
            </div>
            
            <!-- Share Card -->
            <div class="share-card">
              <h3 class="share-heading">Share This Profile</h3>
              <div class="share-buttons">
                <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode(get_the_title()); ?>&url=<?php echo urlencode(get_permalink()); ?>" 
                   target="_blank" 
                   class="share-btn share-twitter">
                  <svg class="share-icon" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/>
                  </svg>
                  Twitter
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" 
                   target="_blank" 
                   class="share-btn share-facebook">
                  <svg class="share-icon" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
                  </svg>
                  Facebook
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Related Athletes Section -->
    <?php
    $related_athletes = new WP_Query(array(
      'post_type' => 'athlete',
      'posts_per_page' => 4,
      'post__not_in' => array(get_the_ID()),
      'orderby' => 'rand'
    ));
    
    if ($related_athletes->have_posts()) : ?>
      <section class="related-athletes-section">
        <div class="container">
          <h2 class="related-heading">Related Athletes</h2>
          <div class="related-athletes-grid">
            <?php while ($related_athletes->have_posts()) : $related_athletes->the_post(); ?>
              <article class="related-athlete-card">
                <a href="<?php the_permalink(); ?>" class="related-athlete-link">
                  <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('medium', array('class' => 'related-athlete-image')); ?>
                  <?php endif; ?>
                  <h3 class="related-athlete-name">
                    <?php the_title(); ?>
                  </h3>
                  <?php if (get_field('position')) : ?>
                    <p class="related-athlete-position"><?php the_field('position'); ?></p>
                  <?php endif; ?>
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