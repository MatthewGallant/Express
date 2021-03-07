<?php

include_once("functions.php");
verify();

include_once("database.php");

$data = query("SELECT * FROM config WHERE id = 1");
$business_name = $data[0]['business_name'];
$business_slogan = $data[0]['business_slogan'];
$theme_color = $data[0]['theme_color'];
$account_name = $data[0]['order_time'];

page_access_log();

$user_id = $_GET['id'];

?>

<!doctype html>
<html lang="en">
  <head>
  	<?php include_once("head.php"); ?>
  </head>
  <body>
    <?php include_once("panelbar.php"); ?>
	
	<div class="container">

        <br />

        <?php

            if (isset($_POST['account_password'])) {
                if ($_POST['account_password'] != "") {

                    $ini_array = parse_ini_file("database.ini");

                    $servername = $ini_array['server'];
                    $username = $ini_array['username'];
                    $password = $ini_array['password'];
                    $dbname = $ini_array['table'];
            
                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    
                        // set the PDO error mode to exception
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                        // prepare sql and bind parameters
                        $stmt = $conn->prepare("UPDATE login SET password = :password WHERE id = " . $user_id);
                        
                        $stmt->bindParam(':password', $password);
            
                        $password = password_hash($_POST['account_password'], PASSWORD_DEFAULT);
            
                        $stmt->execute();

                        express_log("Reset Password", "The account '" . $_POST['account_name'] . "' has been updated.");
            
                        header("Location: edit-manager.php?message=reset_success&id=" . $user_id);

                    } catch(PDOException $e) {
                        header("Location: edit-manager.php?message=reset_failure&id=" . $user_id);
                    }
            
                    $conn = null;

                } else {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo 'Please fill in all of the fields.';
                    echo '<button type="button" class="close" data-dismiss="alert">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo '</div>';
                }
            }

        ?>

        <h2>Reset Password</h2>

        <br />

        <form method="POST" action="reset-password.php?id=<?php echo $user_id; ?>">
            <div class="form-group">
                <label for="account_name">Password</label>
                <input type="password" class="form-control" id="account_password" name="account_password" placeholder="Enter Password">
            </div>

            <br />

            <button type="submit" class="btn btn-danger">Reset Password</button>

            <br /><br />

        </form>	

        <br />

    </div>

    <?php include_once("footer.php"); ?>
    
	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="functions.js"></script>

    </body>
</html>