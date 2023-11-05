<?php
require_once __DIR__ . "/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $account_number = $_POST["account_number"];
    $loanNo = $_POST["loanNo"]; // Get the loan number from POST parameters
    $remarks = $_POST["remarks"]; // Get the remarks from POST parameters
    $amount_paid = $_POST["totalBalance"]; // Set the amount paid
    $payment_date = date("Y-m-d"); // Set the current date
    $audit_description = "Loan Payment"; // Set the audit description

    // Update clients table
    $query = "UPDATE clients SET balance = ? WHERE account_number = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $amount_paid, $account_number);
    $stmt->execute();

    // Fetch the updated balance from the database
    $query = "SELECT balance FROM clients WHERE account_number = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $account_number);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $totalBalance = $row['balance'];

    if ($totalBalance > 0) {
        $remarks = "Paid Partially";
        $remarksClients = "Unpaid";
    } else {
        $remarks = "Paid Fully";
        $remarksClients = "Paid";
    }

    // Update remarks in clients table
    $query = "UPDATE clients SET remarks = ? WHERE account_number = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $remarksClients, $account_number);
    $stmt->execute();

    // Insert record into loan_payments table
    $query = "INSERT INTO loan_payments (loanNo, account_number, remarks, amount_paid, payment_date, audit_description) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssss", $loanNo, $account_number, $remarks, $amount_paid, $payment_date, $audit_description);
    $stmt->execute();

    // Insert record into transaction_history table
    $query = "INSERT INTO transaction_history (account_number, audit_description, transaction_type, transaction_date, transaction_status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $account_number, $audit_description, $audit_description, $payment_date, $remarks);
    $stmt->execute();

    // Check for errors
    if ($conn->error) {
        echo "Error: " . $conn->error;
    } else {
        header("Location: /coop/Admin/Payment/payment.php"); // Redirect to the payment edit page
        exit();
    }
}
?>