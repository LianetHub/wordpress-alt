<?php if (have_rows('seo_content_blocks')): ?>

    <section class="article">
        <div class="container">
            <div class="article__content">
                <article class="article__body">
                    <?php while (have_rows('seo_content_blocks')) : the_row();

                        $margin_bottom_desktop = get_sub_field('margin_bottom_desktop');
                        $margin_bottom_mobile = get_sub_field('margin_bottom_mobile');


                        $style_desktop = !empty($margin_bottom_desktop) ? 'margin-bottom: ' . $margin_bottom_desktop . ';' : '';
                        $style_mobile = !empty($margin_bottom_mobile) ? '--mb-mobile: ' . $margin_bottom_mobile . ';' : '';


                        if (get_row_layout() == 'heading_h2') :
                            $h2_text = get_sub_field('h2_text'); ?>
                            <h2 class="text-uppercase" style="<?php echo esc_attr($style_desktop); ?> <?php echo esc_attr($style_mobile); ?>"><?php echo esc_html($h2_text); ?></h2>

                        <?php elseif (get_row_layout() == 'heading_h3') :
                            $h3_text = get_sub_field('h3_text'); ?>
                            <h3 class="text-uppercase" style="<?php echo esc_attr($style_desktop); ?> <?php echo esc_attr($style_mobile); ?>"><?php echo esc_html($h3_text); ?></h3>

                        <?php elseif (get_row_layout() == 'text_block') :
                            $content_text = get_sub_field('content_text'); ?>
                            <div class="seo-text-block" style="<?php echo esc_attr($style_desktop); ?> <?php echo esc_attr($style_mobile); ?>"><?php echo wp_kses_post($content_text); ?></div>

                        <?php elseif (get_row_layout() == 'variative_list') :
                            $list_format = get_sub_field('list_format');
                            $list_class = 'list-style-' . esc_attr($list_format);
                        ?>
                            <ul class="seo-list <?php echo $list_class; ?>" style="<?php echo esc_attr($style_desktop); ?> <?php echo esc_attr($style_mobile); ?>">
                                <?php if (have_rows('list_items')) :
                                ?>
                                    <?php while (have_rows('list_items')) : the_row();
                                        $list_item_text = get_sub_field('list_item_text'); ?>
                                        <li><?php echo esc_html($list_item_text); ?></li>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </ul>

                            <?php elseif (get_row_layout() == 'image_block') :
                            $image_url = get_sub_field('image');
                            if ($image_url) : ?>
                                <div class="seo-image-block" style="<?php echo esc_attr($style_desktop); ?> <?php echo esc_attr($style_mobile); ?>">
                                    <img src="<?php echo esc_url($image_url); ?>" alt="">
                                </div>
                    <?php endif;
                        endif;
                    endwhile;
                    ?>
                </article>
            </div>
        </div>
    </section>

<?php endif;
?>