<?php 
	
	class ParsPrCy extends Parse{
		protected $site;
		protected $data;

		function __construct($site, $data){
			parent::__construct($data);
			$this->site = $site;
			$this->data = $data;
		}

		public function allData(){
			$this->site = $this->data->cutUrl($this->site);

			$prCy = file_get_contents('https://a.pr-cy.ru/'. $this->site .'/');

			$document = phpQuery::newDocument($prCy);
			/*
			$cms = $document->find("#ipCountry .content-test")->text();
			*/
			$tablePrCy = $document->find("#mainPageTechs .table-tech tbody");

			$ageDomain = $document->find("#whoisCreationDate .content-test")->text();
			$endDomain = $document->find("#whoisExpirationDate .content-test")->text();
			$bondingDomain = $document->find("#yandexGlue .content-test")->text();
			$bannedSite = $document->find("#roskomnadzor .content-test")->text();
			$ags = $document->find("#yandexAgs .content-test")->text();
			$serverLocation = $document->find("#ipCountry .content-test")->text();
			$charset_Site = $document->find("#mainPageEncoding .content-test")->text();
			$TIC = $document->find("#yandexCitation .content-test")->text();
			$favicon = $document->find("#favicon .content-test")->text();
			$sizeFont = $document->find("#pageSpeedUseLegibleFontSizes .content-test")->text();
			$robots = $document->find("#robotsTxt .content-test")->text();
			$siteMap = $document->find("#sitemap .content-test")->text();
			$ssl = $document->find("#ssl .content-test")->text();
			$titleHtml = $document->find("#mainPageHeaders .content-test")->text();
			$yandexIndex = $document->find("#yandexIndex .content-test")->text();
			$googleIndex = $document->find("#googleIndex .content-test")->text();
			$yandexCatalog = $document->find("#yandexCatalog .content-test")->text();
			$codeResponse = $document->find("#page404StatusCode .content-test")->text();
			$href_404 = $document->find("#page404BackLink .content-test")->text();
			$pageSpeed = $document->find("#pageSpeedServerResponseTime .content-test")->text();
			$loadTime = $document->find("#loadTime .content-test")->text();
			$microdata = $document->find("#microdataSchemaOrg .content-test")->text();
			$mainPageText = $document->find("#mainPageTextLength .content-test")->text();
			$mainPageWords = $document->find("#mainPageWordsCount .content-test")->text();
			$facebookSocial = $document->find("#facebookSocial .content-test")->text();
			$vkontakteSocial = $document->find("#vkontakteSocial .content-test")->text();
			$googlePlusSocial = $document->find("#googlePlusSocial .content-test")->text();
			$twitterSocial = $document->find("#twitterSocial .content-test")->text();
			$wwwRedirect = $document->find("#wwwRedirect .content-test")->text();
			$mainPageTitle = $document->find("#mainPageTitle .content-test")->text();
			$mainPageDescription = $document->find("#mainPageDescription .content-test")->text();



			$dataPrCy = array(
					"ageDomain" => $ageDomain,
					"endDomain" => $endDomain,
					"bondingDomain" => $bondingDomain,
					"bannedSite" => $bannedSite,
					"ags" => $ags,
					"serverLocation" => $serverLocation,
					"charset_Site" => $charset_Site,
					"TIC" => $TIC,
					"favicon" => $favicon,
					"sizeFont" => $sizeFont,
					"robots" => $robots,
					"siteMap" => $siteMap,
					"yandexIndex" => $yandexIndex,
					"googleIndex" => $googleIndex,
					"ssl" => $ssl,
					"yandexCatalog" => $yandexCatalog,
					"codeResponse" => $codeResponse,
					"href_404" => $href_404,
					"pageSpeed" => $pageSpeed,
					"loadTime" => $loadTime,
					"microdata" => $microdata,
					"mainPageText" => $mainPageText,
					"mainPageWords" => $mainPageWords,
					"facebookSocial" => $facebookSocial,
					"vkontakteSocial" => $vkontakteSocial,
					"googlePlusSocial" => $googlePlusSocial,
					"twitterSocial" => $twitterSocial,
					"wwwRedirect" => $wwwRedirect,
					"mainPageTitle" => $mainPageTitle,
					"mainPageDescription" => $mainPageDescription,
					"titleHtml" => $titleHtml
				);	

			$this->data->filterPrCyTable($tablePrCy);
			$this->data->prCyAllData($dataPrCy);
		}
	

	}