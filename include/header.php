<?php !isset($_SESSION) ? header('Location: ./') : '' ; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>E-Comics</title>
        <meta name="description" content="./#">
        <meta name="keywords" content="./#">
        <meta name="author" content="">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="./design/css/bootstrap.min.css" rel="stylesheet">
        <link href="./design/css/animate.min.css" rel="stylesheet">
        <link href="./design/css/ddlevelsmenu-base.css" rel="stylesheet">
        <link href="./design/css/ddlevelsmenu-topbar.css" rel="stylesheet">
        <link href="./design/css/jquery.countdown.css" rel="stylesheet">
        <link href="./design/css/font-awesome.min.css" rel="stylesheet">
        <link href="./design/css/style.css" rel="stylesheet">

        <link rel="shortcut icon" href="./#">
    </head>
<body>

<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-sm-2">
                <!-- Logo -->
                <div class="logo">
                    <h1><a href="./">E-Comics</a></h1>
                </div>
            </div>
            <div class="col-md-6 col-sm-5">
                <!-- Navigation menu -->
                <div class="navi">
                    <div id="ddtopmenubar" class="mattblackmenu">
                        <ul>
                            <li><a href="./">Accueil</a></li>
                            <?php if(isset($_SESSION['Auth']) && isset($_SESSION['Auth']['id']) ): ?>
                                <li><a href="./#" rel="ddsubmenu1">Compte</a>
                                    <ul id="ddsubmenu1" class="ddsubmenustyle">
                                        <li><a href="./?rub=account">Mon compte</a></li>
                                        <li><a href="./?rub=cart">Voir le panier</a></li>
                                        <li><a href="./?rub=checkout">Payer</a></li>
                                        <li><a href="./?rub=orderhistory">Historique d'achat</a></li>
                                        <li><a href="./?rub=editaccount">Editer mon profil</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <li><a href="./#" rel="ddsubmenu1">Notre catalogue</a>
                                <ul id="ddsubmenu1" class="ddsubmenustyle">
                                    <li><a href="./?rub=items">Tout les comics</a></li>
                                    <li><a href="./?rub=items&amp;category=1">Marvel Comics</a></li>
                                    <li><a href="./?rub=items&amp;category=2">DC Comics</a></li>
                                </ul>
                            </li>
                            <li><a href="./?rub=contact">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Dropdown NavBar -->
                <div class="navis"></div>
            </div>

            <div class="col-md-4 col-sm-5">
                <div class="kart-links">
                    <?php if(isset($_SESSION['Auth']) && isset($_SESSION['Auth']['id'])): ?>
                        <a href="./?rub=logout">Déconnexion</a>
                    <?php else: ?>
                        <a href="./?rub=login">Connexion</a>
                        <a href="./?rub=register">Inscription</a>
                    <?php endif; ?>
                    <a data-toggle="modal" href="./#cart"><i class="fa fa-shopping-cart"></i> <span id="count"><?= $cart->countItems(); ?></span><span id="total"><?= $cart->total(); ?></span>	€</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>