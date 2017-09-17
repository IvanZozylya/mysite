<?php require_once ROOT . '/views/layouts/header.php'; ?>
<div class="register text-center">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <ul>
                <h4 class="text-center">
                    <li class="btn btn-default"><a href="/user/online/1">User Online</a></li>
                    <li class="btn btn-default"><a href="/user/online/0">User Offlane</a></li>
                </h4>
            </ul>
            <h3><?php if ($categoryId == 1)
                    echo "<b class='btn btn-success'>Users Online : " . $total . "</b>";
                elseif ($categoryId == 0) {
                    echo "<b class='btn btn-danger'>Users Offline: " . $total . "</b>";
                } else {
                    echo "Эти данные недоступны";
                } ?></h3>
            <?php foreach ($userOnline as $online) : ?>
                <ul>
                    <li><h4><b class="btn-default"><a
                                        href="/cabinet/<?php echo $online['id']; ?>"><?php echo $online['name']; ?>
                                    <?php if ($online['online'] == 1) echo "<b class='btn-success'>Online</b>";
                                    elseif ($categoryId == 0) {
                                        echo "<b class='btn-danger'>Offline</b>";
                                    } ?></a></b></h4></li>
                </ul>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div class="col-md-4 col-md-offset-4">
    <?php echo $pagination->get(); ?>
</div>

<?php require_once ROOT . '/views/layouts/footer.php'; ?>