<?php
$promo_background = get_field('promo_background') ?? '';
$promo_title = get_field('promo_title') ?? '';
$promo_main_title = get_field('promo_main_title') ?? '';
$promo_subtitle = get_field('promo_description') ?? '';
$promo_hint = get_field('promo_hint') ?? '';
$promo_has_offer_btn = get_field('promo_has_offer_btn') ?? false;


$style_attr = $promo_background ? ' style="background-image: url(' . esc_url($promo_background) . ');"' : '';




?>



<section class="promo" <?= $style_attr ?>>
    <div class="container">
        <?php if (!is_front_page() && function_exists('yoast_breadcrumb')): ?>
            <?php yoast_breadcrumb('<nav class="breadcrumbs">', '</nav>'); ?>
        <?php endif; ?>

        <?php if ($promo_title && $promo_main_title): ?>
            <h1 class="promo__caption"><?= fix_widows_after_prepositions(esc_html($promo_title)) ?></h1>
            <div class="promo__title title-lg"><?= fix_widows_after_prepositions(esc_html($promo_main_title)) ?></div>
        <?php elseif ($promo_main_title): ?>
            <h1 class="promo__title title-lg"><?= fix_widows_after_prepositions(esc_html($promo_main_title)) ?></h1>
        <?php elseif ($promo_title): ?>
            <h1 class="promo__title title-lg"><?= fix_widows_after_prepositions(esc_html($promo_title)) ?></h1>
        <?php else: ?>
            <h1 class="promo__title title-lg"><?= fix_widows_after_prepositions(esc_html(get_the_title())) ?></h1>
        <?php endif; ?>

        <?php if ($promo_subtitle): ?>
            <p class="promo__description"><?= esc_html($promo_subtitle) ?></p>
        <?php endif; ?>

        <?php if ($promo_hint): ?>
            <div class="promo__hint"><?= esc_html($promo_hint) ?></div>
        <?php endif; ?>

        <?php if ($promo_has_offer_btn): ?>
            <a href="#offer" class="promo__btn btn btn-primary">Получить КП</a>
        <?php endif; ?>
    </div>
</section>