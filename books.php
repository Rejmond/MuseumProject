<?php
require_once('config.php');

$books = ContentManager::GetPostsInfo('books');
for ($i = 0; $i < count($books); $i++) {
    $books[$i]['link'] = "/book.php?id={$books[$i]['itemid']}";
}

$model = array(
    'books' => $books
);

echo $Twig->render('books.html', $model);
