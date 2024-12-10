<?php
// include '../Cookies_83/LoginPage_68/Verify_Account.php';
include '../Workout_Login/Verify_Account.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$host = 'localhost:3306';
// $db = 'athletic_legs';
// $user = 'root';
// $pass = '';
// $db = 'djgage_db';
$db = 'cse442_2024_fall_team_m_db';
$user = 'djgage';
$pass = '50493464';
// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
	die(json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]));
}

//Connect to thomas's database
function DataBase_Connect(): mysqli
{
	//This is the test servers name
	// $database_name = "tjmehok_db";
	$database_name = "cse442_2024_fall_team_m_db";
	//I belive this is the full name Matt gave us in his email
	$server_name = "localhost:3306";
	//The user name and password is how we sign into PHP admin
	$user_name = "tjmehok";
	$password = "50407528";
	// $user_name   = "root";
	// $password = "";

	//This is the most important part
	//we are creating the mysqli class so it will eaisily connect everytime
	try {
		$connect = new mysqli($server_name, $user_name, $password, $database_name);
		//check the connection status
		//If the connection failed
	} catch (PDOException $e) {
		die("Connection failed: " . mysqli_connect_error());
	}
	return $connect;
	//If the connection succeded
}

//Add a fullworkout to thomas's database so it can be used on the workout history page
function AddFullWorkOut($Workout_Title, $Workout_Date, $workout_Info, $Workout_TypeInputs)
{
	$DB = DataBase_Connect();
	if (!$DB) {
		error_log('Database connection failed: ' . mysqli_connect_error());
		echo json_encode(['success' => false, 'message' => 'Database connection failed']);
		exit;
	}

	error_log('Attempting to save workout: ' . $Workout_Title . ' with exercises: ' . json_encode($workout_Info));

	$Grab_dataBase = $DB->prepare("INSERT INTO planned_workouts_FULL(Workout_Title, Workout_Movements, User_ID, Workout_Results, Workout_Type, Workout_Date) VALUES (?, ?, ?, ?, ?, ?)");

	if (!$Grab_dataBase) {
		error_log('Failed to prepare statement: ' . $DB->error);
		return ['success' => false, 'message' => 'Failed to prepare statement: ' . $DB->error];
	}

	$workout_Movements = "";
	$workout_Results = "";

	//var_dump($workout_Info);
	//THIS WHOLE for each needs to be altered so that the explode can work properly with it
	for ($x = 0; $x <= count($workout_Info) - 1; $x++) {
		$exercise = $workout_Info[$x]['workout'];
		$weight = $workout_Info[$x]['weight'];
		$reps = $workout_Info[$x]['reps'];
		$sets = $workout_Info[$x]['sets'];

		$workout_Movements .= $exercise . ",";
		$workout_Results .= $exercise . "," . $sets . "," . $reps . "," . $weight . "+_)(*&^%";
	}

	// Define a default Workout_type. Adjust this logic later as needed.
	$WorkoutTypes = "";
	foreach ($Workout_TypeInputs as $workout_TypeInput) {
		$WorkoutTypes = $WorkoutTypes . $workout_TypeInput . ",";
	}

	// Define the user using the website currently
	//This line might need to be replaced for temp local testing
	$UserID = UserEmailFromID($_COOKIE["Authentication_Token"]);
	//$UserID = "TestUser@gmail.com";

	$Grab_dataBase->bind_param("ssssss", $Workout_Title, $workout_Movements, $UserID, $workout_Results, $WorkoutTypes, $Workout_Date);

	if (!$Grab_dataBase->execute()) {
		error_log('SQL execution failed: ' . $Grab_dataBase->error);
		echo json_encode(['success' => false, 'message' => 'SQL execution failed']);
		exit;
	}
	$insert_id = $DB->insert_id;
	$DB->close();
	return ['success' => true, 'workoutID' => $insert_id];
}

