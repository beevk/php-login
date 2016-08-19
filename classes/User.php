<?php 
	class User{
		private $_db;
		private $_data,
				$_cookieName,
				$_sessionName,
				$_isLoggedIn;

		public function __construct($user = null) {
			$this->_db = DB::getInstance();
			$this->_sessionName = Config::get('session/sessionName');
			$this->_cookieName = Config::get('remember/cookieName');

			if(!$user){
				if(Session::exists($this->_sessionName)){
					$user = Session::get($this->_sessionName);
					//echo $user;
					if($this->find($user)){
						$this->_isLoggedIn = true;
					}
					else{
						//Process logout
					}
				}
			}
			else{
				$this->find($user);

			}
		}		

		public function create($fields = array()) {
			if(!$this->_db->insert('users', $fields)) {
				throw new Exception('There was a problem creating this account.');	
			}

		}

		public function find($user = null){
			if($user) {
				//To find the user by its ID
				$field = (is_numeric($user)) ? 'id' : 'username';
				$data = $this->_db->get('users', array($field, '=' , $user));

				if($data->count()) {
					$this->_data = $data->first();
					return true;
				}
			}
			return false;
		}

		public function login($username = null, $password = null, $remember = false){
		
			if(!$username && !$password && $this->exists()) {
				//Log user in
				Session::put($this->_sessionName, $this->data()->id);
			}
			else {
				$user = $this->find($username);	

				if($user){
					echo "DB:" . $this->data()->password . "<br>";
					echo "New val: " . Hash::make($password, $this->data()->salt) . "<br>";
					if($this->data()->password === Hash::make($password, $this->data()->salt)) {
						Session::put($this->_sessionName, $this->data()->id);

						if($remember){
							//To check if it's stored in DB
							$hash = Hash::unique();
							//Check inside our DB
							$hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));

							if(!$hashCheck->count()) {
								//Generate new hash to stoere in DB	
								$this->_db->insert('users_session', array(
									'user_id' => $this->data()->id,
									'hash' => $hash
								));
							}
							else{
								$hash = $hashCheck->first()->hash;
							}

							Cookie::put($this->_cookieName, $hash, Config::get('remember/cookieExpiry'));
						}

						return true;
					}
				}
			}
			return false;
		}

		public function logout() {
			//Remove from DB, delete cookie and session
			$this->_db->delete('users_session', array('user_id', '=', $this->data()->id));
			Session::delete($this->_sessionName);
			Cookie::delete($this->_cookieName);
		}

		public function update($fields = array(), $id = null) {
			if(!$id && $this->isLoggedIn()) {
				$id = $this->data()->id;
			}

			if(!$this->_db->update('users', $id, $fields)) {
				throw new Exception('There was a problem Updating!');
			}
		}

		public function data() {
			return $this->_data;
		}

		public function exists() {
			return (!empty($this->_data)) ? true : false;
		}

		public function isLoggedIn() {
			return $this->_isLoggedIn;
		}

		public function hasPermission($key) {
			$group = $this->_db->get('groups', array('id', '=', $this->data()->groups));

			if($group->count()) {
				$permissions = json_decode($group->first()->permissions, true);
				//print_r($permissions);

				if($permissions[$key] == true) {
					return true;
				}

			}
			return false;
		}
	} 