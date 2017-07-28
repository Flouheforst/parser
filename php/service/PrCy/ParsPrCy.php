<?php 
	
	class ParsPrCy extends Parse{

		protected $dataPrCt;
		protected $site;
		protected $data;

		function __construct($site, $data){
			parent::__construct($data);
			$this->site = $site;
			$this->data = $data;
		}

		// парсит 3 слайд pdf 
		public function parseThPage(){
			
			$this->site = $this->data->cutUrl($this->site);

			
			$prCy = file_get_contents('https://a.pr-cy.ru/'. $this->site .'/');
			

			$document = phpQuery::newDocument($prCy);

			$ageDomain = $document->find("#whoisCreationDate .content-test")->text();
			$endDomain = $document->find("#whoisExpirationDate .content-test")->text();
			$bondingDomain = $document->find("#yandexGlue .content-test")->text();
			$bannedSite = $document->find("#roskomnadzor .content-test")->text();
			$ags = $document->find("#yandexAgs .content-test")->text();
			
			$dataPrCy = array(
					"ageDomain" => $ageDomain,
					"endDomain" => $endDomain,
					"bondingDomain" => $bondingDomain,
					"bannedSite" => $bannedSite,
					"ags" => $ags
				);	
						
			$this->data->prCyThPage($dataPrCy);

		}


	}