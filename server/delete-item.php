<?php

include_once("functions.php");
verify();

include_once("database.php");

if (isset($_GET['id'])) {

    $item_id = $_GET['id'];

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
        if (isset(query("SELECT item_name FROM menu WHERE id = " . $item_id)[0]['item_name'])) {
            $stmt = $conn->prepare("UPDATE menu SET for_sale = 'no' WHERE id = " . $item_id);
        } else {
            $stmt = $conn->prepare("DELETE FROM menu WHERE id = " . $item_id);
        }

        $stmt->execute();

        express_log("Remove Item", "The item '" . $item_id . "' has been removed.");

        header("Location: edit-menu.php?message=delete_success");
    
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        return "Error";
    }

    $conn = null;

} else {
    header("Location: edit-menu.php?message=delete_failure");
}

?>