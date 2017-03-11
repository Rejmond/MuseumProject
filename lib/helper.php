<?php

function require_login() {
    global $USER, $CONFIG;
    if (!$USER->is_admin()) {
        redirect("{$CONFIG->wwwroot}/auth.php");
    }
}

function get_context_name($context) { // Предполагается расширение
    $array = array (
        'about' => 'О музее',
        'books' => 'Книги'
    );
    return $array[$context];
}

function get_entity_template($context) { // Предполагается расширение
    $array = array (
        'about' => 'about.html',
        'books' => 'book.html'
    );
    return $array[$context];
}

function get_entities_template($context) { // Предполагается расширение
    $array = array (
        'books' => 'books.html'
    );
    return $array[$context];
}

function get_navigation() { // Предполагается расширение
    global $CONFIG;
    return array(
        'about_link' => "{$CONFIG->wwwroot}/entity.php?context=about",
        'books_link' => "{$CONFIG->wwwroot}/entities.php?context=books"
    );
}

function get_base_model() {
    global $CONFIG, $USER;
    return array(
        'wwwroot' => $CONFIG->wwwroot,
        'admin'   => $USER->is_admin()
    );
}

function required_param($name) {
    if (isset($_POST[$name])) {
        return $_POST[$name];
    }
    if (isset($_GET[$name])) {
        return $_GET[$name];
    }
    die("The argument with name \"$name\" is required.");
}

function optional_param($name, $default = null) {
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

function get_file($name, $optional = false) {
    if (isset($_FILES[$name])) {
        if ($_FILES[$name]['size'] == 0) {
            if ($optional) {
                return false;
            } else {
                die("The file with name \"$name\" is required.");
            }
        } else {
            return $_FILES[$name];
        }
    } else {
        if ($optional) {
            return false;
        } else {
            die("The file with name \"$name\" is required.");
        }
    }
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function resize($filepath, $width, $height)
{
    AcImage::setRewrite(true);
    $img = AcImage::createImage($filepath);
    $width_origin = $img->getWidth();
    $height_origin = $img->getHeight();
    if ($width_origin > $width && $height_origin > $height) {
        $img->cropCenter("{$width}pr", "{$height}pr");
        $img->resizeByHeight($height);
        $img->resizeByWidth($width);;
    } else {
        $img->cropCenter($width, $height);
    }
    $img->save($filepath);
}
