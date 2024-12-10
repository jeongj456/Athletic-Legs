<?php

if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
    die("Invalid email");
}

if(empty($_POST["name"])){
    die("Please enter Username");
}

if(strlen($_POST["password"]) < 6){
    die("Password must be at least 8 characters");
}

if(!preg_match("/[a-z]/i", $_POST["password"])){
    die("Password must contain at least one letter");
}

if(!preg_match("/[0-9]/", $_POST["password"])){
    die("Password must contain at least one number");
}

if($_POST["password"] !== $_POST["password_confirmation"]){
    die("Passwords must match");
}


$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

//print_r($_POST);

$mysqli = require __DIR__ ."/database_management.php";

$sql = "INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)";

$stmt = $mysqli->stmt_init();

if(!$stmt->prepare($sql)){
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sss", $_POST["name"], $_POST["email"], $password_hash);

$stmt->execute();
echo"Sign up successful";
?>