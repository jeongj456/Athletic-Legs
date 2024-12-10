<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection settings
$servername = "localhost";
$username = "richiezh"; // Replace with your DB username
$password = "50360501"; // Replace with your DB password
$dbname = "richiezh_db"; // Replace with your DB name

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check if it's a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $muscle_name = htmlspecialchars($_POST['muscle_name']);
    $weight_lifted = htmlspecialchars($_POST['weight_lifted']);
    $time_spent = htmlspecialchars($_POST['time_spent']);

    // Insert the data into the database
    $stmt = $mysqli->prepare("INSERT INTO muscle_data (muscle_name, weight_lifted, time_spent) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }
    
    // Bind parameters: "s" for string, "i" for integers
    $stmt->bind_param("sii", $muscle_name, $weight_lifted, $time_spent);
    
    if ($stmt->execute()) {
        echo "Record inserted successfully.";
    } else {
        echo "Error inserting record: " . $stmt->error;
    }
    
    $stmt->close();
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] == 'fetch') {
    // Fetch the last 10 entries from the database
    $result = $mysqli->query("SELECT muscle_name, weight_lifted, time_spent FROM muscle_data ORDER BY id DESC LIMIT 10");

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Log the data to PHP error log for debugging
    error_log(print_r($data, true));

    // Send the data back as JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    // For direct access or other request types, do nothing
    exit; // This ensures no output is sent for direct access
}

// Close the connection
$mysqli->close();
?>
