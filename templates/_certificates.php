<?php if (have_rows('сertificates', 'option')): ?>
    <?php
    $is_certificates_page = is_page(117);
    $extra_class = $is_certificates_page ? ' сertificates--white' : '';
    $tag = $is_certificates_page ? 'div' : 'section';
    ?>
    <<?= $tag ?> class="сertificates<?= $extra_class ?>">
        <div class="container">
            <?php if (!$is_certificates_page):  ?>
                <h2 class="сertificates__title title text-uppercase">Сертификаты</h2>
            <?php endif; ?>
            <div class="сertificates__body">
                <div class="сertificates__slider swiper">
                    <div class="swiper-wrapper">
                        <?php while (have_rows('сertificates', 'option')): the_row();
                            $review_image = get_sub_field('сertificates_image');
                            $image_url = $review_image['url'] ?? '';
                            $image_alt_text = $review_image['alt'] ?? '';

                            if (empty($image_alt_text)) {
                                $image_alt_text = $review_image['title'] ?? 'Изображение сертификата';
                            }
                        ?>
                            <a href="<?php echo esc_url($image_url); ?>" data-fancybox="сertificates" class="сertificates__slide swiper-slide">
                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt_text); ?>">
                            </a>
                        <?php endwhile; ?>
                    </div>
                </div>
                <button type="button" class="сertificates__slider-prev swiper-button-prev swiper-button-dark"></button>
                <button type="button" class="сertificates__slider-next swiper-button-next swiper-button-dark"></button>
            </div>
            <?php
            $certificate_pdf_url = '';
            if ($is_certificates_page) {
                $certificate_pdf_file_array = get_field('certificate_pdf_url');

                if ($certificate_pdf_file_array && is_array($certificate_pdf_file_array) && isset($certificate_pdf_file_array['url'])) {
                    $certificate_pdf_url = $certificate_pdf_file_array['url'];
                }
            }
            ?>
            <?php if ($certificate_pdf_url && $is_certificates_page) : ?>
                <a href="<?= esc_url($certificate_pdf_url) ?>" download class="сertificates__download icon-download"><span>Открыть в PDF</span></a>
            <?php endif; ?>
        </div>
    </<?= $tag ?>>
<?php endif; ?>