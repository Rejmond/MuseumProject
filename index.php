<?php

require_once('config.php');

$model = get_navigation();

echo $Twig->render('main.html', $model);
