<?php

$company_data = get_field('company_block');


if ($company_data):
    $company_header_text = $company_data['company_header_text'] ?? '';
    $company_gallery_images = $company_data['company_gallery_images'] ?? [];
    $company_tagline = $company_data['company_tagline'] ?? '';
    $company_content_blocks = $company_data['company_content_blocks'] ?? [];

    if ($company_header_text || !empty($company_gallery_images) || $company_tagline || !empty($company_content_blocks)):
?>
        <div class="company">
            <div class="container">
                <?php if ($company_header_text): ?>
                    <div class="company__header">
                        <?php echo wp_kses_post($company_header_text); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($company_gallery_images)): ?>
                    <div class="company__gallery">
                        <div class="company__gallery-slider swiper">
                            <div class="swiper-wrapper">
                                <?php foreach ($company_gallery_images as $image): ?>
                                    <a href="<?= esc_url($image['url']); ?>" data-fancybox="company" class="company__slide swiper-slide">
                                        <img src="<?= esc_url($image['sizes']['large'] ?? $image['url']); ?>" class="cover-image" alt="<?= esc_attr($image['alt']); ?>">
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <button type="button" class="company__gallery-prev swiper-button-prev"></button>
                        <button type="button" class="company__gallery-next swiper-button-next"></button>
                    </div>
                <?php endif; ?>

                <?php if ($company_tagline): ?>
                    <div class="company__tagline title-sm">
                        <?php echo nl2br(esc_html($company_tagline)); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($company_content_blocks)): ?>
                    <div class="company__body">
                        <?php foreach ($company_content_blocks as $block): ?>
                            <?php
                            $block_description = $block['block_description'] ?? '';
                            $block_image = $block['block_image'] ?? [];
                            ?>
                            <?php if ($block_description || !empty($block_image)): ?>
                                <div class="company__block">
                                    <?php if ($block_description): ?>
                                        <div class="company__desc">
                                            <?php echo wp_kses_post($block_description); ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($block_image) && isset($block_image['url'])): ?>
                                        <div class="company__image">
                                            <img src="<?= esc_url($block_image['sizes']['large'] ?? $block_image['url']); ?>" class="cover-image" alt="<?= esc_attr($block_image['alt']); ?>">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
<?php
    endif;
endif;
?>