<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class RoleAPI {
  private $url;
  private $token;
  private $cookie;

  public function __construct($url, $token) {
    $this->url = $url;
    $this->token = $token;
  }

  public function login() {
    $ch = curl_init();
    
    

      //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $this->url . "o/oauth2/authorizeImplicit?userinfo_endpoint=https://api.learning-layers.eu/o/oauth2/userinfo");
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch,CURLOPT_HTTPHEADER, array("access_token: ".$this->token));
    curl_setopt($ch,CURLOPT_HEADER, 1);

    $result = curl_exec($ch);
      //print "curl response is:" . $response;
    if (!curl_errno($ch)) {
      switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
          case 200 || 500:  # OK
          preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
          if(sizeof($matches[1])>0){
            $this->cookie = $matches[1][0];
            $c = explode("=",$matches[1][0]);
            setcookie('conserve_session',$c[1],time()+60, '/');
            header("Cookie: ".$matches[1][0]);
            return true;
          }
          break;
          default:
          return false;
        }
        return false;
      }
        //return ($info['response_code'] == 200);
      curl_close($ch);
    }
    
    private function get_string_between($string, $start, $end){
      $string = ' ' . $string;
      $ini = strpos($string, $start);
      if ($ini == 0) return '';
      $ini += strlen($start);
      $len = strpos($string, $end, $ini) - $ini;
      return substr($string, $ini, $len);
    }

    public function createSpace($name) {
      if(!$this->login()) return 403;

      $ch = curl_init();
      // TODO append auth token
      $array = array('openapp.ns.rdf=http://www.w3.org/1999/02/22-rdf-syntax-ns#',
        'openapp.ns.rdfs=http://www.w3.org/2000/01/rdf-schema#',
        'openapp.ns.dcterms=http://purl.org/dc/terms/',
        'openapp.rdf.predicate=http://purl.org/role/terms/space',
        'openapp.rdf.type=http://purl.org/role/terms/Space',
        'openapp.rdfs.label=' . $name);
      $data = join('&', $array);

        //http_post_data($this->url . "/spaces", $data, array('headers' => array('Content-Type' => 'application/x-www-form-urlencoded')), $info);
      //open connection
      

      //set the url, number of POST vars, POST data
      curl_setopt($ch,CURLOPT_URL, $this->url."spaces");
      curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);


      curl_setopt($ch,CURLOPT_POST, 1);
      curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
      curl_setopt($ch,CURLOPT_HTTPHEADER, array("Cookie: ".$this->cookie));

      $result = curl_exec($ch);
      //print "curl response is:" . $response;
      if (!curl_errno($ch)) {
        switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
          case 200 || 500:  # OK
          curl_close($ch);
          return $this->url."spaces/".$name;
          break;
          default:
          curl_close($ch);
          return -1;
        }
      }
        //return ($info['response_code'] == 200);

    }

    public function addActivityToSpace($space, $name) {
      if(!$this->login()) return 403;

      $ch = curl_init();

        //http_post_data($this->url . "/spaces", $data, array('headers' => array('Content-Type' => 'application/x-www-form-urlencoded')), $info);
      //open connection
      

      //set the url, number of POST vars, POST data
      curl_setopt($ch,CURLOPT_URL, $this->url."spaces/".$space."/:;predicate=http%3A%2F%2Fpurl.org%2Frole%2Fterms%2Factivity");
      curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);


      curl_setopt($ch,CURLOPT_POST, 1);
      curl_setopt($ch,CURLOPT_HTTPHEADER, array("Cookie: ".$this->cookie));
      curl_setopt($ch,CURLOPT_HEADER, true);

      $result = curl_exec($ch);
      $location = trim($this->get_string_between($result."\n","Location: ","\n"));
      //print "curl response is:" . $response;
      if (!curl_errno($ch)) {
        switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
          case 201:  # OK
          $this->setActivityName($location,$name);
          return $location;
          break;
          default:
          return "";
        }
      }
        //return ($info['response_code'] == 200);
      curl_close($ch);
    }

    public function setActivityName($activity,$name){
      if(!$this->login()) return 403;

      $ch = curl_init();

        //http_post_data($this->url . "/spaces", $data, array('headers' => array('Content-Type' => 'application/x-www-form-urlencoded')), $info);
      //open connection
      

      //set the url, number of POST vars, POST data
      curl_setopt($ch,CURLOPT_URL, $activity."/:;predicate=http%3A%2F%2Fpurl.org%2Fopenapp%2Fmetadata");
      curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);


      curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "PUT");
      $post = '{"":{"http://purl.org/dc/terms/title":[{"value":"'.$name.'","type":"literal"}]}}';
      curl_setopt($ch,CURLOPT_POSTFIELDS, $post);
      curl_setopt($ch,CURLOPT_HTTPHEADER, array("Cookie: layouts=%7B%7D; ".$this->cookie,"Content-Type:application/json","Accept:application/json"));
      curl_setopt($ch,CURLOPT_HEADER, true);

      $result = curl_exec($ch);
      curl_close($ch);
    }

    public function removeActivityFromSpace($activity) {
      if(!$this->login()) return 403;

      $ch = curl_init();
      

      //set the url, number of POST vars, POST data
      curl_setopt($ch,CURLOPT_URL, $activity);
      curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);


      curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "DELETE");
      curl_setopt($ch,CURLOPT_HTTPHEADER, array("Cookie: layouts=%7B%7D; ".$this->cookie,"Accept:application/json"));
      curl_setopt($ch,CURLOPT_HEADER, true);

      $result = curl_exec($ch);
      //print "curl response is:" . $response;
      if (!curl_errno($ch)) {
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return ($http_code==200);
      }else{
        echo curl_errno($ch);
        //return ($info['response_code'] == 200);
      }
      curl_close($ch);
    }

    public function addWidgetToSpace($space, $activity, $widgetUrl) {
      if(!$this->login()) return 403;
      
      $uri = $this->url . 'spaces/' . $space . '/:;';
      $uri .= urlencode('http://www.w3.org/1999/02/22-rdf-syntax-ns#type').'='.urlencode('http://purl.org/role/terms/OpenSocialGadget').';';
      $uri .= urlencode('http://www.w3.org/2000/01/rdf-schema#seeAlso').'='.urlencode($widgetUrl).';';
      if(strlen($activity)>3){
        $uri .= urlencode('http://purl.org/role/terms/activity').'='.urlencode($activity).';';
      }
      $uri .= urlencode('predicate').'='.urlencode('http://purl.org/role/terms/tool');
      $ch = curl_init();
      curl_setopt($ch,CURLOPT_URL, $uri);
      curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);


      curl_setopt($ch,CURLOPT_POST, 1);
      curl_setopt($ch,CURLOPT_HTTPHEADER, array("Cookie: ".$this->cookie));
      curl_setopt($ch,CURLOPT_HEADER, true);

      $result = curl_exec($ch);
      $location = trim($this->get_string_between($result."\n","Location: ","\n"));
      //print "curl response is:" . $response;
      if (!curl_errno($ch)) {
        switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
          case 201:  # OK
          return $location;
          break;
          default:
          echo 'Unerwarter HTTP-Code: ', $http_code, "\n";
        }
      }
        //return ($info['response_code'] == 200);
      curl_close($ch);

    }

    public function removeWidgetFromSpace($widget) {
      $this->login();
      $ch = curl_init();
      

      //set the url, number of POST vars, POST data
      curl_setopt($ch,CURLOPT_URL, $widget);
      curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);


      curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "DELETE");
      curl_setopt($ch,CURLOPT_HTTPHEADER, array("Cookie: layouts=%7B%7D; ".$this->cookie,"Accept:application/json"));
      curl_setopt($ch,CURLOPT_HEADER, true);

      $result = curl_exec($ch);
      //print "curl response is:" . $response;
      if (!curl_errno($ch)) {
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return ($http_code==200);
      }else{
        echo curl_errno($ch);
        //return ($info['response_code'] == 200);
      }
      curl_close($ch);

    }
  }
  ?>
