<title>Другие пользователи</title>
<?php require_once ROOT . '/views/layouts/header.php'; ?>
<div><a href="/cabinet/<?php echo $userId;?>"><h4>Вернуться</h4></a></div>
<a href="/otherUsers/"><h3 class="btn btn-success">Всего пользователей : <?php echo $total;?></h3></a>
<div class="">
    <table border="1" class="col-sm-4 col-sm-offset-4 padding-right text-center">
    <?php foreach ($allUsers as $users) : ?>
        <tr>
            <td style="padding: 10px"><a href="/cabinet/<?php echo $users['id']; ?>"><i class="btn btn-default">
                        <b><?php echo $users['name'] ?></b></i></a>
            </td>
            <td>
                <b><a href="#">Написать сообщение</a></b>
            </td>
        </tr>
    <?php endforeach; ?>
    </table>
</div>

<div class="col-md-4 col-md-offset-5">
    <?php echo $pagination->get(); ?>
</div>
<?php require_once ROOT . '/views/layouts/footer.php'; ?>