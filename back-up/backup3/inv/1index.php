<?php
$con = mysql_connect("202.43.178.243","productdev","selfcare");
if (!$con)
  {
  	die('Could not connect: ' . mysql_error());
  }


mysql_select_db("self_care", $con);

$result = mysql_query("SELECT * FROM LOGIN_CUST");

while($row = mysql_fetch_array($result))
  {
  echo $row['CUSTCODE'] . " " . $row['CUSTNAME'];
  echo "<br />";
  }

mysql_close($con);
?> 