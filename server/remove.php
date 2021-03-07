<?php

$item_id = $_GET['id'];
$order = $_COOKIE['order'];

$order_array = explode("/", $order);

foreach ($order_array as $key => $item) {
    $item_data = explode("|", $item);
    $item_db_id = $item_data[3];
    
    if ($item_db_id == $item_id) {
        unset($order_array[$key]);
    }
}

$new_order = implode("/", $order_array);
$new_number = $_COOKIE['cart_number'] - 1;

if(isset($_COOKIE['order'])) {
    setcookie('order', $new_order, time() + (86400), "/");
}

if(isset($_COOKIE['cart_number'])) {
    setcookie('cart_number', $new_number, time() + (86400), "/");
}

header("Location: cart.php");

?>