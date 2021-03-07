<?php

include_once('database.php');
include_once('functions.php');

$orders = json_encode(query("SELECT * FROM incoming_orders"));

echo $orders;

?>