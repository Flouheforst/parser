<?php 
	class WorkWithData {
		private $allData = array();

		public function megrgeArra($urlImg, $sizeImg){

			$res = array();
			$i = 1;
			$j = 2;
			
			foreach ($urlImg as $key => $value) {
				$res[$i] = $value;
				$i += 2;
			}

			foreach ($sizeImg as $keyArr => $valueArr) {
				$res[$j] = $valueArr;
				$j+= 2;
				ksort($res);
			}

			return $res;
		}

		public function cutUrl($site){
			if (stristr($site, "https://") ===  $site) {
				$site = str_replace("https://", "", $site);  
			} elseif (stristr($site, "http://") ===  $site) {
				$site = str_replace("http://", "", $site);
			} elseif (stristr($site, "www.") ===  $site) {
				$site = str_replace("www.", "", $site);
			}

			return $site;
		}

		public function filterTableMegaindex($table){
			$i = 0;
			$query = array();
			$yandex = array();
			$google = array();

			foreach ($table as $key => $value) {
				$pq = pq($value);
				foreach ($pq->find('tr') as $val) {
					$tr = pq($val);
					$queryCycl = $tr->find("td")->contents()->eq(2)->text();
					// 5 8 10
					$yandexCycl_5 = $tr->find("td")->contents()->eq(5)->find("span")->text();
					//(11 13)
					$google_11 = $tr->find("td")->contents()->eq(11)->find("span")->text();
					$google_13 = $tr->find("td")->contents()->eq(13)->find("span")->text();

					if (!empty($queryCycl) || !empty($yandexCycl_5) || !empty($yandexCycl_8) || !empty($yandexCycl_10) || !empty($google_13) || !empty($google_16) || !empty($google_18) ) {

						$query[$i] = $queryCycl;
						$yandex[$i] = trim($yandexCycl_5);
						$google[$i] = trim($google_13);
						$google[$i] .= trim($google_11);
					}
					$i++;
				}
			}

			$res = array(
						"query" => $query,
						"google" => $google,
						"yandex" => $yandex
					);

			$this->allData[1] = array(
					"data" => $res
				);

			//$res = $this->clearGarbage($query, $google, $yadnex);
		}

		public function filterPrCyTable($table){
			foreach($table as $key => $value){
				$pq = pq($value);
				$lang = $pq->find("td")->contents()->eq(22)->text();
				$img = $pq->find(".text-img")->contents()->eq(22);
			}
		}

		// переписать rtrim
		public function prCyAllData($data = array()){

			if (!empty($data)) {
				foreach ($data as $key => $value) {
					$data[$key] = str_replace(chr(9),"", trim( str_replace("\n", "", $data[$key] ) ) ) ;
				}

				$data["intEndDoman"] = intval(mb_substr($data["endDomain"], mb_strpos($data["endDomain"], ' ')));
				$data["intAgeDomain"] = intval($data["ageDomain"]);

				$data["yandexIndex"] = trim($data["yandexIndex"]);
				$data["titleHtml"] = $this->htmlTitlePrCy($data["titleHtml"]);

				$data["endDomain"] = rtrim($data["endDomain"], '.');
				$data["charset_Site"] = rtrim($data["charset_Site"], '.');
				$data["favicon"] = rtrim($data["favicon"], '.');
				$data["wwwRedirect"] = rtrim($data["wwwRedirect"], '.');
				$data["robots"] = rtrim($data["robots"], '.');
				$data["siteMap"] = rtrim($data["siteMap"], '.');
				$data["codeResponse"] = rtrim($data["codeResponse"], '.');
				$data["mainPageWords"] = rtrim($data["mainPageWords"], '.');
				$data["mainPageDescription"] = rtrim($data["mainPageDescription"], '.');
				$data["href_404"] = rtrim($data["href_404"], '.');
				$data["facebookSocial"] = rtrim($data["facebookSocial"], '.');
				$data["vkontakteSocial"] = rtrim($data["vkontakteSocial"], '.');
				$data["googlePlusSocial"] = rtrim($data["googlePlusSocial"], '.');
				$data["microdata"] = rtrim($data["microdata"], '.');
				$data["twitterSocial"] = rtrim($data["twitterSocial"], '.');
				$data["pageSpeed"] = rtrim($data["pageSpeed"], '.');

				$data["codeResponse"] = $this->prCyError_404($data["codeResponse"]);
				$data["href_404"] = $this->href_404($data["href_404"]);

				$data["codeResponse"] = $this->prCyError_404($data["codeResponse"]);
				
				$data["yandexCatalog"] = $this->prCyCatalogYandex($data["yandexCatalog"]);

				$data["yandexCatalog"] = substr(substr($this->prCyCatalogYandex($data["yandexCatalog"]),0, 1200), 0, -1);
				$data["mainPageTitle"] = substr(substr($data["mainPageTitle"], 0, 60), 0, -2);

				$data["mainPageDescription"] = substr(substr($data["mainPageDescription"], 0, 60), 0, -2);

				$data["facebookSocial"] = $this->cutToSimbol($data["facebookSocial"], 0, 70, 0, -1);
				$data["vkontakteSocial"] = $this->cutToSimbol($data["vkontakteSocial"], 0, 70, 0, -2);
				$data["googlePlusSocial"] = $this->cutToSimbol($data["googlePlusSocial"], 0, 70, 0, -2);
				$data["twitterSocial"] = $this->cutToSimbol($data["twitterSocial"], 0, 70, 0, -2);

				$data = $this->checkPrCy($data);

				$this->allData[2] = $data;

				$this->is_in_str($data["pageSpeed"], "Ваш сервер ответил быстро", "pageSpeed");
				$this->is_in_str($data["pageSpeed"], "Россия", "serverLocation");
				$this->is_in_str($data["pageSpeed"], "Указана кодировка UTF-8", "charset_Site");

				$this->headerPrCy($data["titleHtml"][0]);
				$this->loadTime($data["loadTime"]);

				$this->searchIndex($data["yandexIndex"], "yandexIndex");
				$this->searchIndex($data["googleIndex"], "googleIndex");

				$this->yandexCatalog($data["yandexCatalogx"]);
				$this->tic($data["TIC"]);

			} else {
				return false;
			}
			
		}

		protected function yandexCatalog($catalog){
			if (stristr($catalog, "Нет")) {
				$this->allData[2]["yandexCatalogIcon"] = "assets/img/nope.png";
				$this->allData[2]["yandexCatalogIconW"] = 8;
				$this->allData[2]["yandexCatalogIconH"] = 8;
			} else {
				$this->allData[2]["yandexCatalogIcon"] = "assets/img/ok.png";
				$this->allData[2]["yandexCatalogIconW"] = 8;
				$this->allData[2]["yandexCatalogIconH"] = 8;
			}
			
		}

		protected function searchIndex($index, $name){
			if ( intval($index) !== 0 ) {
				if ( ( $index <= 1 ) && ( $index >= 0 ) )  {
					$this->allData[2][$name . "Icon"] = "assets/img/nope.png";
					$this->allData[2][$name . "IconW"] = 8;
					$this->allData[2][$name . "IconH"] = 8;
				} elseif ( ( $index <= 30 ) && ( $index > 1 ) ) {
					$this->allData[2][$name . "Icon"] = "assets/img/HolyFuck.png";
					$this->allData[2][$name . "IconW"] = 2;
					$this->allData[2][$name . "IconH"] = 10;
				} elseif ( $index >= 30 ) {
					$this->allData[2][$name . "Icon"] = "assets/img/ok.png";
					$this->allData[2][$name . "IconW"] = 8;
					$this->allData[2][$name . "IconH"] = 8;
				}
			}
		}

		protected function loadTime($loadTime){
			if ( (float) str_replace(",", ".",substr($loadTime, 0, 3)) > 1 ) {
				$this->allData[2]["loadTimeIcon"] = "assets/img/nope.png";
				$this->allData[2]["loadTimeIconW"] = 8;
				$this->allData[2]["loadTimeIconH"] = 8;
			} else {
				$this->allData[2]["loadTimeIcon"] = "assets/img/ok.png";
				$this->allData[2]["loadTimeIconW"] = 8;
				$this->allData[2]["loadTimeIconH"] = 8;
			}
		}

		protected function cutToSimbol($part, $from, $to, $fromT, $toT){
			return substr(substr($part, $from, $to), $fromT, $toT);
		}


		protected function tic($tic){
			if ($tic > 0 ) {
				$this->allData[2]["ticIcon"] = "assets/img/ok.png";
				$this->allData[2]["ticIconW"] = 8;
				$this->allData[2]["ticIconH"] = 8;
			} else {
				$this->allData[2]["ticIcon"] = "assets/img/nope.png";
				$this->allData[2]["ticIconW"] = 8;
				$this->allData[2]["ticIconH"] = 8;
			}
			
		}		
		public function checkPrCy($data){
			if ( ($data["bondingDomain"] === "Яндекс не считает домен склеенным.") && ($data["bannedSite"] === "Домен не найден в реестре.") && ($data["ags"] === "Фильтр не обнаружен.") ) {

				$data["bondingDomain"] = "Нет";
				$data["bannedSite"] = "Нет";
				$data["ags"] = "Нет";

				$data['sanctions'] = "Нет";

				$data = $this->analizeIconDomenPrCy($data);
			
				return $data;
			} else {

			}
		}

		private function clearGarbage($query, $google, $yandex){
			if ( (count($query)) === (count($google)) || (count($query)) === (count($yandex)) || (count($google)) === (count($yandex)) )  {

				return $megaindexData = array(
						"query" => $query,
						"google" => $google,
						"yandex" => $yandex
					);
			} else {
				// todo 	
				echo "Неравное кол-во столбцов";
			}
			
		}

		public function setImg($img){
			$this->allData[3] = $img;
		}

		public function delImages($img = array()){
			foreach ($img as $key => $value) {
				unlink($_SERVER['DOCUMENT_ROOT'] . 'parser/' . $value);
			}
		}

		// переписать на switch
		protected function analizeIconDomenPrCy($data = array() ){
			if ($data["bondingDomain"] === "Нет") {
				$data["bondingDomainIcon"] = "assets/img/ok.png";
				$data["bondingDomainIconW"] = 8;
				$data["bondingDomainIconH"] = 8;
			} else {
				$data["bondingDomainIcon"] = "assets/img/nope.png";
				$data["bondingDomainIconW"] = 8;
				$data["bondingDomainIconH"] = 8;
			}
			if ($data["bannedSite"] === "Нет") {
				$data["bannedSiteIcon"] = "assets/img/ok.png";
				$data["bannedSiteIconW"] = 8;
				$data["bannedSiteIconH"] = 8;
			} else {
				$data["bannedSiteIcon"] = "assets/img/nope.png";
				$data["bannedSiteIconW"] = 8;
				$data["bannedSiteIconH"] = 8;
			}
			if ($data["ags"] === "Нет") {
				$data["agsIcon"] = "assets/img/ok.png";
				$data["agsIconW"] = 8;
				$data["agsIconH"] = 8;
			} else {
				$data["agsIcon"] = "assets/img/nope.png";
				$data["agsIconW"] = 8;
				$data["agsIconH"] = 8;
			}
			if ($data["intEndDoman"] > 1) {
				$data["intEndDomanIcon"] = "assets/img/ok.png";
				$data["sizeEndDomanW"] = 8;
				$data["sizeEndDomanH"] = 8;
			} else {
				$data["intEndDomanIcon"] = "assets/img/nope.png";
				$data["sizeEndDomanW"] = 8;
				$data["sizeEndDomanH"] = 8;
			} 
			if ($data["ageDomain"] > 1 ) {
				$data["intAgeDomainIcon"] = "assets/img/ok.png";
				$data["sizeAgeDomainIconW"] = 8;
				$data["sizeAgeDomainIconH"] = 8;
			} else {
				$data["intAgeDomainIcon"] = "assets/img/nope.png";
				$data["sizeAgeDomainIconW"] = 8;
				$data["sizeAgeDomainIconH"] = 8;
			}

			unset( $data["intEndDoman"] );
			unset( $data["intAgeDomain"] );
			return $data;
		}


		protected function cutWord($string, $position){
			return stristr($string, $position);
		}

		protected function htmlTitlePrCy($htmlTitle){
			$str = "В структуре вашего сайта используются HTML заголовки H1-H6";
			$htmlTitle = substr(preg_replace("/H[{0-9}]/", "", substr(str_replace(" ", "",str_replace ($str, "", $htmlTitle)), 1)), 1) ;
			$htmlTitle = explode(":", $htmlTitle);

			return $htmlTitle;
		}

		protected function prCyCatalogYandex($catalog){
			$str = array("Показать всё", "Скрыть");

			foreach ($str as $key) {
				$catalog = str_replace($str, "", $catalog);
			}

			return $catalog;
		}

		protected function headerPrCy($header){
			$h1 = intval($header);
			if ($h1 !== 0) {
				if ($h1 === 1) {
					$this->allData[2]["titleHtmlIcon"] = "assets/img/ok.png";
					$this->allData[2]["titleHtmlIconW"] = 8;
					$this->allData[2]["titleHtmlIconH"] = 8;
				} else {
					$this->allData[2]["titleHtmlIcon"] = "assets/img/HolyFuck.png";
					$this->allData[2]["titleHtmlIconW"] = 2;
					$this->allData[2]["titleHtmlIconH"] = 10;
				}
			} else {
				$this->allData[2]["titleHtmlIcon"] = "assets/img/HolyFuck.png";
				$this->allData[2]["titleHtmlIconW"] = 2;
				$this->allData[2]["titleHtmlIconH"] = 10;
			}
		}

		

		public function filterErrorValidatorHtml($error){
			$errors = array();
			$i = 0;
			foreach ($error as $key => $value) {
				$pq = pq($value);
				foreach ($pq->find('li') as $val) {
					$li = pq($val);
					$errors[$i] = trim($li->find("p strong")->text());
					$i++;
				}	
			}

			$countErr = array_count_values($errors);

			$this->allData[4]["html"] = $countErr = array(
					"errors" => $countErr["Error"],
					"warning" => $countErr["Warning"]
				);

			if (intval($countErr["errors"]) > 1) {
				$this->allData[4]["html"]["icon"] = "assets/img/ok.png";
				$this->allData[4]["html"]["iconW"] = 8;
				$this->allData[4]["html"]["iconH"] = 8;
			} else {
				
				$this->allData[4]["html"]["icon"] = "assets/img/nope.png";
				$this->allData[4]["html"]["iconW"] = 8;
				$this->allData[4]["html"]["iconH"] = 8;
			}
			
		}

		public function filterErrorValidatorCss($error){
			$error = trim(preg_replace('~[^0-9]+~','', $error));
			$this->allData[4]["css"] = array(	
					"error" => $error
				);

			if ( intval($error) > 1 ) {
				$this->allData[4]["css"]["icon"] = "assets/img/ok.png";
				$this->allData[4]["css"]["iconW"] = 8;
				$this->allData[4]["css"]["iconH"] = 8;
			} else {
				$this->allData[4]["css"]["icon"] = "assets/img/nope.png";
				$this->allData[4]["css"]["iconW"] = 8;
				$this->allData[4]["css"]["iconH"] = 8;
			}
		}

		protected function prCyError_404($err){
			return str_replace("Все отлично, ", "", $err);
		}

		protected function href_404($err){
			if (stristr($err, "Ссылка со страницы 404 найдена")) {
				return str_replace("Ссылка со страницы 404 найдена", "Да", $err);
			} elseif (stristr($err, "Ссылка со страницы 404 не найдена")) {
				return str_replace("Ссылка со страницы 404 не найдена", "Нет", $err);
			}
		}

		public function getAllData(){
			return $this->allData;
		}

		public function getData($key){
			return $this->allData[$key];
		}


		protected function is_in_str($str, $substr, $name){
			$result = stristr($str, $substr);
			if ($result === FALSE) {
				$this->allData[2][$name . "Icon"] = "assets/img/ok.png";
				
				$this->allData[2][$name . "IconW"] = 8;
				$this->allData[2][$name . "IconH"] = 8;
			} else {
				$this->allData[2][$name . "Icon"] = "assets/img/HolyFuck.png";
			
				$this->allData[2][$name . "IconW"] = 2;
				$this->allData[2][$name . "IconH"] = 10;
				
			}
		}
		/*

			filterErrorValidatorHtml ->
			$error = str_replace("Errors", "Ошибок", $error);
			$error = str_replace("warning", "Предупреждений", $error);
			$error = str_replace("(s)", "", $error);

			$this->allData[4]["html"] = trim($error); <-
		*/

	}