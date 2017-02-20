<?php

require_once('../config.php');

require_login();

if (isset($_POST['name'])) {
    $params = array(
        'name' => $_POST['name'],
        'abstract' => $_POST['abstract'],
        'info' => $_POST['info']
    );
    ContentManager::AddPostContent('books', $_POST['content'], $params);
    header("Location: {$CONFIG->wwwroot}/admin/books.php");
}

$model = array();

echo $Twig->render('admin/book.html', $model);
