<?php
    session_start();
    if(isset($_POST['otp'])){
        require("conect.php");

        $name = $_SESSION['name'];
        $email = $_SESSION['email'];
        $phone = $_SESSION['phone'];
        $password = $_SESSION['hash'];
        $otp = $_SESSION['otp'];
        $id = rand(000000000, 999999999);


        $chckotp = $_POST['otp1'].$_POST['otp2'].$_POST['otp3'].$_POST['otp4'].$_POST['otp5'].$_POST['otp6'];
        if($otp == $chckotp){
            $query = "INSERT INTO users(id, name, email, phone, password, date) VALUES('$id', '$name', '$email', '$phone', '$password', current_timestamp())";
            $result = mysqli_query($con, $query);
            if($result){
                echo"
                    <script>
                        alert('Registration Success');
                        window.location.href='../frontend/LoginPage.html';
                    </script>
                ";
            }
        }

        else{
            echo"
                <script>
                    alert('You entered wrong OTP');
                    window.location.href='../frontend/regotp.html';
                </script>
            ";
        }
    }
    else{
        echo "Technical Issue";
    }
?>