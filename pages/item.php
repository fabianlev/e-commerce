<?php if(isset($_GET['id']) && !empty($_GET['id'])): ?>

    <?php
        $item = $db->find('items', 'first', [
            'fields' =>
                ['ITEMS.id', 'ITEMS.name', 'ITEMS.description', 'ITEMS.short_description', 'ITEMS.pages', 'ITEMS.language', 'ITEMS.editor', 'ITEMS.price', 'ITEMS.img', 'ITEMS.category_id', 'CATEGORIES.name AS cat_name', 'CATEGORIES.parent_id AS cat_parent'],
            'join' => ['categories' => 'ITEMS.category_id=CATEGORIES.id'],
            'conditions' => ['ITEMS.id' => $_GET['id']],
        ]);
        $parent = $db->find('categories', 'first', ['conditions' => ['id' => $item->cat_parent]]);
    ?>
    <div class="page-title">
        <div class="container">
            <h2><i class="fa fa-desktop color"></i> <?= $item->cat_name; ?></h2>
            <hr />
        </div>
    </div>

    <div class="shop-items">
        <div class="container">

            <div class="row">

                <div class="col-md-9 col-md-push-3">

                    <!-- Breadcrumb -->
                    <ul class="breadcrumb">
                        <li><a href="index.php">Accueil</a> <span class="divider"></span></li>
                        <li><a href="?rub=items">Catalogue</a> <span class="divider"></span></li>
                        <li><a href="?rub=items&category=<?= $parent->id ?>"><?= $parent->name ?><span class="divider"></span></a></li>
                        <li><a href="?rub=items&category=<?= $item->category_id ?>"><?= $item->cat_name ?><span class="divider"></span></a></li>
                        <li><?= $item->name; ?></li>
                    </ul>

                    <div class="single-item">
                        <div class="row">
                            <div class="col-md-4 col-xs-5">

                                <div class="item-image">
                                    <img src="<?= COMIC . $item->img ?>" alt="" />
                                </div>


                            </div>
                            <div class="col-md-8 col-xs-7">
                                <h4><?= $item->name; ?></h4>
                                <h5><strong>Prix : <?= number_format($item->price, 2); ?>€</strong></h5>
                                <p><strong>Frais de Port</strong> : Offert</p>
                                <p><strong>Série</strong> : <?= $item->cat_name; ?></p>

                                <div class="input-group">
                                    <input type="text" class="form-control" id="itemQuantity" name="quantity" value="1">
                                       <span class="input-group-btn">
                                         <a class="btn btn-info" href="./addCart.php?item=<?= $item->id; ?>" id="addCartQuantity">Panier!</a>
                                       </span>
                                </div><!-- /input-group -->

                                <div class="sep"></div>
                                <br><br><br>
                            </div>
                        </div>
                    </div>

                    <br />
                    <ul id="myTab" class="nav nav-tabs">
                        <li class="active"><a href="#tab1" data-toggle="tab">Description</a></li>
                        <li><a href="#tab2" data-toggle="tab">Spécificités</a></li>
                    </ul>

                    <!-- Tab Content -->
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade in active" id="tab1">
                            <h5><strong><?= $item->name; ?></strong></h5>
                            <p><?= $item->description; ?></p>
                        </div>

                        <!-- Sepcs -->
                        <div class="tab-pane fade" id="tab2">

                            <h5><strong>Product Specs:</strong></h5>
                            <table class="table table-striped">
                                <tbody>
                                <tr>
                                    <td><strong>Nom</strong></td>
                                    <td><?= $item->name; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Editeur</strong></td>
                                    <td><?= $item->editor; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Pages</strong></td>
                                    <td><?= $item->pages; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Langue</strong></td>
                                    <td><?= $item->language; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Série</strong></td>
                                    <td><?= $item->cat_name; ?></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
                <?php include('./include/item_menu.php'); ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <?php  header('Location:?rub=404'); ?>
<?php endif; ?>
