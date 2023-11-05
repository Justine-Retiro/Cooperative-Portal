<?php
require_once "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['loanNo']) && isset($_POST['action'])) {
        $loanNo = $_POST['loanNo'];
        $action = $_POST['action'];
        $dueDate = $_POST['dueDate'];
        
        

        // Get the loan amount requested
        list($loanAmount, $loanAfter) = getLoanAmount($loanNo);
        
        updateTransaction($loanNo, $action, $dueDate);
        // Update the loan status
        if (updateLoanStatus($loanNo, $action, $_POST['dueDate'])) {
            // Update the client's balance and remarks
            if (updateClientBalanceAndRemarks($loanNo, $loanAfter, $action)) {
                header('/coop/Admin/MemberLoan/loan.php');
                exit();
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

function updateTransaction($loanNo, $action, $account_number){
    global $conn;

    $sql = "SELECT account_number FROM transaction_history WHERE loanNo = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "Error in prepare: " . $conn->error;
        return false;
    }
    $stmt->bind_param("s", $loanNo);
    if (!$stmt->execute()) {
        echo "Error in execute: " . $stmt->error;
        return false;
    }
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        echo "No rows returned from query";
        return false;
    }

    $account_number = $row['account_number'];

    if ($action === 'Accepted') {
        // Update transaction_status in transaction_history for accepted loans
        $sql2 = "UPDATE transaction_history SET transaction_status = 'Accepted' WHERE loanNo = ? AND account_number = ?";
        $stmt2 = $conn->prepare($sql2);
        if (!$stmt2) {
            echo "Error in prepare: " . $conn->error;
            return false;
        }
        $stmt2->bind_param('ss', $loanNo, $account_number);
        if (!$stmt2->execute()) {
            echo "Error in execute: " . $stmt2->error;
            return false;
        }
    } elseif ($action === "Rejected") {
        // Update transaction_status in transaction_history
        $sql3 = "UPDATE transaction_history SET transaction_status = 'Rejected' WHERE loanNo = ? AND account_number = ?";
        $stmt3 = $conn->prepare($sql3);
        if (!$stmt3) {
            echo "Error in prepare: " . $conn->error;
            return false;
        }
        $stmt3->bind_param('ss', $loanNo, $account_number);
        if (!$stmt3->execute()) {
            echo "Error in execute: " . $stmt3->error;
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
        $sql = "UPDATE clients c INNER JOIN loan_applications la ON c.account_number = la.account_number SET c.remarks = '' WHERE la.loanNo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $loanNo);

        if (!$stmt->execute()) {
            error_log("SQL error in updateClientBalanceAndRemarks (reject): " . $stmt->error);
        }
    }
}
?>