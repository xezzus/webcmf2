<?php
namespace utils;

class compress {

  public function html($data){
    $data = preg_replace([
      '/<!--[\s\S]*-->/Ui',
      '/[\r\n\t]/Ui'
    ],'',$data);
    $data = preg_replace('/\>[\s]+/Ui','>',$data);
    $data = preg_replace('/[\s]+\</Ui','<',$data);
    $data = preg_replace('/[\s]{2,}/Ui',' ',$data);
    return $data;
  }

}
?>
