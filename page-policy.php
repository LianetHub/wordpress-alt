<?php

/**
 * Template Name: Policy Page Template
 */
?>
<?php
get_header();
?>

<?php require_once(TEMPLATE_PATH . '_promo.php'); ?>
<div class="article">
    <div class="container">
        <div class="article__content">
            <article class="article__body">
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        the_content();
                    endwhile;
                endif;
                ?>
            </article>
        </div>
    </div>
</div>




<?php get_footer(); ?>