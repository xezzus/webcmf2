<?php
namespace utils;

class uri {

  public static function get(){
    return urldecode($_SERVER['REQUEST_URI']);
  }

  public static function arr(){
    $uri = explode('/',self::get());
    foreach($uri as $key=>$value){
      $value = trim($value);
      if(empty($value)) unset($uri[$key]);
      else $uri[$key] = $value;
    }
    $uri = array_values($uri);
    return $uri;
  }
}
?>
