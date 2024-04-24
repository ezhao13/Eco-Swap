<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $itemName = $_POST['name'];
  $itemDescription = $_POST['itemDescription'];
  $email = $_POST['email'];
  $phoneNumber = $_POST['number'];
  $option = $_POST['option'];
}

try {
  // Connect to sqlite database
  $conn = new PDO("sqlite:database.db");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  

  // Create table
  $sql = "CREATE TABLE IF NOT EXISTS Products (
    id INTEGER PRIMARY KEY,
    itemName TEXT NOT NULL,
    itemDescription TEXT NOT NULL,
    email TEXT,
    phoneNumber TEXT,
    option TEXT NOT NULL,
    path TEXT
  )";

  $conn->exec($sql);

  if ($_FILES['image']['error'] == 0) {
        // Set the image upload directory
        $uploadDir = 'uploads/';
        // Get the image file extension
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        // Create a unique file name
        $fileName = uniqid() . '.' . $extension;

    
      if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $fileName)) {
          // Prepare an INSERT statement
          $stmt = $conn->prepare("INSERT INTO Products (itemName, itemDescription, email, phoneNumber, option, path) VALUES (:itemName, :itemDescription, :email, :phoneNumber, :option, :path)");

          // Set the path value
          $path = $uploadDir . $fileName;
          
          // Bind the parameters
          $stmt->bindParam(':itemName', $itemName);
          $stmt->bindParam(':itemDescription', $itemDescription);
          $stmt->bindParam(':email', $email);
          $stmt->bindParam(':phoneNumber', $phoneNumber);
          $stmt->bindParam(':option', $option);
          $stmt->bindParam(':path', $path);
        
          // Execute the statement
          $stmt->execute();
      } else {
          echo 'Failed to move the uploaded file.';
      }
  }



} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>