<?php 
	class FactoryService {
		public static function createMegaIndex($site, $login, $password, $data){
			$class_name = "MegaIndex";
			require ('MegaIndex/MegaIndex.php');
			return new $class_name($site, $login, $password, $data);
		}

		public static function createPrCy($site, $data){
			$class_name = "ParsPrCy";
			require ('PrCy/ParsPrCy.php');
			return new $class_name($site, $data);
		}

		public static function createValidator_w3($site, $data){
			$class_name = "ParseValidator";
			require ('Validator/ParseValidator.php');
			return new $class_name($site, $data);
			
		}
	}