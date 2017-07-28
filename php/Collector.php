<?php 
	require "View/Pdf.php";
	//ob_start();

	class Collector {
		public function assemble($site, $dataSite){
			$pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, '', false, false, false);
			/* ----------------------------------1 стр------------------------------------- */

			// 1 пути к файлам 2 размеры картинки страница по стандарту А4
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
			$pdf->setText('<p style="color:#d19e73; font-size:135px;">АУДИТ САЙТА</p>', 154, 67);


			$pdf->SetFont($LatoMedium, '', 30, '', false);
			$pdf->setText('<p style="color:#d19e73; font-size:64px;"> www.' . $site . '</p>', 149, 125);

			$pdf->SetFont($LatoLight, '', 30, '', false);
			$pdf->setText('<p style="color:#d19e73; font-size:48px;">Дата: <b>' . $data . '</b></p>', 154, 158);


			$pdf->setText('<p style="color:#d19e73; font-size:24px;">ВЕБ-РАЗРАБОТКА</p>', 113, 352);
			$pdf->setText('<p style="color:#d19e73; font-size:24px;">SEO</p>', 207, 352);
			$pdf->setText('<p style="color:#d19e73; font-size:24px;">ЧАТ-БОТЫ</p>', 254, 352);
			$pdf->setText('<p style="color:#d19e73; font-size:24px;">ПОСТРОЕНИЕ ПРОДАЖ ЧЕРЕЗ ИНТЕРНЕТ</p>', 318, 352);
			$pdf->setText('<p style="color:#d19e73; font-size:24px;">ФИРМЕННЫЙ СТИЛЬ</p>', 480, 352);
			/* ----------------------------------2 стр------------------------------------- */
			// мокапы 
			$pdf->addImagesOnPage(array('assets/img/mop.png', 'assets/img/plant.png', 'assets/img/phone.png'), array(
				"1" => array(
						"w" => 360,
						"h" => 270,
						"top" => 440,
						"left" => 162	
					),
				"2" => array(
						"w" => 180,
						"h" => 160,
						"top" => 525,
						"left" => 42
					),
				"3" => array(
						"w" => 160,
						"h" => 140,
						"top" => 550,
						"left" => 460
					)
			));


			//картинки для мокапа 
			$pdf->addImagesOnPage( array($dataSite[3]["comp"], $dataSite[3]["plant"], $dataSite[3]["phone"] ), array(
				"1" => array(
						"w" => 238,
						"h" => 130,
						"top" => 486,
						"left" => 217
					),
				"2" => array(
						"w" => 89,
						"h" => 120,
						"top" => 547,
						"left" => 78
					),
				"3" => array(
						"w" => 51,
						"h" => 87,
						"top" => 581,
						"left" => 500
					)
			));




			/* ----------------------------------3 стр------------------------------------- */
			$pdf->SetFont($LatoMedium, '', 30, '', false);

			$pdf->setText('<p style="color:#d19e73; font-size:64px;">1. АНАЛИЗ ДОМЕННОГО ИМЕНИ</p>', 110, 860);

			$pdf->setText('<p style="color:#d19e73; font-size:40px;">1.1 ВОЗРАСТ ДОМЕННОГО ИМЕНИ</p>', 130, 920);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">1.2 ОКОНЧАНИЕ ДОМЕННОГО ИМЕНИ</p>', 130, 945);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">1.3 СКЛЕЙКА ДОМЕНА</p>', 130, 970);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">1.4 РЕЕСТР ЗАПРЕЩЕННЫХ САЙТОВ</p>', 130, 995);
			$pdf->setText('<p style="color:#d19e73; font-size:40px;">1.5 САНКЦИИ ПОИСКОВЫХ СИСТЕМ</p>', 130, 1020);

			$pdf->SetFont($LatoThinItalic, '', 30, '', false);

			$pdf->setText('<p style="color:#64594d; font-size:40px;">' . $dataSite[2]["ageDomain"] . '</p>', 450, 920);
			$pdf->setText('<p style="color:#64594d; font-size:40px;">' . $dataSite[2]["endDomain"] . '</p>', 450, 945);
			$pdf->setText('<p style="color:#64594d; font-size:40px;">' . $dataSite[2]["bondingDomain"] . '</p>', 450, 970);
			$pdf->setText('<p style="color:#64594d; font-size:40px;">' . $dataSite[2]["bannedSite"] . '</p>', 450, 995);
			$pdf->setText('<p style="color:#64594d; font-size:40px;">' . $dataSite[2]["sanctions"] . '</p>', 450, 1020);


			//url, width height страницы, width height картинки, последние 2 настройка стр
			// указывается текст + разметка 
			// TODO table gen
			// данные ширина nav, табл, шрифт 
			/*
			$pdf->AddPage(array(675, 1140),array(675, 1140));

			$fontname = TCPDF_FONTS::addTTFfont(__DIR__ . '/../assets/font/MyriadPro/MyriadProRegular/MyriadProRegular.ttf', 'TrueTypeUnicode', '', 100);

			$pdf->genTable($dataSite[1]["data"], 6, 2, $fontname);
			*/
			$pdf->Byby("Kompot");
		}
	} 