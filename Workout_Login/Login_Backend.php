<?php

$servername = "localhost:3306";
$user = "dashawne";
$pass = "50449651";
$database = "cse442_2024_fall_team_m_db";

// Remote database credentials
$servername_r = "localhost:3306";
$user_r = "richiezh";
$pass_r = "50360501";
$database_r = "cse442_2024_fall_team_m_db"; 

// Function to receive user email from the ID in the current Authentication_Token
function UserEmailFromID($token) {
    global $servername, $user, $pass, $database; // Use global variables

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

// Create connection
$conn = new mysqli($servername, $user, $pass, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve hashed password from the database
    $sql = "SELECT `Password` FROM `User_Accounts_Table` WHERE `Username` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['Password'];

        // Verify the entered password with the hashed password
        if (password_verify($password, $hashedPassword)) {
            session_start();
            $_SESSION['username'] = $username;

            $token = bin2hex(random_bytes(32)); // Generate a secure random token
            setcookie("Authentication_Token", $token, time() + (432000), "/", ".cse.buffalo.edu", true); // 5 days for the cookie

            $csrf_token0 = bin2hex(random_bytes(32));

            // Update user's token in User_Accounts_Table
            $sql_update = "UPDATE `User_Accounts_Table` SET `id` = ?, `csrf_token` = ? WHERE `Username` = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("sss", $token, $csrf_token0, $username);
            $stmt_update->execute();

            $csrf_token = hash("sha256",$csrf_token0);
            $_SESSION['csrf_token']= $csrf_token;

            // Connect to Richie’s user_profiles database
            $conn_r = new mysqli($servername_r, $user_r, $pass_r, $database_r);

            if ($conn_r->connect_error) {
                die("Connection failed: " . $conn_r->connect_error);
            }
            
            // Check if the user exists in Richie’s user_profiles table
            $sql_r_check = "SELECT `id` FROM `user_profiles` WHERE `username` = ?";
            $stmt_r_check = $conn_r->prepare($sql_r_check);
            $stmt_r_check->bind_param("s", $username);
            $stmt_r_check->execute();
            $result_r_check = $stmt_r_check->get_result();

            if ($result_r_check->num_rows > 0) {
                // If the user exists, update the token in user_profiles
                $sql_r_update = "UPDATE `user_profiles` SET `id` = ? WHERE `username` = ?";
                $stmt_r_update = $conn_r->prepare($sql_r_update);
                $stmt_r_update->bind_param("ss", $token, $username);
                $stmt_r_update->execute();
            } else {
                // If the user doesn't exist, insert a new record with default values
                $email = UserEmailFromID($token); // Retrieve email using UserEmailFromID function
                $age = 0;                   
                $profile_pic = "https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_ProfilePage/dumbbell.png"; 
                $name = $username;
                
                $sql_r_insert = "INSERT INTO `user_profiles` (id, username, email, name, age, profile_pic) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt_r_insert = $conn_r->prepare($sql_r_insert);
                $stmt_r_insert->bind_param("ssssis", $token, $username, $email, $name, $age, $profile_pic);
                $stmt_r_insert->execute();
            }

            // Redirect to the landing page after successful login
            header("Location: https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Landing/Landing_Page.php");
            exit();
        } else {
            // Password is incorrect
            echo '<script type="text/javascript">
                    window.location.href = "Login.php?error=Invalid Username or Password. Please try again!";
                  </script>';
            exit();
        }
    } else {
        


        // header('Content-Type: application/json');
        // echo json_encode(['error' => 'Invalid Username or Password. Please try again!']);
        // exit();

        // header("Location: https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Login/Login.php?error=Invalid Username or Password. Please try again!");
        // header("Location: Login.php?error=Invalid Username or Password. Please try again!");
        // exit();
        // Username not found
        echo '<script type="text/javascript">
                window.location.href = "Login.php?error=Invalid Username or Password. Please try again!";
              </script>';
        exit();
    }
}

$conn->close();

?>
