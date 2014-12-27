<?php
class Session implements IteratorAggregate, ArrayAccess {
	public $session;
	private $started;
	private $db;

	public function __construct($db, $auto = true){
		$this->started = isset($_SESSION);
		if (!$this->started && $auto) {
			$this->start();
		}
		$this->db = $db;
		$this->session = $_SESSION;
	}

	private function start(){
		if(!$this->started){
			session_start();
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

	public function login(){
		$data = $_POST;
		$return = array();
		if(isset($_POST['password'])) {
			$password = $this->encrypt($_POST['password']);
		}
		$data = $this->db->find('users', 'first', ['conditions' => ['mail' => $data['mail'], 'password' => $password, 'active' => 1]]);
		if(!empty($data)) {
			foreach($data as $key => $value){
				if($key == 'password') {
					$value = $this->decrypt($value);
				}
				$_SESSION['Auth'][$key] = $value;
			}
			$return['error'] = false;
			$return['message'] = "Bienvenue " . $_SESSION['Auth']['name'] . ' ' . $_SESSION['Auth']['firstname'];
		} else {
			$return['error'] = true;
			$return['message'] = 'Impossible de vous connecter';
		}
		return $return;
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

	function encrypt($value) {
		$cryptKey = 'gfHG543hGFojkjokL';
		$encoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $value, MCRYPT_MODE_CBC, md5(md5($cryptKey))));
		return $encoded;
	}

	function decrypt($value) {
		$cryptKey = 'gfHG543hGFojkjokL';
		$decoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), base64_decode($value), MCRYPT_MODE_CBC, md5(md5($cryptKey))), "\0");
		return $decoded;
	}
} 