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
?>

<?php require_once(TEMPLATE_PATH . '_promo.php'); ?>
<?php require_once(TEMPLATE_PATH . '_products.php'); ?>
<?php require_once(TEMPLATE_PATH . '_seo-block.php'); ?>
<?php require_once(TEMPLATE_PATH . '_offer.php'); ?>
<?php get_footer(); ?>