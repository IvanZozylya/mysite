<?php include ROOT . '/views/layouts/header.php'; ?>

    <section>
        <div class="container">
            <div class="row">

                <div class="col-sm-4 col-sm-offset-4 padding-right">

                    <?php if($result): ?>
                        <h2>Вы зарегистрированы!</h2>
                    <?php else: ?>
                        <?php if(isset($errors)&&is_array($errors)): ?>
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li> - <?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>


                        <div class="signup-form"><!--sign up form-->
                            <h2>Регистрация на сайте</h2>
                            <form action="#" method="post">
                                <input type="text" class="form-control" name="name" placeholder="Имя" value="<?php echo $name; ?>"/>
                                <input type="email" class="form-control" name="email" placeholder="E-mail" value="<?php echo $email; ?>"/>
                                <input type="password" class="form-control" name="password" placeholder="Пароль" value="<?php echo $password; ?>"/>
                                <input type="submit" name="submit" class="btn btn-success" value="Регистрация" />
                            </form>
                        </div><!--/sign up form-->
                    <?php endif; ?>

                    <br/>
                    <br/>
                </div>
            </div>
        </div>
    </section>

<?php include ROOT . '/views/layouts/footer.php'; ?>