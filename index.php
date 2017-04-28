<?php
require_once('config.php');
$model = get_base_model();
echo $Twig->render('index.html', $model);
