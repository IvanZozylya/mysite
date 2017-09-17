<div class="row"></div>
<h3 style="background: orange" class="text-center btn-warning">Комментарии</h3>

<div class="text-center">
    <?php foreach ($commentsList as $comments) :?>
        <div >
            <?php foreach ($users as $userName) : ?>
                <?php if($comments['current_user_id'] == $userName['id']) :?>
                    <div><?php echo $userName['name'];?></div>
                <?php endif; ?>
            <?php endforeach; ?>
            <div><?php echo $comments['date']?></div>
            <p class="register"><b><?php echo $comments['description']?>
                    <?php if($us['role'] == 1) : ?>
                        <a href="/delete/<?php echo $newsItem['id'];?>/comments/<?php echo $comments['id'];?>/user/<?php echo $comments['current_user_id'];?>" class="pull-right conf" style="color:black;">Удалить</a></b></p>
                    <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<?php if($identification == true) :?>
<h3 class="pull-right btn-default" ><a href="/comments/add/<?php echo $id?>"><b class="btn btn-primary">Добавить комментарий <i class="fa fa-commenting" aria-hidden="true"></i></b></a></h3>
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