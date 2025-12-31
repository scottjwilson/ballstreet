<?php
/**
 * Template part for displaying related posts
 * 
 * @var array $related_posts Related posts data from get_related_posts()
 */
$related_posts = get_query_var('related_posts', array());
if (empty($related_posts)) {
    return;
}
?>

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

