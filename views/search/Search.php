<title>Поиск <?php echo $pageCategory; ?></title>
<?php require_once ROOT . '/views/layouts/header.php'; ?>
<div class="register">
<?php
echo "<h1 class='text-center btn-primary'>Результаты поиска $pageCategory</h1>";
if (isset($countResults)) {
    echo "<h4>Найдено : <b class='btn btn-primary'>$countResults</b></h4>";
}
if ($results === false) {
    echo "<b>Вы задали пустой запрос</b><br/>";
}
?>

<!--ПОИСК по новостям -->
<?php if ($_SESSION['searchPage'] == 'news') : ?>
    <?php if (count($results) == 0) : ?>
        <p><b>Ничего не найдено</b></p>
    <?php elseif (count($results) > 0 && is_array($results)) : ?>
        <?php foreach ($results as $resultNews) : ?>
            <div class="text-center">

                <h3>
                    <div class="btn"><a href="/news/<?php echo $resultNews['id']; ?>">
                            <img src="<?php echo $resultNews['image']; ?>" alt="" width="60" height="50">
                            <?php echo $resultNews['title']; ?></a></div>
                </h3>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>

<!--ПОИСК по темам -->
<?php if ($_SESSION['searchPage'] == 'forum') : ?>
    <?php if (count($results) == 0) : ?>
        <p><b>Ничего не найдено</b></p>
    <?php elseif (count($results) > 0 && is_array($results)) : ?>
        <?php foreach ($results as $resultTema) : ?>
            <div class="text-center">
                <h3>
                    <div class="btn"><a
                                href="/category/<?php echo $_SESSION['category']; ?>/item/<?php echo $resultTema['id']; ?>">
                            <img src="<?php echo $resultTema['image']; ?>" alt="" width="36"
                                 height="36"><?php echo $resultTema['title'] ?></a></div>
                </h3>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>

<!--ПОИСК по категориям -->
<?php if ($_SESSION['searchPage'] == 'category') : ?>
    <?php if (count($results) == 0) : ?>
        <p><b>Ничего не найдено</b></p>
    <?php elseif (count($results) > 0 && is_array($results)) : ?>
        <?php foreach ($results as $resultCategory) : ?>
            <div class="text-center">
                <h3>
                    <div class="btn"><a href="/category/<?php echo $resultCategory['id']; ?>">
                            <img src="<?php echo $resultCategory['image']; ?>" alt="" width="36"
                                 height="36"><?php echo $resultCategory['title']; ?></a></div>
                </h3>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>

<!--ПОИСК по ПОЛЬЗОВАТЕЛЯМ -->
<?php if ($_SESSION['searchPage'] == 'user') : ?>
<?php if (count($results) == 0) : ?>
    <p><b>Ничего не найдено</b></p>

<?php elseif (count($results) > 0 && is_array($results)) : ?>
<?php foreach ($results as $resultUser) : ?>

<div class="text-center">
    <h3>
        <div class="btn"><a href="/cabinet/<?php echo $resultUser['id']; ?>">
                <b><?php echo $resultUser['name']; ?></b>
                <?php if ($resultUser['online'] == 1) echo "<i class='btn-success'>Online</i>"; ?>
                <?php if ($resultUser['online'] == 0) echo "<i class='btn-danger'>Offline</i>"; ?>
            </a></div>
    </h3>
    <?php if (isset($user) && ($user['role'] == 1)) : ?>
    <?php if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == "http://localhost/user/block/0") : ?>
        <?php if ($resultUser['role'] == 0) : ?>
            <form action="/user/block/2/" method="post">
                <input type="text" class="hidden" name="UserId"
                       value="<?php echo $resultUser['id']; ?>">
                <i><input type="submit" class="btn-warning conf2" value="Blocked" name="Blocked"></i>
            </form>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == "http://localhost/user/block/2") : ?>
        <?php if ($resultUser['role'] == 2) : ?>
            <form action="/user/block/1/" method="post">
                <input type="text" class="hidden" name="UserId"
                       value="<?php echo $resultUser['id']; ?>">
                <i><input type="submit" class="btn-success conf3" value="Active" name="Active"></i>
            </form>
        <?php endif;?>
        <?php endif;?>

    <?php if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == "http://localhost/user/delete") : ?>
        <?php if ($resultUser['role'] != 1) : ?>
            <form action="/user/delete/" method="post">
                <input type="text" class="hidden" name="UserId" value="<?php echo $resultUser['id']; ?>">
                <i><input type="submit" class="btn-danger conf1" value="Delete" name="Delete"></i>
            </form>

            <?php endif;?>
            <?php endif;?>
        <?php endif; ?>
</div>

<?php endforeach; ?>
<?php endif; ?>
<?php endif; ?>
<br>
<br>
<br>
</div>
<script>
    $("document").ready(function () {
        $(".conf1").click(function () {
            var conf = confirm("Удалить пользователя?");
            if (conf == true) {
                alert("Пользователь был удален");
            }
            if (conf == false) {
                return false;
            }
        });
        $(".conf2").click(function () {
            var conf = confirm("Заблокировать пользователя?");
            if (conf == true) {
                alert("Пользователь был заблокирован");
            }
            if (conf == false) {
                return false;
            }
        });
        $(".conf3").click(function () {
            var conf = confirm("Разблокировать пользователя?");
            if (conf == true) {
                alert("Пользователь был разблокирован");
            }
            if (conf == false) {
                return false;
            }
        });
    });
</script>
<?php require_once ROOT . '/views/layouts/footer.php'; ?>
