<?php get_header(); ?>

<main class="site-main">
    <!-- Header Section -->
    <?php getHeaderSection('Athletes', 'Browse all athletes and their NIL valuations'); ?>
    <!-- Athletes List Section -->
    <section class="athletes-archive-section">
        <div class="container">
            <?php if (have_posts()) : ?>
                <div class="athletes-archive-list">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php 
                        $fields = get_athlete_fields();
                        ?>
                        <article class="athlete-archive-card">
                            <a href="<?php the_permalink(); ?>" class="athlete-archive-link">
                                <div class="athlete-archive-content">
                                    <!-- Athlete Image -->
                                    <div class="athlete-archive-image">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('medium', array('class' => 'athlete-archive-thumb')); ?>
                                        <?php else : ?>
                                            <div class="athlete-archive-placeholder">
                                                <span><?php echo strtoupper(substr(get_the_title(), 0, 2)); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Athlete Info -->
                                    <div class="athlete-archive-info">
                                        <div class="athlete-archive-main">
                                            <div class="athlete-archive-details">
                                                <h3 class="athlete-archive-name">
                                                    <?php the_title(); ?>
                                                </h3>
                                                <div class="athlete-archive-meta">
                                                    <?php if ($fields['position']) : ?>
                                                        <span class="meta-item"><?php echo esc_html($fields['position']); ?></span>
                                                    <?php endif; ?>
                                                    <?php if ($fields['class_year']) : ?>
                                                        <span class="meta-separator">•</span>
                                                        <span class="meta-item"><?php echo esc_html($fields['class_year']); ?></span>
                                                    <?php endif; ?>
                                                    <?php if ($fields['physical_stats']) : ?>
                                                        <span class="meta-separator">•</span>
                                                        <span class="meta-item"><?php echo esc_html($fields['physical_stats']); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <div class="athlete-archive-additional">
                                                    <?php if ($fields['school_id']) : ?>
                                                        <div class="school-info-archive">
                                                            <?php 
                                                            $school_logo = get_the_post_thumbnail($fields['school_id'], 'thumbnail', array('class' => 'school-logo-small'));
                                                            if ($school_logo) {
                                                                echo $school_logo;
                                                            }
                                                            ?>
                                                            <span class="school-name-small"><?php echo esc_html($fields['school_name']); ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <?php if (!empty($fields['sponsor_images'])) : ?>
                                                        <div class="sponsors-info-archive">
                                                            <span class="sponsors-label">Sponsors:</span>
                                                            <div class="sponsors-logos">
                                                                <?php foreach ($fields['sponsor_images'] as $image) : ?>
                                                                    <div class="sponsor-logo-small"><?php echo $image; ?></div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            
                                            <!-- NIL Valuation -->
                                            <div class="nil-badge">
                                                <?php if ($fields['nil_valuation']) : ?>
                                                    <div class="nil-badge-filled">
                                                        <div class="nil-badge-label">NIL Value</div>
                                                        <div class="nil-badge-value">
                                                            <?php echo format_nil_valuation($fields['nil_valuation']); ?>
                                                        </div>
                                                    </div>
                                                <?php else : ?>
                                                    <div class="nil-badge-empty">
                                                        <div class="nil-badge-label">NIL Value</div>
                                                        <div class="nil-badge-value">—</div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Arrow Icon -->
                                    <div class="athlete-archive-arrow">
                                        <svg class="arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </article>
                    <?php endwhile; ?>
                </div>
                
                <!-- Pagination -->
                <div class="archive-pagination">
                    <?php
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => __('← Previous', 'ball-street'),
                        'next_text' => __('Next →', 'ball-street'),
                    ));
                    ?>
                </div>
            <?php else : ?>
                <div class="no-athletes">
                    <p>No athletes found.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>