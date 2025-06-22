<?php
get_header();
?>

<?php require_once(TEMPLATE_PATH . '_promo.php'); ?>

<div class="cases cases--page">
    <div class="container">
        <?php

        $current_term_slug = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : '';


        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        if (isset($_GET['paged']) && intval($_GET['paged']) > 0) {
            $paged = intval($_GET['paged']);
        }




        $terms = get_terms(array(
            'taxonomy'   => 'project_industry',
            'hide_empty' => true,
        ));

        $archive_base_url = esc_url(get_post_type_archive_link('project'));
        ?>
        <div class="promo__select">
            <select name="industry-filter" class="select project-filter-select">
                <option value="" <?= empty($current_term_slug) ? 'selected' : ''; ?>>
                    Все отрасли
                </option>
                <?php
                if (!empty($terms) && !is_wp_error($terms)) {
                    foreach ($terms as $term) {
                        $selected = ($current_term_slug === $term->slug) ? 'selected' : '';
                        echo '<option value="' . esc_attr($term->slug) . '" ' . $selected . '>' . esc_html($term->name) . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <br>
        <br>
        <div class="cases__list" id="projects-list">
            <?php
            // Проверка, если мы на странице таксономии, но без параметра 'type' в URL.
            // Это может произойти, если WP сам обрабатывает /project_industry/slug/
            if (empty($current_term_slug) && is_tax('project_industry')) {
                $queried_object = get_queried_object();
                if ($queried_object instanceof WP_Term) {
                    $current_term_slug = $queried_object->slug;
                }
            }

            $posts_per_page = 4; // Количество постов на страницу

            $args = array(
                'post_type'      => 'project',
                'posts_per_page' => $posts_per_page,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
                'paged'          => $paged, // Используем текущую страницу
            );

            if (!empty($current_term_slug)) { // Используем $current_term_slug для запроса
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'project_industry',
                        'field'    => 'slug',
                        'terms'    => $current_term_slug,
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
        // Важно: передаем текущую страницу, которая была запрошена, а не projects_query->get('paged')
        // projects_query->get('paged') может быть 0, если это таксономия и paged не установлен.
        $current_page_for_data = $paged;

        if ($projects_query->max_num_pages > $current_page_for_data) :
            // Ссылка для следующей страницы формируется для Ajax-а, так что она не нужна
            // $next_page_url = get_pagenum_link($current_page_for_data + 1);
            // if (!empty($current_term_slug)) {
            //     $next_page_url = add_query_arg('type', $current_term_slug, $next_page_url);
            // }
        ?>
            <button type="button"
                class="cases__more btn btn-primary btn-lg"
                id="load-more-projects"
                data-current-page="<?php echo esc_attr($current_page_for_data); ?>"
                data-posts-per-page="<?php echo esc_attr($posts_per_page); ?>"
                data-max-pages="<?php echo esc_attr($projects_query->max_num_pages); ?>"
                data-industry-filter="<?php echo esc_attr($current_term_slug); ?>"
                data-loading-text="Загрузка...">Показать еще</button>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
    </div>
</div>

<?php require_once(TEMPLATE_PATH . '_callback.php'); ?>
<?php get_footer(); ?>