<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connection.php</title>
</head>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connection.php</title>
</head>
<body>
    <h2>Enter Your Details</h2>
    <form action="" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <input type="submit" value="Submit">
    </form>

    <?php
    // Enable error reporting for debugging
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Database connection details
    $servername = "localhost";  
    $username = "richiezh";         // Your MySQL username
    $password = "50360501";             // Your MySQL password
    $dbname = "richiezh_db";             // Name of your database

    // Connect to MySQL server
    $conn = new mysqli($servername, $username, $password);

    // Check the connection
    if ($conn->connect_error) {
        echo "<script>alert('Connection to database failed: " . $conn->connect_error . "');</script>";
        die();
    } else {
        echo "<script>alert('Connected to the database successfully');</script>";
    }

    // Select the database
    if ($conn->select_db($dbname)) {
        echo "<script>alert('Database selected successfully');</script>";
    } else {
        die("Database selection failed: " . $conn->error);
    }

    // Create `users` table if it doesn't exist
    $table = "CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        age INT(3) NOT NULL,
        email VARCHAR(50) NOT NULL,
        name VARCHAR(50) NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if ($conn->query($table) === TRUE) {
        echo "<script>alert('Table created or already exists!');</script>";
    } else {
        die("Error creating table: " . $conn->error);
    }

    // Check if form data is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize and fetch form data
        $username = $conn->real_escape_string($_POST['username']);
        $age = (int)$_POST['age'];
        $email = $conn->real_escape_string($_POST['email']);
        $name = $conn->real_escape_string($_POST['name']);

        // Insert form data into the `users` table
        $sql = "INSERT INTO users (username, age, email, name) VALUES ('$username', $age, '$email', '$name')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('New record created successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }

    // Close the connection
    $conn->close();
    ?>
</body>
</html>
