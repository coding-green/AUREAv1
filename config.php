<?php
$Server = "localhost";
$User = "u850328419_aureabliss";
$Password = "3uVufeB?";
$Database = "u850328419_aureabliss";

$conn = mysqli_connect($Server, $User, $Password, $Database);
$pdo = new PDO("mysql:host=$Server;dbname=$Database", $User, $Password);

if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
}
