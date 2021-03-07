<?php

session_start();

if (isset($_SESSION['id'])) {
    header("Location: manage.php");
}

include_once("database.php");
include_once("functions.php");

$data = query("SELECT business_name, business_slogan FROM config WHERE id = 1");
$business_name = $data[0]['business_name'];
$business_slogan = $data[0]['business_slogan'];
$theme_color = $data[0]['theme_color'];

if (isset($_POST['email']) && isset($_POST['password'])) {

    $user_data = query("SELECT * FROM login WHERE email = '" . $_POST['email'] . "'");

    if (isset($user_data[0]['email'])) {
        if (password_verify($_POST['password'], $user_data[0]['password'])) {

            $_SESSION['id'] = $user_data[0]['id'];

            express_log("User Login", "The user '" . $user_data[0]['email'] . "' has logged in.");

            header('Location: manage.php');

        } else {

            express_log("User Login", "The user '" . $user_data[0]['email'] . "' has provided an incorrect password.");
            
            echo '<div class="alert alert-danger" role="alert">';
            echo 'Invalid Password for Email Account Provided.';
            echo '</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">';
        echo 'An Account Associated With The Email Provided Was Not Found.';
        echo '</div>';
    }
}

?>

<!doctype html>
<html lang="en">
  <head>
  	<?php include_once("head.php"); ?>
  </head>
  <body>
	
    <br />
    <a href="employee.php" class="btn btn-danger btn-round" style="margin-left: 20px;">Back to Hub Login</a>

	<div class="container">

        <div class="row">
            <div class="col-sm-3">
            </div>
            <div class="col-sm-6">
                <br />
                <br />
                <div align="center">

                    <h1><?php echo $business_name; ?><small> Manager Login</small></h1>

                    <br /><br />

                    <form action="login.php" method="POST">
                        <div class="form-group">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        </div>
                        <br />
                        <button type="submit" class="btn btn-primary btn-round">Login</button>
                    </form>
                </div>
                <br />
            </div>
            <div class="col-sm-3">
            </div>
        </div>
			   
    </div>

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>