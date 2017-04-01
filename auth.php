<?php

require_once('config.php');

$auth = optional_param('auth', false);
$logout = optional_param('logout', false);
$returnurl = optional_param('returnurl', "$CONFIG->wwwroot/index.php#main");

if (post_data_submitted() && $logout !== false) {
    $USER->logout();
    redirect($returnurl);
}

$auth_error = '';
if (post_data_submitted() && $auth !== false) {
    $password = required_param('password');
    if (!$USER->authorise($password)) {
        $auth_error = "Неверный пароль";
    }
}

if ($USER->is_admin()) {
    redirect($returnurl);
} else {
    $model = get_base_model();
    $model['title'] = 'Администрирование';
    $model['error'] = $auth_error;
    echo $Twig->render('loginform.html', $model);
}
