<?php 
	require "MegaIndex/ParsMegaIndex.php";


	define("COOKIE_BASE_PATH",$_SERVER['DOCUMENT_ROOT'] . "/parser/php/CookieFile/");

	abstract class Auth {
		protected $cookieFilePath;
		protected $site;
		protected $login;
		protected $password;
		protected $data;

		public function __construct($site, $login, $password, $data) {
			if(file_exists(COOKIE_BASE_PATH . static::getCookieFileName()) ){
				$this->cookieFilePath = COOKIE_BASE_PATH . static::getCookieFileName();
			}
			$this->site = $site;
			$this->login = $login;
			$this->password = $password;
			$this->data = $data;

			if ($this->checkSite()) {
				
				$parseMegaindex = new ParsMegaIndex($data);
				$parseMegaindex->parseTable($this->site);
				

				// потом как будет готова капча иди в функцию isAuth и от туда вызывай ParseMegaIndex
				/*
					if (!$this->isAuth()) {
						$this->doAuth();
					}
				*/
			}
			
		}

		public function checkSite(){
			if (@fopen($this->site, 'r') !== false ) {
				if (stristr($this->site, "https://") ===  $this->site) {
					$this->site = str_replace("https://", "", $this->site);  
				} elseif (stristr($this->site, "http://") ===  $this->site) {
					$this->site = str_replace("http://", "", $this->site);
				}

				return $this->site;
			} else {
				App::redirect("parser/php/resourses/page/notfound.view.php");
				App::render("notfound");
			}
		}


		/**
		 * Проверка на авторизацию
		 * @return boolean
		 **/
		abstract public function isAuth();

		/**
		 * Авторизация
		 * @return boolean
		 **/		
		abstract public function doAuth();

		/**
		 * Выход из системы
		 * @return boolean
		 **/
		abstract public function logout();

		/**
		 * Имя файла куки
		 * @return string
		 **/
		abstract public function getCookieFileName();
	}