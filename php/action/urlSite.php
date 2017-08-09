<?php
	// require('../Model/SiteContent.php');
	require "../libs/phpQuery.php";
	require "../service/FactoryService.php";
	require "../Collector.php";
	require "../data/WorkWithData.php";

	define("EMAILM", "shadool110790@mail.ru");
	define("PASSWORDM", "13324661we");

	define("EMAIL_PR_CY", "shadool110790@mail.ru");
	define("PASSWORD_PR_CY", "13324661weE");

	if( isset($_POST["site"]) ){ 
		$site = $_POST["site"];

		if ( (stristr($site, "https://") === FALSE) && (stristr($site, "http://") === FALSE) ) {
			$site = "http://" . $site;
		}

		$data = new WorkWithData();
		$collector = new Collector();
		
		$megaInd = FactoryService::createMegaIndex($site, EMAILM, PASSWORDM, $data);
		$validator = FactoryService::createValidator_w3($site, $data);
		$PrCy = FactoryService::createPrCy($site, $data);

		//$Google = FactoryService::createGoogleSpeedParse($site, $data);

		//$Google->parseMobile();
		//$Google->parseDesktop();

		$validator->parseError();

		$PrCy->allData(); 
		
		// устанавливается последним сайтом который парсится
		$PrCy->setObjCollector($collector);
		$PrCy->setSite($site);
		
		$PrCy->build();
		$collector->assemble($data->cutUrl($site), $data->getAllData(), $data);

		$img = $data->getData(3);
		$data->delImages($img);

	}