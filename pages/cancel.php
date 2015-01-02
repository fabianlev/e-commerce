<?php
    if(isset($_GET['delete']) && $_GET['delete'] == 'true'){
        $cart->remove('all');
        header('Location: ./');
    }
    ?>
<div class="page-title">
    <div class="container">
        <h2><i class="fa fa-shopping-cart color"></i> Vous venez d'annuler votre commande !</h2>
        <hr />
        <h5>Vu que votre commande a été annulée, voulez-vous vider votre panier ?</h5>
        <h5><a class="btn btn-success" href="./?rub=cancel&delete=true">Vider le Panier</a> - <a
                class="btn btn-primary" href="./">Retourner à l'accueil</a></h5>
        <div class="sep-bor"></div>
    </div>
</div>