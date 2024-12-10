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
        background-color: rgba(191, 218, 231, 255);
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

    /* .TotalPage{

    background-color: #006CA1;

} */

    /* Modal container (background) */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 10;
        /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.8);
        /* Black w/ opacity */
    }

    /* Modal content */
    .modal-content {
        background-color: #fefefe;
        margin: 10% auto;
        /* 10% from top, centered */
        padding: 20px;
        border-radius: 10px;
        border: 1px solid #888;
        width: 80%;
        /* Could be more or less, depending on screen size */
        max-width: 600px;
        /* Maximum width */
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.7);
        /* Add shadow for a floating effect */
        text-align: center;
        /* Center the content */
    }

    /* The Close Button */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    /* Modal form styling */
    .modal-content form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        /* Two columns for the form fields */
        gap: 10px;
        justify-items: center;
    }

    .modal-content form input[type="text"] {
        width: 90%;
        padding: 10px;
        margin: 5px 0;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    /* Submit button styling */
    .modal-content form button[type="submit"] {
        grid-column: span 2;
        /* Make the button span both columns */
        background-color: #006CA1;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .modal-content form button[type="submit"]:hover {
        background-color: #004d75;
    }
</style>

<head>
    <!-- <link rel="stylesheet" href="./WorkoutCards.css"> -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planned Workouts</title>
</head>

<body>
    <div class="Header">
        <div class="Title">
            <h1>Planned Workouts</h1>
        </div>
        <button id="openModalBtn">Add New Workout</button>
      

        <div id="workoutModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Add New Workout</h2>
                <form id="workoutForm">
                    <input type="text" id="dayName" placeholder="Workout Day (e.g., Chest Day)" required>
                    <input type="text" id="workoutInput" placeholder="Enter Workout" required>
                    <button type="button" id="addWorkoutBtn">Add Workout</button>

                    <!-- List of added workouts -->
                    <ul id="workoutList"></ul>

                    <!-- Save Workout Button -->
                    <button type="button" id="saveWorkoutBtn">Save Workout</button>
                </form>
            </div>
        </div>

        <div class="ErrorMessage">
            <?php if (!empty($errorMsg)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($errorMsg); ?>
                </div>
            <?php endif; ?>
        </div>
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
    <script>
        // Get modal elements
        var modal = document.getElementById("workoutModal");
        var btn = document.getElementById("openModalBtn");
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal
        btn.onclick = function () {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function () {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // JavaScript to handle adding workouts to the list
        var workoutList = []; // Array to store workout list
        var workoutUl = document.getElementById("workoutList");

        document.getElementById("addWorkoutBtn").addEventListener("click", function () {
            var workoutInput = document.getElementById("workoutInput").value;

            if (workoutInput.trim() !== "") {
                workoutList.push(workoutInput); // Add workout to array

                // Add workout to the unordered list
                var li = document.createElement("li");
                li.textContent = workoutInput;
                workoutUl.appendChild(li);

                // Clear the input field
                document.getElementById("workoutInput").value = "";
            } else {
                alert("Please enter a workout.");
            }
        });

        // Handle save workout button click
        document.getElementById("saveWorkoutBtn").addEventListener("click", function () {
            var dayName = document.getElementById("dayName").value;
            if (dayName.trim() === "") {
                alert("Please enter a day name.");
                return; // Exit the function if no day name is provided
            }

            if (workoutList.length === 0) {
                alert("Please add at least one workout.");
                return; // Exit the function if no workouts have been added
            }

            var data = {
                day_name: dayName,
                workouts: workoutList
            };

            fetch("./MyWorkout_Backend.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        alert("Workout saved successfully!");

                        // Add the new workout to the DOM without refreshing the page
                        var workoutListDiv = document.querySelector('.workout-list'); // The container where workouts are displayed

                        // Create a new div for the new workout
                        var newWorkoutDiv = document.createElement('div');
                        newWorkoutDiv.classList.add('workout');

                        // Structure of the new workout div
                        var workoutContent = `
                            <div class="individualWorkout">
                                <div class="WorkoutTitle">
                                    <strong>${dayName}</strong>
                                    <hr>
                                    <br>
                                </div>
                                <div class="WorkoutList">
                                    <ul>
                                        ${workoutList.map(workout => `<li>${workout}</li>`).join('')}
                                    </ul>
                                </div>
                            </div>
                        `;

                        newWorkoutDiv.innerHTML = workoutContent;

                        // Append the new workout div to the workout list container
                        workoutListDiv.prepend(newWorkoutDiv); // Use prepend to add the workout at the top

                        // Clear the modal inputs and hide the modal
                        workoutList = []; // Clear the list of workouts
                        document.getElementById("workoutList").innerHTML = ""; // Clear the displayed list
                        document.getElementById("dayName").value = ""; // Clear the day name field
                        modal.style.display = "none"; // Close the modal
                    } else {
                        alert("Error saving workout: " + result.message); // Show error message from server
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred while saving the workout. Please try again.");
                });
        });


    </script>


</body>


</html>