// Function to save workout
function saveWorkout($dayName, $workouts)
{
	global $conn;

	error_log('Attempting to save workout: ' . $dayName . ' with exercises: ' . json_encode($workouts));

	$stmt = $conn->prepare("INSERT INTO planned_workouts (Workout_Title, Workout_Movements,User_ID) VALUES (?, ?, ?)");

	if (!$stmt) {
		error_log('Failed to prepare statement: ' . $conn->error);
		return ['success' => false, 'message' => 'Failed to prepare statement: ' . $conn->error];
	}
	$userID = UserEmailFromID($_COOKIE["Authentication_Token"]);
	$workoutString = implode(",", $workouts);
	$stmt->bind_param("sss", $dayName, $workoutString, $userID);

	if (!$stmt->execute()) {
		error_log('Failed to execute statement: ' . $stmt->error);
		return ['success' => false, 'message' => 'Failed to execute statement: ' . $stmt->error];
	}

	$stmt->close();
	return ['success' => true, 'workoutID' => $conn->insert_id];
}

// Function to fetch workouts
function fetchWorkouts()
{
	global $conn;

	// Use a prepared statement to prevent SQL injection
	$stmt = $conn->prepare("SELECT * FROM planned_workouts WHERE deleted = ? AND User_ID = ? ORDER BY ID DESC");

	if (!$stmt) {
		return []; // Return an empty array if preparation failed
	}
	$userID = UserEmailFromID($_COOKIE["Authentication_Token"]);
	// Bind the parameter: 0 means fetching non-deleted workouts
	$deletedStatus = 0; // We are fetching only workouts where deleted is 0
	$stmt->bind_param("is", $deletedStatus, $userID);

	// Execute the query
	if (!$stmt->execute()) {
		return []; // Return an empty array if execution failed
	}

	// Get the result set from the query
	$result = $stmt->get_result();

	// Fetch all results as an associative array
	return $result->fetch_all(MYSQLI_ASSOC);
}
function softDeleteWorkout($workoutID)
{
	global $conn;

	// Update the 'deleted' column to 1
	$stmt = $conn->prepare("UPDATE planned_workouts SET deleted = 1 WHERE ID = ?");
	if (!$stmt) {
		return ['success' => false, 'message' => 'Failed to prepare update statement: ' . $conn->error];
	}

	$stmt->bind_param("i", $workoutID);

	if (!$stmt->execute()) {
		return ['success' => false, 'message' => 'Failed to execute update statement: ' . $stmt->error];
	}

	$stmt->close();
	return ['success' => true];
}


// Function to search workouts by title
function searchWorkouts($query)
{
	global $conn;

	$stmt = $conn->prepare("SELECT * FROM planned_workouts WHERE Workout_Title LIKE ? AND deleted = 0 AND User_ID = ?");
	if (!$stmt) {
		return ['success' => false, 'message' => 'Failed to prepare search statement: ' . $conn->error];
	}

	$userID = UserEmailFromID($_COOKIE["Authentication_Token"]);
	$searchQuery = "%" . $query . "%"; // Use wildcard for partial match
	$stmt->bind_param("ss", $searchQuery, $userID);

	$stmt->execute();
	$result = $stmt->get_result();

	$workouts = $result->fetch_all(MYSQLI_ASSOC);

	return ['success' => true, 'workouts' => $workouts];
}

//resetting search results
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
	session_start();
	if ($_SERVER['HTTP_X_CSRF_TOKEN'] != $_SESSION['csrf_token']){
		echo('Fail');
		exit();  
	}
	if ($_GET['action'] === 'fetch') {
		$workouts = fetchWorkouts();
		echo json_encode(['success' => true, 'workouts' => $workouts]);
	} elseif ($_GET['action'] === 'search') {
		$query = $_GET['query'] ?? '';
		if (!empty($query)) {
			$response = searchWorkouts($query);
			echo json_encode($response);
		} else {
			echo json_encode(['success' => false, 'message' => 'No search query provided.']);
		}
	}
	exit; // End script after outputting JSON response
}

// Check if request method is POST and content type is JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	error_log('POST request received.');

	ob_clean(); // Clear any buffer contents
	header('Content-Type: application/json');

	$data = json_decode(file_get_contents('php://input'), true);
