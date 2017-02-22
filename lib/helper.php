<?php

function require_login() {
    global $USER, $CONFIG;
    if (!$USER->is_admin()) {
        header("Location: {$CONFIG->wwwroot}/auth.php");
    }
}

function get_context_name($context) {
    $array = array (
        'about' => 'О музее',
        'books' => 'Книги'
    );
    return $array[$context];
}

function get_entity_template($context) {
    $array = array (
        'about' => 'about.html',
        'books' => 'book.html'
    );
    return $array[$context];
}

function get_entities_template($context) {
    $array = array (
        'books' => 'books.html'
    );
    return $array[$context];
}

function get_navigation() {
    global $CONFIG, $DB;
    return array(
        'about_link' => "{$CONFIG->wwwroot}/entity.php?context=about",
        'books_link' => "{$CONFIG->wwwroot}/entities.php?context=books"
    );
}

function required_param($name) {
    if (isset($_POST[$name])) {
        return $_POST[$name];
    }
    if (isset($_GET[$name])) {
        return $_GET[$name];
    }
    die("Argument with name \"$name\" is required.");
}

function optional_param($name, $default) {
    if (isset($_POST[$name])) {
        return $_POST[$name];
    }
    if (isset($_GET[$name])) {
        return $_GET[$name];
    }
    return $default;
}

function post_data_submitted() {
    return !empty($_POST);
}
