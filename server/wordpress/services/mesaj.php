<?php
$mysqli = new mysqli('localhost', 'muzeyyen', '333444', 'wordpress');
	$dbhost = 'localhost';
	$dbuser = 'muzeyyen';
	$dbpass = '333444';
	$dbname = 'esovtaj';
if ($mysqli->connect_error)
    die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
else
   $sql = "select idaraclar, marka,yer,Belge_Turu,Kullanim_Tarzi,Model_Yili,KM,Renk,Yakit_Turu,Vites_Turu,Plaka_No,image,dosyaNo,takipNo  from araclar";

try {
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $dbh->query($sql);  
	$employees = $stmt->fetchAll(PDO::FETCH_OBJ);
	$dbh = null;
	echo '{"items":'. json_encode($employees) .'}'; 
} catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}'; 
}

?>