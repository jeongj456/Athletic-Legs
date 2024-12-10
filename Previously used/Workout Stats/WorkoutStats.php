<!DOCTYPE html>
<html lang="en">

<head>
    <title>Workout Stats Page</title>

    <!--Google Fonts Linking for Josefin Sans (Textfield Font)-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Navbar/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"><style>
        /* Hamburger Menu Icon */
        .hamburger-menu {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            cursor: pointer;
        }

        .hamburger-menu i {
            font-size: 30px;
            color: #000; /* Change color of hamburger icon if needed */
        }

        /* Navigation Menu (Hidden by Default) */
        .nav-menu {
            display: none; /* Hidden by default */
            position: absolute;
            top: 50px;
            left: 20px;
            background-color: #333;
            padding: 10px;
            border-radius: 5px;
            width: 200px;
            z-index: 1001; /* Ensure it appears above other content */
        }

        .nav-menu a {
            color: white;
            padding: 10px;
            text-decoration: none;
            display: block; /* Display links in a vertical stack */
        }

        .nav-menu a:hover {
            background-color: #555;
        }

        .center-buttons {
            text-align: center; /* Centers the buttons horizontally */
            margin-top: 15px;   /* Adds some spacing from elements above */
        }

        .center-buttons button {
            margin: 0 10px; /* Adds space between the buttons */
            background-color: #bfdae6; /* Set background color */
            border: none; /* Remove default border */
            padding: 10px 20px; /* Add padding for better appearance */
            border-radius: 5px; /* Add border radius for rounded corners */
            cursor: pointer; /* Change cursor to pointer on hover */
            font-family: "Josefin Sans", sans-serif; /* Use same font as page */
        }

        .center-buttons button:hover {
            background-color: #a2c9d5; /* Slightly darker on hover */
        }

        .graph_buttons {
            display: flex;
            flex-direction: row;
            justify-content: center;

        }

        .active-button button{
            background-color: #a2c9d5;
            /* background-color: #88b3c7; */
            border: 1px solid #a2c9d5; /* Optional border to make it stand out */
        }

	.center-buttons button,
.stats-button {
    margin: 0 10px; /* Adds space between the buttons */
    background-color: #bfdae6; /* Set background color */
    border: none; /* Remove default border */
    padding: 10px 20px; /* Add padding for better appearance */
    border-radius: 5px; /* Add border radius for rounded corners */
    cursor: pointer; /* Change cursor to pointer on hover */
    font-family: "Josefin Sans", sans-serif; /* Use same font as page */
}

