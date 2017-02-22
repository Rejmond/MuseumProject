<?php

require_once('config.php');

$context = required_param('context');

$entities = ContentManager::get_entities($context);

for ($i = 0; $i < count($entities); $i++) {
    $entities[$i]['edit_link'] = "{$CONFIG->wwwroot}/admin/edit.php?id={$entities[$i]['id']}";
    $entities[$i]['delete_link'] = "{$CONFIG->wwwroot}/admin/delete.php?id={$entities[$i]['id']}";
    $entities[$i]['link'] = "{$CONFIG->wwwroot}/entity.php?id={$entities[$i]['id']}";
}

$model = get_base_model();
$model['admin'] = $USER->is_admin() ? 1 : 0;
$model['entities'] = $entities;
$model['add_link'] = "{$CONFIG->wwwroot}/admin/add.php?context=$context";

echo $Twig->render(get_entities_template($context), $model);
