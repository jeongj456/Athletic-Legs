<?php

$servername = "localhost:3306";
$user = "dashawne";
$pass = "50449651";
$database = "dashawne_db"; 




// $servername_r = "localhost:3306";
// $user_r = "richiezh";
// $pass_r = "50360501";
// $database_r = "user_profiles"; 



// $servername = "localhost:3306";
// $user = "root";
// $pass = "";
// $database = "CSE442_Testing"; 




// Function to receive user email from the id in the current Authentication_Token
function UserEmailFromID($token) {

    $servername = "localhost:3306";
    $user = "dashawne";
    $pass = "50449651";
    $database = "dashawne_db";

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





$conn = new mysqli($servername, $user, $pass, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hashing and Salting the Password
    // $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = "SELECT `Password` FROM `User_Accounts_Table` WHERE `Username` = '$username'";
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
        // Fetch the hashed password from the result
        $row = $result->fetch_assoc();
        $hashedPassword = $row['Password'];

        // Verify the entered password with the hashed password
        if (password_verify($password, $hashedPassword)) {
            // Password is correct, redirect to a success page
            // header("Location: dashboard.php");
            // header("Location: Login.php?corr=Thank you for entering your correct login information");

            session_start();

            $username = $_POST['username'];
            $password = $_POST['password'];


            // Cookie
            // $_SESSION['token'] = bin2hex(random_bytes(32));
            // setcookie('Authentication_Token', 'username', time() + (90), '.cse.buffalo.edu', '/CSE442-542',1); // Cookie Valid for 1 minute 30 seconds
            $_SESSION['username'] = $username;


            $token = bin2hex(random_bytes(32)); // Generate a secure random token

            // setcookie("Authentication_Token", "Username", time() + (300), ".cse.buffalo.edu");
            setcookie("Authentication_Token", $token, time() + (432000),  "/", ".cse.buffalo.edu", true); // 5 days for the cookie


            $sql_update = "UPDATE `User_Accounts_Table` SET `id` = '$token' WHERE `Username` = '$username'";
            
            

            if ($conn->query($sql_update) === TRUE) {

                // // Testing the UserEamilFromID function
                // $email = UserEmailFromID($token);
                

                // if ($email) {
                //     // Testing the UserEmailFromID to see if the email is correect
                //     setcookie("Email", $email, time() + (10),  "/", ".cse.buffalo.edu", true);
                //     // error_log("User's email: " . $email);
                // } else {
                //     error_log("Invalid token or user not found.");
                // }


                // Redirect to the profile page after successful login
                header("Location: https://se-dev.cse.buffalo.edu/CSE442/2024-Fall/tjmehok/WorkoutHistory/WorkoutHistory_FrontEnd.php");
                exit();
            } else {
                echo "Error updating record: " . $conn->error;
            }

            // $conn = new mysqli($servername_r, $user_r, $pass_r, $database_r);

            // if ($conn->connect_error) {
            //     die("Connection failed: " . $conn->connect_error);
            // }

            //  $sql_insert = "INSERT INTO user_profiles (username, email, name, age, profile_pic) VALUES ('$username', '$email', '$name', $age, '$profile_pic')";

            // if ($conn->query($sql_insert) === TRUE) {
                // Redirect to profile page after successful login and logging profile data
            // header("Location: https://se-dev.cse.buffalo.edu/CSE442/2024-Fall/richiezh/Profile.php");
            exit(); // Always exit after redirection
            // } else {
            //     echo "Error: " . $sql_insert . "<br>" . $conn->error;
            // }

            // $sql = INSERT INTO user_profiles (id, username, email, name, age, profile_pic) 
            




            // header("Location: https://se-dev.cse.buffalo.edu/CSE442/2024-Fall/richiezh/Profile.php");
            // exit(); // Always exit after redirection

            // setcookie("Authentication_Token", "Username", time() + (90), ".cse.buffalo.edu", "/CSE442-542", 1);
            // header("Location: Login.php?corr=Thank you for entering your correct login information");



            // if ($username == 'username' && $password == 'password') {
                // Generate a token (here we're using session, but you can use JWT or another method)
                // $_SESSION['token'] = bin2hex(random_bytes(32));  // Random token generation for demo purposes

                // Set the token in a cookie (Optional: adjust the expiration time as needed)
                // setcookie('auth_token', $_SESSION['token'], time() + (86400 * 30), "/"); // Cookie valid for 30 days

                
            // }

            // exit();

        } else {
            // Password is incorrect
            // echo "<p style='color:red;'>Invalid password. Please try again.</p>";
            //header("Location: ../Login.php?error=Please enter a correct username and password!");

            // $message = "Invalid password. Please try again.";
        }
    } else {
        // Username not found
        // echo "<p style='color:red;'>Username not found. Please try again.</p>";
        // header("Location: Login.php?error=Invalid password. Please try again.");

        //header("Location: Login.php?error=Please enter a correct username and password!");

        // $message = "Username not found. Please try again.";
    }

    




}

$conn->close();



?>

