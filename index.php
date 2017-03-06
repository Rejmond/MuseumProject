<?php

require_once('config.php');

$model = array_merge(get_base_model(), get_navigation());

echo $Twig->render('main.html', $model);
