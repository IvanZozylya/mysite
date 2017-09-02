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
    public function actionContact()
    {
        $_SESSION['searchPage'] = 'news';
        $userEmail = '';
        $userText = '';
        $result = false;

        if (isset($_POST['submit'])) {

            $userEmail = $_POST['userEmail'];
            $userText = $_POST['userText'];

            $errors = false;

            // Валидация полей
            if (!User::checkEmail($userEmail)) {
                $errors[] = 'Неправильный email';
            }

            if ($errors == false) {
                $adminEmail = 'ivan.zozylya@gmail.com';
                $message = "Текст: {$userText}. От {$userEmail}";
                $subject = 'Тема письма';
                $headers = "From: {$userEmail}" . "\r\n" .
                    "Reply-To: {$userEmail}" . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
                $result = mail($adminEmail, $subject, $message, $headers);
                $result = true;
            }

        }

        require_once(ROOT . '/views/site/contact.php');

        return true;
    }

    //404 ошибка
    public function action404()
    {
        if ($_SESSION['searchPage'] == 'user') {
            header("Refresh:3 url=/user/login/");
        }else{
            header("Refresh:2 url=/");
        }
        require_once ROOT . '/views/site/404.php';

        return true;
    }
}