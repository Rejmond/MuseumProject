<?php

require_once('config.php');

$context = optional_param('context', false);
if ($context) {
    validate_context($context);
    $entity_id = ContentManager::get_entity_by_context($context)['id'];
} else {
    $entity_id = required_param('id');
}

$model = get_base_model();
$model['entity'] = EntityManager::get_object($entity_id);
$model['edit_link'] = "{$CONFIG->wwwroot}/admin/edit.php?id={$entity_id}";
$model['delete_link'] = "{$CONFIG->wwwroot}/admin/delete.php?id={$entity_id}";

echo $Twig->render(get_entity_template($model['entity']['context']), $model);
