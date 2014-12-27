<?php
if(isset($_GET['id'], $_GET['token'])){
    $count = $db->find('users', 'count', ['fields' => ['id'], 'conditions' => ['id' => $_GET['id'], 'token' => $_GET['token']]]);
    if($count){
        $db->update('users', ['token' => null, 'active' => true], $_GET['id']);
    }
}
header('Location: ./');