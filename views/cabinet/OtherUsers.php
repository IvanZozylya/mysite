<?php require_once ROOT . '/views/layouts/header.php'; ?>
<h3 class="btn btn-success">Все пользователи</h3>
<div class="text-center">
    <?php foreach ($allUsers as $users) : ?>
        <div class="alert"><a href="/cabinet/<?php echo $users['id']; ?>"><i class="btn btn-default">
                    <?php echo $users['name'] ?></i></a>
            <br><b><a href="#">Написать сообщение</a></b>
        </div>
    <?php endforeach; ?>
</div>

<div class="col-md-4 col-md-offset-5">
    <?php echo $pagination->get(); ?>
</div>
<?php require_once ROOT . '/views/layouts/footer.php'; ?>
