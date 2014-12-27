<?php
$error = array();
$mail = '';

if(!empty($_POST)){
    if(empty($_POST['mail'])){
        $error['mail']['empty'] = true;
    } else {
        $mail = $db->find('users', 'count', ['conditions' => ['mail' => $_POST['mail']]]);
        if($mail == 1){
            $error['mail']['used'] = true;
        }
    }
    if(empty($_POST['name'])){
        $error['name']['empty'] = true;
    } else {
        $name = $db->find('users', 'count', ['conditions' => ['mail' => $_POST['name']]]);
    }
    if(empty($_POST['firstname'])){
        $error['firstname']['empty'] = true;
    } else {
        $firstname = $db->find('users', 'count', ['conditions' => ['mail' => $_POST['firstname']]]);
    }
    if(empty($_POST['password'])){
        $error['password'] = true;
    }
    if(empty($error)) {
        foreach ($_POST as $key => $value) {
            if (empty($value)) {
                $value = null;
            }
            $post[$key] = $value;
        }
        $token = md5(time());
        var_dump($_POST);
        var_dump($token);
        $db->insert('users', ['name' => $post['name'], 'firstname' => $post['firstname'], 'mail' => $post['mail'], 'password' => $session->encrypt($post['password']), 'token' => $token]);
    }
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
                        <h3>Register</h3>
                        <form class="form-horizontal" role="form" method="post" action="./?rub=register">
                            <div class="form-group <?= isset($error['firstname']) ? 'has-error' : ''; ?>">
                                <label for="inputLastName" class="col-lg-3 control-label">Nom</label>
                                <div class="col-lg-9">
                                    <input type="text" name="firstname" class="form-control" id="inputName" placeholder="<?= isset($error['firstname']['empty']) ? 'Ce champ ne peut être vide' : 'Nom';  ?>" <?= isset($_POST['firstname']) && !empty($_POST['firstname']) ? 'value="' . $_POST['firstname'] . '"' : ''; ?>>
                                </div>
                            </div>
                            <div class="form-group <?= isset($error['name']) ? 'has-error' : ''; ?>">
                                <label for="inputFirstName" class="col-lg-3 control-label">Prénom</label>
                                <div class="col-lg-9">
                                    <input type="text" name="name" class="form-control" id="inputName" placeholder="<?= isset($error['name']['empty']) ? 'Ce champ ne peut être vide' : 'Prénom';  ?>"  <?= isset($_POST['name']) && !empty($_POST['name']) ? 'value="' . $_POST['name'] . '"' : ''; ?>>
                                </div>
                            </div>
                            <div class="form-group <?= isset($error['mail']) ? 'has-error' : ''; ?>">
                                <label for="inputEmail1" class="col-lg-3 control-label">Adresse Mail</label>
                                <div class="col-lg-9">
                                    <input type="email" name="mail" class="form-control" id="inputEmail1" placeholder="<?= isset($error['name']['empty']) ? 'Ce champ ne peut être vide' : isset($error['mail']['used']) ? 'Cette adresse mail est déjà utilisée.' : 'Adresse Mail'  ?>">
                                </div>
                            </div>
                            <div class="form-group <?= isset($error['password']) ? 'has-error' : ''; ?>">
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