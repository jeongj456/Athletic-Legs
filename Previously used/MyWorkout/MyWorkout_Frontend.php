include './MyWorkout_Backend.php';
<?php
include '../Navbar/navbar.php';

$workouts = fetchWorkouts();
?>
<!DOCTYPE html>
<html lang="en" class="TotalPage">

<head>
    <link rel="stylesheet" href="../Navbar/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Josefin Sans' rel='stylesheet'>
    <link rel="stylesheet" href="./WorkoutCards.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planned Workouts</title>
</head>

<body class="TotalPageBody">
    <div class="StickyHeader">
        <div class="TotalHeader">
            <div class="Header">
                <div class="Title">
                    <h1>Planned Workouts</h1>
                </div>

                <div id="workoutModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Add New Workout</h2>
                        <form id="workoutForm">
                            <input type="text" id="dayName" placeholder="Workout Day (e.g., Chest Day)" required>
                            <input type="text" id="workoutInput" placeholder="Enter Workout" required>
                        </form>
                        <ul id="workoutList"></ul>
                        <button type="button" id="addWorkoutBtn">Add Workout</button>
                        <!-- Save Workout Button -->
                        <button type="button" id="saveWorkoutBtn">Save Workout</button>
                    </div>
                </div>

                <div id="logDataModal" class="modal">
                    <div class="modal-content-logWorkout">
                        <span class="logDataClose">&times;</span>
                        <h2>Log Workout Data</h2>
                        <form id="logDataForm">
                            <div id="logWorkoutDetails">
                                <!-- All workout rows will populate here -->
                            </div>
                        </form>
                        <button type="button" id="saveLogDataBtn">Save Data</button>
                    </div>
                </div>


                <div id="editWorkoutModal" class="modal">
                    <div class="modal-content">
                        <span class="editWorkoutClose">&times;</span>
                        <h2>Edit Existing Workout</h2>
                        <form id="editWorkoutForm">
                            <div>
                                <h3> Workout Title </h3>
                                <input type="text" id="editDayName" placeholder="Workout Day (e.g., Chest Day)"
                                    required>
                            </div>
                            <div>
                                <p class="WarningText">*To remove workouts please click on the workout to remove*</p>
                                <ul id="editWorkoutList"></ul> <!-- List of existing workouts -->
                            </div>
                            <div>
                                <h3> Add Workout </h3>
                                <input type="text" id="editWorkoutInput" placeholder="Enter Workout" required>
                            </div>
                        </form>
                        <button type="button" id="addEditWorkoutBtn">Add Workout</button>
                        <button type="button" id="saveEditWorkoutBtn">Save Changes</button>
                    </div>
                </div>


                <div id="shareWorkoutModal" class="modal">
                    <div class="modal-content">
                        <span class="shareWorkoutClose">&times;</span>
                        <h2>Who would you like to share this workout with?</h2>
                        <input type="text" id="sent_to" placeholder="Please enter email" required>
                        <button type="button" id="shareWorkoutBtn">Share this Workout</button>
                    </div>
                </div>

            </div>
        </div>
        <hr>
        <br>
        <div class="SearchBar">
            <form id="searchForm">
                <input type="text" id="searchInput" placeholder="Search workout by title..." required>
                <button type="submit">Search</button>
            </form>
            <button id="clearSearchBtn">Clear Filter</button>
        </div>
        <div class="AddWorkoutButton">
            <button id="openModalBtn">Add New Workout</button>
        </div>
    </div>
    <div class="workout-list">
        <?php foreach ($workouts as $workout): ?>
            <div class="workout">
                <div class="individualWorkout">
                    <div class="VerticalEllipses">
                        <i class="fa fa-ellipsis-v"></i>
                        <div class="dropdown-content">
                            <ul>
                                <li class="edit-workout" data-id="<?php echo (int) $workout['ID']; ?>">Edit</li>
                                <li class="delete-workout" data-id="<?php echo (int) $workout['ID']; ?>">Delete</li>
                                <li class="log-data" data-id="<?php echo (int) $workout['ID']; ?>">Log Data</li>
                                <li class="share-workout" data-id="<?php echo (int) $workout['ID']; ?>">Share</li>
                            </ul>
                        </div>
                    </div>
                    <div class="WorkoutTitle">
                        <strong><?php echo htmlspecialchars($workout['Workout_Title']); ?></strong>
                        <hr>
                        <br>
                    </div>
                    <div class="WorkoutList">
                        <ul>
                            <?php
                            $movements = explode(",", $workout['Workout_Movements']);
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

        var editWorkoutModal = document.getElementById("editWorkoutModal");
        var shareWorkoutModal = document.getElementById("shareWorkoutModal");
        var editWorkoutspan = document.getElementsByClassName("editWorkoutClose")[0]; // Make sure this targets the right close button
        var shareWorkoutspan = document.getElementsByClassName("shareWorkoutClose")[0];

        // Attach event listener to all edit workout buttons
        document.querySelectorAll('.edit-workout').forEach(function (editBtn) {
            editBtn.onclick = function () {
                editWorkoutModal.style.display = "block";
            }
        });

        // When the user clicks on <span> (x), close the modal
        editWorkoutspan.onclick = function () {
            editWorkoutModal.style.display = "none";
        }
        shareWorkoutspan.onclick = function() {
            shareWorkoutModal.style.display = "none";
        }
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
            if (event.target == editWorkoutModal) {
                editWorkoutModal.style.display = "none";
            }
            if (event.target == shareWorkoutModal) {
                shareWorkoutModal.style.display == "none";
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



        document.getElementById("saveLogDataBtn").addEventListener("click", function () {
            // Retrieve all the logged workout details
            const sets = Array.from(document.querySelectorAll("input[name='sets[]']")).map(input => input.value);
            const reps = Array.from(document.querySelectorAll("input[name='reps[]']")).map(input => input.value);
            const weights = Array.from(document.querySelectorAll("input[name='weight[]']")).map(input => input.value);
            const workoutDetails = [];

            // Collecting workout details to match the format expected by AddFullWorkout
            Array.from(document.querySelectorAll(".workout-row")).forEach((row, index) => {
                workoutDetails.push({
                    workout: row.querySelector("p").textContent,
                    sets: sets[index],
                    reps: reps[index],
                    weight: weights[index]
                });
            });

            const data = {
                Workout_Title: document.querySelector("#logWorkoutDetails h3").textContent, // or another identifier
                workout_Info: workoutDetails,
                Workout_TypeInputs: ["Strength", "Endurance"], // Example type inputs, replace as necessary
                Workout_Date: new Date().toISOString().slice(0, 10), // Current date in yyyy-mm-dd format
                loggingWorkout: true // Flag to indicate the logging operation
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
                        alert("Workout data logged successfully!");
                        logDataModal.style.display = "none";  // Close the modal
                    } else {
                        alert("Error logging data: " + result.message);
                    }
                })
                .catch(error => {
                    console.error("Error:", error);  // Log full error
                    console.error("Full response text:", error.response ? error.response.text() : "No response text");
                    alert("An error occurred while logging the data. Please check the console for more details.");
                });

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
                .then(response => {
                    if (!response.ok) {
                        // Handle server errors (like 500)
                        throw new Error('Server error: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(result => {
                    if (result.success) {
                        alert("Workout saved successfully!");

                        // Add the new workout to the DOM with the correct workoutID from the server response
                        var workoutListDiv = document.querySelector('.workout-list');

                        var newWorkoutDiv = document.createElement('div');
                        newWorkoutDiv.classList.add('workout');

                        // Structure of the new workout div with the correct workoutID
                        var workoutContent = `
                <div class="individualWorkout">
                    <div class="VerticalEllipses">
                        <i class="fa fa-ellipsis-v"></i>
                        <div class="dropdown-content">
                            <ul>
                                <li class="edit-workout" data-id="<?php echo (int) $workout['ID']; ?>">Edit</li>
                                <li class="delete-workout" data-id="<?php echo (int) $workout['ID']; ?>">Delete</li>
                                <li class="log-data" data-id="<?php echo (int) $workout['ID']; ?>">Log Data</li>
                                <li class="share-workout" data-id="<?php echo (int) $workout['ID']; ?>">Share</li>
                                </ul>
                        </div>
                    </div>
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

                        // Prepend the new workout to the DOM
                        workoutListDiv.prepend(newWorkoutDiv);

                        // Clear the form, the workout list array, and close the modal
                        workoutList = [];
                        document.getElementById("workoutList").innerHTML = "";  // Clear the workout list displayed in the modal
                        document.getElementById("dayName").value = "";          // Clear the day name input
                        document.getElementById("workoutInput").value = "";     // Clear the workout input

                        modal.style.display = "none";  // Close the modal
                        window.location.reload();
                    } else {
                        alert("Error saving workout: " + result.message);
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred while saving the workout. Please try again.");
                });
        });






        var logDataModal = document.getElementById("logDataModal");
        var logDataClose = document.getElementsByClassName("logDataClose")[0];

        // Event delegation to open the Log Data modal with workout data
        document.querySelector('.workout-list').addEventListener('click', function (event) {
            if (event.target.classList.contains('log-data')) {
                const workoutId = event.target.getAttribute('data-id');

                // Fetch the workout details from the DOM (or via AJAX if needed)
                const workoutElement = event.target.closest('.workout');
                const dayName = workoutElement.querySelector('.WorkoutTitle strong').textContent;
                const workouts = Array.from(workoutElement.querySelectorAll('.WorkoutList li')).map(li => li.textContent.trim());

                // Populate the modal with workout details
                document.getElementById("logWorkoutDetails").innerHTML = `
            <h3>${dayName}</h3>
            <ul>${workouts.map(workout => `<li>${workout}</li>`).join('')}</ul>
        `;

                logDataModal.style.display = "block";
            }
        });

        // Close the Log Data modal when the close button is clicked
        logDataClose.onclick = function () {
            logDataModal.style.display = "none";
        };

        // Close the Log Data modal when clicking outside of it
        window.onclick = function (event) {
            if (event.target == logDataModal) {
                logDataModal.style.display = "none";
            }
        };


        document.getElementById("saveLogDataBtn").addEventListener("click", function () {
            logDataModal.style.display = "none";
        });



        document.getElementById("shareWorkoutBtn").addEventListener("click", function () {
            var sent_to = document.getElementById("sent_to").value;

            if (sent_to.trim() == "") {
                alert("Please enter an email.");
                return;
            }

            var data = {
                send_to: sent_to,
                workoutID: workoutToShare
            };

            fetch("./MyWorkout_Backend.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
                .then(response => {
                    if (!response.ok) {
                        // Handle server errors (like 500)
                        throw new Error('Server error: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(result => {
                    if (result.success) {
                        alert("Workout shared successfully!");

                        shareWorkoutModal.style.display = "none";  // Close the modal
                        window.location.reload();
                    } else {
                        alert("Error sharing workout: " + result.message);
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Invalid receiver");
                });
        });



        var editWorkoutModal = document.getElementById("editWorkoutModal");
        var editWorkoutForm = document.getElementById("editWorkoutForm");
        var editDayNameInput = document.getElementById("editDayName");
        var editWorkoutListUl = document.getElementById("editWorkoutList");
        var editWorkoutInput = document.getElementById("editWorkoutInput");
        var workoutToEdit = null; // Store workout ID to be edited
        var workoutToShare =null;

        // Event delegation for deleting workouts
        document.querySelector('.workout-list').addEventListener('click', function (event) {
            // Check if the clicked element is a delete button
            if (event.target.classList.contains('log-data')) {
                const workoutId = event.target.getAttribute('data-id');
                const workoutElement = event.target.closest('.workout');
                const dayName = workoutElement.querySelector('.WorkoutTitle strong').textContent;
                const workouts = Array.from(workoutElement.querySelectorAll('.WorkoutList li')).map(li => li.textContent.trim());

                // Populate the modal with workout details in a table format

                const logWorkoutDetails = document.getElementById("logWorkoutDetails");
                logWorkoutDetails.innerHTML = `<h3>${dayName}</h3>`;

                workouts.forEach((workout, index) => {
                    const workoutRow = document.createElement('div');
                    workoutRow.classList.add('workout-row');
                    workoutRow.innerHTML = `
                        <p>${workout}</p>
                        <label for="sets-${index}">Sets:</label>
                        <input type="number" id="sets-${index}" name="sets[]" required>

                        <label for="reps-${index}">Reps:</label>
                        <input type="number" id="reps-${index}" name="reps[]" required>

                        <label for="weight-${index}">Weight (lbs):</label>
                        <input type="number" id="weight-${index}" name="weight[]" required>
                    `;
                    logWorkoutDetails.appendChild(workoutRow);
                });

                logDataModal.style.display = "block";
            } else if (event.target.classList.contains('delete-workout')) {
                const workoutId = event.target.getAttribute('data-id'); // Get the workout ID from the data-id attribute

                var data = {
                    workoutID: workoutId,
                };

                fetch("./MyWorkout_Backend.php", {
                    method: "PATCH", // Using PATCH method to handle deletion
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(data)
                })
                    .then(response => {
                        if (!response.ok) {
                            // Handle non-200 responses
                            throw new Error('Server responded with error: ' + response.statusText);
                        }
                        return response.json(); // Parse the JSON from the response
                    })
                    .then(result => {
                        if (result.success) {
                            // Remove the workout from the DOM after successful deletion
                            const workoutElement = event.target.closest('.workout');
                            workoutElement.classList.add('fade-out');
                            setTimeout(() => workoutElement.remove(), 500); // Wait for fade-out effect
                            alert('Workout deleted successfully!');
                        } else {
                            // Handle the case where success is false
                            throw new Error("Error deleting workout: " + result.message);
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("An error occurred while deleting the workout. Please try again.");
                    });
            } else if (event.target.classList.contains('edit-workout')) {
                //Fetch for sending edits to the backend
                const workoutId = event.target.getAttribute('data-id');
                workoutToEdit = workoutId; // Store the workout ID being edited

                // Fetch the existing workout details (assuming you have the data in the DOM)
                var workoutElement = event.target.closest('.workout');
                var dayName = workoutElement.querySelector('.WorkoutTitle strong').textContent;
                var workouts = Array.from(workoutElement.querySelectorAll('.WorkoutList li')).map(li => li.textContent.trim());

                // Populate the modal with the existing data
                editDayNameInput.value = dayName;
                editWorkoutListUl.innerHTML = ''; // Clear any existing workouts
                workouts.forEach(workout => {
                    var li = document.createElement('li');
                    li.textContent = workout;
                    editWorkoutListUl.appendChild(li);
                });

                editWorkoutModal.style.display = 'block'; // Show modal

            } else if (event.target.classList.contains('share-workout')) {
                //Fetch for sending edits to the backend
                const workoutId = event.target.getAttribute('data-id');
                //workoutToEdit = workoutId; // Store the workout ID being edited
                workoutToShare = workoutId; // Store the workout ID being shared

                shareWorkoutModal.style.display = 'block'; // Show modal

            }
        });


        // Function to toggle the dropdown
        document.querySelectorAll('.fa-ellipsis-v').forEach((ellipsis) => {
            ellipsis.addEventListener('click', function (event) {
                // Get the dropdown content that is next to the clicked ellipsis
                var dropdown = this.nextElementSibling;

                // Hide all other dropdowns
                document.querySelectorAll('.dropdown-content').forEach((content) => {
                    if (content !== dropdown) {
                        content.style.display = 'none';
                    }
                });

                // Toggle the current dropdown visibility
                dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
            });
        });

        // Close the dropdown if the user clicks outside of it
        window.addEventListener('click', function (event) {
            // If the clicked element is not an ellipsis or within a dropdown, close all dropdowns
            if (!event.target.matches('.fa-ellipsis-v') && !event.target.closest('.dropdown-content')) {
                document.querySelectorAll('.dropdown-content').forEach((dropdown) => {
                    dropdown.style.display = 'none';
                });
            }
        });

        document.getElementById('addEditWorkoutBtn').addEventListener('click', function () {
            var workout = editWorkoutInput.value.trim();
            if (workout) {
                var li = document.createElement('li');
                li.textContent = workout;
                editWorkoutListUl.appendChild(li);
                editWorkoutInput.value = ''; // Clear input field
            } else {
                alert("Please enter a workout.");
            }
        });
        document.getElementById('saveEditWorkoutBtn').addEventListener('click', function () {
            var updatedDayName = editDayNameInput.value.trim();
            var updatedWorkouts = Array.from(editWorkoutListUl.querySelectorAll('li'))
                .filter(li => !li.classList.contains('strikethrough'))
                .map(li => li.textContent.trim());

            if (updatedDayName === '' || updatedWorkouts.length === 0) {
                alert('Please provide a day name and at least one workout.');
                return;
            }
            var data = {
                workoutID: workoutToEdit,
                day_name: updatedDayName,
                workouts: updatedWorkouts
            };

            fetch("./MyWorkout_Backend.php", {
                method: "PATCH",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        alert("Workout updated successfully!");
                        location.reload(); // Optionally reload the page to reflect changes
                    } else {
                        alert("Error updating workout: " + result.message);
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred while updating the workout. Please try again.");
                });

            editWorkoutModal.style.display = 'none'; // Close the modal
        });
        editWorkoutListUl.addEventListener('click', function (event) {
            if (event.target.tagName === 'LI') {
                event.target.classList.toggle('strikethrough');
            }
        });

        document.getElementById("searchForm").addEventListener("submit", function (e) {
            e.preventDefault(); // Prevent form from submitting traditionally

            var query = document.getElementById("searchInput").value.trim();

            if (query) {
                fetch('./MyWorkout_Backend.php?action=search&query=' + encodeURIComponent(query))
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            displaySearchResults(result.workouts);
                        } else {
                            alert("Error: " + result.message);
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("An error occurred while searching. Please try again.");
                    });
            } else {
                alert("Please enter a search query.");
            }
        });
        function setupEllipsesListeners() {
            document.querySelectorAll('.fa-ellipsis-v').forEach((ellipsis) => {
                ellipsis.addEventListener('click', function (event) {
                    var dropdown = this.nextElementSibling;
                    document.querySelectorAll('.dropdown-content').forEach((content) => {
                        if (content !== dropdown) {
                            content.style.display = 'none';
                        }
                    });
                    dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
                });
            });
        }

        // Function to display search results dynamically
        function displaySearchResults(workouts) {
            var workoutListDiv = document.querySelector('.workout-list');
            workoutListDiv.innerHTML = ""; // Clear the previous workout list

            if (workouts.length > 0) {
                workouts.forEach(workout => {
                    var newWorkoutDiv = document.createElement('div');
                    newWorkoutDiv.classList.add('workout');

                    var workoutContent = `
                <div class="individualWorkout">
                    <div class="VerticalEllipses">
                        <i class="fa fa-ellipsis-v"></i>
                        <div class="dropdown-content">
                            <ul>
                                <li class="edit-workout" data-id="${workout.ID}">Edit</li>
                                <li class="delete-workout" data-id="${workout.ID}">Delete</li>
                                <li class="log-data" data-id="<?php echo (int) $workout['ID']; ?>">Log Data</li>
                                <li class="share-workout" data-id="<?php echo (int) $workout['ID']; ?>">Share</li>
                            </ul>
                        </div>
                    </div>
                    <div class="WorkoutTitle">
                        <strong>${workout.Workout_Title}</strong>
                        <hr>
                        <br>
                    </div>
                    <div class="WorkoutList">
                        <ul>
                            ${workout.Workout_Movements.split(',').map(movement => `<li>${movement.trim()}</li>`).join('')}
                        </ul>
                    </div>
                </div>
            `;
                    newWorkoutDiv.innerHTML = workoutContent;
                    workoutListDiv.appendChild(newWorkoutDiv);
                });
                setupEllipsesListeners();
            } else {
                workoutListDiv.innerHTML = "<p>No workouts found.</p>";
            }
        }

        document.getElementById("clearSearchBtn").addEventListener("click", function () {
            document.getElementById("searchInput").value = "";
            fetch('./MyWorkout_Backend.php?action=fetch') // Specify action=fetch
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        displaySearchResults(result.workouts);
                    } else {
                        alert("Error: " + result.message);
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred while resetting the workout list. Please try again.");
                });
        });
    </script>
</body>

</html>