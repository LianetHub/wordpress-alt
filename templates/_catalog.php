<?php if (have_rows('catalog_items')):  ?>

    <?php $catalog_title = get_field("catalog_title") ?? ''; ?>
    <section class="catalog">
        <div class="container">
            <?php if (!empty($catalog_title)): ?>
                <h2 class="catalog__title title text-uppercase"><?= $catalog_title ?></h2>
            <?php endif; ?>
            <div class="catalog__body">
                <div class="catalog__slider swiper">
                    <ul class="swiper-wrapper">
                        <?php while (have_rows('catalog_items')): the_row();

                            $item_image_url = get_sub_field('item_image');
                            $item_name = get_sub_field('item_name');
                            $item_link_array = get_sub_field('item_link');

                            $item_link_url = isset($item_link_array['url']) ? $item_link_array['url'] : '';
                            $item_link_title = isset($item_link_array['title']) ? $item_link_array['title'] : '';
                            $item_link_target = isset($item_link_array['target']) ? $item_link_array['target'] : '_self'; // '_self' по умолчанию
                        ?>
                            <li class="catalog__item swiper-slide">
                                <a href="<?php echo esc_url($item_link_url); ?>" class="catalog__card" target="<?php echo esc_attr($item_link_target); ?>" title="<?php echo esc_attr($item_link_title); ?>">
                                    <span class="catalog__card-image">
                                        <img src="<?php echo esc_url($item_image_url); ?>" alt="<?php echo esc_attr($item_name); ?>">
                                    </span>
                                    <span class="catalog__card-name title-sm"><?php echo esc_html($item_name); ?></span>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
                <button type="button" class="catalog__slider-prev swiper-button-prev"></button>
                <button type="button" class="catalog__slider-next swiper-button-next"></button>
            </div>
        </div>
    </section>
<?php endif; ?>