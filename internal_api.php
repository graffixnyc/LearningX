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
function addTopic($topic) {
	$sql = "CALL addTopic(:topic)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql);
		$stmt->bindParam("topic", $topic);
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
function addResource($topicid,$resourcetype, $resource, $resourcedisplay, $featured) {
	$sql = "CALL createResource(:topicid,:resourcetype, :resource, :resourcedisplay, :featured)";

	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql);
		$stmt->bindParam("topicid", $topicid);
		$stmt->bindParam("resourcetype", $resourcetype);
		$stmt->bindParam("resource", $resource);
		$stmt->bindParam("resourcedisplay", $resourcedisplay);
		$stmt->bindParam("featured", $featured);

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
function getAnswers($questionid) {
	$sql = "CALL getAnswers(:questionid)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql);
		$stmt->bindParam("questionid", $questionid);
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

function markQuestionAnswered($question_id, $user_id, $answered_already, $answered_correct) {
    $sql = "CALL getUserProgress(:question_id, :user_id, :answered_already, :answered_correct)";
    try {
		$dbCon = getConnection();
        $stmt = $dbCon->prepare($sql);
        $stmt->bindParam("question_id", $question_id);
        $stmt->bindParam("user_id", $user_id);
        $stmt->bindParam("answered_already", $answered_already);
        $stmt->bindParam("answered_correct", $answered_correct);
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

function getUserProgress($topic_level, $user_id) {
    $sql = "CALL getUserProgress(:topic_level, :user_id)";
    try {
		$dbCon = getConnection();
        $stmt = $dbCon->prepare($sql);
        $stmt->bindParam("topic_level", $topic_level);
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();
        $results = array();
        //$resultset = $stmt->fetchALL(PDO::FETCH_ASSOC);
        //echo 'All are '.$resultset[0]["totalquestions"].' here.';
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = $row;
        }
        return $results;
    }
    catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
    }
}

function updateProgress($inlevel, $user_id, $correct) {
    $sql = "CALL getUserProgress(:inlevel, :user_id, :correct)";
    try {
		$dbCon = getConnection();
        $stmt = $dbCon->prepare($sql);
        $stmt->bindParam("inlevel", $inlevel);
        $stmt->bindParam("user_id", $user_id);
        $stmt->bindParam("correct", $correct);
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
