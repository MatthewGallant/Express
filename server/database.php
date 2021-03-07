<?php

function query($query) {

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
        $stmt = $conn->prepare($query);
        $stmt->execute();
    
        // get result
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
        $data = $stmt->fetchAll();

        return $data;
    
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        return "Error";
    }


    
    $conn = null;
}

?>