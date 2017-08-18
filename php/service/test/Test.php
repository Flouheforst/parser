<?php 
	use \Curl\MultiCurl;
	error_reporting(E_ALL); 
	ini_set('display_errors', 1);
	ini_set('max_execution_time', 3000);
	require $_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php";

	$start = microtime(true);

/*	
for ($i=0; $i < 2; $i++) { 
	$url = "http://webistore.ru/get?i=$i";
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$page = curl_exec($curl);
}

*/
	$multi_curl = new MultiCurl();

	$multi_curl->success(function($instance) {
	    // echo 'call to "' . $instance->url . '" was successful.' . "\n";
	    // echo 'response:' . "\n";
	    // var_dump($instance->response);
	});
	$multi_curl->error(function($instance) {
	    // echo 'call to "' . $instance->url . '" was unsuccessful.' . "\n";
	    // echo 'error code: ' . $instance->errorCode . "\n";
	    // echo 'error message: ' . $instance->errorMessage . "\n";
	});
	$multi_curl->complete(function($instance) {
	    // echo 'call completed' . "\n";
	});

	$multi_curl->addGet('https://www.google.com/search', array(
	    'q' => 'hello world',
	));
	$multi_curl->addGet('https://duckduckgo.com/', array(
	    'q' => 'hello world',
	));
	$multi_curl->addGet('https://www.bing.com/search', array(
	    'q' => 'hello world',
	));

	$multi_curl->start(); 



		
	$end = microtime(true);
	$runtime = $end - $start;
	echo "\n";
	echo "Время выполнения php скрипта в микросекундах: ". $runtime;
