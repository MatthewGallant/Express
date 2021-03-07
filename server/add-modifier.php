<?php

include_once("functions.php");
verify();

include_once("database.php");

if (isset($_GET['item']) && isset($_GET['modifier'])) {

    $item_id = $_GET['item'];
    $modifier_id = $_GET['modifier'];

    $existsing_modifier = query("SELECT item_modifiers FROM menu WHERE id = " . $item_id)[0]['item_modifiers'];

    $existing_modifiers = explode(", ", $existsing_modifier);

    $exists = false;

    foreach ($existing_modifiers as $mod) {
        if ($mod == $modifier_id) {
            $exists = true;
        }
    }

    if ($exists == false) {

        if ($existsing_modifier != "") {
            $new_modifier = $existsing_modifier . ", " . $modifier_id;
        } else {
            $new_modifier = $modifier_id;
        }

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
            $stmt = $conn->prepare("UPDATE menu SET item_modifiers = :item_modifiers WHERE id = " . $item_id);
            
            $stmt->bindParam(':item_modifiers', $item_modifiers);

            $item_modifiers = $new_modifier;

            $stmt->execute();

            express_log("Add Modifier to Item", "The modifier '" . $modifier_id . "' has been added to item '" . $item_id . "'.");

            header("Location: edit-item.php?id=" . $item_id . "&message=add_success");
        
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return "Error";
        }

        $conn = null;

    } else {
        header("Location: edit-item.php?id=" . $item_id . "&message=add_failure");
    }

}

?>