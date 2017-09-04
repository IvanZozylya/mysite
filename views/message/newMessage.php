<title>Новые сообщения</title>
<?php require_once ROOT . '/views/layouts/header.php'; ?>
<h2>Новые сообщения</h2>
<table border="1" class="col-sm-4 col-sm-offset-4 padding-right text-center">
    <tr>
        <td>Сообщение:</td>
        <td>От кого:</td>
    </tr>
    <?php foreach ($newMessageList as $newMessage) : ?>
        <tr>
            <td style="padding: 10px">
                <i><a href="/message/view/<?php echo $newMessage['id'];?>"><?php echo $newMessage['text']; ?></a></i>
            </td>
            <td>
                <i>
                    <?php foreach ($users as $user) : ?>
                        <?php if ($user['id'] == $newMessage['userFrom']) : ?>
                            <b><i><a href="/cabinet/<?php echo $user['id'];?>"><?php echo $user['name']; ?></a></i></b>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </i>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php require_once ROOT . '/views/layouts/footer.php'; ?>
