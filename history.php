<?php

require_once('config.php');

$model = get_base_model();
$model['title'] = 'История';
$model['returnurl'] = "{$model['current_url']}#main";
$model['about'] = ContentManager::get_entity_by_context('about-history')['content'];
$model['periods'] = get_entities('periods', 100, 4, array('param' => 'order', 'order' => 'ASC'));
$model['books'] = get_entities('books', 30);
$model['leaders'] = get_entities('leaders', null, 4, array('param' => 'order', 'order' => 'ASC'));
$model['memories'] = get_entities('memories', 30);
$model['history_of_institute'] = get_entities('history-of-institute', null, null, array('param' => 'content', 'order' => 'ASC'));

echo $Twig->render('history.html', $model);
