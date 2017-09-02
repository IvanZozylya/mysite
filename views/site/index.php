<title>Главная</title>
<?php include_once(ROOT . '/views/layouts/header.php'); ?>
<div class="container">
    <div class="row otstup">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" style="width: 800px">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                </ol>
                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item active">
                        <img src="/template/images/slider/cybersport_.jpg" width="800" alt="...">
                        <div class="carousel-caption">
                        </div>
                    </div>

                    <div class="item">
                        <img src="/template/images/slider/large.jpg" width="800" alt="...">
                        <div class="carousel-caption">
                        </div>
                    </div>

                    <div class="item">
                        <img src="/template/images/slider/asd.jpg" width="800" alt="...">
                        <div class="carousel-caption">

                        </div>
                    </div>
                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
<?php include_once(ROOT . '/views/layouts/footer.php'); ?>