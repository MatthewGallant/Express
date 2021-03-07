<?php

date_default_timezone_set('America/New_York');

include_once("database.php");

$data = query("SELECT * FROM config WHERE id = 1");
$business_name = $data[0]['business_name'];
$business_slogan = $data[0]['business_slogan'];
$theme_color = $data[0]['theme_color'];
$currency = $data[0]['currency'];

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

$closed = false;

?>

<!doctype html>
<html lang="en">
  <head>
  	<?php include_once("head.php"); ?>
  </head>
  <body>
	<?php include_once("navbar.php"); ?>
	
	<div class="container">

        <br />

        <div class="row">
            <div class="col">
                <h2>Cart</h2>
            </div>
            <div class="col"></div>
            <div class="col">
                <?php

                    $times = query("SELECT * FROM hours WHERE id = 1");
                    $current_day = strtolower(date('l'));
                    $current_time = time('H:i');
                    $store_open = strtotime($times[0][$current_day . "_open"]);
                    $store_close = strtotime($times[0][$current_day . "_close"]);
                    $day_closed = $times[0][$current_day . "_closed"];

                    if($current_time >= $store_open && $current_time <= $store_close && $day_closed == "No") {
                        if (isset($_COOKIE['order'])) {
                            echo "<a href='checkout.php' class='btn btn-block btn-" . $theme_color . "'>Checkout ($" . number_format($total_price, 2, '.', '') . " " . $currency . ")</a>";
                        }
                    } else {
                        $closed = true;
                    }

                ?>
            </div>
        </div>

        <?php

        if ($closed == true) {
            echo "<br /><p>The store is currently closed. Please wait to order until the store is open. You can view the store's hours <a href='hours.php'>here.</a></p>";
        }

        ?>

        <br />

        <div class="table-responsive rounded">
            <table class="table table-striped table-hover table-bordered">
                <tbody>
                    <?php

                        if (isset($_COOKIE['order'])) {

                            $order = explode("/", $_COOKIE['order']);

                            echo "<thead class='thead-dark'>";
                            echo "<tr>";
                            echo "<th scope='col'>Name</th>";
                            echo "<th scope='col'>Options</th>";
                            echo "<th scope='col'>Comments</th>";
                            echo "<th scope='col'>Price</th>";
                            echo "<th scope='col'>Remove</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            
                            foreach ($order as $item) {

                                $exploded_item = explode("|", $item);

                                $item_data = query("SELECT * FROM menu WHERE id = " . $exploded_item[0]);
                                $item_name = $item_data[0]['item_name'];
                                $item_slogan = $item_data[0]['item_slogan'];
                                $item_price = $item_data[0]['item_price'];
                                $item_modifiers_string = $item_data[0]['item_modifiers'];

                                echo "<tr>";
                                echo "<td>" . $item_name . "</td>";

                                if ($exploded_item[1] == "") {
                                    echo "<td>None</td>";
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
                                                $modifier_list = $modifier_list . "<b>" . $modifier_data[0] . "</b>";
                                            } else {
                                                $modifier_list = $modifier_list . $modifier_data[0] . ": " . "<b>" . $modifier_data[1] . "</b>";
                                            }

                                            $first_modifier = false;

                                        } elseif ($modifier_data[0] == "") {
                                            // Pass
                                        }
                                        else {
                                            if ($modifier_data[1] == "Yes") {
                                                $modifier_list = $modifier_list . ", " . "<b>" . $modifier_data[0] . "<b/>";
                                            } else {
                                                $modifier_list = $modifier_list . ", " . $modifier_data[0] . ": " . "<b>" . $modifier_data[1] . "</b>";
                                            }
                                        }
                                    }

                                    echo "<td>" . $modifier_list . "</td>";
                                }
                                
                                if ($exploded_item[2] == "") {
                                    echo "<td>None</td>";
                                } else {
                                    echo "<td>" . $exploded_item[2] . "</td>";
                                }
                                
                                echo "<td>$" . number_format($item_price, 2, '.', '') . " " . $currency . "</td>";
                                echo "<td><a href='remove.php?id=" . $exploded_item[3] . "'>Remove</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<h4>No Items Found in Cart. <a href='menu.php'>Want to Find Some?</a></h4>";
                        }

                    ?>
                </tbody>
            </table>
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