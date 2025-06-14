<?
$phone_number = get_field('phone_number', 'option');
$formatted_phone_number = preg_replace('/[^0-9+]/', '', $phone_number);
$telegram_url = get_field('telegram_url', 'option');
$whatsapp_url = get_field('whatsapp_url', 'option');
?>

<section class="callback">
    <div class="container">
        <div class="callback__body">
            <div class="callback__main">
                <h2 class="callback__title title text-uppercase">остались вопросы?</h2>
                <p class="callback__subtitle title-sm">Поможем выбрать, ответим на&nbsp;все вопросы</p>
                <div class="callback__contacts">
                    <?php if (!empty($phone_number)): ?>
                        <a href="tel:<?= esc_attr($formatted_phone_number) ?>" class="callback__phone title-sm">
                            <?= esc_html($phone_number) ?>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($telegram_url) || !empty($phone_number)): ?>
                        <div class="callback__socials">
                            <?php if (!empty($whatsapp_url)): ?>
                                <a href="<?= esc_url($whatsapp_url) ?>" class="callback__social icon-whatsapp" target="_blank" rel="noopener noreferrer"></a>
                            <?php endif; ?>
                            <?php if (!empty($telegram_url)): ?>
                                <a href="<?= esc_url($telegram_url) ?>" target="_blank" class="callback__social icon-telegram" rel="noopener noreferrer"></a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="callback__form">
                <?= do_shortcode('[contact-form-7 id="d58eb3b" title="Контактная форма Остались Вопросы?"]'); ?>
            </div>
        </div>
    </div>
</section>