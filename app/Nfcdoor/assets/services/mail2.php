<?php
 
$to="muzeyyen.histiroglu@gmail.com";
 
$from="info@7tech.co.in";
 
$sub="This is a plain text mail!";
 
$msg="This is the message body! <br/><br/> From:<br/><a href='http://www.7tech.co.in'>7tech.co.in team</a>";
 
$headers  = "From: $from\r\n";
 
$headers .= "Content-type: text/html\r\n";
 
mail($to,$sub,$msg,$headers);
 
?>