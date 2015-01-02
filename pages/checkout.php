<?php if(!empty($_SESSION['cart']) && isset($_SESSION['Auth']['id'])):
    $url = false;
    $paypal = new Paypal();
    $site =  'http://' . $_SERVER['SERVER_NAME'] . str_replace('index.php', '', $_SERVER['PHP_SELF']);
    $params = [
        'RETURNURL' => $site . '?rub=process',
        'CANCELURL' => $site . '?rub=cancel',
        'PAYMENTREQUEST_0_AMT' => $cart->total('.', ''),
        'PAYMENTREQUEST_0_CURRENCYCODE' => 'EUR',
        'PAYMENTREQUEST_0_ITEMAMT' => $cart->total('.', ''),
    ];
    $params = array_merge($params, $cart->getPaypalParams());
    $response = $paypal->request('SetExpressCheckout', $params);
    if($response){
        $_SESSION['Order'] = $session['cart'];
        $url = 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&useraction=commit&token=' . $response['TOKEN'];
        $user = $_SESSION['Auth'];
        $order = $db->find('orders', 'count') + 1; ?>
        <div class="page-title">
             <div class="container">
                <h2><i class="fa fa-desktop color"></i> Information sur la commande <small>#<?= $order; ?></small></h2>
                <hr />
             </div>
        </div>

        <div class="checkout">
             <div class="container view-cart">
                <h4>Détail sur l'envoie et la facture</h4>
                <br />
                <form class="form-horizontal" role="form" method="post" action="./?rub=checkout" >
                    <div class="address">
                        <address>
                            <?php if(!empty($user->address) && !empty($user->number) && !empty($user->zip) && !empty($user->city) && !empty($user->phone)): ?>
                                <?= $user->address . ' ' .  $user->number; ?><br>
                                <?= $user->zip . ' ' . $user->city; ?><br>
                                <?= $user->country; ?><br>
                                <!-- Phone number -->
                                <abbr title="Téléphone"><span class="fa fa-phone"></span></span> :</abbr> <?= $user->phone; ?>.<br />
                            <?php else: ?>
                                Les informations de votre compte paypal seront prisent en compte.
                            <?php endif; ?>
                        </address>
                    </div>

                    <hr />
                    <h4>Information de payement</h4>
                    <?php $items = $cart->getItems('Order'); ?>
                    <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Image</th>
                                <th>Quantité</th>
                                <th>Prix Unitaire</th>
                                <th>Total</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php foreach ($items as $key => $item): ?>
                        <tr>
                            <td><?= $key+1; ?></td>
                            <td><a href="./?rub=item&id=<?= $item->id; ?>"><?= $item->name; ?></a></td>
                            <td><a href="./?rub=item&id=<?= $item->id; ?>"><img src="<?= COMIC . $item->img; ?>" alt="" class="img-responsive"/></a></td>
                            <td><?= $_SESSION['cart'][$item->id]; ?></div>
                            </td>
                            <td><?= number_format($item->price, 2, '.', ''); ?> €</td>
                            <td><?= number_format($item->price * $_SESSION['cart'][$item->id], 2, '.', ''); ?> €</td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <th></th><th></th><th></th><th></th>
                        <th>Total</th>
                        <th><?= $cart->total('.', ''); ?> €</th>
                    </tr>
                    </tbody>
                    </table>
                    <hr />
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <input type="hidden" value="<?= $cart->total('.', ''); ?>" name="total" />
                            <a href="<?= $url; ?>" type="submit" class="btn btn-danger">Confirmer la commande</a>
                        </div>
                    </div>
                </form>

             </div>
        </div>
    <?php } else {
        header('Location: ./?rub=cart');
    }
endif;
