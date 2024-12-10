<?php

$servername = "localhost:3306";
$user = "dashawne";
$pass = "50449651";
$database = "cse442_2024_fall_team_m_db";

$conn = new mysqli($servername, $user, $pass, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $id = 0;

    // Check if email already exists
    $checkEmailSql = "SELECT * FROM `User_Accounts_Table` WHERE `Email` = ?";
    $stmt_email = $conn->prepare($checkEmailSql);
    $stmt_email->bind_param("s", $email);
    $stmt_email->execute();
    $result_email = $stmt_email->get_result();

    if ($result_email->num_rows > 0) {
        // Email already exists
        header("Location: https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Register/CreateAccount.php?error=Email already linked to an account");
        exit();
    }

    // Check if username already exists
    $checkUsernameSql = "SELECT * FROM `User_Accounts_Table` WHERE `Username` = ?";
    $stmt_username = $conn->prepare($checkUsernameSql);
    $stmt_username->bind_param("s", $username);
    $stmt_username->execute();
    $result_username = $stmt_username->get_result();

    if ($result_username->num_rows > 0) {
        // Username already exists
        header("Location: https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Register/CreateAccount.php?error=Username already linked to an account");
        exit();
    }

    // Hashing and Salting the Password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert the new user
    $sql = "INSERT INTO `User_Accounts_Table`(`Email`, `Username`, `Password`, `id`) VALUES (?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql);
    $stmt_insert->bind_param("sssi", $email, $username, $hashedPassword, $id);

    if ($stmt_insert->execute()) {
        // If the query is successful, redirect to a success page
        header("Location: https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Login/Login.php?corr=Account Created Successfully!");
        exit();
    } else {
        // Handle the error
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

?>