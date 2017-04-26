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
    'exposition' => array(
        'entity_template' => 'exposition.html',
        'entities_template' => 'expositions.html',
        'content_type' => PARAM_RAW,
        'params' => array(
            'name' => array(
                'required' => true,
                'type' => PARAM_NOTAGS,
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
    'exposition-scientists' => array(
        'entity_template' => 'exposition-scientist.html',
        'entities_template' => 'exposition-scientists.html',
        'content_type' => PARAM_NOTAGS,
        'perpage' => 10,
        'params' => array(
            'name' => array(
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
        'attachments' => array(
            'image' => array(
                'required' => false,
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
    'exposition-graduates' => array(
        'entity_template' => 'exposition-graduate.html',
        'entities_template' => 'exposition-graduates.html',
        'content_type' => PARAM_NOTAGS,
        'perpage' => 10,
        'params' => array(
            'name' => array(
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
        'attachments' => array(
            'image' => array(
                'required' => false,
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
    'calendar' => array(
        'entity_template' => 'date.html',
        'entities_template' => 'dates.html',
        'content_type' => PARAM_NOTAGS,
        'perpage' => 10,
        'params' => array(
            'name' => array(
                'required' => true,
                'type' => PARAM_NOTAGS,
            ),
            'timestamp' => array(
                'required' => true,
                'type' => PARAM_DATE,
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
                'required' => false,
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
    'paper1' => array(
        'entity_template' => 'paper-info.html',
        'entities_template' => false,
        'content_type' => PARAM_NOTAGS,
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
                'size' => array(1200, 800),
                'list' => false,
            ),
        )
    ),
    'papers1' => array(
        'entity_template' => 'paper.html',
        'entities_template' => 'paper.html',
        'content_type' => PARAM_NOTAGS,
        'params' => array(
            'year' => array(
                'required' => true,
                'type' => PARAM_INT,
            ),
            'number' => array(
                'required' => true,
                'type' => PARAM_INT,
            ),
        ),
        'attachments' => array(
            'file' => array(
                'required' => true,
                'image' => false,
                'list' => false,
            ),
        ),
    ),
    'paper2' => array(
        'entity_template' => 'paper-info.html',
        'entities_template' => false,
        'content_type' => PARAM_NOTAGS,
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
                'size' => array(1200, 800),
                'list' => false,
            ),
        )
    ),
    'papers2' => array(
        'entity_template' => 'paper.html',
        'entities_template' => 'paper.html',
        'content_type' => PARAM_NOTAGS,
        'params' => array(
            'year' => array(
                'required' => true,
                'type' => PARAM_INT,
            ),
            'number' => array(
                'required' => true,
                'type' => PARAM_INT,
            ),
        ),
        'attachments' => array(
            'file' => array(
                'required' => true,
                'image' => false,
                'list' => false,
            ),
        ),
    ),
    'leaders' => array(
        'entity_template' => 'leader.html',
        'entities_template' => 'leaders.html',
        'content_type' => PARAM_NOTAGS,
        'perpage' => 10,
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
            'order' => array(
                'required' => true,
                'type' => PARAM_INT,
            ),
        ),
        'attachments' => array(
            'image' => array(
                'required' => false,
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
    'memories' => array(
        'entity_template' => 'memory.html',
        'entities_template' => 'memories.html',
        'content_type' => PARAM_NOTAGS,
        'perpage' => 10,
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
                'size' => array(1200, 800),
                'list' => false,
            ),
            'files' => array(
                'required' => false,
                'image' => false,
                'list' => true,
            ),
            'photos' => array(
                'required' => false,
                'image' => true,
                'size' => array(1200, 800),
                'list' => true,
            ),
        ),
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
    'history-of-success' => array(
        'entity_template' => 'story.html',
        'entities_template' => 'stories.html',
        'content_type' => PARAM_NOTAGS,
        'perpage' => 10,
        'params' => array(
            'name' => array(
                'required' => true,
                'type' => PARAM_NOTAGS,
            ),
            'year' => array(
                'required' => true,
                'type' => PARAM_INT,
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
    /*                        projects                     */
    /*                                                     */
    'projects' => array(
        'entity_template' => 'project.html',
        'entities_template' => 'projects.html',
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
    /*                                                     */
    /*                     student-groups                  */
    /*                                                     */
    'student-groups' => array(
        'entity_template' => 'student-group.html',
        'entities_template' => 'student-groups.html',
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
