<?php

include_once("database.php");

$data = query("SELECT business_name, theme_color FROM config WHERE id = 1");
$business_name = $data[0]['business_name'];
$theme_color = $data[0]['theme_color'];

?>

<footer class="container-fluid footer">
    <nav class="navbar">
        <span class="text-muted">&copy; <?= date("Y"); ?> <?php echo $business_name; ?></span>
    </nav>
</footer>