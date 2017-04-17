<?php

defined('MUSEUM_INTERNAL') || die;

function require_login() {
    global $USER, $CONFIG;
    if (!$USER->is_admin()) {
        redirect("{$CONFIG->wwwroot}/auth.php");
    }
}

function get_entity_template($context) {
    global $CONFIG;
    return $CONFIG->entities[$context]['entity_template'];
}

function get_entities_template($context) {
    global $CONFIG;
    return $CONFIG->entities[$context]['entities_template'];
}

function is_singleton_context($context) {
    global $CONFIG;
    return $CONFIG->entities[$context]['entities_template'] === false;
}

function get_base_model() {
    global $CONFIG, $USER;
    return array(
        'wwwroot'     => $CONFIG->wwwroot,
        'admin'       => $USER->is_admin(),
        'current_url' => $CONFIG->wwwroot . $_SERVER['REQUEST_URI']
    );
}

function validate_context($context) {
    global $CONFIG;
    $correct_contexts = array_keys($CONFIG->entities);
    if (!in_array($context, $correct_contexts)) {
        die("Context \"$context\" is incorrect");
    }
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

function resize_image($filepath, $width, $height)
{
    AcImage::setRewrite(true);
    $img = AcImage::createImage($filepath);
    $width_origin = $img->getWidth();
    $height_origin = $img->getHeight();
    if ($width_origin > $width && $height_origin > $height) {
       /* $img->cropCenter("{$width}pr", "{$height}pr");*/
        $img->resizeByHeight($height);
        $img->resizeByWidth($width);
    } else {
        $img->cropCenter($width, $height);
    }
    $img->save($filepath);
}

function limit_words($string, $limit) {
    $words = explode(' ', $string);
    return implode(' ', array_splice($words, 0, $limit));
}

function clean_param($param, $type)
{
    switch ($type)
    {
        case PARAM_RAW:
            return trim($param);

        case PARAM_NOTAGS:
            return trim(strip_tags($param));

        case PARAM_INT:
            return is_int($param) ? (int)$param : '';

        case PARAM_FLOAT:
            return is_numeric($param) ? (float)$param : '';

        case PARAM_DATE:
            $date = DateTime::createFromFormat('d.m.Y', $param);
            return $date ? $date->format('d.m.Y') : '';

        default:
            die('unknownparamtype');
    }
}

function pagination($baseurl, $totalcount, $page, $perpage)
{
    $maxdisplay = 9;
    $symbol = mb_strpos($baseurl, '?') !== false ? '&' : '?';

    $result = array();
    $result['current'] = $page + 1;
    $result['first'] = false; // если установлено, требуется первое "многоточие"
    $result['previous'] = false;
    $result['pages'] = array();
    $result['next'] = false;
    $result['last'] = false; // если установлено, требуется второе "многоточие"
    if ($totalcount > $perpage) {
        if ($page > 0) {
            $pageinfo = array('label' => '<', 'url' => $baseurl . $symbol . 'page=' . ($page - 1) . '#main');
            $result['previous'] = $pageinfo;
        }

        $lastpage = ceil($totalcount / $perpage);

        if ($page > round($maxdisplay / 3 * 2)) {
            $currpage = $page - round($maxdisplay / 3);
            $pageinfo = array('label' => '1', 'url' => $baseurl . $symbol . 'page=0' . '#main');
            $result['first'] = $pageinfo;
        } else {
            $currpage = 0;
        }

        $displaycount = 0;
        while ($displaycount < $maxdisplay and $currpage < $lastpage) {
            $pageinfo = array('label' => $currpage + 1, 'url' => $baseurl . $symbol . 'page=' . $currpage . '#main');
            $result['pages'][] = $pageinfo;
            $displaycount++;
            $currpage++;
        }

        if ($currpage < $lastpage) {
            $pageinfo = array('label' => $lastpage, 'url' => $baseurl . $symbol . 'page=' . ($lastpage - 1) . '#main');
            $result['last'] = $pageinfo;
        }

        if ($page + 1 != $lastpage) {
            $pageinfo = array('label' => '>', 'url' => $baseurl . $symbol . 'page=' . ($page + 1) . '#main');
            $result['next'] = $pageinfo;
        }
    }

    return $result;
}
