<?php

session_start();

define('MUSEUM_INTERNAL', true);
define('PARAM_RAW',      'raw');
define('PARAM_NOTAGS',   'tag');
define('PARAM_DATE',     'date');
define('PARAM_NUMBER',   'number');

$CONFIG->entities = array(
    'about' => array(
        'entity_template' => 'about.html',
        'entities_template' => false,
        'content_type' => PARAM_NOTAGS,
        'params' => array(
            'fulltext' => array(
                'required' => true,
                'type'     => PARAM_RAW,
            ),
        ),
        'attachments' => array(),
    ),
);

require_once($CONFIG->dirroot . '/Twig/Autoloader.php');
require_once($CONFIG->dirroot . '/lib/db.php');
require_once($CONFIG->dirroot . '/lib/auth.php');
require_once($CONFIG->dirroot . '/lib/content.php');
require_once($CONFIG->dirroot . '/lib/entity.php');
require_once($CONFIG->dirroot . '/lib/files.php');
require_once($CONFIG->dirroot . '/AcImage/AcImage.php');
require_once($CONFIG->dirroot . '/lib/helper.php');

$DB = new DBConnection($CONFIG->dbpath);
$USER = new User();

Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem($CONFIG->dirroot . '/templates');
$Twig = new Twig_Environment($loader);
