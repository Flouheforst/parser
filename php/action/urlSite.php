<?php
	// require('../Model/SiteContent.php');
	require "../libs/phpQuery.php";
	require "../service/FactoryService.php";
	require "../Collector.php";
	require "../data/WorkWithData.php";

	define("EMAILM", "shadool110790@mail.ru");
	define("PASSWORDM", "13324661we");
	
	if( isset($_POST["site"]) ){ 
		$site = $_POST["site"];

		if ( (stristr($site, "https://") === FALSE) && (stristr($site, "http://") === FALSE) ) {
			$site = "http://" . $site;
		}
		$data = new WorkWithData();
		$collector = new Collector();
		
		$megaInd = FactoryService::createMegaIndex($site, EMAILM, PASSWORDM, $data);
		
		$PrCy = FactoryService::createPrCy($site, $data);
		$PrCy->parseThPage();
		$PrCy->setObjCollector($collector);
		$PrCy->setSite($site);
		
		$PrCy->build();
		$collector->assemble($data->cutUrl($site), $data->getAllData(), $data);
	}	