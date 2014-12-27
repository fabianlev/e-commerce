<?php
$perPage = 12;
$current = isset($_GET['page']) && $_GET['page'] != 0 ? (int)$_GET['page'] : 1;
$pagination = ($current - 1) * $perPage;
if(isset($_GET['category']) && !empty($_GET['category']) && is_numeric($_GET['category'])){
    if($_GET['category'] <= 2){
        $items = $db->find('items', 'all', [
            'fields' =>
                ['ITEMS.id', 'ITEMS.name', 'ITEMS.description', 'ITEMS.short_description', 'ITEMS.pages', 'ITEMS.language', 'ITEMS.editor', 'ITEMS.price', 'ITEMS.img', 'ITEMS.category_id', 'CATEGORIES.name AS cat_name', 'CATEGORIES.parent_id AS cat_parent'],
            'join' => ['categories' => 'ITEMS.category_id=CATEGORIES.id'],
            'conditions' => ['CATEGORIES.parent_id' => $_GET['category']],
            'order' => ['created DESC'],
            'limit' => [$pagination, $perPage]
        ]);
        $parent = $db->find('categories', 'first', ['conditions' => ['id' => $_GET['category'], 'parent_id' => 0]]);
        $count = $db->find('items', 'count', ['join' => ['categories' => 'ITEMS.category_id=CATEGORIES.id'], 'conditions' => ['CATEGORIES.parent_id' => $_GET['category']]]);

    } else {
        $items = $db->find('items', 'all', [
            'fields' =>
                ['ITEMS.id', 'ITEMS.name', 'ITEMS.description', 'ITEMS.short_description', 'ITEMS.pages', 'ITEMS.language', 'ITEMS.editor', 'ITEMS.price', 'ITEMS.img', 'ITEMS.category_id', 'CATEGORIES.name AS cat_name', 'CATEGORIES.parent_id AS cat_parent'],
            'join' => ['categories' => 'ITEMS.category_id=CATEGORIES.id'],
            'conditions' => ['category_id' => $_GET['category']],
            'order' => ['created DESC'],
            'limit' => [$pagination, $perPage]
        ]);
        $parent = $db->find('categories', 'first', ['conditions' => ['id' => $items[0]->cat_parent, 'parent_id' => 0]]);
        $count = $db->find('items', 'count', ['join' => ['categories' => 'ITEMS.category_id=CATEGORIES.id'], 'conditions' => ['category_id' => $_GET['category']]]);
    }

} else {
    $items = $db->find('items', 'all', ['order' => ['created DESC'], 'limit' => [$pagination, $perPage]]);
    $count = $db->find('items', 'count');
}

$page = ceil ($count / $perPage);
?>

<div class="page-title">
    <div class="container">
      <h2><i class="fa fa-desktop color"></i> Catalogue <small>
              <?php if(isset($parent)): ?>
                  <?= $parent->name; ?>
                  <?php if($_GET['category'] > 2): ?>
                       - <?= $items[0]->cat_name; ?>
                  <?php endif; ?>
              <?php else: ?>
                  Complet
              <?php endif; ?>
          </small></h2>
      <hr />
    </div>
</div>

<div class="shop-items">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-push-3">

                <!-- Breadcrumb -->
                <ul class="breadcrumb">
                    <li><a href="./">Accueil</a> <span class="divider"></span></li>
                    <?php if(isset($parent)): ?>
                        <li><a href="./?rub=items&category=<?= $parent->id ?>"><?= $parent->name; ?></a> <span class="divider"></span></li>
                        <?php if($_GET['category'] > 2): ?>
                            <li><a href="./?rub=items&category=<?= $_GET['category'] ?>"><?= $items[0]->cat_name; ?></a> <span class="divider"></span></li>
                        <?php endif; ?>
                    <?php endif; ?>
                    <li>Catalogue <span class="divider"></span></li>
                </ul>
                <div class="row">
                <?php foreach ($items as $k => $item): ?>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="item">
                            <div class="item-image">
                                <a href="./?rub=item&id=<?= $item->id; ?>"><img src="<?= COMIC . $item->img; ?>" /></a>
                            </div>
                            <div class="items-details">
                                <h5><a href="./?rub=item&id=<?= $item->id; ?>"><?= $item->name; ?></a></h5>
                                <div class="clearfix"></div>
                                <p><?= truncate($item->short_description, 30, '...'); ?></p>
                                <hr />
                                <div class="item-price pull-left"><?= number_format($item->price, 2); ?> €</div>
                                <div class="pull-right"><a href="./?rub=addCart&item=<?= $item->id; ?>" class="btn btn-danger btn-sm">Au panier !</a></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>

                 <div class="row">
                    <div class="col-md-offset-4 col-md-8">
                        <?php $link = "./?rub=items"; $link .= isset($_GET['category']) ? '&category=' . $_GET['category'] : ""; ?>
                        <?= paginate($link, '&page=', $page, $current); ?>
                    </div>
                 </div>

            </div>


            <?php include('./include/item_menu.php'); ?>
        </div>

        <div class="sep-bor"></div>
    </div>
</div>