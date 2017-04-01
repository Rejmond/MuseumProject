<?php

$CONFIG = new stdClass();
$CONFIG->dirroot = 'C:/OpenServer/domains/museum.sibsiu';
$CONFIG->wwwroot = 'http://museum.sibsiu';
$CONFIG->dbpath = 'C:/OpenServer/domains/museum.siu2/database.db';
$CONFIG->dataroot = 'C:/OpenServer/domains/museum.sibsiu/files';
$CONFIG->password = '000000';

$CONFIG->entities = array(
    'about' => array(
        'entity_template' => 'about.html',
        'entities_template' => false,
        'params' => array(),
        'attachments' => array(),
    ),
);

require_once('loader.php');
