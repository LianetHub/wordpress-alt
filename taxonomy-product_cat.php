<?php
get_header();
?>

<?php require_once(TEMPLATE_PATH . '_promo.php'); ?>
<section class="products">
    <div class="container">
        <div class="products__content">
            <aside class="products__sidebar">
                <form role="search" method="get" class="products__search" action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="text" name="s" class="products__search-input" placeholder="Поиск по каталогу">
                    <input type="hidden" name="post_type" value="product">
                    <button type="submit" class="products__search-btn icon-search"></button>
                </form>
                <div class="products__filters">
                    <div class="products__filters-caption title-sm icon-next">
                        ФИЛЬТРЫ
                        <span class="products__filters-quantity">(1)</span>
                    </div>
                    <div class="products__filters-blocks">
                        <?php if (is_active_sidebar('product-filters')) : ?>
                            <?php dynamic_sidebar('product-filters'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </aside>
            <div class="products__body">
                <ul class="products__list">
                    <?php if (have_posts()) : ?>
                        <?php while (have_posts()) : the_post();
                            global $product; ?>
                            <li class="product">
                                <a href="<?php the_permalink(); ?>" class="product__image">
                                    <?php echo $product->get_image(); ?>
                                </a>
                                <a href="<?php the_permalink(); ?>" class="product__name"><?php the_title(); ?></a>
                                <a href="<?php the_permalink(); ?>" class="product__more more-link icon-arrow">Запросить стоимость</a>
                            </li>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <p>Товары не найдены.</p>
                    <?php endif; ?>
                </ul>

                <div class="products__bottom">
                    <?php if (woocommerce_pagination()) : ?>
                        <div class="products__pagination pagination">
                            <?php woocommerce_pagination(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once(TEMPLATE_PATH . '_offer.php'); ?>
<?php get_footer(); ?>