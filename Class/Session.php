<?php
class Session implements IteratorAggregate, ArrayAccess {
	public $session;
	private $started;
	private $db;
	private $key = 'gfHG543hGFojkjokL';

	public function __construct($db, $infos = false, $auto = true){
		$this->started = isset($_SESSION);
		if (!$this->started && $auto) {
			$this->start();
		}
		$this->db = $db;
		$this->session = $_SESSION;
		if($infos){
			$this->set('', $infos);
		}
	}

	private function start(){
		if(!$this->started){
			session_start();
			session_regenerate_id();
			$this->started = true;
		}
	}

	public function destroy($clear_data = true){
		if ($this->started){
			if ($clear_data){
				unset($this->session);
			}
			session_destroy();
			session_write_close();
			$this->started = false;
		}
	}

	public function login($data = array()){
		if(empty($data)){
			$data = $_POST;
		}
		if(isset($_POST['password'])) {
			$password = $this->encrypt($_POST['password']);
		}
		$data = $this->db->find('users', 'first', ['conditions' => ['mail' => $data['mail'], 'password' => $password]]);
		if(!empty($data)) {
			if($data->active){
				session_regenerate_id();
				foreach($data as $key => $value){
					if($key == 'password') {
						$value = $this->decrypt($value);
					}
					$_SESSION['Auth'][$key] = $value;
				}
				$_SESSION['flash'] = array('type' => 'success', 'message' => "Bienvenue {$_SESSION['Auth']['name']}  {$_SESSION['Auth']['firstname']}, vous êtes maintenant connecté");
			} else {
				$_SESSION['flash'] = array('type' => 'danger', 'message' => "Merci de bien vouloir valider votre compte avant de vous connecter");
			}
			
		} else {
			$_SESSION['flash'] = array('type' => 'danger', 'message' => "L'adresse mail ou le mot de passe est incorrect.");
		}
	}

	public function set($key, $value){
		$this->session[$key] = $value;
	}
	public function delete($key){
		unset($this->session[$key]);
	}

	public function get($key){
		return $this->session[$key];
	}

	public function has($key){
		return array_key_exists($key, $this->session);
	}

	public function offsetSet($offset, $value) {
		$this->set($offset, $value);
	}

	public function offsetExists($offset) {
		$this->has($offset);
	}

	public function offsetUnset($offset) {
		if($this->has($offset)){
			unset($this->session[$offset]);
		}
	}

	public function offsetGet($offset) {
		return $this->get($offset);
	}

	public function getIterator(){
		return new ArrayIterator($this->session);
	}

	public function encrypt($value) {
		return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($this->key), $value, MCRYPT_MODE_CBC, md5(md5($this->key))));
	}

	public function decrypt($value) {
		return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($this->key), base64_decode($value), MCRYPT_MODE_CBC, md5(md5($this->key))), "\0");
	}
} 