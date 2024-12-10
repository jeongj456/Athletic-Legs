<?php
include './BackEnd.php';
$workoutData = TableDataOUT();
//$workoutSubmission = SubmitDataIN();
?>

<!DOCTYPE html>
<html>
    <head>
    <!-- <link rel="stylesheet" href="./WorkoutHistoryStyling.css"> -->
     <style>
        /* General styles */
        body {
            background-color: #006CA1;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #000000;
            text-align: center;
        }

        #blackMedium {
            font-family: verdana;
            font-size: 20px;
            color: #000000;
            width: 100%;
            max-width: 300px;
            border: 15px #006CA1;
            padding: 50px;
            margin: 20px auto;
        }

        /* Form container styles */
        form {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            margin: 20px;
        }

        form label, form input {
            width: 100%;
            max-width: 300px;
        }

        /* Table title and data styles for larger screens */
        .Table_title{
            border-bottom: 5px solid #000;
            display: flex;
            flex-wrap: wrap;
            background-color: rgba(255, 255, 255, .75);
            justify-content: center;
        }

        .Table_title > div {
            background-color: rgb(0, 0, 0);
            width: 200px;
            margin: 10px;
            text-align: center;
            line-height: 75px;
            font-size: 30px;
            color: rgb(255, 255, 255);
        }
        .Table_data > div{
            outline: 2px solid #000;
            /* background-color: rgba(255, 255, 255, .75); */
            width: 200px;
            margin: 10px;
            text-align: center;
            line-height: 75px;
            font-size: 30px;
            color: rgb(0,0,0);
        }

        .WorkoutWrap {
            display: flex;
            flex-wrap: wrap;
            font-size: 20px;
            text-align: center;
        }

        /* Dividing line between workouts */
        .Table_data {
            border-bottom: 5px solid #000; /* Divider line between each workout */
            display: flex;
            flex-wrap: wrap;
            background-color: rgba(255, 255, 255, .75);
            justify-content: center;
            
        }

        /* Mobile responsiveness */
        @media only screen and (max-width: 768px) {
            .Table_title, .Table_data {
                flex-wrap: wrap; /* Wrap the table items for small screens */
            }

            .Table_title > div, .Table_data > div {
                width: 100%; /* Make each item full width on smaller screens */
                margin: 5px 0;
                line-height: 50px; /* Reduce line-height for smaller screens */
                font-size: 20px; /* Adjust font size for mobile */
            }

            form {
                flex-direction: column; /* Stack form elements vertically */
                gap: 5px;
            }

            form label, form input {
                max-width: 100%; /* Make form elements full width */
                margin: 5px 0;
            }

            .Table_data {
                flex-direction: column; /* Stack workouts vertically on smaller screens */
                margin-bottom: 20px; /* Add space between each workout */
            }
        }

        input[type=text] {
            width: 100%;
            padding: 5px 20px;
            margin: 8px 0;
            box-sizing: border-box;
        }


     </style>

</head>
    <body>
        <h1>Workout History</h1>
        <form method="POST"  class="WorkoutWrap">
            <div style="display: flex; gap: 10px; align-items: center;">
                <label for="workout_name">Workout Name:</label>
                <input type="text" id="workout_name" name="workout_name" required>

                <label for="weight">Weight:</label>
                <input type="text" id="weight" name="weight" required>

                <label for="rep_count">Rep Count:</label>
                <input type="text" id="rep_count" name="rep_count" required>

                <label for="set_count">Set Count:</label>
                <input type="text" id="set_count" name="set_count" required>

                <label for="workout_date">Workout Date:</label>
                <input type="date" id="workout_date" name="workout_date" required>

                <input type="submit" value="Submit">
            </div>
        </form>
        <hr>
        <div class = "Table_title">
            <div>Date</div>
            <div>Name</div>
            <div>Weight</div>
            <div>total reps</div>
            <div>total sets</div>
        </div>
        <?php
        // Split the Workout_Movements string by colon
        $DataEntry = explode(":", $workoutData);

        // Iterate over each movement and display as a list item
        foreach ($DataEntry as $entry) {
            // Split each entry by comma
            $itemData = explode(",", $entry);

            // Check if there are exactly 5 items (Date, Name, Weight, Total Reps, Total Sets)
            if (count($itemData) == 5) {
                // Output each item in the desired format
                echo "<div class='Table_data'>";
                echo "<div>{$itemData[0]}</div>"; // Date
                echo "<div>{$itemData[1]}</div>"; // Name
                echo "<div>{$itemData[2]}</div>"; // Weight
                echo "<div>{$itemData[3]}</div>"; // Total Reps
                echo "<div>{$itemData[4]}</div>"; // Total Sets
                echo "</div>";
            }
            //echo "<br>";
        }
        ?>
    </body>
    </html>
    
    
    <!-- <div class = "Table_data">
            <ul>
                
                  Split the Workout_Movements string by collan
                 $DataEntry = explode(":", $workoutData);
                 // Iterate over each movement and display as a list item
                 foreach ($DataEntry as $entry) {
                    // Split each entry by comma
                     $itemData = explode(",", $entry);
                     echo $itemData[0];
                 }
                ?>
            </ul>
        </div> -->