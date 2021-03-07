<?php

include_once("functions.php");
verify();

include_once("database.php");

if (isset($_GET['id'])) {

    $category_id = $_GET['id'];

    $category_name = query("SELECT category_name FROM categories WHERE id = " . $category_id)[0]['category_name'];
    $menu = query("SELECT * FROM menu");

    $category_used = false;

    foreach ($menu as $item) {
        if ($item['item_category'] == $category_name) {
            $category_used = true;
        }
    }

    if ($category_used == false) {

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
            $stmt = $conn->prepare("DELETE FROM categories WHERE id = " . $category_id);
    
            $stmt->execute();
    
            express_log("Remove Category", "The category '" . $category_id . "' has been removed.");
    
            header("Location: edit-categories.php?message=delete_success");
        
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return "Error";
        }
    
        $conn = null;

    } else {
        header("Location: edit-categories.php?message=delete_failure");
    }

} else {
    header("Location: edit-categories.php?message=delete_failure");
}

?>