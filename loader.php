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
        'perpage' => 5,
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
            'photos' => array(
                'required' => false,
                'image' => true,
                'size' => array(1200, 800),
                'list' => true,
            ),
        )
    ),
    'exhibitions' => array(
        'entity_template' => 'exhibition.html',
        'entities_template' => 'exhibitions.html',
        'content_type' => PARAM_NOTAGS,
        'perpage' => 5,
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
            'photos' => array(
                'required' => false,
                'image' => true,
                'size' => array(1200, 800),
                'list' => true,
            ),
        )
    ),
    'presents' => array(
        'entity_template' => 'present.html',
        'entities_template' => 'presents.html',
        'content_type' => PARAM_NOTAGS,
        'perpage' => 5,
        'params' => array(
            'name' => array(
                'required' => true,
                'type' => PARAM_NOTAGS,
            ),
            'presenter' => array(
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
                'required' => true,
                'image' => true,
                'size' => array(1200, 800),
                'list' => false,
            ),
            'photos' => array(
                'required' => false,
                'image' => true,
                'size' => array(1200, 800),
                'list' => true,
            ),
        )
    ),
    /*                                                     */
    /*                   history entities                  */
    /*                                                     */
    'about-history' => array(
        'entity_template' => 'about-history.html',
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
    'periods' => array(
        'entity_template' => 'period.html',
        'entities_template' => 'periods.html',
        'content_type' => PARAM_NOTAGS,
        'params' => array(
            'interval' => array(
                'required' => true,
                'type' => PARAM_NOTAGS,
            ),
            'fulltext' => array(
                'required' => true,
                'type' => PARAM_RAW,
            ),
            'order' => array(
                'required' => true,
                'type' => PARAM_INT,
            ),
        ),
        'attachments' => array(),
    ),
    'books' => array(
        'entity_template' => 'book.html',
        'entities_template' => 'books.html',
        'content_type' => PARAM_NOTAGS,
        'perpage' => 10,
        'params' => array(
            'name' => array(
                'required' => true,
                'type' => PARAM_NOTAGS,
            ),
            'description' => array(
                'required' => true,
                'type' => PARAM_RAW,
            ),
        ),
        'attachments' => array(
            'image' => array(
                'required' => false,
                'image' => true,
                'size' => array(1200, 800),
                'list' => false,
            ),
            'files' => array(
                'required' => false,
                'image' => false,
                'list' => true,
            ),
        )
    ),
    'history-of-institute' => array(
        'entity_template' => 'history-of-institute.html',
        'entities_template' => 'history-of-institute.html',
        'content_type' => PARAM_NOTAGS,
        'params' => array(
            'link' => array(
                'required' => true,
                'type' => PARAM_NOTAGS,
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
