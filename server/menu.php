<?php

include_once("database.php");

$data = query("SELECT * FROM config WHERE id = 1");
$business_name = $data[0]['business_name'];
$business_slogan = $data[0]['business_slogan'];
$theme_color = $data[0]['theme_color'];
$currency = $data[0]['currency'];

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

        <div align="center">
            <h2>Menu</h2>
        </div>

        <br />
        
        <div class="table-responsive rounded">
            <table class="table table-striped table-hover table-bordered" style="">
                <?php

                $menu = query("SELECT * FROM menu");

                $categories = [];

                foreach ($menu as $menu_item) {
                    if (!in_array($menu_item['item_category'], $categories)) {
                        // Set Category as Array
                        $categories[$menu_item['item_category']] = [];
                    }
                }

                ksort($categories);

                foreach ($menu as $menu_item) {
                    if ($menu_item['for_sale'] == "yes") {
                        if (!in_array($menu_item['item_category'], $categories)) {
                            // Add Item to Category
                            $categories[$menu_item['item_category']][$menu_item] = [];
                            array_push($categories[$menu_item['item_category']], $menu_item);
                            
                        } else {
                            $categories[$menu_item['item_category']][$menu_item] = [];
                            array_push($categories[$menu_item['item_category']], $menu_item);
                        }
                    }
                }

                $categories  = array_filter($categories);

                foreach ($categories as $category) {
                    if (empty($category)) {
                        unset($category);
                    }
                }

                foreach ($categories as $key => $category) {

                    echo "<thead class='thead-dark'>";
                    echo "<tr>";
                    echo "<th scope='col'>" . $key . "</th>";
                    echo "<th scope='col'></th>";
                    echo "<th scope='col'></th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    foreach ($category as $menu_item) {
                        echo "<tr>";
                        echo "<td>" . $menu_item['item_name'] . "</td>";
                        echo "<td>$" . $menu_item['item_price'] . " " . $currency . "</td>";
                        echo "<td><a href='item.php?id=" . $menu_item['id'] . "' class='btn btn-" . $theme_color . " btn-block'>Select</a></td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                }

                ?>
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