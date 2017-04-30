<?php

require_once('../config.php');

require_login();

$context = required_param('context');
validate_context($context);

$accept = optional_param('accept', false);
$cancel = optional_param('cancel', false);
$returnurl = optional_param('returnurl', false);

if ($cancel !== false) {
    redirect($returnurl ? $returnurl : "{$CONFIG->wwwroot}/entities.php?context={$context}");
}

$model = get_base_model();
$model['title'] = 'Добавление элемента';
$model['context'] = $context;

if (post_data_submitted() && $accept !== false) {
    $result = EntityManager::add_object_from_submit();
    if (is_numeric($result)) {
        redirect($returnurl ? $returnurl : "{$CONFIG->wwwroot}/entity.php?id={$result}");
    } else if (is_array($result)) {
        $model['errors'] = $result['errors'];
        $model['content'] = $result['values']['content'];
        unset($result['values']['content']);
        $model['params'] = $result['values'];
    }
}

$template = 'admin/' . get_entity_template($context);
if (file_exists("$CONFIG->dirroot/templates/$template")) {
    echo $Twig->render($template, $model);
} else {
    redirect("$CONFIG->wwwroot/museum.php");
}
