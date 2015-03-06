<?php
class cfg {

  static private $cfg;

  static function __callStatic($name,$arg){
    if(is_null(self::$cfg)){
      $cfg = __DIR__.'/../config/config.php';
      if(is_file($cfg)) self::$cfg = require_once($cfg);
      else return false;
      if(!is_array(self::$cfg)) return false;
    } 
    if(isset(self::$cfg[$name])) {
      if(isset($arg[1])) return self::$cfg[$name][$arg[0]][$arg[1]];
      elseif(isset($arg[0])) return self::$cfg[$name][$arg[0]];
      else return json_decode(json_encode(self::$cfg[$name]));
    }
  }

  private function __clone(){}
  private function __wakeup(){}

}
?>
