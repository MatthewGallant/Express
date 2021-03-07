<?php

include_once("functions.php");
verify();

include_once("database.php");

$data = query("SELECT business_name, business_slogan FROM config WHERE id = 1");
$business_name = $data[0]['business_name'];
$business_slogan = $data[0]['business_slogan'];
$theme_color = $data[0]['theme_color'];

page_access_log();

$modifier_id = $_GET['id'];

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
                    echo 'The Option Was Added Successfully.';
                    echo '<button type="button" class="close" data-dismiss="alert">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo '</div>';
                } elseif ($_GET['message'] == "add_failure") {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo 'This Option Already Exists.';
                    echo '<button type="button" class="close" data-dismiss="alert">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo '</div>';
                } elseif ($_GET['message'] == "delete_success") {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                    echo 'The Option Has Been Removed From This Modifier Successfully.';
                    echo '<button type="button" class="close" data-dismiss="alert">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo '</div>';
                } elseif ($_GET['message'] == "delete_failure") {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo 'An Error Occurred While Trying To Remove The Option From This Modifier.';
                    echo '<button type="button" class="close" data-dismiss="alert">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo '</div>';
                }
            }

            if (isset($_POST['modifier_name']) && isset($_POST['modifier_select'])) {
                if ($_POST['modifier_name'] != "" && $_POST['modifier_select'] != "") {

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
                        $stmt = $conn->prepare("UPDATE modifiers SET modifier_name = :modifier_name, modifier_type = :modifier_select WHERE id = " . $modifier_id);
                        
                        $stmt->bindParam(':modifier_name', $modifier_name);
                        $stmt->bindParam(':modifier_select', $modifier_select);

                        $modifier_types = ['Single' => 'single', 'Multiple' => 'multi'];
            
                        $modifier_name = clean($_POST['modifier_name']);

                        foreach ($modifier_types as $title => $name) {
                            if ($_POST['modifier_select'] == $title) {
                                $modifier_select = $name;
                            }
                        }
            
                        $stmt->execute();

                        express_log("Edit Modifier List", "The modifier '" . $modifier_id . "' has been edited.");
            
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

            $modifier_data = query("SELECT * FROM modifiers WHERE id = " . $modifier_id);

        ?>

        <h2>Edit Modifier List: <?php echo $modifier_data[0]['modifier_name']; ?><a href="edit-modifier-lists.php" class="btn btn-danger btn-round" style="margin-left: 20px; float: right;">Back</a></h2>

        <br />

        <form method="POST" action="edit-modifier-list.php?id=<?php echo $modifier_id; ?>">
            <div class="form-group">
                <label for="modifier_name">Modifier Name</label>
                <input type="text" class="form-control" id="modifier_name" name="modifier_name" placeholder="Enter Item Name" value="<?php echo $modifier_data[0]['modifier_name']; ?>">
            </div>
            <div class="form-group">
                <label for="modifier_select">Select Modifier Type</label>
                <select class="form-control" id="modifier_select" name="modifier_select">
                    <?php

                        $modifier_types = ['single' => 'Single', 'multi' => 'Multiple'];

                        foreach ($modifier_types as $type => $name) {

                            if ($modifier_data[0]['modifier_type'] == $type) {
                                echo "<option selected='selected'>" . $name . "</option>";
                            } else {
                                echo "<option>" . $name . "</option>";
                            }
                        }

                    ?>
                </select>
                <small id="type_help" class="form-text text-muted">A single allows the customer to select only one option. A multiple allows the customer to select multiple options.</small>
            </div>

            <button type="submit" class="btn btn-<?php echo $theme_color; ?>">Save</button>

            <br /><br />

        </form>

        <br />

        <div class="row">
            <div class="col-sm-4">
                <h3>Modifier Options</h3>
            </div>
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <a href="add-option.php?id=<?php echo $modifier_id; ?>" class="btn btn-block btn-<?php echo $theme_color; ?>">Add Option</a>
            </div>
        </div>

        <br />

        <?php

        if ($modifier_data[0]['modifier_data'] != "") {

            echo "<div class='table-responsive rounded'>";
            echo "<table class='table table-striped table-hover table-bordered'>";
            echo "<thead class='thead-dark'>";
            echo "<tr>";
            echo "<th scope='col'>Option Name</th>";
            echo "<th scope='col'>Option Price</th>";
            echo "<th scope='col'>Edit Option</th>";
            echo "<th scope='col'>Delete Option</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            $option_data = explode("|", $modifier_data[0]['modifier_data']);

            foreach ($option_data as $mod) {

                $modifier_options = explode("::", $mod);

                echo "<tr>";
                echo "<td><b>" . $modifier_options[0] . "</b></td>";
                echo "<td>" . $modifier_options[1] . "</td>";

                echo "<td><a href='edit-option.php?modifier=" . $modifier_id . "&option=" . preg_replace('/\s+/', '_', $modifier_options[0]) . "' class='btn btn-block btn-" . $theme_color . "'>Edit Option</a></td>";
                echo "<td><button type='button' class='btn btn-block btn-danger' onclick='deleteOption(" . $modifier_id . ", \"" . preg_replace('/\s+/', '_', $modifier_options[0]) . "\")'>Delete Option</button></td>";
                echo "</tr>";
            }

            echo "</tr>";
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
            
        }

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