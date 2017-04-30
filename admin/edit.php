<?php

require_once('../config.php');

require_login();

$context = optional_param('context', false);
if ($context) {
    validate_context($context);
    $entity_id = ContentManager::get_entity_by_context($context)['id']; // предполагается гарантированное получение id
} else {
    $entity_id = required_param('id');
}

$accept = optional_param('accept', false);
$cancel = optional_param('cancel', false);
$returnurl = optional_param('returnurl', "{$CONFIG->wwwroot}/entity.php?id={$entity_id}");

if ($cancel !== false) {
    redirect($returnurl);
}

$object = EntityManager::get_object($entity_id);
if (!$object) {
    redirect("$CONFIG->wwwroot/museum.php");
}

$model = get_base_model();
$model['title'] = 'Редактирование элемента';
$model = array_merge($model, $object);

if (post_data_submitted() && $accept !== false) {
    $result = EntityManager::update_object_from_submit();
    if ($result === true) {
        redirect($returnurl);
    } else if (is_array($result)) {
        $model['errors'] = $result['errors'];
        $model['content'] = $result['values']['content'];
        unset($result['values']['content']);
        $model['params'] = $result['values'];
    }
}

$template = 'admin/' . get_entity_template($object['context']);
if (file_exists("$CONFIG->dirroot/templates/$template")) {
    echo $Twig->render($template, $model);
} else {
    redirect("$CONFIG->wwwroot/museum.php");
}
