<?php require_once ROOT . '/views/layouts/header.php'; ?>
<?php if($result): ?>
    <h2>Новость была добавлена!</h2>
    <h2><a href="/news">Перейти к новостям</a></h2>
<?php else: ?>
<?php if(isset($errors)&&is_array($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li> - <?php echo $error; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
    <div class="signup-form register">
        <h1 class="btn-primary text-center register">Добавление Новости</h1>
        <form action="#" method="post" enctype="multipart/form-data">
            <input type="datetime" class="hidden" name="date" placeholder="Имя" value="<?php echo $date;?>"/>
            <label for="title" style="color: black" class="btn btn-primary">Заголовок: </label><br>
            <input type="text" name="title" id="title" value="<?php if(isset($_POST['submit'])) echo $_POST['title']?>"><br>
            <label for="content" style="color: black" class="btn btn-primary">Содержимое: </label><br>
            <textarea name="content"  cols="40" rows="10" id="content"><?php if(isset($_POST['submit'])) echo $_POST['content']?></textarea><br>
            <input type="hidden" name="MAX_FILE_SIZE" value="200000" />
            <input type="file" name="userfile"  accept="image/jpeg,image/png" id="" style="color: black">
            <input type="submit" name="submit" class="btn btn-success register login-submit" value="Добавить" />
        </form>
    </div>
<?php endif; ?>
<?php require_once ROOT . '/views/layouts/footer.php'; ?>