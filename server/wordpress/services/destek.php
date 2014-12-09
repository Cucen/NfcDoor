<?php
$con=mysqli_connect("192.168.1.14","root","333444","esovtaj");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$sql="INSERT INTO destekTalebi (aracId,ihaleNo,destek)
VALUES
('$_POST[aracId]'),('$_POST[ihaleId]'),('$_POST[destekTalebi]')";

if (!mysqli_query($con,$sql))
  {
  die('Error: ' . mysqli_error($con));
  }
 else{
echo 'Teklifiniz Elimize Ulasti';

}

mysqli_close($con);
?>