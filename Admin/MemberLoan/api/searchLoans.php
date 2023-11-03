<?php
require_once "connection.php";

$query = $_GET['query'];

$sql = "SELECT * FROM loan_applications WHERE account_number LIKE ? OR customer_name LIKE ? OR college LIKE ? OR loan_type LIKE ? 
OR application_status LIKE ? OR loanNo LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = '%' . $query . '%';
$stmt->bind_param('ssssss', $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);

$stmt->execute();
$result = $stmt->get_result();

echo "<tr>";
        echo "<th>Account Number</th>";
        echo "<th>Name</th>";
        echo "<th>College/Dept</th>";
        echo "<th>Type</th>";
        echo "<th>Date of applying</th>";
        echo "<th>Amount</th>";
        echo "<th>Status</th>";
        echo "<th>Loan Ref</th>";
        echo "<th>Actions</th>";
echo "</tr>";

// Output the loan applications as HTML
if ($result->num_rows > 0){
    while ($row = $result->fetch_assoc()) {
    
        echo "<tr>";
            echo "<td><a class='text-decoration-none text-primary' href='/coop/Admin/MemberLoan/Application/application.php?account_number=" . $row["account_number"] . "&loan_id=" . $row["loanNo"] . "'>" . $row["account_number"] . "</a></td>";            
            echo "<td>" . $row["customer_name"] . "</td>";
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
    }
} else {
    if ($status === 'all') {
        echo "<tr><td colspan='9'>No borrowers found.</td></tr>";
    } else {
        echo "<tr><td colspan='9'>No loan applications found.</td></tr>";
    }
}

?>