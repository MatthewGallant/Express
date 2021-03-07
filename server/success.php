<?php

include_once("database.php");

$data = query("SELECT * FROM config WHERE id = 1");
$business_name = $data[0]['business_name'];
$business_slogan = $data[0]['business_slogan'];
$theme_color = $data[0]['theme_color'];
$order_time = $data[0]['order_time'];

if (isset($_GET['uuid'])) {
    $uuid = $_GET['uuid'];
    $order = query("SELECT id FROM incoming_orders WHERE uuid = '" . $uuid . "'");
    $id = $order[0]['id'];
}

?>

<!doctype html>
<html lang="en">
  <head>
  	<?php include_once("head.php"); ?>
  </head>
  <body>
	<?php include_once("navbar.php"); ?>
	
	<div class="container">

        <br /><br /><br />

        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4" align="center">
                <h4>Order <b>#<?php echo $id; ?></b></h4>
                <h6>Your order will be ready for pickup in <?php echo $order_time; ?> minutes. Please have this number ready when you pickup the order.</h6>
                <br />
                <div style="font-size:8em;">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <br />
                <a href="menu.php" class="btn btn-<?php echo $theme_color; ?>">Start New Order</a>
            </div>
            <div class="col-sm-4"></div>
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