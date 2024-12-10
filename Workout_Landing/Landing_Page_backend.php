<?php
header('Content-Type: application/json');
session_start(); // Start session to manage tokens

// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost"; // Update with your server name
$username = "richiezh"; // Update with your database username
$password = "50360501"; // Update with your database password
$dbname = "cse442_2024_fall_team_m_db"; // Update with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Helper function to sanitize input
function sanitize_input($data, $conn) {
    return $conn->real_escape_string(trim($data));
}
// Function to retrieve the user ID from the cookie
function get_user_id_from_cookie($conn) {
    if (!isset($_COOKIE['Authentication_Token']) || empty($_COOKIE['Authentication_Token'])) {
        echo json_encode(['error' => 'No Authentication_Token found.']);
        exit;
    }
    return sanitize_input($_COOKIE['Authentication_Token'], $conn); // Return user ID directly from the cookie
}

// Function to check if user is authenticated
function is_user_authenticated($conn) {
    $userId = get_user_id_from_cookie($conn);
    // Check if user exists in the database
    $sql = "SELECT COUNT(*) as count FROM user_profiles WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    return $row['count'] > 0; // Return true if user exists
}

// Handle GET request to check authentication status
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (is_user_authenticated($conn)) {
        echo json_encode(['authenticated' => true]);
    } else {
        echo json_encode(['authenticated' => false]);
    }
}

// Function to delete the token cookie
function delete_token_cookie() {
    setcookie('Authentication_Token', '', time() - 3600, '/', '.cse.buffalo.edu', true, true); // Expire cookie
    unset($_SESSION['auth_token']); // Remove token from session
    unset($_SESSION['username']);   // Remove username from session
}

// Handle DELETE request to log out the user
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    delete_token_cookie(); // Call the function from Profile backend
    echo json_encode(['success' => true]);
}

// Close database connection
$conn->close();
?>
