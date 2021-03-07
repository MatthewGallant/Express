<?php

include_once("functions.php");
verify();

include_once("database.php");

$data = query("SELECT business_name, business_slogan FROM config WHERE id = 1");
$business_name = $data[0]['business_name'];
$business_slogan = $data[0]['business_slogan'];
$theme_color = $data[0]['theme_color'];

$item_id = $_GET['modifier'];
$option_id = $_GET['option'];

$modifier_data = query("SELECT * FROM modifiers WHERE id = " . $item_id);

$option_data = explode("|", $modifier_data[0]['modifier_data']);

foreach ($option_data as $mod) {

    $modifier_options = explode("::", $mod);

    $option_id = str_replace("_", " ", $option_id);

    if ($modifier_options[0] == $option_id) {
        $option_name = $modifier_options[0];
        $option_price = $modifier_options[1];
    }
}

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

        <br />

                <?php

                if (isset($_POST['option_name']) && isset($_POST['option_price'])) {
                    if ($_POST['option_name'] != "" && $_POST['option_price'] != "") {

                        $modifier_id = $_GET['id'];
                        $option_name = $_GET['option'];
                    
                        $modifier_options = query("SELECT modifier_data FROM modifiers WHERE id = " . $item_id)[0]['modifier_data'];
                    
                        $option_data = explode("|", $modifier_options);
                    
                        $new_options = [];

                        $exists = false;
                    
                        foreach ($option_data as $mod) {
                    
                            $modifier_options = explode("::", $mod);
                    
                            $option_name = str_replace("_", " ", $option_name);
                    
                            $opt = $modifier_options[0] . "::" . $modifier_options[1];

                            if ($_POST['option_name'] == $modifier_options[0]) {
                                array_push($new_options, $_POST['option_name'] . "::" . $_POST['option_price']);
                            } else {
                                array_push($new_options, $opt);
                            }
                        }
                    
                        $new_options_string = implode("|", $new_options);
                    
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
                            $stmt = $conn->prepare("UPDATE modifiers SET modifier_data = :modifier_data WHERE id = " . $item_id);
                    
                            $stmt->bindParam(':modifier_data', $modifier_data);
                    
                            $modifier_data = $new_options_string;
                    
                            $stmt->execute();
                    
                            express_log("Edit Option", "The option '" . $option_name . "' has been saved to modifier list '" . $modifier_id . "'.");
                    
                            header("Location: edit-modifier-list.php?id=" . $item_id . "&message=add_success");
                        
                        } catch(PDOException $e) {
                            header("Location: edit-modifier-list.php?id=" . $item_id . "&message=add_failure");
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

        <div class="row">
            <div class="col">
                <h2>Edit Option: <?php echo $option_name; ?></h2>
            </div>
            <div class="col"></div>
            <div class="col">
                <a href="edit-modifier-list.php?id=<?php echo $item_id; ?>" class="btn btn-danger btn-block">Cancel</a>
            </div>
        </div>

        <br />

        <form method="POST" action="edit-option.php?modifier=<?php echo $item_id; ?>">
            <div class="form-group">
                <label for="option_name">Option Name</label>
                <input type="text" readonly class="form-control" id="option_name" name="option_name" placeholder="Option Name" value="<?php echo $option_name; ?>">
            </div>
            <div class="form-group">
                <label for="option_price">Option Price <b>(Without Dollar Sign)</b></label>
                <input type="text" class="form-control" id="option_price" name="option_price" placeholder="Option Price (Without Dollar Sign)" value="<?php echo $option_price; ?>">
            </div>

            <button type="submit" class="btn btn-<?php echo $theme_color; ?>">Save Option</button>

            <br /><br />

        </form>	

        <br />

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