<?php

defined('MUSEUM_INTERNAL') || die;

class EntityManager
{

    public static function add_object_from_submit()
    {
        global $CONFIG;

        if (post_data_submitted()) {
            $context = required_param('context');
            validate_context($context);
            if (is_singleton_context($context)) {
                return false;
            }

            $values = array();
            $errors = array();
            $params = array();
            $files = array();

            $values['content'] = optional_param('content', '');
            $content_type = isset($CONFIG->entities[$context]['content_type']) ? $CONFIG->entities[$context]['content_type'] : PARAM_RAW;
            $content = clean_param($values['content'], $content_type);
            if ($content === '') { // Контент всегда обязателен?
                $errors['content'] = 'required';
            }

            foreach ($CONFIG->entities[$context]['params'] as $paramname => $options) {
                $values[$paramname] = optional_param($paramname, '');
                $value = clean_param($values[$paramname], isset($options['type']) ? $options['type'] : PARAM_RAW);
                $required = isset($options['required']) ? $options['required'] === true : false;
                if ($value === '' && $required) {
                    $errors[$paramname] = 'required';
                } else {
                    $params[$paramname] = $value;
                }
            }

            foreach ($CONFIG->entities[$context]['attachments'] as $paramname => $options) {
                $list = isset($options['list']) ? $options['list'] === true : false;
                if ($list) continue;
                $file = get_file($paramname, true);
                $required = isset($options['required']) ? $options['required'] === true : false;
                $image = isset($options['image']) ? $options['image'] === true : false;
                if (!$file && $required) {
                    $errors[$paramname] = 'required';
                } else if ($file) {
                    if ($image) {
                        if (AcImage::isFileImage($file['tmp_name'])) {
                            if (isset($options['size'])) {
                                resize_image($file['tmp_name'], $options['size'][0], $options['size'][1]);
                            }
                        } else {
                            $errors[$paramname] = 'required';
                            continue;
                        }
                    }
                    $files[$paramname] = $file;
                }
            }

            if (count($errors) == 0) {
                $entity_id = ContentManager::add_entity($context, $content, $params);
                foreach ($files as $filearea => $file) {
                    FileManager::add_file($entity_id, $filearea, $file);
                }
                return $entity_id;
            } else {
                return array('errors' => $errors, 'values' => $values);
            }
        } else {
            return false;
        }
    }

    public static function update_object_from_submit()
    {
        global $CONFIG;

        if (post_data_submitted()) {
            $entity_id = required_param('id');
            $entity = ContentManager::get_entity_by_id($entity_id);
            if (!$entity) {
                return false;
            }
            $context = $entity['context'];

            $values = array();
            $errors = array();
            $params = array();
            $files = array();

            $values['content'] = optional_param('content', '');
            $content_type = isset($CONFIG->entities[$context]['content_type']) ? $CONFIG->entities[$context]['content_type'] : PARAM_RAW;
            $content = clean_param($values['content'], $content_type);
            if ($content === '') { // Контент всегда обязателен?
                $errors['content'] = 'required';
            }

            foreach ($CONFIG->entities[$context]['params'] as $paramname => $options) {
                $values[$paramname] = optional_param($paramname, '');
                $value = clean_param($values[$paramname], isset($options['type']) ? $options['type'] : PARAM_RAW);
                $required = isset($options['required']) ? $options['required'] === true : false;
                if ($value === '' && $required) {
                    $errors[$paramname] = 'required';
                } else {
                    $params[$paramname] = $value;
                }
            }

            foreach ($CONFIG->entities[$context]['attachments'] as $paramname => $options) {
                $list = isset($options['list']) ? $options['list'] === true : false;
                if ($list) continue;
                $file = get_file($paramname, true);
                $image = isset($options['image']) ? $options['image'] === true : false;
                if ($file) {
                    if ($image) {
                        if (AcImage::isFileImage($file['tmp_name'])) {
                            if (isset($options['size'])) {
                                resize_image($file['tmp_name'], $options['size'][0], $options['size'][1]);
                            }
                        } else {
                            $errors[$paramname] = 'required';
                            continue;
                        }
                    }
                    $files[$paramname] = $file;
                }
            }

            if (count($errors) == 0) {
                ContentManager::update_entity($entity_id, $content, $params);
                foreach ($files as $filearea => $file) {
                    FileManager::delete_filearea($entity_id, $filearea);
                    FileManager::add_file($entity_id, $filearea, $file);
                }
                return true;
            } else {
                return array('errors' => $errors, 'values' => $values);
            }
        } else {
            return false;
        }
    }

