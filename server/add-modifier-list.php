<?php

include_once("functions.php");
verify();

include_once("database.php");

$data = query("SELECT business_name, business_slogan FROM config WHERE id = 1");
$business_name = $data[0]['business_name'];
$business_slogan = $data[0]['business_slogan'];
$theme_color = $data[0]['theme_color'];

page_access_log();

if (isset($_GET['id'])) {
    $item_id = $_GET['id'];
    $item_data = query("SELECT * FROM menu WHERE id = " . $item_id);
    $item_name = $item_data[0]['item_name'];
    $item_slogan = $item_data[0]['item_slogan'];
    $item_price = $item_data[0]['item_price'];
    $item_modifiers_string = $item_data[0]['item_modifiers'];
} else {

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
        $stmt = $conn->prepare("INSERT INTO modifiers () VALUES ()");

        $stmt->execute();

        $last_id = $conn->lastInsertId();

        header("Location: add-modifier-list.php?id=" . $last_id);

    } catch(PDOException $e) {
        header("Location: edit-modifier-lists.php?message=add_failure");
    }

    $conn = null;
}

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

        <div class="row">
            <div class="col">
                <h2>Add Modifier</h2>
            </div>
            <div class="col"></div>
            <div class="col">
                <a href="delete-list.php?id=<?php echo $item_id; ?>" class="btn btn-danger btn-block">Cancel</a>
            </div>
        </div>

        <br />

        <form method="POST" action="edit-modifier-list.php?id=<?php echo $item_id; ?>">
            <div class="form-group">
                <label for="modifier_name">Modifier Name</label>
                <input type="text" class="form-control" id="modifier_name" name="modifier_name" placeholder="Enter Item Name">
            </div>
            <div class="form-group">
                <label for="modifier_select">Select Modifier Type</label>
                <select class="form-control" id="modifier_select" name="modifier_select">
                    <option>Single</option>
                    <option>Multiple</option>
                </select>
                <small id="type_help" class="form-text text-muted">A single allows the customer to select only one option. A multiple allows the customer to select multiple options.</small>
            </div>

            <button type="submit" class="btn btn-<?php echo $theme_color; ?>">Save</button>

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