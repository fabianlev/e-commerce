<?php
require_once('./init/init.php');
ob_start();
if (file_exists(ROOT . (isset($_GET['rub']) ? $_GET['rub'] : 'home') . '.php') || !preg_match("#^[a-zA-Z0-9\-\_\/]+$#", isset($_GET['rub']))) {
    include(ROOT . (isset($_GET['rub']) ? $_GET['rub'] : 'home') . '.php');
} else {
    $_GET['rub'] = "404";
    include(ROOT . (isset($_GET['rub']) ? $_GET['rub'] : $_GET['rub']) . '.php');
}
$content = ob_get_clean();
require_once('./include/header.php');
echo $content;
require_once('./include/footer.php');