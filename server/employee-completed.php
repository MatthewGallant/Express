<?php

include_once("functions.php");
verify_employee();

include_once("database.php");

$data = query("SELECT * FROM config WHERE id = 1");
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

    <?php include_once("livebar.php"); ?>
	
	<div style="padding: 10px;">

        <br />

        <h2>Completed Orders</h2>

        <br />

        <style>

        .table thead th { 
            background-color: var(--<?php echo $theme_color; ?>);
            color: white;
            border: black;
            vertical-align: middle;
        }

        </style>

        <div id="modalDiv"></div>

                <?php

                $incoming_orders = array_reverse(query("SELECT * FROM completed_orders"));

                if (isset($incoming_orders[0])) {

                    foreach ($incoming_orders as $order_data) {

                        echo "<div class='table-responsive rounded'>";
                        echo "<table class='table table-striped table-hover table-bordered'>";
    
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th scope='col'>Order #" . $order_data['id'] . "</th>";
                        echo "<th scope='col'>" . $order_data['full_name'] . "</th>";
                        echo "<th scope='col'>" . $order_data['email_address'] . "</th>";
                        echo "<th scope='col'>" . $order_data['phone_number'] . "</th>";
                        echo "<th scope='col'>" . strtoupper($order_data['time_placed']) . "</th>";
                        echo "<th scope='col'>$" . number_format($order_data['price'], 2, '.', '') . " USD</th>";
                        echo "</tr>";
                        echo "</thead>";

                        $order = explode("/", $order_data['order']);
                        
                        foreach ($order as $item) {

                            $exploded_item = explode("|", $item);

                            $item_data = query("SELECT * FROM menu WHERE id = " . $exploded_item[0]);
                            $item_name = $item_data[0]['item_name'];
                            $item_slogan = $item_data[0]['item_slogan'];
                            $item_price = $item_data[0]['item_price'];
                            $item_modifiers_string = $item_data[0]['item_modifiers'];

                            echo "<tr>";;

                            echo "<td>" . $item_name . "</td>";

                            if ($exploded_item[1] == "") {
                                echo "<td colspan='2'>No Modifiers</td>";
                            } else {
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

                                    if ($first_modifier == true) {

                                        if ($modifier_data[1] == "Yes") {
                                            $modifier_list = $modifier_list . $modifier_data[0];
                                        } else {
                                            $modifier_list = $modifier_list . $modifier_data[0] . ": " . $modifier_data[1];
                                        }

                                        $first_modifier = false;

                                    } elseif ($modifier_data[0] == "") {
                                        // Pass
                                    }
                                    else {
                                        if ($modifier_data[1] == "Yes") {
                                            $modifier_list = $modifier_list . ", " . $modifier_data[0];
                                        } else {
                                            $modifier_list = $modifier_list . ", " . $modifier_data[0] . ": " . $modifier_data[1];
                                        }
                                    }
                                }

                                echo "<td colspan='2'>" . $modifier_list . "</td>";
                            }
                            
                            if ($exploded_item[2] == "") {
                                echo "<td colspan='2'>No Comments</td>";
                            } else {
                                echo "<td colspan='2'>" . $exploded_item[2] . "</td>";
                            }
                            
                            echo "<td>$" . number_format($item_price, 2, '.', '') . " USD</td>";

                            echo "</tr>";
                        }                 
                    }

                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>";   

                } else {
                    echo "<div align='center'><h2>No Orders Currently</h2></div>";
                }

                ?>
			   
    </div>

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="functions.js"></script>
</body>
</html>