<?php
require("conect.php");
$fromuser = $_POST['fromuser'];
$touser = $_POST['touser'];
$output = "";

$chats = mysqli_query($con, "SELECT * FROM messages WHERE (fromuser = '$fromuser' AND touser = '$touser') OR (fromuser = '$touser' AND touser = '$fromuser')") or die("Failed to query database");
while($chat = mysqli_fetch_assoc($chats)){
    if($chat['touser'] == $_SESSION['userid']){
      $output = "<div style='text-align: right;'>
        <p style='background-color: lightblue; word-wrap: break-word; display: inline-block; padding: 5px; border-radius: 10px; max-width: 70px;'>".$chat["message"]."
        </p>
      </div>";
    }
    else{
      $output = "<div style='text-align: left;'>
        <p style='background-color: yellow; word-wrap: break-word; display: inline-block; padding: 5px; border-radius: 10px; max-width: 70px;'>".$chat["message"]."
        </p>
      </div>";
    }
  }
  echo $output;
?>