<?php

/*
 * Правила определения новых контекстов:
 * 1. Имена параметров и прикреплений не должны быть равны content, date, context;
 * 2. Имена параметров и прикреплений не должны повторяться между собой;
 * 3. Если сущность одноэлементная, следует указать 'entities_template' => false, ее следует создать в БД заранее;
 * 4. Параметр 'perpage' не является обязательным, если его не указать, постраничного разделения не будет.
 */

$CONFIG = new stdClass();
$CONFIG->dirroot = 'C:/inetpub/wwwroot/museum';
$CONFIG->wwwroot = 'http://localhost:89';
$CONFIG->dbpath = 'C:/inetpub/wwwroot/museum/database.db';
$CONFIG->dataroot = 'C:/inetpub/wwwroot/museum/files';
$CONFIG->password = '123456';

require_once('loader.php');
