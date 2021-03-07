<?php

include_once("functions.php");
verify();

include_once("database.php");

$data = query("SELECT * FROM config WHERE id = 1");
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

            if (isset($_POST['monday_open']) && isset($_POST['tuesday_open']) && isset($_POST['wednesday_open']) && isset($_POST['thursday_open']) && isset($_POST['friday_open']) && isset($_POST['saturday_open']) && isset($_POST['sunday_open']) && isset($_POST['monday_open_choice']) && isset($_POST['tuesday_open_choice']) && isset($_POST['wednesday_open_choice']) && isset($_POST['thursday_open_choice']) && isset($_POST['friday_open_choice']) && isset($_POST['saturday_open_choice']) && isset($_POST['sunday_open_choice']) && isset($_POST['monday_close']) && isset($_POST['tuesday_close']) && isset($_POST['wednesday_close']) && isset($_POST['thursday_close']) && isset($_POST['friday_close']) && isset($_POST['saturday_close']) && isset($_POST['sunday_close']) && isset($_POST['monday_close_choice']) && isset($_POST['tuesday_close_choice']) && isset($_POST['wednesday_close_choice']) && isset($_POST['thursday_close_choice']) && isset($_POST['friday_close_choice']) && isset($_POST['saturday_close_choice']) && isset($_POST['sunday_close_choice']) && isset($_POST['monday_closed']) && isset($_POST['tuesday_closed']) && isset($_POST['wednesday_closed']) && isset($_POST['thursday_closed']) && isset($_POST['friday_closed']) && isset($_POST['saturday_closed']) && isset($_POST['sunday_closed'])) {
                if ($_POST['monday_open'] != "" && $_POST['tuesday_open'] != "" && $_POST['wednesday_open'] != "" && $_POST['thursday_open'] != "" && $_POST['friday_open'] != "" && $_POST['saturday_open'] != "" && $_POST['sunday_open'] != "" && $_POST['monday_open_choice'] != "" && $_POST['tuesday_open_choice'] != "" && $_POST['wednesday_open_choice'] != "" && $_POST['thursday_open_choice'] != "" && $_POST['friday_open_choice'] != "" && $_POST['saturday_open_choice'] != "" && $_POST['sunday_open_choice'] != "" && $_POST['monday_close'] != "" && $_POST['tuesday_close'] != "" && $_POST['wednesday_close'] != "" && $_POST['thursday_close'] != "" && $_POST['friday_close'] != "" && $_POST['saturday_close'] != "" && $_POST['sunday_close'] != "" && $_POST['monday_close_choice'] != "" && $_POST['tuesday_close_choice'] != "" && $_POST['wednesday_close_choice'] != "" && $_POST['thursday_close_choice'] != "" && $_POST['friday_close_choice'] != "" && $_POST['saturday_close_choice'] != "" && $_POST['sunday_close_choice'] != "" && $_POST['monday_closed'] != "" && $_POST['tuesday_closed'] != "" && $_POST['wednesday_closed'] != "" && $_POST['thursday_closed'] != "" && $_POST['friday_closed'] != "" && $_POST['saturday_closed'] != "" && $_POST['sunday_closed'] != "") {
                    
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
                        $stmt = $conn->prepare("UPDATE hours SET monday_open = :monday_open, tuesday_open = :tuesday_open, wednesday_open = :wednesday_open, thursday_open = :thursday_open, friday_open = :friday_open, saturday_open = :saturday_open, sunday_open = :sunday_open, monday_close = :monday_close, tuesday_close = :tuesday_close, wednesday_close = :wednesday_close, thursday_close = :thursday_close, friday_close = :friday_close, saturday_close = :saturday_close, sunday_close = :sunday_close, monday_closed = :monday_closed, tuesday_closed = :tuesday_closed, wednesday_closed = :wednesday_closed, thursday_closed = :thursday_closed, friday_closed = :friday_closed, saturday_closed = :saturday_closed, sunday_closed = :sunday_closed WHERE id = 1");
                        
                        $stmt->bindParam(':monday_open', $monday_open);
                        $stmt->bindParam(':tuesday_open', $tuesday_open);
                        $stmt->bindParam(':wednesday_open', $wednesday_open);
                        $stmt->bindParam(':thursday_open', $thursday_open);
                        $stmt->bindParam(':friday_open', $friday_open);
                        $stmt->bindParam(':saturday_open', $saturday_open);
                        $stmt->bindParam(':sunday_open', $sunday_open);
                        $stmt->bindParam(':monday_close', $monday_close);
                        $stmt->bindParam(':tuesday_close', $tuesday_close);
                        $stmt->bindParam(':wednesday_close', $wednesday_close);
                        $stmt->bindParam(':thursday_close', $thursday_close);
                        $stmt->bindParam(':friday_close', $friday_close);
                        $stmt->bindParam(':saturday_close', $saturday_close);
                        $stmt->bindParam(':sunday_close', $sunday_close);
                        $stmt->bindParam(':monday_closed', $monday_closed);
                        $stmt->bindParam(':tuesday_closed', $tuesday_closed);
                        $stmt->bindParam(':wednesday_closed', $wednesday_closed);
                        $stmt->bindParam(':thursday_closed', $thursday_closed);
                        $stmt->bindParam(':friday_closed', $friday_closed);
                        $stmt->bindParam(':saturday_closed', $saturday_closed);
                        $stmt->bindParam(':sunday_closed', $sunday_closed);
                
                        $monday_open = date('H:i', strtotime($_POST['monday_open'] . " " . $_POST['monday_open_choice']));
                        $tuesday_open = date('H:i', strtotime($_POST['tuesday_open'] . " " . $_POST['tuesday_open_choice']));
                        $wednesday_open = date('H:i', strtotime($_POST['wednesday_open'] . " " . $_POST['wednesday_open_choice']));
                        $thursday_open = date('H:i', strtotime($_POST['thursday_open'] . " " . $_POST['thursday_open_choice']));
                        $friday_open = date('H:i', strtotime($_POST['friday_open'] . " " . $_POST['friday_open_choice']));
                        $saturday_open = date('H:i', strtotime($_POST['saturday_open'] . " " . $_POST['saturday_open_choice']));
                        $sunday_open = date('H:i', strtotime($_POST['sunday_open'] . " " . $_POST['sunday_open_choice']));
                        $monday_close = date('H:i', strtotime($_POST['monday_close'] . " " . $_POST['monday_close_choice']));
                        $tuesday_close = date('H:i', strtotime($_POST['tuesday_close'] . " " . $_POST['tuesday_close_choice']));
                        $wednesday_close = date('H:i', strtotime($_POST['wednesday_close'] . " " . $_POST['wednesday_close_choice']));
                        $thursday_close = date('H:i', strtotime($_POST['thursday_close'] . " " . $_POST['thursday_close_choice']));
                        $friday_close = date('H:i', strtotime($_POST['friday_close'] . " " . $_POST['friday_close_choice']));
                        $saturday_close = date('H:i', strtotime($_POST['saturday_close'] . " " . $_POST['saturday_close_choice']));
                        $sunday_close = date('H:i', strtotime($_POST['sunday_close'] . " " . $_POST['sunday_close_choice']));
                        $monday_closed = $_POST['monday_closed'];
                        $tuesday_closed = $_POST['tuesday_closed'];
                        $wednesday_closed = $_POST['wednesday_closed'];
                        $thursday_closed = $_POST['thursday_closed'];
                        $friday_closed = $_POST['friday_closed'];
                        $saturday_closed = $_POST['saturday_closed'];
                        $sunday_closed = $_POST['sunday_closed'];

                        $stmt->execute();

                        express_log("Edit Hours", "The store hours have been changed.");

                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                        echo 'The Business Hours Have Been Updated Successfully.';
                        echo '<button type="button" class="close" data-dismiss="alert">';
                        echo '<span aria-hidden="true">&times;</span>';
                        echo '</button>';
                        echo '</div>';
                    
                    } catch(PDOException $e) {
                        echo "Error: " . $e->getMessage();
                        return "Error";
                    }
                
                    $conn = null;

                } else {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo 'At Least One Field Was Not Entered. Please Fill in The Field and Try Again.';
                    echo '<button type="button" class="close" data-dismiss="alert">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo '</div>';
                }
            }

            $hours = query("SELECT * FROM hours WHERE id = 1");

        ?>

        <h2>Edit Ordering Hours</h2>

        <br />

        <form action="edit-hours.php" method="POST">
            <div class="row">

                <?php

                    $monday_open = strtoupper(date('h:i-a', strtotime($hours[0]['monday_open'])));
                    $monday_open_time = explode("-", $monday_open);

                ?>

                <div class="col">
                    <label for="monday_open">Monday Open Time Hour</label>
                    <input type="text" class="form-control" id="monday_open" name="monday_open" placeholder="Enter Monday Opening Time" value="<?php echo $monday_open_time[0]; ?>">
                </div>
                <div class="col">
                    <label for="monday_open_choice">Monday Open Time AM/PM</label>
                    <select class="form-control" id="monday_open_choice" name="monday_open_choice">

                        <?php 
                        
                            if ($monday_open_time[1] == "AM") {
                                echo "<option selected='selected'>AM</option>";
                                echo "<option>PM</option>";
                            } else {
                                echo "<option>AM</option>";
                                echo "<option selected='selected'>PM</option>";
                            }
                        
                        ?>

                    </select>
                </div>
                <div class="col">
                    <label for="monday_closed">Monday Closed</label>
                    <select class="form-control" id="monday_closed" name="monday_closed">

                        <?php 
                        
                            if ($hours[0]['monday_closed'] == "No") {
                                echo "<option selected='selected'>No</option>";
                                echo "<option>Yes</option>";
                            } else {
                                echo "<option>No</option>";
                                echo "<option selected='selected'>Yes</option>";
                            }
                        
                        ?>

                    </select>
                </div>
            </div>

            <br />

            <div class="row">

                <?php

                    $monday_close = strtoupper(date('h:i-a', strtotime($hours[0]['monday_close'])));
                    $monday_close_time = explode("-", $monday_close);

                ?>

                <div class="col-sm-4">
                    <label for="monday_close">Monday Close Time Hour</label>
                    <input type="text" class="form-control" id="monday_close" name="monday_close" placeholder="Enter Monday Closing Time" value="<?php echo $monday_close_time[0]; ?>">
                </div>
                <div class="col-sm-4">
                    <label for="monday_close_choice">Monday Close Time AM/PM</label>
                    <select class="form-control" id="monday_close_choice" name="monday_close_choice">

                    <?php 
                        
                        if ($monday_close_time[1] == "AM") {
                            echo "<option selected='selected'>AM</option>";
                            echo "<option>PM</option>";
                        } else {
                            echo "<option>AM</option>";
                            echo "<option selected='selected'>PM</option>";
                        }
                    
                    ?>

                    </select>
                </div>
            </div>

            <br />

            <div class="row">

                <?php

                    $tuesday_open = strtoupper(date('h:i-a', strtotime($hours[0]['tuesday_open'])));
                    $tuesday_open_time = explode("-", $tuesday_open);

                ?>

                <div class="col">
                    <label for="tuesday_open">Tuesday Open Time Hour</label>
                    <input type="text" class="form-control" id="tuesday_open" name="tuesday_open" placeholder="Enter Tuesday Opening Time" value="<?php echo $tuesday_open_time[0]; ?>">
                </div>
                <div class="col">
                    <label for="tuesday_open_choice">Tuesday Open Time AM/PM</label>
                    <select class="form-control" id="tuesday_open_choice" name="tuesday_open_choice">
                        
                        <?php 
                        
                            if ($tuesday_open_time[1] == "AM") {
                                echo "<option selected='selected'>AM</option>";
                                echo "<option>PM</option>";
                            } else {
                                echo "<option>AM</option>";
                                echo "<option selected='selected'>PM</option>";
                            }
                        
                        ?>

                    </select>
                </div>
                <div class="col">
                    <label for="tuesday_closed">Tuesday Closed</label>
                    <select class="form-control" id="tuesday_closed" name="tuesday_closed">

                        <?php 
                        
                            if ($hours[0]['tuesday_closed'] == "No") {
                                echo "<option selected='selected'>No</option>";
                                echo "<option>Yes</option>";
                            } else {
                                echo "<option>No</option>";
                                echo "<option selected='selected'>Yes</option>";
                            }
                        
                        ?>

                    </select>
                </div>
            </div>

            <br />

            <div class="row">

                <?php

                    $tuesday_close = strtoupper(date('h:i-a', strtotime($hours[0]['tuesday_close'])));
                    $tuesday_close_time = explode("-", $tuesday_close);

                ?>

                <div class="col-sm-4">
                    <label for="tuesday_close">Tuesday Close Time Hour</label>
                    <input type="text" class="form-control" id="tuesday_close" name="tuesday_close" placeholder="Enter Tuesday Closing Time" value="<?php echo $tuesday_close_time[0]; ?>">
                </div>
                <div class="col-sm-4">
                    <label for="tuesday_close_choice">Tuesday Close Time AM/PM</label>
                    <select class="form-control" id="tuesday_close_choice" name="tuesday_close_choice">
                    
                    <?php 
                        
                        if ($tuesday_close_time[1] == "AM") {
                            echo "<option selected='selected'>AM</option>";
                            echo "<option>PM</option>";
                        } else {
                            echo "<option>AM</option>";
                            echo "<option selected='selected'>PM</option>";
                        }
                    
                    ?>

                    </select>
                </div>
            </div>

            <br />

            <div class="row">

                <?php

                    $wednesday_open = strtoupper(date('h:i-a', strtotime($hours[0]['wednesday_open'])));
                    $wednesday_open_time = explode("-", $wednesday_open);

                ?>

                <div class="col">
                    <label for="wednesday_open">Wednesday Open Time Hour</label>
                    <input type="text" class="form-control" id="wednesday_open" name="wednesday_open" placeholder="Enter Wednesday Opening Time" value="<?php echo $wednesday_open_time[0]; ?>">
                </div>
                <div class="col">
                    <label for="wednesday_open_choice">Wednesday Open Time AM/PM</label>
                    <select class="form-control" id="wednesday_open_choice" name="wednesday_open_choice">
                    
                    <?php 
                        
                        if ($wednesday_open_time[1] == "AM") {
                            echo "<option selected='selected'>AM</option>";
                            echo "<option>PM</option>";
                        } else {
                            echo "<option>AM</option>";
                            echo "<option selected='selected'>PM</option>";
                        }
                    
                    ?>

                    </select>
                </div>
                <div class="col">
                    <label for="wednesday_closed">Wednesday Closed</label>
                    <select class="form-control" id="wednesday_closed" name="wednesday_closed">

                        <?php 
                        
                            if ($hours[0]['wednesday_closed'] == "No") {
                                echo "<option selected='selected'>No</option>";
                                echo "<option>Yes</option>";
                            } else {
                                echo "<option>No</option>";
                                echo "<option selected='selected'>Yes</option>";
                            }
                        
                        ?>

                    </select>
                </div>
            </div>

            <br />

            <div class="row">

                <?php

                    $wednesday_close = strtoupper(date('h:i-a', strtotime($hours[0]['wednesday_close'])));
                    $wednesday_close_time = explode("-", $wednesday_close);

                ?>

                <div class="col-sm-4">
                    <label for="wednesday_close">Wednesday Close Time Hour</label>
                    <input type="text" class="form-control" id="wednesday_close" name="wednesday_close" placeholder="Enter Wednesday Closing Time" value="<?php echo $wednesday_close_time[0]; ?>">
                </div>
                <div class="col-sm-4">
                    <label for="wednesday_close_choice">Wednesday Close Time AM/PM</label>
                    <select class="form-control" id="wednesday_close_choice" name="wednesday_close_choice">
                    
                    <?php 
                        
                        if ($wednesday_close_time[1] == "AM") {
                            echo "<option selected='selected'>AM</option>";
                            echo "<option>PM</option>";
                        } else {
                            echo "<option>AM</option>";
                            echo "<option selected='selected'>PM</option>";
                        }
                    
                    ?>

                    </select>
                </div>
            </div>

            <br />

            <div class="row">

                <?php

                    $thursday_open = strtoupper(date('h:i-a', strtotime($hours[0]['thursday_open'])));
                    $thursday_open_time = explode("-", $thursday_open);

                ?>

                <div class="col">
                    <label for="thursday_open">Thursday Open Time Hour</label>
                    <input type="text" class="form-control" id="thursday_open" name="thursday_open" placeholder="Enter Thursday Opening Time" value="<?php echo $thursday_open_time[0]; ?>">
                </div>
                <div class="col">
                    <label for="thursday_open_choice">Thursday Open Time AM/PM</label>
                    <select class="form-control" id="thursday_open_choice" name="thursday_open_choice">
                    
                    <?php 
                        
                        if ($thursday_open_time[1] == "AM") {
                            echo "<option selected='selected'>AM</option>";
                            echo "<option>PM</option>";
                        } else {
                            echo "<option>AM</option>";
                            echo "<option selected='selected'>PM</option>";
                        }
                    
                    ?>

                    </select>
                </div>
                <div class="col">
                    <label for="thursday_closed">Thursday Closed</label>
                    <select class="form-control" id="thursday_closed" name="thursday_closed">

                        <?php 
                        
                            if ($hours[0]['thursday_closed'] == "No") {
                                echo "<option selected='selected'>No</option>";
                                echo "<option>Yes</option>";
                            } else {
                                echo "<option>No</option>";
                                echo "<option selected='selected'>Yes</option>";
                            }
                        
                        ?>

                    </select>
                </div>
            </div>

            <br />

            <div class="row">

                <?php

                    $thursday_close = strtoupper(date('h:i-a', strtotime($hours[0]['thursday_close'])));
                    $thursday_close_time = explode("-", $thursday_close);

                ?>

                <div class="col-sm-4">
                    <label for="thursday_close">Thursday Close Time Hour</label>
                    <input type="text" class="form-control" id="thursday_close" name="thursday_close" placeholder="Enter Thursday Closing Time" value="<?php echo $thursday_close_time[0]; ?>">
                </div>
                <div class="col-sm-4">
                    <label for="thursday_close_choice">Thursday Close Time AM/PM</label>
                    <select class="form-control" id="thursday_close_choice" name="thursday_close_choice">
                    
                    <?php 
                        
                        if ($thursday_close_time[1] == "AM") {
                            echo "<option selected='selected'>AM</option>";
                            echo "<option>PM</option>";
                        } else {
                            echo "<option>AM</option>";
                            echo "<option selected='selected'>PM</option>";
                        }
                    
                    ?>

                    </select>
                </div>
            </div>

            <br />

            <div class="row">

                <?php

                    $friday_open = strtoupper(date('h:i-a', strtotime($hours[0]['friday_open'])));
                    $friday_open_time = explode("-", $friday_open);

                ?>

                <div class="col">
                    <label for="friday_open">Friday Open Time Hour</label>
                    <input type="text" class="form-control" id="friday_open" name="friday_open" placeholder="Enter Friday Opening Time" value="<?php echo $friday_open_time[0]; ?>">
                </div>
                <div class="col">
                    <label for="friday_open_choice">Friday Open Time AM/PM</label>
                    <select class="form-control" id="friday_open_choice" name="friday_open_choice">
                    
                    <?php 
                        
                        if ($friday_open_time[1] == "AM") {
                            echo "<option selected='selected'>AM</option>";
                            echo "<option>PM</option>";
                        } else {
                            echo "<option>AM</option>";
                            echo "<option selected='selected'>PM</option>";
                        }
                    
                    ?>

                    </select>
                </div>
                <div class="col">
                    <label for="friday_closed">Friday Closed</label>
                    <select class="form-control" id="friday_closed" name="friday_closed">

                        <?php 
                        
                            if ($hours[0]['friday_closed'] == "No") {
                                echo "<option selected='selected'>No</option>";
                                echo "<option>Yes</option>";
                            } else {
                                echo "<option>No</option>";
                                echo "<option selected='selected'>Yes</option>";
                            }
                        
                        ?>

                    </select>
                </div>
            </div>

            <br />

            <div class="row">

                <?php

                    $friday_close = strtoupper(date('h:i-a', strtotime($hours[0]['friday_close'])));
                    $friday_close_time = explode("-", $friday_close);

                ?>

                <div class="col-sm-4">
                    <label for="friday_close">Friday Close Time Hour</label>
                    <input type="text" class="form-control" id="friday_close" name="friday_close" placeholder="Enter Friday Closing Time" value="<?php echo $friday_close_time[0]; ?>">
                </div>
                <div class="col-sm-4">
                    <label for="friday_close_choice">Friday Close Time AM/PM</label>
                    <select class="form-control" id="friday_close_choice" name="friday_close_choice">
                    
                    <?php 
                        
                        if ($friday_close_time[1] == "AM") {
                            echo "<option selected='selected'>AM</option>";
                            echo "<option>PM</option>";
                        } else {
                            echo "<option>AM</option>";
                            echo "<option selected='selected'>PM</option>";
                        }
                    
                    ?>

                    </select>
                </div>
            </div>

            <br />

            <div class="row">

                <?php

                    $saturday_open = strtoupper(date('h:i-a', strtotime($hours[0]['saturday_open'])));
                    $saturday_open_time = explode("-", $saturday_open);

                ?>

                <div class="col">
                    <label for="saturday_open">Saturday Open Time Hour</label>
                    <input type="text" class="form-control" id="saturday_open" name="saturday_open" placeholder="Enter Saturday Opening Time" value="<?php echo $saturday_open_time[0]; ?>">
                </div>
                <div class="col">
                    <label for="saturday_open_choice">Saturday Open Time AM/PM</label>
                    <select class="form-control" id="saturday_open_choice" name="saturday_open_choice">
                    
                    <?php 
                        
                        if ($saturday_open_time[1] == "AM") {
                            echo "<option selected='selected'>AM</option>";
                            echo "<option>PM</option>";
                        } else {
                            echo "<option>AM</option>";
                            echo "<option selected='selected'>PM</option>";
                        }
                    
                    ?>

                    </select>
                </div>
                <div class="col">
                    <label for="saturday_closed">Saturday Closed</label>
                    <select class="form-control" id="saturday_closed" name="saturday_closed">

                        <?php 
                        
                            if ($hours[0]['saturday_closed'] == "No") {
                                echo "<option selected='selected'>No</option>";
                                echo "<option>Yes</option>";
                            } else {
                                echo "<option>No</option>";
                                echo "<option selected='selected'>Yes</option>";
                            }
                        
                        ?>

                    </select>
                </div>
            </div>

            <br />

            <div class="row">

                <?php

                    $saturday_close = strtoupper(date('h:i-a', strtotime($hours[0]['saturday_close'])));
                    $saturday_close_time = explode("-", $saturday_close);

                ?>

                <div class="col-sm-4">
                    <label for="saturday_close">Saturday Close Time Hour</label>
                    <input type="text" class="form-control" id="saturday_close" name="saturday_close" placeholder="Enter Saturday Closing Time" value="<?php echo $saturday_close_time[0]; ?>">
                </div>
                <div class="col-sm-4">
                    <label for="saturday_close_choice">Saturday Close Time AM/PM</label>
                    <select class="form-control" id="saturday_close_choice" name="saturday_close_choice">
                    
                    <?php 
                        
                        if ($saturday_close_time[1] == "AM") {
                            echo "<option selected='selected'>AM</option>";
                            echo "<option>PM</option>";
                        } else {
                            echo "<option>AM</option>";
                            echo "<option selected='selected'>PM</option>";
                        }
                    
                    ?>

                    </select>
                </div>
            </div>

            <br />

            <div class="row">

                <?php

                    $sunday_open = strtoupper(date('h:i-a', strtotime($hours[0]['sunday_open'])));
                    $sunday_open_time = explode("-", $sunday_open);

                ?>

                <div class="col">
                    <label for="sunday_open">Sunday Open Time Hour</label>
                    <input type="text" class="form-control" id="sunday_open" name="sunday_open" placeholder="Enter Sunday Opening Time" value="<?php echo $sunday_open_time[0]; ?>">
                </div>
                <div class="col">
                    <label for="sunday_open_choice">Sunday Open Time AM/PM</label>
                    <select class="form-control" id="sunday_open_choice" name="sunday_open_choice">
                    
                    <?php 
                        
                        if ($sunday_open_time[1] == "AM") {
                            echo "<option selected='selected'>AM</option>";
                            echo "<option>PM</option>";
                        } else {
                            echo "<option>AM</option>";
                            echo "<option selected='selected'>PM</option>";
                        }
                    
                    ?>

                    </select>
                </div>
                <div class="col">
                    <label for="sunday_closed">Sunday Closed</label>
                    <select class="form-control" id="sunday_closed" name="sunday_closed">

                        <?php 
                        
                            if ($hours[0]['sunday_closed'] == "No") {
                                echo "<option selected='selected'>No</option>";
                                echo "<option>Yes</option>";
                            } else {
                                echo "<option>No</option>";
                                echo "<option selected='selected'>Yes</option>";
                            }
                        
                        ?>

                    </select>
                </div>
            </div>

            <br />

            <div class="row">

                <?php

                    $sunday_close = strtoupper(date('h:i-a', strtotime($hours[0]['sunday_close'])));
                    $sunday_close_time = explode("-", $sunday_close);

                ?>

                <div class="col-sm-4">
                    <label for="sunday_close">Sunday Close Time Hour</label>
                    <input type="text" class="form-control" id="sunday_close" name="sunday_close" placeholder="Enter Sunday Closing Time" value="<?php echo $sunday_close_time[0]; ?>">
                </div>
                <div class="col-sm-4">
                    <label for="sunday_close_choice">Sunday Close Time AM/PM</label>
                    <select class="form-control" id="sunday_close_choice" name="sunday_close_choice">
                    
                    <?php 
                        
                        if ($sunday_close_time[1] == "AM") {
                            echo "<option selected='selected'>AM</option>";
                            echo "<option>PM</option>";
                        } else {
                            echo "<option>AM</option>";
                            echo "<option selected='selected'>PM</option>";
                        }
                    
                    ?>

                    </select>
                </div>
            </div>

            <br />

            <div align="center"><button type="submit" class="btn btn-<?php echo $theme_color; ?>">Save Hours</button></div>
        </form>
			   
    </div>

	<?php include_once("footer.php"); ?>
	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>