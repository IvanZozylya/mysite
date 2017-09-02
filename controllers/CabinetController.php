<?php


class CabinetController
{
    //Страница кабинета
    public function actionIndex($id,$params = false)
    {
        $us = $_SESSION['user'];
        #ПРОВЕРКА НА СУЩЕСТВОВАНИЕ
        $IdUser = User::getUserById($id);
        if ($IdUser == false) {
            header("Location: /cabinet/$us");
            exit();
        }
        if($params == true){
            header("Location: /cabinet/$us");
            exit();
        }

        $_SESSION['searchPage'] = "user";
        // Получаем идентификатор пользователя из сессии
        $userId = User::checkLogged();


        // Получаем информацию о пользователе из БД
        $user = User::getUserById($id);

        $identification = User::identificationUsers();
        if ($identification == false) {
            header("Location: /user/logout");
        }

        if (isset($_POST['delete'])) {
            $idUser = $_POST['idUser'];

            //Удаление пользователя
            $deleteUser = User::deleteUserForId($idUser);
            $deleteCommentsForum = CommentsForum::deleteCommentsForumForUserId($idUser);
            $deleteCommentsNews = CommentsNews::deleteCommentsNewsForUserId($idUser);

            header("Location: /user/delete");
        }

        //Заблокировать пользователя
        if (isset($_POST['blocked'])) {
            $idUserBlock = $_POST['idUser'];
            $blockUser = User::editUsersRole($idUserBlock, 2);
            if ($blockUser == true) {
                header("Location: /user/block/2");
            }
        }

        //Разблокироть пользователя
        if (isset($_POST['active'])) {
            $idUserActive = $_POST['idUser'];
            $ActiveUser = User::editUsersRole($idUserActive, 0);
            if ($ActiveUser == true) {
                header("Location: /user/block/0");
            }
        }

        require_once(ROOT . '/views/cabinet/index.php');

        return true;
    }

    //Страница редактирования данных
    public function actionEdit()
    {
        $_SESSION['searchPage'] = "user";
        // Получаем идентификатор пользователя из сессии
        $userId = User::checkLogged();

        // Получаем информацию о пользователе из БД
        $user = User::getUserById($userId);

        $name = $user['name'];
        $password = $user['password'];

        $result = false;

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $password = $_POST['password'];

            $errors = false;

            if (!User::checkName($name)) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }

            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }

            if ($errors == false) {
                $result = User::edit($userId, $name, $password);
                header("Refresh:1 url=/cabinet/$userId");
            }

        }

        require_once(ROOT . '/views/cabinet/edit.php');

        return true;
    }

}