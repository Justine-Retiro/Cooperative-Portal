<?php
require_once __DIR__ . "/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $account_number = $_POST["account_number"];
    $query = "UPDATE clients SET";
    $params = array();

    if (isset($_POST["balance"])) {
        $query .= " balance = ?,";
        $params[] = $_POST["balance"];
    }
    if (!empty($_POST["remarks"])) {
        $query .= " remarks = ?,";
        $params[] = $_POST["remarks"];
    }

    // Remove the trailing comma from the query
    $query = rtrim($query, ",");

    $query .= " WHERE account_number = ?";
    $params[] = $account_number;

    $stmt = $conn->prepare($query);
    $stmt->bind_param(str_repeat("s", count($params)), ...$params);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header('Location: ../Edit/edit.php?account_number=' . $account_number);
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
