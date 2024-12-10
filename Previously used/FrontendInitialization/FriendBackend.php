<?php       
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "localhost";
$username = "richiezh";
$password = "50360501";
$dbname = "richiezh_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    error_log("Connection error: " . $conn->connect_error);
    die(json_encode(['error' => $conn->connect_error]));
}

// Check if the Authentication_Token cookie is set
if (!isset($_COOKIE['Authentication_Token'])) {
    header('Location: https://se-dev.cse.buffalo.edu/CSE442/2024-Fall/richiezh/Login.php');
    exit();
}

// Get the current user's ID based on the token
$token = $_COOKIE['Authentication_Token'];

$sql = "SELECT id, username FROM user_profiles WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $currentUser = $result->fetch_assoc();
    $currentUserId = $currentUser['id'];
    $currentUsername = $currentUser['username'];
} else {
    echo json_encode(['error' => 'Current user not found.']);
    exit();
}

// Initialize response array
$response = [];

// Handle friend requests or incoming requests
$data = json_decode(file_get_contents("php://input"), true);

// Add Friend Request
if (isset($data['action']) && $data['action'] === 'addFriend' && isset($data['username'])) {
    $friendUsername = $conn->real_escape_string($data['username']);
    $sql = "SELECT id FROM user_profiles WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $friendUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $friendId = $result->fetch_assoc()['id'];
        if ($currentUserId === $friendId) {
            $response['error'] = 'You cannot send a friend request to yourself.';
        } else {
            // Check if already friends or has sent/received a request
            $sql = "SELECT * FROM friends WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $currentUserId, $friendId, $friendId, $currentUserId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                // Insert new friend request
                $sql = "INSERT INTO friends (user_id, friend_id, status) VALUES (?, ?, 'pending')";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $currentUserId, $friendId);
                $stmt->execute();
                $response['success'] = 'Friend request sent!';
            } else {
                $response['error'] = 'Friend request already exists.';
            }
        }
    } else {
        $response['error'] = 'User not found.';
    }
}

// Load Incoming Friend Requests
if (isset($data['action']) && $data['action'] === 'getIncomingRequests') {
    $sql = "SELECT f.id, u.username FROM friends f JOIN user_profiles u ON f.user_id = u.id WHERE f.friend_id = ? AND f.status = 'pending'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $currentUserId);
    $stmt->execute();
    $result = $stmt->get_result();
    $incomingRequests = [];

    while ($row = $result->fetch_assoc()) {
        $incomingRequests[] = $row;
    }

    if (!empty($incomingRequests)) {
        $response['incomingRequests'] = $incomingRequests;
    } else {
        $response['message'] = 'No incoming requests found.';
    }
}

// Accept Friend Request
if (isset($data['action']) && $data['action'] === 'acceptFriendRequest' && isset($data['requestId'])) {
    $requestId = $conn->real_escape_string($data['requestId']);
    
    // Get the details of the friend request
    $sql = "SELECT user_id, friend_id FROM friends WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $requestId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $friendRequest = $result->fetch_assoc();
        $requesterId = $friendRequest['user_id']; // The user who sent the request
        $acceptorId = $friendRequest['friend_id']; // The user who accepted the request
        
        // Update the original request status to accepted
        $sql = "UPDATE friends SET status = 'accepted' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $requestId);
        if ($stmt->execute()) {
            // Add the reciprocal relationship to the friends table
            $sql = "INSERT INTO friends (user_id, friend_id, status) VALUES (?, ?, 'accepted')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $acceptorId, $requesterId); // Add the acceptor as a friend of the requester
            $stmt->execute();
            
            $response['success'] = 'Friend request accepted.';
        } else {
            $response['error'] = 'Failed to accept friend request.';
        }
    } else {
        $response['error'] = 'Friend request not found.';
    }
}

// Reject Friend Request
if (isset($data['action']) && $data['action'] === 'rejectFriendRequest' && isset($data['requestId'])) {
    $requestId = $conn->real_escape_string($data['requestId']);
    
    // Check if the request exists before deleting
    $sql = "SELECT * FROM friends WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $requestId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $sql = "DELETE FROM friends WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $requestId);
        if ($stmt->execute()) {
            $response['success'] = 'Friend request rejected.';
        } else {
            $response['error'] = 'Failed to reject friend request: ' . $stmt->error; // Log error
        }
    } else {
        $response['error'] = 'Friend request not found.';
    }
}

// Load Friends
if (isset($data['action']) && $data['action'] === 'getFriends') {
    $sql = "SELECT u.username FROM friends f JOIN user_profiles u ON f.friend_id = u.id WHERE f.user_id = ? AND f.status = 'accepted'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $currentUserId);
    $stmt->execute();
    $result = $stmt->get_result();
    $friends = [];

    while ($row = $result->fetch_assoc()) {
        $friends[] = $row;
    }

    if (!empty($friends)) {
        $response['friends'] = $friends;
    } else {
        $response['message'] = 'No friends found.';
    }
}

// Load accepted friends list
if (isset($data['action']) && $data['action'] === 'getAcceptedFriends') {
    $sql = "SELECT u.username FROM friends f JOIN user_profiles u ON f.friend_id = u.id WHERE f.user_id = ? AND f.status = 'accepted'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $currentUserId);
    $stmt->execute();
    $result = $stmt->get_result();
    $acceptedFriends = [];

    while ($row = $result->fetch_assoc()) {
        $acceptedFriends[] = $row;
    }

    if (!empty($acceptedFriends)) {
        $response['acceptedFriends'] = $acceptedFriends;
    } else {
        $response['message'] = 'No accepted friends found.';
    }
}

// Automatically update friend_id on logout
if (isset($_COOKIE['Authentication_Token'])) {
    // Retrieve the new user ID from the token
    $newToken = $_COOKIE['Authentication_Token'];

    // Get the new user's ID
    $sql = "SELECT id FROM user_profiles WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $newToken);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $newUserId = $result->fetch_assoc()['id'];

        // Update friend_id in the friends table for the new user
        $sql = "UPDATE friends SET friend_id = ? WHERE friend_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $newUserId, $currentUserId);
        $stmt->execute();
    }
}

// Close the statement and connection
$stmt->close();
$conn->close();

// Output response
echo json_encode($response);
?>
