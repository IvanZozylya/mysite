<title>Поиск <?php echo $pageCategory;?></title>
<?php require_once ROOT . '/views/layouts/header.php'; ?>

<?php
echo "<h1 class='text-center btn-primary'>Результаты поиска $pageCategory</h1>";
if (isset($countResults)) {
    echo "<h4>Найдено : <b class='btn btn-primary'>$countResults</b></h4>";
}
if ($results === false) {
    echo "<b>Вы задали пустой запрос</b><br/>";
}
?>

<!--ПОИСК по новостям -->
<?php if ($_SESSION['searchPage'] == 'news') : ?>
    <?php if (count($results) == 0) : ?>
        <p><b>Ничего не найдено</b></p>
    <?php elseif (count($results) > 0 && is_array($results)) : ?>
        <?php foreach ($results as $resultNews) : ?>
            <div class="text-center">

                <h3>
                    <div class="btn-default"><a href="/news/<?php echo $resultNews['id']; ?>">
                            <img src="<?php echo $resultNews['image'];?>" alt="" width="60" height="50"><?php echo $resultNews['title'];?></a></div></h3>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>

<!--ПОИСК по темам -->
<?php if ($_SESSION['searchPage'] == 'forum') : ?>
    <?php if (count($results) == 0) : ?>
        <p><b>Ничего не найдено</b></p>
    <?php elseif (count($results) > 0 && is_array($results)) : ?>
        <?php foreach ($results as $resultTema) : ?>
            <div class="text-center">
                <h3>
                    <div class="btn-default"><a href="/category/<?php echo $_SESSION['category']; ?>/item/<?php echo $resultTema['id']; ?>">
                            <img src="<?php echo $resultTema['image'];?>" alt="" width="36" height="36"><?php echo $resultTema['title'] ?></a></div>
                    </h3>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>

<!--ПОИСК по категориям -->
<?php if ($_SESSION['searchPage'] == 'category') : ?>
    <?php if (count($results) == 0) : ?>
        <p><b>Ничего не найдено</b></p>
    <?php elseif (count($results) > 0 && is_array($results)) : ?>
        <?php foreach ($results as $resultCategory) : ?>
            <div class="text-center">
                <h3>
                    <div class="btn-default"><a href="/category/<?php echo $resultCategory['id']; ?>">
                            <img src="<?php echo $resultCategory['image'];?>" alt="" width="36" height="36"><?php echo $resultCategory['title'];?></a></div>
                    </h3>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>

<!--ПОИСК по ПОЛЬЗОВАТЕЛЯМ -->
<?php if ($_SESSION['searchPage'] == 'user') : ?>
    <?php if (count($results) == 0) : ?>
        <p><b>Ничего не найдено</b></p>
    <?php elseif (count($results) > 0 && is_array($results)) : ?>
        <?php foreach ($results as $resultUser) : ?>
            <div class="text-center">
                <h3>
                    <div class="btn-default"><a href="/cabinet/<?php echo $resultUser['id']; ?>">
                            <?php echo $resultUser['name'];?>
                            <?php if($resultUser['online']==1)echo "<b class='btn-success'>Online</b>";?>
                            <?php if($resultUser['online']==0)echo "<b class='btn-danger'>Offline</b>";?>
                        </a></div>
                    </h3>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>

<?php require_once ROOT . '/views/layouts/footer.php'; ?>
