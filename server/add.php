<?php

if (isset($_GET[id])) {
    include_once("database.php");
    include_once("functions.php");

    $data = query("SELECT business_name, business_slogan FROM config WHERE id = 1");
    $theme_color = $data[0]['theme_color'];

    $item_id = $_GET['id'];

    $item_string = $item_id . "|";

    foreach ($_POST as $key => $value) {    
        if ($key != "comments") {
            $item_string = $item_string . $key . "::" . $value . ", ";
        }
    }

    $comments = clean($_POST['comments']);

    $item_string = $item_string . "|" . $comments . "|" . uniqid();

    if(!isset($_COOKIE['order'])) {
        setcookie('order', $item_string, time() + (86400), "/");
    } else {
        $item_string = $_COOKIE['order'] . "/" . $item_string;
        setcookie('order', $item_string, time() + (86400), "/");
    }

    if(!isset($_COOKIE['cart_number'])) {
        setcookie('cart_number', 1, time() + (86400), "/");
    } else {
        $cart_string = $_COOKIE['cart_number'] + 1;
        setcookie('cart_number', $cart_string, time() + (86400), "/");
    }

    header("Location: add.php");
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

		<br /><br />
		
        <div align="center">
            <h3><b>Added to Cart!</b></h3>
            <br />
        </div>
        <div class="row">
            <div class="col-sm-6" align="center">
                <h4>Shop More</h4>
                <h6>Find More Items to Buy</h6>
                <br />
                <div style="font-size:8em;">
                    <i class="fas fa-search"></i>
                </div>
                <a href="menu.php" class="btn btn-<?php echo $theme_color; ?>">Shop More</a>
                <br /><br /><br />
            </div>
            <div class="col-sm-6" align="center">
                <h4>Go to Cart</h4>
                <h6>See Your Items</h6>
                <br />
                <div style="font-size:8em;">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <a href="cart.php" class="btn btn-<?php echo $theme_color; ?>">Go to Cart</a>
                <br /><br /><br />
            </div>
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