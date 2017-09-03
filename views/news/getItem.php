<title><?php echo $newsItem['title'] ?></title>
<?php include_once ROOT . "/views/layouts/header.php"; ?>

<?php if (isset($_SERVER['HTTP_REFERER'])) : ?>
    <?php if ($_SERVER['HTTP_REFERER'] == "http://localhost/search") : ?>
        <div><a href="/search"><h4>Вернуться</h4></a></div>
    <?php endif; ?>
<?php endif; ?>

<div class="text-center btn-primary"><h3><?php echo $newsItem['title']; ?></h3></div>
<div class="pull-right alert"><h4 style="width: 650px"><?php echo $newsItem['content']; ?></h4></div>
<img class="pull-left" src="<?php echo $newsItem['image']; ?>" alt="" width="600" height="300">

<?php if (!empty($newsItem['video'])): ?>
    <iframe width="560" height="315" src="<?php echo $newsItem['video']; ?>" frameborder="0" allowfullscreen></iframe>
<?php endif; ?>

<?php include_once ROOT . '/views/comments_news/view.php'; ?>
<?php include_once ROOT . "/views/layouts/footer.php"; ?>
