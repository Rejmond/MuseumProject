<?php

require_once('config.php');

function get_entities($contexnt) {
    $entities = ContentManager::get_entities($contexnt, array(), array('param' => 'date', 'order' => 'DESC'), 0, 4);
    $result = array();
    for ($i = 0; $i < count($entities); $i++) {
        $result[$i] = EntityManager::get_object($entities[$i]['id']);
        $newcontent = limit_words($result[$i]['content'], 15);
        if ($result[$i]['content'] != $newcontent) {
            $result[$i]['content'] = "$newcontent...";
        }
    }
    return $result;
}

$model = get_base_model();
$model['title'] = 'О музее';
$model['returnurl'] = "{$model['current_url']}#main";
$model['about'] = ContentManager::get_entity_by_context('about')['content'];
$model['news'] = get_entities('news');
$model['exhibitions'] = get_entities('exhibitions');
$model['presents'] = get_entities('presents');
$model['geologic'] = ContentManager::get_entity_by_context('geologic')['content'];

echo $Twig->render('museum.html', $model);
