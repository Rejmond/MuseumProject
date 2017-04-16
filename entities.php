<?php

require_once('config.php');

$context = required_param('context');
validate_context($context);
if (is_singleton_context($context)) {
    die();
}
$page = optional_param('page', 0);

/*$args = array();
switch ($context) {
    case 'news':
        if ($name = optional_param('name', null)) {
            $args['name'] = $name;
            //$args['abstract'] = 'Книга 1';
        }
        break;
}*/

$total = $DB->count_records('entities', array('context' => $context));
$perpage = isset($CONFIG->entities[$context]['perpage']) ? $CONFIG->entities[$context]['perpage'] : 10;
$lastpage = ceil($total / $perpage);
if ($page >= $lastpage) $page = $lastpage - 1;
$entities = ContentManager::get_entities($context, array(), array('param' => 'date', 'order' => 'DESC'), $page * $perpage, $perpage);

$objects = array();
for ($i = 0; $i < count($entities); $i++) {
    $objects[$i] = EntityManager::get_object($entities[$i]['id']);
}

$model = get_base_model();
$model['title'] = 'Список элементов';
$model['returnurl'] = "{$model['current_url']}#main";
$model['context'] = $context;
$model['entities'] = $objects;

$baseurl = "$CONFIG->wwwroot/entities.php?context=$context";
$model['pages'] = pagination($baseurl, $total, $page, $perpage);

$template = get_entities_template($context);
if (file_exists("$CONFIG->dirroot/templates/$template")) {
    echo $Twig->render($template, $model);
} else {
    redirect("$CONFIG->wwwroot/index.php#main");
}
