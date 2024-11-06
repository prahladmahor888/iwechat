<?php
session_start();
require("conect.php");
$fromuser = $_POST['userid'];
$touser = $_POST['touser'];
$message = $_POST['message'];

$output = "";
$sql = "INSERT INTO masseges (fromuser, touser, message) VALUES('$fromuser', '$touser', '$message')";
if($con->query($sql)){
    $output = "";
}
else{
    $output = "Please try again";
}
echo $output;

?>