<?php
/**
 * Template part for displaying post header
 * 
 * @var array $post_data Post data from get_single_post_data()
 */
$post_data = get_query_var('post_data', null);
if (!$post_data) {
    $post_data = get_single_post_data();
}
?>

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
            <?php if (!empty($post_data['categories']['first_two'])) : ?>
                <?php foreach ($post_data['categories']['first_two'] as $category) : ?>
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
        <?php if ($post_data['athlete']['id']) : ?>
            <div class="athlete-card-wrapper">
                <a href="<?php echo esc_url($post_data['athlete']['permalink']); ?>" class="athlete-link-card">
                    <?php if ($post_data['athlete']['image']) : ?>
                        <?php echo $post_data['athlete']['image']; ?>
                    <?php else : ?>
                        <div class="athlete-thumb-placeholder">
                            <span><?php echo strtoupper(substr($post_data['athlete']['name'], 0, 2)); ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="athlete-link-info">
                        <div class="athlete-link-label">Related Athlete</div>
                        <div class="athlete-link-name">
                            <?php echo esc_html($post_data['athlete']['name']); ?>
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

