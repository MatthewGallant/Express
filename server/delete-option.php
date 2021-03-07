<?php

include_once("functions.php");
verify();

include_once("database.php");

if (isset($_GET['id']) && isset($_GET['option'])) {

    $modifier_id = $_GET['id'];
    $option_name = $_GET['option'];

    $modifier_options = query("SELECT modifier_data FROM modifiers WHERE id = " . $modifier_id)[0]['modifier_data'];

    $option_data = explode("|", $modifier_options);

    $new_options = [];

    foreach ($option_data as $mod) {

        $modifier_options = explode("::", $mod);

        $option_name = str_replace("_", " ", $option_name);

        if ($modifier_options[0] != $option_name){
            
            $opt = $modifier_options[0] . "::" . $modifier_options[1];
            array_push($new_options, $opt);

        }

    }

    $new_options_string = implode("|", $new_options);

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
        $stmt = $conn->prepare("UPDATE modifiers SET modifier_data = :modifier_data WHERE id = " . $modifier_id);

        $stmt->bindParam(':modifier_data', $modifier_data);

        $modifier_data = $new_options_string;

        $stmt->execute();

        express_log("Delete Option", "The option '" . $option_name . "' has been deleted from modifier list '" . $modifier_id . "'.");

        header("Location: edit-modifier-list.php?id=" . $modifier_id . "&message=delete_success");
    
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        return "Error";
    }

    $conn = null;

} else {
    header("Location: edit-modifier-list.php?id=" . $modifier_id . "&message=delete_failure");
}

?>