<div class="row"></div>
<h3>Комментарии</h3>

<div class="">
    <?php foreach ($commentsList as $comments) :?>
        <ul>
            <?php foreach ($users as $userName) : ?>
                <?php if($comments['current_user_id'] == $userName['id']) :?>
                    <li><?php echo $userName['name'];?></li>
                <?php endif; ?>
            <?php endforeach; ?>
            <li><?php echo $comments['date']?></li>
            <li class="btn-default alert"><b><?php echo $comments['description']?>
                    <?php if($us['role'] == 1) : ?>
                        <a href="/delete/<?php echo $newsItem['id'];?>/comments/<?php echo $comments['id'];?>/user/<?php echo $comments['current_user_id'];?>" class="pull-right conf">Удалить</a></b></li>
                    <?php endif; ?>
        </ul>
    <?php endforeach; ?>
</div>


<?php if($identification == true) :?>
<h3 class="pull-right btn-default" ><a href="/comments/add/<?php echo $id?>">Добавить комментарий</a></h3>
<?php else : ?>
<h4 class="pull-right btn-default">Внимание! Только зарегистрированные пользователи могут оставлять комментарии.</h4>
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