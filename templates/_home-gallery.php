<?php
$gallery_page_id = 14770;
$max_images_limit = 15;

$all_images = get_field('product_gallery_images', $gallery_page_id);

if (is_array($all_images)) {
    $all_images = array_reverse($all_images);
    $all_images = array_slice($all_images, 0, $max_images_limit);
}

$total_images = is_array($all_images) ? count($all_images) : 0;
$current_post_id = get_the_ID();

if ($total_images > 0) : ?>
    <section class="home-gallery-block">
        <div class="container">
            <div class="home-gallery-block__content">
                <div class="home-gallery-block__header">
                    <h2 class="home-gallery-block__title title text-uppercase">Галерея товаров</h2>
                    <a href="<?= get_permalink($gallery_page_id) ?>" class="home-gallery-block__link more-link icon-arrow">Все фотографии</a>
                </div>
                <div class="home-gallery-block__body">
                    <div class="home-gallery-block__slider swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($all_images as $image) : ?>
                                <div class="swiper-slide">
                                    <a href="<?php echo esc_url($image['url']); ?>" data-fancybox="home-gallery-group" class="gallery__link">
                                        <img src="<?php echo esc_url($image['sizes']['large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="cover-image">
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <button type="button" class="home-gallery-block__slider-prev swiper-button-prev swiper-button-dark"></button>
                    <button type="button" class="home-gallery-block__slider-next swiper-button-next swiper-button-dark"></button>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>