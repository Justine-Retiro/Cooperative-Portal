<?php
    session_start(); //Start the session at the beginning

    // Assuming $conn is your database connection
    require_once __DIR__ . '/connection.php';

    // Check if the user is logged in, if not then redirect to login page
    if(!isset($_SESSION["user_id"]) || $_SESSION["loggedin"] !== true){
        header("Location: /coop/");
        exit;
    }

    $sql = "SELECT first_name, last_name FROM clients WHERE user_id = " . $_SESSION['user_id'];
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['last_name'] = $row['last_name'];
        }
    } else {
        // If no results, redirect to login.php
        header("Location: /coop/");
        exit;
    }
?>