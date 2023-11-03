<?php
require_once "connection.php";

if (isset($_GET["account_number"])) {
  $account_number = $_GET["account_number"];
  
  // Prepare the delete query for clients table
  $query = "DELETE FROM clients WHERE account_number = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $account_number);
  $stmt->execute();

  // Prepare the delete query for users table
  $query = "DELETE FROM users WHERE account_number = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $account_number);
  $stmt->execute();
  
  // Execute the delete query
  if ($stmt->execute()) {
    // Redirect back to the repositories.php page after successful deletion
    header("Location: /coop/Admin/Repositories/repositories.php");
    exit();
  } else {
    // Handle the error if the deletion fails
    echo "Error deleting record: " . $conn->error;
  }
}
?>