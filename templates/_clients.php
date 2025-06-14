<?php if (have_rows('client_logos', 'option')): ?>
    <section class="clients">
        <div class="container">
            <h2 class="clients__title title text-uppercase">Наши клиенты</h2>
            <div class="clients__body">
                <div class="clients__slider swiper">
                    <div class="swiper-wrapper">
                        <?php while (have_rows('client_logos', 'option')): the_row();
                            $logo_image = get_sub_field('logo_image');


                            $logo_image_url = $logo_image['url'] ?? '';
                            $logo_alt_text = $logo_image['alt'] ?? '';


                            if (empty($logo_alt_text)) {
                                $logo_alt_text = $logo_image['title'] ?? 'Логотип клиента';
                            }
                        ?>
                            <div class="clients__slide swiper-slide">
                                <img src="<?php echo esc_url($logo_image_url); ?>" alt="<?php echo esc_attr($logo_alt_text); ?>">
                            </div>
                        <?php endwhile; ?>
                    </div>

                </div>
                <button type="button" class="clients__slider-prev swiper-button-prev swiper-button-dark"></button>
                <button type="button" class="clients__slider-next swiper-button-next swiper-button-dark"></button>
            </div>
        </div>
    </section>
<?php endif; ?>