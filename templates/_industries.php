<?php
$terms = get_terms(array(
    'taxonomy'   => 'project_industry',
    'hide_empty' => false,
    'orderby'    => 'name',
    'order'      => 'ASC',
));

if (!empty($terms) && !is_wp_error($terms)) :
?>
    <div class="industries">
        <div class="container">
            <div class="industries__body">
                <div class="industries__slider swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($terms as $term) :
                            if ($term->slug === 'professionalitet') {
                                continue;
                            }

                            $term_name = esc_html($term->name);
                            $term_link = esc_url(get_term_link($term));

                            $background_image_url = get_field('promo_background', 'project_industry_' . $term->term_id) ?? '';

                            $caption_text = $term_name;
                            $link_url = $term_link;
                            $link_title = $term_name;
                            $link_target = '_self';
                        ?>
                            <a href="<?php echo esc_url($link_url); ?>" class="industries__slide swiper-slide" target="<?php echo esc_attr($link_target); ?>" title="<?php echo esc_attr($link_title); ?>">
                                <? if ($background_image_url) : ?>
                                    <img src="<?php echo esc_url($background_image_url); ?>" class="cover-image" alt="<?php echo esc_attr($caption_text); ?>">
                                <?php endif; ?>
                                <span class="industries__slide-caption title-sm"><?php echo esc_html($caption_text); ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <button type="button" class="industries__slider-prev swiper-button-prev"></button>
                <button type="button" class="industries__slider-next swiper-button-next"></button>
            </div>
        </div>
    </div>
<?php endif; ?>