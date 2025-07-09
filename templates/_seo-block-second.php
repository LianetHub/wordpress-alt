<?php

if (!isset($object_id_for_acf) || empty($object_id_for_acf)) {
    $object_id_for_acf = get_the_ID();
}



$headings = [];
$heading_counter = 0;

if (function_exists('have_rows')) {
    if (have_rows('secondary_seo_content_blocks', $object_id_for_acf)) {
        while (have_rows('secondary_seo_content_blocks', $object_id_for_acf)) : the_row();
            $current_layout = get_row_layout();
            $heading_text = '';

            if ($current_layout == 'heading_h1') {
                $heading_text = get_sub_field('h1_text');
            } elseif ($current_layout == 'heading_h2') {
                $heading_text = get_sub_field('h2_text');
            } elseif ($current_layout == 'heading_h3') {
                $heading_text = get_sub_field('h3_text');
            } elseif ($current_layout == 'heading_h4') {
                $heading_text = get_sub_field('h4_text');
            } elseif ($current_layout == 'heading_h5') {
                $heading_text = get_sub_field('h5_text');
            } elseif ($current_layout == 'heading_h6') {
                $heading_text = get_sub_field('h6_text');
            }

            if (!empty($heading_text)) {
                $slugified_text = cyrillicToLatin($heading_text);
                $heading_id = $slugified_text . '-' . $heading_counter;
                $headings[] = [
                    'tag'  => str_replace('heading_', '', $current_layout),
                    'text' => $heading_text,
                    'id'   => $heading_id,
                ];
                $heading_counter++;
            }
        endwhile;

        if (function_exists('wp_reset_rows')) {
            wp_reset_rows();
        }
    }
}
?>

