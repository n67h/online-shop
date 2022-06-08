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
        <h3 class="text-center">Create New Password</h3>
        <?php
            if(isset($_GET['selector']) && isset($_GET['validator'])){
                $selector = $_GET['selector'];
                $validator = $_GET['validator'];
        
                if(empty($selector) || empty($validator)) {
                    echo 'Could not validate your request.';
                }else {
                    if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
        ?>
                    <form action="includes/reset-password.inc.php" method="post">
                        <input type="hidden" name="selector" value="<?php echo $selector; ?>">
                        <input type="hidden" name="validator" value="<?php echo $validator; ?>">

                        <input type="password" name="password" placeholder="New Password" class="form-control" id="exampleFormControlInput1" required><br>
                        <input type="password" name="password-repeat" placeholder="Repeat New Password" class="form-control" id="exampleFormControlInput1" required><br><br>
                        <div class="d-grid gap-2">
                            <button type="submit" name="reset-password-submit" class="btn btn-dark" id="btn-login">Reset password</button>
                        </div>
                    </form>
        <?php     
                    }
                }
            }
    ?>
    </div>
<?php
    require_once 'footer.php';
?>