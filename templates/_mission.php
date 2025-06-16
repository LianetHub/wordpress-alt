<?php

$mission_data = get_field('mission_block');

if ($mission_data):

    $mission_title_text         = $mission_data['mission_title_text'] ?? '';
    $mission_description        = $mission_data['mission_description'] ?? '';
    $mission_quote_text         = $mission_data['mission_quote_text'] ?? '';
    $mission_author_name        = $mission_data['mission_author_name'] ?? '';
    $mission_author_position    = $mission_data['mission_author_position'] ?? '';
    $mission_founder_image      = $mission_data['mission_founder_image'] ?? []; // Массив данных изображения
    $mission_document_image     = $mission_data['mission_document_image'] ?? []; // Массив данных изображения
    $mission_document_cite_text = $mission_data['mission_document_cite_text'] ?? '';
    $mission_content_title      = $mission_data['mission_content_title'] ?? '';
    $mission_content_tagline    = $mission_data['mission_content_tagline'] ?? '';
    $mission_content_body       = $mission_data['mission_content_body'] ?? '';

    if (
        $mission_title_text || $mission_description || $mission_quote_text || $mission_founder_image ||
        $mission_document_image || $mission_document_cite_text || $mission_content_title ||
        $mission_content_tagline || $mission_content_body
    ):
?>
        <section class="mission">
            <div class="container">
                <div class="mission__header">
                    <div class="mission__main">
                        <?php if ($mission_title_text): ?>
                            <h2 class="mission__title title text-uppercase"><?php echo esc_html($mission_title_text); ?></h2>
                        <?php endif; ?>
                        <?php if ($mission_description): ?>
                            <p class="mission__desc">
                                <?php echo nl2br(esc_html($mission_description)); ?>
                            </p>
                        <?php endif; ?>
                        <?php if ($mission_quote_text || $mission_author_name || $mission_author_position): ?>
                            <div class="mission__footer">
                                <?php if ($mission_quote_text): ?>
                                    <blockquote class="mission__quote">
                                        <?php echo nl2br(esc_html($mission_quote_text)); ?>
                                    </blockquote>
                                <?php endif; ?>
                                <?php if ($mission_author_name || $mission_author_position): ?>
                                    <div class="mission__author">
                                        <?php if ($mission_author_name): ?>
                                            <div class="mission__author-name"><?php echo esc_html($mission_author_name); ?></div>
                                        <?php endif; ?>
                                        <?php if ($mission_author_position): ?>
                                            <div class="mission__author-position"><?php echo esc_html($mission_author_position); ?></div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($mission_founder_image) && isset($mission_founder_image['url'])): ?>
                        <div class="mission__founder">
                            <img src="<?= esc_url($mission_founder_image['sizes']['large'] ?? $mission_founder_image['url']); ?>" class="cover-image" alt="<?= esc_attr($mission_founder_image['alt']); ?>">
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mission__body">
                    <?php if (!empty($mission_document_image) || $mission_document_cite_text): ?>
                        <div class="mission__image">
                            <?php if (!empty($mission_document_image) && isset($mission_document_image['url'])): ?>
                                <div class="mission__image-document">
                                    <img src="<?= esc_url($mission_document_image['url']); ?>" alt="<?= esc_attr($mission_document_image['alt']); ?>">
                                </div>
                            <?php endif; ?>
                            <?php if ($mission_document_cite_text): ?>
                                <cite class="mission__image-cite">
                                    <?php
                                    $cite_lines = explode("\n", $mission_document_cite_text);
                                    foreach ($cite_lines as $line) {
                                        if (trim($line) !== '') {
                                            echo '<span>' . esc_html(trim($line)) . '</span>';
                                        }
                                    }
                                    ?>
                                </cite>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($mission_content_title || $mission_content_tagline || $mission_content_body): ?>
                        <div class="mission__content">
                            <?php if ($mission_content_title): ?>
                                <h3 class="mission__content-title title text-uppercase"><?php echo esc_html($mission_content_title); ?></h3>
                            <?php endif; ?>
                            <?php if ($mission_content_tagline): ?>
                                <p class="mission__content-tagline title-sm"><?php echo nl2br(esc_html($mission_content_tagline)); ?></p>
                            <?php endif; ?>
                            <?php if ($mission_content_body): ?>
                                <div class="mission__content-body">
                                    <?php echo wp_kses_post($mission_content_body); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
<?php
    endif;
endif;
?>