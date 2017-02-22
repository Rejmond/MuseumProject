<?php

require_once('config.php');

$auth_error = '';
if (isset($_POST['auth'])) {
	$password = $_POST['password'];
	$result = $USER->authorise($password);
	if (!$result) {
		$auth_error = "Неверный пароль";
	}
}

if (isset($_POST['logout'])) {
	 $USER->logout();
}

if ($USER->is_admin()) {
	echo $Twig->render('logoutform.html', array());	
} else {
	$model = array(
		'error' => $auth_error
	);
	echo $Twig->render('loginform.html', $model);		
}
