<?php
include './MyWorkout_Backend.php';
$workouts = fetchWorkouts();
?>

<!DOCTYPE html>
<html lang="en" class="TotalPage">
<style>
    .workout {
        text-align: center;
        margin: 50px;
        flex: 1 1 calc(33% - 20px);
        display: inline-flex;
        justify-content: center;
        /* Centers the workout inside the flex container */
        padding-left: 5%;

    }

    .individualWorkout {
        height: 200px;
        /* Fixed height */
        width: 250px;
        /* Fixed width */
        outline: 2px solid #333;
        /* Outline with a dark color */
        overflow: hidden;
        /* Ensures content does not overflow the box */
        display: flex;
        flex-direction: column;
        align-items: center;
        /* Centers the content horizontally */
        padding: 20px;
        background-color: rgba(255, 255, 255, 0.75);
        /* Light background for better visibility */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    }

    .EnterWorkouts,
    .Title {
        justify-content: center;
        display: flex;
        align-items: center;
    }

    .WorkoutList {
        padding: 0;
        margin: 0;
        text-align: center;
        /* Ensures text inside the box is centered */
    }

    .WorkoutList ul {
        list-style: none;
        /*Removes default bullet points*/
        padding-left: 0;
        /* Ensures no extra padding on the left */
    }

    .WorkoutList li {
        padding-bottom: 2%;
        margin-bottom: 5px;
        /* Adds space between workout items */
        text-align: center;
        /* Aligns each list item in the center */
    }

    .ErrorMessage {
        justify-content: center;
        align-items: center;
        display: flex;
    }

    .TotalPage {

        background-color: #006CA1;

    }
</style>

<head>
    <link rel="stylesheet" href="./WorkoutCards.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planned Workouts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"] {
            margin: 5px;
        }

        button {
            margin-top: 10px;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }

        .workout-list {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="Title">
        <h1>Planned Workouts</h1>
    </div>
    <div class="EnterWorkouts">
        <form method="POST">
            <input type="text" name="day_name" placeholder="Workout Day (e.g., Chest Day)" required>
            <input type="text" name="workout1" placeholder="Workout 1">
            <input type="text" name="workout2" placeholder="Workout 2">
            <input type="text" name="workout3" placeholder="Workout 3">
            <input type="text" name="workout4" placeholder="Workout 4">
            <input type="text" name="workout5" placeholder="Workout 5">
            <button type="submit">Submit</button>
        </form>
        <!-- Display error message under the form -->

    </div>
    <div class="ErrorMessage">
        <?php if (!empty($errorMsg)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($errorMsg); ?>
            </div>
        <?php endif; ?>
    </div>
    <br>
    <hr>
    <div class="workout-list">
        <?php foreach ($workouts as $workout): ?>
            <div class="workout">
                <div class="individualWorkout">
                    <div class="WorkoutTitle">
                        <strong><?php echo htmlspecialchars($workout['Workout_Title']); ?></strong>
                        <hr>
                        <br>
                    </div>
                    <div class="WorkoutList">
                        <ul>
                            <?php
                            // Split the Workout_Movements string by comma
                            $movements = explode(",", $workout['Workout_Movements']);
                            // Iterate over each movement and display as a list item
                            foreach ($movements as $movement):
                                ?>
                                <li> <?php echo htmlspecialchars(trim($movement)); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>


</html>