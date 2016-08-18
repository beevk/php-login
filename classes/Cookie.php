<?php 
	class Cookie{
		public static function exists($name) {
			return (isset($_COOKIE[$name])) ? true : false;
		}

		public static function get($name) {
			return $_COOKIE[$name];
		}

		//Cookie needs to be reset to null value instead of  unsetting it.
		public static function put($name, $value, $expiry) {
			if(setcookie($name, $value, time() + $expiry, "/")) {
				return true;
			}
			return false;
		}

		public static function delete($name) {
			self::put($name, '', time() - 1);
		}
	}	

