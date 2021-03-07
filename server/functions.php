<?php

function verify() {

    session_start();
    include_once("database.php");

    if (isset($_SESSION['id'])) {
        $user = query("SELECT email FROM login WHERE id = " . isset($_SESSION['id']))[0]['email'];

        if (!isset($user)) {
            header('Location: login.php?message=session_expired');
        }

    } else {
        header('Location: login.php?message=session_expired');
    }

}

function verify_employee() {

    session_start();
    include_once("database.php");

    if (isset($_SESSION['employee'])) {
        $user = query("SELECT account_name FROM accounts WHERE id = " . $_SESSION['employee'])[0]['account_name'];

        if (!isset($user)) {
            header('Location: employee.php?message=session_expired');
        }

    } else {
        header('Location: employee.php?message=session_expired');
    }

}

function get_manager() {

    session_start();
    include_once("database.php");

    if (isset($_SESSION['id'])) {
        $user = query("SELECT name FROM login WHERE id = " . $_SESSION['id'])[0]['name'];
        return $user;
    } else {
        return "Unknown User";
    }

}

function get_admin_status() {

    session_start();
    include_once("database.php");

    if (isset($_SESSION['id'])) {
        $admin = query("SELECT admin FROM login WHERE id = " . $_SESSION['id'])[0]['admin'];
        return $admin;
    } else {
        return "Unknown User";
    }

}

function get_employee() {

    session_start();
    include_once("database.php");

    if (isset($_SESSION['employee'])) {
        $user = query("SELECT account_name FROM accounts WHERE id = " . $_SESSION['employee'])[0]['account_name'];
        return $user;
    } else {
        return "Unknown User";
    }

}

function express_log($name, $information) {

    date_default_timezone_set('America/New_York');

    include_once("database.php");
    
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
        $stmt = $conn->prepare("INSERT INTO log (name, information, user, time) VALUES (:name, :information, :user, :time)");
        
        $stmt->bindParam(':name', $db_name);
        $stmt->bindParam(':information', $db_information);
        $stmt->bindParam(':user', $db_user);
        $stmt->bindParam(':time', $db_time);

        $db_name = $name;
        $db_information = $information;
        $db_time = date('Y-m-d H:i');
        $db_user = get_user_email();

        $stmt->execute();

    } catch(PDOException $e) {
        echo $e->getMessage();
    }

    $conn = null;

}

function get_user_email() {

    session_start();
    include_once("database.php");

    if (isset($_SESSION['id'])) {
        $user = query("SELECT email FROM login WHERE id = " . isset($_SESSION['id']))[0]['email'];
        return $user;
    }

}

function page_access_log() {

    express_log("Page Access", "The page '" . basename($_SERVER['PHP_SELF']) . "' has been accessed.");

}

function clean($string) {
    $string = str_replace('"', "", $string);
    $string = str_replace("'", "", $string);
    $string = str_replace("/", "", $string);
    $string = str_replace("=", "", $string);
    $string = str_replace(":", "", $string);
    $string = str_replace(";", "", $string);
    $string = strip_tags($string);
    return $string;
}

?>