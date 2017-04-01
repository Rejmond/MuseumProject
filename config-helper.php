<?php

$CONFIG = new stdClass();
//$CONFIG->dirroot = 'I:/www/Museum';
//$CONFIG->wwwroot = 'http://localhost:81';
//$CONFIG->dbpath = 'I:/www/Museum/database.db';
//$CONFIG->dataroot = 'I:/www/Museum/files';
$CONFIG->dirroot = 'C:/inetpub/wwwroot/museum';
$CONFIG->wwwroot = 'http://localhost:89';
$CONFIG->dbpath = 'C:/inetpub/wwwroot/museum/database.db';
$CONFIG->dataroot = 'C:/inetpub/wwwroot/museum/files';
$CONFIG->password = '000000';

$CONFIG->entities = array(
    'about' => array(
        'entity_template' => 'about.html',
        'entities_template' => false,
        'params' => array(),
        'attachments' => array(),
    ),
    'books' => array(
        'entity_template' => 'book.html',
        'entities_template' => 'books.html',
        'params' => array(
            'name' => array(
                'required' => true,
            ),
            'author' => array(
                'required' => true,
            ),
            'abstract' => array(
                'required' => true,
            ),
        ),
        'attachments' => array(
            'image' => array(
                'required' => false,
                'image' => true,
                'size' => array(150, 200),
                'list' => false,
            ),
            'attachment' => array(
                'required' => false,
                'image' => false,
                'list' => false,
            ),
        )
    ),
    'news' => array(
        'entity_template' => 'new.html',
        'entities_template' => 'news.html',
        'params' => array(
            'name' => array(
                'required' => true,
            ),
        ),
        'attachments' => array(
            'image' => array(
                'required' => false,
                'image' => true,
                'size' => array(150, 200),
                'list' => false,
            ),
            'photos' => array(
                'required' => false,
                'image' => true,
                'size' => array(400, 200),
                'list' => true,
            ),
        )
    ),
);

require_once('loader.php');
