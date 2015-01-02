<?php
$paypal = new Paypal();
$response = $paypal->request('GetExpressCheckoutDetails', ['TOKEN' => $_GET['token']]);
$errors = true;
if($response){
    if($response['CHECKOUTSTATUS'] != 'PaymentActionCompleted'){
        var_dump($response);
        $user = $db->find('users', 'first', ['conditions' => ['id' => $_SESSION['Auth']['id']]]);
        $update = $checkUser = ['street' => $user->street, 'zip' => $user->zip, 'city' => $user->city, 'state' => $user->city, 'country' => $user->country];
        if($checkUser['street'] != $response['SHIPTOSTREET']){
            $update['street'] = $response['SHIPTOSTREET'];
        }
        if($checkUser['zip'] != $response['SHIPTOZIP']){
            $update['zip'] = $response['SHIPTOZIP'];
        }
        if($checkUser['city'] != $response['SHIPTOCITY']){
            $update['city'] = $response['SHIPTOCITY'];
        }
        if($checkUser['state'] != $response['SHIPTOSTATE']){
            $update['state'] = $response['SHIPTOSTATE'];
        }
        if($checkUser['country'] != $response['SHIPTOCOUNTRYNAME']){
            $update['country'] = $response['SHIPTOCOUNTRYNAME'];
        }
        if($update !== $checkUser) {
            $db->update('users', $update, $user->id);
        }
        $params = [
            'TOKEN' => $_GET['token'],
            'PAYERID' => $_GET['PayerID'],
            'PAYMENTREQUEST_0_AMT' => $response['AMT'],
            'PAYMENTREQUEST_0_CURRENCYCODE' => 'EUR',
            'PAYEMENTACTION' => 'Sale'
        ];
        $params = array_merge($params, $cart->getPaypalParams('Order'));
        $response = $paypal->request('DoExpressCheckoutPayment', $params);
        if($response){
            $db->insert('orders', [
                'user_id' => $_SESSION['Auth']['id'],
                'transaction_id' => $response['PAYMENTINFO_0_TRANSACTIONID'],
                'status' => $response['PAYMENTINFO_0_PAYMENTSTATUS'],
                'amount' => $response['PAYMENTINFO_0_AMT'],
                'fee' => $response['PAYMENTINFO_0_FEEAMT'],
                'gained' => $response['PAYMENTINFO_0_AMT'] - $response['PAYMENTINFO_0_FEEAMT']
            ]);
            $errors = false;
        } else {
            $errors = $paypal->errors;
            if (!isset($errors['PAYMENTINFO_0_TRANSACTIONID'])) {
                var_dump($errors);
                $count = (count($errors) - 7) / 2;
                for ($i = 0; $i < $count; $i++) {
                    $error[] = $errors["L_LONGMESSAGE$i"];
                }
                $error = implode('& ', $error);
                $db->insert('orders', [
                    'user_id' => $_SESSION['Auth']['id'],
                    'errors' => $error
                ]);
            }
        }
        $cart->remove('all');
    }
} else {
    $errors = $paypal->errors;
}

if(!$errors): ?>
    <div class="page-title">
        <div class="container">
            <h2><i class="fa fa-shopping-cart color"></i> Nous avons bien reçu votre commande !</h2>
            <hr />
            <h5>Merci d'avoir acheté dans notre boutique !</h5>
            <h5>Votre numéro de commande est le  <span class="color"><?= $response['PAYMENTINFO_0_TRANSACTIONID']; ?></span>. Gardez-le précieusement pour toute autre aide nécessaire.</h5>
            <div class="sep-bor"></div>
        </div>
    </div>
<?php else: ?>
    <div class="container">
        <div class="alert alert-danger">Une erreur s'est produite. Votre compte Paypal n'a pas été débité.<br><a class="btn btn-primary" href="./">Retourner à l'accueil</a></div>
    </div>
<?php endif;