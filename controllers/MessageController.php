<?php

class MessageController
{
    //Отобразить сообщение
    public function actionOneMessage($messageId, $params = false)
    {
        //Проверка уровня допуска
        $identefication = User::identificationUsers();
        if ($identefication == false) {
            header("Location: /user/login/");
            exit();
        }

        //Валидация строки
        if ($params == true) {
            header("Location: /message/view/$messageId/");
            exit();
        }

        $errors = false;
        $result = false;

        //Установка даты
        date_default_timezone_set('Europe/Kiev');
        $date = date("Y-m-d H:i:s");

        $_SESSION['searchPage'] = 'user';

        $userId = $_SESSION['user'];

        //Получить всю переписку
        $messageIte = Message::getUsersChat($userId, $messageId);
        usort($messageIte, function ($a, $b) {
            return ($a['id'] - $b['id']);
        });

        //Получаем всех пользователей
        $users = User::UsersAll();

        //Убираем статус новое сообщение
        $oldMessage = Message::getMessageOld($userId, $messageId);

        //Если нажал кнопку Ответить
        //Валидация
        if (isset($_POST['submit'])) {
            $text = User::cleanStr($_POST['text']);
            $userFrom = $_POST['userFrom'];
            $userTo = $_POST['userTo'];
            $data = $_POST['date'];

            if (empty($text)) {
                $errors[] = "Введите сообщение";
            }

            //Если все ок, отправляем сообщение
            if ($errors == false) {
                $goMessage = Message::goMessage($userFrom, $userTo, $text, $data);
                $result = true;
                header("Refresh:1 url=/message/view/$messageId/");


            }
        }

        //Получаем количество отправленных сообщений
        $countFrom = Message::getCountFromUserMessage($userId);

        //Получаем количество новых сообщений
        $countNew = Message::getCountUserNewMessage($userId);


        require_once ROOT . '/views/message/viewMessage.php';
        return true;
    }

    //Страница входящие сообщения
    public function actionIncomingMessage($params = false)
    {
        //Проверка уровня допуска
        $identefication = User::identificationUsers();
        if ($identefication == false) {
            header("Location: /user/login/");
            exit();
        }

        //Валидация входящей строки
        if ($params == true) {
            header("Location: /message/incoming/");
            exit();
        }


        $_SESSION['searchPage'] = 'user';

        $userId = $_SESSION['user'];

        //Получить все значения userFrom где userTo = $userId
        $usFrom = array();
        $userFrom = Message::getUserFromById($userId);
        foreach ($userFrom as $usX) {
            $usFrom[] = $usX[0];
        }
        //Удаляем повторяющиеся значения
        $correction = array_unique(array_reverse($usFrom));

        //Получить список Входящие сообщения
        $newMessag = array();
        for ($i = 0; $i <= count($correction); $i++) {
            if (!isset($correction[$i])) {
                continue;
            }
            $newMessag[] = Message::getIncomingMessage($userId, $correction[$i]);
        }
        $newMessage = array_reverse($newMessag);

        //Получаем список всех пользователей
        $users = User::UsersAll();

        //Получаем количество входящий сообщений
        $countMessage = Message::getCountUserToMessage($userId);

        //Получаем количество отправленных сообщений
        $countFrom = Message::getCountFromUserMessage($userId);

        //Получаем количество новых сообщений
        $countNew = Message::getCountUserNewMessage($userId);


        require_once ROOT . '/views/message/incomingMessage.php';
        return true;
    }

    //Страница истории сообщений
    public function actionMessageHistory($page = 1)
    {
        //Проверка уровня допуска
        $identefication = User::identificationUsers();
        if ($identefication == false) {
            header("Location: /user/login/");
            exit();
        }
        $_SESSION['searchPage'] = 'user';

        $userId = $_SESSION['user'];
        if(!isset($_SESSION['message'])){
            $_SESSION['message'] = 'incoming';
        }

        //Получаем список всех пользователей
        $users = User::UsersAll();

        //Получение всех входящий сообщений для конкретного пользователя
        $message = array();

        //Валидация
        if (isset($_POST['submit'])) {
            if ($_POST['message'] == 1) {
                $_SESSION['message'] = 'incoming';
                header("Location: /message/history/");

            } elseif ($_POST['message'] == 2) {
                $_SESSION['message'] = 'send';
                header("Location: /message/history/");
            }
        }

        //Проверяем что нажал пользователь
        if ($_SESSION['message'] == 'incoming') {

            //Получение всех входящий сообщений для конкретного пользователя
            $message = Message::getIncomingMessageUser($userId, $page);

            //Получить количество входящих сообщений
            $total = Message::getCountUserToMessage($userId);

            //Создаем обьект пагинатора
            $pagination = new Pagination($total, $page, Message::SHOW_BY_DEFAULT, 'page-');

        } elseif ($_SESSION['message'] == 'send') {

            //Получение всех отправленых сообщений конкретного пользователя
            $message = Message::getSendMessageUser($userId, $page);

            //Получить количество отправленных сообщений
            $total = Message::getCountFromUserMessage($userId);

            //Создаем обьект пагинатора
            $pagination = new Pagination($total, $page, Message::SHOW_BY_DEFAULT, 'page-');

        }

        //Получаем количество новых сообщений
        $countNew = Message::getCountUserNewMessage($userId);

        require_once ROOT . '/views/message/historyMessage.php';
        return true;

    }

}