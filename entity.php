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
$model['title'] = 'Информация об элементе';
$model['entity'] = EntityManager::get_object($entity_id);

echo $Twig->render(get_entity_template($model['entity']['context']), $model);
