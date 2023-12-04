<?php
// Include config file
require_once "connection.php";

// Initialize user_id to null
$user_id = null;

// Start a new session or resume the existing session
session_start();

// Account side
// Processing form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the account number and password from the form data
    $account_number = $_POST["account_number"];
    $password = $_POST["password"];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $acc_type = $_POST["role"];

    // Inserting data into the "users" table to store the default password
    $sql = "INSERT INTO users (account_number, passwords, role) VALUES ('$account_number', '$hashed_password', '$acc_type')";
    if ($stmt = $conn->prepare($sql)) {
        if ($stmt->execute()) {
            // Successfully inserted user data into the 'users' table
            $user_id = mysqli_insert_id($conn); // Get the user_id

            // Close the first statement
            $stmt->close();

            // Save the user data into the session
            $_SESSION['user_id'] = $user_id;
            $_SESSION['account_number'] = $account_number;

            // Now, proceed to insert data into the "clients" table
            $sql = 'INSERT INTO clients (user_id, account_number, last_name, middle_name, first_name, birth_date, account_status, position) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)';

            if ($stmt = $conn->prepare($sql)) { 
                // Set parameters for client data
                $account_number = $_POST['account_number'];
                $lastName = $_POST["last_name"];
                $middleName = $_POST["middle_name"];
                $firstName = $_POST["first_name"];
                $birth_date = $_POST["birth_date"];
                $account_status = $_POST["account_status"];
                $position = $_POST["position"];


                $stmt->bind_param('iissssss', $user_id, $account_number, $lastName, $middleName, $firstName, $birth_date, $account_status, $position);                
            if ($stmt->execute()) {
                // Records created successfully. Redirect to the landing page
                header("location: /coop/master/repositories/repositories.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later. " . $stmt->error;
            }

            $stmt->close();
        }
        // Close connection
        $conn->close();
    }
    }
}
?>