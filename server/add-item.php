<?php

include_once("functions.php");
verify();

include_once("database.php");

$data = query("SELECT business_name, business_slogan FROM config WHERE id = 1");
$business_name = $data[0]['business_name'];
$business_slogan = $data[0]['business_slogan'];
$theme_color = $data[0]['theme_color'];

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
        $stmt = $conn->prepare("INSERT INTO menu () VALUES ()");

        $stmt->execute();

        $last_id = $conn->lastInsertId();

        header("Location: add-item.php?id=" . $last_id);

    } catch(PDOException $e) {
        header("Location: edit-menu.php?message=add_failure");
    }

    $conn = null;
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

        <div class="row">
            <div class="col">
                <h2>Add Item</h2>
            </div>
            <div class="col"></div>
            <div class="col">
                <a href="delete-item.php?id=<?php echo $item_id; ?>" class="btn btn-danger btn-block">Cancel</a>
            </div>
        </div>

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

            <button type="submit" class="btn btn-<?php echo $theme_color; ?>">Add Item</button>

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