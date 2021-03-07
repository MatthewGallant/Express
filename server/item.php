<?php

include_once("database.php");

$data = query("SELECT * FROM config WHERE id = 1");
$business_name = $data[0]['business_name'];
$business_slogan = $data[0]['business_slogan'];
$theme_color = $data[0]['theme_color'];
$currency = $data[0]['currency'];

$item_id = $_GET['id'];
$item_data = query("SELECT * FROM menu WHERE id = " . $item_id);
$item_name = $item_data[0]['item_name'];
$item_slogan = $item_data[0]['item_slogan'];
$item_price = $item_data[0]['item_price'];
$item_modifiers_string = $item_data[0]['item_modifiers'];

?>

<!doctype html>
<html lang="en">
  <head>
  	<?php include_once("head.php"); ?>
  </head>
  <body>
	<?php include_once("navbar.php"); ?>
	
	<div class="container">

        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">

                <div align="center">

                <br />

                <h2><?php echo $item_name; ?></h2>
                <h2><small><b>$<?php echo $item_price; ?></b> <?php echo $currency; ?></small></h2>
                <p><?php echo $item_slogan; ?></p>

                <br />

                <form method="POST" action="add.php?id=<?php echo $item_id; ?>">
                
                    <?php

                    if ($item_modifiers_string != "") {

                        echo "<p><b>Please Select from the Options Below to Customize Your Order.</b></p></div>";
                        
                        $item_modifiers = explode(", ", $item_modifiers_string);

                        foreach ($item_modifiers as $modifier) {
                            $modifier = query("SELECT * FROM modifiers WHERE id = " . $modifier);

                            if ($modifier[0]['modifier_type'] == "multi") {

                                echo "<label><b>" . $modifier[0]['modifier_name'] . "</b></label>";

                                $modifier_data = explode("|", $modifier[0]['modifier_data']);

                                foreach ($modifier_data as $modifier) {
                                    $modifier_options = explode("::", $modifier);

                                    if ($modifier_options[1] != 0.00) {  
                                        echo "<div class='form-check'>";                              
                                        echo "<input class='form-check-input' type='checkbox' value='Yes' id='" . $modifier_options[0] . "' name='" . $modifier_options[0] . "'>";
                                        echo "<label class='form-check-label' for='" . $modifier_options[0] . "'>";
                                        echo $modifier_options[0] . " - $" . $modifier_options[1] . " + Tax";
                                        echo "</label>";
                                        echo "</div>";
                                    } else {
                                        echo "<div class='form-check'>";                              
                                        echo "<input class='form-check-input' type='checkbox' value='Yes' id='" . $modifier_options[0] . "' name='" . $modifier_options[0] . "'>";
                                        echo "<label class='form-check-label' for='" . $modifier_options[0] . "'>";
                                        echo $modifier_options[0] . " - No Extra Charge";
                                        echo "</label>";
                                        echo "</div>";
                                    }
                                }

                                echo "<br />";
                            } else {                    
                                echo "<div class='form-group'>";
                                echo "<label for='" . $modifier[0]['modifier_name'] . "'><b>" . $modifier[0]['modifier_name'] . "</b></label>";
                                echo "<select class='form-control' id='" . $modifier[0]['modifier_name'] . "' name='" . $modifier[0]['modifier_name'] . "'>";

                                $modifier_data = explode("|", $modifier[0]['modifier_data']);

                                foreach ($modifier_data as $modifier) {
                                    $modifier_options = explode("::", $modifier);

                                    if ($modifier_options[1] != 0.00) {
                                        echo "<option>" . $modifier_options[0] . " - $" . $modifier_options[1] . " + Tax</option>";
                                    } else {
                                        echo "<option>" . $modifier_options[0] . " - No Extra Charge</option>";
                                    }
                                }

                                echo "</select>";
                                echo "</div>";
                                echo "<br />";
                            }
                        }
                    }

                    ?>

                        <div class="form-group">
                            <label for="comments">Additional Comments (Optional)</label>
                            <textarea class="form-control" id="comments" name="comments" rows="3"></textarea>
                        </div>
                    <button type="submit" class="btn btn-block btn-<?php echo $theme_color; ?>">Add to Cart</button>
                    <br />
                </form>	

            </div>
            <div class="col-sm-4"></div>
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