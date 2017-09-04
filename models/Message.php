<?php

class Message
{
    //Счетчик отправленных сообщений по userFrom
    public static function getCountFromUserMessage($userId)
    {
        $userId = intval($userId);

        $db = Db::getConnection();

        $result = $db->query('SELECT count(id) AS count FROM message WHERE `userFrom` =' . $userId);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['count'];

    }

    //Счетчик полученних сообщений по userTo
    public static function getCountUserToMessage($userId)
    {
        $userId = intval($userId);

        $db = Db::getConnection();

        $result = $db->query('SELECT count(id) AS count FROM message WHERE `userTo` =' . $userId);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['count'];

    }

    //Счетчик новых полученних сообщений по userTo и new_message
    public static function getCountUserNewMessage($userId)
    {
        $userId = intval($userId);

        $db = Db::getConnection();

        $result = $db->query('SELECT count(id) AS count FROM message WHERE `userTo` = ' . $userId . ' AND new_message = 1');
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['count'];

    }

    //Получить список новых сообщений по userTo
    public static function getMessageNew($userId)
    {
        $userId = intval($userId);

        $db = Db::getConnection();
        $result = $db->query("SELECT * FROM message WHERE `userTo` = $userId AND `new_message` = 1");
        $i = 0;
        $newMessage = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $newMessage[$i] = $row;
            $i++;
        }
        return $newMessage;

    }

    //Получить одно сообщение по id и  userTo
    public static function getOneMessageItem($messageId, $userId)
    {
        $messageId = intval($messageId);
        $userId = intval($userId);

        $db = Db::getConnection();

        $result = $db->query("SELECT * FROM message WHERE `id` = $messageId AND `userTo` = $userId");
        return $row = $result->fetch(PDO::FETCH_ASSOC);
    }

    //Отправление сообщение
    public static function goMessage($userFrom,$userTo,$text,$date)
    {
        $db = Db::getConnection();

        $sql = "INSERT INTO message (userFrom,userTo,text,date)"
            . "VALUES (:userFrom,:userTo,:text,:date)";

        $result = $db->prepare($sql);
        $result->bindParam(':userFrom', $userFrom, PDO::PARAM_INT);
        $result->bindParam(':userTo', $userTo, PDO::PARAM_INT);
        $result->bindParam(':text', $text, PDO::PARAM_STR);
        $result->bindParam(':date', $date, PDO::PARAM_STR);

        return $result->execute();
    }

    //Ставим статус прочитанно
    public static function getMessageOld($id)
    {
        $id = intval($id);

        $db = Db::getConnection();

        $result = $db->query("UPDATE message SET `new_message` = 0 WHERE `id` = $id");
    }

}