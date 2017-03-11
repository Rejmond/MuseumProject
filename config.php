<?php

$CONFIG = new stdClass();
$CONFIG->dirroot = 'I:/www/Museum';
$CONFIG->wwwroot = 'http://localhost:81';
$CONFIG->dbpath = 'I:/www/Museum/database.db';
$CONFIG->dataroot = 'I:/www/Museum/files';
//$CONFIG->dirroot = 'C:/inetpub/wwwroot/museum';
//$CONFIG->wwwroot = 'http://localhost:89';
//$CONFIG->dbpath = 'C:/inetpub/wwwroot/museum/database.db';
//$CONFIG->dataroot = 'C:/inetpub/wwwroot/museum/files';
$CONFIG->password = '000000';

require_once('loader.php');
