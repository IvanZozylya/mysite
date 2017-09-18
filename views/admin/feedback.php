<?php require_once ROOT . '/views/layouts/header.php'; ?>
<div class="register">
    <h1 class="text-center btn-primary">FeedBack</h1><br>
    <?php if ($total == 0): ?>
        <h2 class="text-center">Для вас нет новых сообщений</h2>
    <?php else : ?>
        <table class="table table-bordered" style="color: black">
        <tr>
            <td><b>Message:</b></td>
            <td><b>Date:</b></td>
            <td><b>Email:</b></td>
            <td><b>Удаление:</b></td>
        </tr>
        <?php foreach ($feedbackList as $message) : ?>
            <tr>
                <td>
                    <?php echo $message['message'];?>
                </td>
                <td>
                    <?php echo $message['date'];?>
                </td>
                <td>
                    <?php echo $message['email'];?>
                </td>
                <td>
                    <a href="/user/feedback/delete/<?php echo $message['id'];?>" class="conf" style="color: blue">Delete</a>
                </td>
            </tr>
            <?php endforeach;?>
            </table>
        <?php endif; ?>
    <br>
    <br>
    <br>
    <div class="col-md-4 col-md-offset-4">
        <?php echo $pagination->get(); ?>
    </div>
</div>
<script>
    $("document").ready(function () {
        $(".conf").click(function () {
            var conf = confirm("Удалить запись?");
            if (conf == true) {
                alert("Запись была удалена");
            }
            if (conf == false) {
                return false;
            }
        });

    })
</script>
<?php require_once ROOT . '/views/layouts/footer.php'; ?>
