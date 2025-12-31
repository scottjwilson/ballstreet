<?php
/**
 * Template part for displaying athlete cards
 * 
 * @var array $athlete_data Athlete data from get_athlete_card_data()
 */
if (!isset($athlete_data)) {
    $athlete_data = get_athlete_card_data();
}
?>

<article class="athlete-card">
    <a href="<?php echo esc_url($athlete_data['permalink']); ?>" class="athlete-link">
        <?php if ($athlete_data['has_thumbnail']) : ?>
            <div class="athlete-image">
                <?php echo $athlete_data['thumbnail']; ?>
            </div>
        <?php else : ?>
            <div class="athlete-placeholder">
                <span><?php echo strtoupper(substr($athlete_data['title'], 0, 2)); ?></span>
            </div>
        <?php endif; ?>
        <div class="athlete-info">
            <h3 class="athlete-name"><?php echo esc_html($athlete_data['title']); ?></h3>
            <?php if ($athlete_data['position']) : ?>
                <p class="athlete-position"><?php echo esc_html($athlete_data['position']); ?></p>
            <?php endif; ?>
            <?php if ($athlete_data['nil_valuation']) : ?>
                <div class="athlete-nil">
                    <?php echo format_nil_valuation($athlete_data['nil_valuation']); ?>
                </div>
            <?php endif; ?>
        </div>
    </a>
</article>

