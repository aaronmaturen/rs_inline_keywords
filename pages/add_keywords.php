<?php

include_once "../../../include/db.php";
include_once "../../../include/authenticate.php";if (!checkperm("a")) {exit("Permission denied");}
include_once "../../../include/general.php";
include_once "../../../include/resource_functions.php";

$keywords = explode(' ',str_replace('+',' ',$_REQUEST['keywords']));
$refs  = explode(' ',str_replace('+',' ',$_REQUEST['refs']));
foreach($refs as $ref){
    foreach($keywords as $keyword){
        add_keyword_mappings($ref, $keyword,8);
    }
}
?>