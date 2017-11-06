<?php

class UserController
{
    //регистрация пользователей
    public function actionRegister($params = false)
    {
        #ПРОВЕРКА на существование
        if($params == true){
            header("Location: /user/register");
            exit();
        }

        $_SESSION['searchPage'] = "news";
        $name = '';
        $email = '';
        $password = '';
        $result = false;
        $errors = false;

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $name = User::cleanStr($name);
            $email = User::cleanStr($email);
            $password = User::cleanStr($password);
            //валидация полученных данных
            if (!User::checkName($name)) {
                $errors[] = "Имя не должно быть короче двух символов";
            }


            if (!User::checkEmail($email)) {
                $errors[] = "Неправильный email";
            }


            if (!User::checkPassword($password)) {
                $errors[] = "Пароль не должен быть короче шести символов";
            }

            if (User::checkEmailExists($email)) {
                $errors[] = "Такой email уже используеться!";
            }

            //если все ок , регистрируем нового пользователя
            if ($errors == false) {
                $result = User::register($name, $email, $password);
            }
        }




        require_once ROOT . '/views/user/register.php';
        return true;
    }

    //Авторизация пользователя
    public function actionLogin($params = false)
    {
        #ПРОВЕРКА на существование
        if($params == true){
            header("Location: /user/login");
            exit();
        }

        $_SESSION['searchPage'] = "news";
        $email = '';
        $password = '';

        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $date = $_POST['date'];
            $errors = false;

            // Проверяем существует ли пользователь
            $userId = User::checkUserData($email, $password);
            if ($userId == false) {

                // Если данные неправильные - показываем ошибку
                $errors[] = 'Неправильные данные для входа на сайт';
            } else {

                //Проверям не заблокирован ли пользователь
                $us = User::getUserById($userId);
                if ($us['role'] == "2") {
                    $errors[] = "Вы были временно заблокированы!";
                }
            }

            if ($errors == false) {
                // Если данные правильные, запоминаем пользователя (сессия)
                User::auth($userId);


                //Статус пользователя(online) = 1

                $userOnline = User::UserOnline($_SESSION['user'], 1);

                // Перенаправляем пользователя в закрытую часть - кабинет
                header("Location: /cabinet/$userId");
            }
        }
        require_once(ROOT . '/views/user/login.php');
        return true;
    }

    // Удаляем данные о пользователе из сессии
    public function actionLogout()
    {
        $usId = $_SESSION['user'];

        //Статус пользователя(online) = 1
        $userOnline = User::UserOnline($usId, 0);

        //Меняем дату во сколько пользователь покинул сайт
        date_default_timezone_set('Europe/Kiev');
        $d = date("Y-m-d H:i:s");
        $date = '\''.$d.'\'';
        if($usId)
        $editDate = User::editDate($usId, $date);

        ob_start();
        session_start();
        unset($_SESSION['user']);
        unset($_SESSION['message']);

        header("Location: /user/login/");
        ob_end_clean();
    }


}
