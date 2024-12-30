<?php
$Server = "localhost";
$User = "u850328419_aureabliss";
$Password = "3uVufeB?";
$Database = "u850328419_aureabliss";

$conn = mysqli_connect($Server, $User, $Password, $Database);

if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
}
