<?php

require_once('../config.php');

require_login();

$id = $_GET['id'];

if (isset($_POST['content'])) {
    $params = array(
        'name' => $_POST['name'],
        'abstract' => $_POST['abstract'],
        'info' => $_POST['info']
    );
    ContentManager::UpdatePostContent('books', $_POST['content'], $id, $params);
}

$book = ContentManager::GetPostContent('books', $id);

$model = array(
    'content' => $book['content'],
    'data' => $book['data']
);

echo $Twig->render('admin/book.html', $model);
