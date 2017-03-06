<?php

require_once('config.php');

$context = required_param('context');

$args = array();
switch ($context) {
    case 'books':
        if ($author = optional_param('author', null)) {
            $args['author'] = $author;
        }
}

$entities = ContentManager::get_entities($context, $args);

for ($i = 0; $i < count($entities); $i++) {
    $entities[$i]['edit_link'] = "{$CONFIG->wwwroot}/admin/edit.php?id={$entities[$i]['id']}";
    $entities[$i]['delete_link'] = "{$CONFIG->wwwroot}/admin/delete.php?id={$entities[$i]['id']}";
    $entities[$i]['link'] = "{$CONFIG->wwwroot}/entity.php?id={$entities[$i]['id']}";
}

$model = get_base_model();
$model['entities'] = $entities;
$model['add_link'] = "{$CONFIG->wwwroot}/admin/add.php?context=$context";
switch ($context) {
    case 'books':
        $model['author'] = $author;
}

echo $Twig->render(get_entities_template($context), $model);
