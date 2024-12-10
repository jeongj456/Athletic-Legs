<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

//include_once __DIR__ . '/../Workout_Login/Verify_Account.php';
include_once __DIR__ . '/../Workout_History/WorkoutHistory_BackEnd.php';


function AccumulatedDataFromUser($sortType) {
    // Connect to the database
    $DB = DataBase_Connect();

    // Get the user's ID using the authentication token from the cookie
    $UserID = UserEmailFromID($_COOKIE["Authentication_Token"]);

    // Fetch all workout data for this user
    $query = "SELECT Workout_Movements, Workout_Results FROM planned_workouts_FULL WHERE User_ID = ? AND deleted = 0";
    $stmt = $DB->prepare($query);
    $stmt->bind_param("s", $UserID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Initialize an array to hold accumulated data for each movement
    $accumulatedData = [];

    // Process each workout entry
    while ($row = $result->fetch_assoc()) {
        //$movements = explode(",", $row["Workout_Movements"]);
        $results = explode("+_)(*&^%", $row["Workout_Results"]);

        // Iterate over each movement and accumulate weight and sets
        foreach ($results as $resultEntry) {
            if (empty($resultEntry)) continue; // Skip empty entries
            
            // Split the result data for this movement
            list($movement, $sets, $reps, $weight) = explode(",", $resultEntry);

            //Check if the movement already exists in accumulatedData
            //If not then add it to the list
            if (!isset($accumulatedData[$movement])) {
                $accumulatedData[$movement] = [
                    "movement" => $movement,
                    "totalWeight" => 0,
                    "totalSets" => 0
                ];
            }

            // Accumulate the weight and sets
            $accumulatedData[$movement]["totalWeight"] += (float) $weight;
            $accumulatedData[$movement]["totalSets"] += (int) $sets;
        }
    }

    // Close the statement and database connection
    $stmt->close();
    $DB->close();


    // Convert accumulated data to an array and sort based on the sortType
    $accumulatedData = array_values($accumulatedData);

    // Sort the array based on the requested sort type
    //Usort is a speacial custom array sort
    //It takes in your array and the part of the array you want to sort

    //Here is a good segmant if you forgot how to use these from 115

    // Negative integer if the first element should come before the second.
    // Zero if the elements are equal (or in the same position relative to each other).
    // Positive integer if the first element should come after the second.
    usort($accumulatedData, function ($a, $b) use ($sortType) {
        if ($sortType === "lowestWeightsButton") {

            //Sorts the weights from most to least
            return $a["totalWeight"] <=> $b["totalWeight"];

        } 
        elseif ($sortType === "lowestSetsButton") {

            //Sorts the Sets from most to least
            return $a["totalSets"] <=> $b["totalSets"];

        } 
        elseif ($sortType === "HighestWeightsButton") {

            //Sorts the weights from least to most
            return $b["totalWeight"] <=> $a["totalWeight"];

        } 
        elseif ($sortType === "HighestSetsButton") {

            //Sorts the Sets from least to most
            return $b["totalSets"] <=> $a["totalSets"];
        }
        return 0;
    });

    //Param 1 is the array
    //Param 2 is the starting index
    //Param 2 is the ending Index
    $accumulatedData = array_slice($accumulatedData, 0, 4);
    echo json_encode(['success' => true, 'workouts' => $accumulatedData  ]);
}

function getUserStatsByEmail_Weight($email) {
    $servername = "localhost:3306";
    $user = "dashawne";
    $pass = "50449651";
    $database = "cse442_2024_fall_team_m_db";
    
    $conn = new mysqli($servername, $user, $pass, $database);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Initialize dictionary for all possible stats for graph
    $stats = [
        // "Shoulders" => 0,
        "Sholders" => 0,
        "Back" => 0,
        "Biceps" => 0,
        "Abs" => 0,
        "Chest" => 0,
        "Quads" => 0,
        "Calfs" => 0,
        "Hamstrings" => 0
    ];

    // Prepare statement to prevent SQL injection
    $sql = "SELECT Workout_Results, Workout_Type FROM planned_workouts_FULL WHERE User_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    $result = $stmt->get_result();


    // Loop through each row
    while ($row = $result->fetch_assoc()) {
        // Parse Workout_Results to extract numbers and calculate the sum
        preg_match_all('/\d+/', $row['Workout_Results'], $numbers);
        $numbers = $numbers[0]; // Flatten the nested array from preg_match_all
        // print_r($numbers);


        $total = 0;
        // for ($i = 0; $i < count($numbers); $i += 3) {
        //     $total += (int)$numbers[$i];
        // }

        for ($i = 2; $i < count($numbers); $i += 3) {
            $total += (int)$numbers[$i];
        }

        // $total = array_sum($numbers[0]); // Sum up all numbers in this Workout_Results entry
        // print_r($total);
        // print_r("\n");

        
        // Parse Workout_Type to get the list of body parts
        $workout_types = explode(',', $row['Workout_Type']);
        
        // Remove empty entries (due to trailing commas)
        $workout_types = array_filter($workout_types);
        
        // Add the total to each body part listed in Workout_Type
        foreach ($workout_types as $type) {
            if (isset($stats[$type])) {
                $stats[$type] += $total;
            }
        }
    }

    // print_r($stats);


    $stmt->close();
    $conn->close();

    arsort($stats);
    $top5stats = array_slice($stats, 0, 5, true);

    ksort($top5stats);

    // print_r($top5Stats);

    return $top5stats; // Return only the top 5 values


}



function getUserStatsByEmail_Sets($email) {
    $servername = "localhost:3306";
    $user = "dashawne";
    $pass = "50449651";
    $database = "cse442_2024_fall_team_m_db";
    
    $conn = new mysqli($servername, $user, $pass, $database);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Initialize dictionary for all possible stats for graph
    $stats = [
        // "Shoulders" => 0,
        "Sholders" => 0,
        "Back" => 0,
        "Biceps" => 0,
        "Abs" => 0,
        "Chest" => 0,
        "Quads" => 0,
        "Calfs" => 0,
        "Hamstrings" => 0
    ];

    // Prepare statement to prevent SQL injection
    $sql = "SELECT Workout_Results, Workout_Type FROM planned_workouts_FULL WHERE User_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    $result = $stmt->get_result();


    // Loop through each row
    while ($row = $result->fetch_assoc()) {
        // Parse Workout_Results to extract numbers and calculate the sum
        preg_match_all('/\d+/', $row['Workout_Results'], $numbers);
        $numbers = $numbers[0]; // Flatten the nested array from preg_match_all
        // print_r($numbers);


        // $total = 0;
        // for ($i = 2; $i < count($numbers); $i += 3) {
        //     $total += (int)$numbers[$i];
        // }

        $total = 0;
        for ($i = 0; $i < count($numbers); $i += 3) {
            $total += (int)$numbers[$i];
        }

        // $total = array_sum($numbers[0]); // Sum up all numbers in this Workout_Results entry
        // print_r($total);
        // print_r("\n");

        
        // Parse Workout_Type to get the list of body parts
        $workout_types = explode(',', $row['Workout_Type']);
        
        // Remove empty entries (due to trailing commas)
        $workout_types = array_filter($workout_types);
        
        // Add the total to each body part listed in Workout_Type
        foreach ($workout_types as $type) {
            if (isset($stats[$type])) {
                $stats[$type] += $total;
            }
        }
    }

    // print_r($stats);


    $stmt->close();
    $conn->close();

    arsort($stats);
    $top5stats = array_slice($stats, 0, 5, true);

    ksort($top5stats);

    // print_r($top5stats);

    

    return $top5stats; // Return only the top 5 values


    // $top5_Weight = $top5stats;

    // header('Content-Type: application/json');
    // echo json_encode($top5_Weight);

    // return $stats; // Return the dictionary of stats

}
//Check if 'sort' parameter is set in the GET request
//This is how we will control front end requests 
if (isset($_GET['sort'])) {
    // Retrieve the 'sort' parameter value
    $sortType = $_GET['sort'];
    AccumulatedDataFromUser($sortType);
}

$action = isset($_GET['action']) ? $_GET['action'] : null;

if ($action === 'getTop5Weights') {

    $email =UserEmailFromID($_COOKIE["Authentication_Token"]);
    // $email = UserEmailFromID($token);
        // $email = "dashawne@buffalo.edu";
        // $email = "Fake2@gmail.com";
        // $email = "testlegs@gmail.com";
    if ($email) {
        $top5Weights = getUserStatsByEmail_Weight($email);
        header('Content-Type: application/json');
        echo json_encode($top5Weights);
    } else {
        echo json_encode(["error" => "Invalid token."]);
    }


}

if ($action === 'getTop5Sets') {

    $email =UserEmailFromID($_COOKIE["Authentication_Token"]);
    // $email = UserEmailFromID($token);
        // $email = "dashawne@buffalo.edu";
        // $email = "Fake2@gmail.com";
        // $email = "testlegs@gmail.com";
    if ($email) {
        $top5Sets = getUserStatsByEmail_Sets($email);
        header('Content-Type: application/json');
        echo json_encode($top5Sets);
    } else {
        echo json_encode(["error" => "Invalid token."]);
    }


}

?>
