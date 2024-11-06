<?php
if (isset($_POST['login'])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    require("conect.php");
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $query);
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $verifypass = $row['password'];
        }
        if (password_verify($password, $verifypass)) {
            session_start();
            $_SESSION['logged'] = true;
            $_SESSION['email'] = $email;

            echo "<script>
                alert('Login success');
                window.location.href='../home/home.php';
                </script>
            ";
        } 
        else {
            echo "<script>
                alert('Please Enter conrrect password');
                window.location.href='../frontend/LoginPage.html';
                </script>
            ";
        }
    } 
    else {
        echo "<script>
            alert('Please Register');
            window.location.href='../frontend/LoginPage.html';
            </script>
        ";
    }
}
