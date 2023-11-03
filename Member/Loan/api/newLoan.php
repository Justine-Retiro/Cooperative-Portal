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
    $application_status = $_POST['application_status']; // Corrected the variable name
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
    $amount = $_POST['amount'];

    // Check if $stmtInsert is set, and if not, prepare the statement
    $insertSql = "INSERT INTO loan_applications (
        loanNo, account_number, customer_name, age, birth_date, date_employed, contact_num, college, loan_type, work_position,
        retirement_year, application_date, applicant_sign, application_status, amount)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";    
    $stmtInsert = $conn->prepare($insertSql);
    
    if (!$stmtInsert) {
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
    }

    // Bind parameters for the insert query
    $bindInsert = $stmtInsert->bind_param('iissssssssssssi', $loanNo, $account_number, $customer_name, $age, $birth_date, $date_employed, $contact_num, 
    $college, $loan_type, $work_position, $retirement_year, $application_date, $applicant_sign, $application_status, $amount);

    if (!$bindInsert) {
        echo "Binding parameters failed: (" . $stmtInsert->errno . ") " . $stmtInsert->error;
    }

    // Check if the statement is executed successfully
    if ($stmtInsert->execute()) {
        // Loan application submitted successfully
        header("location: /coop/Member/Loan/loan.php");
        exit();
    } else {
        // Handle the error (e.g., display an error message)
        echo "Execute failed: (" . $stmtInsert->errno . ") " . $stmtInsert->error;
    }

    $stmtInsert->close();
}
?>
