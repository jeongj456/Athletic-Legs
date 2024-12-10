<?php

$servername = "localhost:3306";
$username = "dashawne";
$password = "50449651";
$database = "cse442_2024_fall_team_m_db";
// $database = "dashawne_db";


header('Content-Type: application/json');


// Function to create a database connection
function DatabaseConnection($servername, $username, $password, $database) {
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
    }
    return $conn;
}


// Function to remove a current friend
function removeFriend($conn, $currentUser, $friendUsername) {

    // Prepare SQL to delete current friend
    $stmt = $conn->prepare("
        DELETE FROM Friends_Table
        WHERE (Sent_Request = ? AND Received_Request = ?)
        OR (Sent_Request = ? AND Received_Request = ?)
    ");
    $stmt->bind_param("ssss", $currentUser, $friendUsername, $friendUsername, $currentUser);
    $stmt->execute();
    $stmt->close();
}


// Function to get friends' workouts weights
function viewFriendWorkouts($conn, $friendUsername) {
    $friendEmail = EmailFromUsername($conn, $friendUsername);

    // SQL query to fetch workout_results and workout_date for the friend
    $sql = "SELECT Workout_Results, Workout_Date 
            FROM planned_workouts_FULL 
            WHERE Creator_ID = ? AND Deleted = 0
            ORDER BY Workout_Date DESC";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL statement preparation failed: " . $conn->error);
    }

    $stmt->bind_param("s", $friendEmail);
    $stmt->execute();

    $result = $stmt->get_result();
    // $numbers = [];

    if ($result->num_rows > 0) {
        $workoutDictionary = [];
    
        while ($row = $result->fetch_assoc()) {
            $workoutResults = $row['Workout_Results'];
            $workoutDate = $row['Workout_Date'];

            $formattedDate = (new DateTime($workoutDate))->format('m-d-Y');

            $theseworkouts = preg_split('/\+_\\)\\(\\*&\\^%/', $workoutResults);
    
            foreach ($theseworkouts as $work) {
                // Split the section by commas
                $parts = explode(',', $work);
    
                $currentName = null;
                $currentEntry = [];
                foreach ($parts as $part) {
                    if (preg_match('/[a-zA-Z]/', $part)) {
                        $currentName = $part;
                        $currentEntry['name'] = $currentName;
                        $currentEntry['date'] = $formattedDate;
                        $currentEntry['numbers'] = [];
                    } elseif (is_numeric($part)) {
                        if ($currentName !== null) {
                            $currentEntry['numbers'][] = $part;
                        }
                    }
                }

                if (!empty($currentEntry)) {
                    $workoutDictionary[] = $currentEntry; 
                }
            }
        }

    }

    // Close the statement
    $stmt->close();
    // return $names;
    // return $numbers;
    return $workoutDictionary;

}


// Function to get friends' workouts cardio
function viewFriendWorkoutsCardio($conn, $friendUsername) {
    $friendEmail = EmailFromUsername($conn, $friendUsername);

    // SQL query to fetch workout_results and workout_date for the friend
    $sql = "SELECT Workout_Results, Workout_Date 
            FROM planned_cardio_FULL 
            WHERE Creator_ID = ? AND Deleted = 0
            ORDER BY Workout_Date DESC";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL statement preparation failed: " . $conn->error);
    }

    $stmt->bind_param("s", $friendEmail);
    $stmt->execute();

    $result = $stmt->get_result();
    // $numbers = [];

    if ($result->num_rows > 0) {
        $workoutDictionary = []; 
    
        while ($row = $result->fetch_assoc()) {
            // Get the workout_results string and date
            $workoutResults = $row['Workout_Results'];
            $workoutDate = $row['Workout_Date'];

            $formattedDate = (new DateTime($workoutDate))->format('m-d-Y');
    
            // Split workout results by delimiter
            $theseworkouts = preg_split('/\+_\\)\\(\\*&\\^%/', $workoutResults);
    
            foreach ($theseworkouts as $work) {
                // Split the section by commas
                $parts = explode(',', $work);
    
                $currentName = null;
                $currentEntry = []; 
                foreach ($parts as $part) {
                    if (preg_match('/[a-zA-Z]/', $part)) {
                        $currentName = $part;
                        $currentEntry['name'] = $currentName;
                        $currentEntry['date'] = $formattedDate;
                        $currentEntry['numbers'] = [];
                    } elseif (is_numeric($part)) {
                        if ($currentName !== null) {
                            $currentEntry['numbers'][] = $part;
                        }
                    }
                }

                if (!empty($currentEntry)) {
                    $workoutDictionary[] = $currentEntry; 
                }
            }
        }
    

    }

    // Close the statement
    $stmt->close();
    // return $names;
    // return $numbers;
    return $workoutDictionary;

}


