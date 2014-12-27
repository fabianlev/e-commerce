<?php if(isset($_SESSION['Auth']['id'])): ?>
    <?php $user = $db->find('users', 'first', ['conditions' => ['id' => $_SESSION['Auth']['id']]]); ?>
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

                    <hr />

                    <h4>Mes derniers achats</h4>

                    <table class="table table-striped table-hover tcart">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Prix</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>25/08/14</td>
                                <td>4423</td>
                                <td>HTC One</td>
                                <td>530 €</td>
                                <td>Completé</td>
                            </tr>
                            <tr>
                                <td>15/02/14</td>
                                <td>6643</td>
                                <td>Sony Xperia</td>
                                <td>330 €</td>
                                <td>Envoyé</td>
                            </tr>
                            <tr>
                                <td>14/08/14</td>
                                <td>1283</td>
                                <td>Nokia Asha</td>
                                <td>230 €</td>
                                <td>En cours</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <?php header('Location: ./'); ?>
<?php endif; ?>