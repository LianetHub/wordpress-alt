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
										echo '<a href="' . esc_url($image_full_url) . '" class="product-card__slide swiper-slide" data-gallery="product">';
										echo '<img src="' . esc_url($image_thumbnail_url) . '" alt="' . esc_attr(get_post_meta($attachment_id, '_wp_attachment_image_alt', true) ?: $product->get_name()) . '">';
										echo '</a>';
									} elseif (is_string($attachment_id) && strpos($attachment_id, 'placeholder') !== false) {

										echo '<a href="' . esc_url($attachment_id) . '" class="product-card__slide swiper-slide" data-gallery="product">';
										echo '<img src="' . esc_url($attachment_id) . '" alt="' . esc_attr($product->get_name()) . '">';
										echo '</a>';
									}
								}
							} else {
								echo '<a href="' . esc_url(wc_placeholder_img_src()) . '" class="product-card__slide swiper-slide" data-gallery="product">';
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
						<?php the_title(); ?>
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
						<!-- otrasli -->

					</div>
					<a href="#request-quote" data-fancybox class="product-card__btn btn btn-primary btn-lg">Запросить стоимость</a>
				</div>
			</div>
		</div>
	</section>

	<?php
	$technical_specs_string = get_field('technical_specs');
	$has_technical_specs = !empty($technical_specs_string) && !empty(array_filter(array_map('trim', explode("\n", $technical_specs_string))));

	$has_documentation = false;
	$documentation_rows = get_field('product_documentation');
	if (!empty($documentation_rows) && is_array($documentation_rows)) {
		foreach ($documentation_rows as $doc_row) {
			$doc_file_url = $doc_row['doc_file'] ?? '';
			if (!empty($doc_file_url) && is_string($doc_file_url)) {
				$has_documentation = true;
				break;
			}
		}
	}

	$related_products_check = wc_get_related_products($product->get_id(), 6);
	// $has_analogs = !empty($related_products_check);
	$has_analogs = false;

	if ($has_technical_specs || $has_documentation || $has_analogs) :
		$active_tab_class_tech = '';
		$active_tab_class_docs = '';
		$active_tab_class_analogs = '';

		$active_content_class_tech = '';
		$active_content_class_docs = '';
		$active_content_class_analogs = '';

		$default_tab_id = '';
		if ($has_technical_specs) {
			$default_tab_id = 'tech-specs';
		} elseif ($has_documentation) {
			$default_tab_id = 'documentation';
		} elseif ($has_analogs) {
			$default_tab_id = 'analogs';
		}

		if ($default_tab_id === 'tech-specs') {
			$active_tab_class_tech = 'active';
			$active_content_class_tech = 'active';
		} elseif ($default_tab_id === 'documentation') {
			$active_tab_class_docs = 'active';
			$active_content_class_docs = 'active';
		} elseif ($default_tab_id === 'analogs') {
			$active_tab_class_analogs = 'active';
			$active_content_class_analogs = 'active';
		}
	?>
		<div class="product-stats">
			<div class="container">
				<div class="product-stats__body">
					<div class="product-stats__tabs">
						<?php if ($has_technical_specs) : ?>
							<button type="button" class="product-stats__tab <?= $active_tab_class_tech ?>" data-tab="tech-specs">Технические характеристики</button>
						<?php endif; ?>

						<?php if ($has_documentation) : ?>
							<button type="button" class="product-stats__tab <?= $active_tab_class_docs ?>" data-tab="documentation">Документация</button>
						<?php endif; ?>

						<?php if ($has_analogs) : ?>
							<button type="button" class="product-stats__tab <?= $active_tab_class_analogs ?>" data-tab="analogs">Возможные аналоги</button>
						<?php endif; ?>
					</div>

					<div class="product-stats__content">
						<?php if ($has_technical_specs) : ?>
							<div class="product-stats__block <?= $active_content_class_tech ?>" data-tab-content="tech-specs">
								<button type="button" class="product-stats__mobile-tab icon-next <?= $active_tab_class_tech ?>" data-tab="tech-specs">Технические характеристики</button>
								<div class="product-stats__block-content">
									<?php
									$specs = array_filter(array_map('trim', explode("\n", $technical_specs_string)));
									if (!empty($specs)) : ?>
										<ul class="product-stats__list">
											<?php foreach ($specs as $spec_item) : ?>
												<li><?= esc_html($spec_item) ?></li>
											<?php endforeach; ?>
										</ul>
									<?php else : ?>
										<p>Технические характеристики отсутствуют.</p>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>

						<?php if ($has_documentation) : ?>
							<div class="product-stats__block <?= $active_content_class_docs ?>" data-tab-content="documentation">
								<button type="button" class="product-stats__mobile-tab icon-next <?= $active_tab_class_docs ?>" data-tab="documentation">Документация</button>
								<div class="product-stats__block-content">
									<div class="product-stats__docs">
										<?php
										if (!empty($documentation_rows) && is_array($documentation_rows)) :
											foreach ($documentation_rows as $doc_row) :
												$doc_file_url = $doc_row['doc_file'] ?? '';
												$doc_title = $doc_row['doc_title'] ?? '';

												if (!empty($doc_file_url) && is_string($doc_file_url)) :
													$display_title = !empty($doc_title) ? $doc_title : basename($doc_file_url);
										?>
													<a href="<?= esc_url($doc_file_url) ?>" download class="product-stats__doc icon-download">
														<span><?= esc_html($display_title) ?></span>
													</a>
											<?php
												endif;
											endforeach;
										else :
											?>
											<p>Документация отсутствует.</p>
										<?php
										endif;
										?>
									</div>
								</div>
							</div>
						<?php endif; ?>

						<?php if ($has_analogs) : ?>
							<div class="product-stats__block <?= $active_content_class_analogs ?>" data-tab-content="analogs">
								<button type="button" class="product-stats__mobile-tab icon-next <?= $active_tab_class_analogs ?>" data-tab="analogs">Возможные аналоги</button>
								<div class="product-stats__block-content">
									<div class="recommendation__body">
										<div class="recommendation__slider swiper">
											<div class="swiper-wrapper">
												<?php
												foreach ($related_products_check as $related_product_id) {
													$related_product = wc_get_product($related_product_id);
													if ($related_product && $related_product->is_visible()) {
												?>
														<div class="swiper-slide product">
															<a href="<?= esc_url($related_product->get_permalink()) ?>" class="product__image">
																<?= $related_product->get_image('medium') ?>
															</a>
															<a href="<?= esc_url($related_product->get_permalink()) ?>" class="product__name">
																<?php
																$product_full_title = get_field('product_full_title', $related_product->get_id());
																if (empty($product_full_title)) {
																	$product_full_title = $related_product->get_name();
																}
																if (function_exists('fix_widows_after_prepositions')) {
																	echo fix_widows_after_prepositions(esc_html($product_full_title));
																} else {
																	echo esc_html($product_full_title);
																}
																?>
															</a>
														</div>
												<?php
													}
												}
												?>
											</div>
										</div>
										<button type="button" class="recommendation__prev swiper-button-dark swiper-button-prev"></button>
										<button type="button" class="recommendation__next swiper-button-dark swiper-button-next"></button>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>


<?php endwhile;
?>

<?php get_footer(); ?>