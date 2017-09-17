<?php require_once ROOT . '/views/layouts/header.php'; ?>
<h2 class="btn-primary">История сообщении</h2>
<div class="container">
    <div class="row">
        <div class="col-sm-offset-0 padding-right">
            <ul>
                <li><a href="/cabinet/<?php echo $userId; ?>/">Моя страница</a></li>

                <li><a href="/message/incoming/">Входящие(<?php echo $countNew; ?>)</a></li>

                <li><a href="/message/history/">История сообщений</a></li>
            </ul>
        </div>
    </div>
</div>
<form action="" method="post">
    <select name="message" id="" class="navbar-collapse">
        <option value="1" selected>Входящие</option>
        <option value="2" <?php if ($_SESSION['message'] == 'send') echo 'selected'; ?>>Отправление
        </option>
    </select>
    <input type="submit" name="submit" value="Получить">
</form>
<?php if (empty($message)) : ?>
    <h3>Здесь пусто!</h3>
<?php else: ?>
    <?php if ($_SESSION['message'] == 'send') : ?>
        <h3 class="text-center btn-default">Список Отправленных сообщений</h3>
        <table class=" table table-bordered">
            <tr>
                <td><b>Сообщение:</b></td>
                <td><b>Когда:</b></td>
                <td><b>Кому:</b></td>
            </tr>
            <?php foreach ($message as $messageItem): ?>
                <tr>
                    <td>
                        <?php echo $messageItem['text']; ?>
                    </td>
                    <td>
                        <?php echo $messageItem['date']; ?>
                    </td>
                    <?php foreach ($users as $user) : ?>
                        <?php if ($user['id'] == $messageItem['userTo']) : ?>
                            <td>
                                <a href="/cabinet/<?php echo $user['id'];?>"><?php echo $user['name']; ?></a>
                            </td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="col-md-4 col-md-offset-4">
            <?php echo $pagination->get(); ?>
        </div>
    <?php else: ?>
        <h3 class="text-center btn-default">Список Полученных сообщений</h3>
        <table class=" table table-bordered">
            <tr>
                <td><b>Сообщение:</b></td>
                <td><b>Когда:</b></td>
                <td><b>От кого:</b></td>
            </tr>
            <?php foreach ($message as $messageItem): ?>
                <tr>
                    <td>
                        <?php echo $messageItem['text']; ?>
                    </td>
                    <td>
                        <?php echo $messageItem['date']; ?>
                    </td>
                    <?php foreach ($users as $user) : ?>
                        <?php if ($user['id'] == $messageItem['userFrom']) : ?>
                            <td>
                                <a href="/cabinet/<?php echo $user['id'];?>"><?php echo $user['name']; ?></a>
                            </td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="col-md-4 col-md-offset-4">
            <?php echo $pagination->get(); ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php require_once ROOT . '/views/layouts/footer.php'; ?>
