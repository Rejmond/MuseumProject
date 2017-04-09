<?php

require_once('config.php');

$entities = ContentManager::get_entities('news', array(), "ORDER BY date DESC", 0, 4);
$news = array();
for ($i = 0; $i < count($entities); $i++) {
    $news[$i] = EntityManager::get_object($entities[$i]['id']);
    $newcontent = limit_words($news[$i]['content'], 15);
    if ($news[$i]['content'] != $newcontent) {
        $news[$i]['content'] = "$newcontent...";
    }
}

$model = get_base_model();
$model['title'] = 'О музее';
$model['about'] = ContentManager::get_entity_by_context('about')['content'];
$model['news'] = $news;
$model['geologic'] = ContentManager::get_entity_by_context('geologic')['content'];

echo $Twig->render('museum.html', $model);
