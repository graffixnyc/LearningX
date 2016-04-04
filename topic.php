<?php 
include_once("analyticstracking.php");
include 'internal_api.php';
if (!empty($_GET['id'])){
	//Declare the Array
	$resources=array(); 
	//Set the Array to call the function (this function is in internal_api.php)
	$resources=getResources($_GET['id']);
	//Loop through the results and display them.. you can write out HTML with them as you see I'm writing out the topic and then the BR HTML tag.  If you need help concatenating the tags let me know
	foreach($resources as $item) {
    	echo $item['topicID'] . ' ' .  $item['resourceType'] . ' ' .  $item['resource'] . ' ' . $item['featured'] . '<br>';
	}
}

?>