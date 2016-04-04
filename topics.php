<?php 
include_once("analyticstracking.php");
include 'internal_api.php';
$topics=array(); 
$topics=getTopics();

foreach($topics as $item) {
    echo $item['topic'] . <br>;
    // to know what's in $item
    //echo '<pre>'; var_dump($item);
}

?>