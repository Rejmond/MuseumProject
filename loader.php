<?php

session_start();

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
