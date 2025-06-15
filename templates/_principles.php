<?php

$company_principles_group = get_field('company_principles', 'option');


if ($company_principles_group):

    $principles_title = $company_principles_group['principles_title'] ?? '';
    $principles_description = $company_principles_group['principles_description'] ?? '';
    $principles_list_items = $company_principles_group['principles_list_items'] ?? [];


    if (!empty($principles_list_items)):
?>
        <section class="principles">
            <div class="container">
                <div class="principles__header">
                    <?php if ($principles_title): ?>
                        <h2 class="principles__title title text-uppercase">
                            <?php echo nl2br(esc_html($principles_title));
                            ?>
                        </h2>
                    <?php endif; ?>
                    <?php if ($principles_description): ?>
                        <div class="principles__desc">
                            <?php echo fix_widows_after_prepositions(wp_kses_post($principles_description)); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <ol class="principles__list">
                    <?php
                    foreach ($principles_list_items as $principle_item):
                        $principle_caption = $principle_item['item_caption'] ?? '';
                        $principle_sub_items = $principle_item['principle_sub_items'] ?? [];
                    ?>
                        <li class="principles__item">
                            <?php if ($principle_caption): ?>
                                <div class="principles__item-caption text-uppercase">
                                    <?php echo esc_html($principle_caption); ?>
                                </div>
                            <?php endif; ?>

                            <?php

                            if (!empty($principle_sub_items)):
                            ?>
                                <ul class="principles__item-list">
                                    <?php

                                    foreach ($principle_sub_items as $sub_item):
                                        $sub_item_text = $sub_item['sub_item_text'] ?? '';
                                    ?>
                                        <?php if ($sub_item_text): ?>
                                            <li><?php echo fix_widows_after_prepositions(esc_html($sub_item_text)); ?></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </section>
<?php
    endif;
endif;
?>