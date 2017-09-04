<?php require_once ROOT . '/views/layouts/header.php'; ?>

<?php if (isset($_SERVER['HTTP_REFERER'])) : ?>
    <?php if ($_SERVER['HTTP_REFERER'] == "http://localhost/search") : ?>
        <div><a href="/search"><h4>Вернуться</h4></a></div>
    <?php endif; ?>
<?php endif; ?>

    <div class="container">
    <div class="row">
    <div class="col-sm-4 col-sm-offset-11 padding-right">
        <?php if($identification == true) :?>
        <a href="/category/<?php echo $categoryId?>/addTheme"><h3 class="btn btn-success">Создать новую тему:</h3></a>
        <?php endif;?>
    </div></div></div>
<?php foreach ($forumList as $forumCategory) : ?>
    <div class="btn-default"><a href="/category/<?php echo $categoryId; ?>/item/<?php echo $forumCategory['id']; ?>">
            <h4><img src="<?php echo $forumCategory['image']; ?>" alt="" width="36" height="36">
                <?php echo $forumCategory['title']; ?></h4></a>
        <div>Кол-во сообщений:
            <?php
            $countComments = CommentsForum::getCountCommentsForumItem($forumCategory['id']);
            echo $countComments;
            ?>
        </div>
        <div>Последнее сообщение от:
            <?php
            //Получить все данные по последнему комментарию
            $commentItem = CommentsForum::getCommentEnd($forumCategory['id'],"forum_id");
            ?>
            <?php foreach ($users as $userName) : ?>
                <?php if($commentItem['current_user_id'] == $userName['id']) :?>
                    <?php echo $userName['name'];?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <div>Дата последнего сообщения:
            <?php echo $commentItem['date'];?></div>
        <?php if (isset($user)) : ?>
            <?php if ($user['role'] == 1) : ?>
                <h4>
                    <div class="pull-right">
                        <a href="/category/edit/<?php echo $forumCategory['id']; ?>">Редактировать</a></div>
                    <br>
                    <div class="pull-right"><a href="/category/delete/<?php echo $forumCategory['id']; ?>" class="conf">Удалить</a>
                    </div>
                    <br></h4>
            <?php endif; ?>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
    <script>
        $("document").ready(function () {
            $(".conf").click(function () {
                var conf = confirm("Удалить категорию?");
                if (conf == true) {
                    alert("Категория была удалена");
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
<?php require_once ROOT . '/views/layouts/footer.php'; ?>