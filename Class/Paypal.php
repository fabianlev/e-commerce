<?php
class Paypal {

    private $user = PPUSER;
    private $password = PPPWD;
    private $signature = PPSIGNATURE;
    private $endpoint = "https://api-3t.sandbox.paypal.com/nvp";
    public $errors = array();

    public function __construct($user = false, $password = false, $signature = false, $prod = false){
        if($user){
            $this->user = $user;
        }
        if($password){
            $this->password = $password;
        }
        if($signature){
            $this->signature = $signature;
        }
        if($prod){
            $this->endpoint = str_replace('sandbox.', '', $this->endpoint);
        }
    }

    public function request($method, $params){
        $params = array_merge($params, array(
            'METHOD' => $method,
            'VERSION' => '119.0',
            'USER' => $this->user,
            'SIGNATURE' => $this->signature,
            'PWD' => $this->password
        ));
        $params = http_build_query($params);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->endpoint,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_VERBOSE => true
        ));
        $return = curl_exec($curl);
        $returnArray = array();
        parse_str($return, $returnArray);
        if(curl_errno($curl)){
            $this->errors = curl_errno($curl);
            curl_close($curl);
            return false;
        } else {
            if ($returnArray['ACK'] === 'Success') {
                curl_close($curl);
                return $returnArray;
            } else {
                $this->errors = $returnArray;
                curl_close($curl);
                return false;
            }
        }
    }
}