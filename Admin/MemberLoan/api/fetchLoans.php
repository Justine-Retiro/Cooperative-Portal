<?php
require_once "connection.php";

$status = $_GET['status'];

if ($status === 'all') {
    $query = "SELECT * FROM loan_applications";
} else {
    $query = "SELECT * FROM loan_applications WHERE application_status = ?";
}

$stmt = $conn->prepare($query);

if ($status !== 'all') {
    $stmt->bind_param('s', $status);
}

$stmt->execute();
$result = $stmt->get_result();

echo "<tr>";
echo "<th class='fw-medium'>#</th>";
echo "<th class='fw-medium'>Account Number</th>";
echo "<th class='fw-medium'>Name</th>";
echo "<th class='fw-medium'>College/Dept</th>";
echo "<th class='fw-medium'>Type</th>";
echo "<th class='fw-medium'>Date of applying</th>";
echo "<th class='fw-medium'>Amount</th>";
echo "<th class='fw-medium'>Status</th>";
echo "<th class='fw-medium'>Loan Ref</th>";
echo "<th class='fw-medium'>Actions</th>";
echo "</tr>";

// Output the loan applications as HTML
$counter = 1; // Initialize a counter

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $counter ."</td>";
        echo "<td><a class='text-decoration-none text-primary' href='/coop/Admin/MemberLoan/Application/application.php?account_number=" . $row["account_number"] . "&loan_id=" . $row["loanNo"] . "'>" . $row["account_number"] . "</a></td>";        echo "<td>" . $row["customer_name"] . "</td>";
        echo "<td>" . $row["college"] . "</td>";
        echo "<td>" . $row["loan_type"] . "</td>";
        echo "<td>" . $row["application_date"] . "</td>";
        echo "<td>" . $row["amount"] . "</td>";
        echo "<td>" . $row["application_status"] . "</td>";
        echo "<td>" . $row["loanNo"] . "</td>";
        echo "<td>";
        if ($row["action_taken"]) {
            // If an action has been taken, display the action
            echo "<span>" . ucfirst($row["action_taken"]) . "</span>";
        } else {
            // If no action has been taken, display the buttons
            echo "<button class='accept-btn btn btn-success me-2' data-loan-no='" . $row["loanNo"] . "'>Accept</button>";
            echo "<button class='reject-btn btn btn-danger' data-loan-no='" . $row["loanNo"] . "'>Reject</button>";
        }
        echo "</td>";
        echo "</tr>";

        $counter++; // Increment the counter for the next row
    }
} else {
    if ($status === 'all') {
        echo "<tr><td colspan='9'>No borrowers found.</td></tr>";
    } else {
        echo "<tr><td colspan='9'>No " . $status . " loan applications found.</td></tr>";
    }
}


?>