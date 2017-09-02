<?php


class User
{
    const SHOW_BY_DEFAULT = 10;

    //Регистрация пользователя
    public static function register($name, $email, $password)
    {
        $db = Db::getConnection();

        $sql = "INSERT INTO user (name,email,password)"
            . "VALUES (:name,:email,:password)";

        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);

        return $result->execute();

    }

    //правильность name, не короче 2 символов
    public static function checkName($name)
    {
        if (strlen($name) >= 2) {
            return true;
        }
        return false;

    }

    //правильность password ,не короче 6 символов
    public static function checkPassword($password)
    {
        if (strlen($password) >= 6) {
            return true;
        }
        return false;

    }

    //правильность email
    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;

    }

    //Валидация строки
    public static function cleanStr($value = "")
    {
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);

        return $value;

    }

    //проверяем существует ли уже такой email?
    public static function checkEmailExists($email)
    {
        $db = Db::getConnection();
        $sql = "SELECT COUNT(*) FROM user WHERE email = :email";

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        if ($result->fetchColumn()) {
            return true;
        }
        return false;

    }

    //Проверяем существуют ли почта и пароль пользователя,
    //если да возвращаем его id,если нет - false
    public static function checkUserData($email, $password)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM user WHERE email = :email AND password = :password';

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->execute();

        $user = $result->fetch();
        if ($user) {
            return $user['id'];
        }

        return false;
    }

    //Запоминаем пользователя в сессию
    public static function auth($userId)
    {
        $_SESSION['user'] = $userId;
    }

    //Если сессия существет возвращаем ее, если нет перенаправляем на '/user/login'
    public static function checkLogged()
    {
        // Если сессия есть, вернем идентификатор пользователя
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        header("Location: /user/login");
    }

    //Получаем информацию о пользователе (по id)
    public static function getUserById($id)
    {
        if ($id) {
            $db = Db::getConnection();
            $sql = 'SELECT * FROM user WHERE id = :id';

            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_INT);

            // Указываем, что хотим получить данные в виде массива
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result->execute();

            if ($result) {
                return $result->fetch();
            } else {
                return false;
            }
        }
    }

    //редактирование данных в кабинете
    public static function edit($id, $name, $password)
    {
        $db = Db::getConnection();

        $sql = "UPDATE user 
            SET name = :name, password = :password 
            WHERE id = :id";

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        return $result->execute();
    }

    //Если сессия существует возвращаем - false , если нет - true
    public static function isGuest()
    {
        if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }

    //Получить всех пользователей
    public static function getUsers()
    {
        $db = Db::getConnection();
        $result = $db->query("SELECT id,`name`,`role`,`online` FROM user ");
        $user = array();
        $i = 0;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $user[$i]['id'] = $row['id'];
            $user[$i]['name'] = $row['name'];
            $user[$i]['role'] = $row['role'];
            $user[$i]['online'] = $row['online'];
            $i++;
        }
        return $user;

    }

    //Обновление счетчика комментариев пользователя в новостях
    public static function UserAddCommentNews($id, $userPlus)
    {
        $db = Db::getConnection();
        $result = $db->query("UPDATE user SET comments_news ={$userPlus} WHERE id=" . $id);

    }

    //Обновление счетчика комментариев пользователя в темах форума
    public static function UserAddCommentForum($id, $userPlus)
    {
        $db = Db::getConnection();
        $result = $db->query("UPDATE user SET comments_forum ={$userPlus} WHERE id=" . $id);

    }

    //При авторизации ставим статус пользователя онлайн = 1 или 0
    public static function UserOnline($id, $count)
    {
        $id = intval($id);
        $count = intval($count);
        $db = Db::getConnection();
        $result = $db->query("UPDATE user set `online`= {$count} 
                                      WHERE id = " . $id);


    }

    //Получаем всех пользователей где online = $categoryId
    public static function getUserListByOnline($categoryId, $page = 1)
    {
        $page = intval($page);
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

        $db = Db::getConnection();
        $users = array();
        $result = $db->query("SELECT `id`,`name`, `online` FROM `user` WHERE `online` = {$categoryId} ORDER BY `id` DESC "
            . "LIMIT " . self::SHOW_BY_DEFAULT
            . ' OFFSET ' . $offset);

        $i = 0;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $users[$i]['name'] = $row['name'];
            $users[$i]['online'] = $row['online'];
            $users[$i]['id'] = $row['id'];
            $i++;
        }

        return $users;
    }

    //Счетчик пользователей где online = $categoryId
    public static function getCountOnlineUserAll($categoryId)
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT count(online) AS count FROM user '
            . 'WHERE  online ="' . $categoryId . '"');
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['count'];
    }

    //Меняем дату пользователя на вход и выход из сайта
    public static function editDate($id, $date)
    {
        $id = intval($id);
        $db = Db::getConnection();
        $result = $db->query("UPDATE user SET `date` ={$date} WHERE `id`= " . $id);
    }

    //Получить всех пользователей по полю role, по 10 на страницу
    public static function getUsersRole($categoryId, $page = 1)
    {
        $page = intval($page);
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

        $db = Db::getConnection();
        $users = array();
        $result = $db->query("SELECT `id`,`name`, `online`,`role` FROM `user` WHERE `role` = {$categoryId} ORDER BY `id` DESC "
            . "LIMIT " . self::SHOW_BY_DEFAULT
            . ' OFFSET ' . $offset);

        $i = 0;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $users[$i]['id'] = $row['id'];
            $users[$i]['name'] = $row['name'];
            $users[$i]['online'] = $row['online'];
            $users[$i]['role'] = $row['role'];
            $i++;
        }

        return $users;
    }

    //Счетчик пользователей по значению поля role
    public static function getCountRoleUserAll($categoryId)
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT count(id) AS count FROM user '
            . 'WHERE  role ="' . $categoryId . '"');
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['count'];
    }

    //Обновление поля role
    public static function editUsersRole($userId, $role)
    {
        $userId = intval($userId);
        $role = intval($role);
        $db = Db::getConnection();
        $result = $db->query("UPDATE user SET `role`={$role} WHERE `id` =" . $userId);
        return true;
    }

    //Получить абсолютно всех пользоватей + пагинация
    public static function getUsersALL($page = 1)
    {
        $page = intval($page);
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

        $db = Db::getConnection();
        $users = array();
        $result = $db->query("SELECT `id`,`name` FROM `user` WHERE `role` !=1 ORDER BY `id` ASC "
            . "LIMIT " . self::SHOW_BY_DEFAULT
            . ' OFFSET ' . $offset);

        $i = 0;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $users[$i]['id'] = $row['id'];
            $users[$i]['name'] = $row['name'];
            $i++;
        }

        return $users;

    }

    //Счетчик пользователей для страницы Удаления пользователй
    public static function getCountUserId()
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT count(id) AS count FROM user ');
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['count'];
    }

    //Удаление пользователей
    public static function deleteUserForId($userId)
    {
        $userId = intval($userId);
        $db = Db::getConnection();
        $result = $db->query("DELETE FROM user WHERE id=" . $userId);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    //Идентификация пользователей по сайту
    public static function identificationUsers()
    {
        if (isset($_SESSION['user'])) {
            // Получаем идентификатор пользователя из сессии
            $userId = $_SESSION['user'];

            // Получаем информацию о пользователе из БД
            $user = User::getUserById($userId);

            if ($user == false) {
                return false;
            } elseif ($user['role'] == 2) {
                return false;
            } else
                return true;

        } else
            return false;

    }
}
