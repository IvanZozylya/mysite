<?php include ROOT . '/views/layouts/header.php'; ?>
<div class="register">
    <link href='https://fonts.googleapis.com/css?family=Ubuntu:500' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/template/css/style.css">
    <div class="login">
            <?php if ($result): ?>
                <h3>Данные отредактированы!</h3>
            <?php else: ?>
                <?php if (isset($errors) && is_array($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li> - <?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <div class="login-header">
                    <h1>Редактирование данных</h1>
                </div>
                <div class="login-form">
                    <form action="" method="post">
                        <h3>Имя:</h3>
                        <input type="text" class="form-control" name="name" placeholder="Имя"
                               value="<?php echo $name; ?>"/><br>
                        <h3>Пароль:</h3>
                        <input type="password" class="form-control" name="password" placeholder="Пароль"
                               value="<?php echo $password; ?>"/>
                        <br/>
                        <input type="submit" name="submit" class="btn btn-primary login-submit" value="Go"/>
                        <br>
                    </form>
                </div>
            <?php endif; ?>
    </div>
        <br/>
        <br/>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>

    <script src="/template/js/index.js"></script>
    </div>


<?php include ROOT . '/views/layouts/footer.php'; ?>