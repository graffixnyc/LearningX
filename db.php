<?php
function getConnection() {
    try {
        $db_username = "learningx";// graffixnyc
        $db_password = "learnsmart";//flange123$
		$db_name = "learningx";//papermate857$
		$db_host="graffixnyc.com";
		$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
        
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
    return $conn;
}
?>