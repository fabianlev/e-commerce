<?php
if(isset($_SESSION['Auth']['id']))
    $session->destroy();
header('Location: ./');