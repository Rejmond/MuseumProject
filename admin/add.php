<?php

require_once('../config.php');

require_login();

$context = required_param('context');

if (post_data_submitted()) {
    $content = required_param('content');
    $params = [];
    switch ($context) {
        case 'books':
            $params = array(
                'name'     => required_param('name'),
                'abstract' => required_param('abstract'),
                'info'     => required_param('info')
            );
            break;
    }
    $entity_id = ContentManager::add_entity($context, $content, $params);
    redirect("{$CONFIG->wwwroot}/entity.php?id={$entity_id}");
}

$model = get_base_model();
echo $Twig->render('admin/' . get_entity_template($context), $model);
