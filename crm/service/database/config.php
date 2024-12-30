<?php
$Server = "localhost";
$User = "root";
$Password = "";
$Database = "gmd-in";

$conn = mysqli_connect($Server, $User, $Password, $Database);

if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
}
