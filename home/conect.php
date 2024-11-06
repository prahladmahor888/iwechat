<?php
$con = mysqli_connect("localhost", "root", "", "company");
if($con->connect_error){
  die("Connection Failed due to this : ". $con->connect_error);
}
?>