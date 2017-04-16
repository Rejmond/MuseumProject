<?php

require_once('../config.php');

require_login();

$entity_id = required_param('id');
$filearea = required_param('filearea');
$returnurl = optional_param('returnurl', "{$CONFIG->wwwroot}/entity.php?id={$entity_id}#main");
$file = get_file('file', true);
if ($file && post_data_submitted()) {
    EntityManager::add_file($entity_id, $filearea, $file);
}
redirect($returnurl);
