<?php
$con=mysqli_connect("localhost","muzeyyen","333444","test");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$sql="update door set door.key= ('$_POST[keydegeri]')
where Id=
('$_POST[userid]')";

if (!mysqli_query($con,$sql))
  {
  die('Error: ' . mysqli_error($con));
  }
 else{
echo 'Key Üretildi.';

}
mysqli_close($con);
?>