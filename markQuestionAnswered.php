<?php 

include 'internal_api.php';
session_start();
// Call "markQuestionAnswered" Method
// echo var_dump($_POST);
$quesitonid = (int) $_POST['quesitonid'];
$userid = (int) $_POST['userid'];
$answeredAlready = (int) $_POST['answeredAlready'];
$answeredCorrect = (int) $_POST['answeredCorrect'];
markQuestionAnswered($quesitonid, $userid, $answeredAlready, $answeredCorrect);
echo "success";

?>