<?php

require_once('config.php');

$model = get_base_model();
$model['title'] = 'История';
$model['returnurl'] = "{$model['current_url']}#main";
$model['about'] = ContentManager::get_entity_by_context('about-history')['content'];
$model['books'] = $books;

echo $Twig->render('history.html', $model);
