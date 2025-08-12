<?php

/**
 * The template for displaying search results pages.
 *
 * This template can be overridden by copying it to yourtheme/search.php.
 *
 * @see     https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package YOUR_THEME_NAME/Templates
 * @version 1.0.0
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header();
?>


<?php require_once(TEMPLATE_PATH . '_promo.php'); ?>
<?php require_once(TEMPLATE_PATH . '_products.php'); ?>
<?php require_once(TEMPLATE_PATH . '_offer.php'); ?>
<?php get_footer(); ?>