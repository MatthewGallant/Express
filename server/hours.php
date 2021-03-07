<?php

include_once("database.php");

$data = query("SELECT business_name, business_slogan FROM config WHERE id = 1");
$business_name = $data[0]['business_name'];
$business_slogan = $data[0]['business_slogan'];
$theme_color = $data[0]['theme_color'];

$hours = query("SELECT * FROM hours WHERE id = 1");

?>

<!doctype html>
<html lang="en">
  <head>
  	<?php include_once("head.php"); ?>
  </head>
  <body>
	<?php include_once("navbar.php"); ?>
	
	<div class="container">

        <br />

        <div align="center">
            <h2>Store Hours</h2>
        </div>

        <br />

        <div class="table-responsive rounded">
            <table class="table table-striped table-hover table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Monday</th>
                        <th scope="col">Tuesday</th>
                        <th scope="col">Wednesday</th>
                        <th scope="col">Thursday</th>
                        <th scope="col">Friday</th>
                        <th scope="col">Saturday</th>
                        <th scope="col">Sunday</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td scope="row">Opening Time</td>
                        <td>
                            <?php 

                                if ($hours[0]['monday_closed'] == "Yes") {
                                    echo "Closed";
                                } else {
                                    echo strtoupper(date('h:i a', strtotime($hours[0]['monday_open']))); 
                                }

                            ?>
                        </td>
                        <td>
                            <?php 

                                if ($hours[0]['tuesday_closed'] == "Yes") {
                                    echo "Closed";
                                } else {
                                    echo strtoupper(date('h:i a', strtotime($hours[0]['tuesday_open']))); 
                                }

                            ?>
                        </td>
                        <td>
                            <?php 

                                if ($hours[0]['wednesday_closed'] == "Yes") {
                                    echo "Closed";
                                } else {
                                    echo strtoupper(date('h:i a', strtotime($hours[0]['wednesday_open']))); 
                                }

                            ?>
                        </td>
                        <td>
                            <?php 

                                if ($hours[0]['thursday_closed'] == "Yes") {
                                    echo "Closed";
                                } else {
                                    echo strtoupper(date('h:i a', strtotime($hours[0]['thursday_open']))); 
                                }

                            ?>
                        </td>
                        <td>
                            <?php 

                                if ($hours[0]['friday_closed'] == "Yes") {
                                    echo "Closed";
                                } else {
                                    echo strtoupper(date('h:i a', strtotime($hours[0]['friday_open']))); 
                                }

                            ?>
                        </td>
                        <td>
                            <?php 

                                if ($hours[0]['saturday_closed'] == "Yes") {
                                    echo "Closed";
                                } else {
                                    echo strtoupper(date('h:i a', strtotime($hours[0]['saturday_open']))); 
                                }

                            ?>
                        </td>
                        <td>
                            <?php 

                                if ($hours[0]['sunday_closed'] == "Yes") {
                                    echo "Closed";
                                } else {
                                    echo strtoupper(date('h:i a', strtotime($hours[0]['sunday_open']))); 
                                }

                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">Closing Time</td>
                        <td>
                            <?php 

                                if ($hours[0]['monday_closed'] == "Yes") {
                                    echo "Closed";
                                } else {
                                    echo strtoupper(date('h:i a', strtotime($hours[0]['monday_close']))); 
                                }

                            ?>
                        </td>
                        <td>
                            <?php 

                                if ($hours[0]['tuesday_closed'] == "Yes") {
                                    echo "Closed";
                                } else {
                                    echo strtoupper(date('h:i a', strtotime($hours[0]['tuesday_close']))); 
                                }

                            ?>
                        </td>
                        <td>
                            <?php 

                                if ($hours[0]['wednesday_closed'] == "Yes") {
                                    echo "Closed";
                                } else {
                                    echo strtoupper(date('h:i a', strtotime($hours[0]['wednesday_close']))); 
                                }

                            ?>
                        </td>
                        <td>
                            <?php 

                                if ($hours[0]['thursday_closed'] == "Yes") {
                                    echo "Closed";
                                } else {
                                    echo strtoupper(date('h:i a', strtotime($hours[0]['thursday_close']))); 
                                }

                            ?>
                        </td>
                        <td>
                            <?php 

                                if ($hours[0]['friday_closed'] == "Yes") {
                                    echo "Closed";
                                } else {
                                    echo strtoupper(date('h:i a', strtotime($hours[0]['friday_close']))); 
                                }

                            ?>
                        </td>
                        <td>
                            <?php 

                                if ($hours[0]['saturday_closed'] == "Yes") {
                                    echo "Closed";
                                } else {
                                    echo strtoupper(date('h:i a', strtotime($hours[0]['saturday_close']))); 
                                }

                            ?>
                        </td>
                        <td>
                            <?php 

                                if ($hours[0]['sunday_closed'] == "Yes") {
                                    echo "Closed";
                                } else {
                                    echo strtoupper(date('h:i a', strtotime($hours[0]['sunday_close']))); 
                                }

                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
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