<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];
}

try {
  // Connect to sqlite database
  $conn = new PDO("sqlite:database.db");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Create table
  $sql = "CREATE TABLE IF NOT EXISTS Users (
    id SERIAL PRIMARY KEY,
    username TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL
);";

  $conn->exec($sql);

  // Prepare if exists statment
  $exists = $conn->prepare("SELECT CASE WHEN EXISTS (
    SELECT 1 FROM users WHERE username=:username AND password=:password
) THEN 'true'
ELSE 'false' END AS result;");
  
  // Bind the parameters
  $exists->bindParam(':username', $username);
  $exists->bindParam(':password', $password);

  // Execute the statement
  $exists->execute();

  // Fetch the result
  $row = $exists->fetch(PDO::FETCH_ASSOC);
  $result = $row['result'];

  // Find if a username exists
  $usernameQuery = $conn->prepare("SELECT CASE WHEN NOT EXISTS (
    SELECT 1 FROM users WHERE username=:username
) THEN 'true'
ELSE 'false' END AS result;");
$usernameQuery->bindParam(':username', $username);
$usernameQuery->execute();

// Fetch the result
$row = $usernameQuery->fetch(PDO::FETCH_ASSOC);
$result = $row['result'];

// If there is no username, then execute the second statement
if ($result === 'true') {
    $insert = $conn->prepare("INSERT INTO Users (username, password) VALUES (:username, :password)");
    $insert->bindParam(':username', $username);
    $insert->bindParam(':password', $password); 
    $insert->execute();
    echo "User created successfully";
} else {
    echo "Username already exists";
}


// Return the result as a JSON response
  header('Content-Type: application/json');
  echo json_encode(['result' => $result == 'true']);

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>