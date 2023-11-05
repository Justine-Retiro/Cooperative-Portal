<?php 
require_once "connection.php";
include __DIR__ . "/../../api/session.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'mem'){
    header('Location: /coop/globalApi/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validation form data
    $account_number = $_SESSION['account_number'];
    $loanNo = $_POST['loanNo'];
    $application_status = $_POST['application_status'];
    $customer_name = $_POST['customer_name'];
    $age = (int)$_POST['age'];
    $date_employed = $_POST['doe'];
    $birth_date = $_POST['dob'];
    $contact_num = $_POST['contact'];
    $college = $_POST['college'];
    $loan_type = $_POST['loan_type'];
    $work_position = $_POST['work_position'];
    $retirement_year = $_POST['retirement'];
    $application_date = $_POST['doa'];
    $applicant_sign = $_POST['signature'];
    $amount_before = $_POST['amount_before'];
    $amount_after = $_POST['amount_after'];
    $time_pay = $_POST['time_pay'];
    $loanTerm_type = $_POST['loan_term_Type'];

    // Start transaction
    $conn->begin_transaction();

    try {
        // Prepare the statement
        $insertSql = "INSERT INTO loan_applications (
            loanNo, account_number, customer_name, age, birth_date, date_employed, contact_num, college, 
            loan_type, work_position, retirement_year, application_date, applicant_sign, 
            application_status, amount_before, amount_after, time_pay, loan_term_Type)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";    
        $stmtInsert = $conn->prepare($insertSql);
        
        // Bind parameters for the insert query
        $stmtInsert->bind_param('iissssssssssssiiis', $loanNo, $account_number, $customer_name, $age, $birth_date, $date_employed, $contact_num, 
        $college, $loan_type, $work_position, $retirement_year, $application_date, $applicant_sign, $application_status, $amount_before, $amount_after, $time_pay, $loanTerm_type);

        // Execute the statement
        $stmtInsert->execute();

        // Insert record into transaction_history table
        $audit_description = "Loan Request";
        $transaction_type = "Loan";
        $transaction_date = date("Y-m-d");
        $transaction_status = $application_status;

        $query = "INSERT INTO transaction_history (account_number, loanNo, audit_description, transaction_type, transaction_date, transaction_status) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sissss", $account_number, $loanNo, $audit_description, $transaction_type, $transaction_date, $transaction_status);
        $stmt->execute();

        // If no errors, commit the transaction
        $conn->commit();

        header("location: /coop/Member/Loan/loan.php");
        exit();
    } catch (Exception $e) {
        // An error occurred; rollback the transaction
        $conn->rollback();

        // Display the error message
        echo "Error: " . $e->getMessage();
    } finally {
        // Close the statements
        $stmtInsert->close();
        $stmt->close();
    }
}
?>