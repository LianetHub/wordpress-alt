<?php if (have_rows('team_members', 'option')): ?>
    <section class="team">
        <div class="container">
            <h2 class="team__title title text-uppercase">Наша команда</h2>
            <div class="team__body">
                <div class="team__slider swiper">
                    <div class="swiper-wrapper">
                        <?php while (have_rows('team_members', 'option')): the_row();

                            $member_photo = get_sub_field('member_photo');
                            $member_name = get_sub_field('member_name');
                            $member_position = get_sub_field('member_position');

                            $photo_url = $member_photo['url'] ?? '';
                            $photo_alt_text = $member_photo['alt'] ?? '';

                            if (empty($photo_alt_text) && !empty($member_name)) {
                                $photo_alt_text = 'Фотография ' . $member_name;
                            } elseif (empty($photo_alt_text)) {
                                $photo_alt_text = 'Фотография члена команды';
                            }
                        ?>
                            <div class="team__slide swiper-slide">
                                <?php if ($photo_url): ?>
                                    <div class="team__slide-thumb">
                                        <img src="<?php echo esc_url($photo_url); ?>" class="cover-image" alt="<?php echo esc_attr($photo_alt_text); ?>">
                                    </div>
                                <?php endif; ?>
                                <?php if ($member_name): ?>
                                    <div class="team__slide-name title-sm"><?php echo esc_html($member_name); ?></div>
                                <?php endif; ?>
                                <?php if ($member_position): ?>
                                    <div class="team__slide-position"><?php echo esc_html($member_position); ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <button type="button" class="team__slider-prev swiper-button-prev swiper-button-dark"></button>
                <button type="button" class="team__slider-next swiper-button-next swiper-button-dark"></button>
            </div>
        </div>
    </section>
<?php endif; ?>