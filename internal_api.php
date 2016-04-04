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
	$sql = "CALL checkPassword(:username,md5(:password))";
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

function addUserProjects($id,$projectname,$client,$projectdesc,$projectdeadline,$projectdeadlinetime) {
	if (empty($client)){
		$client=NULL;
	}
	if(!empty($projectdeadline)){
		$time_in_24_hour_format  = date("H:i", strtotime($projectdeadlinetime));
		$mySqlFormattedDate = $projectdeadline;
	}
	else{
		$mySqlFormattedDate = NULL;
		$time_in_24_hour_format=NULL;
	}
	$sql = "CALL createProject(:projectname, :projectdesc,:projectdeadline,:id,:projectdeadlinetime,:client)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql);  
		$stmt->bindParam("projectname", $projectname);
		$stmt->bindParam("client", $client);
		$stmt->bindParam("projectdesc", $projectdesc);
		$stmt->bindParam("projectdeadline", $mySqlFormattedDate);
		$stmt->bindParam("id", $id);
		$stmt->bindParam("projectdeadlinetime", $time_in_24_hour_format);
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

function getUserProjects($id,$sortby,$completed) {
	$sql_query = "CALL getUserProjects(:id,:sortby,:completed)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql_query);
		$stmt->bindParam("id", $id);
		$stmt->bindParam("sortby", $sortby);
		$stmt->bindParam("completed", $completed);
		$stmt->execute();
		$dbCon = null;
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

function getUserProject($uid,$pid) {
	$sql_query = "CALL getUserProject(:uid,:pid)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql_query);
		$stmt->bindParam("uid", $uid);
		$stmt->bindParam("pid", $pid);
		$stmt->execute();
		
		$dbCon = null;
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

function updateUserProject($pid,$projname,$projectdesc,$projectdeadline,$projectdeadlinetime, $id,$client)
 {
	if (empty($client)){
		$client=NULL;
	}
	if(!empty($projectdeadline)){
		$mySqlFormattedDate = $projectdeadline;
	}
	else{
		$mySqlFormattedDate = NULL;
	}
	if(!empty($projectdeadlinetime)){
		$time_in_24_hour_format  = date("H:i", strtotime($projectdeadlinetime));
	}
	else{
		$time_in_24_hour_format=NULL;
	}
    $sql_query = "CALL updateUserProject(:pid,:projname,:projectdesc,:projectdeadline,:projectdeadlinetime, :id,:client)";
    try {
        $dbCon = getConnection();
		$stmt = $dbCon->prepare($sql_query);
		$stmt->bindParam("id", $id);
		$stmt->bindParam("pid", $pid);
		$stmt->bindParam("projname", $projname);
		
		$stmt->bindParam("projectdesc", $projectdesc);
		$stmt->bindParam("projectdeadline", $mySqlFormattedDate );
		$stmt->bindParam("projectdeadlinetime", $time_in_24_hour_format);
		$stmt->bindParam("client", $client);
		$stmt->execute();
		$dbCon = null;
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

function deleteProject($id,$pid) {
	$sql = "DELETE FROM projects WHERE user_id=:id and project_id=:pid";
	try{
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql);
		$stmt->bindParam("id", $id);
		$stmt->bindParam("pid", $pid);
		$stmt->execute();
		$dbCon = null;
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
function toggleCompleteProject($pid,$uid) {
	$sql_query = "CALL toggleCompleteProject(:pid,:uid)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql_query);
		$stmt->bindParam("pid", $pid);
		$stmt->bindParam("uid", $uid);
		$stmt->execute();
		$dbCon = null;
		$results = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$results[] = $row;
		}
		return $results;	
	}
	catch(PDOException $e) {
		echo '{"error":{"text123":'. $e->getMessage() .'}}';
	}	
}

function searchProjectByName($uid,$query,$completed) {
	$sql = "SELECT * FROM projects WHERE project_complete=:completed and UPPER(project_name) LIKE :query and user_id=" . $uid . " ORDER BY project_name";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql);
		$query = "%".$query."%";
		$stmt->bindParam("query", $query);
		$stmt->bindParam("completed", $completed);
		$stmt->execute();
		$dbCon = null;
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

function getProjectTasks($uid,$pid) {
	$sql_query = "CALL getTasks(:pid,:uid)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql_query);
		$stmt->bindParam("uid", $uid);
		$stmt->bindParam("pid", $pid);
		$stmt->execute();
		//$projects = $stmt->fetchAll(PDO::FETCH_OBJ);
		$dbCon = null;
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

function getTaskDetails($tid,$uid) {
	$sql_query = "CALL getTaskDetails(:tid,:uid)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql_query);
		$stmt->bindParam("tid", $tid);
		$stmt->bindParam("uid", $uid);
		$stmt->execute();
		$dbCon = null;
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
function startTask($tid) {
	$sql_query = "CALL startTask(:tid)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql_query);
		$stmt->bindParam("tid", $tid);
		$stmt->execute();
		$dbCon = null;
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

function endTask($tid,$taskdesc) {
	$sql_query = "CALL endTask(:tid,:taskdesc)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql_query);
		$stmt->bindParam("tid", $tid);
		$stmt->bindParam("taskdesc", $taskdesc);
		$stmt->execute();
		$dbCon = null;
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
function toggleCompleteTask($tid,$uid) {
	$sql_query = "CALL toggleCompleteTask(:tid,:uid)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql_query);
		$stmt->bindParam("tid", $tid);
		$stmt->bindParam("uid", $uid);
		$stmt->execute();
		$dbCon = null;
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
function deleteTask($tid,$uid) {
	$sql_query = "CALL deleteTask(:tid,:uid)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql_query);
		$stmt->bindParam("tid", $tid);
		$stmt->bindParam("uid", $uid);
		$stmt->execute();
		$dbCon = null;
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
function deleteTaskDetail($tid,$uid) {
	$sql_query = "CALL deleteTaskDetail(:tid,:uid)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql_query);
		$stmt->bindParam("tid", $tid);
		$stmt->bindParam("uid", $uid);
		$stmt->execute();
		$dbCon = null;
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
function getProjectTask($tid, $uid) {
	$sql_query = "CALL getProjectTask(:tid,:uid)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql_query);
		$stmt->bindParam("tid", $tid);
		$stmt->bindParam("uid", $uid);
		$stmt->execute();
		$dbCon = null;
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

function addUserClient($id,$clientname,$clientcontact,$clientemail,$clientphone) {
	$sql = "CALL addClient(:clientname, :clientcontact,:clientemail,:clientphone,:id)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql);  
		$stmt->bindParam("clientname", $clientname);
		$stmt->bindParam("clientcontact", $clientcontact);
		$stmt->bindParam("clientemail", $clientemail);
		$stmt->bindParam("clientphone", $clientphone);
		$stmt->bindParam("id", $id);
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

function getUserClients($id,$sortby) {
	$sql_query = "CALL getUserClients(:id,:sortby)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql_query);
		$stmt->bindParam("id", $id);
		$stmt->bindParam("sortby", $sortby);
		$stmt->execute();
		//$clients = $stmt->fetchAll(PDO::FETCH_OBJ);
		$dbCon = null;
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

function getUserClient($uid,$cid) {
	$sql_query = "CALL getUserClient(:uid,:cid)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql_query);
		$stmt->bindParam("uid", $uid);
		$stmt->bindParam("cid", $cid);
		$stmt->execute();
		$dbCon = null;
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

function updateUserClient($uid,$cid,$clientname,$clientcontact,$clientemail,$clientphone) {
	
    $sql_query = "CALL updateUserClient(:uid,:cid,:clientname,:clientcontact,:clientemail,:clientphone)";
    try {
        $dbCon = getConnection();
		$stmt = $dbCon->prepare($sql_query);
		$stmt->bindParam("uid", $uid);
		$stmt->bindParam("cid", $cid);
		$stmt->bindParam("clientname", $clientname);
		$stmt->bindParam("clientcontact", $clientcontact);
		$stmt->bindParam("clientemail", $clientemail );
		$stmt->bindParam("clientphone", $clientphone);
		$stmt->execute();
		$dbCon = null;
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

function deleteClient($id,$cid) {
	$sql = "CALL deleteClient(:id,:cid)";
	try{
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql);
		$stmt->bindParam("id", $id);
		$stmt->bindParam("cid", $cid);
		$stmt->execute();
		$dbCon = null;
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

function getClientProjects($id,$uid) {
	$sql_query = "CALL getClientProjects(:id,:uid)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql_query);
		$stmt->bindParam("id", $id);
		$stmt->bindParam("uid", $uid);
		$stmt->execute();
		$dbCon = null;
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



function searchClientByName($uid,$query) {
	$sql = "SELECT * FROM clients WHERE UPPER(client_name) LIKE :query and user_id=" . $uid . " ORDER BY client_name";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql);
		$query = "%".$query."%";
		$stmt->bindParam("query", $query);
		$stmt->execute();
		$dbCon = null;
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


function addTask($projectid,$taskname,$uid) {
	$sql = "CALL createTask(:projectid, :taskname,:uid)";
	try {
		$dbCon = getConnection();
		$stmt = $dbCon->prepare($sql);  
		$stmt->bindParam("uid", $uid);
		$stmt->bindParam("taskname", $taskname);
		$stmt->bindParam("projectid", $projectid);
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
	
/*

//PUT FUNCTIONS
function updateUser($id) {
	global $app;
	$req = $app->request();
	$paramFirstName = $req->params('firstname');
	$paramLastName = $req->params('lastname');
	$paramUsername = $req->params('username');
	session_start();
	if ($_SESSION["loggedin"]=='1'){
		$sql = "CALL updateUser(:firstname,:lastname, :username ,:id)";
		try {
			$dbCon = getConnection();
			$stmt = $dbCon->prepare($sql);
			$stmt->bindParam("firstname", $paramFirstName);
			$stmt->bindParam("lastname", $paramLastName);
			$stmt->bindParam("username", $paramUsername);
			$stmt->bindParam("id", $id);
			$status->updated = $stmt->execute();
			$dbCon = null;
			echo json_encode($status);
		}
		catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}'; 
		}
	}
	else{
		$status->Error ='Not Logged in';
		echo json_encode($status);
	}
}

//END PUT FUNCTIONS

//DELETE FUNCTIONS

*/
?>