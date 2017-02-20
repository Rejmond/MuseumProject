<?php

require_once('config.php');

$id = $_GET['id'];

$book = ContentManager::GetPostContent('books', $id);

$model = array(
    'book' => $book
);

echo $Twig->render('book.html', $model);
