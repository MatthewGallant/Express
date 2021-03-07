<?php

include_once("functions.php");
verify();

include_once("database.php");

$data = query("SELECT business_name, business_slogan FROM config WHERE id = 1");
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
	<?php include_once("panelbar.php"); ?>
	
	<div class="container">

        <div id="modalDiv"></div>

        <br />

        <?php

        if (isset($_GET['message'])) {
            if ($_GET['message'] == "add_success") {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                echo 'The List Was Added Successfully.';
                echo '<button type="button" class="close" data-dismiss="alert">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
                echo '</div>';
            } elseif ($_GET['message'] == "add_failure") {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo 'An Error Occurred While Trying To Add This List.';
                echo '<button type="button" class="close" data-dismiss="alert">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
                echo '</div>';
            } elseif ($_GET['message'] == "delete_success") {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                echo 'The List Has Been Deleted Successfully.';
                echo '<button type="button" class="close" data-dismiss="alert">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
                echo '</div>';
            } elseif ($_GET['message'] == "delete_failure") {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo 'An Error Occurred While Trying To Deleted This List. Please Make Sure That This Modifier List is not Being Used on an Item.';
                echo '<button type="button" class="close" data-dismiss="alert">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
                echo '</div>';
            }
        }

        ?>

        <div class="row">
            <div class="col">
                <h2>Edit Modifier Lists</h2>
            </div>
            <div class="col"></div>
            <div class="col">
                <a href="add-modifier-list.php" class="btn btn-<?php echo $theme_color; ?> btn-block">Add List</a>
            </div>
        </div>

        <br />

        <?php

        $modal_modifiers = query("SELECT * FROM modifiers");

        if (isset($modal_modifiers[0]['id'])) {
            
            echo "<div class='table-responsive rounded'>";
            echo "<table class='table table-striped table-hover table-bordered'>";
            echo "<thead class='thead-dark'>";
            echo "<tr>";
            echo "<th scope='col'>Modifier List Name</th>";
            echo "<th scope='col'>Modifier List Items</th>";
            echo "<th scope='col'>Modifier List Type</th>";
            echo "<th scope='col'>Edit Modifier List</th>";
            echo "<th scope='col'>Delete Modifier List</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            foreach($modal_modifiers as $modal_modifier) {

                if ($modal_modifier['modifier_type'] == "multi") {

                    $modifier_data = explode("|", $modal_modifier['modifier_data']);

                    $options = [];

                    foreach ($modifier_data as $mod) {

                        $modifier_options = explode("::", $mod);

                        if ($modifier_options[1] != 0.00) {  
                            array_push($options, $modifier_options[0] . " - $" . $modifier_options[1]);
                        } else {
                            array_push($options, $modifier_options[0] . " - Free");
                        }
                    }

                    echo "<tr>";
                    echo "<td><b>" . $modal_modifier['modifier_name'] . "</b></td>";
                    echo "<td>" . implode(", ", $options) . "</td>";
                    echo "<td>Multiple</td>";
                    echo "<td><a href='edit-modifier-list.php?id=" . $modal_modifier['id'] . "' class='btn btn-block btn-" . $theme_color . "'>Edit List</a></td>";
                    echo "<td><button type='button' class='btn btn-block btn-danger' onclick='deleteList(" . $modal_modifier['id'] . ")'>Delete List</button></td>";
                    echo "</tr>";

                } else {           

                    $modifier_data = explode("|", $modal_modifier['modifier_data']);

                    $options = [];

                    foreach ($modifier_data as $mod) {

                        $modifier_options = explode("::", $mod);

                        if ($modifier_options[1] != 0.00) {
                            array_push($options, $modifier_options[0] . " - $" . $modifier_options[1]);
                        } else {
                            array_push($options, $modifier_options[0] . " - Free");
                        }
                    }

                    echo "<tr>";
                    echo "<td><b>" . $modal_modifier['modifier_name'] . "</b></td>";
                    echo "<td>" . implode(", ", $options) . "</td>";
                    echo "<td>Single</td>";
                    echo "<td><a href='edit-modifier-list.php?id=" . $modal_modifier['id'] . "' class='btn btn-block btn-" . $theme_color . "'>Edit List</a></td>";
                    echo "<td><button type='button' class='btn btn-block btn-danger' onclick='deleteList(" . $modal_modifier['id'] . ")'>Delete List</button></td>";
                    echo "</tr>";
                }
            }
        } else {
            echo "<div align='center'><h4>No modifier lists found. You can add one <a href='add-modifier-list.php'>here</a>.</h4></div>";
        }

        echo "</tr>";
        echo "</tbody>";
        echo "</table>";
        echo "</div>";

        ?>
			   
    </div>

	<?php include_once("footer.php"); ?>
	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="functions.js"></script>
  
</body>
</html>