<?php require_once ROOT . '/views/layouts/header.php'; ?>
<div class="container">
    <div class="row">
        <div class="text-center">
            <?php if ($result): ?>
                <h3>Сообщение отправлено!</h3>
            <?php else: ?>
        <?php if (isset($errors) && is_array($errors)) : ?>
                <?php foreach ($errors as $error) : ?>
                        <div class="alert-danger"><?php echo $error; ?></div>

                <?php endforeach; ?>

        <?php endif; ?>


            <form action="" method="post">
                <input type="datetime" class="hidden" name="date" placeholder="Имя" value="<?php echo $date; ?>"/>

                <?php foreach ($users as $us) : ?>
                    <?php if ($messageItem['userFrom'] == $us['id']) : ?>
                        <label for="userFrom">От: <?php echo $us['name']; ?> </label><br>
                    <?php endif; ?>
                <?php endforeach; ?>
                <input type="text" class="hidden" name="userTo" value="<?php echo $messageItem['userFrom']; ?>">
                <input type="text" class="hidden" name="userFrom" value="<?php echo $messageItem['userTo']; ?>">
                <label for="">Содержимое: </label><br>
                <h4 class="alert"><?php echo $messageItem['text']; ?></h4>
                <label for="userTo">Написать сообщение: </label><br>
                <textarea name="text" id="" cols="40" wrap="" rows="6" required class="form-control">
                    <?php if (isset($_POST['submit'])) echo $_POST['text']; ?>
                </textarea><br>
                <input type="submit" name="submit" class="btn btn-primary" value="Ответить"/>
            </form>
            <?php endif;?>
        </div>
    </div>
</div>
<?php require_once ROOT . '/views/layouts/footer.php'; ?>
