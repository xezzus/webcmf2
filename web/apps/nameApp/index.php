<?php
use base\db;
return function(){
  db::execute('insert into pages (title) values ("best this title");');
  return 'nameApp'; 
}
?>
