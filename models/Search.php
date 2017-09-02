<?php

class Search
{
    //Поиск по  таблице news
    public static function newsSearch($words, $tableName, $action = 1)
    {
        $words = htmlspecialchars($words);
        if ($words == "") return false;
        $query_search = "";

        //если выбрали любое слово
        if ($action == 1) {
            $arraywords = explode(" ", $words);
            foreach ($arraywords as $key => $value) {
                if (isset($arraywords[$key - 1]))
                    $query_search .= ' OR ';
                $query_search .= '`title` LIKE "%' . $value . '%" OR `content` LIKE "%' . $value . '%"';
            }
            $sql = "SELECT * FROM $tableName WHERE $query_search";
            $db = Db::getConnection();
            $result = $db->query($sql);
            $i = 0;
            $results = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $results[$i] = $row;
                $i++;
            }
            return $results;
        }

        //если выбрали все слова
        if ($action == 2) {
            $arraywords = explode(" ", $words);
            foreach ($arraywords as $key => $value) {
                if (isset($arraywords[$key - 1]))
                    $query_search .= ' AND ';
                $query_search .= '`title` LIKE "%' . $value . '%" OR `content` LIKE "%' . $value . '%"';
            }
            $sql = "SELECT * FROM $tableName WHERE $query_search";
            $db = Db::getConnection();
            $result = $db->query($sql);
            $i = 0;
            $results = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $results[$i] = $row;
                $i++;
            }
            return $results;
        }

        //если выбрали Точное совпадение
        if ($action == 3) {
            $query_search .= '`title` LIKE "%' . $words . '%" OR `content` LIKE "%' . $words . '%"';

            $sql = "SELECT * FROM $tableName WHERE $query_search";
            $db = Db::getConnection();
            $result = $db->query($sql);
            $i = 0;
            $results = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $results[$i] = $row;
                $i++;
            }
            return $results;
        }

    }

    //Поиск по  таблице category
    public static function categorySearch($words, $tableName, $action = 1)
    {
        $words = htmlspecialchars($words);
        if ($words == "") return false;
        $query_search = "";

        //если выбрали любое слово
        if ($action == 1) {
            $arraywords = explode(" ", $words);
            foreach ($arraywords as $key => $value) {
                if (isset($arraywords[$key - 1]))
                    $query_search .= ' OR ';
                $query_search .= '`title` LIKE "%' . $value . '%" OR `short_content` LIKE "%' . $value . '%"';
            }
            $sql = "SELECT * FROM $tableName WHERE $query_search";
            $db = Db::getConnection();
            $result = $db->query($sql);
            $i = 0;
            $results = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $results[$i] = $row;
                $i++;
            }
            return $results;
        }

        //если выбрали все слова
        if ($action == 2) {
            $arraywords = explode(" ", $words);
            foreach ($arraywords as $key => $value) {
                if (isset($arraywords[$key - 1]))
                    $query_search .= ' AND ';
                $query_search .= '`title` LIKE "%' . $value . '%" OR `short_content` LIKE "%' . $value . '%"';
            }
            $sql = "SELECT * FROM $tableName WHERE $query_search";
            $db = Db::getConnection();
            $result = $db->query($sql);
            $i = 0;
            $results = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $results[$i] = $row;
                $i++;
            }
            return $results;
        }

        //если выбрали Точное совпадение
        if ($action == 3) {
            $query_search .= '`title` LIKE "%' . $words . '%" OR `short_content` LIKE "%' . $words . '%"';

            $sql = "SELECT * FROM $tableName WHERE $query_search";
            $db = Db::getConnection();
            $result = $db->query($sql);
            $i = 0;
            $results = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $results[$i] = $row;
                $i++;
            }
            return $results;
        }

    }

    //Поиск по  таблице forum
    public static function forumSearch($words, $tableName, $current_category_id = 1, $action = 1)
    {
        $words = htmlspecialchars($words);
        if ($words == "") return false;
        $query_search = "";

        //если выбрали любое слово
        if ($action == 1) {
            $arraywords = explode(" ", $words);
            foreach ($arraywords as $key => $value) {
                if (isset($arraywords[$key - 1]))
                    $query_search .= ' OR ';
                $query_search .= '`title` LIKE "%' . $value . '%"';
            }
            $sql = "SELECT * FROM $tableName WHERE $query_search AND `current_category_id`= $current_category_id";
            $db = Db::getConnection();
            $result = $db->query($sql);
            $i = 0;
            $results = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $results[$i] = $row;
                $i++;
            }
            return $results;
        }

        //если выбрали все слова
        if ($action == 2) {
            $arraywords = explode(" ", $words);
            foreach ($arraywords as $key => $value) {
                if (isset($arraywords[$key - 1]))
                    $query_search .= ' AND ';
                $query_search .= '`title` LIKE "%' . $value . '%"';
            }
            $sql = "SELECT * FROM $tableName WHERE $query_search AND `current_category_id`= $current_category_id";
            $db = Db::getConnection();
            $result = $db->query($sql);
            $i = 0;
            $results = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $results[$i] = $row;
                $i++;
            }
            return $results;
        }

        //если выбрали Точное совпадение
        if ($action == 3) {
            $query_search .= '`title` LIKE "%' . $words . '%"';

            $sql = "SELECT * FROM $tableName WHERE $query_search AND `current_category_id`= $current_category_id";
            $db = Db::getConnection();
            $result = $db->query($sql);
            $i = 0;
            $results = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $results[$i] = $row;
                $i++;
            }
            return $results;
        }

    }

    //Поиск по  таблице user
    public static function userSearch($words, $tableName, $action = 1)
    {

        if ($words == "") return false;
        $query_search = "";

        //если выбрали любое слово
        if ($action == 1) {
            $words = htmlspecialchars($words);
            $arraywords = explode(" ", $words);
            foreach ($arraywords as $key => $value) {
                if (isset($arraywords[$key - 1]))
                    $query_search .= ' OR ';
                $query_search .= '`id` LIKE "%' . $value . '%" OR `name` LIKE "%' . $value . '%"';
            }
            $sql = "SELECT * FROM $tableName WHERE $query_search";
            $db = Db::getConnection();
            $result = $db->query($sql);
            $i = 0;
            $results = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $results[$i] = $row;
                $i++;
            }
            return $results;
        }

        //если выбрали по Id
        if ($action == 2) {
            $words = intval($words);

            $sql = "SELECT * FROM $tableName WHERE `id` = $words";
            $db = Db::getConnection();
            $result = $db->query($sql);
            if ($result) {
                $i = 0;
                $results = array();

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $results[$i] = $row;
                    $i++;
                }
                return $results;
            }
        }

        //если выбрали по Имени
        if ($action == 3) {
        $words = '\''.$words.'\'';
            $db = Db::getConnection();
            $result = $db->query('SELECT * FROM '.$tableName.' WHERE `name` = '.$words);
            $i = 0;
            $results = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $results[$i] = $row;
                $i++;
            }
            return $results;

        }

    }
}