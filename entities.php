<?php

require_once('config.php');

$context = required_param('context');
validate_context($context);
if (is_singleton_context($context)) {
    die();
}

$args = array();
switch ($context) {
    case 'books':
        if ($author = optional_param('author', null)) {
            $args['author'] = $author;
            //$args['abstract'] = 'Книга 1';
        }
    case 'news':
        if ($name = optional_param('name', null)) {
            $args['name'] = $name;
            //$args['abstract'] = 'Книга 1';
        }
}

$entities = ContentManager::get_entities($context, $args);

$objects = array();
for ($i = 0; $i < count($entities); $i++) {
    $objects[$i] = EntityManager::get_object($entities[$i]['id']);
    $objects[$i]['edit_link'] = "{$CONFIG->wwwroot}/admin/edit.php?id={$entities[$i]['id']}";
    $objects[$i]['delete_link'] = "{$CONFIG->wwwroot}/admin/delete.php?id={$entities[$i]['id']}";
    $objects[$i]['link'] = "{$CONFIG->wwwroot}/entity.php?id={$entities[$i]['id']}";
}

$model = get_base_model();
$model['add_link'] = "{$CONFIG->wwwroot}/admin/add.php?context=$context";
$model['entities'] = $objects;

echo $Twig->render(get_entities_template($context), $model);
