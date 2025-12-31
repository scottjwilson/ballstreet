<?php
/**
 * Template part for displaying post cards
 * 
 * @var array $post_data Post data from get_post_card_data()
 */
$post_data = get_query_var('post_data', null);
if (!$post_data) {
    $post_data = get_post_card_data();
}
?>

<article class="article-card">
    <a href="<?php echo esc_url($post_data['permalink']); ?>" class="article-link">
        <div class="article-content">
            <?php if ($post_data['has_thumbnail']) : ?>
                <div class="article-image">
                    <?php echo $post_data['thumbnail']; ?>
                </div>
            <?php endif; ?>
            <div class="article-body <?php echo $post_data['has_thumbnail'] ? 'has-image' : 'no-image'; ?>">
                <h2 class="article-title">
                    <?php echo esc_html($post_data['title']); ?>
                </h2>
                <?php if ($post_data['date']) : ?>
                    <p class="article-date">
                        <?php echo esc_html($post_data['date']); ?>
                    </p>
                <?php endif; ?>
                <?php if ($post_data['excerpt']) : ?>
                    <p class="article-excerpt">
                        <?php echo esc_html($post_data['excerpt']); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </a>
</article>

