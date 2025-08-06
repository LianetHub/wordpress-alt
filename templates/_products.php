<section class="products">
    <div class="container">
        <div class="products__content">
            <?php
            $active_filters_count = 0;

            $chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();

            if (! empty($chosen_attributes)) {
                foreach ($chosen_attributes as $taxonomy_slug => $attribute_data) {
                    if (isset($attribute_data['terms']) && is_array($attribute_data['terms']) && !empty($attribute_data['terms'])) {
                        $active_filters_count += count($attribute_data['terms']);
                    }
                }
            }

            if ((isset($_GET['min_price']) && $_GET['min_price'] !== '') || (isset($_GET['max_price']) && $_GET['max_price'] !== '')) {
                $active_filters_count++;
            }


            $search_query_active = !empty(get_search_query());


            if ($active_filters_count > 0 || $search_query_active || is_active_sidebar('product-filters-sidebar')) :
            ?>
                <aside class="products__sidebar">
                    <form role="search" method="get" class="products__search" action="<?php echo esc_url(get_term_link(get_queried_object(), 'product_cat')); ?>">
                        <input type="text" name="product_search" class="products__search-input" placeholder="Поиск по каталогу" value="<?php echo get_query_var('product_search'); ?>">
                        <button type="submit" class="products__search-btn icon-search"></button>
                    </form>
                    <div class="products__filters">
                        <div class="products__filters-caption title-sm icon-next">
                            ФИЛЬТРЫ
                            <span class="products__filters-quantity">(<?php echo $active_filters_count; ?>)</span>
                        </div>
                        <div class="products__filters-blocks">
                            <?php echo do_shortcode('[yith_wcan_filters slug="default-preset"]'); ?>
                        </div>
                    </div>
                </aside>
            <?php endif; ?>
            <div class="products__body">
                <ul class="products__list">
                    <?php

                    if (have_posts()) :
                        while (have_posts()) : the_post();

                            global $product;
                            if (empty($product) || !is_a($product, 'WC_Product')) {
                                $product = wc_get_product(get_the_ID());
                            }

                            if ($product) :
                    ?>
                                <li class="product">
                                    <a href="<?php the_permalink(); ?>" class="product__image">
                                        <?php echo $product->get_image(); ?>
                                    </a>
                                    <a href="<?php the_permalink(); ?>" class="product__name">
                                        <?php
                                        $product_full_title = get_field('product_full_title', $product->get_id());

                                        if (empty($product_full_title)) {
                                            $product_full_title = $product->get_name();
                                        }

                                        if (function_exists('fix_widows_after_prepositions')) {
                                            echo fix_widows_after_prepositions(esc_html($product_full_title));
                                        } else {
                                            echo esc_html($product_full_title);
                                        } ?>
                                    </a>
                                    <a href="#request-quote" data-fancybox class="product__more more-link icon-arrow">Запросить стоимость</a>
                                </li>
                        <?php
                            endif;
                        endwhile;
                    else :

                        ?>
                        <p class="no-results"><?php esc_html_e('Ничего не найдено по вашему запросу.', 'your-theme-textdomain'); ?></p>
                    <?php
                    endif;
                    ?>
                </ul>

                <div class="products__bottom">
                    <?php

                    if (function_exists('woocommerce_pagination')) : ?>
                        <div class="products__pagination pagination">
                            <?php woocommerce_pagination(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>