<?php


class NewsController
{
    //все новости
    public function actionIndex($page = 1)
    {
        $_SESSION['searchPage'] = "news";
        //получаем все новости в newsList
        $newsList = array();
        $newsList = News::getNews($page);

        //получаем количество записей в переменную $total
        $total = News::getCountNewsId();

        //Создаем обьект пагинатора
        $pagination = new Pagination($total, $page, News::SHOW_BY_DEFAULT, 'page-');

        //Получаем индентификатор пользователя
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user'];
            //Получить всю информацию о пользователе
            $user = User::getUserById($userId);
        }


        require_once(ROOT . '/views/news/index.php');
        return true;
    }

    //одна новость
    public function actionShowItem($id, $page = 1, $params = false)
    {
        #ПРОВЕРКА НА СУЩЕСТВОВАНИЕ
        $ItemNews = News::getShowItemNews($id);
        if ($ItemNews == false) {
            header("Location: /news");
            exit();
        }
        if ($params == true) {
            header("Location: /news");
            exit();
        }

        //Устанавливаем значение сессии = news
        $_SESSION['searchPage'] = "news";
        //получаем все данные об этой новости в newsItem
        $newsItem = array();
        $newsItem = News::getShowItemNews($id);

        //Получаем все комментарии нужной новости по id
        $commentsList = array();
        $commentsList = CommentsNews::getCommentsNewsList($id, $page);

        //Получить всех пользователей
        $users = User::UsersAll();

        //получаем количество комментарий новости
        $total = CommentsNews::getCountCommentsNewsItem($id);

        //Пагинатор
        $pagination = new Pagination($total, $page, CommentsNews::SHOW_BY_DEFAULT, 'page-');

        // получаем идентификатор сессии,
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user'];
            //Получить всю информацию о пользователе
            $us = User::getUserById($userId);
        } else {
            $us = false;
        }

        $identification = User::identificationUsers();

        require_once(ROOT . '/views/news/getItem.php');
        return true;
    }

    //Редактирование новости
    public function actionEditNews($id, $params = false)
    {
        #ПРОВЕРКА на существование
        $ItemNews = News::getShowItemNews($id);
        if ($ItemNews == false) {
            header("Location: /news/");
            exit();
        }
        #ПРОВЕРКА на существование
        if ($params == true) {
            header("Location: /news/");
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

        $errors = false;
        $result = false;

        //Получаем нужную новость по идентификатору
        $newsItem = array();
        $newsItem = News::getShowItemNews($id);


        //Валидация полученных данных с POST
        if (isset($_POST['submit'])) {
            $title = $_POST['title'];
            $data = $newsItem['date'];
            $content = $_POST['content'];

            //Путь старой картинки
            $image = $newsItem['image'];

            //Проверяем была ли добавлена новая картинка,
            //если да то обновляем данные
            if (!empty($_FILES['userfile']['name'])) {
                $uploaddir = ROOT . '/template/images/news/';
                $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
                $image = "/template/images/news/" . $_FILES['userfile']['name'];
            }

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

            //Валидация на размер файла
            if ($_FILES['userfile']['size'] > 200000) {
                $errors[] = "Слишком большой размер файла";
            }

            //Если все ок делаем запрос к бд и добавляем картинку в файл
            if ($errors == false) {
                $result = News::editNews($title, $data, $content, $image, $id);

                if (!empty($_FILES['userfile']['name'])) {
                    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {

                        //Обработка названия image
                        $img = basename($newsItem['image']);
                        $imgArr = explode(".", $img);
                        $imageArr = array_pop($imgArr);
                        $image = strval($imageArr);

                        //Изменить название image
                        $newname = ROOT . '/template/images/news/' . $newsItem['id'] . '.'.$image;
                        //Изменяем название картинки в файле
                        if (rename($uploadfile, $newname)) {

                            $newPath = '\'/template/images/news/' . $newsItem['id'] . '.' . $image . '\'';
                            $newPathImage = News::editPathImage($newsItem['id'], $newPath);
                        }
                    }
                }
                $result = true;
            }

        }


        require_once ROOT . '/views/news/editNews.php';
        return true;

    }

    //Удаление новости + удаление всех комментариев из этой новости
    public function actionDeleteNews($id)
    {
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
        //Вывод нужной новости
        $newsItem = News::getShowItemNews($id);

        //Получить image новости
        $imageSrc = $newsItem['image'];

        //Путь к файлу image
        $imagePath = ROOT . $imageSrc;

        if (!unlink($imagePath)) {
            return false;
        }

        //Удаляем нужную новость по идентификатору
        $deleteNews = News::deleteNews($id);

        //Удаляем все комментарии этой новости
        $deleteComments = CommentsNews::deleteComments($id);

        //Если все удалилось делаем переадресацию на новости
        header("Location: /news/");
        return true;
    }

}