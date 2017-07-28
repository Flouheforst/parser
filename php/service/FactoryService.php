<?php 
	class FactoryService {
		public static function createMegaIndex($site, $login, $password, $data){
			$class_name = "MegaIndex";
			require ('MegaIndex/MegaIndex.php');
			$object = new $class_name($site, $login, $password, $data);
			return $object;
		}

		public static function createPrCy($site, $data){
			$class_name = "ParsPrCy";
			require ('PrCy/ParsPrCy.php');
			$object = new $class_name($site, $data);
			return $object;
		}
	}