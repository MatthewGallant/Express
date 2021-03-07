<?php

session_start();

if (isset($_SESSION['employee'])) {
    header("Location: live.php");
}

include_once("database.php");
include_once("functions.php");

$data = query("SELECT * FROM config WHERE id = 1");
$business_name = $data[0]['business_name'];
$business_slogan = $data[0]['business_slogan'];
$theme_color = $data[0]['theme_color'];

if (isset($_POST['account_select']) && isset($_POST['password'])) {

    $user_data = query("SELECT * FROM accounts WHERE account_name = '" . $_POST['account_select'] . "'");

    if (isset($user_data[0]['account_name'])) {
        if (password_verify($_POST['password'], $user_data[0]['account_code'])) {

            $_SESSION['employee'] = $user_data[0]['id'];

            express_log("Employee Login", "The employee '" . $user_data[0]['account_name'] . "' has logged in.");

            header('Location: live.php');

        } else {

            express_log("Employee Login", "The employee '" . $user_data[0]['account_name'] . "' has provided an incorrect password.");
            
            echo '<div class="alert alert-danger" role="alert">';
            echo 'Invalid password for the account provided.';
            echo '</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">';
        echo 'An account associated with the name provided was not found.';
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
	
	<div class="container">

        <div class="row">
            <div class="col-sm-3">
            </div>
            <div class="col-sm-6">
                <br />
                <br />
                <div align="center">
                    <br />

                    <br />

                    <h1><?php echo $business_name; ?><small> Hub Login</small></h1>

                    <br /><br />

                    <form action="employee.php" method="POST">
                        <div class="form-group">
                            <select class="form-control" id="account_select" name="account_select">
                                <?php

                                    $employee_names = query("SELECT account_name FROM accounts");

                                    foreach ($employee_names as $employee_name) {
                                        echo "<option>" . $employee_name['account_name'] . "</option>";
                                    }

                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Account Code">
                        </div>
                        <br />
                        <button type="submit" class="btn btn-<?php echo $theme_color ?> btn-round">Login</button>
                        <a href="login.php" class="btn btn-success btn-round">Management Login</a>
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