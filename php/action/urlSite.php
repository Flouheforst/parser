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

		$data = new WorkWithData();
		$collector = new Collector();
		$multi_curl = new MultiCurl();
		
		// $megaInd = FactoryService::createMegaIndex($site, EMAILM, PASSWORDM, $data);
		// $validator = FactoryService::createValidator_w3($site, $data);
		$PrCy = FactoryService::createPrCy($site, $data, $multi_curl);
		// $Google = FactoryService::createGoogleSpeedParse($site, $data);
		// $Google->parseMobile();
		// $Google->parseDesktop();

		// $validator->parseError();
		$PrCy->allData(); 
		
		// устанавливается последним сайтом который парсится
		$PrCy->setObjCollector($collector);
		$PrCy->setSite($site);
		
		$PrCy->build();
		// $collector->assemble($data->cutUrl($site), $data->getAllData(), $data);

		// $img = $data->getData(3);
		echo "<pre>";
		print_r($data->getAllData() ) ;
		echo "</pre>";
		//$data->delImages($img);

		$end = microtime(true);
		$runtime = $end - $start;
		echo "Время выполнения php скрипта в микросекундах: ". $runtime;
	}