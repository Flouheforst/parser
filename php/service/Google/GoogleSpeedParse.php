<?php
    class GoogleSpeedParse { 

        protected $urlDesktop;
        protected $urlMobile;
        private $options = array();
        private $user_agent;
        protected $data;

        public function __construct($url, $data){
            $this->data = $data;

            $this->urlDesktop = 'https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=' . $url . '&strategy=desktop';

            $this->urlMobile = 'https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=' . $url . '&strategy=mobile';

            $this->user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0'; 

            $this->options = array(
                CURLOPT_CUSTOMREQUEST  =>"GET",       
                CURLOPT_POST           =>false,        
                CURLOPT_USERAGENT      => $this->user_agent, 
                CURLOPT_RETURNTRANSFER => true,     
                CURLOPT_HEADER         => false,    
                CURLOPT_FOLLOWLOCATION => true,     
                CURLOPT_ENCODING       => "",      
                CURLOPT_AUTOREFERER    => true,     
                CURLOPT_CONNECTTIMEOUT => 120,     
                CURLOPT_TIMEOUT        => 120,     
                CURLOPT_MAXREDIRS      => 10,       
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            );

        }

        public function parseMobile(){
            $pMobile = curl_init( $this->urlMobile );
            curl_setopt_array($pMobile, $this->options);

            $content = curl_exec($pMobile);
            $err = curl_errno($pMobile);
            $errmsg = curl_error($pMobile);
            $data = curl_getinfo($pMobile);
            curl_close($pMobile);

            if ( $this->checkErr($data["http_code"]) ) {

                $res = json_decode($content, true);

                $percentMobile = $res["ruleGroups"]["SPEED"]["score"];

                if (!empty($percentMobile)) {
                    $this->data->setPercentMobile($percentMobile);
                }
            } else {
                App::redirect("parser/php/resourses/page/notfound.view.php");
                App::render("notfound");
            }
        }

        public function parseDesktop(){
            $pDesktop = curl_init( $this->urlDesktop );
            curl_setopt_array($pDesktop, $this->options);
            $content = curl_exec($pDesktop);
            $err = curl_errno($pDesktop);
            $errmsg = curl_error($pDesktop);
            $data = curl_getinfo($pDesktop);
            curl_close($pDesktop);

            if ( $this->checkErr($data["http_code"]) ) {
                $res = json_decode($content, true);

                $percentDesktop = $res["ruleGroups"]["SPEED"]["score"];

                if (!empty($percentDesktop)) {
                    $this->data->setPercentDesktop($percentDesktop);
                } 
            } else {
                App::redirect("parser/php/resourses/page/notfound.view.php");
                App::render("notfound");
            }
        }

        protected function checkErr($content){
            if($content !== 200) {
                return false;
            } else {
                return true;
            }
        }
    }
    


  