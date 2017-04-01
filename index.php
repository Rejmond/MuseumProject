<?php

require_once('config.php');

$model = get_base_model();
$model['title'] = 'О музее';
$model['about'] = ContentManager::get_entity_by_context('about')['content'];

echo $Twig->render('museum.html', $model);
