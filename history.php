<?php

require_once('config.php');

function get_entities($contexnt, $words = 15, $order = array('param' => 'date', 'order' => 'DESC')) {
    $entities = ContentManager::get_entities($contexnt, array(), $order, 0, 4);
    $result = array();
    for ($i = 0; $i < count($entities); $i++) {
        $result[$i] = EntityManager::get_object($entities[$i]['id']);
        $newcontent = limit_words($result[$i]['content'], $words);
        if ($result[$i]['content'] != $newcontent) {
            $result[$i]['content'] = "$newcontent...";
        }
    }
    return $result;
}

$model = get_base_model();
$model['title'] = 'История';
$model['returnurl'] = "{$model['current_url']}#main";
$model['about'] = ContentManager::get_entity_by_context('about-history')['content'];
$model['periods'] = get_entities('periods', 100, array('param' => 'order', 'order' => 'ASC'));
$model['books'] = get_entities('books', 30);

echo $Twig->render('history.html', $model);
