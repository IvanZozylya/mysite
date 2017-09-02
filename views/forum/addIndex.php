<title>Добавление категории</title>
<?php require_once ROOT . '/views/layouts/header.php' ?>
<div><a href="/forum"><h4>Вернуться</h4></a></div>
<?php if($result): ?>
    <h3>Категория была отправлена на рассмотрение админу, ожидайте!</h3>
<?php else: ?>
    <?php if(isset($errors)&&is_array($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li> - <?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <div class="signup-form">
        <h2>Добавление Категории</h2>
        <form action="#" method="post" enctype="multipart/form-data">
            <input type="datetime" class="hidden" name="date" placeholder="Имя" value="<?php echo $date;?>"/>
            <label for="title">Заголовок:  </label><br>
            <input type="text" name="title" id="title" value="<?php if(isset($_POST['submit']))echo $_POST['title']?>"><br>
            <label for="short_content">Содержимое: </label><br>
            <textarea name="short_content"  cols="40" rows="10" id="short_content" ><?php if(isset($_POST['submit']))echo $_POST['short_content']?></textarea><br>
            <input type="hidden" name="MAX_FILE_SIZE" value="120000" />
            <input type="file" name="userfile"  accept="image/png" id="">
            <input type="submit" name="submit" class="btn btn-success" value="Добавить" />
        </form>
    </div>
<?php endif; ?>

<?php require_once ROOT . '/views/layouts/footer.php' ?>
