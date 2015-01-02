<?php if(isset($_SESSION['Auth']['id'])): ?>
    <?php $user = $db->find('users', 'first', ['conditions' => ['id' => $_SESSION['Auth']['id']]]); 
    $order = $db->find('orders', 'all', ['conditions' => ['user_id'=> $_SESSION['Auth']['id']]]); ?>
    <div class="page-title">
        <div class="container">
            <h2><i class="fa fa-desktop color"></i> Mon Compte <small><?= $user->name . ' ' . $user->firstname ?></small></h2>
            <hr />
         </div>
    </div>

    <div class="account-content">
        <div class="container">

            <div class="row">
                <?php include './include/account_menu.php'; ?>
                <div class="col-md-9">
                    <h3><i class="fa fa-user color"></i> &nbsp;Mon Compte</h3>
                    <!-- Your details -->
                    <div class="address">
                        <address>
                            <strong><?= $user->name . ' ' . $user->firstname ?></strong><br>
                            <?php if(!empty($user->address) && !empty($user->number) && !empty($user->zip) && !empty($user->city) && !empty($user->phone)): ?>
                                <?= $user->address . ' ' .  $user->number; ?><br>
                                <?= $user->zip . ' ' . $user->city; ?><br>
                                <?= $user->country; ?><br>
                                <!-- Phone number -->
                                <abbr title="Téléphone"><span class="fa fa-phone"></span></span> :</abbr> <?= $user->phone; ?>.<br />
                                <a href="mailto:<?= $user->mail; ?>"><?= $user->mail; ?></a>
                            <?php else: ?>
                                Merci d'éditer votre profil.
                            <?php endif; ?>
                        </address>
                    </div>
                    <?php if(!empty($order)):
                        $somme = 0;
                        foreach ($order as $key => $value) {
                            $somme += $value->amount;
                        } ?>
                        <hr />
                   
                        <h4>Vous avez effectué <?= count($order) == 1 ? count($order) . ' achat' : count($order) . ' achats'; ?> pour la somme totale de <?= $somme; ?> € </h4>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <?php header('Location: ./'); ?>
<?php endif; ?>