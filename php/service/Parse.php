<?php 

	abstract class Parse {

		protected $workData;
		protected $data = array();
		protected $imgList = array();
		protected $objCollector;
		protected $site;


		public function __construct($data){
			$this->workData = $data;
		}

		public function setObjCollector($objCollector){
			$this->objCollector = $objCollector;
		}

		public function setSite($site){
			$this->site = $site;
		}

		public function build(){
			//$this->objCollector->assemble($this->site, $this->data);
			$this->imgList = array(
					"comp" => $this->img(1920, 1080),
					"plant" => $this->img(900, 1200),
					"phone" => $this->img(300, 500),
					"404" => $this->img(1500, 900)
				);

			$this->workData->setImg($this->imgList);
		}

	
		/*
		// парсит картинку с s-shot.ru
		protected function img($width, $height){
			$img = file_get_contents('http://mini.s-shot.ru/' . $width . 'x' . $height . '/JPEG/1024/Z100/?' . $this->site);
			// название сайта + разрешение + случайное число uniqid();
			$file = $_SERVER['DOCUMENT_ROOT'] . 'parser/assets/img/' .  $this->workData->cutUrl($this->site) . $width . $height . uniqid() . ".jpg";

			file_put_contents($file, $img);
			$outFile = str_replace($_SERVER['DOCUMENT_ROOT'] . "parser/", "", $file);

			return $outFile;
		}
		*/


		protected function img($width, $height){
			$this->site = $this->workData->cutUrl($this->site);
			$response = exec("node " . $_SERVER["DOCUMENT_ROOT"] . "parser/assets/js/screenShot.js $this->site $width $height");
			return str_replace("../../", "", $response);
		}
	}