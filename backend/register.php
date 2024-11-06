<?php
    session_start();
    use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

    function sendMail($email, $otp, $name){
            
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
            $mail->Body    = "Welcome $name<br>Your OTP is : $otp<br> Dont share your OTP anyone";

            $mail->send();
            echo "
                <script>
                    alert('OTP sent Your email');
                    window.location.href='../frontend/regotp.html';
                </script>
            ";
        } 
        catch (Exception $e) {
            echo "
                <script>
                    alert('Plese Connect with internet');
                </script>
            ";
        }
    }

    if(isset($_POST['register'])){
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $phone = $_POST["phone"];
        $otp = rand(111111, 999999);

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['hash'] = $hash;
        $_SESSION['phone'] = $phone;
        $_SESSION['otp'] = $otp;

        require("conect.php");
    	if(!empty($name) && !empty($email) && !empty($password) && !empty($phone)){
            $stmt = $con->prepare("select * from users where email = ? || phone = ?");
            $stmt->bind_param("ss", $email, $phone);
            $stmt ->execute();
            $stmt_result = $stmt->get_result();
            if($stmt_result->num_rows > 0){
                echo "<script>
                        alert('Already exist');
                        window.location.href='../frontend/LoginPage.html';
                    </script>
                ";
            }
            else{   
                sendMail($email, $otp, $name);
                // header("location: ../frontend/regotp.html");
            }
        }
        else{
            header("location: ../frontend/LoginPage.html");
        }
    }    
?>