<?php 
	require ROOT . "/php/service/Parse.php";
	require ROOT . "/php/App.php";

	class ParsPrCy extends Parse{
		protected $site;
		protected $data;
		protected $multi_curl;

		function __construct($site, $data, $multi_curl){
			parent::__construct($data);
			$this->site = $site;
			$this->data = $data;
			$this->multi_curl = $multi_curl;
		}

		public function allData(){
			$this->site = $this->data->cutUrl($this->site);
			
			$this->multi_curl->error(function($instance) {
			    echo 'call to "' . $instance->url . '" was unsuccessful.' . "\n";
			    echo 'error code: ' . $instance->errorCode . "\n";
			    echo 'error message: ' . $instance->errorMessage . "\n";
			});

			$this->multi_curl->success(function($instance) {
				echo 'call to "' . $instance->url . '" was successful.' . "\n";
				echo 'response:' . "\n";
				var_dump($instance->response);
			});

			$this->multi_curl->addGet('https://a.pr-cy.ru/'. $this->site .'/');

			$this->multi_curl->start(); 

		}
	}