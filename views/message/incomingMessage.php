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
                    <li><a href="/message/incoming/">Входящие(<?php echo $countNew; ?>)</a></li>
                </h4>
                <h4>
                    <li><a href="">Отправленные(<?php echo $countFrom; ?>)</a></li>
                </h4>
            </ul>
        </div>
    </div>
</div>
<?php if ($countMessage == 0) : ?>
    <h2 class="text-center">Для вас нет сообщений</h2>
<?php else: ?>
    <?php if ($countNew != 0) : ?>
        <table class="table table-bordered">
            <tr>
                <td><b>Новое Сообщение:</b></td>
                <td><b>Когда:</b></td>
                <td><b>От кого:</b></td>
                <td><b>Удалить:</b></td>
            </tr>
            <?php foreach ($newMessage as $message) : ?>
                <?php if ($message['new_message'] == 1) : ?>
                    <tr class="info">
                        <td>
                            <a href="/message/view/<?php echo $message['userFrom']; ?>">
                                <?php echo $message['text']; ?>
                            </a>
                        </td>
                        <td>
                            <?php echo $message['date'] ?>
                        </td>
                        <?php foreach ($users as $usOne) : ?>
                            <?php if ($usOne['id'] == $message['userFrom']) : ?>
                                <td>
                                    <?php echo $usOne['name']; ?>
                                </td>
                            <?php endif; ?>
                            <?php if ($usOne['id'] == $message['userFrom']) : ?>
                                <td>
                                    <a href="#/<?php echo $usOne['id']; ?>/">Удалить</a>
                                </td>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tr>
                <?php endif; ?>

            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    <table class="table table-bordered">
        <tr>
            <td><b>Сообщение:</b></td>
            <td><b>Когда:</b></td>
            <td><b>От кого:</b></td>
            <td><b>Удалить:</b></td>
        </tr>
        <?php foreach ($newMessage  as $message) : ?>
            <tr>
                <?php if ($message['new_message'] == 0) : ?>
                    <td>
                        <a href="/message/view/<?php echo $message['userFrom']; ?>">
                            <?php echo $message['text']; ?>
                        </a>
                    </td>
                    <td>
                        <?php echo $message['date']; ?>
                    </td>
                    <?php foreach ($users as $usOne) : ?>
                        <?php if ($usOne['id'] == $message['userFrom']) : ?>
                            <td>
                                <?php echo $usOne['name']; ?>
                            </td>
                        <?php endif; ?>
                        <?php if ($usOne['id'] == $message['userFrom']) : ?>
                            <td>
                                <a href="#<?php echo $usOne['id'] ?>">Удалить</a>
                            </td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
<?php require_once ROOT . '/views/layouts/footer.php'; ?>
