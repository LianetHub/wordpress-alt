<?php
$object_id_for_acf = get_the_ID();

$page_type = '';

if (is_tax('project_industry')) {
    $page_type = 'project_industry_tax';
} elseif (is_post_type_archive('project')) {
    $page_type = 'project_archive';
} elseif (is_product_category() || is_product_tag() || is_product_taxonomy()) {
    $page_type = 'product_taxonomy';
} elseif (is_shop()) {
    $page_type = 'shop_page';
} elseif (is_front_page()) {
    $page_type = 'front_page';
} elseif (is_page()) {
    $page_type = 'page';
} elseif (is_home() && !is_front_page()) {
    $page_type = 'posts_page';
} elseif (is_404()) {
    $page_type = '404';
} elseif (is_search()) {
    $page_type = 'search_page';
} else {
    $page_type = 'default';
}

switch ($page_type) {
    case 'project_industry_tax':
        $current_term = get_queried_object();
        if ($current_term) {
            $object_id_for_acf = 'project_industry_' . $current_term->term_id;
        }
        break;
    case 'project_archive':
        $object_id_for_acf = 'option';
        break;
    case 'product_taxonomy':
        $current_term = get_queried_object();
        if ($current_term) {
            $object_id_for_acf = $current_term->taxonomy . '_' . $current_term->term_id;
        }
        break;
    case 'shop_page':
        $shop_page_id = wc_get_page_id('shop');
        if ($shop_page_id) {
            $object_id_for_acf = $shop_page_id;
        } else {
            $object_id_for_acf = 'option';
        }
        break;
    case 'front_page':
    case 'page':
        $object_id_for_acf = get_the_ID();
        break;
    case 'posts_page':
        $object_id_for_acf = get_option('page_for_posts');
        break;
    case '404':
    case 'search_page':
        $object_id_for_acf = 'option';
        break;
    case 'default':
    default:
        $object_id_for_acf = get_the_ID();
        break;
}

$promo_background = get_field('promo_background', $object_id_for_acf) ?? '';
$promo_title = get_field('promo_title', $object_id_for_acf) ?? '';
$promo_main_title = get_field('promo_main_title', $object_id_for_acf) ?? '';
$promo_subtitle = get_field('promo_description', $object_id_for_acf) ?? '';
$promo_hint = get_field('promo_hint', $object_id_for_acf) ?? '';
$promo_has_offer_btn = get_field('promo_has_offer_btn', $object_id_for_acf) ?? false;
$promo_video = get_field('promo_video', $object_id_for_acf) ?? '';
$promo_poster = get_field('promo_poster', $object_id_for_acf) ?? '';

$style_attr = $promo_background ? ' style="background-image: url(' . esc_url($promo_background) . ');"' : '';

$is_projects_archive = is_post_type_archive('project');
$is_certificates_page = is_page(117);
$certificate_pdf_url = '';
if ($is_certificates_page) {
    $certificate_pdf_file_array = get_field('certificate_pdf_url', $object_id_for_acf);

    if ($certificate_pdf_file_array && is_array($certificate_pdf_file_array) && isset($certificate_pdf_file_array['url'])) {
        $certificate_pdf_url = $certificate_pdf_file_array['url'];
    }
}

$title_class = is_single() ? 'title' : 'title-lg';

$title_tag = (is_tax('project_industry')) ? 'div' : 'h1';

$is_partners_page = is_page(14541);
?>

