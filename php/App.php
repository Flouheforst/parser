<?php 
	session_start();

	error_reporting(E_ALL); 
	ini_set('display_errors', 1);
	ini_set('max_execution_time', 3000);

	define("ROOT", $_SERVER["DOCUMENT_ROOT"]);
	class App {
		public static function render($template, $data=[]){
			ob_start();
				extract($data);
				include("resourses/page/$template.view.php");
			echo ob_get_clean();
		}
		
		public static function renderTemplate($template, $data=[]){
			ob_start();
				extract($data);
				include("resourses/template/$template.view.php");
			echo ob_get_clean();
		}

		public static function redirect($action) {
			header("Location: /$action");
		}
	}

	App::render("goParse");