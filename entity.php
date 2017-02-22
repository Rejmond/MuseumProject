<?php

require_once('config.php');

$context = optional_param('context', false);

if ($context) {
    $entity = ContentManager::get_entity_by_context($context);
} else {
    $entity_id = required_param('id');
    $entity = ContentManager::get_entity_by_id($entity_id);
}

$model = array (
    'id' => $entity['id'],
    'content' => $entity['content'],
    'edit_link' => "{$CONFIG->wwwroot}/admin/edit.php?id={$entity['id']}",
    'delete_link' => "{$CONFIG->wwwroot}/admin/delete.php?id={$entity['id']}",
    'admin' => $USER->is_admin() ? 1 : 0
);

switch ($entity['context']) {
    case 'books':
        $model['name'] = $entity['params']['name'];
        $model['abstract'] = $entity['params']['abstract'];
        $model['info'] = $entity['params']['info'];
        break;
}

echo $Twig->render(get_entity_template($entity['context']), $model);
