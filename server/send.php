<?php

date_default_timezone_set('America/New_York');

include_once("database.php");
include_once("functions.php");

$data = query("SELECT * FROM config WHERE id = 1");
$business_name = $data[0]['business_name'];
$business_slogan = $data[0]['business_slogan'];
$theme_color = $data[0]['theme_color'];
$order_time = $data[0]['order_time'];
$company_email = $data[0]['email_address'];

$item_names = [];
$item_modifiers = [];
$item_prices = [];

$times = query("SELECT * FROM hours WHERE id = 1");
$current_day = strtolower(date('l'));
$current_time = time('H:i');
$store_open = strtotime($times[0][$current_day . "_open"]);
$store_close = strtotime($times[0][$current_day . "_close"]);
$day_closed = $times[0][$current_day . "_closed"];

if($current_time >= $store_open && $current_time <= $store_close && $day_closed == "No") {
    if (!isset($_POST['full_name_field']) || !isset($_POST['email_address_field']) || !isset($_POST['phone_number_field']) || $_POST['full_name_field'] == "" || $_POST['email_address_field'] == "" || $_POST['phone_number_field'] == "") {
        header("Location: checkout.php?error=field_empty");
    } else if (!filter_var($_POST['email_address_field'], FILTER_VALIDATE_EMAIL)) {
        header("Location: checkout.php?error=invalid_email");
    } else if (strlen($_POST['phone_number_field']) != 14 || preg_match('/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i', $_POST['phone_number_field']) == false) {
        header("Location: checkout.php?error=invalid_phone");
    }  else {
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
    
                    array_push($item_names, $item_name);
                    array_push($item_prices, $item_price);
    
                    $total_price = $total_price + $item_price;
                }
            }
            
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
                $stmt = $conn->prepare("INSERT INTO incoming_orders (uuid, `order`, time_ordered, price, full_name, email_address, phone_number) VALUES (:uuid, :order, :time_ordered, :price, :full_name, :email_address, :phone_number)");
                $stmt->bindParam(':uuid', $uuid);
                $stmt->bindParam(':order', $order_string);
                $stmt->bindParam(':time_ordered', $time_ordered);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':full_name', $full_name);
                $stmt->bindParam(':email_address', $email_address);
                $stmt->bindParam(':phone_number', $phone_number);
    
                $uuid = uniqid();
                $order_string = $_COOKIE['order'];
                $time_ordered = date('m-d-y h:i a');
                $price = $total_price;
                $full_name = clean($_POST['full_name_field']);
                $email_address = clean($_POST['email_address_field']);
                $phone_number = clean($_POST['phone_number_field']);
                $stmt->execute();
    
                setcookie("order", "", time()-3600);
                setcookie("cart_number", "", time()-3600);
    
                // Send receipt
                $order = query("SELECT id FROM incoming_orders WHERE uuid = '" . $uuid . "'");
                $id = $order[0]['id'];
    
                $to = $email_address . ", " . $company_email;
                $subject = "Your Order Receipt";
    
                $message = '
                <html>
                    <head>
                        <title>Your Order Receipt</title>
                        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
                        <style>
                            html {
                                position: relative;
                                min-height: 100%;
                            }
                            body {
                                margin-bottom: 60px;
                            }
                            .footer {
                                position: absolute;
                                bottom: 0;
                                width: 100%;
                                background-color: #f5f5f5;
                            }
                        </style>
                    </head>
                    <body>
                        <div align="center">
                            <div class="jumbotron jumbotron-fluid">
                                <div class="container">
                                    <h1 class="display-4">' . $business_name . '</h1>
                                    <p class="lead">' . $business_slogan . '</p>
                                </div>
                            </div>
    
                            <div class="container">
    
                                <p>Here is your receipt from ' . $business_name . '. Your order will be ready for pickup in ' . $order_time . ' minutes.</p>
    
                                <br />
    
                                <h3>Order <b>#' . $id . '</b></h3>
                                <h4>' . strtoupper($time_ordered) . '</h4>
    
                                <br />
    
                                <div class="table-responsive rounded">
                                    <table class="table table-striped table-hover table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Item Name</th>
                                                <th scope="col">Item Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                                            
                        foreach ($item_names as $key => $data) {
                            $message .= "<tr>";
                            $message .= "<td>" . $data . "</td>";
                            $message .= "<td>$" . number_format((float) $item_prices[$key], 2, '.', '') . "</td>";
                            $message .= "</tr>";
                        }
    
                        $message .= '       <tr>
                                                <td><b>Total</b></td>
                                                <td><b>$' . number_format((float) $total_price, 2, '.', '') . '</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
    
                            <br />
    
                            <footer class="container-fluid footer">
                                <nav class="navbar">
                                    <span class="text-muted">&copy; ' . date("Y") . ' ' . $business_name . '. Powered by <a href="https://gallantmedia.us/express-restaurant/" target="_BLANK">Gallant Express for Restaurants</a>.</span>
                                </nav>
                            </footer>
    
                        </div>
                    </body>
                </html>
                ';
    
                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
                // More headers
                $headers .= 'From: ' . $business_name . ' <' . $company_email . '>' . "\r\n";
    
                mail($to, $subject, $message, $headers);
    
                header( "Refresh:3; url=success.php?uuid=" . $uuid, true, 303);
            
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
                return "Error";
            }
    
            $conn = null;
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
	
	<div class="container">

        <br /><br /><br />

        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4" align="center">
                <h4>Sending Order...</h4>
                <h6>Please do not close this window while we send your order.</h6>
                <img src="spinner.gif" class="img-fluid" alt="Responsive image">
                <br />
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
  </body>
</html>