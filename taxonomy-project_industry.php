<?php
$current_term = get_queried_object();
$object_id_for_acf = 'project_industry_' . $current_term->term_id; ?>

<?php get_header(); ?>
<?php require_once(TEMPLATE_PATH . '_promo.php'); ?>
<?php require_once(TEMPLATE_PATH . '_nums.php'); ?>
<?php require_once(TEMPLATE_PATH . '_seo-block.php'); ?>
<?php require_once(TEMPLATE_PATH . '_features.php'); ?>
<?php require_once(TEMPLATE_PATH . '_cases.php'); ?>
<?php require_once(TEMPLATE_PATH . '_check-list.php'); ?>
<?php require_once(TEMPLATE_PATH . '_catalog.php'); ?>
<?php require_once(TEMPLATE_PATH . '_support.php'); ?>
<?php require_once(TEMPLATE_PATH . '_principles.php'); ?>
<?php require_once(TEMPLATE_PATH . '_offer.php'); ?>
<?php require_once(TEMPLATE_PATH . '_clients.php'); ?>
<?php require_once(TEMPLATE_PATH . '_reviews.php'); ?>
<?php require_once(TEMPLATE_PATH . '_team.php'); ?>
<?php require_once(TEMPLATE_PATH . '_callback.php'); ?>
<?php get_footer(); ?>