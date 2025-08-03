<?php

/**
 * Секция "Наши проекты" с табами по отраслям.
 */

// Получаем все термины таксономии 'project_industry'
$project_industries = get_terms(array(
    'taxonomy'   => 'project_industry',
    'hide_empty' => true, // Не показывать отрасли, к которым не привязан ни один проект
    'orderby'    => 'name',
    'order'      => 'ASC',
));

$project_archive_link = get_post_type_archive_link('project');

$section_title = 'Наши проекты';
$current_project_id = null;
$current_project_industry_slug = '';


if (is_singular('project')) {
    $section_title = 'Другие проекты';
    $current_project_id = get_the_ID();


    $terms = get_the_terms($current_project_id, 'project_industry');
    if ($terms && !is_wp_error($terms)) {

        $current_project_industry_slug = $terms[0]->slug;
    }
}

?>

<section class="cases">
    <div class="container">
        <div class="cases__content tabs-wrapper">
            <div class="cases__header">
                <h2 class="cases__title title text-uppercase">
                    <?= $section_title ?>
                </h2>
                <?php if ($project_archive_link) : ?>
                    <a href="<?= esc_url($project_archive_link); ?>" class="cases__link more-link icon-arrow">Все проекты</a>
                <?php endif; ?>
            </div>

            <?php if (!empty($project_industries) && !is_wp_error($project_industries)) : ?>
                <div class="cases__tabs">
                    <div class="cases__tabs-slider swiper">
                        <div class="swiper-wrapper">
                            <?php
                            $default_active_tab_slug = !empty($current_project_industry_slug) ? $current_project_industry_slug : ($project_industries[0]->slug ?? '');
                            ?>
                            <?php foreach ($project_industries as $term) : ?>
                                <button type="button" class="cases__tab-btn tabs__item swiper-slide <?= ($term->slug === $default_active_tab_slug) ? 'active' : ''; ?>" data-tab="<?= esc_attr($term->slug); ?>">
                                    <?= esc_html($term->name); ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                        <div class="cases__tabs-scrollbar swiper-scrollbar"></div>
                    </div>
                    <div class="cases__tabs-controls">
                        <button type="button" class="cases__tabs-prev swiper-button-prev"></button>
                        <button type="button" class="cases__tabs-next swiper-button-next"></button>
                    </div>
                </div>

                <div class="cases__tabs-content">
                    <?php foreach ($project_industries as $term) : ?>
                        <div class="cases__tabs-block tab-content <?= ($term->slug === $default_active_tab_slug) ? 'active' : ''; ?>" data-tab-content="<?= esc_attr($term->slug); ?>">
                            <div class="cases__slider">
                                <div class="cases__slider-block swiper">
                                    <div class="swiper-wrapper">
                                        <?php
                                        $args = array(
                                            'post_type'      => 'project',
                                            'posts_per_page' => -1,
                                            'tax_query'      => array(
                                                array(
                                                    'taxonomy' => 'project_industry',
                                                    'field'    => 'slug',
                                                    'terms'    => $term->slug,
                                                ),
                                            ),
                                            'orderby'        => 'date',
                                            'order'          => 'DESC',
                                        );

                                        if ($current_project_id) {
                                            $args['post__not_in'] = array($current_project_id);
                                        }

                                        $projects_query = new WP_Query($args);

                                        if ($projects_query->have_posts()) :
                                            while ($projects_query->have_posts()) : $projects_query->the_post();
                                                $project_location = get_field('project_location');
                                                $delivery_contract_days = get_field('delivery_contract_days');
                                                $delivery_actual_days = get_field('delivery_actual_days');

                                                $delivery_contract_days_num = (int) preg_replace('/[^0-9]/', '', $delivery_contract_days);
                                                $delivery_actual_days_num = (int) preg_replace('/[^0-9]/', '', $delivery_actual_days);


                                                $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                                $thumbnail_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
                                                if (empty($thumbnail_alt)) {
                                                    $thumbnail_alt = get_the_title();
                                                }
                                        ?>
                                                <div class="case swiper-slide">
                                                    <div class="case__main">
                                                        <a href="<?= esc_url(get_permalink()); ?>" class="case__name title-sm"><?= esc_html(get_the_title()); ?></a>
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

                                                                            echo esc_html($delivery_contract_days) . ' ' . plural_days($delivery_contract_days_num);
                                                                        }
                                                                        if (!empty($delivery_contract_days) && !empty($delivery_actual_days)) {
                                                                            echo '/';
                                                                        }
                                                                        if (!empty($delivery_actual_days)) {

                                                                            echo esc_html($delivery_actual_days) . ' ' . plural_days($delivery_actual_days_num);
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            <?php endif; ?>
                                                            <a href="<?= esc_url(get_permalink()); ?>" class="case__btn btn btn-primary btn-lg">Подробнее</a>
                                                        </div>
                                                    </div>
                                                    <a href="<?= esc_url(get_permalink()); ?>" class="case__image">
                                                        <?php if ($thumbnail_url) : ?>
                                                            <img src="<?= esc_url($thumbnail_url); ?>" class="cover-image" alt="<?= esc_attr($thumbnail_alt); ?>">
                                                        <?php else : ?>
                                                            <img src="<?= esc_url(get_template_directory_uri() . '/assets/img/default-project.jpg'); ?>" class="cover-image" alt="Изображение проекта отсутствует">
                                                        <?php endif; ?>
                                                    </a>
                                                </div>
                                        <?php
                                            endwhile;
                                            wp_reset_postdata();
                                        else :
                                            if ($current_project_id && $term->slug === $current_project_industry_slug) {
                                                echo '<p>В этой отрасли нет других проектов.</p>';
                                            } else {
                                                echo '<p>В этой отрасли пока нет проектов.</p>';
                                            }
                                        endif;
                                        ?>
                                    </div>
                                </div>
                                <button type="button" class="cases__slider-prev swiper-button-prev"></button>
                                <button type="button" class="cases__slider-next swiper-button-next"></button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p>Отрасли проектов пока не добавлены.</p>
            <?php endif; ?>
        </div>
    </div>
</section>