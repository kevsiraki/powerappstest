<?php
include("config.php");

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID parameter exists in the request
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the SQL DELETE statement
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Return success response
        http_response_code(200);
        echo json_encode(array("message" => "Record deleted successfully"));
    } else {
        // Return error response
        http_response_code(500);
        echo json_encode(array("message" => "Error deleting record"));
    }

    // Close statement
    $stmt->close();
} else {
    // Return error response if ID parameter is missing
    http_response_code(400);
    echo json_encode(array("message" => "Missing ID parameter"));
}

// Close connection
$conn->close();
?>
