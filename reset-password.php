<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset password</title>
    <?php
        require_once 'header.php';
    ?>
    <br><br>
    <div class="container">
        <h3 class="text-center">Reset Password</h3>
        <form action="includes/reset-request.inc.php" method="post">
				<p class="text-center">An email will be send to your email with instructions on how to reset your password.</p>
                <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="Enter your email address" required><br><br>
                <div class="d-grid gap-2">
                    <button type="submit" name="reset-request-submit" class="btn btn-dark" id="btn-login">Proceed</button><br>
                </div>

				<?php
					if(isset($_GET['error'])) {
						if($_GET['error'] == 'emptyfield') {
							echo '<p class="error text-center">This field is required.</p>';
						}elseif($_GET['error'] == 'invalidemail') {
							echo '<p class="error text-center">Invalid email.</p>';
						}elseif($_GET['error'] == 'emailnotregisteredyet'){
							echo '<p class="error text-center">Email is not registered yet.</p>';
                        }elseif($_GET['error'] == 'passworderror') {
							echo '<p class="error text-center">There was an error in your new password. Please repeat the process.</p>';
						}
					}

					if(isset($_GET['reset'])) {
						if($_GET['reset'] == 'success') {
							echo '<p class="success text-center"><a href="gmail.com"></a>Please Check Your Email.</a></p>';
						}
					}

					/*if(isset($_GET['password'])) {
						if($_GET['password'] == 'updated') {
							echo '<p style="color: #85D512">Password successfully updated.</p>';
						}
					}*/
				?>
	    </form>
    </div>
<?php
    require_once 'footer.php';
?>