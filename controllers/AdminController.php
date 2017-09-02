<?php

class AdminController
{
    //страница Admin Panel
    public function actionIndex($params = false)
    {
        #ПРОВЕРКА на существование
        if($params == true){
            header("Location: /admin/");
            exit();
        }

        $_SESSION['searchPage'] = "user";
        // Получаем идентификатор пользователя из сессии
        $userId = User::checkLogged();

        // Получаем информацию о пользователе из БД
        $user = User::getUserById($userId);

        //Проверка уровня допуска
        if ($user['role'] != 1) {
            header("Location: /cabinet/$userId");
        }
        $countAddCategory = addCategory::getCountAddCategory();

        require_once ROOT . '/views/admin/index.php';

        return true;
    }

    //Добавление новости
    public function actionAddNews($params = false)
    {
        #ПРОВЕРКА на существование
        if($params == true){
            header("Location: /addNews/");
            exit();
        }

        $_SESSION['searchPage'] = "news";
        // Получаем идентификатор пользователя из сессии
        $userId = User::checkLogged();

        // Получаем информацию о пользователе из БД
        $user = User::getUserById($userId);

        //Проверка уровня допуска
        if ($user['role'] != 1) {
            header("Location: /cabinet/$userId");
            exit();
        }

        $date = date("Y-m-d H:i:s");
        $errors = false;
        $result = false;

        //Валидация полученных данных с POST
        if (isset($_POST['submit'])) {
            $title = $_POST['title'];
            $data = $_POST['date'];
            $content = $_POST['content'];
            $uploaddir = ROOT . '/template/images/news/';
            $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
            $image = "/template/images/news/" . $_FILES['userfile']['name'];

            //Валидация поля title
            if (isset($_POST['title'])) {
                if (mb_strlen($_POST['title']) <= 5) {
                    $errors[] = "Заголовок должен быть больше 5 символов";
                } elseif (mb_strlen($_POST['title']) > 255)
                    $errors[] = "Слишком большой заголовок";
            }

            //Валидация поля content
            if (isset($_POST['content'])) {
                if (strlen($_POST['content']) <= 10) {
                    $errors[] = "Контент должнен содержать больше 10 символов";
                }
            }

            //Валидация файла
            if (empty($_FILES['userfile']['name'])) {
                $errors[] = "Добавте картинку";
            }
            //Валидация на размер файла
            if ($_FILES['userfile']['size'] > 200000) {
                $errors[] = "Слишком большой размер файла";
            }

            //Все все ок делаем запрос к бд и добавляем картинку в файл
            if ($errors == false) {
                $result = News::addNews($title, $data, $content, $image);
                if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {

                    //Получить image и id последней новости
                    $newsLast = News::getNewsItemLast();

                    //Обработка названия image
                    $img = basename($newsLast['image']);
                    $imgArr = explode(".",$img);
                    $imageArr = array_pop($imgArr);
                    $image = strval($imageArr);


                    //Изменить название image
                    $oldname = ROOT . $newsLast['image'];
                    $newname = ROOT . '/template/images/news/' . $newsLast['id'] . '.'.$image;

                    if (rename($oldname, $newname)) {

                        //изменить название image в базе
                        $newPath = '\'/template/images/news/' . $newsLast['id'] . '.' . $image . '\'';
                        $newPathImage = News::editPathImage($newsLast['id'], $newPath);
                        $result = true;
                    }
                }
            }
        }


        require_once ROOT . '/views/admin/addNews.php';
        return true;
    }

