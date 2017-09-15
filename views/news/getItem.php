<title><?php echo $newsItem['title'] ?></title>
<?php include_once ROOT . "/views/layouts/header.php"; ?>

<div class="text-center btn-primary register"><h3><?php echo $newsItem['title']; ?></h3></div>
<div style="background-color: snow" class="pull-right alert"><h4 style="width: 650px"><?php echo $newsItem['content']; ?></h4></div>
<img class="pull-left" src="<?php echo $newsItem['image']; ?>" alt="" width="600" height="300">

<?php if (!empty($newsItem['video'])): ?>
    <iframe width="560" height="315" src="<?php echo $newsItem['video']; ?>" frameborder="0" allowfullscreen></iframe>
<?php endif; ?>

<?php include_once ROOT . '/views/comments_news/view.php'; ?>

<?php include_once ROOT . "/views/layouts/footer.php"; ?>
