<?php

include_once("functions.php");
verify();

include_once("database.php");

if (isset($_GET['id'])) {

    $list_id = $_GET['id'];

    $menu = query("SELECT * FROM menu");

    $list_used = false;

    foreach ($menu as $item) {
        foreach (explode(", ", $item['item_modifiers']) as $mod) {
            if ($mod == $list_id) {
                $list_used = true;
            }
        }
    }

    if ($list_used == false) {
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
            $stmt = $conn->prepare("DELETE FROM modifiers WHERE id = " . $list_id);

            $stmt->execute();

            express_log("Remove List", "The list '" . $list_id . "' has been removed.");

            header("Location: edit-modifier-lists.php?message=delete_success");
        
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return "Error";
        }

        $conn = null;
    } else {
        header("Location: edit-modifier-lists.php?message=delete_failure");
    }

} else {
    header("Location: edit-modifier-lists.php?message=delete_failure");
}

?>