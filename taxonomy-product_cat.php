<?php

/**
 * The template for displaying product category archives.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/taxonomy-product_cat.php.
 *
 * @see      https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.1.0
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header();

$current_term = get_queried_object();

$sub_args = array(
    'taxonomy'   => 'product_cat',
    'parent'     => $current_term->term_id,
    'hide_empty' => 1,
);

$subcategories = get_terms($sub_args);

require_once(TEMPLATE_PATH . '_promo.php');

if (!empty($subcategories) && !is_wp_error($subcategories)) : ?>
    <section class="catalog">
        <div class="container">
            <div class="catalog__body">
                <ul class="catalog__grid">
                    <?php foreach ($subcategories as $cat) :
                        $category_link = get_term_link($cat->slug, 'product_cat');

                        $thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
                        $image_url = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : '';
                        $image_alt = $thumbnail_id ? get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true) : esc_attr($cat->name);

                        if (empty($image_url)) {
                            $image_url = get_template_directory_uri() . '/assets/img/placeholder-category.png';
                        }
                    ?>
                        <li class="catalog__item">
                            <a href="<?php echo esc_url($category_link); ?>" class="catalog__card catalog__card--<?php echo esc_attr($cat->slug); ?>" target="_self" title="<?php echo esc_attr($cat->name); ?>">
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
<?php else :
    require_once(TEMPLATE_PATH . '_products.php');
endif;

require_once(TEMPLATE_PATH . '_seo-block.php');
require_once(TEMPLATE_PATH . '_offer.php');

get_footer();
?>