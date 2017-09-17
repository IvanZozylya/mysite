<?php require_once ROOT . '/views/layouts/header.php'; ?>
<h2 class="btn-primary">Входящие сообщения</h2>
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
<?php if ($countMessage == 0) : ?>
    <h2 class="text-center">Для вас нет сообщений</h2>
<?php else: ?>
    <?php if ($countNew != 0) : ?>
        <table class="table table-bordered">
            <tr>
                <td><b>Новое Сообщение:</b></td>
                <td><b>Когда:</b></td>
                <td><b>От кого:</b></td>
            </tr>
            <?php foreach ($newMessage as $message) : ?>
                <?php if ($message['new_message'] == 1) : ?>
                    <tr class="info">
                        <td>
                            <a href="/message/view/<?php echo $message['userFrom']; ?>" class="fa fa-comment">
                                <b style="color: black"><?php echo $message['text']; ?></b>
                            </a>
                        </td>
                        <td>
                            <i class="fa fa-calendar"> <?php echo $message['date']; ?></i>
                        </td>
                        <?php foreach ($users as $usOne) : ?>
                            <?php if ($usOne['id'] == $message['userFrom']) : ?>
                                <td>
                                    <a href="/cabinet/<?php echo $usOne['id'];?>" class="fa fa-user" style="color: maroon"> <?php echo $usOne['name']; ?></a>
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
        </tr>
        <?php foreach ($newMessage as $message) : ?>
            <tr>
                <?php if ($message['new_message'] == 0) : ?>
                    <td>
                        <a href="/message/view/<?php echo $message['userFrom']; ?>" class="fa fa-comment">
                            <b style="color: black"><?php echo $message['text']; ?></b>
                        </a>
                    </td>
                    <td>
                        <i class="fa fa-calendar"> <?php echo $message['date']; ?></i>
                    </td>
                    <?php foreach ($users as $usOne) : ?>
                        <?php if ($usOne['id'] == $message['userFrom']) : ?>
                            <td>
                                <a href="/cabinet/<?php echo $usOne['id'];?>" class="fa fa-user" style="color: maroon"> <?php echo $usOne['name']; ?></a>
                            </td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
<br>
</div>
<?php require_once ROOT . '/views/layouts/footer.php'; ?>
