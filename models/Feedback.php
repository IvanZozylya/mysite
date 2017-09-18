<?php


class Feedback
{
    const SHOW_BY_DEFAULT = 10;
    //Отправление данных в таблицу feedback
    public static function goFeedbackItem($email,$message)
    {
        $db = Db::getConnection();

        $sql = "INSERT INTO feedback (email,message)"
            . "VALUES (:email,:message)";

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':message', $message, PDO::PARAM_STR);


        return $result->execute();
    }

    //Получить все записи с пагинацей
    public static function getFeedbackList($page = 1)
    {
        $page = intval($page);
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

        $db = Db::getConnection();
        $result = $db->query("SELECT * FROM feedback "
            . "ORDER BY date DESC "
            . "LIMIT " . self::SHOW_BY_DEFAULT
            . ' OFFSET ' . $offset);
        $message = array();
        $i = 0;
        if (!$result) {
            header("Location: /otherUsers/");
            exit();
        }
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $message[$i] = $row;
            $i++;
        }
        return $message;


    }

    //Счетчик сообщений
    public static function getCountFeedback()
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT count(id) AS count FROM feedback ');
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['count'];
    }

    //Удаление записей из Feedback
    public static function deleteFeedbackItem($id)
    {
        $id = intval($id);
        $db = Db::getConnection();
        $result = $db->query("DELETE FROM feedback WHERE id=".$id);
        if(!$result){
            header("Location: /users/feedback/");
            return false;
        }
        return true;

    }

}