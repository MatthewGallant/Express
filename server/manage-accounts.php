<?php

include_once("functions.php");
verify();

include_once("database.php");

$data = query("SELECT business_name, business_slogan FROM config WHERE id = 1");
$business_name = $data[0]['business_name'];
$business_slogan = $data[0]['business_slogan'];
$theme_color = $data[0]['theme_color'];

page_access_log();

?>

<!doctype html>
<html lang="en">
  <head>
  	<?php include_once("head.php"); ?>
  </head>
  <body>
	<?php include_once("panelbar.php"); ?>
	
	<div class="container">

        <div id="modalDiv"></div>

        <br />

        <?php

            if (isset($_GET['message'])) {
                if ($_GET['message'] == "add_success") {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                    echo 'The Account Was Added Successfully.';
                    echo '<button type="button" class="close" data-dismiss="alert">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo '</div>';
                } elseif ($_GET['message'] == "add_failure") {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo 'There Was An Error Adding The Account.';
                    echo '<button type="button" class="close" data-dismiss="alert">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo '</div>';
                } elseif ($_GET['message'] == "delete_success") {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                    echo 'The Account Has Been Deleted Successfully.';
                    echo '<button type="button" class="close" data-dismiss="alert">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo '</div>';
                } elseif ($_GET['message'] == "delete_failure") {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo 'An Error Occurred While Trying To Delete The Account.';
                    echo '<button type="button" class="close" data-dismiss="alert">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo '</div>';
                }
            }

        ?>

        <div class="row">
            <div class="col">
                <h2>Employee Accounts</h2>
            </div>
            <div class="col"></div>
            <div class="col">
                <a href="add-account.php" class="btn btn-<?php echo $theme_color; ?> btn-block">Add Account</a>
            </div>
        </div>

        <br />

        <?php

        $accounts = query("SELECT * FROM accounts");

            if (isset($accounts[0])) {
            echo "<div class='table-responsive rounded'>";
            echo "<table class='table table-striped table-hover table-bordered'>";
            echo "<thead class='thead-dark'>";
            echo "<tr>";
            echo "<th scope='col'>Account ID</th>";
            echo "<th scope='col'>Account Name</th>";
            echo "<th scope='col'>Delete Account</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            foreach($accounts as $account) {

                echo "<tr>";
                echo "<td>" . $account['id'] . "</td>";
                echo "<td>" . $account['account_name'] . "</td>";
                echo "<td><button type='button' class='btn btn-block btn-danger' onclick='deleteAccount(" . $account['id'] . ")'>Delete Account</button></td>";
                echo "</tr>";

            }

            echo "</tr>";
            echo "</tbody>";
            echo "</table>";
            echo "</div>";

        } else {
            echo "<div align='center'><h4>No accounts found. You can add one <a href='add-account.php'>here</a>.</h4></div>";
        }

        ?>
			   
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