<?php

class CommentsForum
{
    const SHOW_BY_DEFAULT = 5;

    //Получаем список комментариев определенной темы форума
    public static function getCommentsItem($categoryId = false, $page = 1)
    {
        if ($categoryId) {

            $page = intval($page);
            $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

            $db = Db::getConnection();
            $commentsList = array();
            $result = $db->query("SELECT * FROM comments_forum "
                . "WHERE `forum_id` = '$categoryId' "
                . "ORDER BY date DESC "
                . "LIMIT " . self::SHOW_BY_DEFAULT
                . ' OFFSET ' . $offset);

            $i = 0;
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $commentsList[$i]['id'] = $row['id'];
                $commentsList[$i]['date'] = $row['date'];
                $commentsList[$i]['description'] = $row['description'];
                $commentsList[$i]['current_user_id'] = $row['current_user_id'];
                $commentsList[$i]['current_category_id'] = $row['current_category_id'];
                $i++;
            }

            return $commentsList;
        }
    }

    //получить количество комментариев одной темы форума
    public static function getCountCommentsForumItem($categoryId)
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT count(id) AS count FROM comments_forum '
            . 'WHERE  forum_id ="' . $categoryId . '"');
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['count'];
    }

    //Добавление комментариев
    public static function CommentsAdd($current_user_id, $date, $description, $forum_id, $current_category_id)
    {
        $current_user_id = intval($current_user_id);
        $forum_id = intval($forum_id);
        $current_category_id = intval($current_category_id);
        $db = Db::getConnection();
        $sql = "INSERT INTO comments_forum (`date`,`description`, `current_user_id`, `forum_id`,`current_category_id`)
                  VALUES (:date,:description,:current_user_id,:forum_id,:current_category_id)";

        $result = $db->prepare($sql);
        $result->bindParam(':date', $date, PDO::PARAM_STR);
        $result->bindParam(':description', $description, PDO::PARAM_STR);
        $result->bindParam(':current_user_id', $current_user_id, PDO::PARAM_INT);
        $result->bindParam(':forum_id', $forum_id, PDO::PARAM_INT);
        $result->bindParam(':current_category_id', $current_category_id, PDO::PARAM_INT);
        $result->execute();


    }

    //получить количество комментариев пользователя по индентификатору
    public static function getCountUserComments($userId)
    {
        $db = Db::getConnection();
        $result = $db->query("SELECT COUNT(`id`) as count FROM `comments_forum` WHERE `current_user_id` =" . $userId);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['count'];
    }

    //Удалить комментарий пользователя из заданным индентификатором
    public static function deleteUserComment($id)
    {
        $id = intval($id);
        $db = Db::getConnection();
        $result = $db->query("DELETE FROM comments_forum WHERE id=" . $id);
        return true;

    }

    //Удаление всех комментариев из темы
    // по заданному id(При удалении темы форума)
    public static function deleteComments($id)
    {
        $id = intval($id);
        $db = Db::getConnection();
        $result = $db->query("DELETE FROM comments_forum WHERE forum_id=" . $id);
        return true;
    }

    //Удаление всех комментариев ( при удалении категории форума)
    //по current_category_id
    public static function deleteCommentsALL($current_category_id)
    {
        $current_category_id = intval($current_category_id);
        $db = Db::getConnection();
        $result = $db->query("DELETE FROM comments_forum 
                              WHERE current_category_id=" . $current_category_id);
        if(!$result){
            return false;
        }
        return true;

    }

    //Получить все данные по последнему комментарию ()
    public static function getCommentEnd($categoryId, $str)
    {
        $categoryId = intval($categoryId);
        $str = strval($str);
        $db = Db::getConnection();
        $result = $db->query("SELECT * FROM comments_forum 
                              WHERE {$str} ={$categoryId}           
                                ORDER BY `id` DESC 
                                LIMIT 1");
        if ($result) {
            return $row = $result->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }


    }

    //Удаление комментариев по current_user_id
    public static function deleteCommentsForumForUserId($userId)
    {
        $userId = intval($userId);
        $db = Db::getConnection();
        $result = $db->query("DELETE FROM comments_forum WHERE current_user_id=" . $userId);
        if ($result) {
            return true;
        } else {
            return false;
        }

    }


}