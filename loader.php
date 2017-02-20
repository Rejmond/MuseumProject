<?php

session_start();

require_once('Twig/Autoloader.php');
require_once($CONFIG->dataroot . '/lib/db.php');
require_once($CONFIG->dataroot . '/lib/auth.php');
require_once($CONFIG->dataroot . '/lib/helper.php');
require_once($CONFIG->dataroot . '/lib/content.php');

$DB = new DBConnection($CONFIG->dbpath);
$USER = new User();

Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem($CONFIG->dataroot . '/templates');
$Twig = new Twig_Environment($loader);
