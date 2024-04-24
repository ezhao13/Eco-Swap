<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $itemName = $_POST['name'];
  $email = $_POST['email'];
  $phoneNumber = $_POST['number'];
  $option = $_POST['option'];
}

try {
  // Connect to sqlite database
  $conn = new PDO("sqlite:database.db");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Prepare an INSERT statement
  $stmt = $conn->prepare("DELETE FROM Products WHERE itemName=:itemName AND email=:email AND phoneNumber=:phoneNumber AND option=:option");
  
  // Bind the parameters
  $stmt->bindParam(':itemName', $itemName);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':phoneNumber', $phoneNumber);
  $stmt->bindParam(':option', $option);

  // Execute the statement
  $stmt->execute();

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>