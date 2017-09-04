<?php require_once ROOT . '/views/layouts/header.php'; ?>
<div><a href="/cabinet/<?php echo $userId; ?>/"><h4>Вернуться</h4></a></div>
<h1>Мои Сообщения</h1>
<div class="container">
    <div class="row">
        <div class="col-sm-1 col-sm-offset-0 padding-right">
            <ul>
                <h3><li><a href="/message/new/">Новые(<?php echo $countNew;?>)</a></li></h3>
                <h3><li><a href="">Входящие(<?php echo $countTo;?>)</a></li></h3>
                <h3><li><a href="">Отправленные(<?php echo $countFrom;?>)</a></li></h3>
            </ul>
        </div>
    </div>
</div>
<?php require_once ROOT . '/views/layouts/footer.php'; ?>
