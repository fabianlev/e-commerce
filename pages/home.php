<?php $items = $db->find('items', 'all', array('limit' => 4, 'order' => array('created DESC'))); ?>
<div class="container">

    <?php if (isset($_SESSION['flash'])): ?>
        <br>
        <div class="row">
            <div class="container">
                <div class="alert alert-<?= $_SESSION['flash']['type'] ?>"><?= $_SESSION['flash']['message']; ?></div>
            </div>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif ?>

    <div id="carousel-example-generic" class="carousel slide">
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            <li data-target="#carousel-example-generic" data-slide-to="3"></li>
        </ol>

        <div class="carousel-inner">
            <?php foreach($items as $key => $item){ ?>
                                <!-- Permet de vérifier si c'est le premier élément -->
                <div class="item <?php echo  $key == 0 ? 'active' : '' ?> animated fadeInRight">
                    <img src="./design/img/back1.jpg" alt="" class="img-responsive" />
                    <div class="carousel-caption">
                        <img src="<?php echo COMIC . $item->img; ?>" alt="<?php echo $item->name; ?> cover" class="img-responsive cover" />
                        <h2 class="animated fadeInLeftBig"><a href="./?rub=item&id=<?php echo $item->id; ?>" class="carousel-link"><?php echo $item->name; ?></a></h2>
                        <p class="animated fadeInRightBig"><?php echo $item->short_description; ?></p>
                        <a href="./addCart.php?item=<?php echo $item->id; ?>" class="animated fadeInLeftBig btn btn-info btn-lg addCart">Achetez maintenant</a>
                    </div>
                </div>
            <?php } ?>
        </div>
        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
            <span class="icon-next"></span>
        </a>
    </div>
</div>
<div class="hero">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
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
            <?php foreach ($items as $item){ ?>
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="item">
                        <div class="item-image">
                            <a href="?rub=item&id=<?php echo $item->id; ?>"><img src="<?php echo COMIC . $item->img; ?>" alt="" class="img-responsive"/></a>
                        </div>
                        <div class="item-details">
                            <h5><a href="?rub=item&id=<?php echo $item->id; ?>"><?php echo $item->name; ?></a></h5>
                            <div class="clearfix"></div>
                            <p><?php echo truncate($item->short_description, 30, '...'); ?></p>
                            <hr />
                            <div class="item-price pull-left"><?php echo number_format($item->price, 2); ?> €</div>
                            <div class="pull-right"><a href="./addCart.php?item=<?php echo $item->id; ?>" class="btn btn-danger btn-sm addCart">Au panier !</a></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>