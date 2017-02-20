<?php

class ContentManager {

    public static function GetPostContent($context, $itemid = null) {
        global $DB;
        $sql = "SELECT * FROM posts WHERE context = ? ";
        if (!empty($itemid)) {
            $sql .= "AND itemid = ?";
            $record = $DB->get_record_sql($sql, array($context, $itemid));
            $jsonData = $record['params'];
            $record['data'] = (array)json_decode($jsonData);
            return $record;
        } else {
            return $DB->get_record_sql($sql, array($context));
        }
    }

    public static function GetPostsInfo($context) {
        global $DB;
        $sql = "SELECT * FROM posts WHERE context = ? ";
        $records = $DB->get_records_sql($sql, array($context));
        for ($i = 0; $i < count($records); $i++) {
            $jsonData = $records[$i]['params'];
            $records[$i]['data'] = (array)json_decode($jsonData);
        }
        return $records;
    }

    public static function UpdatePostContent($context, $content, $itemid = null, array $params = array()) {
        global $DB;
        if ($itemid != null && count($params) > 0) {
            $sql = "UPDATE posts SET content = ? , params = ? WHERE context = ? AND itemid = ?";
            $paramJson = json_encode((object)$params);
            $DB->execute($sql, array($content, $paramJson, $context, $itemid));
        } else {
            $sql = "UPDATE posts SET content = ? WHERE context = ?";
            $DB->execute($sql, array($content, $context));
        }
    }

    public static function AddPostContent($context, $content, array $params = array()) {
        global $DB;
        if (count($params) > 0) {
            $sql = 'SELECT max(itemid) AS maxitemid FROM posts WHERE context = ?';
            $maxitemid = $DB->get_record_sql($sql, array($context));
            $sql = 'INSERT INTO posts (context, content, itemid, params, date) VALUES (? , ? , ? , ?, ?)';
            $args = array(
                $context,
                $content,
                $maxitemid['maxitemid'] + 1,
                json_encode((object)$params),
                '2017-02-19'
            );
            $DB->execute($sql, $args);
        } else {
            $sql = 'INSERT INTO posts (context, content) VALUES (?, ?)';
            $args = array(
                'context' => $context,
                'content' => $content
            );
            $DB->execute($sql, $args);
        }
    }

    public static function DeletePost($context, $itemid) {
        global $DB;
        $sql = "DELETE FROM posts WHERE context = ? AND itemid = ?";
        $DB->execute($sql, array($context, $itemid));
    }

}
