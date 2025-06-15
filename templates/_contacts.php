<?php

$company_details_group = get_field('company_details', 'option');
$phone_number = get_field('phone_number', 'option');
$formatted_phone_number = preg_replace('/[^0-9+]/', '', $phone_number);
$email_address = get_field('email_address', 'option');
$work_time = get_field('work_time', 'option');
$organization_address = get_field('organization_address', 'option');
$map_iframe_url = get_field('map_iframe_url', 'option') ?? '';


if ($company_details_group):

    $full_company_name      = $company_details_group['full_company_name'] ?? '';
    $inn_value              = $company_details_group['inn_value'] ?? '';
    $kpp_value              = $company_details_group['kpp_value'] ?? '';
    $ogrn_value             = $company_details_group['ogrn_value'] ?? '';
    $corr_check_value       = $company_details_group['corr_check_value'] ?? '';
    $current_account_value  = $company_details_group['current_account_value'] ?? '';
    $bank_name_value        = $company_details_group['bank_name_value'] ?? '';
    $bik_value              = $company_details_group['bik_value'] ?? '';
    $legal_address_value    = $company_details_group['legal_address_value'] ?? '';
    $actual_address_value   = $company_details_group['actual_address_value'] ?? '';
?>
    <section class="contacts">
        <div class="container">
            <?php if ($full_company_name): ?>
                <h2 class="contacts__title title-sm">Общество с ограниченной ответственностью «Агрион Лайт Техноложис» (ООО «АЛТ»)</h2>
            <?php endif; ?>
            <div class="contacts__body">
                <ul class="contacts__reqs">
                    <?php if ($inn_value): ?>
                        <li class="contacts__reqs-item">
                            <strong> ИНН:</strong> <?php echo esc_html($inn_value); ?>
                        </li>
                    <?php endif; ?>
                    <?php if ($kpp_value): ?>
                        <li class="contacts__reqs-item">
                            <strong>КПП:</strong> <?php echo esc_html($kpp_value); ?>
                        </li>
                    <?php endif; ?>
                    <?php if ($ogrn_value): ?>
                        <li class="contacts__reqs-item">
                            <strong>ОГРН:</strong> <?php echo esc_html($ogrn_value); ?>
                        </li>
                    <?php endif; ?>
                    <?php if ($corr_check_value): ?>
                        <li class="contacts__reqs-item">
                            <strong>Корр. счет:</strong> <?php echo esc_html($corr_check_value); ?>
                        </li>
                    <?php endif; ?>
                    <?php if ($current_account_value): ?>
                        <li class="contacts__reqs-item">
                            <strong>Расчетный счет:</strong> <?php echo esc_html($current_account_value); ?>
                        </li>
                    <?php endif; ?>
                    <?php if ($bank_name_value): ?>
                        <li class="contacts__reqs-item">
                            <strong>Банк:</strong> <?php echo esc_html($bank_name_value); ?>
                        </li>
                    <?php endif; ?>
                    <?php if ($bik_value): ?>
                        <li class="contacts__reqs-item">
                            <strong>БИК:</strong> <?php echo esc_html($bik_value); ?>
                        </li>
                    <?php endif; ?>
                </ul>
                <ul class="contacts__location">
                    <?php if ($legal_address_value): ?>
                        <li class="contacts__location-block">
                            <strong>Юридический адрес: </strong>
                            <address><?php echo nl2br(esc_html($legal_address_value)); ?></address>
                        </li>
                    <?php endif; ?>
                    <?php if ($actual_address_value): ?>
                        <li class="contacts__location-block">
                            <strong>Фактический адрес:</strong>
                            <address><?php echo nl2br(esc_html($actual_address_value)); ?></address>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="contacts__map">
                <div class="contacts__map-info">
                    <div class="contacts__map-caption title-sm">Офис в Челябинске</div>
                    <ul class="contacts__map-list">
                        <?php if ($organization_address): ?>
                            <li class="contacts__map-item">
                                <strong>Адрес:</strong> <?php echo nl2br(esc_html($organization_address)); ?>
                            </li>
                        <?php endif; ?>
                        <?php if ($work_time): ?>
                            <li class="contacts__map-item">
                                <strong>График работы:</strong> <?php echo esc_html($work_time); ?>
                            </li>
                        <?php endif; ?>
                        <?php if ($phone_number): ?>
                            <li class="contacts__map-item">
                                <strong>Tелефон:</strong> <br>
                                <a href="tel:<?= esc_attr($formatted_phone_number) ?>">
                                    <?php echo esc_html($phone_number); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($email_address): ?>
                            <li class="contacts__map-item">
                                <strong>Email:</strong> <br>
                                <a href="mailto:<?php echo esc_attr($email_address); ?>">
                                    <?php echo esc_html($email_address); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <?php if ($map_iframe_url): ?>
                    <div class="contacts__map-content">
                        <iframe src="<?php echo esc_url($map_iframe_url); ?>" width="100%" height="400" frameborder="0" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>