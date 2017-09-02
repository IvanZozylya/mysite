<?php

class CommentsController
{
    //Добавление комментариев в Новости
    public function actionAdd($id)
    {
        #ПРОВЕРКА НА СУЩЕСТВОВАНИЕ
        $itemNews = News::getShowItemNews($id);
        if($itemNews == false){
            header("Location: /Goodbye");
            exit();
        }

        $date = date("Y-m-d H:i:s");
        $errors = false;
        // получаем идентификатор сессии,
        // если сессии нет переадрисация на главную
        $userId = User::checkLogged();

        //Валидация
        if (isset($_POST['submit'])) {
            $data = $_POST['date'];
            $description = $_POST['description'];
            $news_id = $_POST['news_id'];

            $description = User::cleanStr($_POST['description']);
            if (empty($description)) {
                $errors[] = "Напишите комментарий";
            }
            if(mb_strlen($description)<2){
                $errors[] = "Введите 2 или более символа";
            }

            //Проверка статуса пользователя
            $identification = User::identificationUsers();
            if ($identification == false) {
                header("Location: /user/logout");
            } elseif ($identification == true) {
                if (isset($description) && !empty($description)&&$errors==false) {

                    //Добавление комментариев в бд
                    $result = CommentsNews::CommentsAdd($userId, $data, $description, $news_id);

                    //Получить количество записей пользователя
                    $userCount = CommentsNews::getCountUserComments($userId);

                    //Обновление счетчика  комментариев пользователя
                    $userAddComment = User::UserAddCommentNews($userId, $userCount);
                    header("Location: /news/$id");
                }
            }
        }

        require_once ROOT . '/views/comments_news/add.php';
        return true;

    }

    //Удаление комментариев из Новостей
    public function actionDeleteCommentNews($newsId, $comId, $idUser)
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
        $deleteComments = CommentsNews::deleteNewsComment($comId);

        //Получить количество записей пользователя
        $userCount = CommentsNews::getCountUserComments($userId);

        //Обновление счетчика  комментариев пользователя
        $userAddComment = User::UserAddCommentNews($userId, $userCount);

        //После удаления делаем переадресацию на тему
        header("Location: /news/$newsId");
        return true;

    }

}