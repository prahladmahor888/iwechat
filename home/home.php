<?php
session_start();
require("conect.php");
$email = $_SESSION['email'];
$resu = mysqli_query($con, "SELECT * FROM users WHERE email = '$email'");
while ($row = $resu->fetch_assoc()) {
    $_SESSION['pfp'] = $row['pfp'];
    $userid = $row['id'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iWeChat Home</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body class="d-flex">
    <div>
        <?php include "header.php"?>
    </div>
    <div class="post" style="width: 100%;">
        <?php
        if (isset($_POST['uploadpost'])) {
            $title = $_POST['title'];
            $postname = $_FILES['postupload']['name'];
            $tempname = $_FILES['postupload']['tmp_name'];
            $folder = "posts/" . $postname;
            if (move_uploaded_file($tempname, $folder)) {
                $move = mysqli_query($con, "INSERT INTO posts (userid, post, title, date) VALUES('$userid', '$folder', '$title', current_timestamp())");
            } else {
                echo "not upload";
            }
        }
        ?>
        <form action="" method="POST" class="d-flex" style="gap: 4px; overflow: hidden;" enctype="multipart/form-data">
            <img src="<?php echo $_SESSION['pfp']; ?>" style="width: 40px; height: 40px; border-radius: 50%;">
            <input type="text" name="title" placeholder="Enter Something" class="form-control">
            <label for="fileInput">
                <img id="icon" src="post.png" width="40" height="40">
            </label>
            <input id="fileInput" type="file" name="postupload" accept=".jpg, .png, .mp4, .jpeg" hidden>
            <button class="btn btn-primary form-control" style="width: 60px;" name="uploadpost">Post</button>
        </form>
        <div class="sidebar" style="width: 100%; height: 92.4vh;">
            <div class="scrollbox">
                <div class="users" style="gap: 10px; display: flex; flex-flow: wrap;">
                    <?php
                    $show = mysqli_query($con, "SELECT * FROM posts WHERE userid = '$userid'");
                    while ($row = $show->fetch_assoc()) {
                        $post = $row['post'];
                        $title = $row['title'];
                        echo "<div style='width: 300px; box-size: border-box;'>
                    <img src='$post' style='width: 300px; '>
                    <p>$title</p>
                </div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>