<?php
require_once "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['loanNo']) && isset($_POST['action'])) {
        $loanNo = $_POST['loanNo'];
        $action = $_POST['action'];

        // Get the loan amount requested
        $loanAmount = getLoanAmount($loanNo);

        // Update the loan status
        if (updateLoanStatus($loanNo, $action)) {
            // Update the client's balance and remarks
            if (updateClientBalanceAndRemarks($loanNo, $loanAmount, $action)) {
                echo "Success";
            } else {
                echo "Error updating client balance and remarks";
            }
        } else {
            echo "Error updating loan status";
        }
    } else {
        echo "Invalid request";
    }
} else {
    echo "Invalid request method";
}

// Function to get the loan amount requested
function getLoanAmount($loanNo) {
    global $conn;
    $sql = "SELECT amount FROM loan_applications WHERE loanNo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $loanNo);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $loanAmount = $row['amount'];
        $stmt->close();
        return $loanAmount;
    } else {
        echo "Error in getLoanAmount query: " . $stmt->error;
        return false;
    }
}

// Function to update the loan status
function updateLoanStatus($loanNo, $action) {
    global $conn;
    if ($action === 'Accepted') {
        $sql = "UPDATE loan_applications SET application_status = 'Accepted', action_taken = 'Accepted' WHERE loanNo = ?";
    } elseif ($action === 'Rejected') {
        $sql = "UPDATE loan_applications SET application_status = 'Rejected', action_taken = 'Rejected' WHERE loanNo = ?";
    }
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $loanNo);

    if ($stmt->execute()) {
        return true;
    } else {
        echo "Error in updateLoanStatus query: " . $stmt->error;
        return false;
    }
}

// Function to update client's balance and remarks
function updateClientBalanceAndRemarks($loanNo, $loanAmount, $action) {
    global $conn;
    error_log("Updating client balance and remarks for loan number $loanNo, loan amount $loanAmount, action $action");
    if ($action === 'Accepted') {
        // Deduct the loan amount from the client's balance
        $sql = "UPDATE clients c INNER JOIN loan_applications la ON c.account_number = la.account_number SET c.balance = c.balance + ? WHERE la.loanNo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ds', $loanAmount, $loanNo);

        if (!$stmt->execute()) {
            error_log("SQL error in updateClientBalanceAndRemarks (balance): " . $stmt->error);
        }

        $stmt->close();

        // Update client's remarks to "Unpaid"
        $sql = "UPDATE clients c INNER JOIN loan_applications la ON c.account_number = la.account_number SET c.remarks = 'Unpaid' WHERE la.loanNo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $loanNo);

        if (!$stmt->execute()) {
            error_log("SQL error in updateClientBalanceAndRemarks (remarks): " . $stmt->error);
        }
    } elseif ($action === 'Rejected') {
        // No balance changes when the loan is rejected
        // Update client's remarks to "Unpaid"
        $sql = "UPDATE clients c INNER JOIN loan_applications la ON c.account_number = la.account_number SET c.remarks = 'Unpaid' WHERE la.loanNo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $loanNo);

        if (!$stmt->execute()) {
            error_log("SQL error in updateClientBalanceAndRemarks (reject): " . $stmt->error);
        }
    }
}
?>