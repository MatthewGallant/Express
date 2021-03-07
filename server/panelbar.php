<?php

include_once("functions.php");
verify();

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
      echo '<a class="navbar-brand" href="manage.php">';
      echo '<img src="logo.png" width="' . $logo_width . '" height="' . $logo_height . '" alt="' . $business_name . ' Logo"> ' . $business_name . ' Hub Management';
      echo '</a>';
    } else {
      echo '<a class="navbar-brand" href="manage.php">' . $business_name . ' Hub Management</a>';
    }
  ?>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarToggler">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item dropdown <?php if ($page_name == "edit-menu.php" || $page_name == "edit-modifier-lists.php" || $page_name == "edit-categories.php" || $page_name == "edit-deleted-items.php" || $page_name == "add-item.php" || $page_name == "edit-item.php" || $page_name == "add-modifier-list.php" || $page_name == "edit-modifier-list.php" || $page_name == "add-category.php") { echo "active"; } ?>">
        <a class="nav-link dropdown-toggle" href="#" id="editDropdown" role="button" data-toggle="dropdown">
          Menu
        </a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="edit-menu.php">Edit Menu</a>
          <a class="dropdown-item" href="edit-modifier-lists.php">Edit Modifier Lists</a>
          <a class="dropdown-item" href="edit-categories.php">Edit Categories</a>
        </div>
      </li>
      <li class="nav-item dropdown <?php if ($page_name == "edit-hours.php" || $page_name == "view-completed.php" || $page_name == "manage-accounts.php" || $page_name == "manager-accounts.php" || $page_name == "settings.php" || $page_name == "add-account.php" || $page_name == "add-manager.php" || $page_name == "edit-manager.php" || $page_name == "reset-password.php" || $page_name == "change-theme.php" || $page_name == "change-logo.php" || $page_name == "change-wait-time.php" || $page_name == "change-slogan.php" || $page_name == "log.php") { echo "active";} ?>">
        <a class="nav-link dropdown-toggle" href="#" id="manageDropdown" role="button" data-toggle="dropdown">
          Manage
        </a>
        <div class="dropdown-menu">

          <?php
            if (get_admin_status() == "Yes") {
              echo '<a class="dropdown-item" href="edit-hours.php">Edit Ordering Hours</a>';
            }
          ?>

          <a class="dropdown-item" href="view-completed.php">View Completed Transactions</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="manage-accounts.php">Employee Accounts</a>

          <?php
            if (get_admin_status() == "Yes") {
              echo '<a class="dropdown-item" href="manager-accounts.php">Manager Accounts</a>';
            }
          ?>

          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="settings.php">Account Settings</a>
        </div>
      </li>
    </ul>
    <span class="navbar-text">Logged in as <?php echo get_manager(); ?></span>
    <a href="signout.php" class="btn btn-danger my-2 my-sm-0">Signout</a>
  </div>
</nav>