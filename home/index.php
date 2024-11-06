<?php
session_start();
if(!isset($_SESSION['logged']) || $_SESSION['logged'] != true){
  header("location: ../frontend/LoginPage.html");
  exit;
}
else{
$email = $_SESSION['email'];
require("conect.php");
if(isset($_GET['userid'])){
  $_SESSION['userid'] = $_GET['userid'];
  header("location: chat.php");
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>iWeChat Home</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <div class="container d-flex" style="margin-left: 0; padding: 0; height: 100vh;">
    <?php include "header.php"?>

    <div class="sidebar"> <!--style="width: 43%; height: 100vh; ::-webkit-scrollbar{width: 5px;};"-->
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
      <div class="scrollbox">
        <div class="users" style="gap: 10px;">
          <?php
          $result = mysqli_query($con, "SELECT * FROM users");
          if ($result) {
            while ($row = $result->fetch_assoc()) {
              $pfp = $row['pfp'];
              $name = $row['name'];
              $id = $row['id'];
              echo "<a href='?userid=$id' style='color: black; text-decoration: none;'>
                  <div style='display: flex; gap: 10px; border-radius: 10px; background: white; align-items: center; margin: 2px 3px 0 0; padding-left: 6px;'>
                    <div>
                      <img style='width: 25px; height: 25px; border-radius: 50%;' src='$pfp'>
                    </div>
                    <div>
                      <h5>$name</h5>                    
                    </div>
                  </div>
                </a>
              ";
            }
          }
          ?>
        </div>
      </div>
    </div>

    <!-- <div class="sidebar" style="width: 100%; background: black;">
      <form action="" method="post" enctype="multipart/form-data" autocomplete="off" style="display: flex; align-items:self-start;">
        <?php 
        if(isset($_POST['send'])){
          $message = $_POST['message'];
          $send = mysqli_query($con, "INSERT INTO messages (message, sender, reciever) VALUES ('', '', '$message')");
          if($send){
            echo 'send';
          }
          else{
            echo 'failed';
          }          
        }
        ?>
        <input type="text" class="form-control" name="message" id="message" placeholder="Type here...">
        <button type="submit" class="btn btn-primary" name="send">Send</button>
      </form>
      <div class="scrollbox">
        <div class="user massege" style="color: white;">

          <?php
          if (isset($_POST['chat'])) {
            $id = $_SESSION['user'];
            $result = mysqli_query($con, "SELECT * FROM users WHERE id = '$id'");
            if ($result) {
              echo $_SESSION['user'];
            }
          }
          ?>
        </div>
      </div>

    </div>
  </div> -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>