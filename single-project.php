<?php

/**
 * Custom Post Type: project.
 */


get_header(); ?>

<?php require_once(TEMPLATE_PATH . '_promo.php'); ?>
<div class="cases cases--page ">
    <div class="container">
        <?php
        if (have_posts()) :
            while (have_posts()) :
                the_post();

                $project_location = get_field('project_location');

                $total_amount = get_field('total_amount');
                $delivery_contract_days = get_field('delivery_contract_days');
                $delivery_actual_days = get_field('delivery_actual_days');


                $project_industries = get_the_terms(get_the_ID(), 'project_industry');
                $organization_category_name = '';

                if (!empty($project_industries) && !is_wp_error($project_industries)) {

                    $first_term = array_shift($project_industries);
                    $organization_category_name = $first_term->name;
                }


                $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                $thumbnail_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
                if (empty($thumbnail_alt)) {
                    $thumbnail_alt = get_the_title();
                }
        ?>
                <div id="post-<?php the_ID(); ?>" <?php post_class('case case--single'); ?>>
                    <div class="case__main">
                        <?php if (!empty($project_location)) : ?>
                            <div class="case__location icon-location">
                                <div class="case__location-caption">Регион поставки:</div>
                                <address class="case__location-address"><?= esc_html($project_location); ?></address>
                            </div>
                        <?php endif; ?>

                        <?php if (get_the_content()) : ?>
                            <div class="case__desc">
                                <?php the_content(); ?>
                            </div>
                        <?php endif; ?>

                        <?php

                        $has_properties = false;
                        if (!empty($organization_category_name) || !empty($total_amount) || !empty($contract_days) || !empty($actual_days)) {
                            $has_properties = true;
                        }

                        if ($has_properties) : ?>
                            <ul class="case__list">
                                <?php if (!empty($organization_category_name)) : ?>
                                    <li class="case__property">
                                        <div class="case__property-name">Категория организации:</div>
                                        <div class="case__property-value"><?= esc_html($organization_category_name); ?></div>
                                    </li>
                                <?php endif; ?>

                                <?php if (!empty($total_amount)) : ?>
                                    <li class="case__property">
                                        <div class="case__property-name">Сумма общая:</div>
                                        <div class="case__property-value"><?= number_format($total_amount, 2, ',', ' '); ?> руб.</div>
                                    </li>
                                <?php endif; ?>

                                <?php if (!empty($delivery_contract_days)) : ?>
                                    <li class="case__property">
                                        <div class="case__property-name">Срок выполнения по договору:</div>
                                        <div class="case__property-value"><?= esc_html($delivery_contract_days) . ' ' . plural_days($contract_days); ?></div>
                                    </li>
                                <?php endif; ?>

                                <?php if (!empty($delivery_actual_days)) : ?>
                                    <li class="case__property">
                                        <div class="case__property-name">Срок выполнения фактический:</div>
                                        <div class="case__property-value"><?= esc_html($delivery_actual_days) . ' ' . plural_days($actual_days); ?></div>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        <?php endif; ?>

                    </div>

                    <?php if ($thumbnail_url) : ?>
                        <a href="<?= esc_url($thumbnail_url); ?>" data-fancybox class="case__image">
                            <img src="<?= esc_url($thumbnail_url); ?>" class="cover-image" alt="<?= esc_attr($thumbnail_alt); ?>">
                        </a>
                    <?php endif; ?>
                </div>

        <?php
            endwhile;
        endif;
        ?>

    </div>
</div>

<?php

$found_review = false;
if (have_rows('reviews', 'option')):
    while (have_rows('reviews', 'option')): the_row();
        $related_projects_from_acf = get_sub_field('review_related_project');
        $current_project_id = get_the_ID();


        if (
            !empty($related_projects_from_acf) &&
            is_array($related_projects_from_acf) &&
            isset($related_projects_from_acf[0]) &&
            $related_projects_from_acf[0] instanceof WP_Post &&
            $related_projects_from_acf[0]->ID === $current_project_id
        ) {
            $review_image = get_sub_field('review_image');
            $review_company_name = get_sub_field('review_company_name');
            $review_author = get_sub_field('review_author');
            $review_company_desc = get_sub_field('review_company_desc');

            $image_url = $review_image['url'] ?? '';
            $image_alt_text = $review_image['alt'] ?? '';

            if (empty($image_alt_text)) {
                $image_alt_text = $review_image['title'] ?? 'Изображение отзыва';
            }
?>
            <div class="reviews">
                <div class="container">
                    <div class="review">
                        <?php if ($image_url): ?>
                            <a href="<?= esc_url($image_url); ?>" data-fancybox="" class="review__image">
                                <img src="<?= esc_url($image_url); ?>" alt="<?= esc_attr($image_alt_text); ?>">
                            </a>
                        <?php endif; ?>
                        <div class="review__body">
                            <?php if (!empty($review_company_name)): ?>
                                <div class="review__company title-sm"><?= esc_html($review_company_name) ?></div>
                            <?php endif; ?>
                            <?php if (!empty($review_author)): ?>
                                <div class="review__author"><?= esc_html($review_author) ?></div>
                            <?php endif; ?>
                            <?php if (!empty($review_company_desc)): ?>
                                <div class="review__desc"><?= wp_kses_post($review_company_desc) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
<?php
            $found_review = true;
            break;
        }
    endwhile;
endif;
// КОНЕЦ БЛОКА ВЫВОДА СВЯЗАННОГО ОТЗЫВА
?>
<?php
require_once(TEMPLATE_PATH . '_cases.php');
require_once(TEMPLATE_PATH . '_offer.php');
?>

<?php get_footer(); ?>

<?php
