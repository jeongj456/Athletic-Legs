<?php


$servername = "localhost:3306";
$user = "dashawne";
$pass = "50449651";
$database = "dashawne_db"; 


// $servername = "localhost:3306";
// $user = "root";
// $pass = "";
// $database = "CSE442_Testing"; 

// Creating a Connection to Database

$conn = new mysqli($servername, $user, $pass, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $weight = $_POST['weight'];
    $feet = $_POST['feet'];
    $inches = $_POST['inches'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // $id = " ";

    $sql = "INSERT INTO `Create_Profile`(`Name`, `Age`, `Weight`, `Height (ft)`, `Height (in)`, `Email`, `Password`) VALUES ('$name', '$age', '$weight', '$feet', '$inches', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        // If the query is successful, redirect to a success page
        header("Location: FrontEnd_Account.php");  // Replace with your front-end URL
        exit();  // Ensure the script stops after redirection
    } else {
        // Handle the error
        echo "Error: " . $sql . "<br>" . $conn->error;
    }



} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {

    // $sql = "SELECT `Name`, `Age`, `Weight`, `Height (ft)`, `Height (in)`, `Email`, `id`
    // FROM `Create_Profile`
    // ORDER BY `id` ASC
    // LIMIT 10"; // Smallest IDs are first, limited to 10


    $sql = "SELECT * FROM `Create_Profile` ORDER BY `Create_Profile`.`id` DESC LIMIT 10";



    
    $result = $conn->query($sql);
    

    $profiles = array();

    if ($result->num_rows > 0) {
        // Fetch all rows and store in $profiles array
        while($row = $result->fetch_assoc()) {
            $profiles[] = $row;
        }
    }

    // $profiles = array_reverse($profiles);

    // Set content type to application/json and return the data
    header('Content-Type: application/json');
    echo json_encode($profiles);



}

$conn->close();


?>