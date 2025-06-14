<?php if (have_rows('industry_slides')): ?>
    <div class="industries">
        <div class="container">
            <div class="industries__body">
                <div class="industries__slider swiper">
                    <div class="swiper-wrapper">
                        <?php while (have_rows('industry_slides')): the_row();

                            $image_url = get_sub_field('slide_image');
                            $caption_text = get_sub_field('slide_caption');
                            $link_array = get_sub_field('slide_link');

                            $link_url = isset($link_array['url']) ? $link_array['url'] : '';
                            $link_title = isset($link_array['title']) ? $link_array['title'] : '';
                            $link_target = isset($link_array['target']) ? $link_array['target'] : '_self'; // '_self' по умолчанию
                        ?>
                            <a href="<?php echo esc_url($link_url); ?>" class="industries__slide swiper-slide" target="<?php echo esc_attr($link_target); ?>" title="<?php echo esc_attr($link_title); ?>">
                                <img src="<?php echo esc_url($image_url); ?>" class="cover-image" alt="<?php echo esc_attr($caption_text); ?>">
                                <span class="industries__slide-caption title-sm"><?php echo esc_html($caption_text); ?></span>
                            </a>
                        <?php endwhile; ?>
                    </div>
                </div>
                <button type="button" class="industries__slider-prev swiper-button-prev"></button>
                <button type="button" class="industries__slider-next swiper-button-next"></button>
            </div>
        </div>
    </div>
<?php endif; ?>