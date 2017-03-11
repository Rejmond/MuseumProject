<?php

require_once('../config.php');

require_login();

$context = required_param('context');

if (post_data_submitted()) {
    $content = required_param('content');
    switch ($context) {
        case 'books':
            $params = array(
                'name'     => required_param('name'),
                'abstract' => required_param('abstract'),
                'author'   => required_param('author')
            );
            $image = get_file('image');
            resize($image['tmp_name'], 150, 300);
            $entity_id = ContentManager::add_entity($context, $content, $params);
            FileManager::add_file($entity_id, 'image', $image);
            break;
    }
    redirect("{$CONFIG->wwwroot}/entity.php?id={$entity_id}");
}

$model = get_base_model();
echo $Twig->render('admin/' . get_entity_template($context), $model);
