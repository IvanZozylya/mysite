<?php require_once ROOT . '/views/layouts/header.php'; ?>

<?php if (isset($_SERVER['HTTP_REFERER'])) : ?>
    <?php if ($_SERVER['HTTP_REFERER'] == "http://localhost/search") : ?>
        <div><a href="/search"><h4>Вернуться</h4></a></div>
    <?php endif; ?>
<?php endif; ?>

<div class="register text-center">
    <div class="row otstup">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <ul>
                <h4>
                    <li class="btn btn-default"><a href="/user/block/0">User Active</a></li>
                    <li class="btn btn-default"><a href="/user/block/2">User Blocked</a></li>
                </h4>
            </ul>
            <h3><?php if ($role == 0)
                    echo "<b class='btn btn-success'>Users Active : " . $total . "</b>";
                elseif ($role == 2) {
                    echo "<b class='btn btn-warning'>Users Blocked: " . $total . "</b>";
                } else {
                    echo "Эти данные недоступны";
                } ?></h3>
            <?php foreach ($users as $active) : ?>
                <ul>
                    <li>
                        <?php if ($active['role'] == 0) : ?>
                            <form action="" method="post">
                                <h4><b class="btn btn-default"><a
                                                href="/cabinet/<?php echo $active['id']; ?>"><?php echo $active['name']; ?>
                                <b class='btn-success'>Active </b></a></b>
                                    <input type="text"  class="hidden" name="UserId" value="<?php echo $active['id'];?>">
                                <b><input type="submit" class="btn-warning conf" value="Blocked" name="Blocked"></b></h4>
                            </form>
                        <?php endif; ?>

                        <?php if ($role == 2) : ?>
                        <form action="" method="post">
                            <h4><b class="btn btn-default"><a
                                            href="/cabinet/<?php echo $active['id']; ?>"><?php echo $active['name']; ?>
                                        <b class='btn-warning'>Blocked</b></a></b>
                                <input type="text"  class="hidden" name="UserId" value="<?php echo $active['id'];?>">
                                <b><input type="submit" class="btn-success conf2" value="Active" name="Active"></b></h4>
                        </form>
                        <?php endif; ?>
                        <?php if($role == 1)echo "Данные администраторов недоступны"; ?>

                    </li>
                </ul>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div class="col-md-4 col-md-offset-4">
    <?php echo $pagination->get(); ?>
</div>
<script>
    $("document").ready(function () {
        $(".conf").click(function () {
            var conf = confirm("Заблокировать пользователя?");
            if (conf == true) {
                alert("Пользователь был заблокирован");
            }
            if (conf == false) {
                return false;
            }
        });
        $(".conf2").click(function () {
            var conf = confirm("Разблокировать пользователя?");
            if (conf == true) {
                alert("Пользователь был разблокирован");
            }
            if (conf == false) {
                return false;
            }
        });

    })
</script>

<?php require_once ROOT . '/views/layouts/footer.php'; ?>