<title>Admin Panel</title>
<?php require_once ROOT . '/views/layouts/header.php'; ?>
<div><a href="/cabinet/<?php echo $userId?>"><h4>Вернуться</h4></a></div>
<div class="text-center btn-default"><h2>Admin Panel:</h2></div>
<div class="container">
    <div class="row">
        <ul class="text-center">
            <li class="btn-default"><a href="/users/allFunctions/"><h4>Users</h4></a></li>
            <li class="btn-default"><a href="/addNews"><h4>Добавление новостей на сайте</h4></a></li>
            <li class="btn-default"><a href="/addCategory"><h4>Добавление категории в роздел Форум</h4></a></li>
            <li class="btn-default"><a href="/addCategoryWait"><h4>Категории ожидающие добавления(<?php echo $countAddCategory;?>)</h4></a></li>
        </ul>
    </div>
</div>
</div>
<?php require_once ROOT . '/views/layouts/footer.php'; ?>