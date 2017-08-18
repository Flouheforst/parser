<?php
	error_reporting(E_ALL); 
	ini_set('display_errors', 1);
	define("ROOT", $_SERVER["DOCUMENT_ROOT"]);

	require ROOT . "/vendor/phpQuery.php";

	require ROOT . "/php/service/FactoryService.php";
	require ROOT . "/php/Collector.php";
	require ROOT . "/php/data/WorkWithData.php";
	require ROOT . "/vendor/autoload.php";

	use \Curl\MultiCurl;

	define("EMAILM", "shadool110790@mail.ru");
	define("PASSWORDM", "13324661we");

	define("EMAIL_PR_CY", "shadool110790@mail.ru");
	define("PASSWORD_PR_CY", "13324661weE");

	if( isset($_POST["site"]) ){ 

		$start = microtime(true);
		$site = $_POST["site"];

		if ( (stristr($site, "https://") === FALSE) && (stristr($site, "http://") === FALSE) ) {
			$site = "http://" . $site;
		}

		//$data = new WorkWithData();
		//$collector = new Collector();
		//$multi_curl = new MultiCurl();
		
		// $megaInd = FactoryService::createMegaIndex($site, EMAILM, PASSWORDM, $data, $multi_curl);
		//$validator = FactoryService::createValidator_w3($site, $data, $multi_curl);
		// $PrCy = FactoryService::createPrCy($site, $data, $multi_curl);
		// $Google = FactoryService::createGoogleSpeedParse($site, $data, $multi_curl);
		// $Google->parseMobile();
		// $Google->parseDesktop();

		//$validator->parseError();
		// $PrCy->allData(); 
		
		// устанавливается последним сайтом который парсится
		// $PrCy->setObjCollector($collector);
		// $PrCy->setSite($site);
		
		// $PrCy->build();
		// $collector->assemble($data->cutUrl($site), $data->getAllData(), $data);

		// $img = $data->getData(3);
		// echo "<pre>";
		// print_r($data->getAllData() ) ;
		// echo "</pre>";
		// $data->delImages($img);
		some();
		$end = microtime(true);
		$runtime = $end - $start;
		echo "Время выполнения php скрипта в микросекундах: ". $runtime;
	}


	function some(){
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
	}