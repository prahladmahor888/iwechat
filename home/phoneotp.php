<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone OTP</title>
</head>
<body>
    <form action="" method="post">
        <input type="number" name="phone">
        <button type="submit" name="send">send</button>
    </form>
</body>
</html>

<?php
if(isset($_POST['send'])){
    $phone = $_POST['phone'];
    $otp = rand(1111,9999);
$fields = array(
    "variables_values" => "$otp",
    "route" => "otp",
    "numbers" => "$phone",
);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode($fields),
  CURLOPT_HTTPHEADER => array(
    "authorization: JVZLsiSYGw7WvtRozPyx6jH28pJPPgizzVXbqtcqn5PPsWSrYdgsNVGdoBpz",
    "accept: */*",
    "cache-control: no-cache",
    "content-type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
//Service Route Success Response:
// {
//     "return": true,
//     "request_id": "lwdtp7cjyqxvfe9",
//     "message": [
//         "Message sent successfully"
//     ]
// }

}
?>