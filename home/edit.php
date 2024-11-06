<?php
session_start();
$email = $_SESSION['email'];
require("conect.php");
$query = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($con, $query);
if ($result) {
  while ($row = $result->fetch_assoc()) {
    $name = $row['name'];
    $bio = $row['bio'];
    $pfp = $row['pfp'];
    $gender = $row['gender'];
    $id = $row['id'];
  }
}

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $gender = $_POST['gender'];
  $bio = $_POST['bio'];

  $query = "UPDATE users SET name = '$name', gender = '$gender', bio = '$bio' WHERE email = '$email'";
  $result = mysqli_query($con, $query);
  if ($result) {
    echo "<script>alert('Changed Successfuly');
    window.location.href='profile.php';</script>";
  } else {
    echo "Not success";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>iWeChat Edit</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>

<body class="body">
  
  <div class="container" style="width: 40%;">
    <div class="card card-fat" style="padding: 50px; gap: 20px;">
      <div>
        <?php echo "<b>$name</b><br>";?>
        <?php echo"id - $id";?>
      </div>
      <form action="" method="post" enctype="multipart/form-data">
        <div style="text-align: center;">
          <img src="<?php echo $pfp; ?>" width="100" class="mb-2" style="border-radius: 50%;">
        </div>
        <input type="file" name="pfp" accept=".jpg, .png, .jpeg" class="form-control mr-2" required>
        <?php
          if (isset($_POST['sbmt_image'])) {
            $pfp = $_FILES['pfp']['name'];
            $tempname = $_FILES['pfp']['tmp_name'];
            $folder = "images/" . $pfp;
            if (move_uploaded_file($tempname, $folder)) {
              $sbmt = "UPDATE users SET pfp = '$folder' WHERE email = '$email'";
              $submit = mysqli_query($con, $sbmt);
              if ($submit) {
                echo "Image Uploaded";
              }
            }
          }
        ?>
        <button name="sbmt_image" class="btn btn-success mt-2 form-control">Upload Image</button>
      </form>

      <form action="" method="POST" enctype="multipart/form-data" style="gap: 20px;">
        <input type="text" class="form-control mt-2" name="name" placeholder="Name" value="<?php echo $name; ?>">
        <textarea name="bio" class="form-control mt-2" id="" placeholder="Bio"><?php echo $bio; ?></textarea>
        <select name="gender" class="form-control mt-2">
          <option value="<?php echo $gender;?>"><?php if(!empty($gender)){echo $gender;}else{ echo "Select Gender";}?></option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Other">Other</option>
        </select>
        <button class="btn btn-primary mt-2 form-control" name="submit">Submit</button>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>