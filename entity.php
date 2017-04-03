<?php

require_once('config.php');

$context = optional_param('context', false);
if ($context) {
    validate_context($context);
    $entity_id = ContentManager::get_entity_by_context($context)['id']; // предполагается гарантированное получение id
} else {
    $entity_id = required_param('id');
}

$object = EntityManager::get_object($entity_id);
if (!$object) die(); // Записи не существует

$model = get_base_model();
$model['title'] = 'Информация об элементе';
$model['entity'] = $object;

echo $Twig->render(get_entity_template($model['entity']['context']), $model);
