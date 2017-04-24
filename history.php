<?php

require_once('config.php');

$sql = 'SELECT DISTINCT p.value AS year 
          FROM params p 
          JOIN entities e ON (p.entity = e.id AND p.name = :paramname AND e.context == :context)
      ORDER BY CAST(year AS INT) ASC';
$params = array('paramname' => 'year', 'context' => 'history-of-success');

$model = get_base_model();
$model['title'] = 'История';
$model['returnurl'] = "{$model['current_url']}#main";
$model['about'] = ContentManager::get_entity_by_context('about-history')['content'];
$model['periods'] = get_entities('periods', 100, 4, array('param' => 'order', 'order' => 'ASC', 'cast' => 'INT'));
$model['books'] = get_entities('books', 30);
$model['paper1'] = get_entities('paper1', 30)[0];
$model['paper2'] = get_entities('paper2', 30)[0];
$model['leaders'] = get_entities('leaders', null, 4, array('param' => 'order', 'order' => 'ASC', 'cast' => 'INT'));
$model['memories'] = get_entities('memories', 30);
$model['history_of_institute'] = get_entities('history-of-institute', null, null, array('param' => 'content', 'order' => 'ASC'));
$model['history_of_success'] = get_entities('history-of-success', 50, 4, array('param' => 'year', 'order' => 'DESC', 'cast' => 'INT'));
$model['history_of_success_years'] = $DB->get_records_sql($sql, $params);

echo $Twig->render('history.html', $model);
