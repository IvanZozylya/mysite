<title>Форум</title>
<?php require_once ROOT . '/views/layouts/header.php'; ?>

<div class="text-center">
    <h1>Форум</h1>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-4 col-sm-offset-11 padding-right">
            <?php if(isset($user) && ($user['role'] == 1)) :?>
            <a href="/addCategory"><h3 class="btn btn-success">Создать категорию:</h3></a>
            <?php endif;?>
            <?php if(isset($user) && ($user['role'] == 0)) :?>
                <a href="/category/add"><h3 class="btn btn-success">Создать категорию:</h3></a>
            <?php endif; ?>
        </div>
    </div>
</div>
<div>

    <?php foreach ($categoryList as $category): ?>
        <div class="btn-default">
            <h4>
                <img src="<?php echo $category['image']; ?>" alt="" width="36" height="36">
                <a href="/category/<?php echo $category['id']; ?>"><?php echo $category['title']; ?></h4></a>
            <div>Кол-во тем:
                <?php
                //Получаем количество тем нужной категории
                $count = Forum::getCountForumList($category['id']);
                echo $count;
                ?>
            </div>
            <div>Последнее сообщение от:
                <?php
                //Получить все данные по последнему комментарию
                $commentItem = CommentsForum::getCommentEnd($category['id'], "current_category_id");
                ?>
                <?php foreach ($users as $userName) : ?>
                    <?php if ($commentItem['current_user_id'] == $userName['id']) : ?>
                        <?php echo $userName['name']; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <div>Тема: "
                <a href="/category/<?php echo $category['id'] ?>/item/<?php echo $commentItem['forum_id'] ?>">
                    <?php
                    //Получить title темы последнего сообщения
                    $title = Forum::getTitle($commentItem['forum_id']);
                    if ($title) {
                        echo $title;
                    } ?>
                </a>"
            </div>

            <div>Дата последнего сообщения: <?php echo $commentItem['date']; ?></div>
            <h4>
                <?php if (isset($user)) : ?>
                    <?php if ($user['role'] == 1) : ?>
                        <div class="pull-right"><a
                                    href="/forum/edit/<?php echo $category['id']; ?>">Редактировать</a></div><br>
                        <div class="pull-right"><a href="/forum/delete/<?php echo $category['id']; ?>" class="conf">Удалить</a>
                        </div><br>

                    <?php endif; ?>
                <?php endif; ?>
            </h4>
        </div>

    <?php endforeach; ?>
</div>
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
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <?php echo $pagination->get(); ?>
    </div>
</div>
<?php require_once ROOT . '/views/layouts/footer.php'; ?>