.stats-button:hover {
    background-color: #a2c9d5; /* Slightly darker on hover */
}


        @media (max-width: 768px) {
            main {
                flex-direction: column; /* Stack the sections vertically */
                align-items: center;    /* Center the items */
            }

            .top-stats,
            .skill-growth {
                width: 90%; /* Make sections take more width on small screens */
                margin: 10px 0; /* Add margin between stacked sections */
            }
        }

        body {
            justify-content: center;
            align-items: center;
            display: flex;
        }

        .heading_box {
            background-color: #006CA1;
            border-radius: 8px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            font-family: "Josefin Sans", sans-serif;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 10;
            height: 70px;
            display: flex;
            align-items: center;
            padding-left: 10px;
        }

        .title_text {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            text-align: center;
            padding-right: 70px;
            color: white;
        }

        /* Hamburger Menu Styles */
        .hamburger {
            cursor: pointer;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 30px;
            margin-right: 10px;
            display: flex;
            justify-content: flex-start;
        }

        .top-stats,
        .skill-growth {
            background-color: #bfdae6;
            padding: 20px;
            border-radius: 10px;
            width: 45%;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 10px;
            border: 1px solid white;
            text-align: left;
        }

        .checkboxes label {
            display: block;
            margin-bottom: 10px;
        }

        .checkboxes {
            display: flex;
            flex-direction: column; /* Arrange labels in a column */
            align-items: center;    /* Center items horizontally */
            margin: 20px 0;        /* Optional: add margin for spacing */
        }

        canvas {
            width: 400px;
            height: 400px;
            max-width: 100%;
            max-height: 100%;
        }

        main {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            gap: 50px; /* Added to create spacing between the table and graph */
        }

        .top-stats h2,
        .skill-growth h2 {
            text-align: center;
        }

        /* Added this for spacing between table, checkboxes, and graph */
        .top-stats,
        .skill-growth {
            background-color: #bfdae6;
            padding: 20px;
            border-radius: 10px;
            width: 45%;
            margin-top: 80px; /* Set the same margin-top for both sections */
        }

        main {
            margin-top: 110px; /* Adjust as needed for spacing */
            display: flex;
            justify-content: space-between;
            gap: 50px; /* Added to create spacing between the table and graph */
        }

        /* Basic reset for the entire page */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .top {
            justify-content: center;
        }
 .top-stats,
        .skill-growth {
            width: 90%; /* Change to a responsive width */
            margin: 10px auto; /* Center and space */
        }

        @media (max-width: 768px) {
    /* Stack top-stats and skill-growth sections vertically */
    main {
        flex-direction: column;
        align-items: center;
        gap: 20px; /* Space between sections */
    }

    .top-stats,
    .skill-growth {
        width: 90%;
        margin: 10px auto; /* Center and add spacing */
    }

    /* Adjust button size for mobile */
    .center-buttons button,
    .stats-button {
        padding: 8px 16px;
        font-size: 14px; /* Slightly smaller font size */
    }

    /* Adjust hamburger menu icon size */
    .hamburger-menu i {
        font-size: 24px;
    }

    /* Center title text for readability */
    .title_text {
        font-size: 18px; /* Smaller title for mobile */
        padding-right: 0;
    }

    /* Adjust table styling for mobile */
    table th, table td {
        font-size: 12px; /* Smaller font */
        padding: 8px;
    }
}
    </style>


</head>

<body>
    <div class="heading_box">
        <div class="hamburger">
            <div class="hamburger-menu">
                <i class="fa fa-bars" id="menuToggle"></i>
                <div class="nav-menu" id="navMenu">
                      <a href="https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Initilization/Initilization_Page.php">Home</a>
        <a href="https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_ProfilePage/Profile.php">Profile</a>
        <a href="https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_PlannedWorkouts/PlannedWorkout.php">Planned Workout</a>
        <a href="https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_History/WorkoutHistory.php">Workout History</a>
        <a href="https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_MacroPage/Macros.php">Macronutrients</a>
	<a href= "https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_MyStats/WorkoutStats.php"> My Stats </a>
           

                </div>
            </div>
        </div>

        <div class="title_text">
            <h1>My Stats</h1>
        </div>
    </div>

    <div class="container">
        <main>
            <section class="top-stats">
                <h2 class="Top">Top 4 Stats:</h2>
                <p class="Top">* "Top 4" will be relative to the filter you choose below</p>

                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Weight(lb)</th>
                            <th>Sets</th>
                            <!-- <th><button class="stats-button" id="weightHeader">Weight(lb)</button></th>
                            <th><button class="stats-button" id="setsHeader">Sets</button></th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <!-- We need to take these buttons and add an event listener to all of them -->
                <div class="center-buttons">
                    <button id="lowestWeightsButton">Lowest 4 Weights</button>
                    <button id="lowestSetsButton">Lowest 4 Sets</button>
                </div>
                <div class="center-buttons">
                    <button id="HighestWeightsButton">Highest 4 Weights</button>
                    <button id="HighestSetsButton">Highest 4 Sets</button>
                </div>
            </section>
	<div class="checkboxes">
                    <label><input type="checkbox" checked> 1 Week</label>
                    <label><input type="checkbox"> 1 Month</label>
                    <label><input type="checkbox"> 3 Months</label>
                </div>

                <section class="skill-growth">
                <h2>Skill Growth:</h2>
                <canvas id="radarChart"></canvas>

                <!-- <div class="checkboxes"> -->

            
                <div class = "graph_buttons">
                    <div class="center-buttons" id = "button_highlight_weight">
                        <button id="ShowWeightsButton" class="">Show Weight</button>
                        <!-- <label><input type="checkbox" checked>Show Weight</label>
                        <label><input type="checkbox" checked>Show Sets</label> -->
                    </div>

                    <div class="center-buttons" id = "button_highlight_sets">
                        <button id="ShowSetsButton" class="">Show Sets</button>
                        <!-- <label><input type="checkbox" checked>Show Weight</label>
                        <label><input type="checkbox" checked>Show Sets</label> -->
                    </div>
                </div>
                
        </main>
    </div>

 
