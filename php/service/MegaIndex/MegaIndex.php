<?php 
	require "/../Auth.php";
	require "/../../App.php";
	

	class MegaIndex extends Auth {
		protected $site;

		public function __construct($site, $login, $password, $data){
			// как будет регистрация $site убрать из auth
			parent::__construct($site, $login, $password, $data);

			$this->site = $site; 
		}

		public function doAuth(){
			$curl = curl_init("https://ru.megaindex.com/auth");

			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			//curl_setopt($curl, CURLOPT_RETURNTRANSFER , true);	
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);	
			curl_setopt($curl, CURLOPT_COOKIEJAR, $this->cookieFilePath);
			curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookieFilePath);
			curl_setopt($curl, CURLOPT_POSTFIELDS, [
				'email' => $this->login,
				'password' => $this->password
			]);
			curl_exec($curl);

			if (curl_exec($curl) === FALSE) {
				return false;
			} else {
				return true;
			}
			curl_close($curl);
			
		}

		public function isAuth(){
			echo "string";
			$curl = curl_init("https://ru.megaindex.com/auth");

			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER , true);	
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);	
			curl_setopt($curl, CURLOPT_COOKIEJAR, $this->cookieFilePath);
			curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookieFilePath);
			curl_exec($curl);

			if (curl_exec($curl) === FALSE) {

			} else {

				//todo
			}

			curl_close($curl);
		} 

		public function getUrl(){
			return $this->site;
		}

		public function logout(){

		}

		public function getCookieFileName(){
			return "cookiefile.txt";
		}

	}