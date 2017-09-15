<?php include_once ROOT . "/views/layouts/header.php"; ?>

    <div class="text-center">
        <h1 class="btn-primary">Роздел новостей</h1>
    </div>

    <div class="container">
        <div class="row">
            <?php if(isset($user)&&($user['role']) == 1) :?>
                <div class="col-sm-4 col-sm-offset-11 padding-right">
                    <a href="/addNews"><h3 class="btn btn-success">Добавить новость:</h3></a>
                </div>
            <?php endif;?>
        </div>
    </div>

    <div class="label-danger text-center">
        <?php foreach ($newsList as $news): ?>
            <div class="register btn-primary alert">
                <a href="/news/<?php echo $news['id']; ?>">
                    <h4><img src="<?php echo $news['image']; ?>" alt="" width="60" height="50">
                        <?php echo $news['title']; ?>
                        <?php if (isset($user)) : ?>
                            <?php if ($user['role'] == 1) : ?>
                                <ul class="pull-right">
                                    <li><a href="/news/edit/<?php echo $news['id']; ?>"style="color: black">Редактировать</a></li>
                                    <li><a href="/news/delete/<?php echo $news['id']; ?>" class="conf" style="color: black">Удалить</a></li>
                                </ul>
                            <?php endif; ?>
                        <?php endif; ?>
                    </h4>
                </a>

                <p>Опубликовано: <?php echo $news['date']; ?></p></div>
        <?php endforeach; ?>
    </div>

    <div class="col-md-4 col-md-offset-4">
        <?php echo $pagination->get(); ?>
    </div>
    <script>
        $("document").ready(function () {
            $(".conf").click(function () {
                var conf = confirm("Удалить новость?");
                if (conf == true) {
                    alert("Новость была удалена");
                }
                if (conf == false) {
                    return false;
                }
            });

        })
    </script>
<?php include_once ROOT . "/views/layouts/footer.php"; ?>