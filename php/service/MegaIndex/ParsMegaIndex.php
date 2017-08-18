<?php 
	require ROOT . "/php/service/Parse.php";

	class ParsMegaIndex extends Parse {

		protected $dataMegaind = array(); 
		protected $data;
		protected $multi_curl;

		function __construct($data, $multi_curl){
			$this->data = $data;
			$this->multi_curl = $multi_curl;
		}

		public function parseNavbar(){
			$megaIndex = file_get_contents('https://ru.megaindex.com');

			$document = phpQuery::newDocument($megaIndex);
			$table = $document->find("#wrapper_in .testheader .user_menu2");
		}
		
		public function parseTable($site){
			$megaIndex = file_get_contents('https://ru.megaindex.com/visibility/' . $site . '?ser_id=1,2846');

			$document = phpQuery::newDocument($megaIndex);

			$table = pq($document)->find("#report_tbl tbody");
			$this->data->filterTableMegaindex($table);
		
		}

	}