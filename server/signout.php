<?php

session_start();
include_once("functions.php");

if (isset($_SESSION['id'])) {
    express_log("User Signout", "The user '" . $_SESSION['id'] . "' has signed out.");
    unset($_SESSION['id']);
    header('Location: employee.php');
} else {
    header('Location: employee.php');
}

?>