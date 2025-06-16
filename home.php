<?php get_header(); ?>

<?php require_once(TEMPLATE_PATH . '_promo.php'); ?>

<div class="blog blog--white">
    <div class="container">
        <div class="blog__content">
            <div class="blog__body">
                <ul class="blog__list">
                    <?php
                    $args = array(
                        'post_type'      => 'post',            // Выбираем только посты
                        'posts_per_page' => 9,                 // Количество постов для вывода на главной (можно настроить)
                        'post_status'    => 'publish',         // Только опубликованные посты
                        'orderby'        => 'date',            // Сортировка по дате
                        'order'          => 'DESC',            // В убывающем порядке (новые сверху)
                        'ignore_sticky_posts' => true           // Игнорируем "закрепленные" посты
                    );

                    $home_posts_query = new WP_Query($args);

                    if ($home_posts_query->have_posts()) :
                        while ($home_posts_query->have_posts()) : $home_posts_query->the_post();
                    ?>
                            <li class="blog__item">
                                <a href="<?php the_permalink(); ?>" class="blog__item-poster">
                                    <?php
                                    if (has_post_thumbnail()) {
                                        the_post_thumbnail('full', array('class' => 'cover-image'));
                                    } else {

                                        echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/img/default-article-placeholder.png') . '" class="cover-image" alt="Изображение по умолчанию">';
                                    }
                                    ?>
                                </a>
                                <div class="blog__item-body">
                                    <time datetime="<?= get_russian_post_date(get_the_ID(), 'datetime'); ?>" class="blog__item-time"><?= esc_html(get_russian_post_date(get_the_ID())); ?></time>
                                    <a href="<?php the_permalink(); ?>" class="blog__item-title title-sm"><?php the_title(); ?></a>
                                </div>
                            </li>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        echo '<p>Пока нет доступных статей.</p>';
                    endif;
                    ?>
                </ul>
                <?php
                $total_posts = wp_count_posts('post')->publish;
                if ($total_posts > $args['posts_per_page']) :
                ?>
                    <a href="" class="blog__more btn btn-primary btn-lg">Показать еще</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once(TEMPLATE_PATH . '_callback.php'); ?>

<?php get_footer(); ?>