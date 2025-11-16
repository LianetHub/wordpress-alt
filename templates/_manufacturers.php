<?php if (have_rows('manufactures_logos', 'option')): ?>
    <section class="clients">
        <div class="container">
            <h2 class="clients__title title text-uppercase">Оборудование ведущих брендов</h2>
            <div class="clients__body">
                <div class="clients__slider swiper">
                    <div class="swiper-wrapper">
                        <?php while (have_rows('manufactures_logos', 'option')): the_row();
                            $logo_image = get_sub_field('logo_image');


                            $logo_image_url = $logo_image['url'] ?? '';
                            $logo_alt_text = $logo_image['alt'] ?? '';


                            if (empty($logo_alt_text)) {
                                $logo_alt_text = $logo_image['title'] ?? 'Логотип производителя';
                            }
                        ?>
                            <a href="#manufactures-order" data-fancybox
                                data-manufacturer-name="<?php echo esc_attr($logo_alt_text); ?>"
                                class="clients__slide swiper-slide">
                                <img src="<?php echo esc_url($logo_image_url); ?>" alt="<?php echo esc_attr($logo_alt_text); ?>">
                            </a>
                        <?php endwhile; ?>
                    </div>

                </div>
                <button type="button" class="clients__slider-prev swiper-button-prev swiper-button-dark"></button>
                <button type="button" class="clients__slider-next swiper-button-next swiper-button-dark"></button>
            </div>
        </div>
        <div id="manufactures-order" class="popup">
            <button type="button" data-fancybox-close class="popup__close icon-cross"></button>
            <div class="popup__title title text-uppercase">обратный звонок</div>
            <p class="popup__subtitle">Оставьте свои контактные данные и мы свяжемся с вами в ближайшее время!</p>
            <div class="popup__form">
                <?= do_shortcode('[contact-form-7 id="4e71405" title="Контактая форма Обратный звонок Производителя"]'); ?>
            </div>
        </div>
    </section>
<?php endif; ?>