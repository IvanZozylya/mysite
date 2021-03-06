<?php

class Message
{
    const SHOW_BY_DEFAULT = 10;

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
        $result = $db->query("SELECT * FROM message WHERE `userTo` = $userId AND `new_message` = 1 ORDER BY `date` DESC");
        $i = 0;
        $newMessage = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $newMessage[$i] = $row;
            $i++;
        }
        return $newMessage;

    }

    //Отправление сообщение
    public static function goMessage($userFrom, $userTo, $text, $date)
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
    public static function getMessageOld($userId, $userFrom)
    {
        $userId = intval($userId);
        $userFrom = intval($userFrom);

        $db = Db::getConnection();

        $result = $db->query("UPDATE message SET `new_message` = 0 WHERE `userTo` = $userId AND `userFrom` = $userFrom");
    }

    //Получить чат Входящие сообщения
    public static function getIncomingMessage($userId, $userFrom)
    {
        $userId = intval($userId);

        $db = Db::getConnection();

        $result = $db->query("SELECT * FROM `message` WHERE `userTo` = $userId AND `userFrom` = '$userFrom' ORDER BY `date` DESC LIMIT 1");
        return $row = $result->fetch(PDO::FETCH_ASSOC);
    }

    //Получить все значения userFrom где userTo = $userId
    public static function getUserFromById($userId)
    {
        $userId = intval($userId);

        $db = Db::getConnection();
        $result = $db->query("SELECT `userFrom` FROM `message` WHERE `userTo` = $userId ORDER BY `date` DESC");
        $i = 0;
        $userFrom = array();
        while ($row = $result->fetch(PDO::FETCH_NUM)) {
            $userFrom[$i] = $row;

            $i++;
        }
        return $userFrom;
    }

    //Получение чата с конкретным пользователём
    public static function getUsersChat($userTo, $userFrom)
    {
        $userFrom = intval($userFrom);
        $userTo = intval($userTo);

        $db = Db::getConnection();

        $result = $db->query("(SELECT * FROM `message` WHERE `userTo`=$userTo AND `userFrom` = '$userFrom' ORDER BY id DESC LIMIT 3) " .
            " UNION " . " (SELECT * FROM `message` WHERE `userTo`= '$userFrom' AND `userFrom` = $userTo ORDER BY id DESC LIMIT 3)");
        $i = 0;
        $message = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $message[$i] = $row;
            $i++;
        }
        return $message;
    }

    //Получить список всех входящий сообщений для одного пользователя
    public static function getIncomingMessageUser($userId,$page = 1)
    {
        $userId = intval($userId);

        $page = intval($page);
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

        $db = Db::getConnection();

        $result = $db->query("SELECT * FROM message WHERE `userTo` = $userId "
            . "ORDER BY date DESC "
            . "LIMIT " . self::SHOW_BY_DEFAULT
            . ' OFFSET ' . $offset);
        if (!$result) {
            header("Location: /message/history/");
        }
        $messageList = array();
        $i = 0;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $messageList[$i] = $row;
            $i++;
        }
        return $messageList;
    }

    //Получить список всех отправленных сообщений одного пользователя
    public static function getSendMessageUser($userId,$page = 1)
    {
        $userId = intval($userId);

        $page = intval($page);
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

        $db = Db::getConnection();

        $result = $db->query("SELECT * FROM message WHERE `userFrom` = $userId "
            . "ORDER BY date DESC "
            . "LIMIT " . self::SHOW_BY_DEFAULT
            . ' OFFSET ' . $offset);
        if (!$result) {
            header("Location: /message/history/");
        }
        $messageList = array();
        $i = 0;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $messageList[$i] = $row;
            $i++;
        }
        return $messageList;
    }


}