    //Добавление категории('/forum')
    public function actionAddCategory($params = false)
    {
        #ПРОВЕРКА на существование
        if($params == true){
            header("Location: /addCategory/");
            exit();
        }

        $_SESSION['searchPage'] = "category";
        // Получаем идентификатор пользователя из сессии
        $userId = User::checkLogged();


        // Получаем информацию о пользователе из БД
        $user = User::getUserById($userId);

        //Проверка уровня допуска
        if ($user['role'] != 1) {
            header("Location: /cabinet/$userId");
            exit();
        }

        $date = date("Y-m-d H:i:s");
        $errors = false;
        $result = false;

        //Валидация полученных данных с POST
        if (isset($_POST['submit'])) {
            $title = $_POST['title'];
            $data = $_POST['date'];
            $short_content = $_POST['short_content'];

            $short_content = User::cleanStr($short_content);
            $title = User::cleanStr($title);

            $uploaddir = ROOT . '/template/images/category/';
            $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
            $image = "/template/images/category/" . $_FILES['userfile']['name'];

            //Валидация поля title
            if (isset($_POST['title'])) {
                if (mb_strlen($_POST['title']) <= 5) {
                    $errors[] = "Заголовок должен быть больше 5 символов";
                } elseif (mb_strlen($_POST['title']) > 255)
                    $errors[] = "Слишком большой заголовок";
            }

            //Валидация поля short_content
            if (isset($short_content)) {
                if (mb_strlen($short_content) > 255) {
                    $errors[] = "Слишком большое содержимое";
                }
            }

            //Валидация файла
            if (empty($_FILES['userfile']['name'])) {
                $errors[] = "Добавте картинку";
            }

            //Валидация на размер файла
            if ($_FILES['userfile']['size'] > 120000) {
                $errors[] = "Слишком большой размер файла";
            }

            //Все все ок делаем запрос к бд и добавляем картинку в файл
            if ($errors == false) {
                $addCategory = Category::addCategory($title, $data, $short_content, $image);
                if ($addCategory == false) {
                    return false;
                } else {
                    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {

                        //Получить image и id последней категории(таблица Category)
                        $categoryItemLast = Category::getCategoryItemLast();

                        //Изменить название image
                        $oldname = ROOT . $categoryItemLast['image'];
                        $newname = ROOT . '/template/images/category/' . $categoryItemLast['id'] . '.png';

                        if (rename($oldname, $newname)) {

                            $newPath = '\'/template/images/category/' . $categoryItemLast['id'] . '.png\'';
                            $newPathImage = Category::editPathImage($categoryItemLast['id'], $newPath);
                            $result = true;
                        }
                    }
                }
            }
        }


        require_once ROOT . '/views/admin/addCategory.php';
        return true;
    }

