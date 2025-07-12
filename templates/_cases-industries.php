<?php

/**
 * Секция "Наши проекты" без табов.
 */

$project_archive_link = get_post_type_archive_link('project');

$section_title = 'Наши проекты';
$current_project_id = null;
$current_project_industry_slug = '';


$is_project_industry_archive = is_tax('project_industry');
$queried_term = null;

if ($is_project_industry_archive) {
    $queried_term = get_queried_object();

    if ($queried_term) {
        $current_project_industry_slug = $queried_term->slug;
    }
}

?>

<section class="cases">
    <div class="container">
        <div class="cases__content">
            <div class="cases__header">
                <h2 class="cases__title title text-uppercase">
                    <?= $section_title ?>
                </h2>
                <?php if ($project_archive_link) : ?>
                    <a href="<?= esc_url($project_archive_link); ?>" class="cases__link more-link icon-arrow">Все проекты</a>
                <?php endif; ?>
            </div>

            <div class="cases__slider">
                <div class="cases__slider-block swiper">
                    <div class="swiper-wrapper">
                        <?php
                        $args = array(
                            'post_type'      => 'project',
                            'posts_per_page' => -1,
                            'orderby'        => 'date',
                            'order'          => 'DESC',
                        );

                        if (is_singular('project')) {
                            $args['post__not_in'] = array($current_project_id);
                            if (!empty($current_project_industry_slug)) {
                                $args['tax_query'] = array(
                                    array(
                                        'taxonomy' => 'project_industry',
                                        'field'    => 'slug',
                                        'terms'    => $current_project_industry_slug,
                                    ),
                                );
                            }
                        } elseif ($is_project_industry_archive && $queried_term) {

                            $args['tax_query'] = array(
                                array(
                                    'taxonomy' => 'project_industry',
                                    'field'    => 'slug',
                                    'terms'    => $queried_term->slug,
                                ),
                            );
                        }

                        $projects_query = new WP_Query($args);

                        if ($projects_query->have_posts()) :
                            while ($projects_query->have_posts()) : $projects_query->the_post();
                                $project_location = get_field('project_location');
                                $delivery_contract_days = get_field('delivery_contract_days');
                                $delivery_actual_days = get_field('delivery_actual_days');

                                $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                $thumbnail_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
                                if (empty($thumbnail_alt)) {
                                    $thumbnail_alt = get_the_title();
                                }
                        ?>
                                <div class="case swiper-slide">
                                    <div class="case__main">
                                        <div class="case__name title-sm"><?= esc_html(get_the_title()); ?></div>
                                        <?php if (!empty($project_location)) : ?>
                                            <div class="case__location icon-location">
                                                <div class="case__location-caption">Регион поставки:</div>
                                                <address class="case__location-address"><?= esc_html($project_location); ?></address>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (get_the_content()) : ?>
                                            <p class="case__desc"><?= wp_trim_words(get_the_content(), 30, '...'); ?></p>
                                        <?php endif; ?>
                                        <div class="case__footer">
                                            <?php if (!empty($delivery_contract_days) || !empty($delivery_actual_days)) : ?>
                                                <div class="case__time">
                                                    <div class="case__time-caption">Срок поставки договор/факт:</div>
                                                    <div class="case__time-value title-sm">
                                                        <?php
                                                        if (!empty($delivery_contract_days)) {
                                                            echo esc_html($delivery_contract_days) . ' ' . plural_days($delivery_contract_days);
                                                        }
                                                        if (!empty($delivery_contract_days) && !empty($delivery_actual_days)) {
                                                            echo '/';
                                                        }
                                                        if (!empty($delivery_actual_days)) {
                                                            echo esc_html($delivery_actual_days) . ' ' . plural_days($delivery_actual_days);
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <a href="<?= esc_url(get_permalink()); ?>" class="case__btn btn btn-primary btn-lg">Подробнее</a>
                                        </div>
                                    </div>
                                    <div class="case__image">
                                        <?php if ($thumbnail_url) : ?>
                                            <img src="<?= esc_url($thumbnail_url); ?>" class="cover-image" alt="<?= esc_attr($thumbnail_alt); ?>">
                                        <?php else : ?>
                                            <img src="<?= esc_url(get_template_directory_uri() . '/assets/img/default-project.jpg'); ?>" class="cover-image" alt="Изображение проекта отсутствует">
                                        <?php endif; ?>
                                    </div>
                                </div>
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                            if ($is_project_industry_archive && $queried_term) {
                                echo '<p>В отрасли "' . esc_html($queried_term->name) . '" пока нет проектов.</p>';
                            } elseif (is_singular('project')) {
                                echo '<p>В этой отрасли нет других проектов.</p>';
                            } else {
                                echo '<p>Проекты пока не добавлены.</p>';
                            }
                        endif;
                        ?>
                    </div>
                </div>
                <?php if ($projects_query->have_posts()) : ?>
                    <button type="button" class="cases__slider-prev swiper-button-prev"></button>
                    <button type="button" class="cases__slider-next swiper-button-next"></button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>