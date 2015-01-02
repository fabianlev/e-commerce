<?php if(!empty($_POST)){
    foreach ($_POST as $key => $value) {
        if(empty($value)){
            $value = null;
        }
        $post[$key] = $value;
    }
    $db->update('users', ['name' => $post['name'], 'firstname' => $post['firstname'], 'mail' => $post['mail'], 'phone' => $post['phone'], 'address' => $post['address'], 'number' => $post['number'], 'zip' => $post['zip'], 'city' => $post['city'], 'password' => $session->encrypt($post['password']), 'country' => $post['country']], $_SESSION['Auth']['id']);
} ?>

<?php if(isset($_SESSION['Auth']['id'])): ?>
    <?php $user = $db->find('users', 'first', ['conditions' => ['id' => $_SESSION['Auth']['id']]]); ?>

    <div class="container">
        <div class="alert alert-warning">Si ces informations sont différentes des informations de votre compte paypal, elles seront automatiquement mise à jour avec les informations de Paypal.</div>
    </div>

    <div class="page-title">
         <div class="container">
            <h2><i class="fa fa-desktop color"></i> Mon Compte <small><?= $user->name . ' ' . $user->firstname; ?></small></h2>
            <hr />
         </div>
    </div>
      
    <div class="account-content">
        <div class="container">

            <div class="row">
                <?php include './include/account_menu.php'; ?>
                <div class="col-md-9">
                    <h3><i class="fa fa-user color"></i> &nbsp;Editer mon Profil</h3>
                    <!-- Your details -->
                    <form class="form-horizontal" role="form" method="post" action="./?rub=editaccount">
                        <div class="form-group">
                            <label for="inputName" class="col-md-3 control-label">Prénom</label>
                            <div class="col-md-4">
                                <input type="text" name="name" class="form-control" id="inputName" placeholder="Prénom" value="<?= isset($user->name) ? $user->name: ''; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-md-3 control-label">Nom</label>
                            <div class="col-md-4">
                                <input type="text" name="firstname" class="form-control" id="inputName" placeholder="Nom" value="<?= isset($user->firstname) ? $user->firstname: ''; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail1" class="col-md-3 control-label">Adresse Mail</label>
                            <div class="col-md-4">
                                <input type="email" name="mail" class="form-control" id="inputEmail1" placeholder="Adresse Mail" value="<?= isset($user->mail) ? $user->mail: ''; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPhone" class="col-md-3 control-label">Numéro de Téléphone</label>
                            <div class="col-md-4">
                                <input type="text" name="phone" class="form-control" id="inputPhone" placeholder="Numéro de Téléphone" value="<?= isset($user->phone) ? $user->phone: ''; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputCountry" class="col-md-3 control-label">Pays</label>
                            <div class="col-md-4">
                                <select name="country" class="form-control">
                                    <option value="">Sélectionner votre pays</option>
                                    <option value="Belgique" <?= isset($user->country) && $user->country === "Belgique" ? "selected" : ''; ?> >Belgique</option>
                                    <option value="France" <?= isset($user->country) && $user->country === "France" ? "selected" : ''; ?> >France</option>
                                    <option value="Canada" <?= isset($user->country) && $user->country === "Canada" ? "selected" : ''; ?> >Canada</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress" class="col-md-3 control-label">Adresse</label>
                            <div class="col-md-4">
                                <input type="text" name="address" class="form-control" rows="3" placeholder="Adresse" value="<?= isset($user->address) ? $user->address: ''; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress" class="col-md-3 control-label">Numéro</label>
                            <div class="col-md-4">
                                <input type="text" name="number" class="form-control" rows="3" placeholder="Numéro" value="<?= isset($user->number) ? $user->number: ''; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputZip" class="col-md-3 control-label">Code Postal</label>
                            <div class="col-md-4">
                                <input type="text" name="zip" class="form-control" id="inputZip" placeholder="Code Postal" value="<?= isset($user->zip) ? $user->zip: ''; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress" class="col-md-3 control-label">Ville</label>
                            <div class="col-md-4">
                                <input type="text" name="city" class="form-control" rows="3" placeholder="Ville" value="<?= isset($user->city) ? $user->city: ''; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-md-3 control-label">Mot de Passe</label>
                            <div class="col-md-4">
                                <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Mot de Passe" value="<?= isset($user->password) ? $session->decrypt($user->password) : ''; ?>" />
                            </div>
                        </div>
                        <hr />
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-10">
                                <button type="submit" class="btn btn-success">Save Changes</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        <div class="sep-bor"></div>
        </div>
    </div>
<?php else:
    header("Location: ./");
endif; ?>