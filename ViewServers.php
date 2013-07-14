<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="jquery.tablesorter.js"></script> 
<title>Server List</title>
<style type="text/css">
table,td
{
	border               : 1px solid #CCC;
	border-collapse      : collapse;
  font                 : small/1.5 "Tahoma", "Bitstream Vera Sans", Verdana, Helvetica, sans-serif;
}
table
{
	border                :none;
	border                :1px solid #CCC;
}
thead th,
tbody th
{
	background            : #FFF url(th_bck.gif) repeat-x;
  color                 : #666;  
	padding               : 5px 10px;
  border-left           : 1px solid #CCC;
}
tbody th
{
  background            : #fafafb;
  border-top            : 1px solid #CCC;
  text-align            : left;
  font-weight           : normal;
}
tbody tr td
{
	padding               : 5px 10px;
  color                 : #666;
}
tbody tr:hover
{
  background            : #FFF url(tr_bck.gif) repeat;
}

tbody tr:hover td
{
  color                 : #454545;
}
tfoot td,
tfoot th
{
  border-left           : none;
  border-top            : 1px solid #CCC;
	padding               : 4px;
  background            : #FFF url(foot_bck.gif) repeat;
  color                 : #666;
}
caption
{
	text-align            : left;
	font-size             : 120%;
	padding               : 10px 0;
	color                 : #666;
}
table a:link
{
	color                 : #666;
}
table a:visited
{
	color                 : #666;
}
table a:hover
{
	color                 : #003366;
	text-decoration       : none;
}
table a:active
{
	color                 : #003366;
}
table.tablesorter thead tr .header {
	cursor: pointer;
}

table.tablesorter thead tr .headerSortDown, table.tablesorter thead tr .headerSortUp {
background-color: #8dbdd8;
}
</style>
</head>
<body>
<img src="http://i.imgur.com/V4gNq3k.png" alt="Logo" />

<?php
$Conn = mysqli_connect("YourMySqlDetails");
// Check connection
if (mysqli_connect_errno())
  {
  	echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$result = mysqli_query($Conn, "SELECT * FROM servers");
$Time = date('Y-m-d H:i:s');
if(!mysqli_query($Conn, "DELETE FROM servers WHERE LastTimeSeen < NOW() - INTERVAL 2 MINUTE"))//delete old servers
{
	die('Error: ' . mysqli_error($Conn));
}

$DisplayBlock = "<table id='myTable' class='tablesorter'>
<thead> 
<tr>
  <th>Server Name </th>
  <th>Players </th>
  <th>Max Players </th>
  <th>Uptime </th>
</tr>
</thead> 
<tbody>";
$Count = 0;
while($row = mysqli_fetch_array($result))
  {
        $Count++;
	$ServerName = $row['ServerName']; 
	$Url = $row['Url'];
	$Players = $row['Players'];
	$MaxPlayers = $row['MaxPlayers'];
	$Uptime = $row['Uptime'];
	
	//build a html string in the loop, append to DisplayBlock
	$DisplayBlock .= <<<HTML
	<tr>
	<td><b><a href="$Url">$ServerName</a></b><br/>
	<td>$Players </td>
	<td>$MaxPlayers </td>
	<td>$Uptime minutes </td>
	</tr>
HTML;
  }
echo($DisplayBlock); //print the built string
if($Count == 0)
{
echo("<tr><td>No servers currently online :(</td><td></td><td></td><td></td></tr>");
}
echo("</tbody> </table>"); //end the table

mysqli_close($Conn);
?>
<script>
$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
); 
</script>

</body>
</html>		