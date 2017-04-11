<?php

session_start();

define('MUSEUM_INTERNAL', true);
define('PARAM_RAW',      'raw');
define('PARAM_NOTAGS',   'tag');
define('PARAM_DATE',     'date');
define('PARAM_INT',      'int');
define('PARAM_FLOAT',    'float');

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
    'geologic' => array(
        'entity_template' => 'geologic.html',
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
    'news' => array(
        'entity_template' => 'new.html',
        'entities_template' => 'news.html',
        'content_type' => PARAM_NOTAGS,
        'perpage' => 2,
        'params' => array(
            'name' => array(
                'required' => true,
                'type' => PARAM_NOTAGS,
            ),
            'fulltext' => array(
                'required' => true,
                'type' => PARAM_RAW,
            ),
        ),
        'attachments' => array(
            'image' => array(
                'required' => false,
                'image' => true,
                'size' => array(400, 300),
                'list' => false,
            ),
            'photos' => array(
                'required' => false,
                'image' => true,
                //'size' => array(400, 200),
                'list' => true,
            ),
        )
    ),
    'exhibitions' => array(
        'entity_template' => 'theme.html',
        'entities_template' => 'themes.html',
        'content_type' => PARAM_NOTAGS,
        'perpage' => 2,
        'params' => array(
            'name' => array(
                'required' => true,
                'type' => PARAM_NOTAGS,
            ),
            'interval' => array(
                'required' => true,
                'type' => PARAM_NOTAGS,
            ),
            'fulltext' => array(
                'required' => true,
                'type' => PARAM_RAW,
            ),
        ),
        'attachments' => array(
            'image' => array(
                'required' => false,
                'image' => true,
                'size' => array(400, 300),
                'list' => false,
            ),
            'photos' => array(
                'required' => false,
                'image' => true,
                //'size' => array(400, 200),
                'list' => true,
            ),
        )
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
