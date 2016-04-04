<?php 
include_once("analyticstracking.php");
include 'internal_api.php';

//Declare the Array
$topics=array(); 
//Set the Array to call the function (this function is in internal_api.php)
$topics=getTopics();

//Loop through the results and display them.. you can write out HTML with them as you see I'm writing out the topic and then the BR HTML tag.  If you need help concatenating the tags let me know
foreach($topics as $item) {
    echo $item['topic'] . '<br>';
}

?>