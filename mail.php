<?php
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
$usermail = filter_input(INPUT_POST, 'usermail', FILTER_SANITIZE_EMAIL);
$usermessage = filter_input(INPUT_POST, 'usermessage', FILTER_SANITIZE_SPECIAL_CHARS);
// Get the current date and time
$currentDateTime = date('Y-m-d H:i:s');

//database connecction
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'R_corps_user_data';

$conn = mysqli_connect($host, $user, $password, $database);

$sql = "INSERT INTO messages_data(username, usermail, usermessage, sentdate) VALUES ('$username', '$usermail', '$usermessage', '$currentDateTime')";


require 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'Rcorpsinc@gmail.com';                 // SMTP username
$mail->Password = 'fjiturphflcguaso';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to

$mail->setFrom('Rcorpsinc@gmail.com', 'R-corps');
$mail->addAddress($usermail, 'User');     // Add a recipient
/* $mail->addAddress('ellen@example.com');               // Name is optional
$mail->addReplyTo('info@example.com', 'Information');
$mail->addCC('cc@example.com');
$mail->addBCC('bcc@example.com');

$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
$mail->addAttachment('/tmp/image.jpg', 'new.jpg');  */   // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Successful Submission';
$mail->Body    = 'Hi ' . htmlspecialchars($username) . ',<br>Thank you for getting in touch with us. We have received your message and will get back to you shortly.';
$mail->AltBody = 'Hi ' . htmlspecialchars($username) . ',<br>Thank you for getting in touch with us. We have received your message and will get back to you shortly.';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
    header("Location:../error.html");   
} else {
    header("Location:../confirmation.html");  
    mysqli_query($conn, $sql); 
    echo"real";
    
}

mysqli_close($conn);
?>