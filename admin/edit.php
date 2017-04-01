<?php

require_once('../config.php');

require_login();

$context = optional_param('context', false);
if ($context) {
    validate_context($context);
    $entity_id = ContentManager::get_entity_by_context($context)['id'];
} else {
    $entity_id = required_param('id');
}

$object = EntityManager::get_object($entity_id);
if (!$object) die(); // Записи не существует

$model = get_base_model();
$model['title'] = 'Редактирование элемента';
$model = array_merge($model, $object);

if (post_data_submitted()) {
    $result = EntityManager::update_object_from_submit();
    if ($result === true) {
        $return_url = optional_param('return_url', "{$CONFIG->wwwroot}/entity.php?id={$entity_id}");
        redirect($return_url);
    } else if (is_array($result)) {
        $model['errors'] = $result['errors'];
        $model['content'] = $result['values']['content'];
        unset($result['values']['content']);
        $model['params'] = $result['values'];
    }
}

echo $Twig->render('admin/' . get_entity_template($object['context']), $model);
