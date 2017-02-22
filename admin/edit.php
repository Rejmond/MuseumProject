<?php

require_once('../config.php');

require_login();

$entity_id = required_param('id');

if (post_data_submitted()) {
    $context = required_param('context');
    $params = array();
    switch ($context) {
        case 'books':
            $params = array(
                'name' => required_param('name'),
                'abstract' => required_param('abstract'),
                'info' => required_param('info')
            );
            break;
    }
    ContentManager::update_entity($entity_id, required_param('content'), $params);
    header("Location: {$CONFIG->wwwroot}/entity.php?id={$entity_id}");
}

$entity = ContentManager::get_entity_by_id($entity_id);

switch ($entity['context']) {
    case 'books':
        $model = array (
            'name' => $entity['params']['name'],
            'abstract' => $entity['params']['abstract'],
            'info' => $entity['params']['info']
        );
        break;
}

$model['id'] = $entity_id;
$model['content'] = $entity['content'];

echo $Twig->render('admin/' . get_entity_template($entity['context']), $model);
