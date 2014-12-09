<?php
$con=mysqli_connect("localhost","muzeyyen","333444","esovtaj");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
$user_id = $_POST['userid'];
$user_yetki = $_POST['yetkiDurum'];
$sql="UPDATE door ".
       "SET yetkiVerildi = $user
	   _yetki ".
       "WHERE Id = $user_id" ;

if (!mysqli_query($con,$sql))
  {
  die('Error: ' . mysqli_error($con));
  }
 else{
echo 'Teklifiniz Elimize Ulaştı';

}
mysqli_close($con);
?>