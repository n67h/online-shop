<?php
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
    <title>Log in</title>
    <?php
        require_once 'header.php';
    ?>
    <br><br>
    <?php
        $firstname_error = " *";
        $lastname_error = " *";
        $email_error = " *";
        $password_error = " *";
        $password_repeat_error = " *";
        $checkbox_error = " *";

        $firstname_val = "";
        $lastname_val = "";
        $email_val = "";
        $password_val = "";
        $password_repeat_val = "";

        $firstname_success = "";
        $lastname_success = "";
        $email_success = "";
        $password_success = "";
        $password_repeat_success = "";
        $checkbox_success = "";

        

        if(isset($_POST['submit'])) {
            require_once 'includes/db.inc.php';
            require_once 'includes/functions.inc.php';

            $firstname = mysqli_real_escape_string($conn, $_POST['first_name']);
            $lastname = mysqli_real_escape_string($conn, $_POST['last_name']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $password_repeat = mysqli_real_escape_string($conn, $_POST['password_repeat']);


            //FIRST NAME
            if(firstnameEmpty($firstname) !== false) {
                $firstname_error = " This field is required";
            } else {
                if(firstnameInvalid($firstname) !== false) {
                    $firstname_error = " Invalid first name";
                } else {
                    $firstname_error = "";
                    $firstname_success = ' <i class="fa-solid fa-circle-check"></i>';
                    $firstname_val = $firstname;
                }
            }

            //LAST NAME
            if(lastnameEmpty($lastname) !== false) {
                $lastname_error = " This field is required";
            } else {
                if(lastnameInvalid($lastname) !== false) {
                    $lastname_error = " Invalid last name";
                } else {
                    $lastname_error = "";
                    $lastname_success = ' <i class="fa-solid fa-circle-check"></i>';
                    $lastname_val = $lastname;
                }
            }
   
            //EMAIL
            if(emailEmpty($email) !== false) {
                $email_error = " This field is required";
            } else {
                if(emailInvalid($email) !== false) {
                    $email_error = " Invalid email";
                } elseif(emailExists($conn, $email) !== false) {
                    $email_error = " Email is already taken";
                } else {
                    $email_error = "";
                    $email_success = ' <i class="fa-solid fa-circle-check"></i>';
                    $email_val = $email;
                }
            }

            if(emailExists($conn, $email) !== false) {
                $email_error = " Email is already taken";
            }
            
            //PASSWORD
            if(passwordEmpty($password) !== false) {
                $password_error = " This field is required";
            } else {
                if(passwordInvalid($password)  !== false) {
                    $password_error = " Must be  8 to 16 characters";
                } else {
                    $password_error = "";
                    $password_success = ' <i class="fa-solid fa-circle-check"></i>';
                    $password_val = $password;
                }
            }

            //PASSWORD REPEAT
            if(passwordRepeatEmpty($password_repeat) !== false) {
                $password_repeat_error = " This field is required";
            } else {
                if(passwordRepeatInvalid($password_repeat) !== false) {
                    $password_repeat_error = " Must be 8 to 16 characters";
                } elseif(passwordMatch($password, $password_repeat) !== false) {
                    $password_repeat_error = " Password does not match";
                } else {
                    $password_repeat_error = "";
                    $password_repeat_success = ' <i class="fa-solid fa-circle-check"></i>';
                    $password_repeat_val = $password_repeat;
                }
            }

            //GENERATE VERIFICATION KEY
            $vkey = md5(time());
            // echo $vkey;

            //CHECKBOX
            if(!isset($_POST['checkbox'])) {
                $checkbox_error = " This field is required";
            } else {
                $checkbox_error = "";
                $checkbox_success = ' <i class="fa-solid fa-circle-check"></i>';
            }
            // if(!empty($firstname) && !empty($lastname) && !empty($address) && !empty($email) && !empty($phone)  && !empty($password)  && !empty($password_repeat) && firstnameInvalid($firstname) === false && lastnameInvalid($lastname) === false && addressInvalid($address) === false && emailInvalid($email) === false && emailExists($conn, $email) === false &&  phoneInvalid($phone) === false && passwordInvalid($password) === false && passwordRepeatInvalid($password_repeat) === false && passwordMatch($password, $password_repeat) === false && $vkey != "" && $checkbox_error === "")

            


            if(!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password)  && !empty($password_repeat) && firstnameInvalid($firstname) === false && lastnameInvalid($lastname) === false && emailInvalid($email) === false && emailExists($conn, $email) === false && passwordInvalid($password) === false && passwordRepeatInvalid($password_repeat) === false && passwordMatch($password, $password_repeat) === false && $vkey != "" && $checkbox_error === "") {

            
                createUser($conn, $firstname, $lastname, $email, $password, $vkey);

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
                
                
                    $body = "<p>Hi there,</p>
                    <p>Thanks for registering!</p>
                    <p>You're one step closer on creating your account. To start using your account, you need to confirm your e-mail address first clicking the button below:</p>
                    <button><a href='http://localhost/online-shop/verification.php?verificationkey=" .$vkey. "'>Click here to confirm e-mail address</a></button>
                    <p>If you have any questions or concerns, kindly respond to this e-mail</p>
                    <p>Your growth partner,</p>
                    <p>PC-Med</p>";
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Welcome to PC-Med! Confirm the e-mail address of your account here.';
                    $mail->Body    = $body;
                    $mail->AltBody = strip_tags($body);
                
                    $mail->send();
                    // echo 'Message has been sent';
                    header('location: registration-success.php');
                    die();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
            //echo $vkey;
        }
    ?>
    <div class="container">
        <h3 style="text-align: center;">Register by filling up the fields correctly.</h3><br>
        <form action="" method="post">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">First name<span class="error"><?php echo $firstname_error ?></span><span class="success"><?php echo $firstname_success ?></span></label>
                <input type="text" name="first_name" class="form-control" id="exampleFormControlInput1" placeholder="" value="<?php echo $firstname_val ?>">
            </div>

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Last name<span class="error"><?php echo $lastname_error ?></span><span class="success"><?php echo $lastname_success ?></span></label>
                <input type="text" name="last_name" class="form-control" id="exampleFormControlInput1" placeholder="" value="<?php echo $lastname_val ?>">
            </div>

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Email address<span class="error"><?php echo $email_error ?></span><span class="success"><?php echo $email_success ?></span></label>
                <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="" value="<?php echo $email_val ?>">
            </div>

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Password<span class="error"><?php echo $password_error ?></span><span class="success"><?php echo $password_success ?></span></label>
                <input type="password" name="password" class="form-control" id="exampleFormControlInput1" placeholder="" value="<?php echo $password_val ?>">
            </div>

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Repeat password<span class="error"><?php echo $password_repeat_error ?></span><span class="success"><?php echo $password_repeat_success ?></span></label>
                <input type="password" name="password_repeat" class="form-control" id="exampleFormControlInput1" placeholder="" value="<?php echo $password_repeat_val ?>">
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="checkbox" value="" id="flexCheckDefault" <?php if(isset($_POST['checkbox'])) { echo 'checked'; } ?>>
                <label class="form-check-label" for="flexCheckDefault">
                    I agree and consent to the use of my submitted information in accordance with the <a href="#">Terms and Conditions</a> of Online Shop.<span class="error"><?php echo $checkbox_error ?></span><span class="success"><?php echo $checkbox_success ?></span></
                </label><br><br>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" name="submit" class="btn btn-dark btn-lg" id="btn-register">Register</button>
            </div>
        </form>
        <br>
        <h5 style="text-align: center;">Already have an account? <a href="login.php">Log in</a></h5>
        <br><br><br><br>
    </div>
<?php
    require_once 'footer.php';
?>