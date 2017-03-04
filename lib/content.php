<?php

class ContentManager {

    public static function get_entity_by_id($entity_id) {
        global $DB;
        $record = $DB->get_record('entities', array('id' => $entity_id));
        if (!empty($record['params'])) {
            $jsonData = $record['params'];
            $data = json_decode($jsonData);
            $record['params'] = (array)$data;
        }
        return $record;
    }

    public static function get_entity_by_context($context) {
        global $DB;
        $record = $DB->get_record('entities', array('context' => $context));
        if (!empty($record['params'])) {
            $jsonData = $record['params'];
            $data = json_decode($jsonData);
            $record['params'] = (array)$data;
        }
        return $record;
    }

    public static function get_entities($context) {
        global $DB;
        $records = $DB->get_records('entities', array('context' => $context));
        for ($i = 0; $i < count($records); $i++) {
            $jsonData = $records[$i]['params'];
            $data = json_decode($jsonData);
            $records[$i]['params'] = (array)$data;
        }
        return $records;
    }

    public static function update_entity($entity_id, $content, array $params = array()) {
        global $DB;
        if (count($params) > 0) {
            $args = array(
                'content' => $content,
                'params'  => json_encode((object)$params),
            );
        } else {
            $args = array(
                'content' => $content,
            );
        }
        $DB->update_record('entities', $entity_id, $args);
    }

    public static function add_entity($context, $content, array $params = array()) {
        global $DB;
        if (count($params) > 0) {
            $args = array(
                'context' => $context,
                'content' => $content,
                'params'  => json_encode((object)$params),
                'date'    => time()
            );
        } else {
            $args = array(
                'context' => $context,
                'content' => $content,
                'date'    => time()
            );
        }
        return $DB->insert_record('entities', $args);
    }

    public static function delete_entity($entity_id) {
        global $DB;
        $DB->delete_record('entities', $entity_id);
    }

}
