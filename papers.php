<?php

require_once('config.php');

$context = required_param('paper');
validate_context($context);
$year = clean_param(optional_param('year'), PARAM_INT);

$entity = ContentManager::get_entity_by_context($context);
$object = EntityManager::get_object($entity['id']);

$papers_context = 'papers';
switch ($context) {
    case 'paper1':
        $papers_context = 'papers1';
        break;
    case 'paper2':
        $papers_context = 'papers2';
        break;
}

$sql = 'SELECT DISTINCT p.value AS year 
          FROM params p 
          JOIN entities e ON (p.entity = e.id AND p.name = :paramname AND e.context == :context)
      ORDER BY CAST(year AS INT) ASC';
$params = array('paramname' => 'year', 'context' => $papers_context);

$entities = $year ? ContentManager::get_entities($papers_context, array('year' => $year), array('param' => 'number', 'order' => 'ASC', 'cast' => 'INT')) : array();
$objects = array();
for ($i = 0; $i < count($entities); $i++) {
    $objects[$i] = EntityManager::get_object($entities[$i]['id']);
}

$model = get_base_model();
$model['title'] = 'Университетские газеты';
$model['returnurl'] = "{$model['current_url']}#main";
$model['entity'] = $object;
$model['papers_years'] = $DB->get_records_sql($sql, $params);
$model['papers'] = $objects;
$model['papers_context'] = $papers_context;
$model['current_year'] = $year;

echo $Twig->render('papers.html', $model);
