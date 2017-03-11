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

    public static function get_entity_by_context($context) // Осторожно! Только для одноэлементных сущностей
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
            $sql = 'SELECT e.id, COUNT(e.id) AS temp
                      FROM entities e
                INNER JOIN params p ON e.id = p.entity
                     WHERE e.context = :context ';
            $keys = array_keys($conditions);
            $args = array_map(function ($e) {
                global $DB;
                return "(p.name = " . $DB->quote($e) . " AND p.value = :$e)";
            }, $keys);
            $sql .= 'AND (' . implode(' OR ', $args) . ') ';
            $sql .= 'GROUP BY e.id HAVING temp = ' . count($conditions);
        } else {
            $sql = 'SELECT id
                      FROM entities
                     WHERE context = :context';
        }

        $result = array();
        $conditions['context'] = $context;
        $ids = $DB->get_records_sql($sql, $conditions);
        foreach ($ids as $id) {
            $result[] = self::get_entity_by_id($id['id']);
        }
        return $result;
    }

    public static function add_entity($context, $content, array $params = array())
    {
        global $DB;
        self::validate_context($context);
        $args = array(
            'context' => $context,
            'content' => $content,
            'date'    => time()
        );
        $entity_id = $DB->insert_record('entities', $args);
        self::add_params($entity_id, $params);
        return $entity_id;
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

    public static function delete_entity($entity_id)
    {
        global $DB;
        self::delete_params($entity_id);
        $DB->delete_record('entities', $entity_id);
    }

    private static function add_params($entity_id, $params)
    {
        global $DB;
        $entity = $DB->get_record('entities', array('id' => $entity_id));
        foreach (self::get_params()[$entity['context']] as $paramname) {
            $param_args = array(
                'entity' => $entity_id,
                'name'   => $paramname,
                'value'  => isset($params[$paramname]) ? $params[$paramname] : ''
            );
            $DB->insert_record('params', $param_args);
        }
    }

    private static function delete_params($entity_id)
    {
        global $DB;
        $sql = 'DELETE FROM params WHERE entity = ?';
        $DB->execute($sql, array($entity_id));
    }

    private static function validate_context($context) {
        $correct_params = self::get_params();
        if (!in_array($context, array_keys($correct_params))) {
            die("Context \"$context\" is incorrect");
        }
    }

    private static function get_params() { // Предполагается расширение
        return array(
            'about' => array(),
            'books' => array(
                'author',
                'abstract',
                'name'
            )
        );
    }
    
}
