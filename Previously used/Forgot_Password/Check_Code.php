<?php
session_start();

$servername = "localhost:3306";
$user = "dashawne";
$pass = "50449651";
$database = "cse442_2024_fall_team_m_db";

// Create a connection
$conn = new mysqli($servername, $user, $pass, $database);

// Check if connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_code = $_POST['code'];
    $new_password = $_POST['password'];

    // Escape user input to prevent SQL injection
    $entered_code = $conn->real_escape_string($entered_code);
    $new_password = $conn->real_escape_string($new_password);

    // Prepare and execute the SQL query to retrieve the one-time code, email, and timestamp
    $stmt = $conn->prepare("SELECT `Email`, `Code`, `Timestamp` FROM `Reset_Password_Table` WHERE `Code` IS NOT NULL");
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $valid_code_found = false; // A flag to check if any valid code is found
        while ($row = $result->fetch_assoc()) {
            $hashed_code = $row['Code'];
            $timestamp = $row['Timestamp'];
            $email = $row['Email'];  // Use this email to update the password later

            // Check if the one-time code has expired (e.g., 15 minutes)
            $current_time = new DateTime();
            $expiry_time = new DateTime($timestamp);
            $expiry_time->modify('+15 minutes'); // Expiry time set to 15 minutes

            // Verify the entered one-time code with the hashed code
            if (password_verify($entered_code, $hashed_code)) {
                $valid_code_found = true;

                if ($current_time > $expiry_time) {
                    header("Location: https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Forgot/ResetPassword.php?error=The one-time code has expired. Please request a new one.");
                    exit();
                }

                // Code is valid and not expired
                $_SESSION['new_password'] = password_hash($new_password, PASSWORD_BCRYPT);
                $_SESSION['email'] = $email;
                header("Location: https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Forgot/ReEnter.php");
                exit();
            }
        }
        
        // If no valid code was found after looping through results
        if (!$valid_code_found) {
            header("Location: https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Forgot/ResetPassword.php?error=The one-time code is incorrect. Please try again.");
            exit();
        }
    } else {
        header("Location: https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Forgot/ResetPassword.php?error=No reset codes found.");
        exit();
    }
}

// Close the database connection
$conn->close();
?>