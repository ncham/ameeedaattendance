<?php
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$databaseName = "ameeedaempdb";

$conn = mysqli_connect($servername, $dbUsername, $dbPassword, $databaseName);

if (!$conn)
{
    die('Could not connect: ' . mysql_error());
}

?>
