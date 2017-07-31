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

		// todo
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


		public function prCyAllData($data = array()){
			if (!empty($data)) {
				foreach ($data as $key => $value) {
					$data[$key] = str_replace(chr(9),"", trim( str_replace("\n", "", $data[$key] ) ) ) ;
				}
				$data = $this->checkPrCy($data);

				$this->allData[2] = $data;
			} else {
				return false;
			}
			
		}

		public function checkPrCy($data){
			if ( ($data["bondingDomain"] === "Яндекс не считает домен склеенным.") && ($data["bannedSite"] === "Домен не найден в реестре.") && ($data["ags"] === "Фильтр не обнаружен.") ) {

				$data["bondingDomain"] = "Нет";
				$data["bannedSite"] = "Нет";
				$data["ags"] = "Нет";

				$data['sanctions'] = "Нет";

				$data = $this->analizeIconDomen($data);
			
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

		public function getAllData(){
			return $this->allData;
		}

		public function setImg($img){
			$this->allData[3] = $img;
		}

		public function delImages($img = array()){
			foreach ($img as $key => $value) {
				unlink($_SERVER['DOCUMENT_ROOT'] . 'parser/' . $value);
			}
		}

		protected function analizeIconDomen($data = array() ){
			if ( ($data["bondingDomain"] === "Нет") && ($data["bannedSite"] === "Нет") && ($data["ags"] === "Нет") ) {
				$data["bondingDomainIcon"] = "assets/img/nope.png";
				$data["bannedSiteIcon"] = "assets/img/nope.png";
				$data["agsIcon"] = "assets/img/nope.png";
			}

			return $data;
		}

		/*
		private function checkRegExp($megaindexData){
		
		}
		*/

	}