<?php
class Translations
{

    private $db;

    private $lang;

    private $langOrder;

    function __construct() {
        $this->db = require 'db_connect.php';
    }

    public function selectLanguage($l) {
      $this->lang = $l;

      $this->langOrder = array('en', 'de', 'es', 'it', 'gr');
      $this->langOrder = array_diff($this->langOrder, [$l]);
      array_unshift($this->langOrder, $this->langOrder);
    }

    public function get($identifier) {
      $res = $this->getByLanguages($identifier, $this->langOrder);

      if ($res == false) {
        return false;
      }

      if ($res['lang'] == $this->lang) {
        return $res['text'];
      }
      else {
        return "UNTRANSLATED [$res['lang']]: " . $res['text'];
      }
    }

    public function getByLanguages($identifier, $languages) {
      foreach ($languages as $lang) {
        $text = $this->getByLang($identifier, $lang);
        if ($text != false) {
          return array('text' => $text, 'lang' => $lang);
        }
      }

      return false;
    }

    public function getByLang($identifier, $lang) {
        $stmt = $this->db->prepare("SELECT text FROM `translations` WHERE identifier=:identifier AND lang=:lang");
        $stmt->bindParam(":identifier", $identifier, PDO::PARAM_STR);
        $stmt->bindParam(":lang", $lang, PDO::PARAM_STR);

        if (!$stmt->execute()) {
          print_r( $stmt->errorInfo() );
          die('Could not get translation.');
        }

        $res = $stmt->fetch(PDO::FETCH_OBJ);

        if (isset($res->text)) {
          return $res->text;
        }
        else {
          return false;
        }
    }

    public function set($identifier, $text) {
        $stmt = $this->db->prepare("REPLACE INTO translations (identifier, lang, `text`) VALUES (:identifier, :lang, :text)");
        $stmt->bindParam(":identifier", $identifier, PDO::PARAM_STR);
        $stmt->bindParam(":lang", $this->lang, PDO::PARAM_STR);
        $stmt->bindParam(":text", $text, PDO::PARAM_STR);

        if (!$stmt->execute()) {
          print_r( $stmt->errorInfo() );
          die('Could not set translation.');
        }
    }
}
?>
