<?php

include_once("functions.php");
verify();

include_once("database.php");

$data = query("SELECT business_name, business_slogan FROM config WHERE id = 1");
$business_name = $data[0]['business_name'];
$business_slogan = $data[0]['business_slogan'];
$theme_color = $data[0]['theme_color'];

page_access_log();

if (isset($_GET['id'])) {

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
        $stmt = $conn->prepare("UPDATE menu SET for_sale = 'yes' WHERE id = :id");
        
        $stmt->bindParam(':id', $id);

        $id = $_GET['id'];

        $stmt->execute();

        express_log("Add Deleted Item", "The item '" . $_GET['id'] . "' has been added again.");

        header("Location: edit-menu.php?message=add_success");

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        // header("Location: edit-menu.php?message=add_failure");
    }

    $conn = null;

}

?>