    public static function delete_object_from_submit()
    {
        if (post_data_submitted()) {
            $entity_id = required_param('id');
            $entity = ContentManager::get_entity_by_id($entity_id);
            if (!$entity || is_singleton_context($entity['context'])) {
                return false;
            }
            ContentManager::delete_entity($entity_id);
            FileManager::delete_entity_files($entity_id);
            return $entity;
        } else {
            return false;
        }
    }

    public static function get_object($entity_id)
    {
        global $CONFIG;
        $entity = ContentManager::get_entity_by_id($entity_id);
        if (!$entity) {
            return false;
        }

        $entity['files'] = array();
        foreach ($CONFIG->entities[$entity['context']]['attachments'] as $paramname => $options) {
            $list = isset($options['list']) ? $options['list'] === true : false;
            if (!$list) {
                $filerecord = FileManager::get_file_by_filearea($entity_id, $paramname);
                if ($filerecord) {
                    $entity['files'][$paramname] = array();
                    $entity['files'][$paramname]['id'] = $filerecord['id'];
                    $entity['files'][$paramname]['name'] = pathinfo($filerecord['filename'], PATHINFO_FILENAME);
                    $entity['files'][$paramname]['type'] = pathinfo($filerecord['filename'], PATHINFO_EXTENSION);
                    $entity['files'][$paramname]['size'] = format_bytes(filesize(FileManager::get_file_path($filerecord['id'])));
                }
            } else {
                $filerecords = FileManager::get_files_in_filearea($entity_id, $paramname);
                if (count($filerecords) > 0) {
                    $entity['files'][$paramname] = array();
                    foreach ($filerecords as $filerecord) {
                        $fileid = $filerecord['id'];
                        $entity['files'][$paramname][$fileid] = array();
                        $entity['files'][$paramname][$fileid]['id'] = $fileid;
                        $entity['files'][$paramname][$fileid]['name'] = pathinfo($filerecord['filename'], PATHINFO_FILENAME);
                        $entity['files'][$paramname][$fileid]['type'] = pathinfo($filerecord['filename'], PATHINFO_EXTENSION);
                        $entity['files'][$paramname][$fileid]['size'] = format_bytes(filesize(FileManager::get_file_path($fileid)));
                    }
                }
            }
        }

        return $entity;
    }

    public static function add_file($entity_id, $filearea, $file)
    {
        global $CONFIG;
        $entity = ContentManager::get_entity_by_id($entity_id);
        if (!$entity) {
            return false;
        }
        $context = $entity['context'];
        if (!isset($CONFIG->entities[$context]['attachments'][$filearea])) {
            return false;
        }
        $options = $CONFIG->entities[$context]['attachments'][$filearea];

        $image = isset($options['image']) ? $options['image'] === true : false;
        if ($image) {
            if (AcImage::isFileImage($file['tmp_name'])) {
                if (isset($options['size'])) {
                    resize_image($file['tmp_name'], $options['size'][0], $options['size'][1]);
                }
            } else {
                return false;
            }
        }

        $list = isset($options['list']) ? $options['list'] === true : false;
        if (!$list) {
            FileManager::delete_filearea($entity_id, $filearea);
        }
        FileManager::add_file($entity_id, $filearea, $file);
        return true;
    }

    public static function delete_file($file_id)
    {
        global $CONFIG;
        $file = FileManager::get_file_by_id($file_id);
        $filearea = $file['filearea'];
        $entity = ContentManager::get_entity_by_id($file['entity']);
        $context = $entity['context'];
        $options = $CONFIG->entities[$context]['attachments'][$filearea];

        $list = isset($options['list']) ? $options['list'] === true : false;
        $required = isset($options['required']) ? $options['required'] === true : false;
        if ($list || !$required) {
            FileManager::delete_file_by_id($file_id);
            return true;
        } else {
            return false;
        }
    }

}
