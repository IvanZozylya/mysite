<title>Добавление категории</title>
<?php require_once ROOT . '/views/layouts/header.php' ?>
<?php if($result): ?>
    <h2>Тема была добавлена!</h2>
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
            <input type="datetime" class="hidden" name="date" placeholder="Имя" value="<?php echo $data;?>"/>
            <input type="text" class="hidden" name="current_user_id" value="<?php echo $userId;?>">
            <input type="text" class="hidden" name="current_category_id" value="<?php echo $categoryId;?>">
            <input type="text" class="hidden" name="image" value="<?php echo $imageCategory;?>">
            <label for="title">Заголовок:  </label><br>
            <textarea name="title"  cols="30" rows="3" id="title" ><?php if(isset($_POST['submit']))echo $_POST['title']?></textarea><br>
            <input type="submit" name="submit" class="btn btn-success" value="Добавить" />
        </form>
    </div>
<?php endif; ?>

<?php require_once ROOT . '/views/layouts/footer.php' ?>

