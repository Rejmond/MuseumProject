<?php

class ContentManager
{

    public static function get_entity_by_id($entity_id)
    {
        global $DB;
        $record = $DB->get_record('entities', array('id' => $entity_id));
        $params = $DB->get_records('params', array('entity' => $entity_id));
        $record['params'] = array();
        foreach ($params as $param) {
            $record['params'][$param['name']] = $param['value'];
        }
        return $record;
    }

    public static function get_entity_by_context($context)
    {
        global $DB;
        $record = $DB->get_record('entities', array('context' => $context));
        $params = $DB->get_records('params', array('entity' => $record['id']));
        $record['params'] = array();
        foreach ($params as $param) {
            $record['params'][$param['name']] = $param['value'];
        }
        return $record;
    }

    public static function get_entities($context, array $conditions = array())
    {
        global $DB;
        if (!empty($conditions)) {
            $sql = 'SELECT e.id as id, context, content, date FROM entities e
                INNER JOIN params p
                ON e.id = p.entity 
                WHERE e.context = :context ';
            $keys = array_keys($conditions);
            $args = array_map(function ($e) {
                return "p.name = \"$e\" AND p.value = :$e";
            }, $keys);
            $sql .= "AND " . implode(' AND ', $args) . "";
        } else {
            $sql = 'SELECT * from entities WHERE context = :context';
            $conditions['context'] = $context;
            $records = $DB->get_records_sql($sql, $conditions);
            foreach ($records as $index => $record) {
                $params = $DB->get_records('params', array('entity' => $records[$index]['id']));
                $records[$index]['params'] = array();
                foreach ($params as $param) {
                    $records[$index]['params'][$param['name']] = $param['value'];
                }
            }
        }
        $conditions['context'] = $context;
        $records = $DB->get_records_sql($sql, $conditions);
        foreach ($records as $index => $record) {
            $params = $DB->get_records('params', array('entity' => $records[$index]['id']));
            $records[$index]['params'] = array();
            foreach ($params as $param) {
                $records[$index]['params'][$param['name']] = $param['value'];
            }
        }
        return $records;
    }

    public static function update_entity($entity_id, $content, array $params = array())
    {
        global $DB;
        $args = array(
            'content' => $content,
        );
        $DB->update_record('entities', $entity_id, $args);
        self::delete_params($entity_id);
        self::add_params($entity_id, $params);
    }

    public static function add_entity($context, $content, array $params = array())
    {
        global $DB;
        $args = array(
            'context' => $context,
            'content' => $content,
            'date' => time()
        );
        $entity_id = $DB->insert_record('entities', $args);
        self::add_params($entity_id, $params);
        return $entity_id;
    }

    public static function delete_entity($entity_id)
    {
        global $DB;
        $DB->delete_record('entities', $entity_id);
    }

    private static function add_params($entity_id, $params)
    {
        global $DB;
        $entity = $DB->get_record('entities', array('id' => $entity_id));
        foreach ($params as $name => $value) {
            if (param_is_correct($entity['context'], $name)) {
                $param_args = array(
                    'entity' => $entity_id,
                    'name' => $name,
                    'value' => $value
                );
                $DB->insert_record('params', $param_args);
            }
        }
    }

    private static function delete_params($entity_id)
    {
        global $DB;
        $sql = 'DELETE FROM params WHERE entity = ?';
        $DB->execute($sql, array($entity_id));
    }

}
