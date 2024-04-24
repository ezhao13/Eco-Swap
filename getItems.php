<?php

$search = isset($_POST['search']) ? '%' . $_POST['search'] . '%' : '%'; // Use a wildcard if no search query

try {
    // Connect to the SQLite database
    $conn = new PDO("sqlite:database.db");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    /* //To delete item with specific id
    $delete = "DELETE FROM Products WHERE id>=8";
    $conn->exec($delete);
  */

    $sql = "SELECT * FROM Products WHERE itemDescription LIKE :search OR itemName LIKE :search OR email LIKE :search OR phoneNumber LIKE :search";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':search', $search, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch all the results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($results);
    header('Content-Type: application/json');
    echo $json;
  
  
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>
