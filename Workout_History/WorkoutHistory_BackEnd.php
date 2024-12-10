<?php


//include '../Cookies_83/LoginPage_68/Verify_Account.php';
include '../Workout_Login/Verify_Account.php';


ini_set('display_errors', 1); // Do not display errors
ini_set('log_errors', 1);     // Log errors to file
error_reporting(E_ALL);
ini_set('error_log', 'path_to_error_log_file.log'); // Path to log file
//TableDataOUT();
//SubmitDataIN();

//Global varibles
////////////////////////////////////
$filterType = [];
//echo('Fail');
////////////////////////////////////


//This function will have the ability to mark the workout as deleted
function softDeleteWorkout($workoutID, $deletedType)
{
    $conn = DataBase_Connect();

    // Update the 'deleted' column to 1
    if(!$deletedType){

        $stmt = $conn->prepare("UPDATE planned_workouts_FULL SET deleted = 1 WHERE ID = ?");
        if (!$stmt) {
            return ['success' => false, 'message' => 'Failed to prepare update statement: ' . $conn->error];
        }
    }else if($deletedType){
        $stmt = $conn->prepare("UPDATE planned_cardio_FULL SET deleted = 1 WHERE ID = ?");
        if (!$stmt) {
            return ['success' => false, 'message' => 'Failed to prepare update statement: ' . $conn->error];
        }
    }else{
        return ['success' => false, 'message' => 'Failed to execute update statement: ' ];
    }

    $stmt->bind_param("i", $workoutID);

    if (!$stmt->execute()) {
        return ['success' => false, 'message' => 'Failed to execute update statement: ' . $stmt->error];
    }

    $stmt->close();
    return ['success' => true];
}

