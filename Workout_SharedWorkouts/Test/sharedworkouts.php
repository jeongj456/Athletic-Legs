<?php
    include '../Navbar/navbar.php';
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <title>Shared Workouts</title>
    <link rel="stylesheet" href="../../Navbar/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Josefin Sans' rel='stylesheet'>
    <link rel="stylesheet" media="screen and (max-width: 600px)" href="sharedworkouts_mobile.css">
    <link rel="stylesheet" media="screen and (min-width: 601px)" href="sharedworkouts.css">
</head>

<body>
    <input type="hidden" id="csrf_token" value="<?php session_start(); echo $_SESSION['csrf_token'];?>"></>
    <div class="container">
        <div class="top-of-page">
            <div class="title">
                Shared Workouts
            </div>
        </div>
        <div>Accepted Workouts</div>
        <div class="content">
            <div class="bottom-container">
                <div class="top">
                    <div id="units">
                        Received
                        <label class="switch">
                            <input type="checkbox" name="unit" id="unit">
                            <span class="slider round"></span>
                        </label>
                        Shared
                    </div>

                    <div class="SearchBar">
                        <form id="searchForm">
                            <input type="text" id="searchInput" placeholder="Search workout by title..." required>
                            <button type="submit" id="searchworkoutname">Search</button>
                        </form>
                        <button id="clearSearchBtn">Clear Filter</button>
                    </div>

                    <div class="made-buttons" id="incoming">
                        <a href="incomingworkouts.php" style="text-decoration: none; color: inherit;">
                            Incoming Workouts
                        </a>
                    </div>
                </div>

                <div class="bottom">

                    <div class="workout-list">
                        <div class="workout" id="allcards">
                            <?php
                            $conn = mysqli_connect('localhost', 'jjjeong', '50233699', 'cse442_2024_fall_team_m_db');
                            # Getting email from auth token
                            $auth_token = $_COOKIE["Authentication_Token"];
                            $query = "SELECT * FROM User_Accounts_Table WHERE id = '$auth_token'";
                            $result = $conn->query($query);
                            $row = $result->fetch_assoc();
                            $email = $row['Email'];

                            # Get all workouts id numbers in shared workouts table with the email equal to sent_to and acceptance set to 1(means you accepted)
                            $query = "SELECT * FROM shared_workouts WHERE sent_to = '$email' AND acceptance = 1";
                            $result = $conn->query($query);
                            $rows = $result->fetch_all(MYSQLI_ASSOC);
                            foreach ($rows as $row) {
                                $id = $row['ID'];
                                $query1 = "SELECT * FROM planned_workouts WHERE ID = '$id'";
                                $result1 = $conn->query($query1);
                                $wks = $result1->fetch_assoc();
                                $workout_title = $wks['Workout_Title'];
                                $workout_movements = $wks['Workout_Movements'];
                                $movements = "";
                                $array = explode(',', $workout_movements); //split string into array seperated by ', '
                                foreach ($array as $value) //loop over values
                                {
                                    $movement = "<li>" . $value . "</li>";
                                    $movements .= $movement;
                                }
                                $all_shared_workouts .= "
                                        <div class='individualWorkout'>
                                            <div class='WorkoutTitle'>
                                                <strong>" . $workout_title . "</strong>
                                                <hr>
                                                <br>
                                            </div>
                                            <div class='WorkoutList'>
                                                <ul>" . $movements . "</ul>
                                            </div>
                                        </div>";
                            }
                            echo $all_shared_workouts;

                            ?>
                            <script>
                                const csrf_token = document.getElementById("csrf_token").value;

                                document.getElementById("unit").addEventListener("change", switchCards);
                                document.getElementById("searchForm").addEventListener("submit", getCards);
                                document.getElementById("clearSearchBtn").addEventListener("click", switchCards);

                                function switchCards() {
                                    var toggle = document.getElementById("unit"); // Get toggle to see if it is checked
                                    var workoutcards = document.getElementById("allcards");
                                    if (toggle.checked) {
                                        // Display workouts you shared(sent)
                                        fetch('./backend.php?action=sent_from', {
                                            method: 'GET',
                                            headers: {
                                                "X-CSRF-Token": csrf_token,
                                                'Content-Type': 'application/json',
                                            },
                                        })
                                            .then(response => response.json())
                                            .then(result => {
                                                workoutcards.innerHTML = result.message;
                                                console.log(result.message);
                                            })
                                            .catch(error => {
                                                console.error("Error:", error);
                                                alert("An error occurred while trying to retrieve all shared workouts.");
                                            });
                                    } else {
                                        // Display workouts you shared(sent)
                                        fetch('./backend.php?action=sent_to', {
                                            method: 'GET',
                                            headers: {
                                                "X-CSRF-Token": csrf_token,
                                                'Content-Type': 'application/json',
                                            },
                                        })
                                            .then(response => response.json())
                                            .then(result => {
                                                workoutcards.innerHTML = result.message;
                                                console.log(result.message);
                                            })
                                            .catch(error => {
                                                console.error("Error:", error);
                                                alert("An error occurred while trying to retrieve all received workouts.");
                                            });
                                    }
                                }

                                function getCards() {
event.preventDefault();
var workoutcards = document.getElementById("allcards");
                                    var workout_name = encodeURIComponent(document.getElementById("searchInput").value.trim());
                                    var to_or_from;
                                    if (document.getElementById("unit").checked){
                                        to_or_from = 'sent_from'; //shared
                                    }else{
                                        to_or_from = 'sent_to';  //received and acceptance is 1
                                    }

                                    fetch('./backend.php?action=search&workout_name=' + workout_name + '&tof=' + to_or_from, {
                                        method: 'GET',
                                        headers: {
                                            "X-CSRF-Token": csrf_token,
                                            'Content-Type': 'application/json',
                                        },
                                    })
.then(response => {
    if (!response.ok) {
        throw new Error("Network response was not ok");
    }
    return response.json();
})
.then(result => {
    workoutcards.innerHTML = result.workouts || result.message;
    console.log(result.message || result.workouts);
})
.catch(error => {
    console.error("Error:", error);
    alert("An error occurred while searching. Please try again.");
});
                                }
                                

                            </script>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>