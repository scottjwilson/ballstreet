<?php get_header(); ?>

<main class="site-main">
   <?php getHeroSection(); ?>
    <section class="featured-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Featured Stories</h2>
                <a href="#" class="view-all">View All →</a>
            </div>
            
            <div class="stories-grid">
                <?php
                // Query featured posts with ACF boolean field
                $featured_posts = new WP_Query([
                    'posts_per_page' => 3,
                    'post_type' => 'post',
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'meta_query' => [
                        [
                            'key' => 'isFeatured',
                            'value' => '1',
                            'compare' => '='
                        ]
                    ]
                ]);

                if ($featured_posts->have_posts()) :
                    while ($featured_posts->have_posts()) : $featured_posts->the_post();
                        // Get post category for label
                        $categories = get_the_category();
                        $category_name = !empty($categories) ? strtoupper($categories[0]->name) : 'FEATURED';
                        $category_emoji = !empty($categories) ? getCategoryEmoji($categories[0]->name) : '📰';
                        
                        // Get featured image or use gradient background
                        $has_thumbnail = has_post_thumbnail();
                        $thumbnail_url = $has_thumbnail ? get_the_post_thumbnail_url(get_the_ID(), 'large') : '';
                        
                        // Get excerpt or trimmed content
                        $excerpt = has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 20);
                        
                        // Get read time (estimate based on word count)
                        $word_count = str_word_count(strip_tags(get_the_content()));
                        $read_time = max(1, round($word_count / 200)); // Assuming 200 words per minute
                ?>
                <article class="story-card">
                    <a href="<?php the_permalink(); ?>">
                        <div class="story-image<?php echo $has_thumbnail ? '' : ' story-image-gradient'; ?>" <?php echo $has_thumbnail ? 'style="background-image: url(' . esc_url($thumbnail_url) . ');"' : ''; ?>>
                            <?php if (!$has_thumbnail) : ?>
                                <div class="story-icon"><?php echo $category_emoji; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="story-category"><?php echo esc_html($category_name); ?></div>
                        <h3 class="story-title">
                            <?php the_title(); ?>
                        </h3>
                        <p class="story-excerpt">
                            <?php echo esc_html($excerpt); ?>
                        </p>
                        <div class="story-meta"><?php echo $read_time; ?> min read • <?php echo get_the_date('M j, Y'); ?></div>
                    </a>
                </article>
                
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                <!-- Fallback if no featured posts found -->
                <p class="no-stories">No featured stories available.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
    
    <section class="coverage-section">
        <div class="container">
            <h2 class="coverage-title">Coverage Areas</h2>
            
            <div class="categories-grid">
            <?php
                $categories = get_categories(array(
                    'orderby' => 'name',
                    'order' => 'ASC',
                    'hide_empty' => false
                ));
                
                if (!empty($categories)) :
                    foreach ($categories as $category) :
                        $category_emoji = getCategoryEmoji($category->name);
                        $category_description = wp_strip_all_tags($category->description);
                ?>
                <a href="<?php echo get_category_link($category->term_id); ?>">
                    <div class="category-card">
                        <div class="category-icon"><?php echo $category_emoji; ?></div>
                        <h5 class="category-title"><?php echo esc_html($category->name); ?></h5>
                        <p class="category-desc"><?php echo esc_html($category_description ?: 'Category posts'); ?></p>
                    </div>
                </a>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </section>

    <!-- Newsletter CTA -->
    <?php getNewsletter(); ?>
    <?php
  $athletes = new WP_Query([
    'posts_per_page' => 10,
    'post_type' => 'athlete',
    'orderby' => 'date',
    'order' => 'DESC',
  ]);

  if ($athletes->have_posts()) : ?>
    <section class="athletes-section">
      <div class="container">
        <div class="section-header">
          <h2 class="section-title">Athletes</h2>
          <div class="section-subtitle">NIL Valuations</div>
        </div>
        
        <!-- Desktop Table View -->
        <div class="athletes-table-wrapper">
          <table class="athletes-table">
            <thead>
              <tr>
                <th>Rank</th>
                <th>Player</th>
                <th>NIL Valuation</th>
                <th>School</th>
                <th>Sponsors</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $rank = 1;
              while($athletes->have_posts()) {
                $athletes->the_post(); 
                
                // Get ACF fields
                $position = get_field('position');
                $class_year = get_field('class_year') ?: get_field('year');
                $height = get_field('height');
                $weight = get_field('weight');
                $high_school = get_field('high_school');
                $nil_valuation = get_field('nil_valuation') ?: get_field('valuation');
                
                // Get school
                $school = get_field('school');
                $school_id = 0;
                $school_name = '';
                if ($school) {
                  if (is_array($school)) {
                    $school = $school[0];
                  }
                  if (is_object($school) && isset($school->ID)) {
                    $school_id = $school->ID;
                    $school_name = $school->post_title;
                  } elseif (is_numeric($school)) {
                    $school_id = $school;
                    $school_name = get_the_title($school);
                  }
                }
                
                // Get sponsors
                $sponsors = get_field('sponsors');
                $sponsor_images = array();
                if ($sponsors) {
                  if (!is_array($sponsors)) {
                    $sponsors = array($sponsors);
                  }
                  foreach ($sponsors as $sponsor) {
                    $sponsor_id = 0;
                    if (is_object($sponsor) && isset($sponsor->ID)) {
                      $sponsor_id = $sponsor->ID;
                    } elseif (is_numeric($sponsor)) {
                      $sponsor_id = $sponsor;
                    }
                    if ($sponsor_id) {
                      $sponsor_image = get_the_post_thumbnail($sponsor_id, 'thumbnail', array('class' => 'sponsor-logo'));
                      if ($sponsor_image) {
                        $sponsor_images[] = $sponsor_image;
                      }
                    }
                  }
                }
                
                // Format height/weight
                $physical_stats = '';
                if ($height && $weight) {
                  $physical_stats = $height . '/' . $weight;
                } elseif ($height) {
                  $physical_stats = $height;
                } elseif ($weight) {
                  $physical_stats = $weight . ' lbs';
                }
                
                // Format class/year
                $class_display = '';
                if ($class_year) {
                  $class_display = $class_year;
                }
                
                // Build player info line
                $player_info = array();
                if ($class_display) $player_info[] = $class_display;
                if ($physical_stats) $player_info[] = $physical_stats;
                if ($high_school) $player_info[] = $high_school;
              ?>
                <tr>
                  <td>
                    <span class="athlete-rank"><?php echo $rank; ?></span>
                  </td>
                  <td>
                    <div class="athlete-info">
                      <div class="athlete-avatar">
                        <?php if (has_post_thumbnail()) : ?>
                          <?php the_post_thumbnail('thumbnail', array('class' => 'avatar-img')); ?>
                        <?php else : ?>
                          <div class="avatar-placeholder">
                            <span><?php echo strtoupper(substr(get_the_title(), 0, 2)); ?></span>
                          </div>
                        <?php endif; ?>
                      </div>
                      <div class="athlete-details">
                        <div class="athlete-name-row">
                          <a href="<?php the_permalink(); ?>" class="athlete-name">
                            <?php the_title(); ?>
                          </a>
                          <?php if ($position) : ?>
                            <span class="athlete-position"><?php echo esc_html($position); ?></span>
                          <?php endif; ?>
                        </div>
                        <?php if (!empty($player_info)) : ?>
                          <div class="athlete-meta">
                            <?php echo esc_html(implode(' / ', $player_info)); ?>
                          </div>
                        <?php endif; ?>
                      </div>
                    </div>
                  </td>
                  <td>
                    <?php if ($nil_valuation) : ?>
                      <span class="nil-value">
                        <?php 
                        // Format as currency if it's a number
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
                      </span>
                    <?php else : ?>
                      <span class="nil-empty">—</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if ($school_id) : ?>
                      <div class="school-info">
                        <?php 
                        $school_logo = get_the_post_thumbnail($school_id, 'thumbnail', array('class' => 'school-logo'));
                        if ($school_logo) {
                          echo $school_logo;
                        }
                        ?>
                      </div>
                    <?php else : ?>
                      <span class="nil-empty">—</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if (!empty($sponsor_images)) : ?>
                      <div class="sponsors-list">
                        <?php foreach ($sponsor_images as $image) : ?>
                          <div class="sponsor-item"><?php echo $image; ?></div>
                        <?php endforeach; ?>
                      </div>
                    <?php else : ?>
                      <span class="nil-empty">—</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php 
                $rank++;
              } ?>
            </tbody>
          </table>
        </div>
        
        <!-- Mobile Card View -->
        <div class="athletes-mobile">
          <?php 
          rewind_posts();
          $rank = 1;
          while($athletes->have_posts()) {
            $athletes->the_post(); 
            
            // Get ACF fields
            $position = get_field('position');
            $class_year = get_field('class_year') ?: get_field('year');
            $height = get_field('height');
            $weight = get_field('weight');
            $high_school = get_field('high_school');
            $nil_valuation = get_field('nil_valuation') ?: get_field('valuation');
            
            // Get school
            $school = get_field('school');
            $school_id = 0;
            $school_name = '';
            if ($school) {
              if (is_array($school)) {
                $school = $school[0];
              }
              if (is_object($school) && isset($school->ID)) {
                $school_id = $school->ID;
                $school_name = $school->post_title;
              } elseif (is_numeric($school)) {
                $school_id = $school;
                $school_name = get_the_title($school);
              }
            }
            
            // Get sponsors
            $sponsors = get_field('sponsors');
            $sponsor_images = array();
            if ($sponsors) {
              if (!is_array($sponsors)) {
                $sponsors = array($sponsors);
              }
              foreach ($sponsors as $sponsor) {
                $sponsor_id = 0;
                if (is_object($sponsor) && isset($sponsor->ID)) {
                  $sponsor_id = $sponsor->ID;
                } elseif (is_numeric($sponsor)) {
                  $sponsor_id = $sponsor;
                }
                if ($sponsor_id) {
                  $sponsor_image = get_the_post_thumbnail($sponsor_id, 'thumbnail', array('class' => 'sponsor-logo'));
                  if ($sponsor_image) {
                    $sponsor_images[] = $sponsor_image;
                  }
                }
              }
            }
            
            // Format values
            $physical_stats = '';
            if ($height && $weight) {
              $physical_stats = $height . '/' . $weight;
            } elseif ($height) {
              $physical_stats = $height;
            } elseif ($weight) {
              $physical_stats = $weight . ' lbs';
            }
            
            $class_display = $class_year ?: '';
            $player_info = array();
            if ($class_display) $player_info[] = $class_display;
            if ($physical_stats) $player_info[] = $physical_stats;
            if ($high_school) $player_info[] = $high_school;
          ?>
            <article class="athlete-card">
              <div class="athlete-card-header">
                <div class="athlete-card-info">
                  <span class="athlete-rank"><?php echo $rank; ?></span>
                  <div class="athlete-avatar">
                    <?php if (has_post_thumbnail()) : ?>
                      <?php the_post_thumbnail('thumbnail', array('class' => 'avatar-img')); ?>
                    <?php else : ?>
                      <div class="avatar-placeholder">
                        <span><?php echo strtoupper(substr(get_the_title(), 0, 2)); ?></span>
                      </div>
                    <?php endif; ?>
                  </div>
                  <div class="athlete-details">
                    <a href="<?php the_permalink(); ?>" class="athlete-name">
                      <?php the_title(); ?>
                    </a>
                    <div class="athlete-tags">
                      <?php if ($position) : ?>
                        <span class="athlete-position"><?php echo esc_html($position); ?></span>
                      <?php endif; ?>
                    </div>
                    <?php if (!empty($player_info)) : ?>
                      <div class="athlete-meta">
                        <?php echo esc_html(implode(' / ', $player_info)); ?>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
              
              <div class="athlete-card-grid">
                <?php if ($nil_valuation) : ?>
                  <div class="athlete-stat">
                    <span class="stat-label">NIL Valuation</span>
                    <span class="stat-value">
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
                    </span>
                  </div>
                <?php endif; ?>
                
                <?php if ($school_id) : ?>
                  <div class="athlete-stat">
                    <span class="stat-label">School</span>
                    <div class="school-info">
                      <?php 
                      $school_logo = get_the_post_thumbnail($school_id, 'thumbnail', array('class' => 'school-logo'));
                      if ($school_logo) {
                        echo $school_logo;
                      }
                      ?>
                    </div>
                  </div>
                <?php endif; ?>
                
                <?php if (!empty($sponsor_images)) : ?>
                  <div class="athlete-stat">
                    <span class="stat-label">Sponsors</span>
                    <div class="sponsors-list">
                      <?php foreach ($sponsor_images as $image) : ?>
                        <div class="sponsor-item"><?php echo $image; ?></div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
            </article>
          <?php 
            $rank++;
          } ?>
        </div>
      </div>
    </section>
    
    <?php wp_reset_postdata(); ?>
  <?php endif; ?>

</main>

<?php get_footer(); ?>