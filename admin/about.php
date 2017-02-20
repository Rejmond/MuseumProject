<?php

require_once('../config.php');

require_login();

if (isset($_POST['content'])) {
    ContentManager::UpdatePostContent('about', $_POST['content']);
}

$content = ContentManager::GetPostContent('about');

$model = array(
    'content' => $content['content']
);

echo $Twig->render('admin/about.html', $model);