<?php if (function_exists('have_rows') && have_rows('secondary_seo_content_blocks', $object_id_for_acf)): ?>

    <section class="article">
        <div class="container">
            <div class="article__content ">
                <article class="article__seo-block">
                    <?php
                    static $output_heading_counter = 0;
                    $output_heading_counter = 0;
                    ?>
                    <?php while (have_rows('secondary_seo_content_blocks', $object_id_for_acf)) : the_row();

                        $margin_bottom_desktop = get_sub_field('margin_bottom_desktop');
                        $margin_bottom_mobile = get_sub_field('margin_bottom_mobile');

                        $style_vars = '';
                        if (!empty($margin_bottom_desktop)) {
                            $style_vars .= '--desktop-offset: ' . esc_attr($margin_bottom_desktop) . ';';
                        }
                        if (!empty($margin_bottom_mobile)) {
                            $style_vars .= ' --mobile-offset: ' . esc_attr($margin_bottom_mobile) . ';';
                        }

                        $current_layout = get_row_layout();
                        $current_heading_id = '';

                        if (in_array($current_layout, ['heading_h1', 'heading_h2', 'heading_h3', 'heading_h4', 'heading_h5', 'heading_h6'])) {
                            if (isset($headings[$output_heading_counter])) {
                                $current_heading_id = $headings[$output_heading_counter]['id'];
                            }
                            $output_heading_counter++;
                        }
                    ?>

                        <?php if ($current_layout == 'heading_h1') :
                            $h1_text = get_sub_field('h1_text'); ?>
                            <h1 id="<?php echo esc_attr($current_heading_id); ?>" class="text-uppercase" style="<?php echo esc_attr($style_vars); ?>"><?php echo esc_html($h1_text); ?></h1>

                        <?php elseif ($current_layout == 'heading_h2') :
                            $h2_text = get_sub_field('h2_text'); ?>
                            <h2 id="<?php echo esc_attr($current_heading_id); ?>" style="<?php echo esc_attr($style_vars); ?>"><?php echo esc_html($h2_text); ?></h2>

                        <?php elseif ($current_layout == 'heading_h3') :
                            $h3_text = get_sub_field('h3_text'); ?>
                            <h3 id="<?php echo esc_attr($current_heading_id); ?>" style="<?php echo esc_attr($style_vars); ?>"><?php echo esc_html($h3_text); ?></h3>

                        <?php elseif ($current_layout == 'heading_h4') :
                            $h4_text = get_sub_field('h4_text'); ?>
                            <h4 id="<?php echo esc_attr($current_heading_id); ?>" style="<?php echo esc_attr($style_vars); ?>"><?php echo esc_html($h4_text); ?></h4>

                        <?php elseif ($current_layout == 'heading_h5') :
                            $h5_text = get_sub_field('h5_text'); ?>
                            <h5 id="<?php echo esc_attr($current_heading_id); ?>" style="<?php echo esc_attr($style_vars); ?>"><?php echo esc_html($h5_text); ?></h5>

                        <?php elseif ($current_layout == 'heading_h6') :
                            $h6_text = get_sub_field('h6_text'); ?>
                            <h6 id="<?php echo esc_attr($current_heading_id); ?>" style="<?php echo esc_attr($style_vars); ?>"><?php echo esc_html($h6_text); ?></h6>

                        <?php elseif ($current_layout == 'text_block') :
                            $content_text = get_sub_field('content_text');
                            $has_columns = get_sub_field('columns');

                            $text_block_class = 'seo-text-block';

                            $child_count = 0;
                            $has_read_more = false;

                            if ($has_columns && !empty($content_text)) {
                                $dom = new DOMDocument();
                                @$dom->loadHTML('<div>' . $content_text . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                                if ($dom->documentElement) {
                                    foreach ($dom->documentElement->childNodes as $node) {
                                        if ($node->nodeType === XML_ELEMENT_NODE) {
                                            $child_count++;
                                        }
                                    }
                                }

                                if ($child_count > 3) {
                                    $has_read_more = true;
                                }
                            }
                        ?>
                            <div class="<?php echo esc_attr($text_block_class); ?>" style="<?php echo esc_attr($style_vars); ?>">
                                <?php if ($has_columns) : ?>
                                    <div class="seo-text-block__columns">
                                        <?php echo wp_kses_post($content_text); ?>
                                    </div>
                                    <?php if ($has_read_more) : ?>
                                        <button type="button" class="seo-text-block__more more-link icon-arrow">Читать полностью</button>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <?php echo wp_kses_post($content_text); ?>
                                <?php endif; ?>
                            </div>

                        <?php elseif ($current_layout == 'variative_list') :
                            $list_format = get_sub_field('list_format');
                            $list_class = 'list-style-' . esc_attr($list_format);
                        ?>
                            <ul class="seo-list <?php echo $list_class; ?>" style="<?php echo esc_attr($style_vars); ?>">
                                <?php if (have_rows('list_items')) : ?>
                                    <?php while (have_rows('list_items')) : the_row();
                                        $list_item_text = get_sub_field('list_item_text'); ?>
                                        <li><?php echo esc_html($list_item_text); ?></li>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </ul>

                            <?php elseif ($current_layout == 'image_block') :
                            $image_array = get_sub_field('image');
                            $image_url = '';
                            $image_alt = '';

                            if ($image_array && is_array($image_array)) {
                                $image_url = $image_array['url'];
                                $image_alt = $image_array['alt'];
                            }
                            if ($image_url) : ?>
                                <div class="seo-image-block" style="<?php echo esc_attr($style_vars); ?>">
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                                </div>
                    <?php endif;
                        endif;
                    endwhile;
                    ?>
                </article>

                <?php
                if (count($headings) > 1) :
                ?>
                    <aside class="article__sidebar">
                        <nav>
                            <ul class="article__navbar-list">
                                <?php foreach ($headings as $heading) : ?>
                                    <li class="article__navbar-item article__navbar-item--<?php echo esc_attr($heading['tag']); ?>">
                                        <a href="#<?php echo esc_attr($heading['id']); ?>"><?php echo esc_html($heading['text']); ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </nav>
                    </aside>
                <?php endif; ?>
            </div>
        </div>
    </section>

<?php endif; ?>