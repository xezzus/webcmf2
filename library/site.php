<?php
use utils\compress;

class site {

  public function getFile($nameView=null){
    if(empty($nameView)){
      $path = __DIR__."/../web/page/";
    } else {
      $path = __DIR__."/../web/view/$nameView/";
    }
    $uri = explode('/',$_SERVER['REQUEST_URI']);
    foreach($uri as $key=>$value){ if(empty(trim($value))) { unset($uri[$key]); continue; } }
    $uri = array_values($uri);
    for($i=count($uri)-1; $i>=0; $i--){
      $nextUri = implode('/',array_slice($uri,0,$i+1));
      $isFile = $path.$nextUri.'/index.phtml';
      if(is_file($isFile)) break;
      else $isFile = false;
    }
    if($isFile) return $isFile;
    else if(is_file($path.'index.phtml')) return $path.'index.phtml';
  }

  public function findContent($nameView=null){
    $file = $this->getFile();
    ob_start();
    require($file);
    $content = ob_get_clean();
    # get/set view
    preg_match_all('/\<\!\-\-[\s]*\{(.+)\}[\s]*\-\-\>/Ui',$content,$tpl);
    $tpl = array_map(function($tpl){
      $tpl = trim($tpl);
      return $tpl;
    },$tpl[1]);
    foreach($tpl as $key=>$value){
      if($file = $this->getFile($value)) {
        ob_start();
        require($file);
        $contentView = ob_get_clean();
        $content = preg_replace("/\<\!\-\-[\s]*\{$value\}[\s]*\-\-\>/Ui",$contentView,$content);
      }
    }
    # get/set variable
    preg_match_all('/\<\!\-\-[\s]*\[(.+)\][\s]*\-\-\>/Ui',$content,$tpl);
    $tpl = array_map(function($tpl){
      $tpl = trim($tpl);
      return $tpl;
    },$tpl[1]);
    # insert variable
    foreach($tpl as $key=>$value){
      if(!isset($this->{$value})) continue;
      if(is_array($this->{$value})) $this->{$value} = implode('',$this->{$value});
      $content = preg_replace("/\<\!\-\-[\s]*\[$value\][\s]*\-\-\>/Ui",$this->{$value},$content);
    }
    unset($key,$value);
    # compress
    $compress = new compress;
    $content = $compress->html($content);
    # echo HTML
    echo $content;
  }

  public function __construct(){
    $this->findContent();
  }

}
?>
