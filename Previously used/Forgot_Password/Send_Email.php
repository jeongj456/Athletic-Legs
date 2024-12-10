<?php

$servername = "localhost:3306";
$user = "dashawne";
$pass = "50449651";
$database = "cse442_2024_fall_team_m_db";
// $database = "dashawne_db";

// Create a connection
$conn = new mysqli($servername, $user, $pass, $database);

// Check if connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get the email from POST request and sanitize it
    $email = $conn->real_escape_string($_POST['email']); 

    // Use a prepared statement to check if the email exists
    $sql = $conn->prepare("SELECT `Username` FROM `User_Accounts_Table` WHERE `Email` = ?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        // Fetch the username associated with the email
        $row = $result->fetch_assoc();
        $username = $row['Username'];

        // Generate an 8-digit one-time code for password reset
        $tempcode = random_int(10000000, 99999999);
        // $tempcode = bin2hex(random_bytes(4));

        $hashed_tempcode = password_hash($tempcode, PASSWORD_BCRYPT); // Hash the tempcode using bcrypt
        
        $link = "https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Forgot/ResetPassword.php";

        // Email details
        $to = $email;
        $subject = "Reset Password For Athletic Legs";
        
        // Email content
        $txt = "
Hi $username,

We received a request to reset your password for your Athletic Legs account. To proceed, please use the one-time code below and follow the link to reset your password.

Your One-Time Code: $tempcode

For security reasons, this code will expire in 15 minutes. Please use it as soon as possible.

Reset Password Link: $link

Best,
The Athletic Legs Team
";

    $headers = "From: AthleticLegs@buffalo.edu";

    // Send the email and check if it was successful
    if (mail($to, $subject, $txt, $headers)) {


        // Check the Forgot Password Tabke Database to check if the email exists in it

        // If it doesn't exsit create an entry with the above Email and one-time Code

        // If it does exist just change the one-time code in the table



        // Check the Forgot_Password_Table to see if the email exists
        $sqlCheck = $conn->prepare("SELECT `Email` FROM `Reset_Password_Table` WHERE `Email` = ?");
        $sqlCheck->bind_param("s", $email);
        $sqlCheck->execute();
        $resultCheck = $sqlCheck->get_result();


        if ($resultCheck->num_rows > 0) {
            // Email exists, update the one-time code
            $sqlUpdate = $conn->prepare("UPDATE `Reset_Password_Table` SET `Code` = ?, `Timestamp` = NOW() WHERE `Email` = ?");
            $sqlUpdate->bind_param("ss", $hashed_tempcode, $email);
            $sqlUpdate->execute();
            $sqlUpdate->close();
        } else {
            // Email does not exist, insert a new entry
            $sqlInsert = $conn->prepare("INSERT INTO `Reset_Password_Table` (`Email`, `Code`, `Timestamp`) VALUES (?, ?, NOW())");
            $sqlInsert->bind_param("ss", $email, $hashed_tempcode);
            $sqlInsert->execute();
            $sqlInsert->close();
        }

        // Redirect to confirmation page after successful email sending + successful Forgot_Password_Table stuff
        header("Location: https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Forgot/LinkConfirmation.php");
        exit();
    } else {
        // If email fails, show an alert
        echo "<script>alert('Failed to send the email. Please try again.');</script>";
    }
    } else {
        // Email doesn't exist in the database, show an alert
        echo "<script>alert('Email not found in the system. Please check and try again.');</script>";
    }

    // Close the statement and connection
    $sql->close();
    $conn->close();
}
?>