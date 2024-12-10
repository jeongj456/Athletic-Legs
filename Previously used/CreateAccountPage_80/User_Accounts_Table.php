<?php

$servername = "localhost:3306";
$user = "dashawne";
$pass = "50449651";
$database = "dashawne_db"; 

// $servername = "localhost:3306";
// $user = "root";
// $pass = "";
// $database = "CSE442_Testing"; 

$conn = new mysqli($servername, $user, $pass, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if email already exists
    $checkEmailSql = "SELECT * FROM `User_Accounts_Table` WHERE `Email` = '$email'";
    $result = $conn->query($checkEmailSql);

    if ($result->num_rows > 0) {
        // Email already exists
        header("Location: CreateAccount.php?error=Email already linked to an account");
        // echo "Error: Email already registered!";
    } else {
        // Hashing and Salting the Password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert the new user
        $sql = "INSERT INTO `User_Accounts_Table`(`Email`, `Username`, `Password`) VALUES ('$email', '$username', '$hashedPassword')";
        // header("Location: CreateAccount.php?corr=Account Created Successfully!");

        if ($conn->query($sql) === TRUE) {
            // If the query is successful, redirect to a success page
            // header("Location: CreateAccount.php");
            header("Location: CreateAccount.php?corr=Account Created Successfully!");
            exit();
        } else {
            // Handle the error
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();

?>
