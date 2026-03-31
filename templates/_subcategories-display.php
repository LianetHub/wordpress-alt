<section class="catalog catalog--subcategories">
    <div class="container">
        <h2 class="catalog__title title text-uppercase"><?php echo esc_html($current_term->name); ?></h2>
        <div class="catalog__body">
            <ul class="catalog__grid">
                <?php foreach ($sub_categories as $cat) :
                    $category_link = get_term_link($cat->term_id, 'product_cat');
                    $thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
                    $image_url = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : '';
                    $image_alt = $thumbnail_id ? get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true) : esc_attr($cat->name);

                    if (empty($image_url)) {
                        $image_url = get_template_directory_uri() . '/assets/img/placeholder-category.png';
                    }
                ?>
                    <li class="catalog__item">
                        <a href="<?php echo esc_url($category_link); ?>" class="catalog__card catalog__card--<?php echo esc_attr($cat->slug); ?>">
                            <span class="catalog__card-image">
                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                            </span>
                            <span class="catalog__card-name title-sm"><?php echo esc_html($cat->name); ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>