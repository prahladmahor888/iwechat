<?php 
session_start();
require("conect.php");
$email = $_SESSION['email'];
$query = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($con, $query);
if($result){
  while($row = $result->fetch_assoc()){
    $name = $row['name'];
    $bio = $row['bio'];
    $pfp = $row['pfp'];
    $id = $row['id'];
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile iWeChat</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <section>
    <div class="container">
      <div class="card">
        <dev class="card-fat">
          <form action="" method="POST">
          <div class="profile">
            <ul class="d-flex flex-row">
              <li>
                <img src="<?php echo $pfp;?>">
              </li>
              <li>Post</li>
              <li>Following</li>
              <li>Followers</li>
            </ul>
          </div><hr>
          <div class="info mt-2">
            <div class="name">Name <br><?php echo "<h1 style='font-size: 23px'>$name</h1><p>id-$id</p>";?></div>
            <div class="bio">Bio <br>
              <?php echo $bio;?>
            </div>
          </div><hr>
          <div class="edit">
            <ul class="d-flex">
              <li><button class="btn btn-light" name="edit">Edit</button></li>
              <li><button class="btn btn-light" name="share">Share</button></li>
            </ul>
          </div><hr>
          <div class="post">
            <ul class="d-flex">
              <li><button class="btn btn-light" name="post">Post</button></li>
              <li><button class="btn btn-light" name="video">Video</button></li>
              <li><button class="btn btn-light" name="mix">Mix</button></li>
            </ul> 
          </div>
          </form>
        </dev>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

<?php 
if(isset($_POST['edit'])){
  header("location: edit.php");
}

?>