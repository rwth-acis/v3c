<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// https://github.com/rwth-acis/PLEASE-Frontend/blob/7ad5af8d96a0544d57c34799cd892772ceb3cf63/src/app/deploy/space.html

class RoleAPI {
    private $url;
    private $token;

    public function __construct($url, $token) {
        $this->url = $url;
        $this->token = $token;
    }

    public function login() {
      // TODO append auth token
      $response = http_get($this->url . "/o/oauth2/authorizeImplicit?userinfo_endpoint=https://api.learning-layers.eu/o/oauth2/userinfo", array(), $info);
      return ($info['response_code'] == 200);
    }

    public function createSpace($name) {
      // TODO append auth token
      $array = array('openapp.ns.rdf=http://www.w3.org/1999/02/22-rdf-syntax-ns#',
              'openapp.ns.rdfs=http://www.w3.org/2000/01/rdf-schema#',
              'openapp.ns.dcterms=http://purl.org/dc/terms/',
              'openapp.rdf.predicate=http://purl.org/role/terms/space',
              'openapp.rdf.type=http://purl.org/role/terms/Space',
              'openapp.rdfs.label=' . $name);
      $data = join('&', $array);

      http_post_data($this->url . "/spaces", $data, array('headers' => array('Content-Type' => 'application/x-www-form-urlencoded')), $info);

      return ($info['response_code'] == 200);
    }

    public function addActivityToSpace($space, $name) {

    }

    public function removeActivityFromSpace($space, $name) {

    }

    public function addWidgetToSpace($space, $activity, $widgetUrl) {
      // TODO append auth token
      // TODO activity

      $uri = $this->url . '/spaces/' . $space . '/:;';
      $uri .= urlencode('http://www.w3.org/1999/02/22-rdf-syntax-ns#type=http://purl.org/role/terms/OpenSocialGadget;');
      $uri .= urlencode('http://www.w3.org/2000/01/rdf-schema#seeAlso=' . $widgetUrl . ';');
      $uri .= urlencode('predicate=http://purl.org/role/terms/tool');

      http_post_data($this->url . "/spaces", '', array(), $info);

      return ($info['response_code'] == 200);
    }

    public function removeWidgetFromSpace($room, $activity, $widgetInstanceId) {

    }
}

echo "asdf";

$api = new RoleAPI("http://role-sandbox.eu/", "asdf");
echo ($api->createSpace("qwertzukjlmnbvdswqeetrzu") ? "true" : "false");
?>
