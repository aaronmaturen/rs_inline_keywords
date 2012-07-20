<?php
  error_reporting(E_ALL);
  ini_set('display_errors','On');
  require '../../../include/db.php';
  require '../../../include/authenticate.php';if (!checkperm("a")) {exit("Permission denied");}
  require '../../../include/general.php';
  require '../../../include/resource_functions.php';
  $refs  = explode(' ',str_replace('+',' ',$_REQUEST['refs']));
  foreach($refs as $ref){
    # echo sql_query("update resource set archive=2 where ref='$ref'");
    delete_resource($ref);
  }
  echo 'marked as archived';
?>