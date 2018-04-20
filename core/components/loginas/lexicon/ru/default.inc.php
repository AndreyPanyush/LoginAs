<?php
/**
 * This file is part of the LoginAs extension
 *
 * Copyright (c) 2017 Andrey Panyush
 */

$_lang['loginas'] = 'LoginAs';

$_lang['loginas.main'] = 'Основные';
$_lang['loginas.setting_ttl'] = 'Время жизни токена';
$_lang['loginas.setting_ttl_description'] = 'Количество секунд, через которое авторизация по сгенерированному токену станет невозможна';
$_lang['loginas.setting_remove_read'] = 'Одноразовые токены';
$_lang['loginas.setting_remove_read_description'] = 'Токен будет удален после первой попытки авторизации';
$_lang['loginas.setting_check_ip'] = 'Провекра IP';
$_lang['loginas.setting_check_ip_description'] = 'Сравнивать IP-адрес при генерации токена и при авторизации';
$_lang['loginas.setting_redirect'] = 'ID для перенаправления';
$_lang['loginas.setting_redirect_description'] = 'Идентификатор ресурса для перенаправления после успешной авторизации';


$_lang['loginas.err_generate'] = 'Невозможно авторизоваться как этот пользователь';
$_lang['loginas.err_generate_not_found'] = 'Пользователь не найден';
$_lang['loginas.err_generate_sudo'] = 'Невозможно авторизоваться как супер-пользователь';

$_lang['loginas.err_login'] = 'Невозможно авторизоваться как этот пользователь';
$_lang['loginas.err_login_token'] = 'Не указан токен';
$_lang['loginas.err_login_record'] = 'Неверная ссылка';
$_lang['loginas.err_login_ip'] = 'IP-адрес не совпадает';

$_lang['loginas.modal_button'] = 'Авторизоваться';
$_lang['loginas.window_generate_title'] = 'Контекст для авторизации';
$_lang['loginas.modal_success_title'] = 'Авторизация';
$_lang['loginas.modal_success_message'] = 'Скопируйте ссылку для авторизации из поля ниже. Сссылка действительна в течение [[+ttl]] секунд. Не передавайте ссылку третим лицам. Откройте эту ссылку в другом брузере или воспользуйтесь режимом "Инкогнито"';
