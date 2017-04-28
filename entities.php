<?php

require_once('config.php');

$context = required_param('context');
validate_context($context);
if (is_singleton_context($context)) {
    redirect("$CONFIG->wwwroot/museum.php");
}
$page = optional_param('page', 0);

$conditions = array();
$order = array('param' => 'date', 'order' => 'DESC');
$perpage = isset($CONFIG->entities[$context]['perpage']) ? $CONFIG->entities[$context]['perpage'] : null;
switch ($context) {
    case 'periods':
    case 'leaders':
        $order = array('param' => 'order', 'order' => 'ASC', 'cast' => 'INT');
        break;
    case 'calendar':
        $order = array('param' => 'timestamp', 'order' => 'ASC', 'cast' => 'INT');
        break;
    case 'history-of-success':
        $year = clean_param(optional_param('year', null), PARAM_INT);
        if ($year) {
            $conditions = array('year' => $year);
            $perpage = null;
        }
        $order = array('param' => 'year', 'order' => 'DESC', 'cast' => 'INT');
        break;
}

$offset = $pagination = null;
if ($perpage !== null) {
    $total = $DB->count_records('entities', array('context' => $context));
    $lastpage = ceil($total / $perpage);
    if ($page >= $lastpage) $page = $lastpage - 1;
    $offset = $page * $perpage;
    $baseurl = "$CONFIG->wwwroot/entities.php?context=$context";
    $pagination = pagination($baseurl, $total, $page, $perpage);
}
$entities = ContentManager::get_entities($context, $conditions, $order, $offset, $perpage);

$objects = array();
for ($i = 0; $i < count($entities); $i++) {
    $objects[$i] = EntityManager::get_object($entities[$i]['id']);
}

$model = get_base_model();
$model['title'] = 'Список элементов';
$model['returnurl'] = "{$model['current_url']}";
$model['context'] = $context;
$model['entities'] = $objects;
$model['pages'] = $pagination;

$template = get_entities_template($context);
if (file_exists("$CONFIG->dirroot/templates/$template")) {
    echo $Twig->render($template, $model);
} else {
    redirect("$CONFIG->wwwroot/museum.php");
}
