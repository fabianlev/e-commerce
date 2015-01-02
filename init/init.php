<?php
require_once('functions.php');
require_once('./Class/Database.php');
require_once('./Class/Session.php');
require_once('./Class/Cart.php');
require_once('./Class/Paypal.php');

$db = new Database();
$session = new Session($db);
$cart = new Cart($db);

define("ROOT", "./pages/");
define("AJAX", "./ajaxPages/");
define("COMIC", "./design/img/items/");
define("PPUSER", "admin_api2.kareylo.dev");
define("PPPWD", "ZXVMMLZ5WWLGJQFY");
define("PPSIGNATURE", "AUWBAalPC8p3nAKf1DlAw0sn1gqiADU1Wv5kqBBZY2YxgIVb0GEFcq68");