<?php include_once ROOT.'/views/layouts/header.php'; ?>
<?php if(isset($errors)&&is_array($errors)) : ?>
<?php foreach ($errors as $error) : ?>
<ul>
    <li> - <?php echo $error;?></li>
</ul>
<?php endforeach; ?>
<?php endif; ?>
<div class="register">
    <h2 class="text-center btn-primary icon-message">Добавление комментариев</h2>
    <form action="#" method="post" class="text-center">
        <input type="datetime" class="hidden" name="date" placeholder="Имя" value="<?php echo $date;?>"/>
        <input type="text" class="hidden" name="current_user_id" placeholder="Пароль" value="<?php echo $userId?>"/>
        <textarea name="description" id="" cols="100" rows="5"><?php if(isset($_POST['submit']))echo $_POST['description'];?></textarea><br>
        <input type="text" class="hidden" name="news_id" value="<?php echo $id?>;">
        <input type="submit" name="submit" class="btn btn-primary" value="Добавить" />
    </form>
</div>




<?php include_once ROOT.'/views/layouts/footer.php';?>
