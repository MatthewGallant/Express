<?php

date_default_timezone_set('America/New_York');

include_once("database.php");

$data = query("SELECT * FROM config WHERE id = 1");
$business_name = $data[0]['business_name'];
$business_slogan = $data[0]['business_slogan'];
$theme_color = $data[0]['theme_color'];
$currency = $data[0]['currency'];

$times = query("SELECT * FROM hours WHERE id = 1");
$current_day = strtolower(date('l'));
$current_time = time('H:i');
$store_open = strtotime($times[0][$current_day . "_open"]);
$store_close = strtotime($times[0][$current_day . "_close"]);
$day_closed = $times[0][$current_day . "_closed"];

if($current_time >= $store_open && $current_time <= $store_close && $day_closed == "No") {
    if (isset($_COOKIE['order'])) {
        $order = explode("/", $_COOKIE['order']);

        $total_price = 0.00;

        if (isset($_COOKIE['order'])) {

            $order = explode("/", $_COOKIE['order']);
            
            foreach ($order as $item) {

                $exploded_item = explode("|", $item);

                $item_data = query("SELECT * FROM menu WHERE id = " . $exploded_item[0]);
                $item_name = $item_data[0]['item_name'];
                $item_slogan = $item_data[0]['item_slogan'];
                $item_price = $item_data[0]['item_price'];
                $item_modifiers_string = $item_data[0]['item_modifiers'];

                if ($exploded_item[1] != "") {
                    $modifiers = explode(", ", $exploded_item[1]);
                    $modifier_list = "";
                    $first_modifier = true;

                    foreach ($modifiers as $key => $modifier) {
                        if ($modifier == "") {
                            unset($modifiers[$key]);
                        }
                    }

                    foreach ($modifiers as $modifier) {
                        $modifier_data = explode("::", $modifier);

                        if (strpos($modifier_data[1], ' - ') !== false) {
                            $multiple_split = explode(" - ", $modifier_data[1]);
                            $modifier_data[1] = $multiple_split[0];
                        }

                        $db_item = query("SELECT item_modifiers FROM menu WHERE id = " . $exploded_item[0]);
                        $modifier_exploded = explode(", ", $db_item[0]['item_modifiers']);

                        foreach ($modifier_exploded as $mod) {
                            $modifier_query = query("SELECT * FROM modifiers WHERE id = " . $mod);
                            $exploded_options = explode("|", $modifier_query[0]['modifier_data']);
                            
                            foreach ($exploded_options as $option) {
                                $option_data = explode("::", $option);

                                $modifier_data[0] = str_replace("_", " ", $modifier_data[0]);

                                if ($modifier_data[0] == $option_data[0]) {
                                    $item_price = $item_price + $option_data[1];
                                } elseif ($modifier_data[1] == $option_data[0]) {
                                    $item_price = $item_price + $option_data[1];
                                }
                            }
                        }
                    }
                }
                $total_price = $total_price + $item_price;
            }
        }
    }
} else {
    header("Location: cart.php");
}

?>

<!doctype html>
<html lang="en">
  <head>
  	<?php include_once("head.php"); ?>
  </head>
  <body>
	<?php include_once("navbar.php"); ?>

    <script src="https://cdn.rawgit.com/PascaleBeier/bootstrap-validate/v2.1.3/dist/bootstrap-validate.js" ></script>
	
	<div class="container">

        <br />

        <?php

        if (isset($_GET['error'])) {
            if ($_GET['error'] == "field_empty") {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo 'Please fill out all of the fields.';
                echo '<button type="button" class="close" data-dismiss="alert">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
                echo '</div>';
            } else if ($_GET['error'] == "invalid_email") {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo 'Please enter a valid email.';
                echo '<button type="button" class="close" data-dismiss="alert">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
                echo '</div>';
            } else if ($_GET['error'] == "invalid_phone") {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo 'Please enter a valid phone number.';
                echo '<button type="button" class="close" data-dismiss="alert">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
                echo '</div>';
            }
        }

        ?>

        <div align="center">
            <h2>Checkout</h2>
        </div>

        <br />

        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4" align="center">
                <form method="POST" action="send.php">
                    <div class="form-group" align="left">
                        <label for="full_name_field">Full Name</label>
                        <input type="text" class="form-control" id="full_name_field" name="full_name_field" placeholder="Enter Full Name">
                    </div>
                    <div class="form-group" align="left">
                        <label for="email_address_field">Email Address</label>
                        <input type="email" class="form-control" id="email_address_field" name="email_address_field" placeholder="Enter Email Address">
                    </div>
                    <div class="form-group" align="left">
                        <label for="phone_number_field">Phone Number</label>
                        <input type="tel" class="form-control phone_number_field" id="phone_number_field" name="phone_number_field" placeholder="(123) 456-7890">
                    </div>

                    <br />

                    <div class="form-group" align="left">
                        <p>You owe <b>$<?php echo number_format($total_price, 2, '.', ''); ?> <?php echo $currency ?></b> at the store when picking up your order. By clicking the "Submit Order Now" button, you agree to pickup and pay for this order.</p>
                    </div>

                    <br />

                    <button type="submit" class="btn btn-<?php echo $theme_color; ?>">Submit Order Now</button>
                </form>
            </div>
            <div class="col-sm-4"></div>
        </div>

        <br />

        <div align="center">
            <p style="color: green;"><i class="fas fa-lock"></i> Connection Secure</p>
        </div>

        <br />
			   
    </div>

	<?php include_once("footer.php"); ?>
	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="cleave.min.js"></script>
    <script src="cleave-phone.us.js"></script>
    <script>

        bootstrapValidate('#full_name_field', 'regex:^[a-zA-Z ]*$:Please enter your name.|max:50:Please limit your name to 150 characters.|required')
        bootstrapValidate('#email_address_field', 'email:Please enter a valid email.|max:100:Please limit your email to 150 characters.|required')

        var cleave = new Cleave('.phone_number_field', {
            numericOnly: true,
            blocks: [0, 3, 0, 3, 4],
            delimiters: ["(", ")", " ", "-"],
        });

    </script>
  </body>
</html>