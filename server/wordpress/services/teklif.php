<?php
$con=mysqli_connect("localhost","muzeyyen","333444","esovtaj");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$sql="INSERT INTO teklif (teklifFiyati,aracId,kullaniciId)
VALUES
('$_POST[teklif]','$_POST[aracId]','$_POST[user]')";

if (!mysqli_query($con,$sql))
  {
  die('Error: ' . mysqli_error($con));
  }
 else{
echo 'Teklifiniz Elimize Ulaştı';

}
mysqli_close($con);
?>