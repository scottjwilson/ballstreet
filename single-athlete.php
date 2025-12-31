<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
  
  <?php
    // Get all athlete data using helper functions
    $fields = get_athlete_fields(true); // true = extended data
    $news_posts = get_athlete_news();
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
              <?php if ($fields['position']) : ?>
                <span class="athlete-position-badge">
                  <?php echo esc_html($fields['position']); ?>
                </span>
              <?php endif; ?>
              
              <?php if ($fields['class_year']) : ?>
                <span class="athlete-meta-item"><?php echo esc_html($fields['class_year']); ?></span>
              <?php endif; ?>
              
              <?php if ($fields['physical_stats']) : ?>
                <span class="athlete-meta-item"><?php echo esc_html($fields['physical_stats']); ?></span>
              <?php endif; ?>
            </div>
            
            <?php if ($fields['school_id']) : ?>
              <div class="athlete-school">
                <?php 
                $school_logo = get_the_post_thumbnail($fields['school_id'], 'thumbnail', array('class' => 'school-logo-hero'));
                if ($school_logo) {
                  echo $school_logo;
                }
                ?>
                <?php if ($fields['school_permalink']) : ?>
                  <a href="<?php echo esc_url($fields['school_permalink']); ?>" class="school-name-link">
                    <?php echo esc_html($fields['school_name']); ?>
                  </a>
                <?php else : ?>
                  <span class="school-name"><?php echo esc_html($fields['school_name']); ?></span>
                <?php endif; ?>
              </div>
            <?php endif; ?>
            
            <?php if ($fields['high_school']) : ?>
              <div class="athlete-high-school">
                <span class="high-school-label">High School:</span> 
                <?php echo esc_html($fields['high_school']); ?>
                <?php if ($fields['high_school_location']) : ?>
                  <span class="high-school-location">(<?php echo esc_html($fields['high_school_location']); ?>)</span>
                <?php endif; ?>
              </div>
            <?php endif; ?>
            
            <?php if ($fields['nil_valuation']) : ?>
              <div class="nil-valuation-card">
                <div class="nil-label">NIL VALUATION</div>
                <div class="nil-value">
                  <?php echo format_nil_valuation($fields['nil_valuation']); ?>
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
            <?php if (!empty($fields['sponsor_data'])) : ?>
              <div class="sidebar-card">
                <h3 class="sidebar-heading">Sponsors</h3>
                <div class="sponsors-list">
                  <?php foreach ($fields['sponsor_data'] as $sponsor) : ?>
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
                <?php if ($fields['position']) : ?>
                  <div class="fact-item">
                    <dt class="fact-label">Position</dt>
                    <dd class="fact-value"><?php echo esc_html($fields['position']); ?></dd>
                  </div>
                <?php endif; ?>
                
                <?php if ($fields['class_year']) : ?>
                  <div class="fact-item">
                    <dt class="fact-label">Class</dt>
                    <dd class="fact-value"><?php echo esc_html($fields['class_year']); ?></dd>
                  </div>
                <?php endif; ?>
                
                <?php if ($fields['height']) : ?>
                  <div class="fact-item">
                    <dt class="fact-label">Height</dt>
                    <dd class="fact-value"><?php echo esc_html($fields['height']); ?></dd>
                  </div>
                <?php endif; ?>
                
                <?php if ($fields['weight']) : ?>
                  <div class="fact-item">
                    <dt class="fact-label">Weight</dt>
                    <dd class="fact-value"><?php echo esc_html($fields['weight']); ?></dd>
                  </div>
                <?php endif; ?>
                
                <?php if ($fields['high_school']) : ?>
                  <div class="fact-item">
                    <dt class="fact-label">High School</dt>
                    <dd class="fact-value fact-value-right"><?php echo esc_html($fields['high_school']); ?></dd>
                  </div>
                <?php endif; ?>
                
                <?php if ($fields['school_name']) : ?>
                  <div class="fact-item">
                    <dt class="fact-label">School</dt>
                    <dd class="fact-value fact-value-right"><?php echo esc_html($fields['school_name']); ?></dd>
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