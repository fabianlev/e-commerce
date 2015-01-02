<?php
if(isset($_GET['id'], $_GET['token'])){
    $user = $db->find('users', 'first', ['fields' => ['id', 'mail', 'password'], 'conditions' => ['id' => $_GET['id'], 'token' => $_GET['token']]]);
    if(!empty($user)){
        $db->update('users', ['token' => null, 'active' => true], $_GET['id']);
        $login['mail'] = $count->mail;
        $login['password'] = $session->decrypt($count->password);
        $session->login($login);
    } else {
        echo 'Vous avez entrez un id et/ou un token non valide';
    }
}
header('Location: ./');