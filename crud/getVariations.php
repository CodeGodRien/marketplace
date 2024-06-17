<?php
require "../config/dbconn.php";

// Validate and sanitize input
$productID = $_GET['productID'];
if (!is_numeric($productID)) {
    echo json_encode(['error' => 'Invalid product ID']);
    exit();
}

// Prepare the SQL statement
$sql = "SELECT DISTINCT variationName FROM variations WHERE productID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $productID); // "i" indicates integer type for productID

// Execute the prepared statement
$stmt->execute();
$result = $stmt->get_result();

// Fetch results into an array
$variations = array();
while ($row = mysqli_fetch_assoc($result)) {
    $variations[] = $row['variationName'];
}

// Output JSON-encoded array of variations
echo json_encode($variations);

// Close the statement and database connection
$stmt->close();
$conn->close();
?>
