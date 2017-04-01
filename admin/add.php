<?php

require_once('../config.php');

require_login();

$context = required_param('context');
validate_context($context);
$model = get_base_model();

if (post_data_submitted()) {
    $result = EntityManager::add_object_from_submit();
    if (is_numeric($result)) {
        redirect("{$CONFIG->wwwroot}/entity.php?id={$result}");
    } else if (is_array($result)) {
        $model['errors'] = $result['errors'];
        $model['content'] = $result['values']['content'];
        unset($result['values']['content']);
        $model['params'] = $result['values'];
    }
}

echo $Twig->render('admin/' . get_entity_template($context), $model);
