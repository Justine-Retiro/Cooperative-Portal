<?php
require_once 'connection.php';
// include __DIR__ . "/../../api/session.php";

// if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'admin'){
//     header('Location: /coop/globalApi/login.php');
//     exit();
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $account_number = $_POST["account_number"];
    $amount = $_POST["amount"]; // You need to retrieve the amount from your form

    // Start a database transaction
    $conn->begin_transaction();

    try {
        // Update the loan application status to "Accepted"
        $updateSql = "UPDATE loan_applications SET application_status = 'Accepted' WHERE account_number = ?";
        $stmtUpdate = $conn->prepare($updateSql);

        if (!$stmtUpdate) {
            echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        }

        $stmtUpdate->bind_param('s', $account_number);

        // Check if the statement is executed successfully
        if ($stmtUpdate->execute()) {

            // Transfer balance
            $insertSql = "INSERT INTO clients (amount, remarks) VALUES (?, ?, 'unpaid')";
            $stmtInsert = $conn->prepare($insertSql);

            if (!$stmtInsert) {
                echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
            }

            // You need to replace $client_id with the actual client_id from your form
            $stmtInsert->bind_param('account_number', $client_id, $amount);

            if ($stmtInsert->execute()) {
                // Commit the transaction
                $conn->commit();

                // Loan application status updated and balance transferred successfully
                header("location: /coop/Admin/MemberLoan/loan.php");
                exit();
            } else {
                // Handle the error (e.g., display an error message)
                echo "Execute failed: (" . $stmtInsert->errno . ") " . $stmtInsert->error;
                $conn->rollback();
            }
        } else {
            // Handle the error (e.g., display an error message)
            echo "Execute failed: (" . $stmtUpdate->errno . ") " . $stmtUpdate->error;
            $conn->rollback();
        }
    } catch (Exception $e) {
        // Rollback the transaction in case of an error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    $stmtUpdate->close();
    $stmtInsert->close();
}

?>
