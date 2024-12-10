<form method="POST" action="">
    <label for="FirstName">Enter first name:</label>
    <input type="string" id="FirstName" name="FirstName" required>
    <br>
    <label for="LastName">Enter last name:</label>
    <input type="string" id="LastName" name="LastName" required>
    <br><br>
    <input type="submit" value="Enter First and last name to database">
</form>

<?php
//These are the logins for server db
$servername = "localhost:3306";
$username = "djgage";
$password = "50493464";
$databaseName = "djgage_db";
//These are the logins for the local db 
//$username = "root";
// $password = "";
// $databaseName = "test";
// $tableName = "test_table";
$serverConn;
try {
    $serverConn = new mysqli($servername, $username, $password, $databaseName);

} catch (mysqli_sql_exception $e) {
    echo "<br>Database connection failed";
    die("<br>Error from server: " . $e->getMessage());
}
echo "<br> Connection to the database was successful";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the two numbers from the form (they will only exist during the POST request)
    $firstName = isset($_POST['FirstName']) ? $_POST['FirstName'] : "";
    $lastName = isset($_POST['LastName']) ? $_POST['LastName'] : "";

    //Give a prepared statement to protect against sql injection
    $prepareStatement = $serverConn->prepare("INSERT INTO Test_Table (First_Name, Last_Name) VALUES (?, ?)");

    //Bind the values to the prepared statement vaules
    $prepareStatement->bind_param("ss", $firstName, $lastName);

    if ($prepareStatement->execute()) { //If it executes correctly then print this out
        echo "<br>The values $firstName and $lastName have added to the database<br>";
    } else {
        echo "<br> Some shit fucked up";
    }
}
$serverConn->close();

// You don't need to select a table with mysqli_select_db, that's for databases

?>