<?php

require_once('../config.php');

require_login();

echo $Twig->render('admin/index.html', array());
