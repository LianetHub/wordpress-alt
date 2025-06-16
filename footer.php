</main>
<?php
$phone_number = get_field('phone_number', 'option');
$formatted_phone_number = preg_replace('/[^0-9+]/', '', $phone_number);
$email_address = get_field('email_address', 'option');
$organization_address = get_field('organization_address', 'option');
$company_details_group = get_field('company_details', 'option');
$current_year = date('Y');
?>
<footer class="footer">
    <div class="container">
        <div class="footer__header">
            <?php if (!empty($organization_address)): ?>
                <address class="footer__location icon-location">
                    <?= esc_html($organization_address) ?>
                </address>
            <?php endif; ?>
            <?php if (!empty($email_address) || !empty($phone_number)): ?>
                <div class="footer__contacts">
                    <?php if (!empty($email_address)): ?>
                        <a href="mailto:<?= esc_attr($email_address) ?>" class="footer__contact icon-envelope">
                            <?= esc_html($email_address) ?>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($phone_number)): ?>
                        <a href="tel:<?= esc_attr($formatted_phone_number) ?>" class="footer__contact icon-phone">
                            <?= esc_html($phone_number) ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <a href="#callback" data-fancybox class="footer__callback btn btn-primary">Обратный звонок</a>
        </div>
        <nav aria-label="Меню в подвале" class="footer__menu">
            <div class="footer__menu-block">
                <div class="footer__menu-caption">АЛТ</div>
                <ul class="footer__menu-list">
                    <li><a href="">Главная</a></li>
                    <li><a href="">О компании</a></li>
                    <li><a href="">Для госзаказчиков</a></li>
                    <li><a href="">Для бизнеса</a></li>
                    <li><a href="">Отзывы</a></li>
                    <li><a href="">Блог</a></li>
                    <li><a href="">Проекты</a></li>
                    <li><a href="">Контакты</a></li>
                    <li><a href="">Карта сайта</a></li>
                    <li><a href="">Политика конфиденциальности</a></li>
                </ul>
            </div>
            <div class="footer__menu-block">
                <div class="footer__menu-caption">Наша продукция</div>
                <ul class="footer__menu-list">
                    <li><a href="">Микрочипы</a></li>
                    <li><a href="">Клапаны </a></li>
                    <li><a href="">Мировые бренды автоматики</a></li>
                    <li><a href="">Запчасти для холодильного оборудования</a></li>
                    <li><a href="">Запчасти для роботов</a></li>
                    <li><a href="">Лабораторное оборудование</a></li>
                    <li><a href="">Запчасти для медицинского оборудования</a></li>
                    <li><a href="">Средства измерения, находящиеся в ГРСИ</a></li>
                    <li><a href="">Измерительное оборудование</a></li>
                </ul>
            </div>
            <div class="footer__menu-block">
                <div class="footer__menu-caption">Отрасли</div>
                <ul class="footer__menu-list">
                    <li><a href="">Химическое производство</a></li>
                    <li><a href="">Пищевая промышленность</a></li>
                    <li><a href="">Атомная энергетика</a></li>
                    <li><a href="">Нефтегазовая промышленность</a></li>
                    <li><a href="">Для лабораторий</a></li>
                    <li><a href="">Пищевая промышленность</a></li>
                    <li><a href="">Атомная энергетика</a></li>
                </ul>
            </div>
        </nav>

        <div class="footer__bottom">
            <a href="<?= get_home_url() ?>" class="footer__logo">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-white.svg" alt="Логотип">
            </a>
            <?php if ($company_details_group):
                $company_full_name = $company_details_group['full_company_name'] ?? '';
                $company_ogrn = $company_details_group['ogrn_value'] ?? '';
                $company_inn = $company_details_group['inn_value'] ?? '';
                $company_copyright_name = $company_details_group['short_company_name'] ?? '';

            ?>
                <div class="footer__reqs">
                    <?php if ($company_full_name): ?>
                        <?php echo esc_html($company_full_name); ?> <br>
                    <?php endif; ?>
                    <?php if ($company_ogrn): ?>
                        ОГРН: <?php echo esc_html($company_ogrn); ?> <br>
                    <?php endif; ?>
                    <?php if ($company_inn): ?>
                        ИНН: <?php echo esc_html($company_inn); ?> <br>
                    <?php endif; ?>
                    <?php if ($company_copyright_name): ?>
                        <?php echo esc_html($company_copyright_name); ?> &copy;<?php echo esc_html($current_year); ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="footer__production">
                Разработка сайта и продвижение
                Маркетинговое агентство <a href="https://inmarketing.team/" target="_blank" class="footer__production-link">InMarketing</a>
            </div>
        </div>
    </div>
</footer>
<?php if (!empty($email_address) || !empty($phone_number)): ?>
    <div class="widgets">
        <?php if (!empty($phone_number)): ?>
            <a href="tel:<?= esc_attr($formatted_phone_number) ?>" aria-label="Телефон" class="widgets__btn icon-phone"></a>
        <?php endif; ?>
        <?php if (!empty($email_address)): ?>
            <a href="mailto:<?= esc_attr($email_address) ?>" aria-label="E-mail" class="widgets__btn icon-envelope"></a>
        <?php endif; ?>
    </div>
<?php endif; ?>
<div id="callback" class="popup">
    <button type="button" data-fancybox-close class="popup__close icon-cross"></button>
    <h2 class="popup__title title text-uppercase">обратный звонок</h2>
    <p class="popup__subtitle">Оставьте свои контактные данные и мы свяжемся с вами в ближайшее время!</p>
    <div class="popup__form">
        <?= do_shortcode('[contact-form-7 id="1a8c4c8" title="Контактая форма Обратный звонок"]'); ?>
    </div>
</div>
<div id="commercial-offer" class="popup">
    <button type="button" data-fancybox-close class="popup__close icon-cross"></button>
    <h2 class="popup__title title text-uppercase">Получить комерческое предложение</h2>
    <p class="popup__subtitle">Оставьте заявку и вы бесплатно получите расчет стоимости в течение 24х часов</p>
    <div class="popup__form">
        <?= do_shortcode('[contact-form-7 id="c086563" title="Контактная форма в модальном окне Получить комерческое предложение"]'); ?>
    </div>
</div>
<? if (is_single()): ?>
    <div id="audit" class="popup">
        <button type="button" data-fancybox-close class="popup__close icon-cross"></button>
        <h2 class="popup__title title text-uppercase">бесплатный аудит текущих поставок</h2>
        <p class="popup__subtitle">Оставьте ваши контактные данные и все необходимые для оценки документы и получите аудит в течение 48 часов</p>
        <div class="popup__form">
            <?= do_shortcode('[contact-form-7 id="7bbbebe" title="Контактная форма в модальном окне бесплатный аудит текущих поставок"]'); ?>
        </div>
    </div>
<? endif; ?>
</div>
<?php wp_footer(); ?>
</body>

</html>