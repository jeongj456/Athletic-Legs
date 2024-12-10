<?php
include '../Workout_Login/Verify_Account.php';
session_start();
if ($_SERVER['HTTP_X_CSRF_TOKEN'] != $_SESSION['csrf_token']) {
    echo ('Fail');
    exit();
}
$data = json_decode(file_get_contents("php://input"), true);
$username = $data['blockedUsername'];
$blocked_by_user = UserEmailFromID($_COOKIE['Authentication_Token']); // Assuming you store the logged-in user's email in the session

// Database connection
$conn = new mysqli("localhost", "djgage", "50493464", "cse442_2024_fall_team_m_db");
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

// Get the email of the user to block
$stmt = $conn->prepare("SELECT Email FROM User_Accounts_Table WHERE Username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user_to_block = $result->fetch_assoc()['Email'];

if (!$user_to_block) {
    echo json_encode(['success' => false, 'message' => 'User not found']);
    exit();
}

// Insert block relationship if not already blocked
$stmt = $conn->prepare("INSERT IGNORE INTO Blocked_Users (Blocked_By_User, Blocked_User) VALUES (?, ?)");
$stmt->bind_param("ss", $blocked_by_user, $user_to_block);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'User blocked successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error blocking user']);
}

$stmt->close();
$conn->close();
?>
