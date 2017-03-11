<?php

require_once('../config.php');

require_login();

$entity_id = required_param('id');
$entity = ContentManager::get_entity_by_id($entity_id);

if (post_data_submitted()) {
    $content = required_param('content');
    $params = [];
    switch ($entity['context']) {
        case 'books':
            $params = array(
                'name'     => required_param('name'),
                'abstract' => required_param('abstract'),
                'author'   => required_param('author')
            );
            ContentManager::update_entity($entity_id, $content, $params);
            if ($image = get_file('image', true))
            {
                resize($image['tmp_name'], 150, 300);
                FileManager::delete_filearea($entity_id, 'image');
                FileManager::add_file($entity_id, 'image', $image);
            }
            break;
        case 'about':
            ContentManager::update_entity($entity_id, $content);
            break;
    }
    redirect("{$CONFIG->wwwroot}/entity.php?id={$entity_id}");
}

$model = get_base_model();
switch ($entity['context']) {
    case 'books':
        $model['name']     = $entity['params']['name'];
        $model['abstract'] = $entity['params']['abstract'];
        $model['author']   = $entity['params']['author'];
        break;
}
$model['id'] = $entity_id;
$model['content'] = $entity['content'];

echo $Twig->render('admin/' . get_entity_template($entity['context']), $model);
