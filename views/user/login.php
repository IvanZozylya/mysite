<?php require_once ROOT . '/views/layouts/header.php'; ?>
<div class="register">
    <link href='https://fonts.googleapis.com/css?family=Ubuntu:500' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/template/css/style.css">
    <div class="login">
        <?php if (isset($errors) && is_array($errors)): ?>
                <?php for ($i = 0; $i < count($errors); $i++) : ?>
                    <div class="text-center"><?php echo ($i + 1) . '.' . $errors[$i];
                        echo "<br>"; ?></div>
                <?php endfor; ?>
        <?php endif; ?>
        <div class="login-header">
            <h1>Вход на сайт</h1>
        </div>
        <div class="login-form">
            <form action="" method="post">
                <input type="datetime" class="hidden" name="date" value="<?php echo $data; ?>">
                <h3>Email:</h3>
                <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>"/><br>
                <h3>Password:</h3>
                <input type="password" name="password" placeholder="Password" value="<?php echo $password; ?>"/>
                <br>
                <input type="submit" name="submit" value="Login" class="login-submit"/>
                <br>
            </form>
        </div>

    </div>
    <br>
    <br>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>

    <script src="/template/js/index.js"></script>
</div>
<?php require_once ROOT . '/views/layouts/footer.php'; ?>

