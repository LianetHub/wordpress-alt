<?php
$promo_background = get_field('promo_background') ?? '';
$promo_title = get_field('promo_title') ?? '';
$promo_main_title = get_field('promo_main_title') ?? '';
$promo_subtitle = get_field('promo_description') ?? '';
$promo_hint = get_field('promo_hint') ?? '';
$promo_has_offer_btn = get_field('promo_has_offer_btn') ?? false;

$style_attr = $promo_background ? ' style="background-image: url(' . esc_url($promo_background) . ');"' : '';



$is_certificates_page = is_page(117); // ID страницы с сертификатами
$certificate_pdf_url = '';
if ($is_certificates_page) {
    $certificate_pdf_file_array = get_field('certificate_pdf_url');

    if ($certificate_pdf_file_array && is_array($certificate_pdf_file_array) && isset($certificate_pdf_file_array['url'])) {
        $certificate_pdf_url = $certificate_pdf_file_array['url'];
    }
}

?>



<section class="promo" <?= $style_attr ?>>
    <div class="container">
        <div class="promo__body">
            <div class="promo__offer">
                <?php
                if (is_404()) {
                ?>
                    <h1 class="promo__title title-lg">Страница не найдена</h1>
                    <p class="promo__description">К сожалению, страница, которую вы ищете, не&nbsp;существует или была перемещена.</p>
                    <a href="<?= esc_url(home_url('/')); ?>" class="promo__btn btn btn-primary btn-lg">Вернуться на главную</a>
                    <?php
                } else {

                    if (!is_front_page() && function_exists('yoast_breadcrumb')) {
                        yoast_breadcrumb('<nav class="breadcrumbs">', '</nav>');
                    }

                    if ($promo_title && $promo_main_title) {
                    ?>
                        <h1 class="promo__caption"><?= fix_widows_after_prepositions(esc_html($promo_title)) ?></h1>
                        <div class="promo__title title-lg"><?= fix_widows_after_prepositions(esc_html($promo_main_title)) ?></div>
                    <?php
                    } elseif ($promo_main_title) {
                    ?>
                        <h1 class="promo__title title-lg"><?= fix_widows_after_prepositions(esc_html($promo_main_title)) ?></h1>
                    <?php
                    } elseif ($promo_title) {
                    ?>
                        <h1 class="promo__title title-lg"><?= fix_widows_after_prepositions(esc_html($promo_title)) ?></h1>
                    <?php
                    } else {
                    ?>
                        <h1 class="promo__title title-lg"><?= fix_widows_after_prepositions(esc_html(get_the_title())) ?></h1>
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
                        <a href="#offer" class="promo__btn btn btn-primary btn-lg">Получить КП</a>
                <?php
                    }
                }
                ?>
            </div>
            <? if ($is_certificates_page && $certificate_pdf_url) { ?>
                <a href="<?= esc_url($certificate_pdf_url) ?>" class="promo__download icon-download" download><span>Открыть в PDF</span></a>
            <? } ?>
        </div>
    </div>
</section>
<? if ($promo_subtitle): ?>
    <div class="promo__bottom">
        <div class="container">
            <?= esc_html($promo_subtitle) ?>
        </div>
    </div>
<? endif; ?>