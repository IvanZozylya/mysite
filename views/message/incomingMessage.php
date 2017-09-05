<?php require_once ROOT . '/views/layouts/header.php'; ?>
<h3>Входящие сообщения</h3>
<div class="container">
    <div class="row">
        <div class="col-sm-offset-0 padding-right">
            <ul>
                <h4>
                    <li><a href="/cabinet/<?php echo $userId; ?>/"><h4>Моя страница</h4></a></li>
                </h4>
                <h4>
                    <li><a href="/message/new/">Новые(<?php echo $countNew; ?>)</a></li>
                </h4>
                <h4>
                    <li><a href="/message/incoming/">Входящие(<?php echo $countNew; ?>)</a></li>
                </h4>
                <h4>
                    <li><a href="">Отправленные(<?php echo $countFrom; ?>)</a></li>
                </h4>
            </ul>
        </div>
    </div>
</div>
<table border="1" class="col-sm-offset-4 padding-right">
    <tr>
        <td style="padding: 10px">Сообщение:</td>
        <td>От кого:</td>
    </tr>
    <?php foreach ($newMessage as $message) : ?>
        <tr>
            <td style="padding: 10px">
                <?php echo $message['text']; ?>
            </td>
            <?php foreach ($users as $usOne) :?>
            <?php if($usOne['id'] == $message['userFrom']) :?>
            <td>
                <?php echo $usOne['name'];?>
            </td>
                <?php endif;?>
            <?php endforeach;?>
        </tr>
    <?php endforeach; ?>

</table>
<?php require_once ROOT . '/views/layouts/footer.php'; ?>
