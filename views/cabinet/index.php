<title>Кабинет</title>
<?php require_once ROOT . '/views/layouts/header.php'; ?>
<section>
    <div class="container">
        <div class="row">
            <h1>Кабинет пользователя</h1>

            <?php if ($user['id'] == $userId) : ?>
                <h3>Привет, <?php echo $user['name']; ?>!</h3>
            <?php endif; ?>
            <?php if ($user['online'] == 1) : ?>
                <h3>User: <b class="btn-success">
                        <?php echo $user['name']; ?>
                    </b>
                </h3>

            <?php elseif ($user['online'] == 0) : ?>
                <h3>User: <b class="btn-danger"><?php echo $user['name']; ?></b></h3><p>Был в
                    сети: <?php echo $user['date']; ?></p>
            <?php endif; ?>

            <ul>
                <?php if ($user['id'] == $userId) : ?>
                    <?php if ($user['role'] == 1) : ?>
                        <li><a href="/admin">Admin Panel</a></li>
                    <?php endif; ?>
                    <li><a href="#">Сообщения</a></li>
                    <li><a href="#">Другие пользователи</a></li>
                    <li><a href="/cabinet/edit">Редактировать данные</a></li>
                <?php endif; ?>

                <?php if ($user['role'] != 1) : ?>
                    <?php if ($userId == 13) : ?>

                        <form action="" method="post">
                            <input type="text" name="idUser" class="hidden" value="<?php echo $user['id']; ?>">
                            <input type="submit" class="conf1" name="delete" value="Удалить">
                        </form>

                        <?php if ($user['role'] == 0) : ?>

                            <form action="" method="post">
                                <input type="text" name="idUser" class="hidden" value="<?php echo $user['id']; ?>">
                                <input type="submit" class="conf2" name="blocked" value="Блокировать">
                            </form>

                        <?php endif; ?>
                        <?php if ($user['role'] == 2) : ?>

                            <form action="" method="post">
                                <input type="text" name="idUser" class="hidden" value="<?php echo $user['id']; ?>">
                                <input type="submit" class="conf3" name="active" value="Разблокировать">
                            </form>

                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</section>
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
