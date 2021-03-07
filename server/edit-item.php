<?php

include_once("functions.php");
verify();

include_once("database.php");

$data = query("SELECT business_name, business_slogan FROM config WHERE id = 1");
$business_name = $data[0]['business_name'];
$business_slogan = $data[0]['business_slogan'];
$theme_color = $data[0]['theme_color'];

$item_id = $_GET['id'];
$item_data = query("SELECT * FROM menu WHERE id = " . $item_id);
$item_name = $item_data[0]['item_name'];
$item_slogan = $item_data[0]['item_slogan'];
$item_price = $item_data[0]['item_price'];
$item_category = $item_data[0]['item_category'];
$item_modifiers_string = $item_data[0]['item_modifiers'];

page_access_log();

?>

<!doctype html>
<html lang="en">
  <head>
  	<?php include_once("head.php"); ?>
  </head>
  <body>
    <?php include_once("panelbar.php"); ?>

    <div id="modalDiv">
        <div class="modal fade" id="addModifierModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModifierModalLabel">Add Modifier List to Item</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <?php

                            echo "<div class='table-responsive rounded'>";
                            echo "<table class='table table-striped table-hover table-bordered'>";
                            echo "<thead class='thead-dark'>";
                            echo "<tr>";
                            echo "<th scope='col'>Modifier List Name</th>";
                            echo "<th scope='col'>Modifier List Items</th>";
                            echo "<th scope='col'>Modifier List Type</th>";
                            echo "<th scope='col'>Select Modifier List</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";

                            $modal_modifiers = query("SELECT * FROM modifiers");

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
                                    echo "<td><a href='add-modifier.php?item=" . $item_id . "&modifier=" . $modal_modifier['id'] . "' class='btn btn-block btn-" . $theme_color . "'>Select</a></td>";
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
                                    echo "<td><a href='add-modifier.php?item=" . $item_id . "&modifier=" . $modal_modifier['id'] . "' class='btn btn-block btn-" . $theme_color . "'>Select</a></td>";
                                    echo "</tr>";
                                }
                            }

                            echo "</tr>";
                            echo "</tbody>";
                            echo "</table>";
                            echo "</div>";

                        ?>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	<div class="container">

        <br />

        <?php

            if (isset($_GET['message'])) {
                if ($_GET['message'] == "add_success") {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                    echo 'The Modifier List Was Added Successfully.';
                    echo '<button type="button" class="close" data-dismiss="alert">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo '</div>';
                } elseif ($_GET['message'] == "add_failure") {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo 'This Item Already Has The Modifier List.';
                    echo '<button type="button" class="close" data-dismiss="alert">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo '</div>';
                } elseif ($_GET['message'] == "delete_success") {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                    echo 'The Modifier Has Been Removed From This Item Successfully.';
                    echo '<button type="button" class="close" data-dismiss="alert">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo '</div>';
                } elseif ($_GET['message'] == "delete_failure") {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo 'An Error Occurred While Trying To Remove The Modifier From This Item.';
                    echo '<button type="button" class="close" data-dismiss="alert">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo '</div>';
                }
            }

            if (isset($_POST['item_name']) && isset($_POST['item_slogan']) && isset($_POST['item_price']) && isset($_POST['category_select'])) {
                if ($_POST['item_name'] != "" && $_POST['item_slogan'] != "" && $_POST['item_price'] != "" && $_POST['category_select'] != "") {

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
                        $stmt = $conn->prepare("UPDATE menu SET item_name = :item_name, item_slogan = :item_slogan, item_price = FORMAT(:item_price, 2), item_category = :item_category, for_sale = 'yes' WHERE id = " . $item_id);
                        
                        $stmt->bindParam(':item_name', $item_name);
                        $stmt->bindParam(':item_slogan', $item_slogan);
                        $stmt->bindParam(':item_price', $item_price);
                        $stmt->bindParam(':item_category', $item_category);
            
                        $item_name = clean($_POST['item_name']);
                        $item_slogan = clean($_POST['item_slogan']);
                        $item_price = clean($_POST['item_price']);
                        $item_category = clean($_POST['category_select']);
            
                        $stmt->execute();

                        express_log("Edit Item", "The item '" . $item_id . "' has been changed.");
            
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                        echo 'The Item Was Saved Successfully.';
                        echo '<button type="button" class="close" data-dismiss="alert">';
                        echo '<span aria-hidden="true">&times;</span>';
                        echo '</button>';
                        echo '</div>';

                    } catch(PDOException $e) {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                        echo 'There Was An Error Saving The Item. Error Information: ' . $e->getMessage();
                        echo '<button type="button" class="close" data-dismiss="alert">';
                        echo '<span aria-hidden="true">&times;</span>';
                        echo '</button>';
                        echo '</div>';
                    }
            
                    $conn = null;

                } else {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo 'Please Fill in All of The Fields.';
                    echo '<button type="button" class="close" data-dismiss="alert">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo '</div>';
                }
            }

        ?>

        <h2>Edit Item: <?php echo $item_name; ?><a href="edit-menu.php" class="btn btn-danger btn-round" style="margin-left: 20px; float: right;">Back</a></h2>

        <br />

        <form method="POST" action="edit-item.php?id=<?php echo $item_id; ?>">
            <div class="form-group">
                <label for="item_name">Item Name</label>
                <input type="text" class="form-control" id="item_name" name="item_name" placeholder="Enter Item Name" value="<?php echo $item_name; ?>">
            </div>
            <div class="form-group">
                <label for="item_slogan">Item Description</label>
                <input type="text" class="form-control" id="item_slogan" name="item_slogan" placeholder="Enter Item Description" value="<?php echo $item_slogan; ?>">
            </div>
            <div class="form-group">
                <label for="item_price">Item Price <b>(Without Dollar Sign)</b></label>
                <input type="text" class="form-control" id="item_price" name="item_price" placeholder="Enter Item Price Without the Dollar Sign (Ex: 9.99)" value="<?php echo $item_price; ?>">
            </div>
            <div class="form-group">
                <label for="category_select">Select Item Category</label>
                <select class="form-control" id="category_select" name="category_select">
                    <?php

                        $categories = query("SELECT * FROM categories");

                        foreach ($categories as $category) {

                            if ($category['category_name'] == $item_category) {
                                echo "<option selected='selected'>" . $category['category_name'] . "</option>";
                            } else {
                                echo "<option>" . $category['category_name'] . "</option>";
                            }
                        }

                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-<?php echo $theme_color; ?>">Save</button>

            <br /><br />

        </form>	

        <br />

        <div class="row">
            <div class="col-sm-4">
                <h3>Item Modifiers</h3>
            </div>
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <button type="button" class="btn btn-block btn-<?php echo $theme_color; ?>" data-toggle="modal" data-target="#addModifierModal">Add Modifier List to Item</button>
            </div>
        </div>

        <br />
        
        <?php

        if ($item_modifiers_string != "") {

            echo "<div class='table-responsive rounded'>";
            echo "<table class='table table-striped table-hover table-bordered'>";
            echo "<thead class='thead-dark'>";
            echo "<tr>";
            echo "<th scope='col'>Modifier List Name</th>";
            echo "<th scope='col'>Modifier List Items</th>";
            echo "<th scope='col'>Modifier List Type</th>";
            echo "<th scope='col'>Edit Modifier List</th>";
            echo "<th scope='col'>Remove Modifier List</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            
            $item_modifiers = explode(", ", $item_modifiers_string);

            foreach ($item_modifiers as $modifier) {

                $modifier = query("SELECT * FROM modifiers WHERE id = " . $modifier);

                if ($modifier[0]['modifier_type'] == "multi") {

                    $modifier_data = explode("|", $modifier[0]['modifier_data']);

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
                    echo "<td><b>" . $modifier[0]['modifier_name'] . "</b></td>";
                    echo "<td>" . implode(", ", $options) . "</td>";
                    echo "<td>Multiple</td>";
                    echo "<td><button type='button' class='btn btn-block btn-" . $theme_color . "' onclick='editModal(" . $modifier[0]['id'] . ", \"" . $theme_color . "\")'>Edit Modifier</button></td>";
                    echo "<td><button type='button' class='btn btn-block btn-danger' onclick='deleteModal(" . $item_id . ", " . $modifier[0]['id'] . ")'>Remove Modifier</button></td>";
                    echo "</tr>";

                } else {           

                    $modifier_data = explode("|", $modifier[0]['modifier_data']);

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
                    echo "<td><b>" . $modifier[0]['modifier_name'] . "</b></td>";
                    echo "<td>" . implode(", ", $options) . "</td>";
                    echo "<td>Single</td>";
                    echo "<td><button type='button' class='btn btn-block btn-" . $theme_color . "' onclick='editModal(" . $modifier[0]['id'] . ", \"" . $theme_color . "\")'>Edit Modifier</button></td>";
                    echo "<td><button type='button' class='btn btn-block btn-danger' onclick='deleteModal(" . $item_id . ", " . $modifier[0]['id'] . ")'>Remove Modifier</button></td>";
                    echo "</tr>";
                }
            }

            echo "</tr>";
            echo "</tbody>";
            echo "</table>";
            echo "</div>";

        } else {
            echo "<h5>No Modifiers Added to Item Yet.</h5>";
        }

        ?>

    </div>

    <br />

    <?php include_once("footer.php"); ?>
    
	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="functions.js"></script>

    </body>
</html>