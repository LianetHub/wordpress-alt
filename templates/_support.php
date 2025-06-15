<?php

if (have_rows('support_block', 'option')):
    while (have_rows('support_block', 'option')): the_row();

        $support_title = get_sub_field('support_title');
        $support_subtitle = get_sub_field('support_subtitle');


        $support_image_obj = get_sub_field('support_image');
        $support_image_url = $support_image_obj['url'] ?? '';
        $support_image_alt = $support_image_obj['alt'] ?? ($support_title ?: 'Изображение');

        $support_image_order = get_sub_field('support_image_order');
        $order_class = '';
        if ($support_image_order === 'left') {
            $order_class = ' about--reverse';
        }


?>
        <section class="about<?= esc_attr($order_class) ?>">
            <div class="about__wrapper">
                <div class="container">
                    <div class="about__body">
                        <div class="about__header">
                            <div class="container">
                                <?php if ($support_title): ?>
                                    <h2 class="about__title title text-uppercase"><?php echo esc_html($support_title); ?></h2>
                                <?php endif; ?>
                                <?php if ($support_subtitle): ?>
                                    <div class="about__subtitle title-sm"><?php echo wp_kses_post($support_subtitle); ?></div>
                                <?php endif; ?>
                                <?php if (have_rows('support_list_items')):
                                ?>
                                    <ul class="about__list">
                                        <?php while (have_rows('support_list_items')): the_row();
                                        ?>
                                            <?php
                                            $item_icon_obj = get_sub_field('item_icon');
                                            $item_icon_url = $item_icon_obj['url'] ?? '';
                                            $item_icon_alt = $item_icon_obj['alt'] ?? 'Иконка пункта';

                                            $item_text = get_sub_field('item_text');
                                            ?>
                                            <li class="about__list-item">
                                                <?php if ($item_icon_url):
                                                ?>
                                                    <div class="about__list-icon">
                                                        <img src="<?php echo esc_url($item_icon_url); ?>" alt="<?php echo esc_attr($item_icon_alt); ?>">
                                                    </div>
                                                <?php endif; ?>
                                                <?php if ($item_text): ?>
                                                    <div class="about__list-desc"><?php echo fix_widows_after_prepositions(wp_kses_post($item_text)); ?></div>
                                                <?php endif; ?>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($support_image_url): ?>
                <div class="about__image">
                    <img src="<?php echo esc_url($support_image_url); ?>" class="cover-image" alt="<?php echo esc_attr($support_image_alt); ?>">
                </div>
            <?php endif; ?>
        </section>
<?php endwhile;
endif; ?>