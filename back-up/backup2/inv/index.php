<?php
$dbsvr = "billing.cepat.net.id";
$dbusr = "moraapps";
$dbpwd = "moraapps";
$con = mysql_connect("202.43.178.228","productdev","selfcare");
//$con = mysql_connect($dbserver,$dbusr,$dbpwd);
if (!$con){
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