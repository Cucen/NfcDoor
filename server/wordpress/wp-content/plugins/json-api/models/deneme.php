<?php
$con=mysqli_connect("localhost","muzeyyen","333444","wordpress");
// Check connection
if (mysqli_connect_errno())
{
echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
}
$sql = "SELECT * FROM wp_posts where post_status='publish'";
	$dbhost = 'localhost';
	$dbuser = 'muzeyyen';
	$dbpass = '333444';
	$dbname = 'wordpress';

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