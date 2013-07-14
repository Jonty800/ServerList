<!DOCTYPE html>
<html>
<head>
<title>Server List</title>
<style type="text/css">
table {
	border: 1px solid black;
	border-collapse: collapse;
}
th {
	border: 1px solid black;
	padding: 6px;
	font-weight: bold;
	background: #CCC;
}
td {
	border: 1px solid black;
	padding: 6px;
}
.num_posts_col {
	text-align: center;
}
</style>
</head>
<body>
<h1>800Craft Servers</h1>
<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);
$ServerName = $_POST['ServerName']; 
$Url = $_POST['Url'];
if(!isset($Url)){
	die();
}
$Players = $_POST['Players'];
$MaxPlayers = $_POST['MaxPlayers'];
$Uptime = $_POST['Uptime'];
$Time = date('Y-m-d H:i:s');
$HourAgo = date('Y-m-d H:i:s', strtotime('-15 minutes'));

$Conn = mysqli_connect("YourMySqlDetails");
// Check connection
if (mysqli_connect_errno())
  {
  	echo "Failed to connect to MySQL: " . mysqli_connect_error();
  } 

if(!mysqli_query($Conn, "DELETE FROM servers WHERE Url='".$Url."'")) //delete old server
{
	printf('Error: ' . mysqli_error($Conn));
}
$ServerName = strip_tags($ServerName);
if(!mysqli_query($Conn, "INSERT INTO servers(ServerName, Url, Players, MaxPlayers, Uptime, LastTimeSeen)
VALUES ('$ServerName', '$Url', '$Players', '$MaxPlayers', '$Uptime', '$Time')"))
{
	die('Error: ' . mysqli_error($Conn));
}

mysqli_close($Conn);
?>
</body>
</html>