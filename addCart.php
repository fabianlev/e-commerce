<?php require_once('./init/init.php');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
    $json = array('error' => true);
    if(isset($_GET['item']) && is_numeric($_GET['item'])){
        if(isset($_GET['quantity']) && is_numeric($_GET['quantity'])){
            $quantity = $_GET['quantity'];
        } else {
            $quantity = 1;
        }
        $item = $db->find('items', 'first', array('fields' => array('id'),'conditions' => array('id' => $_GET['item'])));
        // SELECT id FROM items WHERE id = $_GET['id'] LIMIT 1
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
