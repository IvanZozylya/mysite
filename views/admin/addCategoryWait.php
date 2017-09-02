<title>Ожидающие добавления</title>
<?php require_once ROOT . '/views/layouts/header.php'; ?>
<div><a href="/admin"><h4>Вернуться</h4></a></div>
<?php if($result == true) :?>
<h3>Категория успешно добавлена!</h3>
<?php else: ?>
    <?php if(isset($errors)&&is_array($errors)) :?>
        <?php foreach($errors as $error) : ?>
<ul>
    <li> - <?php echo $error?></li>
</ul>
<?php endforeach;?>
        <?php endif;?>
    <?php if(empty($categoryList)) : ?>
        <h3>Новых категорий на добавление нет</h3>
        <?php endif;?>
<?php foreach($categoryList as $category) :?>
<ul class="btn-default">
    <h4><li>Title: <?php echo $category['title'];?></li></h4>
    <h4><li>Date: <?php echo $category['date'];?></li></h4>
    <h4><li>Content: <?php echo $category['short_content'];?></li></h4>
    <li><b>Путь к картинке: <?php echo $category['image'];?></b></li>
    <h4><li>Image: <img src="<?php echo $category['image'];?>" alt="" width="36" height="36"></li></h4>
    <form action="" method="post" class="col-sm-offset-2 padding-right">
        <input type="text" name="categoryId" class="hidden" value="<?php echo $category['id'];?>">
        <input type="text" name="title" class="hidden" value="<?php echo $category['title'];?>">
        <input type="text" name="date" class="hidden" value="<?php echo $category['date'];?>">
        <input type="text" name="short_content" class="hidden" value="<?php echo $category['short_content'];?>">
        <input type="text" name="image" class="hidden" value="<?php echo $category['image'];?>">
        <input type="submit" class="btn-success conf" name="addCategory" value="Добавить">
        <input type="submit" class="btn-danger conf2" name="deleteCategory" value="Удалить">
    </form>

</ul>
<?php endforeach;?>
<?php endif?>

<script>
    $("document").ready(function () {
        $(".conf").click(function () {
            var conf = confirm("Добавить категорию?");
            if (conf == true) {
                alert("Категория была добавлена");
            }
            if (conf == false) {
                return false;
            }
        });
        $(".conf2").click(function () {
            var conf = confirm("Удалить категорию?");
            if (conf == true) {
                alert("Категория была удалена");
            }
            if (conf == false) {
                return false;
            }
        });
    });
</script>
<?php require_once ROOT . '/views/layouts/footer.php'; ?>
