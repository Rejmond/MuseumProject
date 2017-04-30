<?php

require_once('config.php');

$model = get_base_model();
$model['title'] = 'Музей истории СибГИУ';
echo $Twig->render('index.html', $model);
