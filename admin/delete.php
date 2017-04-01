<?php

require_once('../config.php');

require_login();

$entity_id = required_param('id');

if (post_data_submitted()) {
    if (!empty(optional_param('delete'))) {
        $result = EntityManager::delete_object_from_submit();
        if ($result) {
            redirect("{$CONFIG->wwwroot}/entities.php?context={$result['context']}");
        }
    }
} else {
    $model = get_base_model();
    $model['id'] = $entity_id;
    echo $Twig->render('admin/delete.html', $model);
}
