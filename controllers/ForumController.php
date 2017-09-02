<?php


class ForumController
{
    //Основная страница форума
    public function actionIndex($page = 1)
    {
        $_SESSION['searchPage'] = "category";
        //Получаем список категорий
        $categoryList = array();
        $categoryList = Category::getCategoryList($page);

        //получаем количество категорий в переменную $total
        $total = Category::getCountCategoryId();

        //Создаем обьект пагинатора
        $pagination = new Pagination($total, $page, Forum::SHOW_BY_DEFAULT, 'page-');

        //Получаем индентификатор пользователя
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user'];
            //Получить всю информацию о пользователе
            $user = User::getUserById($userId);
        }

        //Получить всех пользователей
        $users = User::getUsers();
        $identification = User::identificationUsers();
        require_once ROOT . '/views/forum/index.php';
        return true;
    }

    //Редактирование основной страницы форума
    public function actionEditIndex($id)
    {
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

        $errors = false;
        $result = false;

        //Получаем нужную категорию по идентификатору
        $categoryItem = array();
        $categoryItem = Category::getCategoryItem($id);

        //Валидация полученных данных с POST
        if (isset($_POST['submit'])) {
            $title = $_POST['title'];
            $data = $categoryItem['date'];
            $short_content = $_POST['short_content'];

            //Путь старой картинки
            $image = $categoryItem['image'];

            //Проверяем была ли добавлена новая картинка,
            //если да то обновляем данные
            if (!empty($_FILES['userfile']['name'])) {
                $uploaddir = ROOT . '/template/images/category/';
                $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
                $image = "/template/images/category/" . $_FILES['userfile']['name'];
            }

            //Валидация поля title
            if (isset($_POST['title'])) {
                if (mb_strlen($_POST['title']) <= 5) {
                    $errors[] = "Заголовок должен быть больше 5 символов";
                } elseif (mb_strlen($_POST['title']) > 255)
                    $errors[] = "Слишком большой заголовок";
            }

            //Валидация на размер файла
            if ($_FILES['userfile']['size'] > 120000) {
                $errors[] = "Слишком большой размер файла";
            }

            //Если все ок делаем запрос к бд и добавляем картинку в файл
            if ($errors == false) {
                $result = Category::editCategoryItem($title, $data, $short_content, $image, $id);

                if (!empty($_FILES['userfile']['name'])) {
                    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {

                    }
                }
                $result = true;
            }
        }


        require_once ROOT . '/views/forum/editIndex.php';
        return true;
    }

    //Добавление основой страницы форума
    public function actionAddCategoryIndex()
    {
        $_SESSION['searchPage'] = "category";
        // Получаем идентификатор пользователя из сессии
        $userId = User::checkLogged();


        // Получаем информацию о пользователе из БД
        $user = User::getUserById($userId);


        $date = date("Y-m-d H:i:s");
        $errors = false;
        $result = false;

        //Валидация полученных данных с POST
        if (isset($_POST['submit'])) {
            $title = $_POST['title'];
            $data = $_POST['date'];
            $short_content = $_POST['short_content'];

            $title = User::cleanStr($title);
            $short_content = User::cleanStr($short_content);

            $uploaddir = ROOT . '/template/images/addcategory/';
            $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
            $image = "/template/images/addcategory/" . $_FILES['userfile']['name'];

            //Валидация поля title
            if (isset($title)) {
                if (mb_strlen($title) <= 5) {
                    $errors[] = "Заголовок должен быть больше 5 символов";
                } elseif (mb_strlen($title) > 255)
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

            //Проверка статуса пользователя
            $identification = User::identificationUsers();
            if ($identification == false) {
                header("Location: /user/login");
            } elseif ($identification == true) {
                //Все все ок делаем запрос к бд и добавляем картинку в файл
                if ($errors == false) {
                    $result = addCategory::addCategoryFor($title, $data, $short_content, $image);
                    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
                        $result = true;
                        header("Refresh:3 url=/forum");
                    }
                }

            }
        }

        require_once ROOT . '/views/forum/addIndex.php';
        return true;
    }

    //Удаление категории из осн страницы форума
    public function actionDeleteCategoryId($categoryId)
    {
        // Получаем идентификатор пользователя из сессии
        $userId = User::checkLogged();

        // Получаем информацию о пользователе из БД
        $user = User::getUserById($userId);

        //Проверка уровня допуска
        if ($user['role'] != 1) {
            header("Location: /cabinet/$userId");
            exit();
        }
        //Получить нужную категорию
        $categoryItem = Category::getCategoryItem($categoryId);

        //получаем картинку этой категории
        $imageSrc = $categoryItem['image'];

        //Путь к картинке
        $imagePath = ROOT . $imageSrc;

        //Удаляем картинку
        if (!unlink($imagePath)) {
            return false;
        } else {

            //Удаляем нужную категорию по идентификатору
            $deleteNews = Category::deleteCategory($categoryId);
            if ($deleteNews == false) {
                return false;
            } else {

                //Удаление всех тем из этой категории
                $deleteAllTema = Forum::deleteAllTema($categoryId);
                if ($deleteAllTema == false) {
                    return false;
                } else {

                    //Удаление всех комментариев из этой категории
                    $deleteAllComments = CommentsForum::deleteCommentsALL($categoryId);
                    if ($deleteAllComments == false) {
                        return false;
                    } else {

                        //После удаления делаем переадресацию на форум
                        header("Location: /forum/");
                        return true;
                    }
                }
            }
        }
    }

    //Темы раздела
    public function actionViews($categoryId, $page = 1)
    {
        $_SESSION['searchPage'] = "forum";
        $_SESSION['category'] = $categoryId;
        //Получаем список тем по заданной категории
        $forumList = array();
        $forumList = Forum::getForumList($categoryId, $page);

        //получаем количество записей тем в переменную $total
        $total = Forum::getCountForumList($categoryId);

        //Создаем обьект пагинатора
        $pagination = new Pagination($total, $page, News::SHOW_BY_DEFAULT, 'page-');

        //Получаем индентификатор пользователя
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user'];
            //Получить всю информацию о пользователе
            $user = User::getUserById($userId);
        }

        $users = User::getUsers();

        $identification = User::identificationUsers();

        require_once ROOT . '/views/forum/view.php';
        return true;

    }

    //Редактирование Тем роздела
    public function actionEditView($id)
    {
        // Получаем идентификатор пользователя из сессии
        $userId = User::checkLogged();

        // Получаем информацию о пользователе из БД
        $user = User::getUserById($userId);

        //Проверка уровня допуска
        if ($user['role'] != 1) {
            header("Location: /cabinet/$userId");
            exit();
        }

        $errors = false;
        $result = false;

        //Получить title и image нужной категории
        $titl = Forum::getTitle($id);
        $img = Forum::getImage($id);

        //Валидация полученных данных с POST
        if (isset($_POST['submit'])) {
            $title = $_POST['title'];

            //Путь старой картинки
            $image = $img;

            //Проверяем была ли добавлена новая картинка,
            //если да то обновляем данные
            if (!empty($_FILES['userfile']['name'])) {
                $uploaddir = ROOT . '/template/images/category/';
                $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
                $image = "/template/images/category/" . $_FILES['userfile']['name'];
            }

            //Валидация поля title
            if (isset($_POST['title'])) {
                if (mb_strlen($_POST['title']) <= 5) {
                    $errors[] = "Заголовок должен быть больше 5 символов";
                } elseif (mb_strlen($_POST['title']) > 255)
                    $errors[] = "Слишком большой заголовок";
            }

            //Валидация на размер файла
            if ($_FILES['userfile']['size'] > 120000) {
                $errors[] = "Слишком большой размер файла";
            }

            //Если все ок делаем запрос к бд и добавляем картинку в файл
            if ($errors == false) {
                $result = Forum::editTemaItem($title, $image, $id);

                if (!empty($_FILES['userfile']['name'])) {
                    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {

                    }
                }
                $result = true;
            }

        }
        require_once ROOT . "/views/forum/editView.php";
        return true;

    }

    //Добавление темы роздела
    public function actionAddTheme($categoryId)
    {
        $_SESSION['searchPage'] = "forum";
        $_SESSION['category'] = $categoryId;
        //Проверяем существует ли сессия,если да -возвращаем,
        //если нет -переадресация на страницу авторизации
        $userId = User::checkLogged();

        $result = false;
        $errors = false;
        $data = date("Y-m-d H:i:s");

        //Получаем image нужной категории
        $imageCategory = Category::getImageCategory($categoryId);

        //Валидация полученных данных
        if (isset($_POST['submit'])) {
            $date = $_POST['date'];
            $current_user_id = $_POST['current_user_id'];
            $current_category_id = $_POST['current_category_id'];
            $image = $_POST['image'];
            $title = $_POST['title'];

            $title = User::cleanStr($title);
            $current_category_id = intval($current_category_id);
            $current_user_id = intval($current_user_id);

            if (mb_strlen($title) < 5) {
                $errors[] = "Заголовок не меньше 5 символов";
            }

            if (mb_strlen($title) > 40) {
                $errors[] = "Заголовок не больше 40 символов";
            }

            $identification = User::identificationUsers();
            if ($identification == false) {
                header("Location: /user/logout");
            } elseif ($identification == true) {
                if ($errors == false) {
                    $result = Forum::addForumItem($title, $date, $current_user_id, $current_category_id, $image);
                    $result = true;
                    header("Refresh: 1; url=/category/$categoryId");
                }
            }
        }

        require_once ROOT . '/views/forum/addForumItem.php';
        return true;
    }

    //Удаление темы из роздела
    public function actionDeleteView($categoryId)
    {
        // Получаем идентификатор пользователя из сессии
        $userId = User::checkLogged();

        // Получаем информацию о пользователе из БД
        $user = User::getUserById($userId);

        //Проверка уровня допуска
        if ($user['role'] != 1) {
            header("Location: /cabinet/$userId");
            exit();
        }

        //Удаляем нужную новость по идентификатору
        $deleteNews = Forum::deleteTemaItem($categoryId);

        //Удаляем все комментарии из этой темы
        $deleteComments = CommentsForum::deleteComments($categoryId);

        $host = $_SERVER['HTTP_REFERER'];
        $str = Other::getUri($host, 2);
        //Полсе удаления делаем переадресацию форум
        header("Location: /$str");
        return true;
    }

    //Темы на форуме,комментарии + добавление комментариев
    public function actionItem($categoryId, $category, $page = 1)
    {
        $_SESSION['searchPage'] = "forum";
        $errors = false;
        //Получить все комментарии по $categoryId
        $commentsList = array();
        $commentsList = CommentsForum::getCommentsItem($categoryId, $page);

        //Получить всех пользователей
        $users = User::getUsers();

        // получаем идентификатор сессии,
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user'];
            //Получить всю информацию о пользователе
            $us = User::getUserById($userId);
        } else {
            $us = false;
        }

        //Получить количество комментариев по нужной теме
        $total = CommentsForum::getCountCommentsForumItem($categoryId);

        //Пагинатор
        $pagination = new Pagination($total, $page, CommentsForum::SHOW_BY_DEFAULT, 'page-');

        $date = date("Y-m-d H:i:s");


        //Валидация
        if (isset($_POST['submit'])) {
            $data = $_POST['date'];
            $description = $_POST['description'];
            $description = User::cleanStr($description);
            $forum_id = $_POST['forum_id'];

            if (empty($description)) {
                $errors[] = "Напишите сообщение";
            }

            if (mb_strlen($description) < 2) {
                $errors[] = "Введите 2 или более символа";
            }

            if (mb_strlen($description) > 255) {
                $errors[] = "Слишком большое сообщение";
            }

            //Проверка статуса пользователя при отправлении формы
            $identification = User::identificationUsers();
            if ($identification == false) {
                header("Location: /user/logout");
            } elseif ($identification == true) {
                if (isset($description) && !empty($description) && $errors == false) {

                    //Добавление комментариев в бд
                    $result = CommentsForum::CommentsAdd($userId, $data, $description, $forum_id, $category);

                    //Получить количество записей пользователя
                    $userCount = CommentsForum::getCountUserComments($userId);

                    // Обновление счетчика  комментариев пользователя
                    $userAddComment = User::UserAddCommentForum($userId, $userCount);
                    header("Location: /category/{$category}/item/{$categoryId}");
                }
            }
        }
        //Получаем title нужной категории
        $title = Forum::getTitle($categoryId);
        //Получаем image нужной категории
        $image = Forum::getImage($categoryId);

        //Проверка статуса пользователя на возможность видеть форму
        $identification2 = User::identificationUsers();
        require_once ROOT . '/views/forum/item.php';
        return true;
    }

    //Удаление по одному комментарию из темы на форуме
    public function actionDeleteCommentForum($categoryId, $id, $user)
    {
        // Получаем идентификатор пользователя из сессии
        $userId = User::checkLogged();

        // Получаем информацию о пользователе из БД
        $user = User::getUserById($userId);

        //Проверка уровня допуска
        if ($user['role'] != 1) {
            header("Location: /cabinet/$userId");
            exit();
        }

        //Удаляем нужный комментарий по идентификатору
        $deleteComment = CommentsForum::deleteUserComment($id);

        //Получить количество записей пользователя
        $userCount = CommentsForum::getCountUserComments($userId);

        // Обновление счетчика  комментариев пользователя
        $userAddComment = User::UserAddCommentForum($userId, $userCount);

        //Создаем путь переадресации
        $host = $_SERVER["HTTP_REFERER"];
        $str = Other::getUri($host, 2);

        //После удаления делаем переадресацию на тему
        header("Location: /$str");
        return true;
    }


}