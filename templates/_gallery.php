<?php
$all_images = get_field('product_gallery_images');
$images_per_page = 12;
$total_images = is_array($all_images) ? count($all_images) : 0;
$initial_images = array_slice($all_images, 0, $images_per_page);
$current_post_id = get_the_ID();

if ($total_images > 0) : ?>
    <div
        class="gallery"
        data-page="1"
        data-total-pages="<?php echo ceil($total_images / $images_per_page); ?>"
        data-post-id="<?php echo esc_attr($current_post_id); ?>">
        <div class="container">
            <div class="gallery__items">
                <?php foreach ($initial_images as $image) : ?>
                    <a href="<?php echo esc_url($image['url']); ?>" data-fancybox="product-gallery-group" class="gallery__link">
                        <img src="<?php echo esc_url($image['sizes']['large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="cover-image">
                    </a>
                <?php endforeach; ?>
            </div>

            <?php if ($total_images > $images_per_page) : ?>
                <button type="button" class="gallery__more btn btn-primary btn-lg">Показать еще</button>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>