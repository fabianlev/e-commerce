<footer>
        <div class="container">

            <div class="row">

                <div class="col-md-4 col-sm-4">
                    <div class="fwidget">

                        <h4>E<span class="color">-</span>Comics</h4>
                        <hr />
                        <p>Depuis des années, nous sommes des fans de comics et avons décider de partager notre passion en vendant des comics. Vous trouverez donc sur ce site tous les comics chers à notre coeur et surement au vôtre.<br>Vous pouvez nous suivre sur les réseaux sociaux suivant :</p>

                        <div class="social">
                            <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
                            <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
                            <a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-4">
                    <div class="fwidget">
                        <h4>Categories</h4>
                        <hr />
                        <ul>
                            <li><a href="./?rub=items">Toutes les catégories</a></li>
                            <li><a href="./?rub=items&category=1">Marvel</a></li>
                            <li><a href="./?rub=items&category=2">DC</a></li>
                            <li><a href="./?rub=items&category=4">Iron Man</a></li>
                            <li><a href="./?rub=items&category=9">Flash</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4 col-sm-4">
                    <div class="fwidget">

                        <h4>Nous contacter ?</h4>
                        <hr />
                        <div class="address">
                            <p><i class="fa fa-home color contact-icon"></i> Rue des Laderies 105, </p>
                            <p> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 7031 Villers-Saint-Ghislain</p>
                            <p><i class="fa fa-phone color contact-icon"></i> +32482 26 89 11</p>
                            <p><i class="fa fa-envelope color contact-icon"></i> <a href="mailto:contact@myshop.be">contact@e-comics.be</a></p>
                        </div>

                    </div>
                </div>

            </div>

            <hr />

            <div class="copy text-center">
                Copyright 2014 - 2015 &copy; - Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit, laborum.
            </div>
        </div>
    </footer>

    <span class="totop"><a href="#"><i class="fa fa-chevron-up"></i></a></span>

    <div class="modal fade" id="cart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Votre Panier</h4>
                </div>
                <div class="modal-body" id="modalCart">
                    <?php if(empty($_SESSION['cart'])): ?>
                        Votre panier est vide
                    <?php else: ?>
                        <?php $items = $cart->getItems();
                        ?>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Quantité</th>
                                    <th>Prix</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td><a href="./?rub=item&id=<?= $item->id ?>"><?= $item->name; ?></a></td>
                                    <td><?= $_SESSION['cart'][$item->id]; ?></td>
                                    <td><?= $item->price; ?> €</td>
                                </tr>
                            <?php endforeach; ?>
                                <tr>
                                    <th></th>
                                    <th>Total</th>
                                    <th><?= $cart->total(); ?> €</th>
                                </tr>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Continuer mes achats</button>
                    <a class="btn btn-default" href="./?rub=cart">Afficher le panier</a>
                    <?php if(isset($_SESSION['Auth']) && isset($_SESSION['Auth']['id'])): ?>
                        <a href="./?rub=checkout" type="button" class="btn btn-info">Payer</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="./design/js/jquery.js"></script>
    <script src="./design/js/bootstrap.min.js"></script>
    <script src="./design/js/ddlevelsmenu.js"></script>
    <script src="./design/js/jquery.countdown.min.js"></script>
    <script src="./design/js/jquery.navgoco.min.js"></script>
    <script src="./design/js/filter.js"></script>
    <script src="./design/js/respond.min.js"></script>
    <script src="./design/js/html5shiv.js"></script>
    <script src="./design/js/custom.js"></script>
    </body>
</html>