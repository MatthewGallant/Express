<?php

include_once("functions.php");
verify();

include_once("database.php");

if (isset($_GET['id'])) {

    $account_id = $_GET['id'];

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
        $stmt = $conn->prepare("DELETE FROM login WHERE id = " . $account_id);

        $stmt->execute();

        express_log("Delete Account", "The account '" . $account_id . "' has been deleted.");

        header("Location: manager-accounts.php?message=delete_success");
    
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        return "Error";
    }

    $conn = null;

} else {
    header("Location: manager-accounts.php?message=delete_failure");
}

?>