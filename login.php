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
    <div class="container">
    <h3 style="text-align: center;">Log in</h3><br><br>
    <?php
		if(isset($_POST['submit'])) {
			require_once 'includes/db.inc.php';
            require_once 'includes/functions.inc.php';
			
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$password = mysqli_real_escape_string($conn, $_POST['password']);
			
			if(emptyInputLogin($email, $password) !== false) {
				header("location: login.php?error=emptyinput");
				die();		
			}
			loginUser($conn, $email, $password);
		}

        if(isset($_GET["error"])) {
            if($_GET["error"] == "emptyinput") {
                echo '<p class="error text-center">Fill in all the fields</p>';
            }
            if($_GET["error"] == "invalidemail") {
                echo '<p class="error text-center">Invalid Email</p>';
            }
            if($_GET["error"] == "invalidpassword") {
                echo '<p class="error text-center">Invalid Password</p>';
            }
            if($_GET["error"] == "emailnotverifiedyet") {
                echo '<p class="error text-center">This account has not yet been verified.</p>';
                echo '<p class="text-center"><a href="resend-email.php">Send an email verification</a></p>';
            }
        }

        if(isset($_GET['password'])) {
            if($_GET['password'] == 'updated') {
                echo '<p class="success text-center">Password Successfully updated</p>';
            }
        }
    ?>
    
    <form action="" method="post">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="">
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="exampleFormControlInput1" placeholder="">
        </div>

        <div class="d-grid gap-2">
            <button type="submit" name="submit" class="btn btn-dark" id="btn-login">Register</button>
        </div><br>
        <h5 class="text-center"><a href="reset-password.php">Forgot password?</a></h5>
        <br>
        <h5 class="text-center">New to Online Shop? <a href="registration.php">Register</a></h5>
        <br><br><br><br>
    </form>
    </div>
<?php
    require_once 'footer.php';
?>