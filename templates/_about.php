<?php

if (have_rows('about_block')):
    while (have_rows('about_block')): the_row();

        $about_title = get_sub_field('about_title');
        $about_subtitle = get_sub_field('about_subtitle');
        $about_text = get_sub_field('about_text');

        $about_image_url = get_sub_field('about_image');

?>
        <section class="about">
            <div class="about__wrapper">
                <div class="container">
                    <div class="about__body">
                        <div class="about__header">
                            <div class="container">
                                <?php if ($about_title): ?>
                                    <h2 class="about__title title text-uppercase"><?php echo esc_html($about_title); ?></h2>
                                <?php endif; ?>
                                <?php if ($about_subtitle):  ?>
                                    <div class="about__subtitle"><?php echo wp_kses_post($about_subtitle); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="about__bottom">
                            <div class="container">
                                <?php if ($about_text): ?>
                                    <div class="about__text"><?php echo wp_kses_post($about_text); ?></div>
                                <?php endif; ?>
                                <a href="#" class="about__link more-link icon-arrow">
                                    Подробнее о нас
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($about_image_url): ?>
                <div class="about__image">
                    <img src="<?php echo esc_url($about_image_url); ?>" class="cover-image" alt="<?php echo esc_attr($about_title); ?>">
                </div>
            <?php endif; ?>
        </section>

<?php endwhile;
endif; ?>