<!--THIS SCRIPT WAS WRITTEN BY THOMAS AND RICHIE -->
<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
 <script>
    document.querySelector('.hamburger-menu').addEventListener('click', function () {
        const menu = document.querySelector('.nav-menu');
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    });

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }

    // function displayTopWeights(stats) {
    //     const topWeights = [...stats].sort((a, b) => b.Weight - a.Weight).slice(0, 4);
    //     updateTable(topWeights);
    // }

    // function displayTopSets(stats) {
    //     const topSets = [...stats].sort((a, b) => b.set_count - a.set_count).slice(0, 4);
    //     updateTable(topSets);
    // }

    // function displayBottomWeights(stats) {
    //     const bottomWeights = [...stats].sort((a, b) => a.Weight - b.Weight).slice(0, 4);
    //     updateTable(bottomWeights);
    // }

    // function displayLowestSets(stats) {
    //     const lowestSets = [...stats].sort((a, b) => a.set_count - b.set_count).slice(0, 4);
    //     updateTable(lowestSets);
    // }

    function updateTable(data) {
    const tableBody = document.querySelector("table tbody");
    tableBody.innerHTML = ''; // Clear existing rows

    data.forEach((stat, index) => {
        const row = document.createElement("tr");

        const cellIndex = document.createElement("td");
        cellIndex.textContent = index + 1;

        const cellType = document.createElement("td");
        cellType.textContent = stat.movement || 'N/A';

        const cellWeight = document.createElement("td");
        cellWeight.textContent = stat.totalWeight || '0';

        const cellSetCount = document.createElement("td");
        cellSetCount.textContent = stat.totalSets || '0';

        row.appendChild(cellIndex);
        row.appendChild(cellType);
        row.appendChild(cellWeight);
        row.appendChild(cellSetCount);

        tableBody.appendChild(row);
    });
}

    // Event listeners for headers
    // document.getElementById('weightHeader').addEventListener('click', async () => {
    //     const stats = await fetchWorkoutStats();
    //     displayTopWeights(stats);
    // });

    // document.getElementById('setsHeader').addEventListener('click', async () => {
    //     const stats = await fetchWorkoutStats();
    //     displayTopSets(stats);
    // });

    // document.getElementById('lowestWeightsButton').addEventListener('click', async () => {
    //     const stats = await fetchWorkoutStats();
    //     displayBottomWeights(stats);
    // });

    // document.getElementById('lowestSetsButton').addEventListener('click', async () => {
    //     const stats = await fetchWorkoutStats();
    //     displayLowestSets(stats);
    // });

    // window.onload = async () => {
    //     const stats = await fetchWorkoutStats();
    //     displayTopWeights(stats); // Call to display the top 4 weights by default
    // };

    document.addEventListener("DOMContentLoaded", function() {

        //This is going to be for when we first load the page in
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        const SearchType = {
                SearchString: "HighestWeightsButton"
            };

        //Next we will call out fetch function to keep these 4 Event Listeners cleaner
        TableTopStatsFetch(SearchType);
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////

        //We are going to have a series of four event listeners for the four buttons in our table
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //First one is going to be for lowest weight
        document.getElementById("lowestWeightsButton").addEventListener("click", function () {
            //First we need to create an object that will have the sorting type we are looking for 
            const SearchType = {
                SearchString: "lowestWeightsButton"
            };

            //Next we will call out fetch function to keep these 4 Event Listeners cleaner
            TableTopStatsFetch(SearchType);
        })

        //Second is going to be for the lowerst Sets
        document.getElementById("lowestSetsButton").addEventListener("click", function () {
            //First we need to create an object that will have the sorting type we are looking for

            const SearchType = {
                SearchString: "lowestSetsButton"
            };

            //Next we will call out fetch function to keep these 4 Event Listeners cleaner
            TableTopStatsFetch(SearchType);
        })

        //Third one is going to be for Highest weight
        document.getElementById("HighestWeightsButton").addEventListener("click", function () {
            //First we need to create an object that will have the sorting type we are looking for

            const SearchType = {
                SearchString: "HighestWeightsButton"
            };

            //Next we will call out fetch function to keep these 4 Event Listeners cleaner
            TableTopStatsFetch(SearchType);
        })

        //Forth one is going to be for Highest weight
        document.getElementById("HighestSetsButton").addEventListener("click", function () {
            //First we need to create an object that will have the sorting type we are looking for

            const SearchType = {
                SearchString: "HighestSetsButton"
            };

            //Next we will call out fetch function to keep these 4 Event Listeners cleaner
            TableTopStatsFetch(SearchType);
        })
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////

    })

    //This function will be used to grab our table data and be given an object depending on the type of table data the user wants
    function TableTopStatsFetch(SortTypeObject) {
        // Check if the cookie exists
        const userIdCookie = getCookie('Authentication_Token'); // Replace 'user_id' with your actual cookie name

        //Check if cookie exists
        if (!userIdCookie) {
            //If it does not alert the user
            alert("You need to be logged in to view workout stats.");
            window.location.href = 'https://se-dev.cse.buffalo.edu/CSE442/2024-Fall/dashawne/Login_Token/LoginPage_68/Login.php'; // Redirect to your login page
            return;
        }

        

    // Define the base URL and append the sorting query parameter
    const url = `./WorkoutStatsBackend.php?sort=${SortTypeObject.SearchString}`;

    fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${userIdCookie}`
        }
    })
    .then(response =>  response.json())
    .then(data => {
        console.log(data);
        if (data.success) {
            console.log(data.workouts);
            updateTable(data.workouts); // Refresh the workout list with new data
            //alert("you made your table");
            
        } else {
            console.error("Error making table:", data.message);
        }
    })
    .catch(error => {
        console.error("There was an error with the fetch operation:", error);
    });
}



</script>
<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    
    function addJitter(value, jitterAmount = 0.6) {
        return value + (Math.random() * jitterAmount); 
    }

    // Function to fetch top 5 stats from PHP
    async function fetchTop5Stats() {
        const response = await fetch('WorkoutStatsBackend.php?action=getTop5Weights');
        const data = await response.json();
        return data;
    }

    // Create the chart
    async function createRadarChart() {
        const topStats = await fetchTop5Stats();

        const ctx = document.getElementById('radarChart').getContext('2d');

        // Original data for tooltips
        const originalData = Object.values(topStats);

        // Jittered data for display
        const jitteredData = originalData.map(value => addJitter(value));


        const data = {
            labels: Object.keys(topStats),
            datasets: [{
                label: '',
                // data: jitteredData, 
                data: [],

           
                fill: true,
                backgroundColor: 'rgba(50, 205, 50, 0.2)', // Soft green fill
                borderColor: 'rgba(50, 205, 50, 1)', // Strong green for the line
                pointBackgroundColor: 'rgba(50, 205, 50, 1)', // Points are also green
                pointBorderColor: '#ffffff', // White point borders
                pointHoverBackgroundColor: '#ffffff', // Points turn white on hover
                pointHoverBorderColor: 'rgba(50, 205, 50, 1)' // Green border when hovered
            }]
        };

        const radarChart = new Chart(ctx, {
            type: 'radar',
            data: data,
            options: {
                maintainAspectRatio: true,
                aspectRatio: 1,
                scales: {
                    r: {
                        angleLines: {
                            display: true,
                            color: 'rgba(0, 0, 0, 0.1)' // Light gray lines
                        },
                        grid: {
                            circular: true, // Makes the grid circular
                            color: 'rgba(0, 0, 0, 0.1)' // Light grid lines
                        },
                        suggestedMin: 0,
                        suggestedMax: 10,
                        ticks: {
                            display: false, // This will hide the ticks/labels entirely, including the center
                            backdropColor: 'transparent' // Ensures no background for the tick labels
                        },
                        pointLabels: {
                            color: '#000000', // Darker labels for better contrast
                            font: {
                                size: 14
                            }
                        }
                    }
                },
                elements: {
                    line: {
                        borderWidth: 2 // Thinner lines for a cleaner look
                    }
                },
                plugins: {
                    legend: {
                        display: false // Hides the legend
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const index = context.dataIndex;
                                const datasetLabel = context.dataset.label;
                                return `${datasetLabel}: ${originalTooltipData[index]}`; // Display original value on hover
                            }
                        }
                    }
                }
            }
        });
        return radarChart;
    }

    // Call the function to create the radar chart on page load
    let radarChart;
    let originalTooltipData = []; // Global variable to store original data for tooltips
    window.onload = async function () {
        radarChart = await createRadarChart();
    };
</script>

<script>

    function addJitter(value, jitterAmount = 0.6) {
        return value + (Math.random() * jitterAmount); 
    }

    async function fetchTop5Weights() {
        const response = await fetch('WorkoutStatsBackend.php?action=getTop5Weights');
        const data = await response.json();
        const weightArray = Object.entries(data);
        const top5Weights = weightArray.slice(0, 5).map(([type, weight]) => weight);
        return top5Weights; // Return the top 5 weights
    }

    async function fetchTop5Sets() {
        const response = await fetch('WorkoutStatsBackend.php?action=getTop5Sets');
        const data = await response.json();
        const setArray = Object.entries(data);
        const top5Sets = setArray.slice(0, 5).map(([type, set]) => set);
        return top5Sets; // Return the top 5 sets
    }

    function applyJitterToData(data) {
        return data.map(value => addJitter(value)); // Apply jitter to the data
    }

    function updateSkillGraph(topData, unit) {
        const skillGrowthChart = Chart.getChart('radarChart'); // Get existing chart instance

        // Store original data for tooltip display
        originalTooltipData = [...topData];

        // Apply jitter and update dataset with jittered data for display
        const jitteredData = applyJitterToData(topData);
        skillGrowthChart.data.datasets[0].data = jitteredData; // Use jittered data for chart display
        skillGrowthChart.data.datasets[0].label = unit;
        skillGrowthChart.update(); // Refresh chart to show new data
    }

    document.getElementById('ShowWeightsButton').addEventListener('click', async () => {
        const topWeights = await fetchTop5Weights();
        updateSkillGraph(topWeights, 'Weight (lbs)');

        document.getElementById('button_highlight_weight').classList.add('active-button');
        document.getElementById('button_highlight_sets').classList.remove('active-button');
    });

    document.getElementById('ShowSetsButton').addEventListener('click', async () => {
        const topSets = await fetchTop5Sets();
        updateSkillGraph(topSets, 'Sets');

        document.getElementById('button_highlight_sets').classList.add('active-button');
        document.getElementById('button_highlight_weight').classList.remove('active-button');
    });

</script>

</body></body>

</html>
