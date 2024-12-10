<?php

$servername = "localhost:3306";
$user = "dashawne";
$pass = "50449651";
$database = "cse442_2024_fall_team_m_db";


// Function to receive user email from the ID in the current Authentication_Token
function UserEmailFromID($token) {
    global $servername, $user, $pass, $database; 
    
    $conn = new mysqli($servername, $user, $pass, $database);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT `Email` FROM `User_Accounts_Table` WHERE `id` = ?";
    
    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $conn->close();
        return $row['Email']; // Return the user's email
    } else {
        $conn->close();
        return null; // Token not found
    }
}


?>