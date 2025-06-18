<?php get_header(); ?>
<?php require_once(TEMPLATE_PATH . '_promo.php'); ?>
<?php require_once(TEMPLATE_PATH . '_nums.php'); ?>

<?php
$term = get_queried_object();

if ($term && is_a($term, 'WP_Term') && $term->taxonomy === 'project_industry') :
?>
    <section class="cases">
        <div class="container">
            <div class="cases__content">
                <div class="cases__header">
                    <h2 class="cases__title title text-uppercase">
                        Проекты в отрасли: <?php echo esc_html($term->name); ?>
                    </h2>
                    <?php if (! empty($term->description)) : ?>
                        <p><?php echo wp_kses_post($term->description); ?></p>
                    <?php endif; ?>
                    <a href="<?php echo get_post_type_archive_link('project'); ?>" class="cases__link more-link icon-arrow">Все проекты</a>
                </div>

                <div class="cases__tabs-content">
                    <div class="cases__tabs-block active">
                        <div class="cases__slider">
                            <div class="cases__slider-block swiper">
                                <div class="swiper-wrapper">
                                    <?php
                                    if (have_posts()) :
                                        while (have_posts()) : the_post();
                                            if (get_post_type() !== 'project') {
                                                continue;
                                            }
                                    ?>
                                            <div class="case swiper-slide">
                                                <div class="case__main">
                                                    <a href="<?php the_permalink(); ?>" class="case__name title-sm"><?php the_title(); ?></a>
                                                    <div class="case__location icon-location">
                                                        <div class="case__location-caption">Регион поставки:</div>
                                                        <address class="case__location-address"><?php echo esc_html(get_post_meta(get_the_ID(), 'project_location', true)); ?></address>
                                                    </div>
                                                    <p class="case__desc"><?php the_excerpt(); ?></p>
                                                    <div class="case__footer">
                                                        <div class="case__time">
                                                            <div class="case__time-caption">Срок поставки договор/факт:</div>
                                                            <div class="case__time-value title-sm"><?php echo esc_html(get_post_meta(get_the_ID(), 'project_delivery_time', true)); ?></div>
                                                        </div>
                                                        <a href="<?php the_permalink(); ?>" class="case__btn btn btn-primary btn-lg">Подробнее</a>
                                                    </div>
                                                </div>
                                                <a href="<?php the_permalink(); ?>" class="case__image">
                                                    <?php the_post_thumbnail('large', array('class' => 'cover-image')); ?>
                                                </a>
                                            </div>
                                        <?php
                                        endwhile;
                                        the_posts_pagination(); // Если нужна пагинация
                                    else :
                                        ?>
                                        <p>Проекты в этой отрасли пока отсутствуют.</p>
                                    <?php
                                    endif;
                                    ?>
                                </div>
                            </div>
                            <button type="button" class="cases__slider-prev swiper-button-prev"></button>
                            <button type="button" class="cases__slider-next swiper-button-next"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
else :
    echo '<p>Отрасль не найдена.</p>';
endif; ?>

<?php require_once(TEMPLATE_PATH . '_features.php'); ?>
<?php require_once(TEMPLATE_PATH . '_check-list.php'); ?>
<?php require_once(TEMPLATE_PATH . '_support.php'); ?>
<?php require_once(TEMPLATE_PATH . '_principles.php'); ?>
<?php require_once(TEMPLATE_PATH . '_offer.php'); ?>
<?php require_once(TEMPLATE_PATH . '_clients.php'); ?>
<?php require_once(TEMPLATE_PATH . '_reviews.php'); ?>
<?php require_once(TEMPLATE_PATH . '_team.php'); ?>
<?php require_once(TEMPLATE_PATH . '_callback.php'); ?>
<?php get_footer(); ?>