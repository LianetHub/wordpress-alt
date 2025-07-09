<?php

/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We recommend you read more here:
 * https://docs.woocommerce.com/document/template-structure/
 *
 * @see     https://docs.woocommerce.com/document/single-product-page-display/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

get_header();
?>

<?php while (have_posts()) : the_post(); ?>

	<?php
	global $product;
	if (!$product) {
		wc_get_template_part('content', 'single-product');
		continue;
	}


	$attachment_ids = $product->get_gallery_image_ids();

	$main_image_id = $product->get_image_id();
	if ($main_image_id && !in_array($main_image_id, $attachment_ids)) {

		array_unshift($attachment_ids, $main_image_id);
	} elseif (!$main_image_id && empty($attachment_ids)) {
		$attachment_ids = array(wc_placeholder_img_src());
	} elseif ($main_image_id && empty($attachment_ids)) {
		$attachment_ids = array($main_image_id);
	}
	?>

	<section class="product-card">
		<div class="container">
			<nav class="breadcrumbs">
				<?php

				if (function_exists('woocommerce_breadcrumb')) {
					woocommerce_breadcrumb(array(
						'delimiter'   => ' / ',
						'wrap_before' => '',
						'wrap_after'  => '',
						'before'      => '<span>',
						'after'       => '</span>',
						'home'        => _x('Главная страница', 'breadcrumb', 'woocommerce'),
					));
				}
				?>
			</nav>
			<div class="product-card__header">
				<div class="product-card__images">
					<div class="product-card__slider swiper">
						<div class="swiper-wrapper">
							<?php

							if (!empty($attachment_ids)) {
								foreach ($attachment_ids as $attachment_id) {
									$image_full_url = wp_get_attachment_image_url($attachment_id, 'full'); // URL полного изображения
									$image_thumbnail_url = wp_get_attachment_image_url($attachment_id, 'woocommerce_single'); // URL для основного изображения продукта
									if ($image_full_url && $image_thumbnail_url) {
										echo '<a href="' . esc_url($image_full_url) . '" class="product-card__slide swiper-slide" data-fancybox="product">';
										echo '<img src="' . esc_url($image_thumbnail_url) . '" alt="' . esc_attr(get_post_meta($attachment_id, '_wp_attachment_image_alt', true) ?: $product->get_name()) . '">';
										echo '</a>';
									} elseif (is_string($attachment_id) && strpos($attachment_id, 'placeholder') !== false) {

										echo '<a href="' . esc_url($attachment_id) . '" class="product-card__slide swiper-slide" data-fancybox="product">';
										echo '<img src="' . esc_url($attachment_id) . '" alt="' . esc_attr($product->get_name()) . '">';
										echo '</a>';
									}
								}
							} else {
								echo '<a href="' . esc_url(wc_placeholder_img_src()) . '" class="product-card__slide swiper-slide" data-fancybox="product">';
								echo '<img src="' . esc_url(wc_placeholder_img_src()) . '" alt="' . esc_attr($product->get_name()) . '">';
								echo '</a>';
							}
							?>
						</div>
						<button type="button" class="product-card__prev swiper-button-prev swiper-button-dark"></button>
						<button type="button" class="product-card__next swiper-button-next swiper-button-dark"></button>
					</div>
					<div class="product-card__thumbs swiper">
						<div class="swiper-wrapper">
							<?php

							if (!empty($attachment_ids)) {
								foreach ($attachment_ids as $attachment_id) {
									$image_thumb_url = wp_get_attachment_image_url($attachment_id, 'woocommerce_gallery_thumbnail');
									if ($image_thumb_url) {
										echo '<div class="product-card__thumb swiper-slide">';
										echo '<img src="' . esc_url($image_thumb_url) . '" alt="' . esc_attr(get_post_meta($attachment_id, '_wp_attachment_image_alt', true) ?: $product->get_name()) . '">';
										echo '</div>';
									} elseif (is_string($attachment_id) && strpos($attachment_id, 'placeholder') !== false) {

										echo '<div class="product-card__thumb swiper-slide">';
										echo '<img src="' . esc_url($attachment_id) . '" alt="' . esc_attr($product->get_name()) . '">';
										echo '</div>';
									}
								}
							} else {

								echo '<div class="product-card__thumb swiper-slide">';
								echo '<img src="' . esc_url(wc_placeholder_img_src()) . '" alt="' . esc_attr($product->get_name()) . '">';
								echo '</div>';
							}
							?>
						</div>
					</div>
				</div>
				<div class="product-card__main">
					<div class="product-card__heading">
						<?php if ($sku = $product->get_sku()) : ?>
							<div class="product-card__articul">Артикул: <?= esc_html($sku) ?></div>
						<?php endif; ?>

						<?php
						if ($product->is_in_stock()) {
							echo '<div class="product-card__availability icon-check-circle in-stock">в наличии на складе</div>';
						} else {
							echo '<div class="product-card__availability icon-check-circle not-available">Нет в наличии</div>';
						}
						?>
					</div>
					<h1 class="product-card__title">
						<?php
						$product_title = get_field('product_full_title');
						if (empty($product_title)) {
							$product_title = $product->get_name();
						}
						echo fix_widows_after_prepositions(esc_html($product_title));
						?>
					</h1>
					<div class="product-card__info">
						<?php
						$manufacturer = get_field('product_manufacturer');
						$country = get_field('product_country');

						if ($manufacturer) : ?>
							<div class="product-card__info-item">
								Производитель: <?= esc_html($manufacturer) ?>
							</div>
						<?php endif; ?>

						<?php if ($country) : ?>
							<div class="product-card__info-item">
								Страна производства: <?= esc_html($country) ?>
							</div>
						<?php endif; ?>
					</div>
					<div class="product-card__desc">
						<?php if ($product->get_description()) : ?>
							<div class="product-card__desc-block">
								<div class="product-card__desc-caption title-sm">Описание:</div>
								<div class="product-card__desc-text"><?php the_content(); ?></div>
							</div>
						<?php endif; ?>

						<?php
						$application = get_field('product_application');
						if ($application) : ?>
							<div class="product-card__desc-block">
								<div class="product-card__desc-caption title-sm">Применение:</div>
								<div class="product-card__desc-text"><?= wp_kses_post($application) ?></div>
							</div>
						<?php endif; ?>

						<?php

						$product_categories = wc_get_product_category_list($product->get_id(), ', ', '<div class="product-card__desc-block"><div class="product-card__desc-caption title-sm">Категории:</div><div class="product-card__desc-text"><ul><li>', '</li></ul></div></div>');
						if ($product_categories) : ?>
							<?= str_replace(',', '</li><li>', $product_categories);
							?>
						<?php endif; ?>
					</div>
					<a href="#commercial-offer" data-fancybox class="product-card__btn btn btn-primary btn-lg">Запросить стоимость</a>
				</div>
			</div>
		</div>
	</section>

	<div class="product-stats">
		<div class="container">
			<div class="product-stats__body">
				<div class="product-stats__tabs">
					<button type="button" class="product-stats__tab icon-next active">Технические характеристики</button>
					<button type="button" class="product-stats__tab icon-next">Документация</button>
					<button type="button" class="product-stats__tab icon-next">Возможные аналоги</button>
				</div>
				<div class="product-stats__content">
					<div class="product-stats__block active">
						<?php

						$technical_specs_string = get_field('technical_specs');

						if (!empty($technical_specs_string)) :
							$specs = explode("\n", $technical_specs_string);
							$specs = array_filter(array_map('trim', $specs));
							if (!empty($specs)) : ?>
								<ul class="product-stats__list">
									<?php foreach ($specs as $spec_item) : ?>
										<li><?= esc_html($spec_item) ?></li>
									<?php endforeach; ?>
								</ul>
							<?php else : ?>
								<p>Технические характеристики отсутствуют.</p>
							<?php endif; ?>
						<?php else : ?>
							<p>Технические характеристики отсутствуют.</p>
						<?php endif; ?>
					</div>
					<div class="product-stats__block">
						<div class="product-stats__docs">
							<?php
							if (have_rows('product_documentation')) : ?>
								<?php while (have_rows('product_documentation')) : the_row(); ?>
									<?php
									$doc_file = get_sub_field('doc_file');
									$doc_title = get_sub_field('doc_title');
									if ($doc_file && $doc_file['url']) : ?>
										<a href="<?= esc_url($doc_file['url']) ?>" download class="product-stats__doc icon-download">
											<span><?= esc_html($doc_title ?: basename($doc_file['url'])) ?></span>
										</a>
									<?php endif; ?>
								<?php endwhile; ?>
							<?php else : ?>
								<p>Документация отсутствует.</p>
							<?php endif; ?>
						</div>
					</div>
					<div class="product-stats__block">
						<div class="recommendation__body">
							<div class="recommendation__slider swiper">
								<div class="swiper-wrapper">
									<?php

									$related_products = wc_get_related_products($product->get_id(), 6);
									if (!empty($related_products)) {
										foreach ($related_products as $related_product_id) {
											$related_product = wc_get_product($related_product_id);
											if ($related_product && $related_product->is_visible()) {
									?>
												<div class="swiper-slide product-slide">
													<a href="<?= esc_url($related_product->get_permalink()) ?>" class="product-slide__img">
														<?= $related_product->get_image('medium')
														?>
													</a>
													<a href="<?= esc_url($related_product->get_permalink()) ?>" class="product-slide__title"><?= esc_html($related_product->get_name()) ?></a>
													<?php if ($related_product->is_in_stock()) : ?>
														<div class="product-slide__availability in-stock">В наличии</div>
													<?php else : ?>
														<div class="product-slide__availability not-available">Нет в наличии</div>
													<?php endif; ?>
													<a href="<?= esc_url($related_product->get_permalink()) ?>" class="product-slide__btn btn btn-primary">Подробнее</a>
												</div>
									<?php
											}
										}
									} else {
										echo '<p class="no-analogs">Возможные аналоги отсутствуют.</p>';
									}
									?>
								</div>
							</div>
							<button type="button" class="recommendation__prev swiper-button-dark swiper-button-prev"></button>
							<button type="button" class="recommendation__next swiper-button-dark swiper-button-next"></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


<?php endwhile; // End of the loop. 
?>

<?php get_footer(); ?>