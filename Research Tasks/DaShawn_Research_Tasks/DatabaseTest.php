<html>
<body>

<!-- Here is where you will actually enter things -->
<!-- Form for User to Enter Username and Password --> 

<center>
<h1> Login </h1> 
<form method = "POST" action="">
Username: <input type = "text" name = "Username"> <br>
Password: <input type = "text" name = "Password"> <br> <br>
<input type = "Submit">
</form>
</center>

<?php

/* 
Create a php file that can do the following: 
- Connect to the database and display text saying the connection status on the page 
- Have the ability to enter text/input that gets entered and stored into the database as a new entry
*/

// $servername = "dev.cse.buffalo.edu";
// $servername = "apitude.cse.buffalo.edu";

$servername = "localhost:3306";
$user = "dashawne";
$pass = "50449651";
$database = "dashawne_db"; 

// Create connection
$conn = new mysqli($servername, $user, $pass, $database);

// Check connection
if ($conn->connect_error) {
	echo "Unsuccessful Connection";
	die("Connection failed: " . $conn->connect_error);
} else {
	echo "<center> <h3> Connection Successful! </h3> </center>";
}


$username = $_POST['Username'];
$password = $_POST['Password']; 



/*
if (is_null($username) === TRUE) {
	echo "Please Enter a Username!";
} if (is_null($password) === TRUE) {
	echo "Please Enter a Password!";
} if (is_null($username) and is_null($password) === TRUE) {
	echo "Please Enter a Username and a Password!";
} else {
 */


$sql = "INSERT INTO `User_Info`(`Username`, `Password`) VALUES ('$username','$password')";

// echo $_POST['Password'];

if ($conn->query($sql) === TRUE) {
	echo "<center> <h3> Username: $username</h3> </center>";
	echo "<center> <h3> Password: $password</h3> </center>";
//	echo "<center> <h3> New Record Created Successfully! </h3> </center>";
}
else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}


?>
</body>
</html>
