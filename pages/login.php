<?php
$error = array();
if(!empty($_POST)){
    if(empty($_POST['mail'])){
        $error['mail'] = "Ce champ ne peut être vide";
        $_SESSION['flash'] = array('type' => 'danger', 'message' => "L'un des champs n'est pas rempli");
    }
    if(empty($_POST['password'])){
        $error['password'] = "Ce champ ne peut être vide";
        $_SESSION['flash'] = array('type' => 'danger', 'message' => "L'un des champs n'est pas rempli");
    }
    if(empty($error)){
        $session->login();
        if($_SESSION['flash']['type'] == "success") {
            header('Location: ./');
            exit();
        }
    }
}


if(isset($_SESSION['Auth']) && !empty($_SESSION['Auth']['id'])){
    header('Location: ./');
    exit();
}
?>
<div class="blocky">
    <div class="container">

        <?php if (isset($_SESSION['flash'])): ?>
            <div class="container">
                <div class="alert alert-<?= $_SESSION['flash']['type'] ?>"><?= $_SESSION['flash']['message']; ?></div>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif ?>

        <div class="row">
            <div class="col-md-6">
                <div class="reg-login-info">
                    <h2>Connectez-vous pour passer commande <span class="color">!</span></h2>
                    <img src="./design/img/back1.jpg" alt="" class="img-responsive img-thumbnail" />
                    <p>Duis leo risus, vehicula luctus nunc. Quiue rhoncus, a sodales enim arcu quis turpis. Duis leo risus, condimentum ut posuere ac, vehicula luctus nunc. Quisque rhoncus, a sodales enim arcu quis turpis.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="register-login">
                    <div class="cool-block">
                        <div class="cool-block-bor">

                            <h3>Connexion</h3>
                            <form class="form-horizontal" role="form" method="post" action="./?rub=login">
                                    <div class="form-group<?php echo isset($error['mail']) ? ' has-error' : '' ; ?>">
                                        <label for="inputEmail1" class="col-lg-3 control-label">Adresse Mail</label>
                                        <div class="col-lg-9">
                                            <input type="email" class="form-control" id="inputEmail1" name="mail" placeholder="<?php echo isset($error['mail']) ? $error['mail'] : 'Adresse Mail' ; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group<?php echo isset($error['password']) ? ' has-error' : '' ; ?>">
                                        <label for="inputPassword1" class="col-lg-3 control-label">Mot de passe</label>
                                        <div class="col-lg-9">
                                            <input type="password" class="form-control" id="inputPassword1" name="password" placeholder="<?php echo isset($error['password']) ? $error['password'] : 'Mot de Passe' ; ?>">
                                        </div>
                                    </div>
                                <div class="form-group">
                                    <div class="col-lg-offset-3 col-lg-9">
                                        <button type="submit" class="btn btn-info">Se Connecter</button>
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