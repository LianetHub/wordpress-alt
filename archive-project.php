<?php
get_header();
?>

<?php require_once(TEMPLATE_PATH . '_promo.php'); ?>

<div class="cases cases--page">
    <div class="container">
        <div class="cases__list" id="projects-list">
            <?php

            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $current_filter_slug = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : '';

            if (empty($current_filter_slug) && is_tax('project_industry')) {
                $queried_object = get_queried_object();
                if ($queried_object instanceof WP_Term) {
                    $current_filter_slug = $queried_object->slug;
                }
            }

            $posts_per_page = 4;

            $args = array(
                'post_type'      => 'project',
                'posts_per_page' => $posts_per_page,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
                'paged'          => $paged,
            );

            if (!empty($current_filter_slug)) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'project_industry',
                        'field'    => 'slug',
                        'terms'    => $current_filter_slug,
                    ),
                );
            }

            $projects_query = new WP_Query($args);

            if ($projects_query->have_posts()) :
                while ($projects_query->have_posts()) : $projects_query->the_post();
                    $project_location = get_field('project_location');
                    $delivery_contract_days = get_field('delivery_contract_days');
                    $delivery_actual_days = get_field('delivery_actual_days');

                    $thumbnail_id = get_post_thumbnail_id();
                    $thumbnail_url = $thumbnail_id ? wp_get_attachment_image_url($thumbnail_id, 'full') : '';
                    $thumbnail_alt = $thumbnail_id ? get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true) : '';

                    if (empty($thumbnail_alt)) {
                        $thumbnail_alt = get_the_title();
                    }
            ?>
                    <div class="case">
                        <div class="case__main">
                            <a href="<?php the_permalink(); ?>" class="case__name title-sm"><?php the_title(); ?></a>
                            <?php if (!empty($project_location)) : ?>
                                <div class="case__location icon-location">
                                    <div class="case__location-caption">Регион поставки:</div>
                                    <address class="case__location-address"><?php echo esc_html($project_location); ?></address>
                                </div>
                            <?php endif; ?>
                            <div class="case__desc"><?php the_excerpt(); ?></div>
                            <div class="case__footer">
                                <?php
                                $has_contract_time = !empty($delivery_contract_days);
                                $has_actual_time = !empty($delivery_actual_days);

                                if ($has_contract_time || $has_actual_time) :
                                ?>
                                    <div class="case__time">
                                        <div class="case__time-caption">Срок поставки договор/факт:</div>
                                        <div class="case__time-value title-sm">
                                            <?php
                                            if ($has_contract_time) {
                                                echo esc_html($delivery_contract_days) . ' ' . plural_days($delivery_contract_days);
                                            }
                                            if ($has_contract_time && $has_actual_time) {
                                                echo '/';
                                            }
                                            if ($has_actual_time) {
                                                echo esc_html($delivery_actual_days) . ' ' . plural_days($delivery_actual_days);
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <a href="<?php the_permalink(); ?>" class="case__btn more-link icon-arrow">Подробнее о проекте</a>
                            </div>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="case__image">
                            <?php if ($thumbnail_url) : ?>
                                <img src="<?php echo esc_url($thumbnail_url); ?>" class="cover-image" alt="<?php echo esc_attr($thumbnail_alt); ?>">
                            <?php else : ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder.jpg" class="cover-image" alt="Изображение не найдено">
                            <?php endif; ?>
                        </a>
                    </div>
            <?php
                endwhile;
            else :
                echo '<p>По выбранным критериям проекты не найдены.</p>';
            endif;
            ?>
        </div>

        <?php

        if ($projects_query->max_num_pages > $paged) :

            $next_page_url = get_pagenum_link($paged + 1);
            if (!empty($current_filter_slug)) {
                $next_page_url = add_query_arg('type', $current_filter_slug, $next_page_url);
            }
        ?>
            <button type="button"
                class="cases__more btn btn-primary btn-lg"
                id="load-more-projects"
                data-current-page="<?php echo esc_attr($paged); ?>"
                data-posts-per-page="<?php echo esc_attr($posts_per_page); ?>"
                data-max-pages="<?php echo esc_attr($projects_query->max_num_pages); ?>"
                data-next-page-url="<?php echo esc_url($next_page_url); ?>"
                data-industry-filter="<?php echo esc_attr($current_filter_slug); ?>"
                data-loading-text="Загрузка...">Показать еще</button>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
    </div>
</div>

<?php require_once(TEMPLATE_PATH . '_callback.php'); ?>
<?php get_footer(); ?>