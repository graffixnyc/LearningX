<?php 
include_once("analyticstracking.php");
include 'internal_api.php';

//Declare the Array
$practice=array(); 
//Set the Array to call the function (this function is in internal_api.php)
$practice=getPractice($_POST["topicid"]);

//Loop through the results and display them.. you can write out HTML with them as you see I'm writing out the topic and then the BR HTML tag.  If you need help concatenating the tags let me know
foreach($practice as $item) {
    echo $item['question'] . '<br>';
}

?>