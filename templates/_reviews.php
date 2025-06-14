<?php if (have_rows('review_images', 'option')): ?>
    <section class="reviews">
        <div class="container">
            <h2 class="reviews__title title text-uppercase">Отзывы</h2>
            <div class="reviews__body">
                <div class="reviews__slider swiper">
                    <div class="swiper-wrapper">
                        <?php while (have_rows('review_images', 'option')): the_row();

                            $review_image = get_sub_field('review_image');


                            $image_url = $review_image['url'] ?? '';
                            $image_alt_text = $review_image['alt'] ?? '';

                            if (empty($image_alt_text)) {
                                $image_alt_text = $review_image['title'] ?? 'Изображение отзыва';
                            }
                        ?>
                            <a href="<?php echo esc_url($image_url); ?>" data-fancybox="reviews" class="reviews__slide swiper-slide">
                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt_text); ?>">
                            </a>
                        <?php endwhile; ?>
                    </div>
                </div>
                <button type="button" class="reviews__slider-prev swiper-button-prev swiper-button-dark"></button>
                <button type="button" class="reviews__slider-next swiper-button-next swiper-button-dark"></button>
            </div>
        </div>
    </section>
<?php endif; ?>