    //Страница ожидающая добавления категорий
    public function actionCategoryWait($params = false)
    {
        #ПРОВЕРКА на существование
        if($params == true){
            header("Location: /addCategoryWait/");
            exit();
        }

        $_SESSION['searchPage'] = "category";

        $result = false;
        $errors = false;
        // Получаем идентификатор пользователя из сессии
        $userId = User::checkLogged();

        // Получаем информацию о пользователе из БД
        $user = User::getUserById($userId);

        //Проверка уровня допуска
        if ($user['role'] != 1) {
            header("Location: /cabinet/$userId");
        }

        //Получить все категории
        $categoryList = array();
        $categoryList = addCategory::getCategoryList();


        //Валидация
        if (isset($_POST['addCategory'])) {
            $categoryId = $_POST['categoryId'];
            $title = $_POST['title'];
            $date = $_POST['date'];
            $short_content = $_POST['short_content'];

            #Обработка image
            $image = $_POST['image'];

            #Путь к картинке
            $from = ROOT . $image;
            $img = '/template/images/category/' . basename($image);

            #Новый путь
            $filename = ROOT . '/template/images/category/' . basename($image);


            # Если файл не существует
            if (!file_exists($from))
                $errors[] = 'Файл нет существует: ' . $from;

            # Копируем файл
            if (copy($from, $filename)) {

                # Удаляем файл
                unlink($from);

                #Добавляем категорию
                $addresult = Category::addCategory($title, $date, $short_content, $img);

                if ($addresult) {
                    #Удаляем эту категорию из addcategory
                    $result = addCategory::deleteCategory($categoryId);
                } else {
                    $errors[] = "Не удалось добавить файл";
                }

                //Получить image и id последней категории(таблица Category)
                $categoryItemLast = Category::getCategoryItemLast();

                //Изменить название image
                $oldname = ROOT . $categoryItemLast['image'];
                $newname = ROOT . '/template/images/category/' . $categoryItemLast['id'] . '.png';

                if (!rename($oldname, $newname)) {
                    $errors[] = "Файл не был переименнован";
                    return false;
                } else {

                    $newPath = '\'/template/images/category/' . $categoryItemLast['id'] . '.png\'';
                    $newPathImage = Category::editPathImage($categoryItemLast['id'], $newPath);

                    $result = true;
                    header("Location: /admin");

                    # Возвращаем true
                    return true;
                }
            } else {
                $errors[] = "Ошибка при копировании файла";
            }


        }

        //Валидация
        if (isset($_POST['deleteCategory'])) {

            $idCategory = $_POST['categoryId'];

            #Удаляем эту категорию из addcategory
            $deleteCategory = addCategory::deleteCategory($idCategory);

            if ($deleteCategory == true) {
                #Обработка image
                $imgDelete = $_POST['image'];

                #Путь к картинке
                $from = ROOT . $imgDelete;

                # Удаляем файл
                if (!unlink($from)) {
                    $errors[] = "Файл не удален";
                };

                //Переадресация на админ
                $result = true;
                header("Location: /admin");

            } else {
                $errors[] = "Не удалось удалить файл";
            }

        }

        require_once ROOT . '/views/admin/addCategoryWait.php';
        return true;
    }

//Общая панель для выбора операций над пользователями
    public function actionAllFunction($params = false)
    {
        #ПРОВЕРКА на существование
        if($params == true){
            header("Location: /users/allFunctions/");
            exit();
        }

        $_SESSION['searchPage'] = "user";
        // Получаем идентификатор пользователя из сессии
        $userId = User::checkLogged();

        // Получаем информацию о пользователе из БД
        $user = User::getUserById($userId);

        //Проверка уровня допуска
        if ($user['role'] != 1) {
            header("Location: /cabinet/$userId");
        }

        require_once ROOT . '/views/admin/users/index.php';
        return true;
    }

//Онлайн пользователи
    public function actionOnline($categoryId, $page = 1,$params = false)
    {
        #ПРОВЕРКА на существование
        if($params == true){
            header("Location: /user/online/1/");
            exit();
        }

        $_SESSION['searchPage'] = "user";
        // Получаем идентификатор пользователя из сессии
        $userId = User::checkLogged();
        // Получаем информацию о пользователе из БД
        $user = User::getUserById($userId);
        //Проверка уровня допуска
        if ($user['role'] != 1) {
            header("Location: /cabinet/$userId");
            exit();
        }
        //Получить всех пользователей где online = $categoryId
        $userOnline = User::getUserListByOnline($categoryId, $page);

        //Счетчик пользователей где online = $caregoryId
        $total = User::getCountOnlineUserAll($categoryId);

        //Пагинатор
        $pagination = new Pagination($total, $page, User::SHOW_BY_DEFAULT, 'page-');

        require_once ROOT . '/views/admin/users/online.php';
        return true;
    }

//Блокировка пользователей
    public function actionBlockUsers($role, $page = 1,$params = false)
    {
        #ПРОВЕРКА на существование
        if($params == true){
            header("Location: /user/block/0/");
            exit();
        }

        $_SESSION['searchPage'] = "user";
        // Получаем идентификатор пользователя из сессии
        $userId = User::checkLogged();
        // Получаем информацию о пользователе из БД
        $user = User::getUserById($userId);
        //Проверка уровня допуска
        if ($user['role'] != 1) {
            header("Location: /cabinet/$userId");
            exit();
        }

        //Получить всех пользователей
        $users = User::getUsersRole($role, $page);

        //Счетчик пользователей по значению role
        $total = User::getCountRoleUserAll($role);

        //Пагинатор
        $pagination = new Pagination($total, $page, User::SHOW_BY_DEFAULT, 'page-');

        //Заблокировать пользователя
        if (isset($_POST['Blocked'])) {
            $idUserBlock = $_POST['UserId'];
            $blockUser = User::editUsersRole($idUserBlock, 2);
            if ($blockUser == true) {
                header("Location: /user/block/0");
            }
        }

        //Разблокироть пользователя
        if (isset($_POST['Active'])) {
            $idUserActive = $_POST['UserId'];
            $ActiveUser = User::editUsersRole($idUserActive, 0);
            if ($ActiveUser == true) {
                header("Location: /user/block/2");
            }
        }

        require_once ROOT . '/views/admin/users/blockUsers.php';
        return true;
    }

//Удаление пользователя
    public function actionDeleteUser($page = 1,$params = false)
    {
        #ПРОВЕРКА на существование
        if($params == true){
            header("Location: /user/delete/");
            exit();
        }

        $_SESSION['searchPage'] = "user";
        // Получаем идентификатор пользователя из сессии
        $userId = User::checkLogged();
        // Получаем информацию о пользователе из БД
        $user = User::getUserById($userId);
        //Проверка уровня допуска
        if ($user['role'] != 1) {
            header("Location: /cabinet/$userId");
            exit();
        }

        //Вывести всех пользователей
        $usersList = User::getUsersALL($page);

        //Счетчик пользователей
        $total = User::getCountUserId();

        //Пагинатор
        $pagination = new Pagination($total, $page, User::SHOW_BY_DEFAULT, 'page-');

        //Валидация формы

        if (isset($_POST['Delete']) || isset($_POST['submit'])) {
            $idUser = $_POST['UserId'];

            //Удаление пользователя
            $deleteUser = User::deleteUserForId($idUser);
            $deleteCommentsForum = CommentsForum::deleteCommentsForumForUserId($idUser);
            $deleteCommentsNews = CommentsNews::deleteCommentsNewsForUserId($idUser);

            //Переадресация на страницу удаления
            if ($deleteUser == true && $deleteCommentsForum == true && $deleteCommentsNews == true) {
                header("Location: /user/delete");
            }
        }


        require_once ROOT . '/views/admin/users/deleteUser.php';
        return true;
    }


}