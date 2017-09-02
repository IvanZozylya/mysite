<title><?php echo $title;?></title>
<?php include_once ROOT . '/views/layouts/header.php'; ?>
<?php if($_SERVER['HTTP_REFERER'] == "http://localhost/search") :?>
    <div><a href="/search"><h4>Вернуться</h4></a></div>
<?php endif;?>
    <h2 class="btn-default alert"><img src="<?php echo $image?>" width="40" alt=""> <?php echo $title;?></h2>

    <div class="">
        <?php foreach ($commentsList as $comments) :?>
            <ul>
                <?php foreach ($users as $userName) : ?>
                    <?php if($comments['current_user_id'] == $userName['id']) :?>
                        <li><?php echo $userName['name'];?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
                <li><?php echo $comments['date']?></li>
                <li class="btn-default alert">
                    <b style="<?php echo $style?>"><?php echo $comments['description']?></b>
                    <?php if($us['role'] == 1) :?>
                    <h4><a href="/item/<?php echo $categoryId;?>/delete/<?php echo $comments['id'];?>/user/<?php echo $comments['current_user_id'];?>" class="pull-right conf">Удалить</a></h4>
                    <?php endif; ?>
                </li>
            </ul>




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
    <div class="signup-form">
        <h2>Добавление комментариев</h2>
        <form action="#" method="post">
            <input type="datetime" class="hidden" name="date" placeholder="Имя" value="<?php echo $date;?>"/>
            <input type="text" class="hidden" name="current_user_id" placeholder="Пароль" value="<?php echo $userId?>"/>
            <input type="text" class="hidden" name="current_user_id" placeholder="Пароль" value="<?php echo $category?>"/>
            <textarea name="description" id="" cols="30" rows="5"></textarea><br>
            <input type="text" class="hidden" name="forum_id" value="<?php echo $categoryId?>;">
            <input type="submit" name="submit" class="btn btn-success" value="Добавить" />
        </form>
    </div>
<?php endif;?>
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

    <div class="col-md-4 col-md-offset-4">
        <?php echo $pagination->get(); ?>
    </div>
<?php include_once ROOT . '/views/layouts/footer.php'; ?>