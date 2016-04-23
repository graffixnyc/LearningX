<?php 

include 'internal_api.php';
session_start();

$_SESSION['topicid'] = $_GET['topicid'];
$_SESSION["intended"] = "practice";
header("Location: login");

?>