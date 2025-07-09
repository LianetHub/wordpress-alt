<?php

if (!isset($object_id_for_acf) || empty($object_id_for_acf)) {
    $object_id_for_acf = get_the_ID();
}

$features_title = get_field('features_title', $object_id_for_acf) ?? 'Преимущества';
$features_description = get_field('features_description', $object_id_for_acf);
?>

<?php if (have_rows('features_list_items', $object_id_for_acf)): ?>
    <section class="features">
        <div class="container">
            <h2 class="features__title title text-uppercase">
                <?php echo fix_widows_after_prepositions(esc_html($features_title)); ?>
            </h2>
            <?php if ($features_description): ?>
                <div class="features__desc"><?php echo wp_kses_post($features_description); ?></div>
            <?php endif; ?>
            <ul class="features__list">
                <?php while (have_rows('features_list_items', $object_id_for_acf)): the_row();
                    $item_caption = get_sub_field('item_caption');
                    $item_description = get_sub_field('item_description');
                ?>
                    <li class="features__item icon-check-circle">
                        <?php if ($item_caption): ?>
                            <div class="features__item-caption title-sm">
                                <?php echo wp_kses_post($item_caption); ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($item_description): ?>
                            <div class="features__item-desc">
                                <?php echo wp_kses_post($item_description); ?>
                            </div>
                        <?php endif; ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </section>
<?php endif; ?>