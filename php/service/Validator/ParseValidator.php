<?php 

	class ParseValidator extends Parse {
		protected $site;
		public $data;

		public function __construct($site, $data){
			parent::__construct($data);
			$this->data = $data;
			$this->site = $site;
		}

		public function parseError(){
			$this->site = $this->data->cutUrl($this->site);

			$opts = array(
			  'http'=>array(
			    'method'=>"GET",
			    'header'=>"Accept-language: en\r\n" .
			              "User-Agent: chrome\r\n"
			  )
			);
			$context = stream_context_create($opts);
			
			$validator_w3Html = file_get_contents('https://validator.w3.org/nu/?doc=https%3A%2F%2F' . $this->site, false, $context);

			$validHtml = phpQuery::newDocument($validator_w3Html);
			$errorsHtml = pq($validHtml)->find('#results ol');



			$url = "https://jigsaw.w3.org/css-validator/validator?uri=" . $this->site . "&profile=css3&usermedium=all&warning=1&vextwarning=&lang=ru";
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$page = curl_exec($curl);

			//Обрабатываем переменную с помощью phpQuery:
			$document = phpQuery::newDocument($page); 
			$errorsCss = $document->find('#results_container #errors h3')->text();
			
			$this->data->filterErrorValidatorHtml($errorsHtml);
			$this->data->filterErrorValidatorCss($errorsCss);

			
		}

	} 