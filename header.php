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
            <div class="header__top">
                <div class="container">
                    <div class="header__top-body">
                        <nav aria-label="Меню для госзаказчиков" class="header__top-menu">
                            <ul>
                                <li><a href="/state">Для госзаказчиков</a></li>
                                <li><a href="/certificates">Сертификаты</a></li>
                                <li><a href="/reviews">Отзывы</a></li>
                            </ul>
                        </nav>
                        <div class="header__top-worktime">График работы: Пн-Пт 9:00 — 18:00</div>
                    </div>
                </div>
            </div>
            <div class="header__body">
                <div class="container">
                    <div class="header__body-content">
                        <a href="<?= get_home_url() ?>" class="header__logo">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.svg" alt="Логотип">
                        </a>
                        <address class="header__location icon-location">Челябинск, ул. Тернопольская 6, Сколково, Челябинский Кластер</address>
                        <div class="header__contacts">
                            <a href="" class="header__contact icon-envelope">info@alt-ltd.ru</a>
                            <a href="" class="header__contact icon-phone">+7 (351) 777-45-78</a>
                        </div>
                        <a href="#callback" data-fancybox class="header__callback btn btn-primary">Обратный звонок</a>
                    </div>
                </div>
            </div>
            <div class="header__bottom">
                <div class="container">
                    <div class="header__bottom-content">
                        <nav aria-label="Основное меню" class="menu">
                            <ul class="menu__list">
                                <li class="menu__item"><a href="/catalog" class="menu__link">Каталог</a></li>
                                <li class="menu__item menu-parent">
                                    <a href="/industries" class="menu__link">Отрасли</a>
                                    <button type="button" class="menu__arrow icon-chevron-down"></button>
                                </li>
                                <li class="menu__item"><a href="/about" class="menu__link">О компании</a></li>
                                <li class="menu__item"><a href="/business" class="menu__link">Для бизнеса</a></li>
                                <li class="menu__item"><a href="/projects" class="menu__link">Проекты</a></li>
                                <li class="menu__item"><a href="/blog" class="menu__link">Блог</a></li>
                                <li class="menu__item"><a href="/contacts" class="menu__link">Контакты</a></li>
                            </ul>
                        </nav>
                        <form action="#" class="header__search">
                            <input type="text" name="search" class="header__search-input" autocomplete="off" placeholder="Поиск по сайту">
                            <button type="submit" class="header__search-btn icon-search"></button>
                        </form>
                    </div>
                </div>
            </div>
        </header>
        <main class="page">