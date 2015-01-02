<?php
if(isset($_SESSION['Auth']['id'])) {
    $cart = $session->get('cart');
    $session->destroy();
    session_start();
    session_regenerate_id();
    $_SESSION['cart'] = $cart;
    $_SESSION['flash'] = array('type' => 'success', 'message' => "Vous êtes maintenant déconnecté");
}
header('Location: ./');