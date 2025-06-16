<section class="blog">
    <div class="container">
        <div class="blog__content">
            <div class="blog__header">
                <h2 class="blog__title title text-uppercase">Блог</h2>
                <a href="<?php echo esc_url(get_post_type_archive_link('post')); ?>" class="blog__link more-link icon-arrow">Все публикации</a>
            </div>
            <div class="blog__body">
                <div class="blog__slider swiper">
                    <div class="swiper-wrapper">
                        <?php
                        $args = array(
                            'post_type'      => 'post',            // Выбираем только посты
                            'posts_per_page' => -1,                // Выводим все доступные посты
                            'post_status'    => 'publish',         // Только опубликованные посты
                            'orderby'        => 'date',            // Сортировка по дате
                            'order'          => 'DESC',            // В убывающем порядке (новые сверху)
                            'ignore_sticky_posts' => true           // Игнорируем "закрепленные" посты
                        );

                        $all_posts_query = new WP_Query($args);

                        if ($all_posts_query->have_posts()) :
                            while ($all_posts_query->have_posts()) : $all_posts_query->the_post();
                        ?>
                                <div class="blog__item swiper-slide">
                                    <a href="<?php the_permalink(); ?>" class="blog__item-poster">
                                        <?php

                                        if (has_post_thumbnail()) {
                                            the_post_thumbnail('full', array('class' => 'cover-image'));
                                        } else {

                                            echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/img/default-article-placeholder.png') . '" class="cover-image" alt="Изображение по умолчанию">';
                                        }
                                        ?>
                                    </a>

                                    <time datetime="<?= get_russian_post_date(get_the_ID(), 'datetime'); ?>" class="blog__item-time"><?= esc_html(get_russian_post_date(get_the_ID())); ?></time>
                                    <a href="<?php the_permalink(); ?>" class="blog__item-title title-sm"><?php the_title(); ?></a>
                                    <a href="<?php the_permalink(); ?>" class="blog__item-btn btn btn-primary btn-lg">Подробнее</a>
                                </div>
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                            echo '<p>Пока нет доступных статей.</p>';
                        endif;
                        ?>
                    </div>
                </div>
                <button type="button" class="blog__slider-prev swiper-button-prev"></button>
                <button type="button" class="blog__slider-next swiper-button-next"></button>
            </div>
        </div>
    </div>
</section>