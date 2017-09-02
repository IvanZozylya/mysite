<?php require_once ROOT . '/views/layouts/header.php'; ?>
    <div><a href="/admin"><h4>Вернуться</h4></a></div>
    <div class="text-center btn-default"><h2>Users Operations:</h2></div>
    <div class="container">
        <div class="row">
                <ul class="text-center">
                    <li class="btn-default"><a  href="/user/online/1"><h4>Online</h4></a></li>
                    <li class="btn-default"><a  href="/user/block/0" ><h4 class="">Блокировка</h4></a></li>
                    <li class="btn-default"><a  href="/user/delete" ><h4 class="">Удаление</h4></a></li>
                </ul>
            </div>
        </div>
    </div>

<?php require_once ROOT . '/views/layouts/footer.php'; ?>