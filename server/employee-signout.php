<?php

session_start();
include_once("functions.php");

if (isset($_SESSION['employee'])) {
    express_log("Employee Signout", "The employee '" . $_SESSION['employee'] . "' has signed out.");
    unset($_SESSION['employee']);
    header('Location: employee.php');
} else {
    header('Location: employee.php');
}

?>