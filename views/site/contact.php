<title>Обратная связь</title>
<?php include ROOT . '/views/layouts/header.php'; ?>
<div class="register">
    <link href='https://fonts.googleapis.com/css?family=Ubuntu:500' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/template/css/style.css">
    <div class="login">

        <?php if ($result): ?>
            <p class="h3">Сообщение отправлено! Мы ответим Вам на указанный email.</p>
        <?php else: ?>
        <?php if (isset($errors) && is_array($errors)): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li> - <?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div class="login-header">
            <h1>Обратная связь</h1>
            <h5>Есть вопрос? Напишите нам</h5>
        </div>
        <div class="login-form">
            <form action="" method="post">
                <h3>Ваша почта:</h3>
                <input type="email" name="userEmail" placeholder="Email" value="<?php echo $userEmail; ?>"/><br>
                <h3>Сообщение:</h3>
                <input type="text" name="userText" placeholder="Message" value="<?php echo $userText; ?>"/>
                <br>
                <input type="submit" name="submit" value="Отправить" class="login-submit"/>
                <br>
            </form>
        </div>
        <?php endif; ?>
    </div>
    <br>
    <br>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>

    <script src="/template/js/index.js"></script>
</div>

<?php include ROOT . '/views/layouts/footer.php'; ?>