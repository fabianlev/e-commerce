<?php
class Cart {

    private $db;
    private $cart;

    public function __construct($db){
        if(!isset($_SESSION)){
            session_start();
        }
        if(!isset($_SESSION['cart'])){
            $_SESSION['cart'] = [];
        }

        $this->db = $db;
    }

    public function total(){
        $total = 0;
        $keys = array_keys($products = $_SESSION['cart']);
        $items = $this->db->find('items', 'all', ['conditionIn' => ['id' => implode(', ', $keys)]]);
        foreach ($items as $item) {
            $total += $_SESSION['cart'][$item->id] * $item->price;
        }
        return number_format($total, 2, ',', ' ');
    }

    public function countItems(){
        $count = array_sum($_SESSION['cart']);
       if($count == 0){
           $str = '';
       } elseif($count == 1){
           $str = '1 objet - ';
       } else {
           $str = $count . ' objets - ';
       }
        return $str;
    }

    public function refresh(){
        foreach ($_SESSION['cart'] as $id => $quantity) {
            if(isset($_SESSION['cart'][$id])){
                if($_POST['cart']['quantity'][$id] == 0) {
                    unset($_SESSION['cart'][$id]);
                } else {
                    $_SESSION['cart'][$id] = $_POST['cart']['quantity'][$id];
                }
            }
        }
    }

    public function add($id, $quantity = 1){
        if(isset($_SESSION['cart'][$id])){
            $_SESSION['cart'][$id] += $quantity;
        } else {
            $_SESSION['cart'][$id] = $quantity;
        }
    }

    public function remove($id, $quantity = 1){
        if(is_numeric($id)) {
            if (($quantity == $_SESSION['cart'][$id]) || $quantity == 'all') {
                unset($_SESSION['cart'][$id]);
            } else {
                $_SESSION['cart'][$id] -= $quantity;
            }
        } elseif ($id == "all"){
            unset($_SESSION['cart']);
            $_SESSION['cart'] = array();
        }
    }

    public function getModal() {
        $str = '';
        if(empty($_SESSION['cart'])):
            $str .= 'Votre panier est vide';
        else:
            $str .= '<table class="table table-striped table-hover"><thead><tr><th>Nom</th><th>Quantité</th><th>Prix</th></tr></thead><tbody>';
            $keys = array_keys($products = $_SESSION['cart']);
            $items = $this->db->find('items', 'all', ['conditionIn' => ['id' => implode(', ', $keys)]]);
            foreach ($items as $item):
                $str .= '<tr><td><a href="./?rub=item&id=' . $item->id . '">' . $item->name . '</a></td><td>' . $_SESSION['cart'][$item->id] . '</td><td>' . $item->price . ' €</td></tr>';
            endforeach;
            $str .= '<tr><th></th><th>Total</th><th>' . $this->total() . ' €</th></tr></tbody></table>';
        endif;
        return $str;
    }

    public function get($key = 'cart'){
        return $_SESSION[$key];
    }
}