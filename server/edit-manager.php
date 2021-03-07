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

$user_data = query("SELECT name, email, admin FROM login WHERE id = " . $user_id);
$user_name = $user_data[0]['name'];
$user_email = $user_data[0]['email'];
$user_admin = $user_data[0]['admin'];

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

        if (isset($_GET['message'])) {
            if ($_GET['message'] == "reset_success") {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                echo 'The password was reset successfully.';
                echo '<button type="button" class="close" data-dismiss="alert">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
                echo '</div>';
            } elseif ($_GET['message'] == "reset_failure") {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo 'There was an error reseting the password.';
                echo '<button type="button" class="close" data-dismiss="alert">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
                echo '</div>';
            }
        }

        ?>

        <?php

            if (isset($_POST['account_name']) && isset($_POST['account_email'])) {
                if ($_POST['account_name'] != "" && $_POST['account_email'] != "") {

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
                        $stmt = $conn->prepare("UPDATE login SET name = :name, email = :email, admin = :admin WHERE id = " . $user_id);
                        
                        $stmt->bindParam(':name', $name);
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':admin', $admin);
            
                        $name = $_POST['account_name'];
                        $email = $_POST['account_email'];

                        if (isset($_POST['admin_checkbox'])) {
                            $admin = "Yes";
                        } else {
                            $admin = "No";
                        }
            
                        $stmt->execute();

                        express_log("Edit Account", "The account '" . $_POST['account_name'] . "' has been updated.");
            
                        header("Location: manager-accounts.php?message=edit_success");

                    } catch(PDOException $e) {
                        header("Location: manager-accounts.php?message=edit_failure");
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

        <h2>Edit Manager Account<a href="manager-accounts.php" class="btn btn-danger btn-round" style="margin-left: 20px; float: right;">Back</a></h2>

        <br />

        <form method="POST" action="edit-manager.php?id=<?php echo $user_id; ?>">
            <div class="form-group">
                <label for="account_name">Account Name (Manager's Name)</label>
                <input type="text" class="form-control" id="account_name" name="account_name" placeholder="Account Name (Manager's Name)" value="<?php echo $user_name; ?>">
            </div>
            <div class="form-group">
                <label for="account_email">Account Email</label>
                <input type="email" class="form-control" id="account_email" name="account_email" placeholder="Account Email" value="<?php echo $user_email; ?>">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Yes" id="admin_checkbox" name="admin_checkbox" <?php if ($user_admin == "Yes") { echo "checked"; } ?> >
                <label class="form-check-label" for="admin_checkbox">
                    Admin Access
                </label>
            </div>

            <br />

            <button type="submit" class="btn btn-<?php echo $theme_color; ?>">Save Account</button>
            <a href="reset-password.php?id=<?php echo $user_id; ?>" class="btn btn-danger">Reset Password</a>

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