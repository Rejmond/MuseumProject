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
if (!$object) {
    redirect("$CONFIG->wwwroot/museum.php");
}

$model = get_base_model();
$model['title'] = 'Информация об элементе';
$model['returnurl'] = optional_param('returnurl', "{$CONFIG->wwwroot}/entities.php?context={$object['context']}");
$model['entity'] = $object;

$template = get_entity_template($model['entity']['context']);
if (file_exists("$CONFIG->dirroot/templates/$template")) {
    echo $Twig->render($template, $model);
} else {
    redirect("$CONFIG->wwwroot/museum.php");
}
