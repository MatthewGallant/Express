<?php

include_once("functions.php");
verify();

include_once("database.php");

$data = query("SELECT * FROM config WHERE id = 1");
$business_name = $data[0]['business_name'];
$business_slogan = $data[0]['business_slogan'];
$theme_color = $data[0]['theme_color'];

$user_data = query("SELECT email FROM login WHERE id = " . $_SESSION['id']);

page_access_log();

$ini_array = parse_ini_file("about.ini");

$version = $ini_array['version'];
$date = $ini_array['date'];
$time = $ini_array['time'];

$admin_status = get_admin_status();

?>

<!doctype html>
<html lang="en">
  <head>
  	<?php include_once("head.php"); ?>
  </head>
  <body>
    <?php include_once("panelbar.php"); ?>
	
	<div class="container">

        <div class="modal fade" id="aboutModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="aboutModalLabel">About Gallant Express</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <img src="gallant-media.png" class="img-fluid" alt="Gallant Media Logo">
                            </div>
                            <div class="col-sm-9">
                                <h3>Gallant Express</h3>
                                <h6>Version <?php echo $version; ?></h6>
                                <h6>Built on <?php echo $date; ?> @ <?php echo $time; ?></h6>
                                <h6>Licensed to: <?php echo $business_name; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <br />

        <?php

        if (isset($_GET['message'])) {
            if ($_GET['message'] == "color_success") {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                echo 'The Color Theme Was Changed Successfully.';
                echo '<button type="button" class="close" data-dismiss="alert">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
                echo '</div>';
            } elseif ($_GET['message'] == "color_failure") {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo 'There Was An Error While Attempting to Change The Color Theme.';
                echo '<button type="button" class="close" data-dismiss="alert">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
                echo '</div>';
            } elseif ($_GET['message'] == "wait_success") {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                echo 'The Wait Time Was Changed Successfully.';
                echo '<button type="button" class="close" data-dismiss="alert">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
                echo '</div>';
            } elseif ($_GET['message'] == "wait_failure") {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo 'There Was An Error While Attempting to Change The Wait Time.';
                echo '<button type="button" class="close" data-dismiss="alert">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
                echo '</div>';
            } elseif ($_GET['message'] == "logo_success") {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                echo 'The Logo Was Changed Successfully.';
                echo '<button type="button" class="close" data-dismiss="alert">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
                echo '</div>';
            } elseif ($_GET['message'] == "logo_failure") {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo 'There Was An Error While Attempting to Change The Logo.';
                echo '<button type="button" class="close" data-dismiss="alert">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
                echo '</div>';
            } elseif ($_GET['message'] == "slogan_success") {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                echo 'The Slogan Was Changed Successfully.';
                echo '<button type="button" class="close" data-dismiss="alert">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
                echo '</div>';
            } elseif ($_GET['message'] == "slogan_failure") {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo 'There Was An Error While Attempting to Change The Slogan.';
                echo '<button type="button" class="close" data-dismiss="alert">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
                echo '</div>';
            }
        }

        ?>

        <div class="row">
            <div class="col">
                <h2>Account Settings</h2>
            </div>
            <div class="col"></div>
            <div class="col">
                <h4><?php echo $user_data[0]['email']; ?></h4>
            </div>
        </div>

        <br />

        <div class="row">

            <div class="col">

                <?php if ($admin_status == "Yes"): ?>

                <div>
                    <h5>Color Theme</h5>
                    <p>Change the color theme of the online store.</p>
                    <a href="change-theme.php" class="btn btn-<?php echo $theme_color; ?>">Change Theme</a>
                </div>

                <br />

                <div>
                    <h5>Store Logo</h5>
                    <p>Change the store logo that appears at the top left corner of every page.</p>
                    <a href="change-logo.php" class="btn btn-<?php echo $theme_color; ?>">Change Logo</a>
                </div>

                <br />

                <div>
                    <h5>Order Wait Time</h5>
                    <p>Change the amount of time that the customer is told to wait after placing an order before they should pick it up.</p>
                    <a href="change-wait-time.php" class="btn btn-<?php echo $theme_color; ?>">Change Wait Time</a>
                </div>
            </div>
            <div class="col">
                <div>
                    <h5>Company Slogan</h5>
                    <p>Change the slogan that appears on the front page.</p>
                    <a href="change-slogan.php" class="btn btn-<?php echo $theme_color; ?>">Change Slogan</a>
                </div>

                <br />

                <?php endif; ?>

                <div>
                    <h5>Express System Log</h5>
                    <p>View the Express System Log.</p>
                    <a href="log.php?page=1" class="btn btn-<?php echo $theme_color; ?>">View Log</a>
                </div>

                <br />

                <div>
                    <h5>Express System Information</h5>
                    <p>Information about the Gallant Express installation.</p>
                    <button type="button" data-toggle="modal" data-target="#aboutModal" class="btn btn-<?php echo $theme_color; ?>">View Information</button>
                </div>
            </div>
        </div>

        <br />
			   
    </div>

	<?php include_once("footer.php"); ?>
	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>