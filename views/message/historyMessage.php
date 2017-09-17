<?php require_once ROOT . '/views/layouts/header.php'; ?>
<h2 class="btn-primary">История сообщений</h2>
<div class="register">
<div class="container">
    <div class="row">
        <div class="col-sm-offset-0 padding-right">
            <h3 class="btn btn-primary register"><a href="/cabinet/<?php echo $userId; ?>/" class="icon-home" style="color: maroon"> Home</a></h3><br>

            <h3 class="btn btn-primary register"><a href="/message/incoming/" style="color: maroon" class="fa fa-envelope"> Входящие(<?php echo $countNew; ?>)</a></h3><br>

            <h3 class="btn btn-primary register"><a href="/message/history/" style="color: maroon" class="fa fa-envelope-open"> История сообщений</a></h3>

        </div>
    </div>
</div>
<form action="" method="post">
    <select name="message" id="" class="navbar-collapse">
        <option value="1" selected>Входящие</option>
        <option value="2" <?php if ($_SESSION['message'] == 'send') echo 'selected'; ?>>Отправление
        </option>
    </select>
    <input type="submit" name="submit" class="login-submit btn btn-primary" value="Получить">
</form>
<?php if (empty($message)) : ?>
    <h2 class="text-center">Здесь пусто!</h2>
<?php else: ?>
    <?php if ($_SESSION['message'] == 'send') : ?>
        <h3 class="text-center btn-primary">Список Отправленных сообщений</h3>
        <table class=" table table-bordered">
            <tr>
                <td><b>Сообщение:</b></td>
                <td><b>Когда:</b></td>
                <td><b>Кому:</b></td>
            </tr>
            <?php foreach ($message as $messageItem): ?>
                <tr>
                    <td>
                        <i class="fa fa-comment" style="color: orangered"></i> <b style="color: black"><?php echo $messageItem['text']; ?></b>
                    </td>
                    <td>
                        <i class="fa fa-calendar"> <?php echo $messageItem['date']; ?></i>
                    </td>
                    <?php foreach ($users as $user) : ?>
                        <?php if ($user['id'] == $messageItem['userTo']) : ?>
                            <td>
                                <a href="/cabinet/<?php echo $user['id'];?>" class="fa fa-user" style="color: maroon"> <?php echo $user['name']; ?></a>
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
        <h3 class="text-center btn-primary">Список Полученных сообщений</h3>
        <table class=" table table-bordered">
            <tr>
                <td><b>Сообщение:</b></td>
                <td><b>Когда:</b></td>
                <td><b>От кого:</b></td>
            </tr>
            <?php foreach ($message as $messageItem): ?>
                <tr>
                    <td>
                        <i class="fa fa-comment" style="color: orangered"></i> <b style="color: black"><?php echo $messageItem['text']; ?></b>
                    </td>
                    <td>
                        <i class="fa fa-calendar"> <?php echo $messageItem['date']; ?></i>
                    </td>
                    <?php foreach ($users as $user) : ?>
                        <?php if ($user['id'] == $messageItem['userFrom']) : ?>
                            <td>
                                <a href="/cabinet/<?php echo $user['id'];?>" class="fa fa-user" style="color: maroon"> <?php echo $user['name']; ?></a>
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
    <br>
</div>
<?php require_once ROOT . '/views/layouts/footer.php'; ?>
