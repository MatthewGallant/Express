<?php

include_once("functions.php");
verify();

include_once("database.php");

$data = query("SELECT business_name, business_slogan FROM config WHERE id = 1");
$business_name = $data[0]['business_name'];
$business_slogan = $data[0]['business_slogan'];
$theme_color = $data[0]['theme_color'];

$page = $_GET['page'];

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

        <h2>Express System Log<a href="settings.php" class="btn btn-danger btn-round" style="margin-left: 20px; float: right;">Back</a></h2>

        <br />

        <div class="table-responsive rounded">
            <table class="table table-striped table-hover table-bordered">
                <?php

                $page_range_upper = $page * 10;
                $page_range_lower = $page_range_upper - 9;

                $log = query("SELECT * FROM log WHERE id BETWEEN " . $page_range_lower . " AND " . $page_range_upper);

                echo "<thead class='thead-dark'>";
                echo "<tr>";
                echo "<th scope='col'>ID</th>";
                echo "<th scope='col'>Name</th>";
                echo "<th scope='col'>Information</th>";
                echo "<th scope='col'>User</th>";
                echo "<th scope='col'>Time Recorded</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                foreach ($log as $entry) {
                    echo "<tr>";
                    echo "<td>" . $entry['id'] . "</td>";
                    echo "<td><b>" . $entry['name'] . "</b></td>";
                    echo "<td>" . $entry['information'] . "</td>";
                    echo "<td>" . $entry['user'] . "</td>";
                    echo "<td>" . $entry['time'] . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";

                $amount_of_rows = query("SELECT COUNT(*) FROM log")[0]['COUNT(*)'];

                ?>
            </table>
        </div>

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <!-- <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
                </li> -->
                <?php

                for ($i = $amount_of_rows / 10; $i > 0 ; $i--) {
                    echo '<li class="page-item"><a class="page-link" href="log.php?page=' . (round($i, 0, PHP_ROUND_HALF_UP) + 1) . '">' . (round($i, 0, PHP_ROUND_HALF_UP) + 1) . '</a></li>';
                }

                ?>
                <!-- <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
                </li> -->
            </ul>
        </nav>
			   
    </div>

	<?php include_once("footer.php"); ?>
	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>