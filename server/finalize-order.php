<?php

include_once("functions.php");
verify_employee();

include_once("database.php");

if (isset($_GET['id'])) {

    $order_id = $_GET['id'];

    $existing_order = query("SELECT * FROM incoming_orders WHERE id = " . $order_id);

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
        $stmt = $conn->prepare("INSERT INTO completed_orders (id, uuid, `order`, time_placed, price, full_name, email_address, phone_number, processed_by) VALUES (:id, :uuid, :order, :time_placed, :price, :full_name, :email_address, :phone_number, :processed_by)");
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':uuid', $uuid);
        $stmt->bindParam(':order', $order);
        $stmt->bindParam(':time_placed', $time_placed);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':email_address', $email_address);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':processed_by', $processed_by);

        $id = $existing_order[0]['id'];
        $uuid = $existing_order[0]['uuid'];
        $order = $existing_order[0]['order'];
        $time_placed = $existing_order[0]['time_ordered'];
        $price = $existing_order[0]['price'];
        $full_name = $existing_order[0]['full_name'];
        $email_address = $existing_order[0]['email_address'];
        $phone_number = $existing_order[0]['phone_number'];
        $processed_by = get_employee();

        $stmt->execute();

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            // prepare sql and bind parameters
            $stmt = $conn->prepare("DELETE FROM incoming_orders WHERE id = " . $order_id);
    
            $stmt->execute();
    
            express_log("Finalize Order", "The order '" . $uuid . "' has been finalized.");
    
            header("Location: live.php");
        
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return "Error";
        }
    
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        return "Error";
    }

    $conn = null;

}

?>