<?php

require_once('config.php');

$post = ContentManager::get_entity_by_context('about');

$model = array(
    'post' => $post
);

echo $Twig->render('about.html', $model);