// Function to get user username from ID token
function UserUsernameFromID($conn, $token) {
    $sql = "SELECT `Username` FROM `User_Accounts_Table` WHERE `id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['Username'];
    } else {
        return null;
    }
}


// Function to get user Name from ID token
function UserNAMEFromID($conn, $token) {
    $sql = "SELECT `name` FROM `user_profiles` WHERE `id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['name'];
    } else {
        return null;
    }
}



// Function to get user username from email
function UsernameFromEmail($conn, $email) {

    $sql = "SELECT `Username` FROM `User_Accounts_Table` WHERE `Email` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['Username'];
    } else {
        return null;
    }

}


// Function to get user email from username
function EmailFromUsername($conn, $username) {

    $sql = "SELECT `Email` FROM `User_Accounts_Table` WHERE `Username` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['Email'];
    } else {
        return null;
    }

}

// AND username NOT IN (
//     SELECT Received_Request 
//     FROM Friends_Table 
//     WHERE Sent_Request = ? AND Status = 'Accepted'
// )
// AND username NOT IN (
//     SELECT Sent_Request 
//     FROM Friends_Table 
//     WHERE Received_Request = ? AND Status = 'Accepted'
// )
// AND username NOT IN (
//     SELECT Sent_Request 
//     FROM Friends_Table 
//     WHERE Received_Request = ? AND Status = 'Pending'
// )
// AND username NOT IN (
//     SELECT Received_Request 
//     FROM Friends_Table 
//     WHERE Sent_Request = ? AND Status = 'Pending'
// )

