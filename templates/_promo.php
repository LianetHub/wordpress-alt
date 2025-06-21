<?php
$promo_background = get_field('promo_background') ?? '';
$promo_title = get_field('promo_title') ?? '';
$promo_main_title = get_field('promo_main_title') ?? '';
$promo_subtitle = get_field('promo_description') ?? '';
$promo_hint = get_field('promo_hint') ?? '';
$promo_has_offer_btn = get_field('promo_has_offer_btn') ?? false;

$style_attr = $promo_background ? ' style="background-image: url(' . esc_url($promo_background) . ');"' : '';


$is_projects_archive = is_post_type_archive('project');

$is_certificates_page = is_page(117); // ID страницы с сертификатами
$certificate_pdf_url = '';
if ($is_certificates_page) {
    $certificate_pdf_file_array = get_field('certificate_pdf_url');

    if ($certificate_pdf_file_array && is_array($certificate_pdf_file_array) && isset($certificate_pdf_file_array['url'])) {
        $certificate_pdf_url = $certificate_pdf_file_array['url'];
    }
}


$title_class = is_single() ? 'title' : 'title-lg';

?>

<section class="promo" <?= $style_attr ?>>
    <div class="container">
        <div class="promo__body">
            <div class="promo__offer">
                <?php
                if (is_404()) {
                ?>
                    <h1 class="promo__title <?= $title_class ?>">Страница не найдена</h1>
                    <p class="promo__description">К сожалению, страница, которую вы ищете, не&nbsp;существует или была перемещена.</p>
                    <a href="<?= esc_url(home_url('/')); ?>" class="promo__btn btn btn-primary btn-lg">Вернуться на главную</a>
                    <?php
                } else {

                    if (!is_front_page() && function_exists('yoast_breadcrumb')) {
                        if (is_singular('project')) {
                            echo '<nav class="breadcrumbs">';
                            echo '<a href="' . esc_url(home_url('/')) . '">Главная</a> / ';
                            echo '<a href="' . esc_url(get_post_type_archive_link('project')) . '">Проекты</a> / ';
                            echo '<span>' . esc_html(get_the_title()) . '</span>';
                            echo '</nav>';
                        } else {
                            yoast_breadcrumb('<nav class="breadcrumbs">', '</nav>');
                        }
                    }

                    if (is_post_type_archive('project')) {
                        $post_type_obj = get_post_type_object('project');
                        $archive_title = $post_type_obj ? $post_type_obj->labels->name : 'Проекты';

                        echo '<h1 class="promo__title ' . esc_attr($title_class) . '">' . esc_html($archive_title) . '</h1>';
                    } elseif (is_tax('project_industry')) {
                        $term = get_queried_object();
                        if ($term) {
                            echo '<h1 class="promo__title ' . esc_attr($title_class) . '">' . esc_html($term->name) . '</h1>';
                        } else {
                            echo '<h1 class="promo__title ' . esc_attr($title_class) . '">Отрасли Проектов</h1>';
                        }
                    } elseif ($promo_title && $promo_main_title) {
                    ?>
                        <h1 class="promo__caption"><?= fix_widows_after_prepositions(esc_html($promo_title)) ?></h1>
                        <div class="promo__title <?= $title_class ?>"><?= fix_widows_after_prepositions(esc_html($promo_main_title)) ?></div>
                    <?php
                    } elseif ($promo_main_title) {
                    ?>
                        <h1 class="promo__title <?= $title_class ?>"><?= fix_widows_after_prepositions(esc_html($promo_main_title)) ?></h1>
                    <?php

                    } elseif ($promo_title) {
                    ?>
                        <h1 class="promo__title <?= $title_class ?>"><?= fix_widows_after_prepositions(esc_html($promo_title)) ?></h1>
                    <?php
                    } elseif (is_home() || is_front_page()) {
                    ?>
                        <h1 class="promo__title <?= $title_class ?>">Блог</h1>
                    <?php
                    } else {
                    ?>
                        <h1 class="promo__title <?= $title_class ?>"><?= fix_widows_after_prepositions(esc_html(get_the_title())) ?></h1>
                    <?php
                    }

                    if ($promo_subtitle) {
                    ?>
                        <p class="promo__description"><?= esc_html($promo_subtitle) ?></p>
                    <?php
                    }

                    if ($promo_hint) {
                    ?>
                        <div class="promo__hint title-sm"><?= esc_html($promo_hint) ?></div>
                    <?php
                    }

                    if ($promo_has_offer_btn) {
                    ?>
                        <a href="#commercial-offer" data-fancybox class="promo__btn btn btn-primary btn-lg">Получить КП</a>
                    <?php
                    }
                }
                if (is_single() && get_post_type() === 'post') {
                    ?>
                    <time datetime="<?= get_russian_post_date(null, 'datetime'); ?>" class="promo__time"><?= esc_html(get_russian_post_date()); ?></time>
                <?php
                }
                ?>
            </div>
            <?php if ($is_certificates_page && $certificate_pdf_url) { ?>
                <a href="<?= esc_url($certificate_pdf_url) ?>" class="promo__download icon-download" download><span>Открыть в PDF</span></a>
            <?php } ?>
            <?php if ($is_projects_archive) { ?>
                <?
                $current_term_slug = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : '';


                $terms = get_terms(array(
                    'taxonomy'   => 'project_industry',
                    'hide_empty' => true,
                ));


                $archive_base_url = esc_url(get_post_type_archive_link('project'));
                ?>
                <div class="promo__select">
                    <select name="industry-filter" id="industry-filter-desktop" class="select project-filter-select">
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
<?php if ($promo_subtitle): ?>
    <div class="promo__bottom">
        <div class="container">
            <?= esc_html($promo_subtitle) ?>
        </div>
    </div>
<?php endif; ?>
<?php if ($is_projects_archive): ?>
    <?
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