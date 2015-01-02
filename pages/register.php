<?php
$error = array();

if(!empty($_POST)){
    if(empty($_POST['mail'])){
        $error['mail']['empty'] = true;
    } else {
        $mail = $db->find('users', 'count', ['conditions' => ['mail' => $_POST['mail']]]);
        if($mail >= 1){
            $error['mail']['used'] = true;
        }
    }
    if(empty($_POST['name'])){
        $error['name'] = true;
    }
    if(empty($_POST['firstname'])){
        $error['firstname'] = true;
    }

    if(empty($_POST['password'])){
        $error['password'] = true;
    }

    if(empty($error)) {
        foreach ($_POST as $key => $value) {
            if(empty($value)) {
                $value = null;
            }
            $post[$key] = $value;
        }

        $token = md5(time());
        $db->insert('users', array('name' => htmlentities($post['name']), 'firstname' => htmlentities($post['firstname']), 'mail' => htmlentities($post['mail']), 'password' => htmlentities($session->encrypt($post['password'])), 'token' => $token));
        $user = $db->find('users', 'first', array('fields' => array('id'), 'conditions' => array('token' => $token)));


        $to  = $_POST['mail'];
        // Sujet
        $subject = 'Inscription à E-Comics';
        // message
        $link =  'http://' . $_SERVER['SERVER_NAME'] . str_replace('index.php', '', $_SERVER['PHP_SELF']) . "?rub=activate&amp;id=$user->id&amp;token=$token";
        $message = "<html><head><title>Inscription à E-Comics</title></head><body><p>Merci pour votre inscription sur E-Comics !</p><p>Pour activer votre compte, merci de cliquer sur le lien <a href=\"$link\">D'activation</a> ou collez ce lien dans votre barre d'adresse : $link</p></body></html>";
        // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        // En-têtes additionnels
        $headers .= 'To: '. htmlentities($_POST['name']) . ' '.  htmlentities($_POST['firstname']) . '  <' . $to . '>' . '\r\n';
        $headers .= 'From: E-Comics <contact@e-comics.be>' . '\r\n';
        // Envoi
        mail($to, $subject, $message, $headers);
        ?>
        <br>
        <div class="container">
            <div class="alert alert-success">Vous allez recevoir un mail contenant les informations pour activer votre compte. /!\ Le mail sera pris comme un "Spam"</div>
        </div>
        <?php
    }
}

if(!empty($_SESSION['Auth']['id'])){
    header('Location: ./');
    exit();
}
?>
<div class="blocky">
    <div class="container">
        <div class="row">
           <div class="col-md-6">
              <div class="reg-login-info">
                 <h2>Inscrivez-vous pour commander <span class="color">!</span></h2>
                 <img src="./design/img/back1.jpg" alt="" class="img-responsive img-thumbnail" />
                 <p>Duis leo risus, vehicula luctus nunc. Quiue rhoncus, a sodales enim arcu quis turpis. Duis leo risus, condimentum ut posuere ac, vehicula luctus nunc. Quisque rhoncus, a sodales enim arcu quis turpis.</p>
              </div>
           </div>
           <div class="col-md-6">
              <div class="register-login">
                 <div class="cool-block">
                    <div class="cool-block-bor">
                        <h3>Inscription</h3>
                        <form class="form-horizontal" role="form" method="post" action="./?rub=register">
                            <div class="form-group <?php echo isset($error['firstname']) ? 'has-error' : ''; ?>">
                                <label for="inputLastName" class="col-lg-3 control-label">Nom</label>
                                <div class="col-lg-9">
                                    <input type="text" name="firstname" class="form-control" id="inputName" placeholder="<?= isset($error['firstname']['empty']) ? 'Ce champ ne peut être vide' : 'Nom';  ?>" <?= isset($_POST['firstname']) && !empty($_POST['firstname']) ? 'value="' . $_POST['firstname'] . '"' : ''; ?>>
                                </div>
                            </div>
                            <div class="form-group <?php echo isset($error['name']) ? 'has-error' : ''; ?>">
                                <label for="inputFirstName" class="col-lg-3 control-label">Prénom</label>
                                <div class="col-lg-9">
                                    <input type="text" name="name" class="form-control" id="inputName" placeholder="<?= isset($error['name']['empty']) ? 'Ce champ ne peut être vide' : 'Prénom';  ?>"  <?= isset($_POST['name']) && !empty($_POST['name']) ? 'value="' . $_POST['name'] . '"' : ''; ?>>
                                </div>
                            </div>
                            <div class="form-group <?php echo isset($error['mail']) ? 'has-error' : ''; ?>">
                                <label for="inputEmail1" class="col-lg-3 control-label">Adresse Mail</label>
                                <div class="col-lg-9">
                                    <input type="email" name="mail" class="form-control" id="inputEmail1" placeholder="<?= isset($error['name']['empty']) ? 'Ce champ ne peut être vide' : isset($error['mail']['used']) ? 'Cette adresse mail est déjà utilisée.' : 'Adresse Mail'  ?>">
                                </div>
                            </div>
                            <div class="form-group <?php echo isset($error['password']) ? 'has-error' : ''; ?>">
                                <label for="inputPassword1" class="col-lg-3 control-label">Mot de passe</label>
                                <div class="col-lg-9">
                                    <input type="password" name="password" class="form-control" id="inputPassword1" placeholder="<?= isset($error['name']['empty']) ? 'Ce champ ne peut être vide' : 'Mot de Passe';  ?>"  <?= isset($_POST['password']) && !empty($_POST['password']) ? 'value="' . $_POST['password'] . '"' : ''; ?>>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-9">
                                    <button type="submit" class="btn btn-info">Inscription</button>
                                </div>
                            </div>
                        </form>
                    </div>
                 </div>
              </div>
           </div>
        </div>
    </div>
</div>