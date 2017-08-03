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

				$data = $this->serverLocation($data);
				$data = $this->charset_Site($data);

				$data = $this->headerPrCy($data);

				$data["yandexCatalog"] = $this->prCyCatalogYandex($data["yandexCatalog"]);

				$data["yandexCatalog"] = substr(substr($this->prCyCatalogYandex($data["yandexCatalog"]),0, 1200), 0, -1);

				$data = $this->checkPrCy($data);

				$this->allData[2] = $data;
			} else {
				return false;
			}
			
		}

		protected function serverLocation($data){
			if (stristr($data["serverLocation"], "Россия")) {
				$data["serverLocationIcon"] = "assets/img/ok.png";

				$data["serverLocationIconW"] = 8;
				$data["serverLocationIconH"] = 8;
			} else {
				$data["serverLocationIcon"] = "assets/img/HolyFuck.png";

				$data["serverLocationIconW"] = 2;
				$data["serverLocationIconH"] = 10;
			}
			
			return $data;
		}

		protected function charset_Site($data){
			if (stristr($data["charset_Site"], "Указана кодировка UTF-8")) {
				$data["charset_SiteIcon"] = "assets/img/ok.png";

				$data["charset_SiteIconW"] = 8;
				$data["charset_SiteIconH"] = 8;
			} else {
				$data["charset_SiteIcon"] = "assets/img/HolyFuck.png";

				$data["charset_SiteIconW"] = 2;
				$data["charset_SiteIconH"] = 10;
			}
			
			return $data;			
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

		// после такого надо выбрасывать с крышы
		protected function analizeIconDomenPrCy($data = array() ){
			if ( ($data["bondingDomain"] === "Нет") && ($data["bannedSite"] === "Нет") && ($data["ags"] === "Нет") ) {
				$data["bondingDomainIcon"] = "assets/img/ok.png";
				$data["bannedSiteIcon"] = "assets/img/ok.png";
				$data["agsIcon"] = "assets/img/ok.png";
			} elseif ( ($data["bondingDomain"] === "Да") && ($data["bannedSite"] === "Нет") && ($data["ags"] === "Нет") ) {
				$data["bondingDomainIcon"] = "assets/img/nope.png";
				$data["bannedSiteIcon"] = "assets/img/ok.png";
				$data["agsIcon"] = "assets/img/ok.png";
			} elseif ( ($data["bondingDomain"] === "Нет") && ($data["bannedSite"] === "Да") && ($data["ags"] === "Нет") ) {
				$data["bondingDomainIcon"] = "assets/img/ok.png";
				$data["bannedSiteIcon"] = "assets/img/nope.png";
				$data["agsIcon"] = "assets/img/ok.png";
			} elseif ( ($data["bondingDomain"] === "Нет") && ($data["bannedSite"] === "Нет") && ($data["ags"] === "Да") ) {
				$data["bondingDomainIcon"] = "assets/img/ok.png";
				$data["bannedSiteIcon"] = "assets/img/ok.png";
				$data["agsIcon"] = "assets/img/nope.png";
			}  elseif ( ($data["bondingDomain"] === "Да") && ($data["bannedSite"] === "Да") && ($data["ags"] === "Нет") ) {
				$data["bondingDomainIcon"] = "assets/img/nope.png";
				$data["bannedSiteIcon"] = "assets/img/nope.png";
				$data["agsIcon"] = "assets/img/ok.png";
			}	elseif ( ($data["bondingDomain"] === "Да") && ($data["bannedSite"] === "Нет") && ($data["ags"] === "Да") ) {
				$data["bondingDomainIcon"] = "assets/img/nope.png";
				$data["bannedSiteIcon"] = "assets/img/ok.png";
				$data["agsIcon"] = "assets/img/nope.png";
			}	elseif ( ($data["bondingDomain"] === "Да") && ($data["bannedSite"] === "Нет") && ($data["ags"] === "Да") ) {
				$data["bondingDomainIcon"] = "assets/img/ok.png";
				$data["bannedSiteIcon"] = "assets/img/ok.png";
				$data["agsIcon"] = "assets/img/ok.png";
			} 	elseif ( ($data["bondingDomain"] === "Да") && ($data["bannedSite"] === "Нет") && ($data["ags"] === "Да") ) {
				$data["bondingDomainIcon"] = "assets/img/nope.png";
				$data["bannedSiteIcon"] = "assets/img/nope.png";
				$data["agsIcon"] = "assets/img/nope.png";
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
			$h1 = intval($header["titleHtml"][0]);
			if ($h1 !== 0) {
				if ($h1 === 1) {
					$header["titleHtmlIcon"] = "assets/img/ok.png";
					$header["titleHtmlIconW"] = 8;
					$header["titleHtmlIconH"] = 8;
				} else {
					$header["titleHtmlIcon"] = "assets/img/HolyFuck.png";
					$header["titleHtmlIconW"] = 2;
					$header["titleHtmlIconH"] = 10;
				}
			} else {
				$header["titleHtmlIcon"] = "assets/img/HolyFuck.png";
				$header["titleHtmlIconW"] = 2;
				$header["titleHtmlIconH"] = 10;
			}
			return $header;
			
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
		
		}

		public function filterErrorValidatorCss($error){
			$error = trim(preg_replace('~[^0-9]+~','', $error));
			$this->allData[4]["css"] = $error;
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
		/*

			filterErrorValidatorHtml ->
			$error = str_replace("Errors", "Ошибок", $error);
			$error = str_replace("warning", "Предупреждений", $error);
			$error = str_replace("(s)", "", $error);

			$this->allData[4]["html"] = trim($error); <-
		*/

	}