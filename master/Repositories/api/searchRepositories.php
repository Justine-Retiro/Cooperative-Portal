<?php
require_once "connection.php";

$query = $_GET['query'];

$sql = "SELECT clients.*, users.* FROM clients INNER JOIN users ON clients.user_id = users.user_id WHERE clients.account_number AND users.account_number LIKE ? OR first_name LIKE ? OR middle_name LIKE ? OR last_name LIKE ? OR  role LIKE ? OR remarks LIKE ?";
$stmt = $conn->prepare($sql);

$searchTerm = '%' . $query . '%';
$stmt->bind_param('ssssss', $searchTerm, $searchTerm, $searchTerm, $searchTerm,$searchTerm, $searchTerm );

$stmt->execute();
$result = $stmt->get_result();

echo "<table class='table' style='font-size: large;'>";
echo "<tr>";
echo "<th>#</th>";
echo "<th>Account Number</th>";
echo "<th>Name</th>";
echo "<th>Birth Date</th>";
echo "<th>Status</th>";
echo "<th>Actions</th>";
echo "</tr>";

// Output the records as HTML
$counter = 1;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $counter . "</td>";
        echo "<td> <a class='text-decoration-none text-primary' href='/coop/Admin/Repositories/Edit/edit.php?account_number=" . $row["account_number"] . "'>" . $row["account_number"] . "</td>";
        echo "<td>" . $row["first_name"] . " " . $row["middle_name"] . " " . $row["last_name"] . "</td>";
        $date = date_create($row["birth_date"]);
        echo "<td>" . date_format($date,"M d Y") . "</td>";
        
        // -- Role
        if ($row["account_status"] === "Active") {
            echo "<td class='text-success fw-medium'>" . $row["account_status"] . "</td>";
        } elseif ($row["account_status"] === "Inactive") {
            echo "<td class='text-danger fw-medium'>" . "Inactive" . "</td>";
        }    
        echo "<td>";
        echo '<a href="/coop/Admin/Repositories/Edit/editAdmin.php?account_number=' . $row["account_number"] . '"><button class="btn btn-success me-1">Edit</button></a>';
        echo '<a href="/coop/Admin/Repositories/api/delete.php?account_number=' . $row["account_number"] . '"><button class="btn btn-danger">Delete</button></a>';                                        
        echo "</td>";
        echo "</tr>";
        $counter++;
    }
} else {
    echo "<tr><td colspan='6'>No records have been found.</td></tr>";
}

echo "</table>";



?>