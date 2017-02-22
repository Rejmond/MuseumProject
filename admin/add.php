<?php

require_once('../config.php');

require_login();

$context = required_param('context');

if (post_data_submitted()) {
    switch ($context) {
        case 'books':
            $params = array(
                'name' => required_param('name'),
                'abstract' => required_param('abstract'),
                'info' => required_param('info')
            );
            break;
    }
    $entity_id = ContentManager::add_entity($context, required_param('content'), $params);
    header("Location: {$CONFIG->wwwroot}/entity.php?id={$entity_id}");
}

echo $Twig->render('admin/' . get_entity_template($context), array());