function DataBase_Connect(): mysqli
{
    //This is the test servers name
    //$database_name = "tjmehok_db";
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

function SharedWorkoutCreatorID($WorkoutID): string
{
    $DB = DataBase_Connect();
    $CreatorID = "";

    $UserID = UserEmailFromID($_COOKIE["Authentication_Token"]);

    //Grabbing the creator ID
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $grabDataBase = $DB->prepare("SELECT * FROM shared_workouts WHERE sent_to = ? AND idx = ? ORDER BY ID DESC");
    $grabDataBase->bind_param("si", $UserID, $WorkoutID); // Bind the UserID parameter

    $grabDataBase->execute();
    $DataResult = $grabDataBase->get_result();

    if ($DataResult->num_rows == 1) {
        $row = $DataResult->fetch_assoc();
        $CreatorID = $row["sent_from"];
        $DB->close();
        return $CreatorID;
    }

    $DB->close();
    return "ERERERERERERERROOR";


}


//This function We will be taking the data out of the DB based on auth token
function TableDataOUT($Filters, $SearchString): string
{
    $DB = DataBase_Connect();
    $FinalOutString = "";

    $UserID = UserEmailFromID($_COOKIE["Authentication_Token"]);
    //$UserID = 'Fake1@gmail.com';
    $SearchedFullString = '%' . $SearchString . '%';

    /////////////////////////////////////////////////////////

    //This section is for adding weight workouts
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $grabDataBase = $DB->prepare("SELECT * FROM planned_workouts_FULL WHERE User_ID = ? AND deleted = 0 AND Workout_Title LIKE ? ORDER BY ID DESC");
    $grabDataBase->bind_param("ss", $UserID, $SearchedFullString); // Bind the UserID parameter

    $grabDataBase->execute();
    $DataResult = $grabDataBase->get_result();

    //We need to look into the filtering now
    for ($x = 0; $x < $DataResult->num_rows; $x++) {
        $row = $DataResult->fetch_assoc();
        $Types = explode(",", $row["Workout_Type"]);
        //Continuously grabing the next string to send out to the front end
        if (count($Filters) > 0) {
            foreach ($Filters as $Filter) {
                if (in_array($Filter, $Types)) {
                    $FinalOutString = $FinalOutString . $row["Workout_Date"] . ";" . $row["Workout_Title"] . ";" . $row["Workout_Movements"] . ";" . $row["Workout_Results"] . ";" . $row["Workout_Type"] . ";" . $row["ID"] . ";" . "0" . ";" . $row["Creator_ID"] . "?";
                    break;
                }
            }
        } else {

            $FinalOutString = $FinalOutString . $row["Workout_Date"] . ";" . $row["Workout_Title"] . ";" . $row["Workout_Movements"] . ";" . $row["Workout_Results"] . ";" . $row["Workout_Type"] . ";" . $row["ID"] . ";" . "0" . ";" . $row["Creator_ID"] . "?";
        }
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    //This section is for adding all the cardio workouts
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $grabDataBase = $DB->prepare("SELECT * FROM planned_cardio_FULL WHERE User_ID = ? AND deleted = 0 AND Workout_Title LIKE ? ORDER BY ID DESC");
    $grabDataBase->bind_param("ss", $UserID, $SearchedFullString); // Bind the UserID parameter

    $grabDataBase->execute();
    $DataResult = $grabDataBase->get_result();

    //We need to look into the filtering now
    for ($x = 0; $x < $DataResult->num_rows; $x++) {
        $row = $DataResult->fetch_assoc();
        $Types = explode(",", $row["Workout_Type"]);
        //Continuously grabing the next string to send out to the front end
        if (count($Filters) > 0) {
            foreach ($Filters as $Filter) {
                if (in_array($Filter, $Types)) {
                    $FinalOutString = $FinalOutString . $row["Workout_Date"] . ";" . $row["Workout_Title"] . ";" . $row["Workout_Movements"] . ";" . $row["Workout_Results"] . ";" . $row["Workout_Type"] . ";" . $row["ID"] . ";" . "1" . ";" . $row["Creator_ID"] . "?";
                    break;
                }
            }
        } else {

            $FinalOutString = $FinalOutString . $row["Workout_Date"] . ";" . $row["Workout_Title"] . ";" . $row["Workout_Movements"] . ";" . $row["Workout_Results"] . ";" . $row["Workout_Type"] . ";" . $row["ID"] . ";" . "1" . ";" . $row["Creator_ID"] . "?";
        }
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    }

    $DB->close();

    return $FinalOutString;
}





function AddFullWorkOut($Workout_Title, $Workout_Date, $workout_Info, $Workout_TypeInputs, $CardioFlag, $CreatorID)
{
    $DB = DataBase_Connect();
    if (!$DB) {
        error_log('Database connection failed: ' . mysqli_connect_error());
        echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        exit;
    }

    error_log('Attempting to save workout: ' . $Workout_Title . ' with exercises: ' . json_encode($workout_Info));
    $action = "";
    //This is for adding in weight workouts
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if ($CardioFlag == 0) {
        $Grab_dataBase = $DB->prepare("INSERT INTO planned_workouts_FULL(Workout_Title, Workout_Movements, User_ID, Creator_ID, Workout_Results, Workout_Type, Workout_Date) VALUES (?, ?, ?, ?, ?, ?, ?)");

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

        $Grab_dataBase->bind_param("sssssss", $Workout_Title, $workout_Movements, $UserID, $CreatorID, $workout_Results, $WorkoutTypes, $Workout_Date);

        if (!$Grab_dataBase->execute()) {
            error_log('SQL execution failed: ' . $Grab_dataBase->error);
            echo json_encode(['success' => false, 'message' => 'SQL execution failed']);
            exit;
        }
        $action = "I completed a Weight Workout";

    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //This is for adding in weight workouts
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    else if ($CardioFlag == 1) {
        $Grab_dataBase = $DB->prepare("INSERT INTO planned_cardio_FULL(Workout_Title, Workout_Movements, User_ID, Creator_ID, Workout_Results, Workout_Type, Workout_Date) VALUES (?, ?, ?, ?, ?, ?, ?)");

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
            $TimeTrack = $workout_Info[$x]['Time'];
            $distanceTrack = $workout_Info[$x]['Distance'];

            $workout_Movements .= $exercise . ",";
            $workout_Results .= $exercise . "," . $TimeTrack . "," . $distanceTrack . "+_)(*&^%";
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

        $Grab_dataBase->bind_param("sssssss", $Workout_Title, $workout_Movements, $UserID, $CreatorID, $workout_Results, $WorkoutTypes, $Workout_Date);
        $action = "I completed a Cardio Workout";

        if (!$Grab_dataBase->execute()) {
            error_log('SQL execution failed: ' . $Grab_dataBase->error);
            echo json_encode(['success' => false, 'message' => 'SQL execution failed']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Not cardio or weight']);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    CreateStatusUpdate($action, $WorkoutTypes, $Workout_Date);
    $insert_id = $DB->insert_id;
    $DB->close();
    return ['success' => true, 'workoutID' => $insert_id, "CardioType" => $CardioFlag];
}

function FilterGET(): array
{
    global $filterType;
    return $filterType;
}

//This funtionality is meant to properly update the database once new data is recieved
function updateWorkout($workoutID, $workoutDATA, $workoutTypes, $updatedTitle, $updatedDate, $CardioFlag)
{
    //echo implode(',', $workoutDATA);
    //echo $workoutID;

    $DB = DataBase_Connect();
    if (!$DB) {
        error_log('Database connection failed: ' . mysqli_connect_error());
        echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        exit;
    }

    $UserID = UserEmailFromID($_COOKIE["Authentication_Token"]);

    if ($CardioFlag == 0) {
        // Prepare update statement
        //, Workout_Type = ?, Workout_Date = ?
        //Those ones above still need to be implemented 
        $stmt = '';
        $stmt = $DB->prepare("UPDATE planned_workouts_FULL SET Workout_Title = ?, Workout_Date = ?, Workout_Movements = ?, Workout_Results = ?, Workout_Type = ? WHERE ID = ? AND User_ID = ? AND deleted = 0");
        if (!$stmt) {
            return ['success' => false, 'message' => 'Failed to prepare update statement: ' . $DB->error];
        }

        $workoutMovmentsInput = '';
        $workoutResultsInput = '';
        $workoutTypeInput = '';


        foreach ($workoutDATA as $workoutEntry) {
            //echo implode(',', $workoutEntry);
            $workoutMovmentsInput .= $workoutEntry['name'] . ",";
            $workoutResultsInput .= $workoutEntry['name'] . "," . $workoutEntry['sets'] . "," . $workoutEntry['reps'] . "," . $workoutEntry['weight'] . "+_)(*&^%";
        }

        foreach ($workoutTypes as $workoutType) {
            $workoutTypeInput .= $workoutType . ",";
        }

        $stmt->bind_param("sssssis", $updatedTitle, $updatedDate, $workoutMovmentsInput, $workoutResultsInput, $workoutTypeInput, $workoutID, $UserID);

        if (!$stmt->execute()) {
            $DB->close();
            return ['success' => false, 'message' => 'Failed to execute update statement on weight workout: ' . $stmt->error];
        }
    } elseif ($CardioFlag == 1) {
        // Prepare update statement
        //, Workout_Type = ?, Workout_Date = ?
        //Those ones above still need to be implemented 
        $stmt = '';
        $stmt = $DB->prepare("UPDATE planned_cardio_FULL SET Workout_Title = ?, Workout_Date = ?, Workout_Movements = ?, Workout_Results = ?, Workout_Type = ? WHERE ID = ? AND User_ID = ? AND deleted = 0");
        if (!$stmt) {
            return ['success' => false, 'message' => 'Failed to prepare update statement: ' . $DB->error];
        }

        $workoutMovmentsInput = '';
        $workoutResultsInput = '';
        $workoutTypeInput = '';


        foreach ($workoutDATA as $workoutEntry) {
            //echo implode(',', $workoutEntry);
            $workoutMovmentsInput .= $workoutEntry['name'] . ",";
            $workoutResultsInput .= $workoutEntry['name'] . "," . $workoutEntry['time'] . "," . $workoutEntry['distance'] . "+_)(*&^%";
        }

        foreach ($workoutTypes as $workoutType) {
            $workoutTypeInput .= $workoutType . ",";
        }

        $stmt->bind_param("sssssis", $updatedTitle, $updatedDate, $workoutMovmentsInput, $workoutResultsInput, $workoutTypeInput, $workoutID, $UserID);

        if (!$stmt->execute()) {
            $DB->close();
            return ['success' => false, 'message' => 'Failed to execute update statement on weight workout: ' . $stmt->error];
        }

    } else {
        $DB->close();
        return ['success' => false, 'message' => 'Neither a Cardio or Weight workout'];
    }

    //$insert_id = $DB->insert_id;
    $DB->close();
    return ['success' => true, 'workoutID' => $workoutID];
}

function CreateStatusUpdate($action, $workoutTypes, $date)
{
    $conn = DataBase_Connect();

    //Getting the users email
    $UserEmail = UserEmailFromID($_COOKIE['Authentication_Token']);

    //Getting the username of the user from their email
    $query = "
            SELECT Username FROM User_Accounts_Table 
            WHERE Email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $UserEmail);
    $stmt->execute();
    $Username = $stmt->get_result()->fetch_assoc()['Username'];
    $stmt->close();
    $postBody = "";
    if (str_contains($action, "Weight")) { // if we have completed a weight workout
        $postBody = "I completed a weight workout. I hit my  " . $workoutTypes;

    } else if (str_contains($action, "Cardio")) { // if we have completed a cardio workout
        $postBody = "I completed a cardio workout, where I went" . $workoutTypes;

    } else {
        $postBody = "Someething went wrong with the if statement";
    }

    // $date = date("Y-m-d G:i");

    // $dateTime = date('Y-m-d H:i:s');
    $date = date('Y-m-d H:i:s', strtotime($date . ' ' . date('H:i:s')));
    //inserting the databaase
    $stmt = $conn->prepare("INSERT INTO status_feed (Username, Email, actn, postBody, DateTime) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $Username, $UserEmail, $action, $postBody, $date);
    try {
        $stmt->execute();
        // If it exectues, send a json string of this dictionary that can be accessed by doing result.message
        return json_encode(['success' => true, 'message' => 'Successfully inserted into database']);
    } catch (Exception) {
        return json_encode(['success' => false, 'message' => 'Could not insert into database']);
    }

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //ERROR TESTING MESSAGE 
    error_log('POST request received.');

    $data = json_decode(file_get_contents('php://input'), true);

    //This is for deleting a workout
    $deletedWorkoutID = isset($data['DeletedWorkoutId']) ? $data['DeletedWorkoutId'] : '';
    $deletedType= isset($data['DeleteType']) ? $data['DeleteType'] : '';

    //Getting data

    //Getting the possible search
    $SearchString = isset($data['SearchString']) ? $data['SearchString'] : "";

    //Getting possible filters 
    $filterType = isset($data['workoutType']) ? $data['workoutType'] : [];

    //Getting the CardioFlag
    $CardioFlag = isset($data['CardioFlag']) ? $data['CardioFlag'] : 3;

    //Checking for updated information
    $UpdatedWorkoutData = isset($data['updatedMovements']) ? $data['updatedMovements'] : [];
    $UpdatedWorkoutID = isset($data['workoutID']) ? $data['workoutID'] : -1;
    $UpdatedWorkoutTypes = isset($data['selectedTypes']) ? $data['selectedTypes'] : [];
    $UpdatedDate = isset($data['updatedDate']) ? $data['updatedDate'] : '';
    $UpdatedTitle = isset($data['updatedTitle']) ? $data['updatedTitle'] : '';


    session_start();
    if ($_SERVER['HTTP_X_CSRF_TOKEN'] != $_SESSION['csrf_token']) {
        echo json_encode(["success" => "false", 'reason' => "CREF"]);
        echo ('Fail');
        header("Location: https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Login/Login.php");
        exit();
    }

    //Checking the varibles inside of data
    //Workout_Title, Workout_Date, workout_Info
    if (!empty($data['Workout_Title']) && !empty($data['Workout_Date']) && !empty($data['workout_Info']) && !empty($data['workout_type'])) {

        //ERROR testing message 
        // error_log('Saving workout: ' . json_encode($data));

        //CURRENTLY THE CRATOR ID WILL ALWAYS STAY THE PERSON LOGGED IN UNTIL DEREK CHANGES THAT
        $response = AddFullWorkOut($data['Workout_Title'], $data['Workout_Date'], $data['workout_Info'], $data['workout_type'], $CardioFlag, UserEmailFromID($_COOKIE["Authentication_Token"]));

        if ($response['success']) {
            error_log('Workout saved successfully.');
        } else {
            error_log('Failed to save workout: ' . $response['message']);
        }
        $UpdatedWorkouts = TableDataOUT([], '');
        echo json_encode(["success" => $response['success'], 'workouts' => $UpdatedWorkouts]);

    }
    //Filter POST
    else if (count($filterType) > 0) {
        // Pass $filterType to TableDataOUT to retrieve only relevant workouts
        $UpdatedWorkouts = TableDataOUT($filterType, $SearchString);
        echo json_encode(['success' => true, 'workouts' => $UpdatedWorkouts]);
        error_log('Filters being applied');

    }
    //Updated DATA POST based on filters
    else if (count($UpdatedWorkoutData) > 0 && $UpdatedWorkoutID != -1 && count($UpdatedWorkoutTypes) > 0 && $UpdatedDate != '' && $UpdatedTitle != '') {
        // Pass $filterType to TableDataOUT to retrieve only relevant workouts
        $response = updateWorkout($UpdatedWorkoutID, $UpdatedWorkoutData, $UpdatedWorkoutTypes, $UpdatedTitle, $UpdatedDate, $CardioFlag);
        $UpdatedWorkouts = TableDataOUT([], '');
        echo json_encode(['success' => true, 'workouts' => $UpdatedWorkouts]);
        error_log('Updated workout being applied');

    }
    //Grab associated data based on Search string
    else if ($SearchString != "") {
        // Pass $filterType to TableDataOUT to retrieve only relevant workouts
        $UpdatedWorkouts = TableDataOUT($filterType, $SearchString);
        echo json_encode(['success' => true, 'workouts' => $UpdatedWorkouts]);
        error_log('Filters being applied');


    }
    //This is for deleting workout, It is calling the preexisting function in "MyWorkout_Backend.php
    else if ($deletedWorkoutID != "") {
        softDeleteWorkout($deletedWorkoutID, $deletedType);
        //echo json_encode(['success' => true, 'DeletedWorkoutID' => $deletedWorkoutID ]);
        //This line will be reserved if we end up preserving filters
        $UpdatedWorkouts = TableDataOUT([], '');
        echo json_encode(['success' => true, 'workouts' => $UpdatedWorkouts, 'Deleted workout' => $deletedWorkoutID]);
        error_log('Workout Being Deleted');
    }
    //FAILED POST
    else {
        echo json_encode(['workouts' => implode(",", $filterType), 'AttemptedDeleted' => $deletedWorkoutID]);
        error_log('Invalid input data');
        echo json_encode(['success' => false, 'message' => 'Invalid input data']);
    }
}
?>