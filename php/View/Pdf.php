<?php
	require "../libs/tcpdf/tcpdf.php";
		
	define("URLROOT", $_SERVER['DOCUMENT_ROOT'] . "parser/");
	define("FORMATPDF", "A4");

	class Pdf extends TCPDF {
		function __construct($orientation, $unit, $format, $bool1, $charset, $bool2, $headerBool, $footerBool) {
		    parent::__construct($orientation, $unit, $format, $bool1, $charset, $bool2);

		    // set document information
			$this->SetCreator(PDF_CREATOR);
			$this->SetAuthor('Nik');
			$this->SetTitle('Kompot');
			$this->SetSubject('---');
			$this->SetKeywords('---');

			// set default header data
			$this->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
			$this->setFooterData(array(0,64,0), array(0,64,128));

			// set header and footer fonts
			$this->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

			$this->setPrintHeader($headerBool);
			$this->setPrintFooter($footerBool);

			// set default monospaced font
			$this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$this->SetHeaderMargin(0);
			$this->SetFooterMargin(0);

			// set auto page breaks
			$this->SetAutoPageBreak(FAlSE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$this->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		}

		//вывод картинок на одну страницу !!! переписать 
		public function addImagesOnPage($urlImg = array(), $sizeImg = array() ){
			
			$countUrl = count($urlImg);
			$countSize = count($sizeImg);
			
			if ($countUrl === $countSize) {
				$data = new WorkWithData();
				$urlSize = $data->megrgeArra($urlImg, $sizeImg);
				
				$counterUrl = 1;
				$counterSize = 2;
				if (is_array($urlSize)) {

					if ($countUrl === 3) {
						for ($i = 1; $i < count($urlSize) - 2 ; $i++) { 
							$img_file = URLROOT . $urlSize[$counterUrl];
							$this->addImageNewPage( $img_file,  $urlSize[$counterSize]["left"],$urlSize[$counterSize]["w"], $urlSize[$counterSize]["h"], $urlSize[$counterSize]["top"]);
							$counterUrl += 2;
							$counterSize += 2;
						}
					} elseif ($countUrl === 2) {
						for ($i = 0; $i < count($urlSize) - 2; $i++) { 
							$img_file = URLROOT . $urlSize[$counterUrl];
							$this->addImageNewPage( $img_file,  $urlSize[$counterSize]["left"],$urlSize[$counterSize]["w"], $urlSize[$counterSize]["h"], $urlSize[$counterSize]["top"]);
							$counterUrl += 2;
							$counterSize += 2;

						}
					} elseif ($countUrl === 1) {
						for ($i = 1; $i < count($urlSize); $i++) { 
							$img_file = URLROOT . $urlSize[$counterUrl];
							$this->addImageNewPage( $img_file,  $urlSize[$counterSize]["left"],$urlSize[$counterSize]["w"], $urlSize[$counterSize]["h"], $urlSize[$counterSize]["top"]);
						}
					} else {
						// todo 
						echo "превышен лимит";
					}

				} else {
					// todo
					echo "что то не то с массивом";
				}
				
			} else {
				// todo
				echo "Неравное количество переданных параметров";
			}

		}

		// добавление картинки
		public function addImageNewPage($url, $left, $wigthImg, $heightImg, $top, $headerBool= false, $footerBool= false) {



			$bMargin = $this->getBreakMargin();
        	$auto_page_break = $this->AutoPageBreak;
       		$this->SetAutoPageBreak(false, 0);
			$this->Image($url, $left, $top, $wigthImg, $heightImg, '', '', '', false, 300, '', false, false, 0);
			$this->SetAutoPageBreak($auto_page_break, $bMargin);
        	$this->setPageMark();
		}

		public function coloredTable($header, $data, $heightNav, $heightTable, $font, $width1 = 60, $width2 = 60, $width3 = 60, $width4 = 0, $width5 = 0, $width6 = 0) {
		
		
			$this->SetFont($font, '', 10);
			
			$w = array($width1, $width2, $width3, $width4, $width5, $width6);

			$num_headers = count($header);

			for( $i = 0; $i < $num_headers; ++$i ) {
				$this->SetDrawColor(1, 1, 1);
				$this->SetFillColor(255, 255, 255);
				$this->setCellPaddings(0, $heightNav, 0, $heightNav);
				$this->Cell($w[$i], 1, $header[$i], 1, 0, 'C', 1);
			}

			$this->Ln();
			// fill менять четность нечетность строк по цвету
			$fill = true;
			
			for ($i=0; $i < count($data["query"]); $i++) {
				//цвет границы
				$this->SetDrawColor(1, 1, 1);
				// цвет заполнения						
				$this->SetFillColor(224, 235, 255);
				// настраиваем высоту
				$this->setCellPaddings(0, $heightTable, 0, $heightTable);
				// 6 выравнивание
				$this->Cell($w[0], 6, $data["query"][$i], 'LR', 0, 'C', $fill);
				$this->Cell($w[0], 6, $data["yandex"][$i], 'LR', 0, 'C', $fill);
				$this->Cell($w[0], 6, $data["google"][$i], 'LR', 0, 'C', $fill);
				$this->Ln();

				$fill = !$fill;
			}

			$this->Cell(array_sum($w), 0, '', 'T');
		}

		public function genTable($table, $heightNav, $heightTable, $font){
			$header = array('Запрос', 'Яндекс Москва Органика', 'Google Москва Органика');
			$this->coloredTable($header, $table, $heightNav, $heightTable, $font);
		}

		// вывод текста
		public function setText($text, $left = 0, $top = 0){
$html = <<<EOD
$text
EOD;
			$this->writeHTMLCell( 0, 0, $left, $top, $html, 0, 1, 0, true, false, true);
		}
		public function safePDf($site){
			$this->Output( $_SERVER['DOCUMENT_ROOT'] . 'parser/assets/pdf/' . $site . '.pdf', 'F');
		}
		// отдать pdf с именем $name
		public function Byby($name){
			$this->Output( $name . '.pdf', 'I');
		}
	} 