<?php

require_once('../config.php');

require_login();

$id = $_GET['id'];

if (isset($_POST['delete_id'])) {
    ContentManager::DeletePost('books', $_POST['delete_id']);
    header("Location: {$CONFIG->wwwroot}/admin/books.php");
}

$book = ContentManager::GetPostContent('books', $id);

$model = array(
    'content' => $book['content'],
    'data' => $book['data'],
    'id' => $book['itemid']
);

echo $Twig->render('admin/delete_book.html', $model);
