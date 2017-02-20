<?php

require_once('../config.php');

require_login();

$books = ContentManager::GetPostsInfo('books');
for ($i = 0; $i < count($books); $i++) {
    $books[$i]['edit_link'] = "/admin/book.php?id={$books[$i]['itemid']}";
    $books[$i]['delete_link'] = "/admin/delete_book.php?id={$books[$i]['itemid']}";
}

$model = array(
    'books' => $books
);

echo $Twig->render('admin/books.html', $model);
