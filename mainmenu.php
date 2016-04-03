<?php include_once("analyticstracking.php") ?>
<?php session_start();
if ($_SESSION["loggedin"]=='1'){ 
	echo 'LOGGED IN';
?>
	
<?php }
else{
	$_SESSION["intended"]="mainmenu";
	header( 'Location: login' ) ;
}
?>
