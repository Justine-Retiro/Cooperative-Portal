<?php
require_once "connection.php";
session_start();

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $birthdate = $_POST["birthdate"];

    $query = "SELECT clients.birth_date, clients.account_status, users.role  
    FROM clients 
    INNER JOIN users ON clients.user_id = users.user_id 
    WHERE clients.account_number = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $_SESSION["account_number"]);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if ($birthdate == $user['birth_date']) {
            $response['status'] = 'success';
            $response['role'] = $_SESSION['role'];

            // Add the isset() check here
            if (isset($user['account_status'])) {
                $response['account_status'] = $user['account_status'];
                setcookie('toastr', 'Successfully logged in!', time() + (86400 * 30), "/"); // 86400 = 1 day

            } else {
                $response['account_status'] = 'unknown'; // Or handle the case when 'account_status' is not present
            }
            // Reset the counter if the birthdate is correct
            $_SESSION['attempt_counter'] = 0;
        } else {
            $response['status'] = 'fail';
            $response['message'] = 'Invalid birthdate.';
            $_SESSION['attempt_counter'] = isset($_SESSION['attempt_counter']) ? $_SESSION['attempt_counter'] + 1 : 1;
            if ($_SESSION['attempt_counter'] >= 5) {
                // Unset all of the session variables
                $_SESSION = array();
                // Destroy the session
                session_destroy();
                $response['status'] = 'redirect';
                setcookie('toastr', 'Too many failed attempts. Please log in again.', time() + (86400 * 30), "/"); // 86400 = 1 day
            }
        }
    } else {
        $response['status'] = 'fail';
        $response['message'] = 'An error occurred. Please try again later.';
    }
}

echo json_encode($response);
?>