<?php

include_once("database.php");

$data = query("SELECT * FROM config WHERE id = 1");
$business_name = $data[0]['business_name'];
$theme_color = $data[0]['theme_color'];
$logo_enabled = $data[0]['logo_enabled'];
$logo_width = $data[0]['logo_width'];
$logo_height = $data[0]['logo_height'];

if(!isset($_COOKIE['cart_number'])) {
  $cart_number = 0;
} else {
  $cart_number = $_COOKIE['cart_number'];
}

$page_name = basename($_SERVER['PHP_SELF']);

?>

<style>

@media (max-width: 576px) {
  .navbar-brand {
      line-height: 15px;
      font-size: 15px;
      padding-top: 5px;
      padding-bottom: 5px;
  }

  .navbar {
      padding-top: 5px;
      padding-bottom: 5px;
  }
}

</style>

<nav class="navbar navbar-expand-sm navbar-dark bg-<?php echo $theme_color; ?>" data-toggle="affix">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar" style="padding-left: 5px;">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="mx-auto d-sm-flex d-block flex-sm-nowrap">
        <?php
          if ($logo_enabled == "true") {
            echo '<a class="navbar-brand" href="index.php">';
            echo '<img src="logo.png" width="' . $logo_width . '" height="' . $logo_height . '" alt="' . $business_name . ' Logo">' . $business_name;
            echo '</a>';
          } else {
            echo '<a class="navbar-brand" href="index.php">' . $business_name . '</a>';
          }
        ?>

        <div class="collapse navbar-collapse text-center" id="mainNavbar">
            <ul class="navbar-nav">
                <li class="nav-item <?php if ($page_name == "menu.php" || $page_name == "item.php") { echo "active"; } ?>">
                  <a class="nav-link" href="menu.php">Menu</a>
                </li>
                <li class="nav-item <?php if ($page_name == "tutorial.php") { echo "active"; } ?>">
                  <a class="nav-link" href="tutorial.php">How it Works</a>
                </li>
                <li class="nav-item <?php if ($page_name == "hours.php") { echo "active"; } ?>">
                  <a class="nav-link" href="hours.php">Store Hours</a>
                </li>
            </ul>
        </div>
    </div>
    <a href="cart.php"><button class="btn btn-dark my-2 my-sm-0" type="submit">Cart <span class="badge badge-pill badge-light" id="cartNumber"><?php echo $cart_number; ?></span></button></a>
</nav>