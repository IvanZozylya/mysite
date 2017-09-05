<?php
$online = User::getCountOnlineUserAll(1);
$getUserAdmin = array();
if(isset($_SESSION['user'])){
    $userId = $_SESSION['user'];
    $getUserAdmin = User::getUserById($userId);
}
//if(isset($_SESSION['user']) && ($getUserAdmin['online']) == 0){
//    header("Location: /user/logout");
//    exit();
//}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Новости</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!--обновление счетчика онлайн каждые 15минут-->
    <script>
        var timerId = setInterval(function() {
            $.post("/views/site/offlineRedactor.php",{armagedon:"Ok"});
            alert("Данные обновлены");
        }, 900000);
    </script>
</head>
<body>

<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Навигация</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Главная</a>
            <a class="navbar-brand" href="/news">Новости</a>
            <a class="navbar-brand" href="/forum">Форум</a>
            <a class="navbar-brand" href="/contact">Связь</a>
        </div>
            <form class="navbar-form navbar-left" role="search" action="/search/" method="post">
                <div class="form-group">
                    <input type="text" class="form-control"
                           <?php if($_SESSION['searchPage'] == "news") :?>placeholder="Поиск новости"<?php endif;?>
                        <?php if($_SESSION['searchPage'] == 'user'): ?> placeholder="Поиск пользователя"<?php endif;?>
                        <?php if($_SESSION['searchPage'] == 'category'): ?> placeholder="Поиск категории"<?php endif;?>
                        <?php if($_SESSION['searchPage'] == 'forum'): ?> placeholder="Поиск темы"<?php endif;?>
                           name="words" value="<?php if(isset($_POST['bsearch'])) echo $_POST['words'];?>">
                </div>

                <button type="submit" class="btn btn-default" name="bsearch">Найти</button>
                <?php if($_SESSION['searchPage'] !="user") :?>

                    <select name="search" id="" class="btn">
                    <option value="1" selected>Любое слово</option>
                    <option value="2" <?php if(isset($_POST['search'])&&($_POST['search']) == 2) echo 'selected';?>>Все слова</option>
                    <option value="3" <?php if(isset($_POST['search'])&&($_POST['search']) == 3) echo 'selected';?>>Точное совпадение</option>
                </select>

                <?php endif;?>

                <?php if($_SESSION['searchPage'] == "user") : ?>
                <select name="search" id="" class="btn">
                    <option value="1" <?php if(!isset($_POST['bsearch'])) echo 'selected';?>>Любое слово</option>
                    <?php if(isset($getUserAdmin) && ($getUserAdmin['role']==1)) :?>
                    <option value="2" <?php if(isset($_POST['search'])&&($_POST['search']) == 2) echo 'selected';?>>По id</option>
                        <?php endif;?>
                    <option value="3" <?php if(isset($_POST['search'])&&($_POST['search']) == 3) echo 'selected';?>>По имени</option>
                </select>
                <?php endif;?>
            </form>

        <ul class="nav navbar-nav navbar-right">
            <li><a href="#" style="color: #2aabd2;">Онлайн: <b><?php echo $online;?></b></a></li>
            <?php if(User::isGuest()) :?>
                <li><a href="/user/register/">Регистрация</a></li>
                <li><a href="/user/login/">Вход</a></li>
            <?php else : ?>
                <li><a href="/user/logout/">Выход</a></li>
                <li><a href="/cabinet/<?php echo $userId;?>">Кабинет</a></li>
            <?php endif; ?>

        </ul>
        </div>
    </div>
</nav>


