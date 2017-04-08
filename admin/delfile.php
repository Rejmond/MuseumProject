<?php

require_once('../config.php');

require_login();

$file_id = required_param('id');
$filerecord = FileManager::get_file_by_id($file_id);
if ($filerecord && post_data_submitted()) {
    EntityManager::delete_file($file_id);
    redirect("{$CONFIG->wwwroot}/entity.php?id={$filerecord['entity']}#main");
}
