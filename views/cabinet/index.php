<?php require_once ROOT . '/views/layouts/header.php'; ?>
<section class="register">
    <div class="container">
        <div class="row">
            <h1 class="text-center">Кабинет пользователя</h1>

            <?php if ($user['id'] == $userId) : ?>
                <h2>Привет, <b style="color: maroon"><?php echo $user['name']; ?>!</b></h2>
                <br>
            <?php endif; ?>
                <?php if ($user['id'] == $userId) : ?>
                    <?php if ($user['role'] == 1) : ?>
                        <h3 class="btn btn-primary register"><a href="/admin/" style="color: maroon" class="fa fa-user-secret"> Admin Panel</a></h3><br>
                    <?php endif; ?>
                    <h3 class="btn btn-primary register"><a href="/message/incoming/" style="color: maroon" class="fa fa-comments"> Сообщения</a></h3><br>
                    <h3 class="btn btn-primary register"><a href="/otherUsers/" style="color: maroon" class="fa fa-users"> Другие пользователи</a></h3><br>
                    <h3 class="btn btn-primary register"><a href="/cabinet/edit/" style="color: maroon" class="fa fa-pencil"> Редактировать данные</a></h3><br>
                <?php endif; ?>
            <?php if ($user['online'] == 1) : ?>
                <h3 class="pull-right"><i class="fa fa-user" aria-hidden="true">User:</i> <b class="btn-success">
                        <?php echo $user['name']; ?>
                    </b>
                </h3>

            <?php elseif ($user['online'] == 0) : ?>
                <h3><i class="fa fa-user" aria-hidden="true">User:</i> <b class="btn-danger"><?php echo $user['name']; ?></b></h3><p>Был в
                    сети: <?php echo $user['date']; ?></p>
            <?php endif; ?>
            <?php if($user['id'] !=$userId) :?>
                <a href="/message/view/<?php echo $user['id'];?>" class="btn btn-primary icon-message"> Написать сообщение</a>
            <?php endif;?>
        </div>
        <?php if ($user['role'] != 1) : ?>
            <?php if ($userId == 13) : ?>

                <form action="" method="post" class="col-sm-1 col-sm-offset-0 padding-right">
                    <input type="text" name="idUser" class="hidden" value="<?php echo $user['id']; ?>">
                    <input type="submit" class="btn-danger conf1" name="delete" value="Удалить">
                </form>

                <?php if ($user['role'] == 0) : ?>

                    <form action="" method="post">
                        <input type="text" name="idUser" class="hidden" value="<?php echo $user['id']; ?>">
                        <input type="submit" class="btn-warning conf2" name="blocked" value="Блокировать">
                    </form>

                <?php endif; ?>
                <?php if ($user['role'] == 2) : ?>

                    <form action="" method="post">
                        <input type="text" name="idUser" class="hidden" value="<?php echo $user['id']; ?>">
                        <input type="submit" class="btn-success conf3" name="active" value="Разблокировать">
                    </form>

                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>



        <br>
        <br>
        <br>
        <br>
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
