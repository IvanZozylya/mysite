<?php
$online = User::getCountOnlineUserAll(1);
$getUserAdmin = array();
if (isset($_SESSION['user'])) {
    $userId = $_SESSION['user'];
    $getUserAdmin = User::getUserById($userId);
}
//if(isset($_SESSION['user']) && ($getUserAdmin['online']) == 0){
//    header("Location: /user/logout");
//    exit();
//}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cybersport</title>
    <!-- Animate.css -->
    <link rel="stylesheet" href="/template/css/animate.css">
    <!-- Icomoon Icon Fonts-->
    <link rel="stylesheet" href="/template/css/icomoon.css">
    <!-- Bootstrap  -->
    <link rel="stylesheet" href="/template/css/bootstrap.css">

    <!-- Magnific Popup -->
    <link rel="stylesheet" href="/template/css/magnific-popup.css">

    <!-- Owl Carousel  -->
    <link rel="stylesheet" href="/template/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/template/css/owl.theme.default.min.css">

    <!-- Theme style  -->
    <link rel="stylesheet" href="/template/css/style.css">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <!-- Modernizr JS -->
    <script src="/template/js/modernizr-2.6.2.min.js"></script>
    <!-- FOR IE9 below -->
    <!--[if lt IE 9]>
    <script src="/template/js/respond.min.js"></script>
    <![endif]-->
    <!--обновление счетчика онлайн каждые 15минут-->
    <script>
        var timerId = setInterval(function () {
            $.post("/views/site/offlineRedactor.php", {armagedon: "Ok"});

        }, 900000);
    </script>

</head>
<body>

<div class="fh5co-loader"></div>

<div id="page">
    <nav class="fh5co-nav register" role="navigation">
        <div class="top">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <p class="num">Call: +38 063 510 6747</p>
                        <ul class="fh5co-social">
                            <li><a href="#"><i class="icon-twitter"></i></a></li>
                            <li><a href="#"><i class="icon-dribbble"></i></a></li>
                            <li><a href="#"><i class="icon-github"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="top-menu">
            <div class="container">
                <div class="row">
                    <div class="col-xs-2">
                        <div id="fh5co-logo"><a href="/">Cybersport<span>.</span></a></div>
                    </div>
                    <div class="col-xs-10 text-right menu-1">
                        <ul>
                            <li class="col-sm-3"><a href="/">Главная</a></li>
                            <li class="col-sm-1"><a href="/news">Новости</a></li>
                            <li class="col-sm-2"><a href="/forum">Форум</a></li>
                            <li class="col-sm-1"><a href="/contact">Связь</a></li>
                            <li><a href="#" style="color: #2aabd2;">Онлайн: <b><?php echo $online; ?></b></a></li>
                            <?php if (User::isGuest()) : ?>
                                <li class="nav navbar-nav navbar-right"><a href="/user/register/">Регистрация</a></li>
                                <li class="nav navbar-nav navbar-right"><a href="/user/login/">Вход</a></li>
                            <?php else : ?>
                                <li class="nav navbar-nav navbar-right"><a href="/user/logout/">Выход</a></li>
                                <li class="nav navbar-nav navbar-right"><a href="/cabinet/<?php echo $userId; ?>">Кабинет</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <form class="navbar-form navbar-left" role="search" action="/search/" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control"
                               <?php if ($_SESSION['searchPage'] == "news") : ?>placeholder="Поиск новости"<?php endif; ?>
                            <?php if ($_SESSION['searchPage'] == 'user'): ?> placeholder="Поиск пользователя"<?php endif; ?>
                            <?php if ($_SESSION['searchPage'] == 'category'): ?> placeholder="Поиск категории"<?php endif; ?>
                            <?php if ($_SESSION['searchPage'] == 'forum'): ?> placeholder="Поиск темы"<?php endif; ?>
                               name="words" value="<?php if (isset($_POST['bsearch'])) echo $_POST['words']; ?>">
                    </div>

                    <button type="submit" class="btn btn-primary" name="bsearch">Найти</button>
                    <?php if ($_SESSION['searchPage'] != "user") : ?>

                        <select name="search" id="" class="btn btn-primary">
                            <option value="1" selected>Любое слово</option>
                            <option value="2" <?php if (isset($_POST['search']) && ($_POST['search']) == 2) echo 'selected'; ?>>
                                Все слова
                            </option>
                            <option value="3" <?php if (isset($_POST['search']) && ($_POST['search']) == 3) echo 'selected'; ?>>
                                Точное совпадение
                            </option>
                        </select>

                    <?php endif; ?>

                    <?php if ($_SESSION['searchPage'] == "user") : ?>
                        <select name="search" id="" class="btn">
                            <option value="1" <?php if (!isset($_POST['bsearch'])) echo 'selected'; ?>>Любое слово
                            </option>
                            <?php if (isset($getUserAdmin) && ($getUserAdmin['role'] == 1)) : ?>
                                <option value="2" <?php if (isset($_POST['search']) && ($_POST['search']) == 2) echo 'selected'; ?>>
                                    По id
                                </option>
                            <?php endif; ?>
                            <option value="3" <?php if (isset($_POST['search']) && ($_POST['search']) == 3) echo 'selected'; ?>>
                                По имени
                            </option>
                        </select>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </nav>

    <header id="fh5co-header" class="fh5co-cover fh5co-cover-sm" role="banner"
            style="background-image:url(/template/images/site/img_bg_2.jpg); height: 400px"
            data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="display-t">
                        <div class="display-tc animate-box" data-animate-effect="fadeIn">
                            <h1><a href="/">Cybersport</a></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>


