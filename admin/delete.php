<?php

require_once('../config.php');

require_login();

$entity_id = required_param('id');

if (post_data_submitted()) {
    $entity = ContentManager::get_entity_by_id($entity_id);
    if (!empty(optional_param('delete'))) {
        ContentManager::delete_entity($entity_id);
        FileManager::delete_entity_files($entity_id);
    }
    redirect("{$CONFIG->wwwroot}/entities.php?context={$entity['context']}");
} else {
    $model = get_base_model();
    $model['id'] = $entity_id;
    echo $Twig->render('admin/delete.html', $model);
}
