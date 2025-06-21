<?php

/**
 * Template Name: Reviews Page Template
 */
?>
<?php
get_header();
?>

<?php require_once(TEMPLATE_PATH . '_promo.php'); ?>
<?php if (have_rows('reviews', 'option')): ?>
    <div class="reviews reviews--white">
        <div class="container">
            <ul class="reviews__list">
                <?php while (have_rows('reviews', 'option')): the_row();

                    $review_image = get_sub_field('review_image');
                    $review_company_name = get_sub_field('review_company_name');
                    $review_author = get_sub_field('review_author');
                    $review_company_desc = get_sub_field('review_company_desc');
                    $related_project = get_sub_field('review_related_project');

                    $image_url = $review_image['url'] ?? '';
                    $image_alt_text = $review_image['alt'] ?? '';

                    $project_link = '';

                    if ($related_project) {
                        $project_link = get_permalink($related_project[0]->ID);
                    }

                    if (empty($image_alt_text)) {
                        $image_alt_text = $review_image['title'] ?? 'Изображение отзыва';
                    }
                ?>
                    <li class="review">
                        <div class="review__body">
                            <?php if (!empty($review_company_name)): ?>
                                <div class="review__company title-sm"><?= $review_company_name ?></div>
                            <?php endif; ?>
                            <?php if (!empty($review_author)): ?>
                                <div class="review__author"><?= $review_author ?></div>
                            <?php endif; ?>
                            <?php if (!empty($review_company_desc)): ?>
                                <div class="review__desc"><?= $review_company_desc ?></div>
                            <?php endif; ?>
                            <?php if (!empty($project_link)): ?>
                                <a href="<?= esc_url($project_link); ?>" class="review__link more-link icon-arrow">Подробнее о проекте</a>
                            <?php endif; ?>
                        </div>
                        <a href="<?php echo esc_url($image_url); ?>" data-fancybox class="review__image">
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt_text); ?>">
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>
<?php require_once(TEMPLATE_PATH . '_callback.php'); ?>



<?php get_footer(); ?>