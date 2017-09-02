<?php

class SearchController
{
    //Основная страница поиска
    public function actionSearch()
    {
        $results = false;
        $pageCategory = false;

        //задаем имя в конечном результате при поиске
        if ($_SESSION['searchPage'] == "news") {
            $pageCategory = "по новостям";
        }
        if ($_SESSION['searchPage'] == "category") {
            $pageCategory = "по категориям";
        }
        if ($_SESSION['searchPage'] == "forum") {
            $pageCategory = "по темам";
        }
        if ($_SESSION['searchPage'] == "user") {
            $pageCategory = "по пользователям";
        }

        //Если мы пришли из главной страницы или с новостей
        if ($_SESSION['searchPage'] == "news") {
            //Обработка результата
            if (isset($_POST['bsearch'])) {
                $words = User::cleanStr($_POST['words']);
                $searchValue = $_POST['search'];
                $results = Search::newsSearch($words, $_SESSION['searchPage'], $searchValue);
            }
        }

        //Если мы пришли из форума
        if ($_SESSION['searchPage'] == "category") {
            //Обработка результата
            if (isset($_POST['bsearch'])) {
                $words = User::cleanStr($_POST['words']);
                $searchValue = $_POST['search'];
                $results = Search::categorySearch($words, $_SESSION['searchPage'], $searchValue);
            }
        }

        //Если мы пришли из роздела тем
        if ($_SESSION['searchPage'] == "forum") {
            //Обработка результата
            if (isset($_POST['bsearch'])) {
                $words = User::cleanStr($_POST['words']);
                $searchValue = $_POST['search'];
                $results = Search::forumSearch($words, $_SESSION['searchPage'], $_SESSION['category'], $searchValue);
            }
        }

        //Если мы пришли из кабинета
        if ($_SESSION['searchPage'] == "user") {
            //Обработка результата
            if (isset($_POST['bsearch'])) {
                $words = User::cleanStr($_POST['words']);
                $searchValue = $_POST['search'];
                $results = Search::userSearch($words, $_SESSION['searchPage'], $searchValue);
            }
        }

        //Количество найденых записей
        if ($results != false) {
            $countResults = count($results);
        }

        require_once ROOT . '/views/search/Search.php';
        return true;

    }
}