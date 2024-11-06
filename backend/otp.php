<?php
    session_start();
    if(isset($_POST['submitotp'])){
        $otp = $_POST['otp1'].$_POST['otp2'].$_POST['otp3'].$_POST['otp4'].$_POST['otp5'].$_POST['otp6'];
        $chckotp = $_SESSION['otp'];

        if($otp == $chckotp){
            header("location: ../frontend/newpass.html");
        }
        else{
            echo"
                <script>
                    alert('You entered wrong OTP');
                    window.location.href='../frontend/otp.html';
                </script>
            ";
        }
    }
?>