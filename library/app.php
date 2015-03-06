<?php
class app {

  public static function __callStatic($name,$value){
    $file = __DIR__."/../web/apps/$name/index.php";
    if(is_file($file)) {
      $function = require($file);
      if(is_callable($function)) $value = call_user_func_array($function,$value);
    }
    $file = __DIR__."/../web/apps/$name/index.phtml";
    if(is_file($file)) require($file);
    else return $value;
  }

}
?>
