
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

$dbname = "cse442_2024_fall_m_db"; // Update with your database name


$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Helper function to sanitize input
function sanitize_input($data, $conn) {
    return $conn->real_escape_string(trim($data));
}

// Function to delete the token cookie
function delete_token_cookie() {
    setcookie('Authentication_Token', '', time() - 3600, '/', '.cse.buffalo.edu', true, true); // Expire cookie
    unset($_SESSION['auth_token']); // Remove token from session
    unset($_SESSION['username']);   // Remove username from session
}

// Function to retrieve the user ID from the cookie
function get_user_id_from_cookie($conn) {
    if (!isset($_COOKIE['Authentication_Token']) || empty($_COOKIE['Authentication_Token'])) {
        echo json_encode(['error' => 'No Authentication_Token found.']);
        exit;
    }

    // Assuming the cookie stores the user ID directly
    return sanitize_input($_COOKIE['Authentication_Token'], $conn); // Return user ID directly from the cookie
}

// Fetch user data by ID
function get_user_data_by_id($conn) {
    // Get user ID from the cookie
    $userId = get_user_id_from_cookie($conn);

    // Query to get user data from the database
    $sql = "SELECT id, username, email, name, age, profile_pic FROM user_profiles WHERE id = ?"; // Include id in the selection
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo json_encode(['error' => 'Database error: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("s", $userId); // Bind ID as string (VARCHAR)
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
        $userData['userId'] = $userData['id']; // Add userId to the response
        unset($userData['id']); // Remove 'id' if you want to keep the response clean

        echo json_encode($userData);
    } else {
        echo json_encode(['error' => 'User not found.']);
    }

    $stmt->close();
}


// Handle GET request to retrieve user profile data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // If a specific user ID is passed as a GET parameter, use it
    if (isset($_GET['userId']) && is_numeric($_GET['userId'])) {
        $userId = intval($_GET['userId']);
        
        // Prepare and execute the query to get user data
        $sql = "SELECT id, username, email, name, age, profile_pic FROM user_profiles WHERE id = ?"; // Include id in the selection
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            echo json_encode(['error' => 'Database error: ' . $conn->error]);
            exit;
        }

        $stmt->bind_param("s", $userId); // Bind ID as string (VARCHAR)
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $userData = $result->fetch_assoc();
            $userData['userId'] = $userData['id']; // Add userId to the response
            unset($userData['id']); // Remove 'id' if you want to keep the response clean
            echo json_encode($userData);
        } else {
            echo json_encode(['error' => 'User not found.']);
        }

        $stmt->close();
    } else {
        // If no user ID is passed, retrieve data using the cookie
        get_user_data_by_id($conn);
    }
}


// Handle POST request to update user profile data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate data

    if (isset($data['username'], $data['email'], $data['name'], $data['age'], $data['profile_pic'])) {
        // Get user ID from cookie
        $userId = get_user_id_from_cookie($conn);
        
        // Sanitize inputs
        $username = sanitize_input($data['username'], $conn);
        $email = sanitize_input($data['email'], $conn);
        $name = sanitize_input($data['name'], $conn);
        $age = intval($data['age']);
        $profile_pic = sanitize_input($data['profile_pic'], $conn);

        // Log received profile_pic for debugging
        error_log("Received profile_pic: " . $profile_pic);

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['error' => 'Invalid email format.']);
            exit;
        }

        // Validate name (only letters and spaces)
        if (!preg_match("/^[A-Za-z\s]+$/", $name)) {
            echo json_encode(['error' => 'Invalid name. Only letters and spaces are allowed.']);
            exit;
        }


        // Update query
        $sql = "UPDATE user_profiles SET username = ?, email = ?, name = ?, age = ?, profile_pic = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            echo json_encode(['error' => 'Database error: ' . $conn->error]);
            exit;
        }

        // Corrected bind_param with userId included
        $stmt->bind_param("ssssss", $username, $email, $name, $age, $profile_pic, $userId);


        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Error updating profile: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Invalid input data.']);
    }
}


// Handle DELETE request to log out the user and delete the token cookie
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    delete_token_cookie(); // Delete the authentication token
    echo json_encode(['success' => true]);
}

$conn->close();
?>