/*
	session_start();
	if ($_SERVER['HTTP_X_CSRF_TOKEN'] != $_SESSION['csrf_token']){
		echo('Fail');
		exit();  
	}
		*/
	if (isset($data['loggingWorkout']) && $data['loggingWorkout'] === true) {
		// Logging workout data case
		$response = AddFullWorkOut(
			$data['Workout_Title'],
			$data['Workout_Date'],
			$data['workout_Info'],
			$data['Workout_TypeInputs']
		);
		echo json_encode($response);
		exit;
	} else if (!empty($data['day_name']) && !empty($data['workouts'])) {
		// Saving regular workout case
		$response = saveWorkout($data['day_name'], $data['workouts']);
		echo json_encode($response);
		exit;
	} else if (!empty($data['send_to']) && !empty($data['workoutID'])) {
		error_log('Saving workout: ' . json_encode($data));

		$response = shareWorkout($data['send_to'], $data['workoutID']);
		if ($response['success']) {
			error_log('Workout saved successfully.');
		} else {
			error_log('Failed to save workout: ' . $response['message']);
		}
		echo json_encode($response);
	} else {
		// Error: invalid data for both cases
		error_log('Invalid input data for saving or logging a workout');
		echo json_encode(['success' => false, 'message' => 'Invalid input data for saving or logging a workout']);
		exit;
	}
} else if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
	error_log('PATCH request received.');

	$data = json_decode(file_get_contents('php://input'), true);
	session_start();
	if ($_SERVER['HTTP_X_CSRF_TOKEN'] != $_SESSION['csrf_token']){
		echo('Fail');
		exit();  
	}
	//if the user is updating a workout
	if (isset($data['day_name'])) {
		if (!empty($data['workoutID'])) {
			$response = updateWorkout($data['workoutID'], $data['day_name'], $data['workouts']);
			header('Content-Type: application/json'); // Make sure the response is set as JSON
			echo json_encode($response);
		} else {
			error_log('Invalid input data for deletion');
			header('Content-Type: application/json'); // Make sure the error response is also JSON
			echo json_encode(['success' => false, 'message' => 'Invalid input data for deletion']);
		}

	} else {//if the user is deleting a workout
		if (!empty($data['workoutID'])) {
			$response = softDeleteWorkout($data['workoutID']);
			header('Content-Type: application/json'); // Make sure the response is set as JSON
			echo json_encode($response);
		} else {
			error_log('Invalid input data for deletion');
			header('Content-Type: application/json'); // Make sure the error response is also JSON
			echo json_encode(['success' => false, 'message' => 'Invalid input data for deletion']);
		}
	}
}
// Function to update workout
function updateWorkout($workoutID, $dayName, $workouts)
{
	global $conn;

	// Prepare update statement
	$stmt = $conn->prepare("UPDATE planned_workouts SET Workout_Title = ?, Workout_Movements = ? WHERE ID = ?");
	if (!$stmt) {
		return ['success' => false, 'message' => 'Failed to prepare update statement: ' . $conn->error];
	}

	$workoutString = implode(",", $workouts);
	$stmt->bind_param("ssi", $dayName, $workoutString, $workoutID);

	if (!$stmt->execute()) {
		return ['success' => false, 'message' => 'Failed to execute update statement: ' . $stmt->error];
	}

	$stmt->close();
	return ['success' => true];
}


function shareWorkout($sent_to, $workoutID)
{
	global $conn;

	// 0 = not accepted; 1 = accepted
	$acceptance = 0;
	$stmt = $conn->prepare("INSERT INTO shared_workouts (sent_to, sent_from, ID, acceptance) VALUES (?, ?, ?, ?)");

	if (!$stmt) {
		error_log('Failed to prepare statement: ' . $conn->error);
		return ['success' => false, 'message' => 'Failed to prepare statement: ' . $conn->error];
	}
	$sent_from = UserEmailFromID($_COOKIE["Authentication_Token"]);
	if ($sent_from != $sent_to) {
		$stmt->bind_param("ssii", $sent_to, $sent_from, $workoutID, $acceptance);

		if (!$stmt->execute()) {
			error_log('Failed to execute statement: ' . $stmt->error);
			return ['success' => false, 'message' => 'Failed to execute statement: ' . $stmt->error];
		}

		$stmt->close();
		return ['success' => true, 'workoutID' => $conn->insert_id];
	}
}


?>