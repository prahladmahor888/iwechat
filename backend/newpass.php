<?php
session_start();
if(isset($_POST['submitpass'])){
    $newpass = $_POST['newpass'];
    $confirmpass  = $_POST['confirmpass'];
    $email = $_SESSION['email'];
    $hashpass = password_hash($newpass, PASSWORD_DEFAULT);
    require("conect.php");
    if(empty($newpass) || empty($confirmpass)){
        echo "<script>alert('Plese fill new password')</script>"; 
    }
    else{
        if($confirmpass === $newpass){
            $stmt = $con->prepare("UPDATE users SET password = ? WHERE email = '$email'");
            $stmt->bind_param("s", $hashpass);
            $stmt ->execute();
            if($stmt){
                echo"
                    <script>
                        alert('Password have been changed Succesfully');
                        window.location.href='../frontend/LoginPage.html';
                    </script>
                ";
            }
        }
        else{
            echo "password not match";
        }
    }
}
?>