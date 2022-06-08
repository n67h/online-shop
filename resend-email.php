<?php
    require_once 'includes/db.inc.php';
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resend Email Verification</title>
</head>
<?php
    require_once 'header.php';
?>
<br><br><br><br>
    <div class="container">
        <form action="" method="post">
            <h3 class="text-center">Didn't receive a verification key?</h3><br>
            <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="Enter your email" required><br><br>
            <div class="d-grid gap-2">
                <button type="submit" name="submit" class="btn btn-dark" id="btn-resend">Resend</button>
            </div>
        </form>
        <?php
        if(isset($_POST['submit'])){
            if(isset($_POST['email'])) {
                require_once 'includes/db.inc.php';
                $email = mysqli_real_escape_string($conn, $_POST['email']);

                $sql = "SELECT * FROM users WHERE email = '$email';";

                if($result = $conn->query($sql)) {
                    if(mysqli_num_rows($result) > 0){
                        while ($row = $result->fetch_assoc()) {
                            $vkey = $row['verification_key'];
                            // echo $vkey;
    
                            //Load Composer's autoloader
                            require 'vendor/autoload.php';
    
                            //Create an instance; passing `true` enables exceptions
                            $mail = new PHPMailer(true);
    
                            try {
                                //Server settings
                                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                                $mail->isSMTP();                                            //Send using SMTP
                                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                $mail->Username   = 'ketano.ecommerce@gmail.com';                     //SMTP username
                                $mail->Password   = 'testketanotest';                               //SMTP password
                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                            
                                //Recipients
                                $mail->setFrom('ketano.ecommerce@gmail.com', 'KetAno Admin');
                                $mail->addAddress($email, '.');     //Add a recipient
                                /*
                                $mail->addAddress('ellen@example.com');               //Name is optional
                                $mail->addReplyTo('info@example.com', 'Information');
                                $mail->addCC('cc@example.com');
                                $mail->addBCC('bcc@example.com');
                                */
                            
                                //Attachments
                                /*
                                $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                                $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
                                */
                            
                            
                                $body = "<h3>Welcome to PC-Med</h3><br>
                                <p>Hello, thank you for creating account on PC-Med. You're all set up! To get you started, please click the button below to verify your account.</p><br>
                                <button><a href='http://localhost/online-shop/verification.php?verificationkey=" .$vkey. "'>Verify Account</a></button>";
                                //Content
                                $mail->isHTML(true);                                  //Set email format to HTML
                                $mail->Subject = 'Account Verification';
                                $mail->Body    = $body;
                                $mail->AltBody = strip_tags($body);
                            
                                $mail->send();
                                // echo 'Message has been sent';
                                // header('location: registration-success.php');
                                echo '<script>window.location.replace("registration-success.php");</script>';
                                die();
                            } catch (Exception $e) {
                                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                            }
                        }
                    }else{
                        echo '<script>window.location.replace("resend-email.php?error=emailnotregisteredyet");</script>';
                        // die();
                    }
                }
            }
        }
            
        ?>
    </div>
<?php
    require_once 'footer.php';
?>