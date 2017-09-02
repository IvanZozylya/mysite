<title>Удаление пользователей</title>
<?php require_once ROOT . '/views/layouts/header.php'; ?>
<div><a href="/users/allFunctions/"><h4>Вернуться</h4></a></div>
<h1 class="text-center btn-default">Удаление пользователей</h1>
<h3 class="text-center">Кол-во пользователей: <b class="btn-default"><?php echo $total;?></b></h3>
<div class="text-center">
    <h4>Удалить пользователя по <b>id</b></h4>
    <form action="" method="post">
        <input type="text" name="UserId">
        <input type="submit" class="conf"  name="submit" value="Удалить">
    </form>
    <?php foreach ($usersList as $users) : ?>
        <form action="" method="post">
            <h4><b class="btn btn-default"><a
                            href="/cabinet/<?php echo $users['id']; ?>"><?php echo $users['name']; ?>
                        <b><?php echo $users['id'];?></b></a></b>
                <input type="text"  class="hidden" name="UserId" value="<?php echo $users['id'];?>">
                <b><input type="submit" class="btn-danger conf" value="Delete" name="Delete"></b></h4>
        </form>
    <?php endforeach; ?>
</div>
<div class="col-md-4 col-md-offset-4">
    <?php echo $pagination->get(); ?>
</div>
<script>
    $("document").ready(function () {
        $(".conf").click(function () {
            var conf = confirm("Удалить пользователя?");
            if (conf == true) {
                alert("Пользователь был удален");
            }
            if (conf == false) {
                return false;
            }
        });
    });
</script>
<?php require_once ROOT . '/views/layouts/footer.php'; ?>