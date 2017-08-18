<?php 
	class FactoryService {
		public static function createMegaIndex($site, $login, $password, $data, $multi_curl){
			$class_name = "MegaIndex";
			require ('MegaIndex/MegaIndex.php');
			return new $class_name($site, $login, $password, $data, $multi_curl);
		}

		public static function createPrCy($site, $data, $multi_curl){
			$class_name = "ParsPrCy";
			require ('PrCy/ParsPrCy.php');
			return new $class_name($site, $data, $multi_curl);
		}

		public static function createValidator_w3($site, $data, $multi_curl){
			$class_name = "ParseValidator";
			require ('Validator/ParseValidator.php');
			return new $class_name($site, $data, $multi_curl);
		}

		public static function createGoogleSpeedParse($site, $data, $multi_curl){
			$class_name = "GoogleSpeedParse";
			require ('Google/GoogleSpeedParse.php');
			return new $class_name($site, $data, $multi_curl);
		}
	}