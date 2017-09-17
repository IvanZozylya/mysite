<?php require_once ROOT . '/views/layouts/header.php'; ?>
<a href="/otherUsers/"><h3 class="btn btn-success fa fa-users"> Всего пользователей : <?php echo $total;?></h3></a>
<div class="register">
    <table  class="table table-bordered" border="1" class="col-sm-4 col-sm-offset-4 padding-right text-center">
    <?php foreach ($allUsers as $users) : ?>
        <tr>
            <td style="padding: 10px"><a href="/cabinet/<?php echo $users['id']; ?>"><i class="btn btn-default fa fa-user">
                        <b><?php echo $users['name'] ?></b></i></a>
            </td>
            <td>
                <b><a href="/message/view/<?php echo $users['id']?>/" class="btn btn-primary icon-message"> Написать сообщение</a></b>
            </td>
        </tr>
    <?php endforeach; ?>
    </table>
</div>

<div class="col-md-4 col-md-offset-5">
    <?php echo $pagination->get(); ?>
</div>
<?php require_once ROOT . '/views/layouts/footer.php'; ?>
