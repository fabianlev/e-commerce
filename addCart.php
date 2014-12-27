<?php
require_once('./init/init.php');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
    $json = array('error' => true);
    if(isset($_GET['item'])){
        $quantity = isset($_GET['quantity']) ? $_GET['quantity'] : 1;
        $item = $db->find('items', 'first', ['fields' => ['id'],'conditions' => ['id' => $_GET['item']]]);
        if(!empty($item)){
            $json['error'] = false;
            $json['message'] = "L'objet a bien été ajouté à votre panier !";
            $cart->add($item->id, $quantity);
        } else {
            $json['message'] = "Ce produit n'existe pas.";
        }
    } else {
        $json['message'] = "Vous n'avez pas sélectionné d'objet.";
    }
    $json['total'] = $cart->total();
    $json['count'] = $cart->countItems();
    $json['modal'] = $cart->getModal();
    echo json_encode($json);
} else {
    header('Location: ./');
}
