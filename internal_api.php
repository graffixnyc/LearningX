<?php
ini_set('display_errors', 1);
error_reporting(E_ALL|E_STRICT);
include 'db.php';

function getUser($uid) {
	$sql = "CALL getUser(:uid)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql);
		$stmt->bindParam("uid", $uid);
		$stmt->execute();
		$results = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$results[] = $row;
		}
		return $results;
	}
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	} 
}
function updateUser($uid,$firstname,$lastname,$username) {
	$sql = "CALL updateUser(:username,:firstname,:lastname,:uid)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql);
		$stmt->bindParam("uid", $uid);
		$stmt->bindParam("firstname", $firstname);
		$stmt->bindParam("lastname", $lastname);
		$stmt->bindParam("username", $username);
		$stmt->execute();
		$results = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$results[] = $row;
		}
		return $results;
	}
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	} 
}
function getTopics() {
	$sql = "CALL getTopics()";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql);
		$stmt->execute();
		$results = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$results[] = $row;
		}
		return $results;
	}
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	} 
}
function getPractice($topicid) {
	$sql = "CALL getPractice(:topicid)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql);
		$stmt->bindParam("topicid", $topicid);
		$stmt->execute();
		$results = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$results[] = $row;
		}
		return $results;
	}
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	} 
}

function deleteUser($uid) {
	$sql = "CALL deleteUser(:uid)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql);
		$stmt->bindParam("uid", $uid);
		$stmt->execute();
		$results = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$results[] = $row;
		}
		return $results;
	}
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	} 
}

function addUser($username,$password,$firstname,$lastname) {
	$sql = "CALL createUser(:username, :firstname,:lastname,:password)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql);  
		$stmt->bindParam("username", $username);
		$stmt->bindParam("firstname", $firstname);
		$stmt->bindParam("lastname", $lastname);
		$stmt->bindParam("password", $password);
		$stmt->execute();
		$results = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$results[] = $row;
		}
		return $results;
		
	}
	catch(PDOException $e) {
		if ($e->getCode() ==  23000){
		$_SESSION["UserReg"]= "User Already in Database";
			header( 'Location: register.php') ;
		}
			//echo $e->getCode();
		
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function login($username,$password) {
	$sql = "CALL checkPassword(:username,:password)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql);
		$stmt->bindParam("username", $username);
		$stmt->bindParam("password", $password);
		$stmt->execute();		
		$results = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$results[] = $row;
		}
		return $results;
		$dbCon = null;
	}
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function getResources($topicID) {
	$sql = "CALL getResources(:topicID)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql);
		$stmt->bindParam("topicID", $topicID);
		$stmt->execute();		
		$results = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$results[] = $row;
		}
		return $results;
		$dbCon = null;
	}
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function checkUsername($username) {
	$sql = "CALL checkUsername(:username)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql);
		$stmt->bindParam("username", $username);
		$stmt->execute();		
		$results = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$results[] = $row;
		}
		return $results;
		$dbCon = null;
	}
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function forgotPassword($username) {
	$sql = "CALL forgotPassword(:username)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql);
		$stmt->bindParam("username", $username);
		$stmt->execute();		
		$results = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$results[] = $row;
		}
		
			return $results;
		
		
		$dbCon = null;
	}
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}
function changePassword($curpass,$pass,$uname,$reset) {
	if ($reset==1){
		$sql = "CALL resetPassword(:curpass,:pass,:uname)";
	}
	else{
		$sql = "CALL changePassword(:curpass,:pass,:uname)";
	}
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql);
		$stmt->bindParam("curpass", $curpass);
		$stmt->bindParam("pass", $pass);
		$stmt->bindParam("uname", $uname);
		$stmt->execute();		
		$results = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$results[] = $row;
		}
			return $results;
		$dbCon = null;
	}
	catch(PDOException $e) {
		echo  $e->getMessage() ; 
	}
}

function getUsername($resettoken) {
	$sql = "CALL getUsernameFromToken(:resettoken)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql);
		$stmt->bindParam("resettoken", $resettoken);
		$stmt->execute();
		$results = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$results[] = $row;
		}
		return $results;
	}
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	} 
}





?>