<?php
include './WorkoutHistory_BackEnd.php';
include '../Navbar/navbar.php';
$workoutData = TableDataOUT(FilterGET(), "");
//$workoutSubmission = SubmitDataIN();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Workout History</title>
    <link rel="stylesheet" href="./WorkoutHistory_style.css">
    <link rel="stylesheet" href="../Navbar/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Josefin Sans' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
</head>

<body style="font-family: 'Josefin Sans'">
    <input type="hidden" id="csrf_token" value="<?php session_start();
    echo $_SESSION['csrf_token']; ?>">
    <div id="TitleBar">
        <!-- Title for the Workout History -->
        <h1>Workout History</h1>
    </div>

    <!-- Trigger/Open The Modal for filters-->
    <button class="open-modal-btn" data-modal="FilterModal">Open Filters</button>

    <!-- The Modal for the filter -->
    <div id="FilterModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h2>FILTERS</h2>
            </div>

            <div class="modal-body">
                <!-- creating a ability to send it to the backend -->
                <h3>Select Filters:</h3>
                <form id="filterForm">

                    <!-- Prompt -->
                    <!-- <h3>Select Filters:</h3> -->

                    <!-- Example checkbox categories -->
                    <div class="checkbox-row">
                        <label><input type="checkbox" name="filters[]" value="Sholders"> Sholders</label>
                        <label><input type="checkbox" name="filters[]" value="Biceps"> Biceps</label>
                        <label><input type="checkbox" name="filters[]" value="Triceps"> Triceps</label>
                    </div>

                    <div class="checkbox-row">
                        <label><input type="checkbox" name="filters[]" value="Abs"> Abs</label>
                        <label><input type="checkbox" name="filters[]" value="Back"> Back</label>
                        <label><input type="checkbox" name="filters[]" value="Chest"> Chest</label>
                    </div>

                    <div class="checkbox-row">
                        <label><input type="checkbox" name="filters[]" value="Quads"> Quads</label>
                        <label><input type="checkbox" name="filters[]" value="Calfs"> Calfs</label>
                        <label><input type="checkbox" name="filters[]" value="Hamstrings"> Hamstrings</label>
                    </div>

                    <div class="checkbox-row">
                        <label><input type="checkbox" name="filters[]" value="Date"> Date (Last 3 Months)</label>
                    </div>
                    <!-- Submit button at the bottom -->
                    <div>
                        <input type="submit" value="Submit" class="modal-submit-btn">
                    </div>
                </form>
            </div>

        </div>

    </div>


    <!-- Add Workout Button -->
    <button id="openWeightBtn" class="AddWorkoutButton">Add New Workout</button>


    <!--  add Workout modal -->
    <div id="workoutModal" class="modal" data-modal="ADDworkoutModal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="modal-header">
                <h2>ADDING WORKOUT</h2>
            </div>
            <!-- Here is where we are setting up the New Workouts -->
            <form id="workoutForm">

                <!-- I want the title to be at the top so as to not confuse users -->
                <div class="WorkoutWrap">
                    <label for="Workout title">Workout title:</label>
                    <input type="text" id="dayName" placeholder="Workout Day (e.g., Chest Day)" required>

                    <label for="workout_date">Workout Date:</label>
                    <input type="date" id="workoutDateInput" name="workout_date" required>

                    <div class="dropdown">
                        <button class=dropdown-btn>Workout type</button>
                        <div class="dropdown-content">
                            <label><input type="checkbox" name="WorkoutTypeInput" value="Sholders"> Sholders</label>
                            <label><input type="checkbox" name="WorkoutTypeInput" value="Biceps"> Biceps</label>
                            <label><input type="checkbox" name="WorkoutTypeInput" value="Triceps"> Triceps</label>
                            <label><input type="checkbox" name="WorkoutTypeInput" value="Abs"> Abs</label>
                            <label><input type="checkbox" name="WorkoutTypeInput" value="Back"> Back</label>
                            <label><input type="checkbox" name="WorkoutTypeInput" value="Chest"> Chest</label>
                            <label><input type="checkbox" name="WorkoutTypeInput" value="Quads"> Quads</label>
                            <label><input type="checkbox" name="WorkoutTypeInput" value="Calfs"> Calfs</label>
                            <label><input type="checkbox" name="WorkoutTypeInput" value="Hamstrings"> Hamstrings</label>
                        </div>
                    </div>
                </div>

                <br>
                <!-- <div class="alert warning">
                        <span class="closebtn" id="WarningMessage">&times;</span>  
                        <strong>Warning!</strong> multiple fields may be missing
                    </div> -->

                <div class="WorkoutWrap">
                    <label for="workout Name">Movement:</label>
                    <input type="text" id="workoutInput" placeholder="Enter Workout (e.g., Curls)" required>

                    <label for="weight">Weight:</label>
                    <input type="number" id="WeightInput" placeholder="Enter weight" required>

                    <label for="Reps">Reps:</label>
                    <input type="number" id="RepsInput" placeholder="Enter reps" required>

                    <label for="Sets">Sets:</label>
                    <input type="number" id="SetsInput" placeholder="Enter sets" required>
                </div>

            </form>
            <ul id="workoutList"></ul>
            <button type="button" id="addWorkoutBtn" class=addWorkoutBtn>Add Workout</button>
            <!-- Save Workout Button -->
            <button type="button" id="saveWorkoutBtn" class=saveWorkoutBtn>Save Workout</button>
        </div>
    </div>


    <!-- Add Workout Button -->
    <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
    <button id="openCardioBtn" class="AddCardioButton">Add New Cardio</button>

    <!--  add Cardio modal -->
    <div id="CardioModal" class="modal" data-modal="ADDcardioModal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="modal-header">
                <h2>ADDING CARDIO</h2>
            </div>
            <!-- Here is where we are setting up the New Workouts -->
            <form id="cardioForm">

                <!-- I want the title to be at the top so as to not confuse users -->
                <div class="CardioWrap">
                    <label for="Cardio title">Cardio title:</label>
                    <input type="text" id="CardioName" placeholder="Cardio name" required>

                    <label for="Cardio_date">Workout Date:</label>
                    <input type="date" id="CardioDateInput" name="Cardio_date" required>

                    <div class="dropdown">
                        <button class=dropdown-btn>Cardio type</button>
                        <div class="dropdown-content">
                            <label><input type="checkbox" name="CardioTypeInput" value="Running"> Running</label>
                            <label><input type="checkbox" name="CardioTypeInput" value="Swimming"> Swimming</label>
                            <label><input type="checkbox" name="CardioTypeInput" value="Rowing"> Rowing</label>
                            <label><input type="checkbox" name="CardioTypeInput" value="Biking"> Biking</label>
                            <label><input type="checkbox" name="CardioTypeInput" value="Custom"> Custom</label>
                        </div>
                    </div>
                </div>

                <br>
                <!-- <div class="alert warning">
                        <span class="closebtn" id="WarningMessage">&times;</span>  
                        <strong>Warning!</strong> multiple fields may be missing
                    </div> -->

                <div class="CardioWrap">
                    <label for="Cardio Name">Movement:</label>
                    <input type="text" id="CardioInput" placeholder="Enter Cardio (e.g., Run)" required>

                    <label for="Time">Time:</label>
                    <input type="number" id="TimeInput" placeholder="Enter Time(min)" required>

                    <label for="Distance">Distance:</label>
                    <input type="number" id="DistanceInput" placeholder="Enter Distance(Mile)" required>
                </div>

            </form>
            <ul id="CardioList"></ul>
            <button type="button" id="addCardioBtn" class=addCardioBtn>Add Cardio</button>
            <!-- Save Workout Button -->
            <button type="button" id="saveCardioBtn" class=saveCardioBtn>Save Cardio</button>
        </div>
    </div>
    <!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

    <div class="ErrorMessage">
        <?php if (!empty($errorMsg)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($errorMsg); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- This is going to be related to the search bar -->
    <form id="SearchFilter" class="search-container">
        <button id="clear-filter" onclick="clear_filter()">Clear</button>
        <input type="text" name="SearchBarInput" placeholder="Search workout by title..."><br>
        <button type="submit" id="SearchFilterButton" class="SearchFilterButton">Search</button>
    </form>

    <div class="Result_Table_containers">
        <!-- THIS FIRST SECTION IS FOR WEIGHT WORKOUTS
            //////////////////////////////////////////////////////////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
        <div class=WeightWorkoutSide>
            <div class="result_title">Weight RESULTS</div>
            <div class="Weight_Table_title">
                <div>Date</div>
                <div>Name</div>
                <div>info</div>
            </div>

            <!-- This is where we are hiding the php script -->
            <div id="workoutEntries">
                <!-- PHP script -->
                <?php
                // Split the Workouts string by colon
                //This gets a list of workouts
                $DataEntry = explode("?", $workoutData);
                //echo count($DataEntry);
                //echo $DataEntry[0];
                //echo $DataEntry[1];
                

                // Iterate over each movement and display as a list item
                foreach ($DataEntry as $entry) {
                    // SPLIT DATA FROM HOW THEY ARE FORMATTED IN THE DATA BASE AND BACKEND
                
                    //1 full workouts info
                    $WorkoutDATA = explode(";", $entry);

                    // Check if there are exactly 6 items (Date, Name, Movments, Results, Types, ID)
                    if (count($WorkoutDATA) == 8) {

                        $WorkoutCardioType = $WorkoutDATA[6];
                        $CreatorID = $WorkoutDATA[7];

                        if ($WorkoutCardioType == 0) {

                            //Grabbing the workout Date out of our array of information
                            $WorkoutDate = $WorkoutDATA[0];

                            //Grabbing the workout title out of our array of information
                            $WorkoutTitle = $WorkoutDATA[1];

                            //1 set of movments for a workout
                            $WorkoutMovements = explode(",", $WorkoutDATA[2]);
                            //Fixing our indexing issue
                            array_splice($WorkoutMovements, count($WorkoutMovements) - 1, 1);

                            //1 set of results for all movments
                            $WorkoutResults = explode("+_)(*&^%", $WorkoutDATA[3]);
                            //Fixing our indexing issue
                            array_splice($WorkoutResults, count($WorkoutResults) - 1, 1);

                            //1 set of types for this workout
                            $WorkoutTypes = explode(",", $WorkoutDATA[4]);
                            //Fixing our indexing issue
                            array_splice($WorkoutTypes, count($WorkoutTypes) - 1, 1);

                            $WorkoutID = $WorkoutDATA[5];

                            // Output each item in the desired format
                            ///////////////////////////////////////////////////////////////////////////////////////
                            echo "<div class='Table_data'>";
                            echo "<div>{$WorkoutDate}</div>"; // Date
                            echo "<div class='WorkoutTitleWeights' title='{$WorkoutTitle}'>{$WorkoutTitle}</div>"; // Name
                            echo "<div class='actionBTN'>";
                            echo "<div class= dropdown>";
                            echo "<button class= dropdown-btn >Actions</button>";
                            echo "<div class= dropdown-content >";
                            echo "<ul>";
                            echo "<li class=open-modal-btn data-modal= '{$WorkoutID}'       >Workout Info</button>";
                            echo "<li class=open-modal-btn data-modal= '{$WorkoutID}_editWeight'  >Edit</button>";
                            echo "<li class=open-modal-btn data-modal='deleteModal_{$WorkoutID}'>Delete</button>";
                            echo "</ul>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            ///////////////////////////////////////////////////////////////////////////////////////
                

                            //Creating the information modal
                            ///////////////////////////////////////////////////////////////////////////////////////
                            echo "<div id=  '{$WorkoutID}' class=modal>";
                            echo "<div class=modal-content>";
                            echo "<div class=modal-header>";
                            echo "<span class=close>&times;</span>";
                            echo "<h2 class=WWMT>Workout $WorkoutTitle</h2>";
                            echo "<h2>Created by: $CreatorID</h2>";
                            echo "</div>";
                            echo "<div class=modal-body>";
                            echo "<div class = WorkModal_title>";
                            echo "<div>Name</div>";
                            echo "<div>Weight</div>";
                            echo "<div>Reps used</div>";
                            echo "<div>Sets</div>";
                            echo "</div>";

                            //Need a for loop to go through all of the movments
                            //this needs to change to do length - 1 !!!!!!!
                            foreach ($WorkoutResults as $MovmentResult) {
                                $FMovmentResults = explode(",", $MovmentResult);
                                echo "<div class='WorkModal_data'>";
                                echo "<div>{$FMovmentResults[0]}</div>"; //Movment name
                                echo "<div>{$FMovmentResults[3]}</div>"; //Weight
                                echo "<div>{$FMovmentResults[2]}</div>"; //Reps
                                echo "<div>{$FMovmentResults[1]}</div>"; //Sets
                                echo "</div>";

                            }
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            ///////////////////////////////////////////////////////////////////////////////////////
                

                            //Creating the delete confirmation modal
                            ///////////////////////////////////////////////////////////////////////////////////////
                            echo "<div id='deleteModal_{$WorkoutID}' class='modal'>";
                            echo "<div class='modal-content'>";
                            echo "<div class='modal-header'>";
                            echo "<span class='close'>&times;</span>";
                            echo "<h2>Confirm Deletion</h2>";
                            echo "</div>";
                            echo "<div class='modal-body'>";
                            echo "<p>Are you sure you want to delete this workout?</p>";
                            echo "<button class='confirm-delete-btn' data-id='{$WorkoutID}' value = 0>Yes, Delete</button>";
                            echo "<button class='cancel-delete-btn'>Cancel</button>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            ///////////////////////////////////////////////////////////////////////////////////////
                

                            //Creating  the edit modal
                            ///////////////////////////////////////////////////////////////////////////////////////
                            echo "<div id='{$WorkoutID}_editWeight' class='modal'>";
                            echo "<div class='modal-content'>";
                            echo "<div class='modal-header'>";
                            echo "<span class='close'>&times;</span>";
                            echo "<h2 class=WWMT>Edit $WorkoutTitle</h2>";
                            echo "<h2>Created by: $CreatorID</h2>";
                            echo "</div>";

                            // Start of editing the single-use pieces of info: Date, Title, and Types
                            echo "<div class='edit-header-wrap'>";

                            // Editable Workout Title
                            echo "<label for='editWorkoutTitle'>Workout Title:</label>";
                            echo "<input type='text' id='editWorkoutTitle_{$WorkoutID}' name='editWorkoutTitle' placeholder='{$WorkoutTitle}' />";

                            // Editable Workout Date
                            echo "<label for='editWorkoutDate'>Workout Date:</label>";
                            echo "<input type='date' id='editWorkoutDate_{$WorkoutID}' name='editWorkoutDate' value='{$WorkoutDate}' />";

                            // Editable Workout Type Dropdown
                            echo "<div class='dropdown'>";
                            echo "<button>Workout Type</button>";
                            echo "<div class='dropdown-content' id='EditTypeCheckboxes'>";

                            // Workout type checkboxes (dynamically check if type is in $WorkoutTypes)
                            $types = ['Sholders', 'Biceps', 'Triceps', 'Abs', 'Back', 'Chest', 'Quads', 'Calfs', 'Hamstrings'];
                            foreach ($types as $type) {
                                $checked = in_array($type, $WorkoutTypes) ? 'checked' : '';  // If the type is in the $WorkoutTypes array, mark it as checked
                                echo "<label><input type='checkbox' name='EditWorkoutTypeInput' value='$type' $checked> $type</label>";
                            }

                            echo "</div>";
                            echo "</div>";
                            echo "</div>";

                            echo "<div class=modal-body>";
                            echo "<div class = WorkModal_title>";
                            echo "<div>Name</div>";
                            echo "<div>Weight</div>";
                            echo "<div>Reps used</div>";
                            echo "<div>Sets</div>";
                            echo "</div>";
                            // Create a list to hold workout movement fields
                            echo "<ul>";

                            // Loop through each movement and output it as a list item with input fields
                            foreach ($WorkoutResults as $MovmentResult) {
                                $FMovmentResults = explode(",", $MovmentResult);
                                echo "<li class='WorkModal_data'>";
                                echo "<input type='text' value='{$FMovmentResults[0]}' placeholder='Movement Name' />"; // Movement name
                                echo "<input type='number' value='{$FMovmentResults[3]}' placeholder='Weight' />"; // Weight
                                echo "<input type='number' value='{$FMovmentResults[2]}' placeholder='Reps' />"; // Reps
                                echo "<input type='number' value='{$FMovmentResults[1]}' placeholder='Sets' />"; // Sets
                                echo "<button type='button' class='delete-movement-btn'>Delete</button>"; //DELETE Button
                                echo "</li>";
                            }
                            echo "</ul>";

                            // Optional button to add new movement fields dynamically
                            echo "<button type='button' class='add-movement-btn'>Add New Movement</button>";

                            // The new Save Changes button for submitting the modal's data
                            echo "<button type='button' class='submit-edit-btn'>Save Changes</button>";

                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            ///////////////////////////////////////////////////////////////////////////////////////
                        }
                    }
                }
                ?>
            </div>
        </div>
        <!-- THIS FIRST SECTION IS FOR WEIGHT WORKOUTS
            //////////////////////////////////////////////////////////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

        <!-- THIS SECOND SECTION IS FOR CARDIO WORKOUTS
            //////////////////////////////////////////////////////////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
        <div class=CardioWorkoutSide>
            <div class="result_title">Cardio RESULTS</div>
            <div class="Cardio_Table_title">
                <div>Date</div>
                <div>Name</div>
                <div>info</div>
            </div>

            <!-- This is where we are hiding the php script -->
            <div id="Cardio_workoutEntries">
                <!-- PHP script -->
                <?php
                // Split the Workouts string by colon
                //This gets a list of workouts
                $DataEntry = explode("?", $workoutData);
                //echo count($DataEntry);
                //echo $DataEntry[0];
                //echo $DataEntry[1];
                

                // Iterate over each movement and display as a list item
                foreach ($DataEntry as $entry) {
                    // SPLIT DATA FROM HOW THEY ARE FORMATTED IN THE DATA BASE AND BACKEND
                
                    //1 full workouts info
                    $WorkoutDATA = explode(";", $entry);


                    // Check if there are exactly 6 items (Date, Name, Movments, Results, Types, ID)
                    //echo count($WorkoutDATA);
                    if (count($WorkoutDATA) == 8) {

                        $WorkoutCardioType = $WorkoutDATA[6];
                        $CreatorID = $WorkoutDATA[7];

                        if ($WorkoutCardioType == 1) {

                            //Grabbing the workout Date out of our array of information
                            $WorkoutDate = $WorkoutDATA[0];

                            //Grabbing the workout title out of our array of information
                            $WorkoutTitle = $WorkoutDATA[1];

                            //1 set of movments for a workout
                            $WorkoutMovements = explode(",", $WorkoutDATA[2]);
                            //Fixing our indexing issue
                            array_splice($WorkoutMovements, count($WorkoutMovements) - 1, 1);

                            //1 set of results for all movments
                            $WorkoutResults = explode("+_)(*&^%", $WorkoutDATA[3]);
                            //Fixing our indexing issue
                            array_splice($WorkoutResults, count($WorkoutResults) - 1, 1);

                            //1 set of types for this workout
                            $WorkoutTypes = explode(",", $WorkoutDATA[4]);
                            //Fixing our indexing issue
                            array_splice($WorkoutTypes, count($WorkoutTypes) - 1, 1);

                            $WorkoutID = $WorkoutDATA[5];

                            // Output each item in the desired format
                            ///////////////////////////////////////////////////////////////////////////////////////
                            echo "<div class='Table_data'>";
                            echo "<div>{$WorkoutDate}</div>"; // Date
                            echo "<div class='WorkoutTitleCardio' title='{$WorkoutTitle}'>{$WorkoutTitle}</div>"; // Name
                            echo "<div class='actionBTN'>";
                            echo "<div class= dropdown>";
                            echo "<button class= dropdown-btn >Actions</button>";
                            echo "<div class= dropdown-content >";
                            echo "<ul>";
                            echo "<li class=open-modal-btn data-modal= '{$WorkoutID}'       >Workout Info</button>";
                            echo "<li class=open-modal-btn data-modal= '{$WorkoutID}_editCardio'  >Edit</button>";
                            echo "<li class=open-modal-btn data-modal='deleteModal_{$WorkoutID}'>Delete</button>";
                            echo "</ul>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            ///////////////////////////////////////////////////////////////////////////////////////
                

                            //Creating the information modal
                            ///////////////////////////////////////////////////////////////////////////////////////
                            echo "<div id=  '{$WorkoutID}' class=modal>";
                            echo "<div class=modal-content>";
                            echo "<div class=modal-header>";
                            echo "<span class=close>&times;</span>";
                            echo "<h2>Workout $WorkoutTitle</h2>";
                            echo "<h2>Created by: $CreatorID</h2>";
                            echo "</div>";
                            echo "<div class=modal-body>";
                            echo "<div class = WorkModal_title>";
                            echo "<div>Name</div>";
                            echo "<div>Time</div>";
                            echo "<div>Distance</div>";
                            echo "</div>";

                            //Need a for loop to go through all of the movments
                            //this needs to change to do length - 1 !!!!!!!
                            foreach ($WorkoutResults as $MovmentResult) {
                                $FMovmentResults = explode(",", $MovmentResult);
                                echo "<div class='WorkModal_data'>";
                                echo "<div>{$FMovmentResults[0]}</div>"; //Movment name
                                echo "<div>{$FMovmentResults[1]}</div>"; //Time
                                echo "<div>{$FMovmentResults[2]}</div>"; //Distance
                                echo "</div>";

                            }
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            ///////////////////////////////////////////////////////////////////////////////////////
                

                            //Creating the delete confirmation modal
                            ///////////////////////////////////////////////////////////////////////////////////////
                            echo "<div id='deleteModal_{$WorkoutID}' class='modal'>";
                            echo "<div class='modal-content'>";
                            echo "<div class='modal-header'>";
                            echo "<span class='close'>&times;</span>";
                            echo "<h2>Confirm Deletion</h2>";
                            echo "</div>";
                            echo "<div class='modal-body'>";
                            echo "<p>Are you sure you want to delete this workout?</p>";
                            echo "<button class='confirm-delete-btn' data-id='{$WorkoutID}' value = 1>Yes, Delete</button>";
                            echo "<button class='cancel-delete-btn'>Cancel</button>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            ///////////////////////////////////////////////////////////////////////////////////////
                

                            //Creating  the edit modal
                            ///////////////////////////////////////////////////////////////////////////////////////
                            echo "<div id='{$WorkoutID}_editCardio' class='modal'>";
                            echo "<div class='modal-content'>";
                            echo "<div class='modal-header'>";
                            echo "<span class='close'>&times;</span>";
                            echo "<h2>Edit $WorkoutTitle</h2>";
                            echo "<h2>Created by: $CreatorID</h2>";
                            echo "</div>";

                            // Start of editing the single-use pieces of info: Date, Title, and Types
                            echo "<div class='edit-header-wrap'>";

                            // Editable Workout Title
                            echo "<label for='editWorkoutTitle'>Workout Title:</label>";
                            echo "<input type='text' id='editCardioTitle_{$WorkoutID}' name='editCarioTitle' placeholder='{$WorkoutTitle}' />";

                            // Editable Workout Date
                            echo "<label for='editWorkoutDate'>Workout Date:</label>";
                            echo "<input type='date' id='editCardioDate_{$WorkoutID}' name='editCardioDate' value='{$WorkoutDate}' />";

                            // Editable Workout Type Dropdown
                            echo "<div class='dropdown'>";
                            echo "<button>Workout Type</button>";
                            echo "<div class='dropdown-content' id='EditTypeCheckboxes'>";

                            // Workout type checkboxes (dynamically check if type is in $WorkoutTypes)
                            $types = ['Runnning', 'Swimming', 'Rowing', 'Biking', 'Custom'];
                            foreach ($types as $type) {
                                $checked = in_array($type, $WorkoutTypes) ? 'checked' : '';  // If the type is in the $WorkoutTypes array, mark it as checked
                                echo "<label><input type='checkbox' name='EditCardioTypeInput' value='$type' $checked> $type</label>";
                            }

                            echo "</div>";
                            echo "</div>";
                            echo "</div>";

                            echo "<div class=modal-body>";
                            echo "<div class = WorkModal_title>";
                            echo "<div>Name</div>";
                            echo "<div>Time</div>";
                            echo "<div>Distance</div>";
                            echo "</div>";
                            // Create a list to hold workout movement fields
                            echo "<ul>";

                            // Loop through each movement and output it as a list item with input fields
                            foreach ($WorkoutResults as $MovmentResult) {
                                $FMovmentResults = explode(",", $MovmentResult);
                                echo "<li class='WorkModal_data'>";
                                echo "<input type='text' value='{$FMovmentResults[0]}' placeholder='Movement Name' />"; // Movement name
                                echo "<input type='number' value='{$FMovmentResults[1]}' placeholder='Time' />"; // Time
                                echo "<input type='number' value='{$FMovmentResults[2]}' placeholder='Distance' />"; // Distance
                                echo "<button type='button' class='delete-cardio-btn'>Delete</button>"; //DELETE Button
                                echo "</li>";
                            }
                            echo "</ul>";

                            // Optional button to add new movement fields dynamically
                            echo "<button type='button' class='add-cardio-btn'>Add New Movement</button>";

                            // The new Save Changes button for submitting the modal's data
                            echo "<button type='button' class='submit-cardio-btn'>Save Changes</button>";

                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            ///////////////////////////////////////////////////////////////////////////////////////
                        }
                    }
                }
                ?>
            </div>
        </div>
        <!-- THIS SECOND SECTION IS FOR CARDIO WORKOUTS
            //////////////////////////////////////////////////////////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
    </div>

    <!-- Javascript script -->
    <script>
        console.log("<?php echo $workoutData ?>")
        const csrf_token = document.getElementById("csrf_token").value;
        document.getElementById('filterForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default form submission

            // Get all the checked filter values
            const formData = new FormData(this); // Automatically gathers form input data
            const filters = formData.getAll('filters[]'); // Retrieve all the selected filter values

            // Check if the Date filter is selected
            const dateFilterChecked = filters.includes('Date');
            console.log("Date filter is", dateFilterChecked ? "checked" : "not checked");

            // Send filter data to the backend using Fetch API
            fetch('./WorkoutHistory_BackEnd.php', {
                headers: {
                    "X-CSRF-Token": csrf_token,
                    "Content-Type": "application/json"
                },
                method: 'POST',
                body: new URLSearchParams(formData) // Send the form data as a URL-encoded string
            })
                .then(response => response.json())
                .then(data => {
                    // Handle the response data (e.g., update the workout table)
                    console.log('Success:', data);

                    // You can update the table dynamically here with data
                    // document.getElementById('workoutEntries').innerHTML = data.htmlContent;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
        //This block is dedicated to finding the date
        /////////////////////////////////////////////////////////////////////////////////////////
        const today = new Date();
        // Calculate the EDT offset (UTC-4 hours)
        // JavaScript's getTimezoneOffset() re turns the offset in minutes, so we adjust it for EDT (-240 minutes)
        const edtDate = new Date(today.getTime() - 240 * 60000);
        // Format the date to YYYY-MM-DD for EDT
        const formattedDate = edtDate.toISOString().split('T')[0];
        // Set the value of the date input to the adjusted EDT date
        document.getElementById('workoutDateInput').value = formattedDate;
        document.getElementById('CardioDateInput').value = formattedDate;
        /////////////////////////////////////////////////////////////////////////////////////////


        //This code is dedicated to the workout FILTERS and editing the workouts
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //This function will run when all HTML content is loaded
        //It grabs the filters from storage to attempt to check if there anything the user has used recently
        document.addEventListener("DOMContentLoaded", function () {

            submitFilter()
            //Event listener to the the 
            //This code is dedicated to the workout FILTERS and editing the workouts
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //THis code will be for all the search button activities
            SubmitSearchButton();
            SubmitSearchEnter();
            /////////////////////////////////////////////////////////////////////////////////////////

            //This code is dedicated to the workout type dropDown
            ////////////////////////////////////////////////////////////////////////////////////////
            // Example usage
            document.querySelector('.dropdown button').addEventListener('click', function () {
                console.log(getSelectedFruits());
                var dropdown = document.querySelector('.dropdown-content');

                //WASTED CODE UNLESS USING THIS DROP DOWN BY ITSELF
                // if (!dropdown.contains(event.target)) {
                //     dropdown.style.display = 'none';
                // }
            });
            /////////////////////////////////////////////////////////////////////////////////////////

            //Reinitializing the open modal but
            /////////////////////////////////////////////////////////////////////////////////////////
            addModalEventListeners();
            addModalCloseListeners();
            addDeleteWorkoutListeners();
            //SubmitEditWorkoutListeners();
            /////////////////////////////////////////////////////////////////////////////////////////

            // Load filters on page load
            /////////////////////////////////////////////////////////////////////////////////////////
            const savedFilters = JSON.parse(localStorage.getItem("workoutFilters"));

            if (savedFilters) {
                // Set the saved filter values on the form inputs
                applySelectedFilters(savedFilters.workoutType || []);
            }

            //This code is going to be dedicated to the Editing of an individual workout
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // // Listen for clicks on the "Add New Movement" button
            addWeightMovment_EditWorkout();

            // Attach delete functionality to all existing delete buttons on page load
            deleteWeightMovment_EditWorkout();


            // Form submission event to save filters
            //added a listener to the submit for the button
            SubmitEditWorkoutListeners();
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            //This code is going to be dedicated to the Editing of an individual cardio workout
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            addCardioMovment_EditWorkout();

            //This function will handle initializing the delete button
            deleteCardioMovment_EditWorkout();

            //This function will be handeling the submission of the edit modal
            SubmitEditCardioListeners();
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        });

        // Function to get selected filters (checkboxes)

        function clear_filter() {
            window.location.reload();
        }
        //Loops through all of the boxes to check which ones are clicked
        function getSelectedFilters() {
            const checkboxes = document.querySelectorAll('.checkbox-row input[type="checkbox"]');
            const selectedFilters = [];
            checkboxes.forEach(function (checkbox) {
                if (checkbox.checked) {
                    selectedFilters.push(checkbox.value);
                }
            });
            return selectedFilters;
        }

        function SubmitSearchButton(){
            document.getElementById("SearchFilterButton").addEventListener("click", function () {
                event.preventDefault(); // Prevent the form from submitting traditionally
                // Get selected filter values

                //Get the data from the search bar, It should end up being a single string
                const SearchBarData = {
                    SearchString: getSelectedSearch()
                };

                if (SearchBarData.SearchString != '') {
                    // Send the filters to the backend
                    fetch("./WorkoutHistory_BackEnd.php", {
                        method: "POST",
                        headers: {
                            "X-CSRF-Token": csrf_token,
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify(SearchBarData)
                    })
                        .then(response => response.json()) // Parse the response as JSON.
                        .then(data => {
                            console.log(data);
                            if (data.success) {
                                console.log(data.workouts);
                                updateWorkoutData(data.workouts); // Refresh the workout list with new data
                                //alert("You did func");

                            } else {
                                console.error("Error applying Search:", data.message);
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            //window.location.reload();
                        });
                } else {
                    alert("Don't leave input box Empty");
                }

            });
        }

        function SubmitSearchEnter(){
            const input = document.getElementById("SearchFilter");
            input.addEventListener("keypress", function(event) {
            // If the user presses the "Enter" key on the keyboard
            if (event.key === "Enter") {
                // Cancel the default action, if needed
                event.preventDefault();
                // Trigger the button element with a click
                document.getElementById("SearchFilterButton").click();
            }
            });
        }

        function getSelectedFruits() {
            const workoutTypeCheckboxes = document.querySelectorAll('input[name="WorkoutTypeInput"]');
            const selectedWorkoutTypes = Array.from(workoutTypeCheckboxes)
                .filter(checkbox => checkbox.checked) // Only checked checkboxes
                .map(checkbox => checkbox.value); // Get values of checked checkboxes
            return selectedWorkoutTypes;
        }

        function getSelectedCardio() {
            const CardioTypeCheckboxes = document.querySelectorAll('input[name="CardioTypeInput"]');
            const selectedCardioTypes = Array.from(CardioTypeCheckboxes)
                .filter(checkbox => checkbox.checked) // Only checked checkboxes
                .map(checkbox => checkbox.value); // Get values of checked checkboxes
            return selectedCardioTypes;
        }

        // Function to get selected filters (checkboxes)
        //Loops through all of the boxes to check which ones are clicked
        function getSelectedSearch() {
            const TextBox = document.querySelector('input[name="SearchBarInput"]').value;
            return TextBox;
        }

        // Function to apply saved filters
        //If there are filters selected reselect them
        function applySelectedFilters(selectedTypes) {
            const checkboxes = document.querySelectorAll('.checkbox-row input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectedTypes.includes(checkbox.value);
            });
        }

        //This function will run to fully update our page once filter have been selected
        //The container I made for the workouts will be wiped and the data will be input
        function updateWorkoutData(workouts) {
            const weightWorkoutContainer = document.getElementById("workoutEntries");
            const cardioWorkoutContainer = document.getElementById("Cardio_workoutEntries");

            weightWorkoutContainer.innerHTML = ''; // Clear existing entries
            cardioWorkoutContainer.innerHTML = ''; // Clear existing entries
            console.log('Workouts data type:', typeof workouts);
            console.log('Workouts data:', workouts);
            const workoutEntries  = workouts.split('?').filter(entry => entry.trim()); // Split workout data into entries

            workoutEntries.forEach(entry => {
                const workoutData = entry.split(';');

                // Ensure data structure matches expected format
                if (workoutData.length === 8) {
                    const [workoutDate, workoutTitle, movementData, resultData, typeData, workoutID, cardioFlag, creatorID] = workoutData;

                    const movements = movementData.split(',').filter(Boolean);
                    const results = resultData.split('+_)(*&^%').filter(Boolean);
                    const types = typeData.split(',').filter(Boolean);

                    const isCardio = cardioFlag === '1'; // Determine if this is a cardio workout

                    const container = isCardio ? cardioWorkoutContainer : weightWorkoutContainer;

                    // Workout entry display
                    const workoutHtml = `
                            <div class="Table_data">
                                <div>${workoutDate}</div> <!-- Date -->
                                <div class='WorkoutTitleCardio'>${workoutTitle}</div> <!-- Name -->
                                <div class="actionBTN">
                                    <div class="dropdown">
                                        <button class="dropdown-btn">Actions</button>
                                        <div class="dropdown-content">
                                            <ul>
                                                <li class="open-modal-btn" data-modal="${workoutID}">Workout Info</li>
                                                <li class="open-modal-btn" data-modal="${workoutID}_${isCardio ? 'editCardio' : 'editWeight'}">Edit</li>
                                                <li class="open-modal-btn" data-modal="deleteModal_${workoutID}">Delete</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    container.insertAdjacentHTML('beforeend', workoutHtml);

                    // Workout Info Modal
                    let infoModalHtml = `
                            <div id="${workoutID}" class="modal">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <span class="close">&times;</span>
                                        <h2>Workout ${workoutTitle}</h2>
                                        <h2>Created by: ${creatorID}</h2>
                                    </div>
                                    <div class="modal-body">
                                        <div class="WorkModal_title">
                                            <div>Name</div>
                                            <div>${isCardio ? 'Time' : 'Weight'}</div>
                                            <div>${isCardio ? 'Distance' : 'Reps used'}</div>
                                            ${!isCardio ? '<div>Sets</div>' : ''}
                                        </div>
                        `;
                    results.forEach(result => {
                        const [name, value1, value2, value3] = result.split(',');
                        infoModalHtml += `
                                <div class="WorkModal_data">
                                    <div>${name}</div>
                                    <div>${value1}</div>
                                    <div>${value2}</div>
                                    ${!isCardio ? `<div>${value3}</div>` : ''}
                                </div>
                            `;
                    });
                    infoModalHtml += `</div></div></div>`;
                    container.insertAdjacentHTML('beforeend', infoModalHtml);

                    // Edit Workout Modal
                    const editModalHtml = `
                            <div id="${workoutID}_${isCardio ? 'editCardio' : 'editWeight'}" class="modal">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <span class="close">&times;</span>
                                        <h2>Edit ${workoutTitle}</h2>
                                        <h2>Created by: ${creatorID}</h2>
                                    </div>
                                    <div class="edit-header-wrap">
                                        <label for="editWorkoutTitle">Workout Title:</label>
                                        <input type="text" id="edit${isCardio ? 'Cardio' : 'Weight'}Title_${workoutID}" name="editWorkoutTitle" placeholder="${workoutTitle}" />
                                        <label for="editWorkoutDate">Workout Date:</label>
                                        <input type="date" id="edit${isCardio ? 'Cardio' : 'Weight'}Date_${workoutID}" name="editWorkoutDate" value="${workoutDate}" />
                                        <div class="dropdown">
                                            <button>Workout Type</button>
                                            <div class="dropdown-content" id="EditTypeCheckboxes">
                                                ${types.map(type => `<label><input type="checkbox" name="Edit${isCardio ? 'Cardio' : 'workout'}TypeInput" value="${type}" checked> ${type}</label>`).join('')}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <div class="WorkModal_title">
                                            <div>Name</div>
                                            <div>${isCardio ? 'Time' : 'Weight'}</div>
                                            <div>${isCardio ? 'Distance' : 'Reps used'}</div>
                                            ${!isCardio ? '<div>Sets</div>' : ''}
                                        </div>
                                        <ul>
                                            ${results.map(result => {
                        const [name, value1, value2, value3] = result.split(',');
                        return `
                                                    <li class="WorkModal_data">
                                                        <input type="text" value="${name}" placeholder="Movement Name" />
                                                        <input type="number" value="${value1}" placeholder="${isCardio ? 'Time' : 'Weight'}" />
                                                        <input type="number" value="${value2}" placeholder="${isCardio ? 'Distance' : 'Reps'}" />
                                                        ${!isCardio ? `<input type="number" value="${value3}" placeholder="Sets" />` : ''}
                                                        <button type="button" class="delete-movement-btn">Delete</button>
                                                    </li>
                                                `;
                    }).join('')}
                                        </ul>
                                        <button type="button" class="${isCardio ? 'add-cardio-btn' : 'add-movement-btn'}">Add New Movement</button>
                                        <button type="button" class="${isCardio ? 'submit-cardio-btn' : 'submit-edit-btn'}" data-id="${workoutID}">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        `;
                    container.insertAdjacentHTML('beforeend', editModalHtml);

                    // Delete Confirmation Modal
                    const deleteModalHtml = `
                            <div id="deleteModal_${workoutID}" class="modal">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <span class="close">&times;</span>
                                        <h2>Confirm Deletion</h2>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete this workout?</p>
                                        <button class="confirm-delete-btn" data-id="${workoutID}" value="${isCardio ? 1 : 0}">Yes, Delete</button>
                                        <button class="cancel-delete-btn">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        `;
                    container.insertAdjacentHTML('beforeend', deleteModalHtml);
                }
            });

            addModalEventListeners();
            addModalCloseListeners();
            addDeleteWorkoutListeners();
            SubmitEditWorkoutListeners();
            SubmitEditCardioListeners();
            addWeightMovment_EditWorkout();
            addCardioMovment_EditWorkout();
            deleteWeightMovment_EditWorkout();
            deleteCardioMovment_EditWorkout();
            
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



        // Function to handle modal open/close functionality
        function addModalEventListeners() {
            // Get all modal buttons
            const modalButtons = document.querySelectorAll(".open-modal-btn");

            modalButtons.forEach(button => {
                button.addEventListener("click", function () {
                    //These varibles may be involved in why I am not able to correctly open and close some modals
                    const modalId = button.getAttribute("data-modal");
                    const modal = document.getElementById(modalId);
                    modal.style.display = "block"; // Open the modal
                });
            });
        }

        function addModalCloseListeners() {
            // Get all close buttons
            const closeButtons = document.querySelectorAll(".close");

            closeButtons.forEach(button => {
                button.addEventListener("click", function () {
                    const modal = button.closest(".modal");
                    modal.style.display = "none"; // Close only the closest modal
                });
            });
        }

        function addDeleteWorkoutListeners() {
            // Get all delete buttons
            const deleteButtons = document.querySelectorAll(".open-modal-btn[data-modal^='deleteModal']");

            deleteButtons.forEach(button => {
                button.addEventListener("click", function () {
                    const modalId = button.getAttribute("data-modal");
                    const modal = document.getElementById(modalId);
                    modal.style.display = "block"; // Show the confirmation modal
                });
            });

            // Get all close buttons
            const closeButtons = document.querySelectorAll(".close, .cancel-delete-btn");

            closeButtons.forEach(button => {
                button.addEventListener("click", function () {
                    const modal = button.closest(".modal");
                    modal.style.display = "none"; // Close the modal
                });
            });

            // Confirm delete button action
            const confirmDeleteButtons = document.querySelectorAll(".confirm-delete-btn");

            confirmDeleteButtons.forEach(button => {
                button.addEventListener("click", function () {
                    const workoutId = button.getAttribute("data-id");
                    const DeleteType = button.getAttribute("value");

                    // Prepare data to send to the backend for deletion
                    const deletedData = {
                        DeletedWorkoutId : workoutId,
                        DeleteType : DeleteType
                    };

                    console.log(workoutId);
                    console.log("Deleted Type:"+DeleteType);
                    // Send the delete request to the backend
                    fetch("./WorkoutHistory_BackEnd.php", {
                        method: "POST",
                        headers: {
                            "X-CSRF-Token": csrf_token,
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify(deletedData),
                    })
                        .then((response) => response.json()) // Parse the response as JSON.
                        .then((data) => {
                            console.log(data);
                            if (data.success) {
                                console.log(data.workouts);
                                alert("You successfully deleted a workout");
                                updateWorkoutData(data.workouts); // Refresh the workout list with new data
                            } else {
                                console.error("Error deleting workout:", data.message);
                            }
                        })
                        .catch((error) => {
                            console.error("Error:", error);
                        });

                    // Close the modal after confirming deletion
                    const modal = button.closest(".modal");
                    modal.style.display = "none";
                });
            });
        }
        /////////////////////////////////////////////////////////////////////////////////////////



        //Here are all the function for editing a weight workout
        /////////////////////////////////////////////////////////////////////////////////////////
        function addWeightMovment_EditWorkout() {
            // Listen for clicks on the "Add New Movement" button
            document.querySelectorAll('.add-movement-btn').forEach(button => {
                button.addEventListener('click', function () {
                    // Find the associated list
                    const movementList = button.previousElementSibling;

                    // Create a new list item with input fields for a new movement
                    const newMovementItem = document.createElement('li');
                    newMovementItem.className = 'WorkModal_data';
                    newMovementItem.innerHTML = `
                                <input type="text" placeholder="Movement Name" />
                                <input type="text" placeholder="Weight" />
                                <input type="text" placeholder="Reps" />
                                <input type="text" placeholder="Sets" />
                                <button type="button" class="delete-movement-btn">Delete</button>
                            `;

                    // Append the new list item to the movement list
                    movementList.appendChild(newMovementItem);

                    // Attach event listener to the delete button within the new list item
                    newMovementItem.querySelector('.delete-movement-btn').addEventListener('click', function () {
                        newMovementItem.remove();
                    });
                });
            });
        }

        function deleteWeightMovment_EditWorkout() {
            document.querySelectorAll('.delete-movement-btn').forEach(button => {
                button.addEventListener('click', function () {
                    // Remove the list item containing the delete button
                    button.parentElement.remove();
                });
            });
        }

        function SubmitEditWorkoutListeners() {
            document.querySelectorAll('.submit-edit-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const modal = button.closest('.modal'); // Get the modal container
                    const workoutID = modal.getAttribute('id').replace("_editWeight", ""); // Extract workout ID from modal ID

                    // Get the updated title and date
                    const updatedTitle = modal.querySelector(`#editWorkoutTitle_${workoutID}`).value || modal.querySelector(`#editWorkoutTitle_${workoutID}`).placeholder;
                    const updatedDate = modal.querySelector(`#editWorkoutDate_${workoutID}`).value || modal.querySelector(`#editWorkoutDate_${workoutID}`).placeholder;

                    // Define modalBody by selecting the modal's body section
                    const modalBody = modal.querySelector('.modal-body');

                    // Collect updated workout types
                    const selectedTypes = Array.from(modal.querySelectorAll('input[name="EditWorkoutTypeInput"]:checked')).map(checkbox => checkbox.value);

                   // Collect updated movements
                   const updatedMovements = Array.from(modalBody.querySelectorAll('.WorkModal_data')).map(item => ({
                        name: item.querySelector("input[placeholder='Movement Name']").value,
                        weight: item.querySelector("input[placeholder='Weight']").value,
                        reps: item.querySelector("input[placeholder='Reps']").value,
                        sets: item.querySelector("input[placeholder='Sets']").value
                    }));

                    // Prepare data to send to the backend
                    const Updateddata = {
                        workoutID: workoutID,
                        updatedMovements: updatedMovements,
                        selectedTypes: selectedTypes,
                        updatedTitle: updatedTitle,
                        updatedDate: updatedDate,
                        CardioFlag: 0
                    };

                    console.log("Updated workout data:", Updateddata); // For debugging

                    if (Updateddata.updatedMovements.length != 0 && Updateddata.selectedTypes.length != 0 && Updateddata.updatedTitle != '' && Updateddata.updatedDate != '') {
                        // Send the updated data to the backend
                        fetch('./WorkoutHistory_BackEnd.php', {
                            method: 'POST',
                            headers: {
                                "X-CSRF-Token": csrf_token,
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(Updateddata)
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Workout updated successfully!');
                                    updateWorkoutData(data.workouts);
                                } else {
                                    alert('Error updating workout: ' + data.message);
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    }
                    else if (Updateddata.updatedMovements.length == 0) {
                        alert('There are no movments in your workout!');

                    }
                    else if (Updateddata.selectedTypes.length == 0) {
                        alert('There are no types selected for your workout!');

                    }
                    else if (Updateddata.updatedTitle == []) {
                        alert('There is no Title for your workout!');

                    }
                    else if (Updateddata.updatedDate == []) {
                        alert('There are no date for your workout!');

                    } else {
                        alert('General Error not anticipated for')
                    }
                });
            });
        }

        /////////////////////////////////////////////////////////////////////////////////////////

        function submitFilter() {
            document.querySelector(".modal-submit-btn").addEventListener("click", function (event) {
                event.preventDefault(); // Prevent the form from submitting traditionally

                // Get selected filter values
                const filterData = {
                    workoutType: getSelectedFilters()
                };

                // Save filters to localStorage
                localStorage.setItem("workoutFilters", JSON.stringify(filterData));

                // Send the filters to the backend
                modal = document.getElementById("FilterModal")
                modal.style.display = "none";

                fetch("./WorkoutHistory_BackEnd.php", {
                    method: "POST",
                    headers: {
                        "X-CSRF-Token": csrf_token,
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(filterData)
                })
                    .then(response => response.json()) // Parse the response as JSON.
                    .then(data => {
                        console.log(data);
                        if (data.success) {
                            console.log(data.workouts);
                            updateWorkoutData(data.workouts); // Refresh the workout list with new data

                        } else {
                            console.error("Error applying filters:", data.message);
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        //window.location.reload();
                    });
            });
        }

        //Here are all the function for editing a cardio workout
        /////////////////////////////////////////////////////////////////////////////////////////
        function addCardioMovment_EditWorkout() {
            // Listen for clicks on the "Add New Movement" button
            document.querySelectorAll('.add-cardio-btn').forEach(button => {
                button.addEventListener('click', function () {
                    // Find the associated list
                    const movementList = button.previousElementSibling;

                    // Create a new list item with input fields for a new movement
                    const newMovementItem = document.createElement('li');
                    newMovementItem.className = 'WorkModal_data';
                    newMovementItem.innerHTML = `
                                <input type="text" placeholder="Movement Name" />
                                <input type="number" placeholder="Time" />
                                <input type="number" placeholder="Distance" />
                                <button type="button" class="delete-cardio-btn">Delete</button>
                            `;

                    // Append the new list item to the movement list
                    movementList.appendChild(newMovementItem);

                    // Attach event listener to the delete button within the new list item
                    newMovementItem.querySelector('.delete-cardio-btn').addEventListener('click', function () {
                        newMovementItem.remove();
                    });
                });
            });
        }

        function deleteCardioMovment_EditWorkout() {
            document.querySelectorAll('.delete-cardio-btn').forEach(button => {
                button.addEventListener('click', function () {
                    // Remove the list item containing the delete button
                    button.parentElement.remove();
                });
            });
        }

        function SubmitEditCardioListeners() {
            document.querySelectorAll('.submit-cardio-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const modal = button.closest('.modal'); // Get the modal container
                    const workoutID = modal.getAttribute('id').replace("_editCardio", ""); // Extract workout ID from modal ID

                    // Get the updated title and date
                    const updatedTitle = modal.querySelector(`#editCardioTitle_${workoutID}`).value || modal.querySelector(`#editCardioTitle_${workoutID}`).placeholder;
                    const updatedDate = modal.querySelector(`#editCardioDate_${workoutID}`).value || modal.querySelector(`#editCardioDate_${workoutID}`).placeholder;

                    // Define modalBody by selecting the modal's body section
                    const modalBody = modal.querySelector('.modal-body');

                    // Collect updated workout types
                    const selectedTypes = Array.from(modal.querySelectorAll('input[name="EditCardioTypeInput"]:checked')).map(checkbox => checkbox.value);

                    // Collect updated movements
                    const updatedMovements = Array.from(modalBody.querySelectorAll('.WorkModal_data')).map(item => ({
                        name: item.querySelector("input[placeholder='Movement Name']").value,
                        time: item.querySelector("input[placeholder='Time']").value,
                        distance: item.querySelector("input[placeholder='Distance']").value
                    }));

                    // Prepare data to send to the backend
                    const Updateddata = {
                        workoutID: workoutID,
                        updatedMovements: updatedMovements,
                        selectedTypes: selectedTypes,
                        updatedTitle: updatedTitle,
                        updatedDate: updatedDate,
                        CardioFlag: 1
                    };

                    console.log("Updated workout data:", Updateddata); // For debugging

                    if (Updateddata.updatedMovements.length != 0 && Updateddata.selectedTypes.length != 0 && Updateddata.updatedTitle != '' && Updateddata.updatedDate != '') {
                        // Send the updated data to the backend
                        fetch('./WorkoutHistory_BackEnd.php', {
                            method: 'POST',
                            headers: {
                                "X-CSRF-Token": csrf_token,
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(Updateddata)
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Workout updated successfully!');
                                    updateWorkoutData(data.workouts);
                                } else {
                                    alert('Error updating workout: ' + data.message);
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    }
                    else if (Updateddata.updatedMovements.length == 0) {
                        alert('There are no movments in your workout!');

                    }
                    else if (Updateddata.selectedTypes.length == 0) {
                        alert('There are no types selected for your workout!');

                    }
                    else if (Updateddata.updatedTitle == "") {
                        alert('There is no Title for your workout!');

                    }
                    else if (Updateddata.updatedDate == "") {
                        alert('There are no date for your workout!');

                    } else {
                        alert('General Error not anticipated for')
                    }
                });
            });
        }

        /////////////////////////////////////////////////////////////////////////////////////////

        // Function to open and close modals
        //This is for my static buttons
        /////////////////////////////////////////////////////////////////////////////////////////
        document.addEventListener("DOMContentLoaded", function () {
            // Get all modal buttons
            var modalButtons = document.querySelectorAll(".open-modal-btn"); // Assuming these are buttons to open modals
            const workoutTypeCheckboxes = document.querySelectorAll('input[name="WorkoutTypeInput"]');
            const cardioTypeCheckboxes = document.querySelectorAll('input[name="CardioTypeInput"]');

            // Add event listeners to each button
            modalButtons.forEach(function (filterBTN) {
                filterBTN.addEventListener("click", function () {
                    // Get the modal ID from the data-modal attribute on the button
                    var modalId = filterBTN.getAttribute("data-modal");
                    console.log(modalId);
                    var modal = document.getElementById(modalId);
                    modal.style.display = "block"; // Display the modal
                });
            });

            // Get all close buttons
            var closeButtons = document.querySelectorAll(".close");

            // Add event listeners to close modals when clicking on 'x'
            closeButtons.forEach(function (closeBtn) {
                closeBtn.addEventListener("click", function () {
                    var modal = closeBtn.closest(".modal");
                    modal.style.display = "none"; // Hide the modal
                });
            });

            // Close modal when clicking outside the modal content
            window.onclick = function (event) {
                var modals = document.querySelectorAll(".modal");
                modals.forEach(function (modal) {
                    if (event.target == modal) {
                        modal.style.display = "none"; // Hide the modal
                    }
                });
            };
            ////////////////////////////////////////////////////////////
            // JavaScript to handle adding workouts to the list
            var workoutList = []; // Array to store workout list

            var workoutInputList = []; //Array to store my workout names
            var WeightInputList = []; //Array to store my Weight Input names
            var RepsInputList = []; //Array to store my Rep input names
            var SetsInputList = []; //Array to store my sets input names
            var TimeInputList = []; //Array to store my Time input name from cardio workouts
            var DistanceInputList = []; //Array to store my Time input name from cardio workouts

            var workoutUl = document.getElementById("workoutList");
            var CardioUI = document.getElementById("CardioList");

            //If they attempt to add a workout this function is ran
            //This handles the low level input boxes
            document.getElementById("addWorkoutBtn").addEventListener("click", function () {
                //Create varibles that are connected to the addWorkoutBtn
                var workoutInput = document.getElementById("workoutInput").value;
                var WeightInput = document.getElementById("WeightInput").value;
                var RepsInput = document.getElementById("RepsInput").value;
                var SetsInput = document.getElementById("SetsInput").value;

                //Checking if there is any text in the workout input
                if (workoutInput.length > 25) {
                    document.getElementById("workoutInput").value = "";
                    document.getElementById("WeightInput").value = "";
                    document.getElementById("RepsInput").value = "";
                    document.getElementById("SetsInput").value = "";
                    alert("Exceeded maximum character length of 25");
                } else if (workoutInput.trim() !== "" && WeightInput.trim() !== "" && RepsInput.trim() !== "" && SetsInput.trim() !== "") {
                    workoutInputList.push(workoutInput); // Add workout to array
                    WeightInputList.push(WeightInput); //Add Weights into array
                    RepsInputList.push(RepsInput); //Add Weights into array
                    SetsInputList.push(SetsInput); //Add Weights into array

                    // Add workout to the unordered list
                    var li = document.createElement("li");
                    li.textContent = workoutInput + "," + WeightInput + "," + RepsInput + "," + SetsInput;
                    workoutUl.appendChild(li);

                    // Clear the input field
                    document.getElementById("workoutInput").value = "";
                    document.getElementById("WeightInput").value = "";
                    document.getElementById("RepsInput").value = "";
                    document.getElementById("SetsInput").value = "";
                } else {
                    alert("You May have forgotten to fill out some info!!");
                }
            });

            //If they attempt to add a workout this function is ran
            //This handles the low level input boxes
            document.getElementById("addCardioBtn").addEventListener("click", function () {
                //Create varibles that are connected to the addWorkoutBtn
                var workoutInput = document.getElementById("CardioInput").value;
                var TimeInput = document.getElementById("TimeInput").value;
                var DistanceInput = document.getElementById("DistanceInput").value;

                //Checking if there is any text in the workout input
                if (workoutInput.length > 25) {
                    document.getElementById("CardioInput").value = "";
                    document.getElementById("TimeInput").value = "";
                    document.getElementById("DistanceInput").value = "";
                    alert("Exceeded maximum character length of 25");
                } else if (workoutInput.trim() !== "" && TimeInput.trim() !== "" && DistanceInput.trim() !== "") {
                    TimeInputList.push(TimeInput); // Add workout to array
                    DistanceInputList.push(DistanceInput); //Add Weights into array
                    workoutInputList.push(workoutInput); // Add workout to array

                    // Add workout to the unordered list
                    var li = document.createElement("li");
                    li.textContent = workoutInput + "," + TimeInput + "," + DistanceInput;
                    CardioUI.appendChild(li);

                    // Clear the input field
                    document.getElementById("CardioInput").value = "";
                    document.getElementById("TimeInput").value = "";
                    document.getElementById("DistanceInput").value = "";

                } else {
                    alert("You May have forgotten to fill out some info!!");
                }
            });

            //THIS IS FOR OPENING THE MODAL
            ////////////////////////////////////////////////////////
            var modal = document.getElementById("workoutModal");
            var CardioModal = document.getElementById("CardioModal");
            var CardioBtn = document.getElementById("openCardioBtn");
            var WeightBtn = document.getElementById("openWeightBtn");
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks the button, open the modal
            WeightBtn.onclick = function () {
                modal.style.display = "block";
            }

            // When the user clicks the button, open the modal
            CardioBtn.onclick = function () {
                CardioModal.style.display = "block";
            }

            // When the user clicks on <span> (x), close the modal
            span.onclick = function () {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                    CardioModal.style.display = "none";
                }
            }
            ////////////////////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////////////////
            //SAVING THE WORKOUT
            // Handle save workout button click
            document.getElementById("saveWorkoutBtn").addEventListener("click", function () {
                //These are the peices of data that do not need to be repeated only one per workout 
                var WorkoutTitle = document.getElementById("dayName").value;
                var workoutDateInput = document.getElementById("workoutDateInput").value;
                var workoutTypeInput = getSelectedFruits();


                // Handles the top level input boxes
                if(WorkoutTitle.length > 25){
                    document.getElementById("dayName").value = "";
                    alert("Exceeded maximum character length of 25");
                    return;
                }else if (WorkoutTitle.trim() === "" && workoutDateInput.trim() === "") {
                    alert("Please enter a Workout Title and Date.");
                    return; // Exit the function if no day name and Date are provided
                } else if (WorkoutTitle.trim() === "") {
                    alert("Please enter a Workout Title.");
                    return; // Exit the function if no day name is provided
                } else if (workoutDateInput.trim() === "") {
                    alert("Please enter a WorkoutDate.");
                    return; // Exit the function if no Date is provided
                }

                if (workoutInputList.length === 0) {
                    alert("Please add at least one workout.");
                    return; // Exit the function if no workouts have been added
                } else {
                    //Else add all the lists to get your data together
                    // Assuming workoutInputList, WeightInputList, RepsInputList, and SetsInputList are arrays
                    console.log(workoutInputList)
                    for (var i = 0; i < workoutInputList.length; i++) {
                        // Create an object for each workout
                        var workoutInfo = {
                            workout: workoutInputList[i],
                            weight: WeightInputList[i],
                            reps: RepsInputList[i],
                            sets: SetsInputList[i]
                        };

                        // Push the object into the workoutList array
                        workoutList.push(workoutInfo);
                    }

                    //workoutList = ...workoutList + workoutInputList

                    if (workoutList.length === 0) {
                        alert("THomas your code failed...");
                        return; // Exit the function if no workouts have been added
                    }
                }

                var data =
                {
                    Workout_Title: WorkoutTitle,
                    Workout_Date: workoutDateInput,
                    workout_Info: workoutList,  // The properly formatted list of workouts
                    workout_type: workoutTypeInput,
                    CardioFlag: 0
                };



                console.log('Sending data to server:', data);
                console.log('Sending Types to server:', data.workout_type);

                //BANDAID 
                document.getElementById("workoutList").innerHTML = "";
                document.getElementById("dayName").value = "";
                document.getElementById('workoutDateInput').value = formattedDate;
                const WorkoutTypeInputReset = document.querySelectorAll('input[name="WorkoutTypeInput"]');
                WorkoutTypeInputReset.forEach(checkbox => {
                    checkbox.checked = false; // Uncheck all checkboxes
                });

                modal.style.display = "none";

                fetch("./WorkoutHistory_BackEnd.php", {
                    method: "POST",
                    headers: {
                        "X-CSRF-Token": csrf_token,
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(data)
                })
                    .then(response => {
                        if (!response.ok) {
                            return response.text().then(text => { // Get the text to understand what the server is returning
                                throw new Error('Network response was not ok. Response text: ' + text);
                            });
                        }
                        return response.json(); // Parse as JSON only if it's valid
                    })
                    .then(result => {
                        if (result.success) {
                            alert("Workout saved successfully!");
                            updateWorkoutData(result.workouts);
                            workoutList = []; // Array to store workout list
                            workoutInputList = []; //Array to store my workout names
                            WeightInputList = []; //Array to store my Weight Input names
                            RepsInputList = []; //Array to store my Rep input names
                            SetsInputList = []; //Array to store my sets input names
                        } else {
                            alert("Error saving workout: " + result.message);
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("ERRROROROROROR adding workout");
                        //window.location.reload();
                    });
            });


            //////////////////////////////////////////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////////////////////////////////////////////////////////////
            //This will be  submitting cardio workouts
            document.getElementById("saveCardioBtn").addEventListener("click", function () {
                //These are the peices of data that do not need to be repeated only one per workout 
                var CardioTitle = document.getElementById("CardioName").value;
                var CardioDateInput = document.getElementById("CardioDateInput").value;
                var CardioTypeInput = getSelectedCardio();


                console.log(CardioTitle);
                // Handles the top level input boxes
                if(CardioTitle.length > 25){
                    document.getElementById("CardioName").value = "";
                    alert("Exceeded maximum character length of 25");
                    return;
                }else if (CardioTitle.trim() === "" && CardioDateInput.trim() === "") {
                    alert("Please enter a Workout Title and Date.");
                    return; // Exit the function if no day name and Date are provided
                } else if (CardioTitle.trim() === "") {
                    console.log(CardioTitle);
                    alert("Please enter a Workout Title.");
                    return; // Exit the function if no day name is provided
                } else if (CardioDateInput.trim() === "") {
                    alert("Please enter a WorkoutDate.");
                    return; // Exit the function if no Date is provided
                }

                if (workoutInputList.length === 0) {
                    alert("Please add at least one workout.");
                    return; // Exit the function if no workouts have been added
                } else {
                    //Else add all the lists to get your data together
                    // Assuming workoutInputList, WeightInputList, RepsInputList, and SetsInputList are arrays
                    console.log(workoutInputList)
                    for (var i = 0; i < workoutInputList.length; i++) {
                        // Create an object for each workout
                        var CardioInfo = {
                            workout: workoutInputList[i],
                            Time: TimeInputList[i],
                            Distance: DistanceInputList[i],
                        };

                        // Push the object into the workoutList array
                        workoutList.push(CardioInfo);
                    }

                    //workoutList = ...workoutList + workoutInputList

                    if (workoutList.length === 0) {
                        alert("THomas your code failed...");
                        return; // Exit the function if no workouts have been added
                    }
                }

                var data =
                {
                    Workout_Title: CardioTitle,
                    Workout_Date: CardioDateInput,
                    workout_Info: workoutList,  // The properly formatted list of workouts
                    workout_type: CardioTypeInput,
                    CardioFlag: 1
                };



                console.log('Sending data to server:', data);
                console.log('Sending Types to server:', data.workout_type);

                //BANDAID 
                document.getElementById("CardioList").innerHTML = "";
                document.getElementById("CardioName").value = "";
                document.getElementById('CardioDateInput').value = formattedDate;
                const CardioTypeCheckboxesReset = document.querySelectorAll('input[name="CardioTypeInput"]');
                CardioTypeCheckboxesReset.forEach(checkbox => {
                    checkbox.checked = false; // Uncheck all checkboxes
                });
                CardioModal.style.display = "none";

                fetch("./WorkoutHistory_BackEnd.php", {
                    method: "POST",
                    headers: {
                        "X-CSRF-Token": csrf_token,
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(data)
                })
                    .then(response => {
                        if (!response.ok) {
                            return response.text().then(text => { // Get the text to understand what the server is returning
                                throw new Error('Network response was not ok. Response text: ' + text);
                            });
                        }
                        return response.json(); // Parse as JSON only if it's valid
                    })
                    .then(result => {
                        if (result.success) {
                            alert("Workout saved successfully!");
                            updateWorkoutData(result.workouts);
                            workoutList = []; // Array to store workout list
                            workoutInputList = []; //Array to store my workout names
                            WeightInputList = []; //Array to store my Weight Input names
                            RepsInputList = []; //Array to store my Rep input names
                            SetsInputList = []; //Array to store my sets input names
                        } else {
                            alert("Error saving workout: " + result.message);
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("ERRROROROROROR adding workout");
                        //window.location.reload();
                    });
            });
            ///////////////////////////////////////////////////////////////////////////
        });

    </script>
</body>

</html>