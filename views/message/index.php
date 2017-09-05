<?php require_once ROOT . '/views/layouts/header.php'; ?>
<h1>Мои Сообщения</h1>
<div class="container">
    <div class="row">
        <div class="col-sm-offset-0 padding-right">
            <ul>
                <h4><li><a href="/cabinet/<?php echo $userId; ?>/"><h4>Моя страница</h4></a></li></h4>
                <h4><li><a href="/message/new/">Новые(<?php echo $countNew;?>)</a></li></h4>
                <h4><li><a href="/message/incoming/">Входящие(<?php echo $countNew;?>)</a></li></h4>
                <h4><li><a href="">Отправленные(<?php echo $countFrom;?>)</a></li></h4>
            </ul>
        </div>
    </div>
</div>
<?php require_once ROOT . '/views/layouts/footer.php'; ?>
