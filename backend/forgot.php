<?php
    session_start();
    use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

    function sendMail($email, $otp){
            
        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';
        $mail = new PHPMailer(true);

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'prahladmahor888@gmail.com';                     //SMTP username
            $mail->Password   = 'lkxj wxff waqd nxmp';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('prahladmahor888@gmail.com', 'iWeChat');
            $mail->addAddress($email);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'OTP Verification code';
            $mail->Body    = "Welcome <br>Your OTP is : $otp<br> Dont share your OTP anyone";

            $mail->send();
            echo "
                <script>
                    alert('OTP sent Your email');
                    window.location.href='../frontend/otp.html';
                </script>
            ";
        } 
        catch (Exception $e) {
            echo "
                <script>
                    alert('Technical issue');
                </script>
            ";
        }
    }

    if(isset($_POST['forgot'])){
        $email = $_POST['email'];
        $otp = rand(111111, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;
        
        require("conect.php");
        if(!empty($email)){
            $query = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($con, $query);
            if($result){
                if(mysqli_num_rows($result) > 0)
                {
                    sendMail($email, $otp);
                    // header("location: ../frontend/otp.html");
                }
                else{
                    echo"Wrong entry";
                }
            }
            else{
                echo "This E-Mail dosent exist";
            }
        }
        else{
            echo"
                <script>
                    alert('please enter the email');
                    window.location.href='../frontend/forgot.html';
                </script>
            ";
        }
    }
?>