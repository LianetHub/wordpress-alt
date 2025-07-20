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
    <?php
    $phone_number = get_field('phone_number', 'option');
    $formatted_phone_number = preg_replace('/[^0-9+]/', '', $phone_number);
    $email_address = get_field('email_address', 'option');
    $organization_address = get_field('organization_address', 'option');
    $telegram_url = get_field('telegram_url', 'option');
    $whatsapp_url = get_field('whatsapp_url', 'option');
    $work_time = get_field('work_time', 'option');
    ?>

    <div class="wrapper">
        <header class="header">
            <div class="header__top">
                <div class="container">
                    <div class="header__top-body">
                        <?php
                        wp_nav_menu(array(
                            'theme_location'  => 'top_header_menu',
                            'container'       => 'nav',
                            'container_class' => 'header__top-menu',
                            'container_aria_label' => 'Меню для государственных заказчиков',
                            'menu_class'      => '',
                            'items_wrap'      => '<ul>%3$s</ul>',
                            'depth'           => 1,
                            'fallback_cb'     => false,
                        ));
                        ?>
                        <?php if (!empty($work_time)): ?>
                            <div class="header__top-worktime">График работы: <?= esc_html($work_time) ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="header__body">
                <div class="container">
                    <div class="header__body-content">
                        <a href="<?= get_home_url() ?>" class="header__logo">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.svg" alt="Логотип">
                        </a>
                        <?php if (!empty($organization_address)): ?>
                            <address class="header__location icon-location">
                                <?= esc_html($organization_address) ?>
                            </address>
                        <?php endif; ?>
                        <?php if (!empty($email_address) || !empty($phone_number)): ?>
                            <div class="header__contacts">
                                <?php if (!empty($email_address)): ?>
                                    <a href="mailto:<?= esc_attr($email_address) ?>" class="header__contact icon-envelope">
                                        <?= esc_html($email_address) ?>
                                    </a>
                                <?php endif; ?>

                                <?php if (!empty($phone_number)): ?>
                                    <a href="tel:<?= esc_attr($formatted_phone_number) ?>" class="header__contact icon-phone">
                                        <?= esc_html($phone_number) ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <a href="#callback" data-fancybox class="header__callback btn btn-primary">Обратный звонок</a>
                    </div>
                </div>
            </div>
            <div class="header__bottom">
                <div class="container">
                    <div class="header__bottom-content">
                        <button type="button" aria-label="Меню" class="header__menu-toggler icon-menu">
                            <span></span>
                            <span></span>
                        </button>
                        <div class="menu">
                            <div class="menu__header">
                                <a href="<?= get_home_url() ?>" class="menu__logo">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.svg" alt="Логотип">
                                </a>
                            </div>
                            <?php
                            wp_nav_menu(array(
                                'theme_location'  => 'header-menu',
                                'container'       => 'nav',
                                'container_class' => 'menu__body',
                                'container_aria_label' => 'Основное меню',
                                'menu_class'      => 'menu__list',
                                'walker'         => new Custom_Nav_Menu_Walker(),
                            ));
                            ?>
                            <div class="menu__bottom">
                                <?php if (!empty($email_address) || !empty($phone_number)): ?>
                                    <div class="menu__contacts">
                                        <?php if (!empty($email_address)): ?>
                                            <a href="mailto:<?= esc_attr($email_address) ?>" class="menu__contact icon-envelope">
                                                <?= esc_html($email_address) ?>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (!empty($phone_number)): ?>
                                            <a href="tel:<?= esc_attr($formatted_phone_number) ?>" class="menu__contact icon-phone">
                                                <?= esc_html($phone_number) ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($telegram_url) || !empty($phone_number)): ?>
                                    <div class="menu__socials">
                                        <?php if (!empty($whatsapp_url)): ?>
                                            <a href="<?= esc_url($whatsapp_url) ?>" class="menu__social icon-whatsapp" target="_blank" rel="noopener noreferrer"></a>
                                        <?php endif; ?>
                                        <?php if (!empty($telegram_url)): ?>
                                            <a href="<?= esc_url($telegram_url) ?>" class="menu__social icon-telegram" target="_blank" rel="noopener noreferrer"></a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if (!empty($email_address) || !empty($phone_number)): ?>
                            <div class="header__contacts">
                                <?php if (!empty($email_address)): ?>
                                    <a href="mailto:<?= esc_attr($email_address) ?>" aria-label="Email" class="header__contact icon-envelope"></a>
                                <?php endif; ?>
                                <?php if (!empty($phone_number)): ?>
                                    <a href="tel:<?= esc_attr($formatted_phone_number) ?>" aria-label="Телефон" class="header__contact icon-phone"></a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <form action="<?php echo esc_url(home_url('/')); ?>" class="header__search">
                            <input type="text" name="s" class="header__search-input" autocomplete="off" placeholder="Поиск по сайту">
                            <button type="submit" class="header__search-btn icon-search"></button>
                        </form>

                        <a href="#callback" data-fancybox class="header__callback btn btn-primary">Обратный звонок</a>
                    </div>
                </div>
            </div>
        </header>
        <main class="page">