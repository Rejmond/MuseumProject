<?php

class FileManager
{

    public static function add_file($entity, $filearea, $file)
    {
        global $DB;
        $args = array(
            'entity' => $entity,
            'filearea' => $filearea,
            'filename' => $file['name'],
        );
        if ($record = $DB->get_record('files', $args)) {
            self::delete_file_by_id($record['id']);
        }
        $file_id = $DB->insert_record('files', $args);
        $path = self::get_file_path($file_id);
        if (!move_uploaded_file($file['tmp_name'], $path)) {
            die("Upload error");
        }
    }

    public static function get_file_by_filearea($entity, $filearea)
    {
        global $DB;
        $args = array(
            'entity' => $entity,
            'filearea' => $filearea
        );
        if ($records = $DB->get_records('files', $args)) {
            if (count($records) > 1) {
                die("Too many files in filearea");
            } else {
                return $records[0];
            }
        } else {
            return false;
        }
    }

    public static function get_files_in_filearea($entity, $filearea)
    {
        global $DB;
        $args = array(
            'entity' => $entity,
            'filearea' => $filearea
        );
        return $DB->get_records('files', $args);
    }

    public static function get_file_by_id($id)
    {
        global $DB;
        return $DB->get_record('files', array('id' => $id));
    }

    public static function delete_file_by_id($id)
    {
        global $DB;
        $path = self::get_file_path($id);
        echo $path;
        if (!unlink($path)) {
            die("Delete error");
        }
        $DB->delete_record('files', $id);
    }

    public static function delete_filearea($entity, $filearea)
    {
        $files = self::get_files_in_filearea($entity,  $filearea);
        foreach ($files as $file) {
            self::delete_file_by_id($file['id']);
        }
    }

    public static function delete_entity_files($entity)
    {
        global $DB;
        $records = $DB->get_records('files', array('entity' => $entity));
        foreach ($records as $record) {
            self::delete_file_by_id($record['id']);
        }
    }

    public static function get_file_path($id)
    {
        global $CONFIG;
        $a = $id % 100;
        $a1 = floor($id / 100);
        $b = $a1 % 100;
        $dirpath = "{$CONFIG->dataroot}/$a/$b";
        if (!file_exists($dirpath)) {
            mkdir($dirpath, 777, true);
        }
        return "$dirpath/$id";
    }

}