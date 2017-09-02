<?php


class CommentsNews
{
    const SHOW_BY_DEFAULT = 5;
    //Получить все комментарии нужной новости
    public static function getCommentsNewsList($categoryId = false, $page = 1)
    {
        if ($categoryId) {

            $page = intval($page);
            $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

            $db = Db::getConnection();
            $news = array();
            $result = $db->query("SELECT * FROM comments_news "
                . "WHERE `news_id` = '$categoryId' "
                . "ORDER BY date DESC "
                . "LIMIT " . self::SHOW_BY_DEFAULT
                . ' OFFSET ' . $offset);

            $i = 0;
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $news[$i]['id'] = $row['id'];
                $news[$i]['date'] = $row['date'];
                $news[$i]['description'] = $row['description'];
                $news[$i]['current_user_id'] = $row['current_user_id'];
                $news[$i]['news_id'] = $row['news_id'];
                $i++;
            }

            return $news;
        }
    }

    //получить количество комментариев одной новости
    public static function getCountCommentsNewsItem($categoryId)
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT count(id) AS count FROM comments_news '
            . 'WHERE  news_id ="'.$categoryId.'"');
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['count'];
    }

    //Добавление комментариев
    public static function CommentsAdd($current_user_id, $date, $description, $news_id)
    {
        $current_user_id = intval($current_user_id);
        $news_id = intval($news_id);
        $db = Db::getConnection();
        $sql = "INSERT INTO comments_news (`date`,`description`, `current_user_id`, `news_id`)
                  VALUES (:date,:description,:current_user_id,:news_id)";

        $result = $db->prepare($sql);
        $result->bindParam(':date', $date, PDO::PARAM_STR);
        $result->bindParam(':description', $description, PDO::PARAM_STR);
        $result->bindParam(':current_user_id', $current_user_id, PDO::PARAM_INT);
        $result->bindParam(':news_id', $news_id, PDO::PARAM_INT);
        $result->execute();


    }

    //получить количество комментариев пользователя по индентификатору
    public static function getCountUserComments($userId)
    {
        $db = Db::getConnection();
        $result = $db->query("SELECT COUNT(`id`) as count FROM `comments_news` WHERE `current_user_id` =".$userId);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['count'];
    }

    //Удаление одного комментария в новостях
    public static function deleteNewsComment($id)
    {
        $id = intval($id);
        $db = Db::getConnection();
        $result = $db->query("DELETE FROM comments_news WHERE id = ".$id);
        return true;
    }

    //Удаление всех комментариев в определенной новости
    public static function deleteComments($id)
    {
        $id = intval($id);
        $db = Db::getConnection();
        $result = $db->query("DELETE FROM comments_news WHERE news_id=".$id);
        return true;

    }

    //Удаление комментариев по current_user_id
    public static function deleteCommentsNewsForUserId($userId)
    {
        $userId = intval($userId);
        $db = Db::getConnection();
        $result = $db->query("DELETE FROM comments_news WHERE current_user_id=" . $userId);
        if ($result) {
            return true;
        } else {
            return false;
        }

    }
}