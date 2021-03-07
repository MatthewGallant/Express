<?php

include_once("functions.php");
verify();

include_once("database.php");

$data = query("SELECT * FROM config WHERE id = 1");
$business_name = $data[0]['business_name'];
$business_slogan = $data[0]['business_slogan'];
$theme_color = $data[0]['theme_color'];

$user_data = query("SELECT name FROM login WHERE id = " . $_SESSION['id']);

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

        <br /><br />

        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6" align="center">
                <h2>Welcome <?php echo $user_data[0]['name']; ?></h2>
                <p>Please select an option from below to get started.</p>
                <br />
                <a href="edit-menu.php" class="btn btn-<?php echo $theme_color; ?> btn-block">Edit Menu</a>
                <a href="edit-modifier-lists.php" class="btn btn-<?php echo $theme_color; ?> btn-block">Edit Modifier Lists</a>
                <a href="edit-categories.php" class="btn btn-<?php echo $theme_color; ?> btn-block">Edit Categories</a>
                
                <hr class="my-4">
                
                <a href="edit-hours.php" class="btn btn-<?php echo $theme_color; ?> btn-block">Edit Ordering Hours</a>
                <a href="view-completed.php" class="btn btn-<?php echo $theme_color; ?> btn-block">View Completed Transactions</a>

                <hr class="my-4">

                <a href="manage-accounts.php" class="btn btn-<?php echo $theme_color; ?> btn-block">Manage Accounts</a>
                <a href="settings.php" class="btn btn-<?php echo $theme_color; ?> btn-block">Account Settings</a>
            </div>
            <div class="col-sm-3"></div>
        </div>
			   
    </div>

	<?php include_once("footer.php"); ?>
	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>