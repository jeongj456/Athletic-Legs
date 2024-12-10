<?php
    $conn;
    # Connects to database
    $db_server = "localhost";
    $db_user = "jjjeong";
    $db_pass = "50233699";
    $db_name = "cse442_2024_fall_team_m_db";
    $auth_token = $_COOKIE["Authentication_Token"];
    $email = "";

    
    try{
        $conn = new mysqli($db_server, $db_user, $db_pass, $db_name);
    }catch(mysqli_sql_exception){
        echo"Connection Unsuccessful :(";
    }
    
    # Getting email from auth token
    $query = "SELECT * FROM User_Accounts_Table WHERE id = '$auth_token'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $email = $row['Email'];
    session_start();
    if ($_SERVER['HTTP_X_CSRF_TOKEN'] != $_SESSION['csrf_token']){
        echo('Fail');
        exit();  
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET')  {
        if ($_GET['action'] === 'sent_to') {
            # Get all workouts id numbers in shared workouts table with the email equal to sent_to and acceptance set to 1(means you accepted)
            $query = "SELECT * FROM shared_workouts WHERE sent_to = '$email' AND acceptance = 1";
            $all_workouts = getAllCards($query);
            echo json_encode(['success' => true, 'message' => $all_workouts]);
        } elseif ($_GET['action'] === 'sent_from') {
            # Get all workouts id numbers in shared workouts table with the email equal to sent_from/you sent
            $query = "SELECT * FROM shared_workouts WHERE sent_from = '$email'";
            $all_workouts = getAllCards($query);
            echo json_encode(['success' => true, 'message' => $all_workouts]);
        } elseif ($_GET['action'] === 'search') {
            if ($_GET['tof'] === "sent_from"){
                $query = "SELECT * FROM shared_workouts WHERE sent_from = '$email'";
                $all_workouts = searchAllCards($query, $_GET['workout_name']);
                echo json_encode( ['success' => true, 'workouts' => $all_workouts]);
            } elseif ($_GET['tof'] === "sent_to"){
                $query = "SELECT * FROM shared_workouts WHERE sent_to = '$email' AND acceptance = 1";
                $all_workouts = searchAllCards($query, $_GET['workout_name']);
		echo json_encode(['success' => true, 'workouts' => $all_workouts]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Action not within bounds']);
        }
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($data['action'] === 'acceptWorkout') {
            $id = $data['id'];
            $query = "UPDATE shared_workouts SET acceptance = 1 WHERE idx = '$id'";
    
            if ($conn->query($query) === TRUE) {
                echo json_encode(['success' => true, 'message' => 'Workout accepted']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update acceptance flag']);
            }
            exit;
        }else if ($data['action'] === 'denyWorkout'){
            $id = $data['id'];
            $query = "UPDATE shared_workouts SET acceptance = -1 WHERE idx = '$id'";
            if ($conn->query($query) === TRUE) {
                echo json_encode(['success' => true, 'message' => 'Workout accepted']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update acceptance flag']);
            }
            exit;
        }
    }

    function getAllCards($query){
        global $conn;
        $all_shared_workouts = "";
        $result = $conn->query($query);
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach($rows as $row){
            $id = $row['ID'];
            $query = "SELECT * FROM planned_workouts WHERE ID = '$id'";
            $result = $conn->query($query);
            $wks = $result->fetch_assoc();
            $workout_title = $wks['Workout_Title'];
            $workout_movements = $wks['Workout_Movements'];
            $movements = "";
            $array = explode(',', $workout_movements); //split string into array seperated by ', '
            foreach($array as $value) //loop over values
            {
                $movement = "<li>" . $value . "</li>";
                $movements .= $movement;
            }
            $all_shared_workouts .= "<div class='individualWorkout'><div class='WorkoutTitle'><strong>" . $workout_title . "</strong><hr><br></div><div class='WorkoutList'><ul>" . $movements . "</ul></div></div>";
        }
        return $all_shared_workouts;
    }
    
    function searchAllCards($query, $workout_name){
        global $conn;
        $all_shared_workouts = "";
        $result = $conn->query($query);
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach($rows as $row){
            $id = $row['ID'];
            $query = "SELECT * FROM planned_workouts WHERE ID = '$id' AND Workout_title = '$workout_name'";
            $result = $conn->query($query);
            $wks = $result->fetch_assoc();
            $workout_title = $wks['Workout_Title'];
            $workout_movements = $wks['Workout_Movements'];
            $movements = "";
            $array = explode(',', $workout_movements); //split string into array seperated by ', '
            foreach($array as $value) //loop over values
            {
                $movement = "<li>" . $value . "</li>";
                $movements .= $movement;
            }
            $all_shared_workouts .= "<div class='individualWorkout'><div class='WorkoutTitle'><strong>" . $workout_title . "</strong><hr><br></div><div class='WorkoutList'><ul>" . $movements . "</ul></div></div>";
        }
		
        return $all_shared_workouts;
    }
?>