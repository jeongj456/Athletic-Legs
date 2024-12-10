<?php
    //TableDataOUT();
    //SubmitDataIN();

function DataBase_Connect(): mysqli{
    //This is the test servers name
    $database_name = "tjmehok_db";
    //I belive this is the full name Matt gave us in his email
    $server_name = "localhost:3306";
    //The user name and password is how we sign into PHP admin
    // $user_name   = "tjmehok";
    // $password = "50407528";
    $user_name   = "root";
    $password = "";
    
    //This is the most important part
    //we are creating the mysqli class so it will eaisily connect everytime
    try {
        $connect = new mysqli($server_name, $user_name, $password, $database_name);
    //check the connection status
    //If the connection failed
    }catch (PDOException $e){
        die("Connection failed: " . mysqli_connect_error());
    } 
    return $connect;
    //If the connection succeded
}

//This function We will be taking
function TableDataOUT(): string{
    $DB = DataBase_Connect();
    $FinalOutString = "";

    $grabDataBase = $DB -> prepare("SELECT * FROM planned_workouts ORDER BY Workout_Date DESC LIMIT 10");
    $grabDataBase -> execute();
    $DataResult = $grabDataBase -> get_result();
    //echo $DataResult;
    for ($x = 0; $x < $DataResult->num_rows; $x++) {
        $row = $DataResult->fetch_assoc();

        //Continuously grabing the next string to send out to the front end
        $FinalOutString = $FinalOutString . $row["Workout_Date"] . "," . $row["Workout_Title"] . "," . $row["Workout_Results"] . "," . $row["Workout_Results"] . "," . $row["Workout_Results"] . ":";
    }

    $DB ->close();
    return $FinalOutString;
}

if ($_SERVER['REQUEST_METHOD'] ==='POST'){
    $DB = DataBase_Connect();

    $Workout_Name = isset($_POST["workout_name"]) ? $_POST["workout_name"] : "";
    $Weight = isset($_POST["weight"]) ? $_POST["weight"] : "";
    $Rep_Count = isset($_POST["rep_count"]) ? $_POST["rep_count"] : "";
    $Set_Count = isset($_POST["set_count"]) ? $_POST["set_count"] : "";
    $Workout_Date = isset($_POST["workout_date"]) ? $_POST["workout_date"] : "";
    
    $submitDataBase = $DB -> prepare("INSERT INTO Workout_History(Workout_Date, Workout_name, Weight, rep_count, set_count) VALUES (?,?,?,?,?)");
    $submitDataBase -> bind_param("sssss", $Workout_Date, $Workout_Name, $Weight, $Rep_Count, $Set_Count);

    if ($submitDataBase->execute()) { //If it executes correctly then print this out
       // Redirect to the same page to avoid resubmission
       header("Location: " . $_SERVER['PHP_SELF']);
       exit; // Important: stop further script execution
   } else {
       echo "<br> Some error occurred";
   }

    $DB ->close();
}



?>