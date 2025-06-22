<?php

/**
 * Template Name: Industries Page Template
 */
?>
<?php
get_header();
?>

<?php require_once(TEMPLATE_PATH . '_promo.php'); ?>
<?php
$terms = get_terms(array(
    'taxonomy'   => 'project_industry',
    'hide_empty' => false,
    'orderby'    => 'name',
    'order'      => 'ASC',
));

if (!empty($terms) && !is_wp_error($terms)) :
?>
    <div class="industries">
        <div class="container">
            <div class="industries__body">
                <ul class="industries__list">
                    <?php foreach ($terms as $term) :
                        $term_name = esc_html($term->name);
                        $term_link = esc_url(get_term_link($term));

                        $background_image_url = get_field('promo_background', 'project_industry_' . $term->term_id) ?? '';

                        $caption_text = $term_name;
                        $link_url = $term_link;
                        $link_title = $term_name;
                        $link_target = '_self';
                    ?>
                        <a href="<?php echo esc_url($link_url); ?>" class="industries__slide" target="<?php echo esc_attr($link_target); ?>" title="<?php echo esc_attr($link_title); ?>">
                            <? if ($background_image_url) : ?>
                                <img src="<?php echo esc_url($background_image_url); ?>" class="cover-image" alt="<?php echo esc_attr($caption_text); ?>">
                            <?php endif; ?>
                            <span class="industries__slide-caption title-sm"><?php echo esc_html($caption_text); ?></span>
                        </a>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php require_once(TEMPLATE_PATH . '_callback.php'); ?>



<?php get_footer(); ?>