<?php

require_once('../config.php');

require_login();

$entity_id = required_param('id');
$accept = optional_param('accept', false);
$cancel = optional_param('cancel', false);
$returnurl = optional_param('returnurl', false);

if ($cancel !== false) {
    redirect($returnurl ? $returnurl : "{$CONFIG->wwwroot}/entity.php?id={$entity_id}#main");
}

$object = EntityManager::get_object($entity_id);
if (!$object) die(); // Записи не существует

if (post_data_submitted() && $accept !== false) {
    $result = EntityManager::delete_object_from_submit();
    if ($result) {
        redirect($returnurl ? $returnurl : "{$CONFIG->wwwroot}/entities.php?context={$result['context']}#main");
    }
}

$model = get_base_model();
$model['title'] = 'Удаление элемента';
$model['context'] = $object['context'];
$model['id'] = $entity_id;
echo $Twig->render('admin/delete.html', $model);
