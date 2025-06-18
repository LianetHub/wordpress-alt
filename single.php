<?php get_header(); ?>
<?php require_once(TEMPLATE_PATH . '_promo.php'); ?>

<section class="article">
    <div class="container">
        <div class="article__content">
            <article class="article__body">
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        the_content();
                    endwhile;
                endif;
                ?>
            </article>
            <aside class="article__sidebar">
                <div class="article__navbar">
                    <?php if (is_active_sidebar('article-toc-sidebar')) {
                        dynamic_sidebar('article-toc-sidebar');
                    }
                    ?>
                </div>
                <div class="article__audit">
                    <div class="article__audit-title">Проведем бесплатный аудит текущих поставок</div>
                    <a href="#audit" data-fancybox class="article__audit-btn btn btn-primary">
                        <span class="pc-only">Отправить действующее КП</span>
                        <span class="mobile-only">Получить аудит</span>
                    </a>
                </div>
            </aside>
        </div>
    </div>
</section>
<?php $current_post_id = get_the_ID();

$args = array(
    'post_type'      => 'post',            // Выбираем только посты
    'posts_per_page' => -1,                 // Количество постов для вывода в слайдере
    'post_status'    => 'publish',         // Только опубликованные посты
    'orderby'        => 'date',            // Сортировка по дате
    'order'          => 'DESC',            // В убывающем порядке (новые сверху)
    'post__not_in'   => array($current_post_id), // Исключаем текущий пост
    'ignore_sticky_posts' => true           // Игнорируем "закрепленные" посты, чтобы они не повторялись, если уже исключены
);

$other_posts_query = new WP_Query($args);

if ($other_posts_query->have_posts()) :
?>
    <section class="blog">
        <div class="container">
            <div class="blog__content">
                <div class="blog__header">
                    <h2 class="blog__title title text-uppercase">Другие публикации</h2>
                    <a href="<?php echo esc_url(get_post_type_archive_link('post')); ?>" class="blog__link more-link icon-arrow">Все публикации</a>
                </div>
                <div class="blog__body">
                    <div class="blog__slider swiper">
                        <div class="swiper-wrapper">
                            <?php while ($other_posts_query->have_posts()) : $other_posts_query->the_post(); ?>
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
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <button type="button" class="blog__slider-prev swiper-button-prev"></button>
                    <button type="button" class="blog__slider-next swiper-button-next"></button>
                </div>
            </div>
        </div>
    </section>
<?php
    wp_reset_postdata();
endif;
?>
<?php get_footer(); ?>