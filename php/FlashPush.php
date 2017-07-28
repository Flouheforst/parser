<?php 
	class FlashPush{
		public static function get($key){
			$message = $_SESSION["flash_$key"];
			unset($_SESSION["flash_$key"]);
			return $message;
		}

		public static function has($key){
			return isset($_SESSION["flash_$key"]);
		}

		public static function add($key, $message) {
			$_SESSION["flash_$key"] = $message;
		}
		
	} 