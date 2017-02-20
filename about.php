<?php

require_once('config.php');

$content = ContentManager::GetPostContent('about');

$model = array(
    'content' => $content['content']
);

echo $Twig->render('about.html', $model);
