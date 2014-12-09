<?php
include 'config.php';

$sql = "select idaraclar,piyasaBedeli,marka,yer,Belge_Turu,Kullanim_Tarzi,Model_Yili,KM,Renk,Yakit_Turu,Vites_Turu,Plaka_No,image,dosyaNo,takipNo  from araclar order by piyasaBedeli asc";

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