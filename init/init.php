<?php
require_once('functions.php');
require_once('./Class/Database.php');
require_once('./Class/Session.php');
require_once('./Class/Cart.php');

$db = new Database();
$session = new Session($db);
$cart = new Cart($db);

define("ROOT", "./pages/");
define("AJAX", "./ajaxPages/");
define("COMIC", "./design/img/items/");



