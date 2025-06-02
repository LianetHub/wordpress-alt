<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" itemprop="description" content="описание страницы">
    <meta name="keywords" itemprop="keywords" content="ключевые слова">

    <!-- WordPress Title -->
    <title><?php wp_title(); ?></title>

    <!-- favicon -->
    <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/assets/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="<?php echo get_template_directory_uri(); ?>/assets//favicon.svg" />
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/assets/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="ALT" />
    <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/assets/site.webmanifest" />
    <!-- favicon -->

    <!-- Open Graph  -->
    <meta property="og:type" content="business.business">
    <meta property="og:title" content="">
    <meta property="og:description" content="<?php bloginfo('description'); ?>">
    <meta property="og:url" content="<?php echo esc_url(get_permalink()); ?>">
    <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/assets/OG.png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="627">
    <meta property="og:site_name" content="ALT">
    <meta property="og:locale" content="ru_RU">
    <!-- Open Graph -->

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="">
    <meta property="twitter:description" content="<?php bloginfo('description'); ?>">
    <meta property="twitter:site" content="">
    <meta property="twitter:url" content="<?php echo esc_url(get_permalink()); ?>">
    <meta property="twitter:image:src" content="<?php echo get_template_directory_uri(); ?>/OG.png">
    <!-- Twitter -->


    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <div class="wrapper">
        <header class="header">

        </header>
        <main class="page">