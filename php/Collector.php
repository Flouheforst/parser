<?php 
	require "View/Pdf.php";

	class Collector {

		protected function p($message){
			echo "<pre>";
			print_r($message);
			echo "</pre>";
			die();
		}


		public function assemble($site, $dataSite, $dataWork){
	 		$pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, '', false, false, false);
			/* ----------------------------------1 стр------------------------------------- */
			$pdf->AddPage(array(675, 1140),array(675, 1140));
			ob_end_clean();
			$pdf->addImagesOnPage(array('assets/img/1.jpg', 'assets/img/2.jpg', 'assets/img/3.jpg'), array(
				"1" => array(
						"w" => 675,
						"h" => 380,
						"top" => 0,
						"left" => 0
					),
				"2" => array(
						"w" => 675,
						"h" => 380,
						"top" => 380,
						"left" => 0
					)
				,
				"3" => array(
						"w" => 675,
						"h" => 380,
						"top" => 760,
						"left" => 0
					)
			));

			$MyriadRegular = TCPDF_FONTS::addTTFfont(__DIR__ . '/../assets/font/MyriadPro/MyriadProRegular/MyriadProRegular.ttf', 'TrueTypeUnicode', '', 100);
			$LatoMedium = TCPDF_FONTS::addTTFfont(__DIR__ . '/../assets/font/Lato/Lato-Medium.ttf', 'TrueTypeUnicode', '', 100);
			$LatoLight = TCPDF_FONTS::addTTFfont(__DIR__ . '/../assets/font/Lato/Lato-Light.ttf', 'TrueTypeUnicode', '', 100);
			$LatoThinItalic = TCPDF_FONTS::addTTFfont(__DIR__ . '/../assets/font/Lato/Lato-ThinItalic.ttf', 'TrueTypeUnicode', '', 100);
			$data = date('d.m.Y');


			$pdf->SetFont($MyriadRegular, '', 30, '', false);
			$pdf->setText('<p style="color:#d19e73; font-size:135px;">Аудит сайта</p>', 154, 67);


			$pdf->SetFont($LatoMedium, '', 30, '', false);
			$pdf->setText('<p style="color:#d19e73; font-size:64px;"> www.' . $site . '</p>', 149, 125);

			$pdf->SetFont($LatoLight, '', 30, '', false);
			$pdf->setText('<p style="color:#d19e73; font-size:48px;">Дата: <b>' . $data . '</b></p>', 154, 158);


			$pdf->setText('<p style="color:#d19e73; font-size:24px;">Веб-разработка</p>', 113, 351);
			$pdf->setText('<p style="color:#d19e73; font-size:24px;">SEO</p>', 207, 351);
			$pdf->setText('<p style="color:#d19e73; font-size:24px;">Чат-боты</p>', 254, 351);
			$pdf->setText('<p style="color:#d19e73; font-size:24px;">Построение продаж через интернет</p>', 330, 351);
			$pdf->setText('<p style="color:#d19e73; font-size:24px;">Фирменный стиль</p>', 480, 351);

			/* ----------------------------------2 стр------------------------------------- */

			// мокапы 
			$pdf->addImagesOnPage(array('assets/img/mop.png', 'assets/img/plant.png', 'assets/img/phone.png'), array(
				"1" => array(
						"w" => 365,
						"h" => 290,
						"top" => 430,
						"left" => 162	
					),
				"2" => array(
						"w" => 180,
						"h" => 180,
						"top" => 525,
						"left" => 42
					),
				"3" => array(
						"w" => 160,
						"h" => 150,
						"top" => 550,
						"left" => 460
					)
			));

			//картинки для мокапа 
			$pdf->addImagesOnPage( array($dataSite[3]["comp"], $dataSite[3]["plant"], $dataSite[3]["phone"] ), array(
				"1" => array(
						"w" => 252,
						"h" => 140,
						"top" => 479,
						"left" => 219
					),
				"2" => array(
						"w" => 101,
						"h" => 139,
						"top" => 546,
						"left" => 82
					),
				"3" => array(
						"w" => 55,
						"h" => 92,
						"top" => 581,
						"left" => 513
					)
			));

			$pdf->SetFont($LatoMedium, '', 30, '', false);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">2/16</p>', 632, 733);
			/* ----------------------------------3 стр------------------------------------- */

			$pdf->SetFont($LatoMedium, '', 30, '', false);

			$pdf->setText('<p style="color:#d19e73; font-size:64px;">АНАЛИЗ ДОМЕННОГО ИМЕНИ</p>', 80, 860);

			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Возраст доменного имени</p>', 90, 920);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Окончание доменного имени</p>', 90, 945);

			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Склейка домена</p>', 90, 970);

			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Реестр запрещенных сайтов</p>', 90, 995);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Санкции поисковых систем</p>', 90, 1020);


			$pdf->addImagesOnPage( array($dataSite[2]["bondingDomainIcon"], $dataSite[2]["bannedSiteIcon"], $dataSite[2]["agsIcon"] ), array(
				"1" => array(
						"w" => 8,
						"h" => 8,
						"top" => 973,
						"left" => 80
					),
				"2" => array(
						"w" => 8,
						"h" => 8,
						"top" => 998,
						"left" => 80
					),
				"3" => array(
						"w" => 8,
						"h" => 8,
						"top" => 1023,
						"left" => 80
					)
			));

			$pdf->addImagesOnPage( array($dataSite[2]["intEndDomanIcon"], $dataSite[2]["intAgeDomainIcon"] ), array(
				"1" => array(
						"w" => $dataSite[2]["sizeEndDomanW"],
						"h" => $dataSite[2]["sizeEndDomanH"],
						"top" => 923,
						"left" => 80
					),
				"2" => array(
						"w" => $dataSite[2]["sizeAgeDomainIconW"],
						"h" => $dataSite[2]["sizeAgeDomainIconH"],
						"top" => 948,
						"left" => 80
					)
			));


			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["ageDomain"] . '</p>', 450, 920);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["endDomain"] . '</p>', 450, 945);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["bondingDomain"] . '</p>', 450, 970);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["bannedSite"] . '</p>', 450, 995);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["sanctions"] . '</p>', 450, 1020);

			//url, width height страницы, width height картинки, последние 2 настройка стр
			// указывается текст + разметка 
			// TODO table gen
			// данные ширина nav, табл, шрифт 


			$fontname = TCPDF_FONTS::addTTFfont(__DIR__ . '/../assets/font/MyriadPro/MyriadProRegular/MyriadProRegular.ttf', 'TrueTypeUnicode', '', 100);

			//$pdf->genTable($dataSite[1]["data"], 6, 2, $fontname);

			$pdf->SetFont($LatoMedium, '', 30, '', false);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">3/16</p>', 632, 1110);
			/* ----------------------------------4 стр------------------------------------- */
			$pdf->AddPage(array(675, 380),array(675, 380));
			$pdf->addImagesOnPage( array("assets/img/4.jpg"), array(
				"1" => array(
						"w" => 675,
						"h" => 380,
						"top" => 0,
						"left" => 0
					)
			));

			$pdf->SetFont($LatoMedium, '', 30, '', false);
			$pdf->setText('<p style="color:#d19e73; font-size:64px;">ТЕХНИЧЕСКИЕ ХАРАКТЕРИСТИКИ</p>', 80, 100);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Местоположения сервера</p>', 100, 160);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Кодировка сайта</p>', 100, 185);

			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["serverLocation"] . '</p>', 450, 160);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["charset_Site"] . ' </p>', 450, 185);

		
			$pdf->addImagesOnPage( array($dataSite[2]["serverLocationIcon"], $dataSite[2]["charset_SiteIcon"]), array(
				"1" => array(
						"w" => $dataSite[2]["serverLocationIconW"],
						"h" => $dataSite[2]["serverLocationIconH"],
						"top" => 163,
						"left" => 90
					),
				"2" => array(
						"w" => $dataSite[2]["charset_SiteIconW"],
						"h" => $dataSite[2]["charset_SiteIconH"],
						"top" => 188,
						"left" => 90
					)
			));
	

			$pdf->SetFont($LatoMedium, '', 30, '', false);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">4/16</p>', 632, 350);

			/* ----------------------------------5 стр------------------------------------- */
			$pdf->AddPage(array(675, 380),array(675, 380));
			$pdf->addImagesOnPage( array("assets/img/5.jpg"), array(
				"1" => array(
						"w" => 675,
						"h" => 380,
						"top" => 0,
						"left" => 0
					)
			));

			$pdf->setText('<p style="color:#d19e73; font-size:64px;">СИСТЕМЫ АНАЛИТИКИ</p>', 80, 100);

			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Яндекс.Метрика</p>', 100, 160);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">GoogleAnalytics</p>', 100, 185);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">LiveInternet</p>', 100, 210);


			$pdf->addImagesOnPage( array("assets/img/yandex_metr.png", "assets/img/Google-Analytics-icon.png", "assets/img/18.png"), array(
				"1" => array(
						"w" => 8,
						"h" => 8,
						"top" => 164,
						"left" => 230
					),
				"2" => array(
						"w" => 8,
						"h" => 8,
						"top" => 189,
						"left" => 230
					),
				"3" => array(
						"w" => 8,
						"h" => 8,
						"top" => 214,
						"left" => 230
					)
			));

			$pdf->SetFont($LatoMedium, '', 30, '', false);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">5/16</p>', 632, 350);

			/* ----------------------------------6 стр------------------------------------- */
			$pdf->AddPage(array(675, 380),array(675, 380));
			$pdf->addImagesOnPage( array("assets/img/6.jpg"), array(
				"1" => array(
						"w" => 675,
						"h" => 380,
						"top" => 0,
						"left" => 0
					)
			));

			$pdf->setText('<p style="color:#d19e73; font-size:64px;">ПОКАЗАТЕЛИ В YANDEX</p>', 80, 100);

			$pdf->setText('<p style="color:#d19e73; font-size:40px;">ТИЦ</p>', 100, 160);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Проиндексированно</p>', 100, 185);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Яндекс каталог </p>', 100, 210);
			
			
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["TIC"] . '</p>', 320, 160);
		
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["yandexIndex"] . ' страниц</p>', 320, 185);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["yandexCatalog"] . ' страниц</p>', 320, 210);
				/*
			$pdf->setText('<p style="color:#d19e73; font-size:40px;"> ' . $dataSite[2]["charset_Site"] . ' </p>', 300, 210);
			*/

			$pdf->SetFont($LatoMedium, '', 30, '', false);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">6/16</p>', 632, 350);
			/* ----------------------------------7 стр------------------------------------- */
			$pdf->AddPage(array(675, 380),array(675, 380));
			$pdf->addImagesOnPage( array("assets/img/7.jpg"), array(
				"1" => array(
						"w" => 675,
						"h" => 380,
						"top" => 0,
						"left" => 0
					)
			));

			$pdf->setText('<p style="color:#d19e73; font-size:64px;">ПОКАЗАТЕЛИ В GOOGLE</p>', 80, 100);

			$pdf->setText('<p style="color:#d19e73; font-size:40px;">PR</p>', 100, 160);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Проиндексированно</p>', 100, 185);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Главное зеркало</p>', 100, 210);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Каталог DMOZ</p>', 100, 235);

			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["googleIndex"] . ' страниц</p>', 320, 185);
			$pdf->SetFont($LatoMedium, '', 30, '', false);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">7/16</p>', 632, 350);
			/* ----------------------------------8 стр------------------------------------- */
			$pdf->AddPage(array(675, 380),array(675, 380));
			$pdf->addImagesOnPage( array("assets/img/8.jpg"), array(
				"1" => array(
						"w" => 675,
						"h" => 380,
						"top" => 0,
						"left" => 0
					)
			));

			$pdf->setText('<p style="color:#d19e73; font-size:64px;">ЮЗАБИЛИТИ</p>', 80, 100);

			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Favicon</p>', 100, 160);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Горизонтальная прокрутка</p>', 100, 185);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Наличие flash анимаций</p>', 100, 210);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Размеры шрифтов</p>', 100, 235);


			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["favicon"] . '</p>', 320, 160);
		
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["sizeFont"] . ' страниц</p>', 323, 235);


			$pdf->SetFont($LatoMedium, '', 30, '', false);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">8/16</p>', 632, 350);
			/* ----------------------------------9 стр------------------------------------- */
			$pdf->AddPage(array(675, 380),array(675, 380));
			$pdf->addImagesOnPage( array("assets/img/9.jpg"), array(
				"1" => array(
						"w" => 675,
						"h" => 380,
						"top" => 0,
						"left" => 0
					)
			));

			$pdf->addImagesOnPage( array("assets/img/nopebuke.png"), array(
				"1" => array(
						"w" => 235,
						"h" => 122,
						"top" => 120,
						"left" => 420
					)
			));
			$pdf->addImagesOnPage( array($dataSite[3]["404"]), array(
				"1" => array(
						"w" => 160,
						"h" => 93,
						"top" => 130,
						"left" => 456
					)
			));

			$pdf->setText('<p style="color:#d19e73; font-size:64px;">СТРАНИЦА ОШИБКИ 404</p>', 80, 100);

			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Код ответа страницы 404</p>', 100, 160);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Ссылка страницы 404</p>', 100, 185);



			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["codeResponse"] . '</p>', 280, 160);
		
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["href_404"] . '</p>', 280, 185);


			$pdf->SetFont($LatoMedium, '', 30, '', false);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">9/16</p>', 632, 350);
			/* ----------------------------------10 стр------------------------------------- */
			$pdf->AddPage(array(675, 380),array(675, 380));
			$pdf->addImagesOnPage( array("assets/img/10.jpg"), array(
				"1" => array(
						"w" => 675,
						"h" => 380,
						"top" => 0,
						"left" => 0
					)
			));

			$pdf->setText('<p style="color:#d19e73; font-size:64px;">СКОРОСТЬ ЗАГРУЗКИ САЙТА</p>', 80, 100);

			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Среднее время ответа</p>', 100, 160);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Среднее время загрузки</p>', 100, 185);

			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["pageSpeed"] . '</p>', 320, 160);
		
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["loadTime"] . ' страниц</p>', 320, 185);


			$pdf->SetFont($LatoMedium, '', 30, '', false);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">10/16</p>', 626, 350);
			/* ----------------------------------11 стр------------------------------------- */
			$pdf->AddPage(array(675, 380),array(675, 380));
			$pdf->addImagesOnPage( array("assets/img/11.jpg"), array(
				"1" => array(
						"w" => 675,
						"h" => 380,
						"top" => 0,
						"left" => 0
					)
			));

			$pdf->setText('<p style="color:#d19e73; font-size:64px;">КАЧЕСТВО КОДА</p>', 80, 100);

			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Ошибки в HTML-коде</p>', 100, 160);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Ошибки В CSS</p>', 100, 185);


			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[4]["html"]["errors"] . ' Ошибок ' . $dataSite[4]["html"]["warning"] . ' Предупреждений' . '</p>', 320, 160);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[4]["css"] . ' Ошибок</p>', 320, 185);

			$pdf->SetFont($LatoMedium, '', 30, '', false);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">11/16</p>', 626, 350);
			/* ----------------------------------12 стр------------------------------------- */
			$pdf->AddPage(array(675, 380),array(675, 380));
			$pdf->addImagesOnPage( array("assets/img/12.jpg"), array(
				"1" => array(
						"w" => 675,
						"h" => 380,
						"top" => 0,
						"left" => 0
					)
			));

			$pdf->setText('<p style="color:#d19e73; font-size:64px;">ОПТИМИЗАЦИЯ ПО GOOGLE PAGE SPEED INSIGHTS</p>', 80, 100);

			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Desktop</p>', 100, 160);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Mobile</p>', 100, 185);


			$pdf->SetFont($LatoMedium, '', 30, '', false);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">12/16</p>', 626, 350);
			/* ----------------------------------13 стр------------------------------------- */
			$pdf->AddPage(array(675, 380),array(675, 380));
			$pdf->addImagesOnPage( array("assets/img/13.jpg"), array(
				"1" => array(
						"w" => 675,
						"h" => 380,
						"top" => 0,
						"left" => 0
					)
			));

			$pdf->setText('<p style="color:#d19e73; font-size:64px;">ОПТИМИЗАЦИЯ ДЛЯ ПОИСКОВЫХ СИСТЕМ</p>', 80, 100);

			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Файл robots.txt</p>', 100, 160);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Файл sitemap.XML</p>', 100, 185);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Редирект с WWW</p>', 100, 210);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Микроразметка</p>', 100, 235);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">SSL-сертификат</p>', 100, 260);


			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["robots"] . '</p>', 320, 160);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["siteMap"] . '</p>', 320, 185);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["wwwRedirect"] . '</p>', 320, 210);

			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["microdata"] . '</p>', 320, 235);

			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["ssl"] . '</p>', 320, 260);


			$pdf->SetFont($LatoMedium, '', 30, '', false);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">13/16</p>', 626, 350);
			/* ----------------------------------14 стр------------------------------------- */
			$pdf->AddPage(array(675, 380),array(675, 380));
			$pdf->addImagesOnPage( array("assets/img/14.jpg"), array(
				"1" => array(
						"w" => 675,
						"h" => 380,
						"top" => 0,
						"left" => 0
					)
			));

			$pdf->setText('<p style="color:#d19e73; font-size:64px;">МЕТА-ТЕГИ</p>', 80, 100);

			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Заголовок страницы title</p>', 100, 160);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Описание страницы description</p>', 100, 185);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Оптимизация заголовков на странице</p>', 100, 210);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Количество слов на странице</p>', 100, 235);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Длина текста на странице</p>', 100, 260);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Плотность ключевых слов</p>', 100, 285);

			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["mainPageTitle"] . '</p>', 450, 160);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["mainPageDescription"] . '</p>', 450, 185);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["mainPageText"] . '</p>', 450, 235);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["mainPageWords"] . '</p>', 450, 260);

			$pdf->SetFont($LatoMedium, '', 30, '', false);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">14/16</p>', 626, 350);
			/* ----------------------------------15 стр------------------------------------- */
			$pdf->AddPage(array(675, 380),array(675, 380));
			$pdf->addImagesOnPage( array("assets/img/15.jpg"), array(
				"1" => array(
						"w" => 675,
						"h" => 380,
						"top" => 0,
						"left" => 0
					)
			));

			$pdf->setText('<p style="color:#d19e73; font-size:64px;">АНАЛИЗ ЗАГОЛОВКОВ</p>', 80, 100);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . htmlspecialchars("<H1>", ENT_QUOTES) . '</p>', 100, 160);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . htmlspecialchars("<H2>", ENT_QUOTES) . '</p>', 100, 185);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . htmlspecialchars("<H3>", ENT_QUOTES) . '</p>', 100, 210);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . htmlspecialchars("<H4>", ENT_QUOTES) . '</p>', 100, 235);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . htmlspecialchars("<H5>", ENT_QUOTES) . '</p>', 100, 260);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . htmlspecialchars("<H6>", ENT_QUOTES) . '</p>', 100, 285);
			$pdf->addImagesOnPage( array($dataSite[2]["titleHtmlIcon"]), array(
				"1" => array(
						"w" => $dataSite[2]["titleHtmlIconW"],
						"h" => $dataSite[2]["titleHtmlIconH"],
						"top" => 162,
						"left" => 90
					)
			));

			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["titleHtml"][0] . '</p>', 318, 160);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["titleHtml"][1] . '</p>', 318, 185);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["titleHtml"][2] . '</p>', 318, 210);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["titleHtml"][3] . '</p>', 318, 235);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["titleHtml"][4] . '</p>', 318, 260);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["titleHtml"][5] . '</p>', 318, 285);




			$pdf->SetFont($LatoMedium, '', 30, '', false);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">15/16</p>', 626, 350);
			/* ----------------------------------16 стр------------------------------------- */
			$pdf->AddPage(array(675, 380),array(675, 380));
			$pdf->addImagesOnPage( array("assets/img/16.jpg"), array(
				"1" => array(
						"w" => 675,
						"h" => 380,
						"top" => 0,
						"left" => 0
					)
			));
			
			$pdf->setText('<p style="color:#d19e73; font-size:64px;">СОЦИАЛЬНЫЕ ФАКТОРЫ</p>', 80, 100);

			$pdf->setText('<p style="color:#d19e73; font-size:40px;">ВКонтакте</p>', 100, 160);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Facebook</p>', 100, 185);
			//$pdf->setText('<p style="color:#d19e73; font-size:40px;">Instagram</p>', 100, 210);
			//$pdf->setText('<p style="color:#d19e73; font-size:40px;">YouTube</p>', 100, 235);
			//$pdf->setText('<p style="color:#d19e73; font-size:40px;">Одноклассники</p>', 100, 260);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Twitter</p>', 100, 210);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">Google Plus</p>', 100, 235);
			//$pdf->setText('<p style="color:#d19e73; font-size:40px;">Telegram</p>', 100, 335);


			$pdf->SetFont($LatoMedium, '', 30, '', false);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">16/16</p>', 626, 350);

			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["facebookSocial"] . '</p>', 318, 160);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["googlePlusSocial"] . '</p>', 318, 185);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["twitterSocial"] . '</p>', 318, 210);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">' . $dataSite[2]["vkontakteSocial"] . '</p>', 318, 235);



			/* ----------------------------------Конечная------------------------------------- */
			$pdf->Byby("Kompot");
			$pdf->safePDf($site);
			

		}
	} 