// Function to search users by query user typed in
function searchUsers($conn, $query, $currentUsername) {

    $currentEmail = EmailFromUsername($conn, $currentUsername);
    
    // Prepare the SQL statement to search for usernames that match the query
    $stmt = $conn->prepare("
        SELECT username, profile_pic 
        FROM user_profiles 
        WHERE username LIKE ? 
        AND username != ?
    ");
    $searchTerm = "%" . $query . "%";
    $stmt->bind_param("ss", $searchTerm, $currentUsername);

    // Execute the query and get the results
    $stmt->execute();
    $result = $stmt->get_result();

    $users = []; // Initialize the users array

    while ($row = $result->fetch_assoc()) {
        // Prepare a separate statement to get the status from Friends_Table
        $stat = $conn->prepare("
            SELECT Status 
            FROM Friends_Table
            WHERE (Sent_Request = ? AND Received_Request = ?)
               OR (Sent_Request = ? AND Received_Request = ?)
        ");
        $stat->bind_param("ssss", $row['username'], $currentUsername, $currentUsername, $row['username']);

        // Execute the status query
        $stat->execute();
        $statusResult = $stat->get_result();

        // Set status to default if no row is found
        $status = $statusResult->num_rows > 0 ? $statusResult->fetch_assoc()['Status'] : 'None';

        // Add user data including status to the users array
        $users[] = [
            'username' => $row['username'],
            'profile_pic' => $row['profile_pic'],
            'status' => $status,
            'email' => EmailFromUsername($conn, $row['username'])
        ];

        $stat->close(); // Close the status query statement
    }

    $filteredUsers = [];

    foreach ($users as $user) {
        // Check if the user is blocked by the current user or has blocked the current user
        if (!isBlocked($currentEmail, $user['email'])) {
            // If not blocked, add to the filtered users array
            $filteredUsers[] = $user;
        }
    }

    $users = $filteredUsers;


    $stmt->close(); // Close the main query statement

    return $users;
}

// Helper function to check if the user is blocked by the current user or has blocked the current user
function isBlocked($currentEmail, $userEmail) {
    global $conn;

    // Query to check if the current user has blocked the other user
    $stmt = $conn->prepare("
        SELECT 1 
        FROM Blocked_Users 
        WHERE (Blocked_By_User = ? AND Blocked_User = ?) 
           OR (Blocked_By_User = ? AND Blocked_User = ?)
    ");
    $stmt->bind_param("ssss", $currentEmail, $userEmail, $userEmail, $currentEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows > 0; // Return true if blocked in either direction, otherwise false
}



// Function to send a friend request (Insertion into table)
function sendFriendRequest($conn, $username) {
    // Retrieve the current user's username
    $token = $_COOKIE["Authentication_Token"];
    $currentUsername = UserUsernameFromID($conn, $token);

    if ($currentUsername) {
        // Prepare the SQL statement to insert the friend request
        $stmt = $conn->prepare("INSERT INTO Friends_Table (Sent_Request, Received_Request, Status) VALUES (?, ?, ?)");
        $status = "Pending";
        $stmt->bind_param("sss", $currentUsername, $username, $status);

        if ($stmt->execute()) {
            $stmt->close();
        } else {
            $stmt->close();
            return ["error" => "Failed to send friend request"];
        }
    } else {
        return ["error" => "User not found"];
    }
}


// Function to block a user (Insertion into table Blocked_Users)
function blockUser($conn, $username) {
    // Retrieve the current user's username
    $token = $_COOKIE["Authentication_Token"];
    $currentUsername = UserUsernameFromID($conn, $token);
    $currentEmail = EmailFromUsername($conn, $currentUsername);
    $otherEmail = EmailFromUsername($conn, $username);

    if ($currentEmail && $otherEmail) {
        // Delete any friend requests or accepted friend relationships between the users
        $deleteStmt = $conn->prepare("
            DELETE FROM Friends_Table 
            WHERE (Sent_Request = ? AND Received_Request = ?) 
               OR (Sent_Request = ? AND Received_Request = ?)
        ");
        $deleteStmt->bind_param("ssss", $currentUsername, $username, $username, $currentUsername);

        // Execute the deletion
        if ($deleteStmt->execute()) {
            $deleteStmt->close();

            // Insert the block into Blocked_Users table
            $stmt = $conn->prepare("INSERT INTO Blocked_Users (Blocked_By_User, Blocked_User) VALUES (?, ?)");
            $stmt->bind_param("ss", $currentEmail, $otherEmail);

            if ($stmt->execute()) {
                $stmt->close();
                return ["success" => "User blocked and friend records removed"];
            } else {
                $stmt->close();
                return ["error" => "Failed to block user"];
            }
        } else {
            $deleteStmt->close();
            return ["error" => "Failed to remove friend records"];
        }
    } else {
        return ["error" => "User not found"];
    }
}


// Function to get pending friend requests FROM
function getPendingRequests($conn, $currentUsername) {
    $stmt = $conn->prepare("SELECT Sent_Request FROM Friends_Table WHERE Received_Request = ? AND Status = 'Pending'");
    $stmt->bind_param("s", $currentUsername);

    $stmt->execute();
    $result = $stmt->get_result();

    $pendingRequests = [];
    while ($row = $result->fetch_assoc()) {
        $pendingRequests[] = $row['Sent_Request'];
    }

    $stmt->close();
    return $pendingRequests;
}


// Function to get pending friend requests TO
function getPendingRequests_WAIT($conn, $currentUsername) {
    $stmt = $conn->prepare("SELECT Received_Request FROM Friends_Table WHERE Sent_Request = ? AND Status = 'Pending'");
    $stmt->bind_param("s", $currentUsername);

    $stmt->execute();
    $result = $stmt->get_result();

    $pendingRequests_WAIT = [];
    while ($row = $result->fetch_assoc()) {
        $pendingRequests_WAIT[] = $row['Received_Request'];
    }

    $stmt->close();
    return $pendingRequests_WAIT;
}


function getBlockedUsers($conn, $currentUsername) {
    $email = EmailFromUsername($conn, $currentUsername);
    $stmt = $conn->prepare("SELECT Blocked_User FROM Blocked_Users WHERE Blocked_By_User = ?");
    $stmt->bind_param("s", $email);

    $stmt->execute();
    $result = $stmt->get_result();

    $blockedUsers = [];
    while ($row = $result->fetch_assoc()) {
        $blockedUsers[] = UsernameFromEmail($conn, $row['Blocked_User']);
    }

    $stmt->close();
    return $blockedUsers;
}


// Function to handle friend requests (accept or reject)
function handleFriendRequest($conn, $currentUsername, $username, $responseAction) {
    // Action (accept or reject)
    if ($responseAction !== 'Accept' && $responseAction !== 'Reject' && $responseAction !== 'cancel') {
        return ["error" => "Invalid action"];
    }

    // Update the status of the friend request
    if ($responseAction === 'Accept') {
        $stmt = $conn->prepare("UPDATE Friends_Table SET Status = 'Accepted' WHERE Sent_Request = ? AND Received_Request = ?");
    } else if ($responseAction === 'Reject') {
        $stmt = $conn->prepare("UPDATE Friends_Table SET Status = 'Rejected' WHERE Sent_Request = ? AND Received_Request = ?");
    } else if ($responseAction === 'cancel') {
        $stmt = $conn->prepare("UPDATE Friends_Table SET Status = 'Rejected' WHERE Received_Request = ? AND Sent_Request = ?");
    }

    $stmt->bind_param("ss", $username, $currentUsername);

    if ($stmt->execute()) {
        if ($responseAction === 'Reject') {
            deleteRejectedRequest($conn, $username, $currentUsername);
        }
        if ($responseAction === 'cancel') {
            deleteRejectedRequest_AWAITING($conn, $username, $currentUsername);
        }
        $stmt->close();
        return ["success" => "Friend request " . strtolower($responseAction) . "ed"];
    } else {
        $stmt->close();
        return ["error" => "Failed to update friend request status"];
    }
}


// Function to delete rejected friend request
function deleteRejectedRequest($conn, $username, $currentUsername) {
    $stmt = $conn->prepare("DELETE FROM Friends_Table WHERE Sent_Request = ? AND Received_Request = ? AND Status = 'Rejected'");
    $stmt->bind_param("ss", $username, $currentUsername);
    $stmt->execute();
    $stmt->close();
}


function deleteRejectedRequest_AWAITING($conn, $username, $currentUsername) {
    $stmt = $conn->prepare("DELETE FROM Friends_Table WHERE Received_Request = ? AND Sent_Request = ? AND Status = 'Rejected'");
    $stmt->bind_param("ss", $username, $currentUsername);
    $stmt->execute();
    $stmt->close();
}


// Function to get accepted friends
function getAcceptedFriends($conn, $currentUsername) {
    $usernames = [];

    // Fetch friends where the current user is the sender
    $stmt = $conn->prepare("SELECT Received_Request FROM Friends_Table WHERE Sent_Request = ? AND Status = 'Accepted'");
    $stmt->bind_param("s", $currentUsername);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $usernames[] = $row['Received_Request'];
    }
    $stmt->close();

    // Fetch friends where the current user is the receiver
    $stmt = $conn->prepare("SELECT Sent_Request FROM Friends_Table WHERE Received_Request = ? AND Status = 'Accepted'");
    $stmt->bind_param("s", $currentUsername);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $usernames[] = $row['Sent_Request'];
    }
    $stmt->close();

    // Fetch profile data for each accepted friend
    $acceptedFriends = [];
    foreach ($usernames as $username) {
        $stmt = $conn->prepare("SELECT username, profile_pic, name FROM user_profiles WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $acceptedFriends[] = [
                'username' => $row['username'],
                'profile_pic' => $row['profile_pic'],
                'name' => $row['name']
            ];
        }
        $stmt->close();
    }

    return $acceptedFriends;
}





// Function to unblock users
function unblockUser($conn, $username) {
    // Retrieve the current user's username
    $token = $_COOKIE["Authentication_Token"];
    $currentUsername = UserUsernameFromID($conn, $token);
    $currentEmail = EmailFromUsername($conn, $currentUsername);
    $otherEmail = EmailFromUsername($conn, $username);

    if ($currentEmail && $otherEmail) {
        // Delete the block rom the Blocked_Users table
        $deleteBlockStmt = $conn->prepare("
            DELETE FROM Blocked_Users 
            WHERE Blocked_By_User = ? AND Blocked_User = ?
        ");
        $deleteBlockStmt->bind_param("ss", $currentEmail, $otherEmail);

        // Execute the deletion
        if ($deleteBlockStmt->execute()) {
            $deleteBlockStmt->close();
            return ["success" => "unblocked"];
        } else {
            $deleteBlockStmt->close();
            return ["error" => "Failed to unblock user"];
        }
    } else {
        return ["error" => "User not found"];
    }
}

























$conn = DatabaseConnection($servername, $username, $password, $database);

if (isset($_GET['action'])) {

    if ($_GET['action'] === 'searchUsers' && isset($_GET['query'])) {
        $query = $_GET['query'];
        $token = $_COOKIE["Authentication_Token"];
        $currentUsername = UserUsernameFromID($conn, $token);
        if ($currentUsername) {
            $usernames = searchUsers($conn, $query, $currentUsername);
            echo json_encode($usernames);
        } else {
            echo json_encode(["error" => "User not found"]);
        }
    } 

    elseif ($_GET['action'] === 'sendFriendRequest' && isset($_GET['username'])) {
        $username = $_GET['username'];
        $response = sendFriendRequest($conn, $username);
        echo json_encode($response);
    } 

    elseif ($_GET['action'] === 'blockUser' && isset($_GET['username'])) {
        $username = $_GET['username'];
        $response = blockUser($conn, $username);
        echo json_encode($response);
    } 
    
    elseif ($_GET['action'] === 'getPendingRequests') {
        $token = $_COOKIE["Authentication_Token"];
        $currentUsername = UserUsernameFromID($conn, $token);
        if ($currentUsername) {
            $pendingRequests = getPendingRequests($conn, $currentUsername);
            echo json_encode($pendingRequests);
        } else {
            echo json_encode(["error" => "User not found"]);
        }
    } 

    elseif ($_GET['action'] === 'BlockedUsers') {
        $token = $_COOKIE["Authentication_Token"];
        $currentUsername = UserUsernameFromID($conn, $token);
        
        if ($currentUsername) {
            $blockedUsers = getBlockedUsers($conn, $currentUsername);
            echo json_encode($blockedUsers);
        } else {
            echo json_encode(["error" => "User not found"]);
        }
    } 
    
    elseif ($_GET['action'] === 'getPendingRequestsWAIT') {
        $token = $_COOKIE["Authentication_Token"];
        $currentUsername = UserUsernameFromID($conn, $token);
        if ($currentUsername) {
            $pendingRequests_WAIT = getPendingRequests_WAIT($conn, $currentUsername);
            echo json_encode($pendingRequests_WAIT);
        } else {
            echo json_encode(["error" => "User not found"]);
        }
    } 
    
    elseif ($_GET['action'] === 'handleFriendRequest' && isset($_GET['username']) && isset($_GET['responseAction'])) {
        $username = $_GET['username'];
        $responseAction = $_GET['responseAction'];
        
        // Get the current user's username from the authentication token
        $token = $_COOKIE["Authentication_Token"];
        $currentUsername = UserUsernameFromID($conn, $token);

        if ($currentUsername) {
            $response = handleFriendRequest($conn, $currentUsername, $username, $responseAction);
            echo json_encode($response);
        }

    } 







    elseif ($_GET['action'] === 'unblockUser' && isset($_GET['username'])) {
        $username = $_GET['username'];

        $response = unblockUser($conn, $username);
        echo json_encode($response);
        
        // Get the current user's username from the authentication token
        // $token = $_COOKIE["Authentication_Token"];
        // $currentUsername = UserUsernameFromID($conn, $token);

        // if ($currentUsername) {
        //     $response = handleFriendRequest($conn, $currentUsername, $username, $responseAction);
        //     echo json_encode($response);
        // }

    } 





    
    
    elseif (isset($_GET['action']) && $_GET['action'] === 'getAcceptedFriends') {
        $token = $_COOKIE["Authentication_Token"];
        $currentUsername = UserUsernameFromID($conn, $token);
        if ($currentUsername) {
            $acceptedFriends = getAcceptedFriends($conn, $currentUsername);
            echo json_encode($acceptedFriends);
        } else {
            echo json_encode(["error" => "User not found"]);
        }
    } 
    
    elseif ($_GET['action'] === 'getLoggedInName') {
        $token = $_COOKIE["Authentication_Token"];
        $name = UserNAMEFromID($conn, $token);
        if ($name) {
            echo json_encode($name);
        } else {
            echo json_encode(["error" => "User not found"]);
        }
    }

    elseif ($_GET['action'] === 'removeFriend' && isset($_GET['friendUser'])) {
        $token = $_COOKIE["Authentication_Token"];
        $name = UserUsernameFromID($conn, $token);
        $friendUsername = $_GET['friendUser'];

        removeFriend($conn, $name, $friendUsername);

        if ($name && $friendUsername) {
            echo json_encode(["Success" => "Friend Found"]);
        } else {
            echo json_encode(["error" => "User not found"]);
        }
    }


    elseif ($_GET['action'] === 'viewWorkouts' && isset($_GET['friendUser'])) {
        $friendUsername = $_GET['friendUser'];

        if ($friendUsername) {
            $workouts = viewFriendWorkouts($conn, $friendUsername);
            echo json_encode($workouts);
            // echo json_encode(["Success" => "Friend Found"]);
        } else {
            echo json_encode(["error" => "User not found"]);
        }

    }

    elseif ($_GET['action'] === 'viewWorkoutsCardio' && isset($_GET['friendUser'])) {
        $friendUsername = $_GET['friendUser'];

        if ($friendUsername) {
            $workouts = viewFriendWorkoutsCardio($conn, $friendUsername);
            echo json_encode($workouts);
            // echo json_encode(["Success" => "Friend Found"]);
        } else {
            echo json_encode(["error" => "User not found"]);
        }

    }

    
    else {
        echo json_encode(["error" => "Invalid action or missing parameters"]);
    }

} else {
    echo json_encode(["error" => "Action parameter is missing"]);
} 

// Close the database connection
$conn->close();

?>
