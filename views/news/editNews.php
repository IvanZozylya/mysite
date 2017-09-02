<title>Редактировать новость</title>
<?php require_once ROOT . '/views/layouts/header.php'; ?>
<?php if($result): ?>
    <h2>Новость была обновлена!</h2>
    <h2><a href="/news/<?php echo $id;?>">Перейти к новости</a></h2>
<?php else: ?>
    <?php if(isset($errors)&&is_array($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li> - <?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <div class="signup-form alert " >
        <h2>Редактировать Новость</h2>
        <form action="#" method="post" enctype="multipart/form-data">
            <label for="title">Заголовок:  </label><br>
            <textarea name="title" id="" cols="30" rows="5"><?php echo $newsItem['title']?></textarea><br>
            <label for="content">Содержимое: </label><br>
            <textarea name="content"  cols="70" rows="15" id="content"><?php echo $newsItem['content'];?></textarea><br>
            <label for="image">Картинка: <br><img src="<?php echo $newsItem['image']?>" id="image" width="510" height="200" alt=""></label>
           <br> <label for="">Выбрать новую картинку: </label>
            <input type="hidden" name="MAX_FILE_SIZE" value="200000" />
            <input type="file" name="userfile"  accept="image/jpeg,image/png" id=""><br>
            <input type="submit" name="submit" class="btn btn-success" value="Изменить" />
        </form>
    </div>
<?php endif; ?>
<?php require_once ROOT . '/views/layouts/footer.php'; ?>