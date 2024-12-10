<?php
$host = 'localhost:3306';
$db = 'athletic_legs';
// $db = 'cse442_2024_fall_team_m_db';

$user = 'root';
// $user = "djgage";
$pass = '';
// $pass = "50493464";

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to save workout
function saveWorkout($dayName, $workouts)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO planned_workouts (Workout_Title, Workout_Movements) VALUES (?, ?)");
    $stmt->bind_param("ss", $dayName, $workouts);
    $stmt->execute();
    $stmt->close();
}

// Function to fetch workouts
function fetchWorkouts()
{
    global $conn;
    $result = $conn->query("SELECT * FROM planned_workouts ORDER BY ID DESC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Initialize error message
$errorMsg = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dayName = trim($_POST['day_name']);
    $workouts = array();

    // Collect workouts only if they are not empty
    for ($i = 1; $i <= 5; $i++) {
        $workout = trim($_POST['workout' . $i]);
        if (!empty($workout)) {
            $workouts[] = $workout;
        }
    }

    // Check if dayName is provided and at least one workout is present
    if (!empty($dayName) && count($workouts) > 0) {
        $workouts = implode(",", $workouts);
        // Save the workout
        saveWorkout($dayName, $workouts);

        // Redirect to the same page to prevent form resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit(); // Ensure the script ends after the redirect
    } else {
        // Set an error message if validation fails
        $errorMsg = "Please enter a workout day and at least one workout.";
    }
}
?>