<?php
session_start();
require("conect.php");
$email = $_SESSION['email'];
$userid = $_SESSION['userid'];

$users = mysqli_query($con, "SELECT * FROM users WHERE id = '$userid'") or die("Failed conect to database");
$user = mysqli_fetch_assoc($users);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <div class="sidebar" style="width: 100%; background: url(./back_image/artem-mihailov-e48PGxiwl9s-unsplash.jpg); background-size: contain;">
    <!-- <form action="insert.php" method="post" enctype="multipart/form-data" autocomplete="off" style="display: flex; align-items:self-start;">
      <input type="text" class="form-control" name="message" id="message" placeholder="Type here..." required>
      <button type="submit" class="btn btn-primary" id="send" name="send">Send</button>
    </form> -->
    <div class="scrollbox">
      <div class="user massege" style="color: white;">

        <p>Hi <?php echo $user['name']; ?></p>
        <input type="text" id="fromuser" name="fromuser" value="<?php echo $user['id']; ?>" hidden />

        <p>send message to : </p>
        <ol>
          <?php
          $msgs = mysqli_query($con, "SELECT * FROM users") or die("Failed conect to database");

          while ($msg = mysqli_fetch_assoc($msgs)) {
            echo "<li><a href=?touser=" . $msg['id'] . "'></a></li>";
            $_SESSION['touser'] = $msg['id'];
          }
          ?>
        </ol>
      </div>
      <div>
        <h4>
          <?php
          if(isset($_GET['touser'])){
            $username = mysqli_query($con, "SELECT * FROM users WHERE id = '".$_GET["touser"]."' ") or die("Failed to query database");
            $uname = mysqli_fetch_assoc($username);
            echo '<input type="text" value='.$_GET["touser"].' id="touser" name="touser" hidden />';
            echo $uname['name'];
          }
          else{
            $username = mysqli_query($con, "SELECT * FROM users") or die("Failed to query database");
            $uname = mysqli_fetch_assoc($username);
            $_SESSION['touser'] = $uname['id'];
            echo '<input type="text" value='.$_SESSION["touser"].' id="touser" name="touser" hidden />';
            echo $uname['name'];
          }
          ?>
        </h4>
      </div>
    </div>
    <div class="model-body" id="msgbody" style="height: 400px;">
      <?php
      if(isset($_GET['touser'])){
        $chats = mysqli_query($con, "SELECT * FROM masseges WHERE (fromuser = '".$_SESSION["userid"]."' AND touser = '".$_GET["touser"]."') OR (fromuser = '".$_GET["touser"]."' AND touser = '".$_SESSION["userid"]."')") or die("Failed to query database");
      }
      else{
        $chats = mysqli_query($con, "SELECT * FROM masseges WHERE (fromuser = '".$_SESSION["userid"]."' AND touser = '".$_SESSION["touser"]."') OR (fromuser = '".$_SESSION["touser"]."' AND touser = '".$_SESSION["userid"]."')") or die("Failed to query database");
      }
        while($chat = mysqli_fetch_assoc($chats)){
          if($chat['fromuser'] == $_SESSION['userid']){
            echo "<div style='text-align: right;'>
              <p style='background-color: lightblue; word-wrap: break-word; display: inline-block; padding: 5px; border-radius: 10px; max-width: 70px;'>".$chat["message"]."
              </p>
            </div>";
          }
          else{
            echo "<div style='text-align: left;'>
              <p style='background-color: yellow; word-wrap: break-word; display: inline-block; padding: 5px; border-radius: 10px; max-width: 70px;'>".$chat["message"]."
              </p>
            </div>";
          }
        }
      
      ?>
    <div class="modal-footer">
      <textarea id="message" class="form-control" style="height: 30px;"></textarea>
      <button id="send" onclick="send" class="btn btn-primary" style="height: 30%;">send</button>
    </div>
    </div>
  </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function(){
      $("#send").on("click", function(){
        $.ajax({
          url: "insert.php",
          method: "POST",
          data:{
            fromuser: $("#fromuser").val(),
            touser: $("#touser").val(),
            message: $("#message").val()
          },
          dataType: "text",
          success: function(data){
            $("#message").val("")
          }
        })
      })
      setInterval(function(){
        $.ajax({
          url: "realtime.php",
          method: "POST",
          data:{
            fromuser: $("#fromuser").val(),
            touser: $("#touser").val()
          },
          dataType: "text",
          success:function(data){
            $("msgbody").html(data)
          }
        })
      }, 700)
    })
  </script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>