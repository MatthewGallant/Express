<?php

include_once("functions.php");
verify();

include_once("database.php");

$data = query("SELECT * FROM config WHERE id = 1");
$business_name = $data[0]['business_name'];
$business_slogan = $data[0]['business_slogan'];
$theme_color = $data[0]['theme_color'];
$wait_time = $data[0]['order_time'];

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

            if (isset($_POST['image_width']) && isset($_POST['image_height'])) {
                if ($_POST['image_width'] != "" && $_POST['image_height'] != "") {

                    $target_dir = "./";
                    $target_file = $target_dir . "logo.png";
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                    // Check if image file is a actual image or fake image
                    if(isset($_POST["submit"])) {
                        $check = getimagesize($_FILES["image_input"]["tmp_name"]);
                        if($check !== false) {
                            $uploadOk = 1;
                        } else {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                            echo 'Please Upload a Valid Image.';
                            echo '<button type="button" class="close" data-dismiss="alert">';
                            echo '<span aria-hidden="true">&times;</span>';
                            echo '</button>';
                            echo '</div>';

                            $uploadOk = 0;
                        }
                    }

                    // Check file size
                    if ($_FILES["image_input"]["size"] > 2000000) {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                        echo 'Your Image is Too Large. Files Must be Under 2 MB.';
                        echo '<button type="button" class="close" data-dismiss="alert">';
                        echo '<span aria-hidden="true">&times;</span>';
                        echo '</button>';
                        echo '</div>';

                        $uploadOk = 0;
                    }

                    // Allow certain file formats
                    if($imageFileType != "png") {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                        echo 'Please Upload a .png File.';
                        echo '<button type="button" class="close" data-dismiss="alert">';
                        echo '<span aria-hidden="true">&times;</span>';
                        echo '</button>';
                        echo '</div>';

                        $uploadOk = 0;
                    }
                    
                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                        echo 'Your Image Was Not Uploaded Due to an Error.';
                        echo '<button type="button" class="close" data-dismiss="alert">';
                        echo '<span aria-hidden="true">&times;</span>';
                        echo '</button>';
                        echo '</div>';
                    } else {
                        if (move_uploaded_file($_FILES["image_input"]["tmp_name"], $target_file)) {
                            
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
                                $stmt = $conn->prepare("UPDATE config SET logo_width = :logo_width, logo_height = :logo_height, logo_enabled = 'true'");
                                
                                $stmt->bindParam(':logo_width', $logo_width);
                                $stmt->bindParam(':logo_height', $logo_height);
                    
                                $logo_width = $_POST['image_width'];
                                $logo_height = $_POST['image_height'];
                    
                                $stmt->execute();
        
                                express_log("Change Logo", "The logo has been changed.");
                    
                                header("Location: settings.php?message=logo_success");
        
                            } catch(PDOException $e) {
                                header("Location: settings.php?message=logo_failure");
                            }
                    
                            $conn = null;

                        } else {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                            echo 'There Was an Error Uploading Your Image.';
                            echo '<button type="button" class="close" data-dismiss="alert">';
                            echo '<span aria-hidden="true">&times;</span>';
                            echo '</button>';
                            echo '</div>';
                        }
                    }

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

        <h2>Change Logo<a href="settings.php" class="btn btn-danger btn-round" style="margin-left: 20px; float: right;">Back</a></h2>
        <p>Change the store logo that appears at the top left corner of every page.</p>

        <br />

        <form method="POST" enctype="multipart/form-data" action="change-logo.php">

            <div class="form-group">
                <label for="image_input">Logo File (.png Only)</label>
                <input type="file" class="form-control-file" id="image_input" name="image_input">
            </div>

            <div class="row">
                <div class="col">
                    <label for="image_width">Image Width (30 - 50)</label>
                    <input type="text" class="form-control" id="image_width" name="image_width" placeholder="Enter Image Width (30 - 50)">
                </div>
                <div class="col">
                    <label for="image_height">Image Height (30 - 50)</label>
                    <input type="text" class="form-control" id="image_height" name="image_height" placeholder="Enter Image Height (30 - 50)">
                </div>
            </div>

            <br />

            <button type="submit" class="btn btn-<?php echo $theme_color; ?>">Save Logo</button>

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