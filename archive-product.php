<?php
get_header();
?>

<?php require_once(TEMPLATE_PATH . '_promo.php'); ?>
<?php
$args = array(
    'taxonomy'     => 'product_cat',
    'orderby'      => 'count',
    'show_count'   => 0,
    'pad_counts'   => 0,
    'hierarchical' => 1,
    'title_li'     => '',
    'hide_empty'   => 0,
    'exclude'      => array(16)
);

$all_categories = get_terms($args); ?>
<? if (! empty($all_categories) && ! is_wp_error($all_categories)) : ?>
    <section class="catalog">
        <div class="container">
            <? if (!is_shop()) : ?>
                <h2 class="catalog__title title text-uppercase">Каталог</h2>
            <? endif ?>
            <div class="catalog__body">
                <ul class="catalog__grid">
                    <? foreach ($all_categories as $cat) :

                        $category_link = get_term_link($cat->slug, 'product_cat');

                        $thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
                        $image_url = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : '';
                        $image_alt = $thumbnail_id ? get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true) : esc_attr($cat->name); // Alt-текст из медиафайла или название категории


                        if (empty($image_url)) {
                            $image_url = get_template_directory_uri() . '/assets/img/placeholder-category.png';
                        }
                    ?>
                        <li class="catalog__item">
                            <a href="<?php echo esc_url($category_link); ?>" class="catalog__card" target="_self" title="<?php echo esc_attr($cat->name); ?>">
                                <span class="catalog__card-image">
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                                </span>
                                <span class="catalog__card-name title-sm"><?php echo esc_html($cat->name); ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>
<? endif; ?>
<?php require_once(TEMPLATE_PATH . '_offer.php'); ?>
<?php require_once(TEMPLATE_PATH . '_reviews.php'); ?>
<?php require_once(TEMPLATE_PATH . '_seo-block.php'); ?>
<?php require_once(TEMPLATE_PATH . '_callback.php'); ?>



<?php get_footer(); ?>