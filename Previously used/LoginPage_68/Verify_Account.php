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
            header("Location: Login.php?corr=Thank you for entering your correct login information");
            exit();
        } else {
            // Password is incorrect
            // echo "<p style='color:red;'>Invalid password. Please try again.</p>";
            header("Location: Login.php?error=Please enter a correct username and password!");
            // $message = "Invalid password. Please try again.";
        }
    } else {
        // Username not found
        // echo "<p style='color:red;'>Username not found. Please try again.</p>";
        // header("Location: Login.php?error=Invalid password. Please try again.");
        header("Location: Login.php?error=Please enter a correct username and password!");
        // $message = "Username not found. Please try again.";
    }

    




}

$conn->close();


?>
