<?php

require_once('config.php');

$model = get_base_model();
$model['title'] = 'О музее';
$model['returnurl'] = "{$model['current_url']}#main";
$model['about'] = ContentManager::get_entity_by_context('about')['content'];
$model['news'] = get_entities('news');
$model['expositions'] = get_entities('exposition', null, 6);
$model['exhibitions'] = get_entities('exhibitions');
$model['calendar'] = get_entities('calendar', null, null, array('param' => 'date', 'order' => 'ASC'));
$model['presents'] = get_entities('presents');
$model['geologic'] = ContentManager::get_entity_by_context('geologic')['content'];

echo $Twig->render('museum.html', $model);
