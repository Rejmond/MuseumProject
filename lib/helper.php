<?php

function require_login() {
    global $USER, $CONFIG;
    if (!$USER->is_admin()) {
        header("Location: {$CONFIG->wwwroot}/auth.php");
    }
}