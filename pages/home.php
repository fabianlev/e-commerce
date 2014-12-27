<?php $last4 = $db->find('items', 'all', ['limit' => 4, 'order' => ['created DESC']]); ?>
<div class="container">

    <div id="carousel-example-generic" class="carousel slide">
    <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            <li data-target="#carousel-example-generic" data-slide-to="3"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
        <!-- Item -->
            <?php foreach($last4 as $key => $item): ?>
                <div class="item <?= $key == 0 ? 'active' : '' ?> animated fadeInRight">
                    <img src="./design/img/back1.jpg" alt="" class="img-responsive" />

                    <div class="carousel-caption">
                        <img src="<?= COMIC . $item->img; ?>" alt="<?= $item->name; ?> cover" class="img-responsive cover" />
                        <h2 class="animated fadeInLeftBig"><a href="./?rub=item&id=<?= $item->id; ?>"><?= $item->name; ?></a></h2>
                        <p class="animated fadeInRightBig"><?= $item->short_description; ?></p>
                        <a href="./addCart.php?item=<?= $item->id; ?>" class="animated fadeInLefttBig btn btn-info btn-lg addCart">Achetez maintenant</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
            <span class="icon-next"></span>
        </a>
    </div>
    <!-- carousel ends -->
</div>
<div class="hero">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Catchy title -->
                <h3>Bienvenue sur <span class="color">E-Comics</span>, le site d'achat de Comics!</h3>
                <p>Vous trouverez sur ce site tous les comics donc vous rêvez ! Que ce soit dans l'univers DC ou Marvel, tout se trouve sur cette boutique en ligne !</p>
            </div>
        </div>
        <div class="sep-bor"></div>
    </div>
</div>
<div class="shop-items blocky">
    <div class="container">

        <div class="row">
            <!-- Item #1 -->
            <?php
            foreach ($last4 as $item): ?>
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="item">
                        <!-- Item image -->
                        <div class="item-image">
                            <a href="?rub=item&id=<?= $item->id; ?>"><img src="<?= COMIC . $item->img; ?>" alt="" class="img-responsive"/></a>
                        </div>
                        <!-- Item details -->
                        <div class="item-details">
                            <!-- Name -->
                            <h5><a href="?rub=item&id=<?= $item->id; ?>"><?= $item->name; ?></a></h5>
                            <div class="clearfix"></div>
                            <!-- Para. Note more than 2 lines. -->
                            <p><?= truncate($item->short_description, 30, '...'); ?></p>
                            <hr />
                            <!-- Price -->
                            <div class="item-price pull-left"><?= number_format($item->price, 2); ?> €</div>
                            <!-- Au panier ! -->
                            <div class="pull-right"><a href="./addCart.php?item=<?= $item->id; ?>" class="btn btn-danger btn-sm addCart">Au panier !</a></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>