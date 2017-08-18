<?php 	
	require ROOT . "/php/service/Parse.php";
	require ROOT . "/php/App.php";

	class ParseValidator {
		protected $multi_curl;
		protected $site;
		public $data;

		public function __construct($site, $data, $multi_curl){
			$this->data = $data;
			$this->site = $site;
			$this->multi_curl = $multi_curl;
		}

		public function parseError(){
			$this->site = $this->data->cutUrl($this->site);
				
			$user_agent='Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36';


			$options = array(

	            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
	            CURLOPT_POST           =>false,        //set to GET
	            CURLOPT_USERAGENT      => $user_agent, //set user agent
	            CURLOPT_RETURNTRANSFER => true,     // return web page
	            CURLOPT_HEADER         => false,    // don't return headers
	            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
	            CURLOPT_ENCODING       => "",       // handle all encodings
	            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
	            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
	            CURLOPT_TIMEOUT        => 120,      // timeout on response
	            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
	            CURLOPT_SSL_VERIFYPEER => false,       // stop after 10 redirects
	        );


			$ch      = curl_init("https://validator.w3.org/nu/?doc=https%3A%2F%2Fkompot.bz");
	        curl_setopt_array( $ch, $options );
	        $content = curl_exec( $ch );
	        $err     = curl_errno( $ch );
	        $errmsg  = curl_error( $ch );
	        $header  = curl_getinfo( $ch );
	        curl_close( $ch );

	        $header['errno']   = $err;
	        $header['errmsg']  = $errmsg;
	        $header['content'] = $content;

	        echo "<pre>";
	        print_r($header);
	        echo "</pre>";
			/*
			$this->multi_curl->setUserAgent("Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0");

			$this->multi_curl->error(function($instance){
				echo 'call to "' . $instance->url . '" was unsuccessful.' . "\n";
				echo "<br>";
			    echo 'error code: ' . $instance->errorCode . "\n";
			    echo "<br>";
			    echo 'error message: ' . $instance->errorMessage . "\n";
			    echo "<br>";
			});

			$this->multi_curl->complete(function($instance) {
			    echo 'call completed' . "\n";
			});

			$this->multi_curl->success(function($instance){
				print_r($instance->response);
			});

			$this->multi_curl->addGet('https://validator.w3.org/nu/?doc=https%3A%2F%2F' . $this->site);
				*/
		//	$this->multi_curl->addGet("https://jigsaw.w3.org/css-validator/validator?uri=" . $this->site . "&profile=css3&usermedium=all&warning=1&vextwarning=&lang=ru");


			//$this->multi_curl->start();


			


			/*
			$url = "https://jigsaw.w3.org/css-validator/validator?uri=" . $this->site . "&profile=css3&usermedium=all&warning=1&vextwarning=&lang=ru";
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$page = curl_exec($curl);

			//Обрабатываем переменную с помощью phpQuery:
			$document = phpQuery::newDocument($page); 
			$errorsCss = $document->find('#results_container #errors h3')->text();
			
			$this->data->filterErrorValidatorHtml($errorsHtml);
			$this->data->filterErrorValidatorCss($errorsCss);
			*/
			
		}

		protected  function get_web_page( $url )	{
	        $user_agent='Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36';

	        $options = array(

	            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
	            CURLOPT_POST           =>false,        //set to GET
	            CURLOPT_USERAGENT      => $user_agent, //set user agent
	            CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
	            CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
	            CURLOPT_RETURNTRANSFER => true,     // return web page
	            CURLOPT_HEADER         => false,    // don't return headers
	            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
	            CURLOPT_ENCODING       => "",       // handle all encodings
	            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
	            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
	            CURLOPT_TIMEOUT        => 120,      // timeout on response
	            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
	            CURLOPT_SSL_VERIFYPEER => false,       // stop after 10 redirects
	        );

	        $ch      = curl_init( $url );
	        curl_setopt_array( $ch, $options );
	        $content = curl_exec( $ch );
	        $err     = curl_errno( $ch );
	        $errmsg  = curl_error( $ch );
	        $header  = curl_getinfo( $ch );
	        curl_close( $ch );

	        $header['errno']   = $err;
	        $header['errmsg']  = $errmsg;
	        $header['content'] = $content;
	        return $header;
    	}

	} 