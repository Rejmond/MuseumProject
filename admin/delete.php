<?php

require_once('../config.php');

require_login();

$entity_id = required_param('id');

if (post_data_submitted()) {
    $entity = ContentManager::get_entity_by_id($entity_id);
    $result = optional_param('delete', null);
    if (!empty($result)) {
        echo 'delete';
        echo $entity_id;
        ContentManager::delete_entity($entity_id);
    }
    header("Location: {$CONFIG->wwwroot}/entities.php?context={$entity['context']}");
} else {
    $model = array('id' => $entity_id);
    echo $Twig->render('admin/delete.html', $model);
}
