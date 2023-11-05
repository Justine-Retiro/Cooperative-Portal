<?php
require_once "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['loanNo']) && isset($_POST['action'])) {
        $loanNo = $_POST['loanNo'];
        $action = $_POST['action'];
        $dueDate = $_POST['dueDate'];

        // Get the loan amount requested
        list($loanAmount, $loanAfter) = getLoanAmount($loanNo);
        
        // Update the loan status
        if (updateLoanStatus($loanNo, $action, $_POST['dueDate'])) {
            // Update the client's balance and remarks
            if (updateClientBalanceAndRemarks($loanNo, $loanAfter, $action)) {
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
    $sql = "SELECT amount_before, amount_after FROM loan_applications WHERE loanNo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $loanNo);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $loanAmount = $row['amount_before'];
        $loanAfter = $row['amount_after'];
        $stmt->close();
        return array($loanAmount, $loanAfter);
    } else {
        echo "Error in getLoanAmount query: " . $stmt->error;
        return false;
    }
}

// Function to update the loan status
function updateLoanStatus($loanNo, $action, $dueDate = null) {
    global $conn;
    if ($action === 'Accepted') {
        $sql = "UPDATE loan_applications SET application_status = 'Accepted', action_taken = 'Accepted', remarks = 'Unpaid' WHERE loanNo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $loanNo);
        if ($stmt->execute()) {
            $sql = "UPDATE loan_applications SET dueDate = ? WHERE loanNo = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $dueDate, $loanNo);
            if (!$stmt->execute()) {
                echo "Error in update dueDate query: " . $stmt->error;
                return false;
            }
        } else {
            echo "Error in updateLoanStatus query: " . $stmt->error;
            return false;
        }
    } elseif ($action === 'Rejected') {
        $sql = "UPDATE loan_applications SET application_status = 'Rejected', action_taken = 'Rejected', remarks = 'Rejected' WHERE loanNo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $loanNo);
        if (!$stmt->execute()) {
            echo "Error in updateLoanStatus query: " . $stmt->error;
            return false;
        }
    }
    return true;
}

// Function to update client's balance and remarks
function updateClientBalanceAndRemarks($loanNo, $loanAfter, $action) {
    global $conn;
    error_log("Updating client balance and remarks for loan number $loanNo, loan amount $loanAfter, action $action");
    if ($action === 'Accepted') {
        // Deduct the loan amount from the client's balance
        $sql = "UPDATE clients c INNER JOIN loan_applications la ON c.account_number = la.account_number SET c.balance = c.balance + ? WHERE la.loanNo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ds', $loanAfter, $loanNo);

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