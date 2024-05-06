<?php
include("config.php");

// Get the JSON data from the request body
$jsonData = file_get_contents('php://input');

// Decode the JSON string into a PHP associative array
$data = json_decode($jsonData, true);

// Check if the JSON decoding was successful
if ($data === null) {
    die();
}

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the record already exists
$sql_check = "SELECT * FROM users WHERE email = ? AND first_name = ? AND last_name = ? AND phone_number = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ssss", $data['Email'], $data['First Name'], $data['Last Name'], $data['Phone Number']);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows > 0) {
    echo "Record already exists";
} else {
    // Prepare and execute the SQL INSERT statement
    $sql_insert = "INSERT INTO users (email, first_name, last_name, phone_number) 
            VALUES (?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ssss", $data['Email'], $data['First Name'], $data['Last Name'], $data['Phone Number']);

    if ($stmt_insert->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}

// Close the statements
$stmt_check->close();
$stmt_insert->close();

// Close the database connection
$conn->close();