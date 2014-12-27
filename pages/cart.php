<?php
// 34:51
$keys = array_keys($products = $session->get('cart'));
$items = $db->find('items', 'all', ['conditionIn' => ['id' => implode(', ', $keys)]]);
if(isset($_GET['del'])) {
    $quantity = isset($_GET['quantity']) ? $_GET['quantity'] : 1;
    $cart->remove($_GET['del'], $quantity);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

if(isset($_POST['cart']['quantity'])){
    $cart->refresh();
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>
<div class="page-title">
    <div class="container">
        <h2><i class="fa fa-desktop color"></i> Mon Panier</h2>
        <hr />
    </div>
</div>

<div class="view-cart blocky">
    <div class="container">
        <?php if(!empty($items)){ ?>
            <div class="row">
                <div class="col-md-12">
                    <form action="./?rub=cart" method="post">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Image</th>
                                <th>Quantité</th>
                                <th>Prix Unitaire</th>
                                <th>Total</th>
                                <th>Options</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php foreach ($items as $key => $item): ?>
                                <tr>
                                    <td><?= $key+1; ?></td>
                                    <td><a href="./?rub=item&id=<?= $item->id; ?>"><?= $item->name; ?></a></td>
                                    <td><a href="./?rub=item&id=<?= $item->id; ?>"><img src="<?= COMIC . $item->img; ?>" alt="" class="img-responsive"/></a></td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" name="cart[quantity][<?= $item->id; ?>]" class="form-control" value="<?= $products[$item->id] ?>">
                                        </div>
                                    </td>
                                    <td><?= number_format($item->price, 2); ?> €</td>
                                    <td><?= number_format($item->price * $_SESSION['cart'][$item->id], 2); ?> €</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="./?rub=cart&del=<?= $item->id; ?>&quantity=all" class="btn btn-danger"><i class="fa fa-remove"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>Total</th>
                                <th><?= $cart->total(); ?> €</th>
                            </tr>
                            </tbody>
                        </table>

                        <div class="row">
                            <div class="span4 offset8">
                                <div class="pull-right btn-group">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-refresh"></i> Recalculer</button>
                                    <a href="./?rub=cart&del=all" class="btn btn-danger">Vider le panier</a>
                                    <a href="./?rub=items" class="btn btn-info">Continuer mes Achats</a>
                                    <a href="./?rub=checkout" class="btn btn-warning">Payer</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php } else { ?>
            <div class="alert alert-danger" role="alert">
                Votre panier est vide. <a href="./?rub=items">Faire des achats</a>
            </div>
        <?php } ?>
    </div>
</div>