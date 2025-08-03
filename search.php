<?php

/**
 * Search Results Template
 */
if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<?php require_once(TEMPLATE_PATH . '_promo.php'); ?>

<div class="search-page" id="main-search-page">
    <div class="container">
        <?php echo do_shortcode('[wpdreams_ajaxsearchlite]'); ?>

        <?php if (have_posts()) : ?>
            <ul class="search-page__results" id="main-search-result">
                <?php while (have_posts()) : the_post(); ?>
                    <?php
                    $search_value = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
                    $permalink = add_query_arg('asl_highlight', urlencode($search_value), get_permalink());
                    ?>
                    <li class="search-page__result">
                        <a href="<?php echo esc_url($permalink); ?>" class="search-page__result-block">
                            <?php if (has_post_thumbnail()) : ?>
                                <span class="search-page__result-thumb">
                                    <?php the_post_thumbnail('medium'); ?>
                                </span>
                            <?php endif; ?>

                            <span class="search-page__result-content">
                                <span class="search-page__result-name"><?php the_title(); ?></span>
                                <?php if (has_excerpt()) : ?>
                                    <span class="search-page__result-desc"><?php the_excerpt(); ?></span>
                                <?php else : ?>
                                    <span class="search-page__result-desc">
                                        <?php echo wp_trim_words(get_the_content(), 25, '...'); ?>
                                    </span>
                                <?php endif; ?>
                            </span>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>

            <div class="search-page__pagination pagination">
                <?php
                the_posts_pagination(array(
                    'show_all'     => false,
                    'end_size'     => 1,
                    'mid_size'     => 2,
                    'prev_next'    => true,
                    'prev_text'    => __('<span class="icon-left"></span>'),
                    'next_text'    => __('<span class="icon-right"></span>'),
                    'add_args'     => false,
                    'add_fragment' => '',
                    'screen_reader_text' => __('Posts navigation'),
                    'class'        => 'search-page__pagination',
                ));
                ?>
            </div>

        <?php else : ?>
            <div class="search-results__not-found">
                <p>По вашему запросу ничего не найдено.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once(TEMPLATE_PATH . '_offer.php'); ?>
<?php get_footer(); ?>