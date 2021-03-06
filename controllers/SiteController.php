<?php


class SiteController
{
    //Главная страничка
    public function actionIndex()
    {
        $_SESSION['searchPage'] = 'news';

        require_once(ROOT . '/views/site/index.php');
        return true;
    }

    //страничка - Обратная связь
    public function actionContact($id = false)
    {
        #ПРОВЕРКА НА СУЩЕСТВОВАНИЕ:
        if ($id == true) {
            header("Location: /contact");
            exit();
        }
        $_SESSION['searchPage'] = 'news';
        $userEmail = '';
        $userText = '';
        $result = false;

        if (isset($_POST['submit'])) {

            $d = date("Y-m-d H:i:s");
            $date = '\''.$d.'\'';

            //Валидация входящей строки
            $userEmail = User::cleanStr($_POST['userEmail']);
            $userText = User::cleanStr($_POST['userText']);

            $errors = false;

            // Валидация полей
            if (!User::checkEmail($userEmail)) {
                $errors[] = 'Неправильный email';
            }

            if(!User::checkPassword($userText)){
                $errors[] = 'Введите не меньше 6 символов';
            }

            //если все ок
            if ($errors == false) {
                //Если ошибок нет вносим данные на в таблицу feedback
                $feedbackItem = Feedback::goFeedbackItem($userEmail,$userText);

                //Если ошибок нет полученные данные на почту
                $adminEmail = 'ivan.zozylya@gmail.com';
                $message = "Текст: {$userText}. От {$userEmail}";
                $subject = 'Тема письма';
                $headers = "From: {$userEmail}" . "\r\n" .
                    "Reply-To: {$userEmail}" . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
                $result = mail($adminEmail, $subject, $message, $headers);
                $result = true;
                header("Refresh:2 url=/");
            }

        }

        require_once(ROOT . '/views/site/contact.php');

        return true;
    }

    //404 ошибка
    public function action404()
    {
        #УСЛОВИЯ ПЕРЕАДРЕСАЦИЙ
        //Если сессия == user
        if ($_SESSION['searchPage'] == 'user') {
            if (isset($_SESSION['user'])) {
                $user = $_SESSION['user'];
                header("Refresh:2 url=/cabinet/$user");
            } else {
                header("Refresh:2 url=/user/login");
            }
            //Если сессия == category
        } elseif ($_SESSION['searchPage'] == 'category') {
            header("Refresh:2 url=/forum");
        } else {
            header("Refresh:1 url=/");
        }

        require_once ROOT . '/views/site/404.php';

        return true;
    }
}