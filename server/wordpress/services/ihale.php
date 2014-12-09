<?php
include 'config.php';

$sql = "SELECT idihalebilgileri,bitisZamani,piyasaBedeli,teklifFiyati,destekTalebi,aracId from araclar inner join ihalebilgileri on ihalebilgileri.aracId = araclar.idaraclar ".
		"where aracId=:id ";

try {
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $dbh->prepare($sql);  
	$stmt->bindParam("id", $_GET['id']);
	$stmt->execute();
	$employee = $stmt->fetchObject();  
	$dbh = null;
	echo '{"item":'. json_encode($employee) .'}'; 
} catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}'; 
}

?>