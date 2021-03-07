<?php

include_once("functions.php");
verify_employee();

include_once("database.php");

$data = query("SELECT * FROM config WHERE id = 1");
$business_name = $data[0]['business_name'];
$theme_color = $data[0]['theme_color'];
$logo_enabled = $data[0]['logo_enabled'];
$logo_width = $data[0]['logo_width'];
$logo_height = $data[0]['logo_height'];

$page_name = basename($_SERVER['PHP_SELF']);

?>

<style>

nav div span{
  list-style: none;
  margin: 0 20px;
  padding: 0;
  display: flex;
  justify-content: space-around;
}

</style>

<nav class="navbar navbar-expand navbar-dark bg-<?php echo $theme_color; ?>">
  <?php
    if ($logo_enabled == "true") {
      echo '<a class="navbar-brand" href="live.php">';
      echo '<img src="logo.png" width="' . $logo_width . '" height="' . $logo_height . '" alt="' . $business_name . ' Logo"> ' . $business_name . ' Hub';
      echo '</a>';
    } else {
      echo '<a class="navbar-brand" href="live.php">' . $business_name . ' Hub</a>';
    }
  ?>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarToggler">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item <?php if ($page_name == "live.php") { echo "active"; } ?>">
        <a class="nav-link" href="live.php">Orders</a>
      </li>
      <li class="nav-item <?php if ($page_name == "employee-completed.php") { echo "active"; } ?>">
        <a class="nav-link" href="employee-completed.php">History</a>
      </li>
    </ul>
    <span class="navbar-text">Logged in as <?php echo get_employee(); ?></span>
    <a href="employee-signout.php" class="btn btn-danger my-2 my-sm-0">Signout</a>
  </div>
</nav>