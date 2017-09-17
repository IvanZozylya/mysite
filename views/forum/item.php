<title><?php echo $title;?></title>
<?php include_once ROOT . '/views/layouts/header.php'; ?>
<?php if(isset($_SERVER['HTTP_REFERER'])) :?>
<?php if($_SERVER['HTTP_REFERER'] == "http://localhost/search") :?>
    <div><a href="/search"><h4>Вернуться</h4></a></div>
<?php endif;?>
    <?php endif;?>
    <h2 class="btn-default alert btn-primary text-center register"><img src="<?php echo $image?>" width="40" alt=""> <?php echo $title;?></h2>

    <div class="text-center">
        <?php foreach ($commentsList as $comments) :?>
            <div style="background: orange" class="btn-warning alert register">
                <?php foreach ($users as $userName) : ?>
                    <?php if($comments['current_user_id'] == $userName['id']) :?>
                        <div style="color: black"><?php echo $userName['name'];?></div>
                    <?php endif; ?>
                <?php endforeach; ?>
                <div style="color: black"><?php echo $comments['date']?></div>
                <div>
                    <b style="<?php echo $style?>"><i style="color: black"><?php echo $comments['description']?></i></b>
                    <?php if($us['role'] == 1) :?>
                    <h4><a href="/item/<?php echo $categoryId;?>/delete/<?php echo $comments['id'];?>/user/<?php echo $comments['current_user_id'];?>" class="pull-right conf">Удалить</a></h4>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php if($identification2 == false) :?>
    <h4 class="pull-right btn-default">Внимание! Только зарегистрированные пользователи могут оставлять комментарии.</h4>
<?php else : ?>
<?php if(isset($errors) && is_array($errors)) :?>
        <?php foreach ($errors as $error) :?>
            <ul>
                <li><?php echo $error;?></li>
            </ul>
            <?php endforeach; ?>
        <?php endif; ?>
    <div class="register text-center">
        <h2 class="register text-center"><b class="fa fa-comment" aria-hidden="true">Добавление комментариев</b></h2>
        <form action="#" method="post" class="text-center">
            <input type="datetime" class="hidden" name="date" placeholder="Имя" value="<?php echo $date;?>"/>
            <input type="text" class="hidden" name="current_user_id" placeholder="Пароль" value="<?php echo $userId?>"/>
            <input type="text" class="hidden" name="current_user_id" placeholder="Пароль" value="<?php echo $category?>"/>
            <textarea name="description" id="" cols="100" rows="3"></textarea><br>
            <input type="text" class="hidden" name="forum_id" value="<?php echo $categoryId?>;">
            <input type="submit" name="submit" class="btn btn-primary" value="Добавить" />
        </form>
    </div>
<?php endif;?>
<div class="col-md-4 col-md-offset-4">
    <?php echo $pagination->get(); ?>
</div>
<script>
    $("document").ready(function () {
        $(".conf").click(function () {
            var conf = confirm("Удалить комментарий?");
            if (conf == true) {
                alert("Комментарий был удален");
            }
            if (conf == false) {
                return false;
            }
        });

    })
</script>


<?php include_once ROOT . '/views/layouts/footer.php'; ?>