<?php 
	class Token{
		//To generate a unique number for the value of session which is displayed in register page source
		public static function generate(){
			//We passed 2 parameters to put() to create a new session
			return Session::put(Config::get('session/tokenName'), md5(uniqid()));
		}

		public static function check($token){
			$tokenName = Config::get('session/tokenName');

			//Checks if SESSION exists and returns value to $token
			if(Session::exists($tokenName) && $token === Session::get($tokenName)){
				Session::delete($tokenName);
				return true;
			}

			return false;
		}
	}
 ?>