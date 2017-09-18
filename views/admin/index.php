<?php require_once ROOT . '/views/layouts/header.php'; ?>
<div class="text-center btn-primary register"><h2>Admin Panel:</h2></div>
<div class="register">
    <div class="row">
        <br>
        <ul class="text-center">
            <li class="btn btn-primary register"><a href="/users/allFunctions/"><h4>Users</h4></a></li><br>
            <li class="btn btn-primary register"><a href="/users/feedback/"><h4>Feedback(<?php echo $total;?>)</h4></a></li><br>
            <li class="btn btn-primary register"><a href="/addNews"><h4>Добавление новостей на сайте</h4></a></li><br>
            <li class="btn btn-primary register"><a href="/addCategory"><h4>Добавление категории в роздел Форум</h4></a></li><br>
            <li class="btn btn-primary register"><a href="/addCategoryWait"><h4>Категории ожидающие добавления(<?php echo $countAddCategory;?>)</h4></a></li><br>
        </ul>
    </div>
    <br>
    <br>
    <br>
</div>
<?php require_once ROOT . '/views/layouts/footer.php'; ?>