<?php
session_start();

$servername = "localhost:3306";
$user = "dashawne";
$pass = "50449651";
$database = "cse442_2024_fall_team_m_db";
// $database = "dashawne_db";
// Check if the session variables are set
if (isset($_SESSION['new_password']) && isset($_SESSION['email'])) {
    $new_password = $_SESSION['new_password'];
    $email = $_SESSION['email'];

    // Retrieve the password entered on the current page
    $this_page_password = $_POST['password'];
    // $this_page_password = password_hash($this_page_password, PASSWORD_BCRYPT);

    // password_verify($new_password, $this_page_password);


    // Compare the new password with the one entered on this page
    if (!password_verify( $this_page_password, $new_password)) {
        // If the passwords do not match, show an error message
        header("Location: https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Forgot/ResetPassword.php?error=The passwords do not match. Please try again.");
        exit();
    }

    // Create a connection
    $conn = new mysqli($servername, $user, $pass, $database);

    // Check if connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Hash the new password
    $hashed_password = password_hash($this_page_password, PASSWORD_BCRYPT);

    // Update the user's password in the database
    $sql = $conn->prepare("UPDATE `User_Accounts_Table` SET `Password` = ? WHERE `Email` = ?");
    $sql->bind_param("ss", $hashed_password, $email); // Bind the parameters
    if ($sql->execute()) {
        // Password updated successfully
        header("Location: https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Forgot/ResetSuccessConfirmation.php");

        // Optionally, you can destroy the session after use
        session_destroy();
    } else {
        // header("Location: ResetPassword.php?error=The passwords do not match. Please try again.");
        echo "Error updating password: " . $conn->error;
    }

    // Close the statement and connection
    $sql->close();
    $conn->close();







}
//     // Create a connection
//     $conn = new mysqli($servername, $user, $pass, $database);

//     // Check if connection was successful
//     if ($conn->connect_error) {
//         die("Connection failed: " . $conn->connect_error);
//     }

//     // Hash the new password
//     $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

//     // Update the user's password in the database
//     $sql = $conn->prepare("UPDATE `User_Accounts_Table` SET `Password` = ? WHERE `Email` = ?");
//     $sql->bind_param("ss", $hashed_password, $email); // Bind the parameters
//     if ($sql->execute()) {
//         // Password updated successfully
//         echo "Your password has been updated successfully.";
//         // Optionally, you can destroy the session after use
//         session_destroy();
//     } else {
//         echo "Error updating password: " . $conn->error;
//     }

//     // Close the statement and connection
//     $sql->close();
//     $conn->close();
// } else {
//     // Redirect if session variables are not set
//     header("Location: ResetPassword.php?error=Session expired. Please request a new password reset.");
//     exit();
// }
?>