<section class="promo" <?= $style_attr ?>>
    <?php if (!empty($promo_video)) : ?>
        <video class="promo__video" playsinline autoplay muted loop poster="<?= esc_url($promo_poster['url']) ?>">
            <source src="<?= esc_url($promo_video['url']) ?>" type="video/mp4">
        </video>
    <?php endif; ?>
    <div class="container">
        <div class="promo__body">
            <div class="promo__offer">

                <?php
                if (is_404()) {
                ?>
                    <h1 class="promo__title <?= $title_class ?>">Страница не найдена</h1>
                    <p class="promo__description">К сожалению, страница, которую вы ищете, не&nbsp;существует или была перемещена.</p>
                    <?php
                } else {

                    if (!is_front_page() && !is_page(405) && function_exists('yoast_breadcrumb')) {
                        switch ($page_type) {
                            case 'project_archive':
                                if (is_singular('project')) {
                                    echo '<nav class="breadcrumbs">';
                                    echo '<a href="' . esc_url(home_url('/')) . '">Главная страница</a> / ';
                                    echo '<a href="' . esc_url(get_post_type_archive_link('project')) . '">Проекты</a> / ';
                                    echo '<span>' . esc_html(get_the_title()) . '</span>';
                                    echo '</nav>';
                                }
                                break;
                            case 'product_taxonomy':
                                if (is_product_category()) {
                                    echo '<nav class="breadcrumbs">';
                                    echo '<a href="' . esc_url(home_url('/')) . '">Главная страница</a> / ';
                                    $shop_page_id = wc_get_page_id('shop');
                                    if ($shop_page_id) {
                                        echo '<a href="' . esc_url(get_permalink($shop_page_id)) . '">Каталог</a> / ';
                                    }
                                    echo '<span>' . esc_html(single_term_title('', false)) . '</span>';
                                    echo '</nav>';
                                }
                                break;
                            case 'search_page':
                                echo '<nav class="breadcrumbs">';
                                echo '<a href="' . esc_url(home_url('/')) . '">Главная страница</a> / ';
                                echo '<span>Поиск</span>';
                                echo '</nav>';
                                break;
                            default:
                                yoast_breadcrumb('<nav class="breadcrumbs">', '</nav>');
                                break;
                        }
                    }

                    if ($promo_title || $promo_main_title) {
                        if ($promo_title && $promo_main_title) {
                    ?>
                            <h1 class="promo__caption"><?= fix_widows_after_prepositions(esc_html($promo_title)) ?></h1>
                            <<?= $title_tag ?> class="promo__title <?= $title_class ?>"><?= fix_widows_after_prepositions(esc_html($promo_main_title)) ?></<?= $title_tag ?>>
                        <?php
                        } elseif ($promo_main_title) {
                        ?>
                            <<?= $title_tag ?> class="promo__title <?= $title_class ?>"><?= fix_widows_after_prepositions(esc_html($promo_main_title)) ?></<?= $title_tag ?>>
                        <?php
                        } elseif ($promo_title) {
                        ?>
                            <<?= $title_tag ?> class="promo__title <?= $title_class ?>"><?= fix_widows_after_prepositions(esc_html($promo_title)) ?></<?= $title_tag ?>>
                            <?php
                        }
                    } else {
                        switch ($page_type) {
                            case 'search_page':
                                $search_query = get_search_query();
                                if (!empty($search_query)) {
                                    echo '<' . $title_tag . ' class="promo__title">' . esc_html__('Результаты поиска по запросу: ', 'your-theme-textdomain') . '"' . esc_html($search_query) . '"</' . $title_tag . '>';
                                } else {
                                    echo '<' . $title_tag . ' class="promo__title">' . esc_html__('Поиск', 'your-theme-textdomain') . '</' . $title_tag . '>';
                                }
                                break;
                            case 'project_archive':
                                $post_type_obj = get_post_type_object('project');
                                $archive_title = $post_type_obj ? $post_type_obj->labels->name : 'Проекты';
                                echo '<' . $title_tag . ' class="promo__title ' . esc_attr($title_class) . '">' . esc_html($archive_title) . '</' . $title_tag . '>';
                                break;
                            case 'project_industry_tax':
                                $term = get_queried_object();
                                if ($term) {
                                    echo '<' . $title_tag . ' class="promo__title ' . esc_attr($title_class) . '">' . esc_html($term->name) . '</' . $title_tag . '>';
                                } else {
                                    echo '<' . $title_tag . ' class="promo__title ' . esc_attr($title_class) . '">Отрасли Проектов</' . $title_tag . '>';
                                }
                                break;
                            case 'shop_page':
                            ?>
                                <<?= $title_tag ?> class="promo__title <?= $title_class ?>"><?= fix_widows_after_prepositions(esc_html(woocommerce_page_title(false))) ?></<?= $title_tag ?>>
                            <?php
                                break;
                            case 'product_taxonomy':
                            ?>
                                <<?= $title_tag ?> class="promo__title <?= $title_class ?>"><?= fix_widows_after_prepositions(esc_html(single_term_title('', false))) ?></<?= $title_tag ?>>
                            <?php
                                break;
                            case 'front_page':
                            case 'posts_page': // is_home()
                            ?>
                                <<?= $title_tag ?> class="promo__title <?= $title_class ?>">Блог</<?= $title_tag ?>>
                            <?php
                                break;
                            case 'default':
                            default:
                            ?>
                                <<?= $title_tag ?> class="promo__title <?= $title_class ?>"><?= fix_widows_after_prepositions(esc_html(get_the_title())) ?></<?= $title_tag ?>>
                        <?php
                                break;
                        }
                    }

                    if ($promo_subtitle) {
                        ?>
                        <p class="promo__description<?php if (is_page(405)) echo " promo__description--mobile"; ?>"><?= esc_html($promo_subtitle) ?></p>
                    <?php
                    }

                    if ($promo_hint) {
                    ?>
                        <div class="promo__hint title-sm"><?= esc_html($promo_hint) ?></div>
                        <?php
                    }

                    if ($promo_has_offer_btn) {
                        if ($is_partners_page) {
                        ?>
                            <a href="#partner-offer" data-fancybox class="promo__btn btn btn-primary btn-lg">Стать партнером</a>
                        <?php
                        } else {
                        ?>
                            <a href="#commercial-offer" data-fancybox class="promo__btn btn btn-primary btn-lg">Получить КП</a>
                    <?php
                        }
                    }
                }
                if (is_single() && get_post_type() === 'post') {
                    ?>
                    <time datetime="<?= get_russian_post_date(null, 'datetime'); ?>" class="promo__time"><?= esc_html(get_russian_post_date()); ?></time>
                <?php
                }
                ?>
            </div>
            <?php
            if (is_404()) {
            ?>
                <a href="<?= esc_url(home_url('/')); ?>" class="promo__btn btn btn-primary btn-lg">Главная страница</a>
            <?php
            }
            ?>

            <?php if ($is_certificates_page && $certificate_pdf_url) { ?>
                <a href="<?= esc_url($certificate_pdf_url) ?>" class="promo__download icon-download" download><span>Открыть в PDF</span></a>
            <?php } ?>
            <?php if ($is_projects_archive) { ?>
                <?php
                $current_term_slug = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : '';

                $terms = get_terms(array(
                    'taxonomy'   => 'project_industry',
                    'hide_empty' => true,
                ));

                $archive_base_url = esc_url(get_post_type_archive_link('project'));
                ?>
                <div class="promo__select">
                    <select name="industry-filter" class="select project-filter-select">
                        <option value="" <?= empty($current_term_slug) ? 'selected' : ''; ?>>
                            Все отрасли
                        </option>
                        <?php
                        if (!empty($terms) && !is_wp_error($terms)) {
                            foreach ($terms as $term) {
                                $selected = ($current_term_slug === $term->slug) ? 'selected' : '';
                                echo '<option value="' . esc_attr($term->slug) . '" ' . $selected . '>' . esc_html($term->name) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<?php if ($promo_subtitle && !is_404() && !is_page(405)) : ?>
    <div class="promo__bottom">
        <div class="container">
            <?= esc_html($promo_subtitle) ?>
        </div>
    </div>
<?php endif; ?>
<?php if ($is_projects_archive) : ?>
    <?php
    $terms = get_terms(array(
        'taxonomy'   => 'project_industry',
        'hide_empty' => false,
        'orderby'    => 'name',
        'order'      => 'ASC',
    ));

    $current_term_slug = isset($_GET['industry']) ? sanitize_text_field($_GET['industry']) : '';
    ?>
    <div class="promo__bottom">
        <div class="container">
            <div class="promo__select">
                <select name="industry-filter" class="select project-filter-select">
                    <option value="<?= esc_url(get_post_type_archive_link('project')); ?>" <?= empty($current_term_slug) ? 'selected' : ''; ?>>
                        Все отрасли
                    </option>
                    <?php
                    if (!empty($terms) && !is_wp_error($terms)) {
                        foreach ($terms as $term) {
                            $selected = ($current_term_slug === $term->slug) ? 'selected' : '';
                            echo '<option value="' . esc_url(get_term_link($term)) . '" ' . $selected . '>' . esc_html($term->name) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
<?php endif; ?>