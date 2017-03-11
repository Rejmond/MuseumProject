<?php

require_once('config.php');

$context = optional_param('context', false);
if ($context) {
    $entity = ContentManager::get_entity_by_context($context);
} else {
    $entity_id = required_param('id');
    $entity = ContentManager::get_entity_by_id($entity_id);
}

$model = get_base_model();
$model['id'] = $entity['id'];
$model['content'] = $entity['content'];
$model['edit_link'] = "{$CONFIG->wwwroot}/admin/edit.php?id={$entity['id']}";
$model['delete_link'] = "{$CONFIG->wwwroot}/admin/delete.php?id={$entity['id']}";

switch ($entity['context']) {
    case 'books':
        $model['name']     = $entity['params']['name'];
        $model['abstract'] = $entity['params']['abstract'];
        $model['author']   = $entity['params']['author'];
        if ($image = FileManager::get_file_by_filearea($entity['id'], 'image')) {
            $model['image'] = $CONFIG->wwwroot . '/file.php?id=' . $image['id'];
        }
        break;
}

echo $Twig->render(get_entity_template($entity['context']), $model);
