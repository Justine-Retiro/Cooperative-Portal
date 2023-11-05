<?php
require_once "connection.php";
session_start();

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $birthdate = $_POST["birthdate"];
    error_log("Birthdate: " . print_r($birthdate, true)); // Log birthdate

    $query = "SELECT birth_date FROM clients WHERE account_number = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $_SESSION["account_number"]);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if ($birthdate == $user['birth_date']) {
            $response['status'] = 'success';
            $response['role'] = $_SESSION['role'];
        } else {
            $response['status'] = 'fail';
            $response['message'] = 'Invalid birthdate.';
        }
    } else {
        $response['status'] = 'fail';
        $response['message'] = 'An error occurred. Please try again later.';
    }
}

echo json_encode($response);
?>