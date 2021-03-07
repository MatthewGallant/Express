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

        <br />

        <?php

            if (isset($_POST['color_select'])) {
                if ($_POST['color_select'] != "") {

                    $colors = ['Blue' => 'primary', 'Grey' => 'secondary', 'Green' => 'success', 'Red' => 'danger', 'Yellow' => 'warning', 'Light Blue' => 'info', 'White' => 'light', 'Black' => 'dark'];

                    $color = $colors[$_POST['color_select']];

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
                        $stmt = $conn->prepare("UPDATE config SET theme_color = :theme_color WHERE id = 1");
                        
                        $stmt->bindParam(':theme_color', $theme_color);
            
                        $theme_color = $color;
            
                        $stmt->execute();

                        express_log("Change Color Theme", "The color theme has been changed to '" . $_POST['color_select'] . "'.");
            
                        header("Location: settings.php?message=color_success");

                    } catch(PDOException $e) {
                        header("Location: settings.php?message=color_failure");
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

        <h2>Change Color Theme<a href="settings.php" class="btn btn-danger btn-round" style="margin-left: 20px; float: right;">Back</a></h2>
        <p>Change the color theme of the online store.</p>

        <br />

        <form method="POST" action="change-theme.php">
            <div class="form-group">
                <label for="color_select">Select Color</label>
                <select class="form-control" id="color_select" name="color_select">
                    <?php

                        $colors = ['Blue' => 'primary', 'Grey' => 'secondary', 'Green' => 'success', 'Red' => 'danger', 'Yellow' => 'warning', 'Light Blue' => 'info', 'White' => 'light', 'Black' => 'dark'];

                        foreach ($colors as $color => $code) {

                            if ($theme_color == $code) {
                                echo "<option selected='selected'>" . $color . "</option>";
                            } else {
                                echo "<option>" . $color . "</option>";
                            }

                        }

                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-<?php echo $theme_color; ?>">Save Color Theme</button>

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