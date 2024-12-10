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
                    <a href="https://se-dev.cse.buffalo.edu/CSE442/2024-Fall/richiezh/Initilization_Page.php">Home</a>
                    <a href="https://se-dev.cse.buffalo.edu/CSE442/2024-Fall/richiezh/Profile.php">Profile</a>
                    <a href="https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_PlannedWorkouts/PlannedWorkout.php">Planned Workout</a>
                    <a href="https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_History/WorkoutHistory.php">Workout History</a>
                    <a href="https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_MacroPage/Macros.php">Macronutrients</a>
                    <a href="https://se-dev.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Stats/WorkoutStats.php">My Stats</a>
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
                <p class="Top">* Stamina has a 0.5x multiplier to properly weight it in the ranking</p>

                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th><button class="stats-button" id="weightHeader">Weight(lb)</button></th>
                            <th><button class="stats-button" id="setsHeader">Sets</button></th>
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
                <div class="center-buttons">
                    <button id="lowestWeightsButton">Lowest 4 Weights</button>
                    <button id="lowestSetsButton">Lowest 4 Sets</button>
                </div>
            </section>
	<div class="checkboxes">
                    <label><input type="checkbox" checked> 1 Week</label>
                    <label><input type="checkbox"> 1 Month</label>
                    <label><input type="checkbox"> 3 Months</label>
                </div>

            <section class="skill-growth">
                <h2>Skill Growth:</h2>
                <canvas id="myChart"></canvas>

                <div class="checkboxes">
                    <label><input type="checkbox" checked>Show Weight</label>
                    <label><input type="checkbox" checked>Show Sets</label>
                </div>
            </section>
        </main>
    </div>

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

    async function fetchWorkoutStats() {
        // Check if the cookie exists
        const userIdCookie = getCookie('Authentication_Token'); // Replace 'user_id' with your actual cookie name

        if (!userIdCookie) {
            alert("You need to be logged in to view workout stats.");
            window.location.href = 'https://se-dev.cse.buffalo.edu/CSE442/2024-Fall/dashawne/Login_Token/LoginPage_68/Login.php'; // Redirect to your login page
            return;
        }

        try {
            const response = await fetch(`https://se-dev.cse.buffalo.edu/CSE442/2024-Fall/richiezh/WorkoutStatsBackend.php?user_profile_id=${userIdCookie}`);
            const stats = await response.json();
            return stats; // Return the stats for further processing
        } catch (error) {
            console.error("Error fetching workout stats:", error);
        }
    }

    function displayTopWeights(stats) {
        const topWeights = [...stats].sort((a, b) => b.Weight - a.Weight).slice(0, 4);
        updateTable(topWeights);
    }

    function displayTopSets(stats) {
        const topSets = [...stats].sort((a, b) => b.set_count - a.set_count).slice(0, 4);
        updateTable(topSets);
    }

    function displayBottomWeights(stats) {
        const bottomWeights = [...stats].sort((a, b) => a.Weight - b.Weight).slice(0, 4);
        updateTable(bottomWeights);
    }

    function displayLowestSets(stats) {
        const lowestSets = [...stats].sort((a, b) => a.set_count - b.set_count).slice(0, 4);
        updateTable(lowestSets);
    }

    function updateTable(data) {
        const tableBody = document.querySelector("table tbody");
        tableBody.innerHTML = ''; // Clear existing rows

        data.forEach((stat, index) => {
            const row = document.createElement("tr");

            const cellIndex = document.createElement("td");
            cellIndex.textContent = index + 1;

            const cellType = document.createElement("td");
            cellType.textContent = stat.Type || 'N/A';

            const cellWeight = document.createElement("td");
            cellWeight.textContent = stat.Weight || '0';

            const cellSetCount = document.createElement("td");
            cellSetCount.textContent = stat.set_count || '0';

            row.appendChild(cellIndex);
            row.appendChild(cellType);
            row.appendChild(cellWeight);
            row.appendChild(cellSetCount);

            tableBody.appendChild(row);
        });
    }

    // Event listeners for headers
    document.getElementById('weightHeader').addEventListener('click', async () => {
        const stats = await fetchWorkoutStats();
        displayTopWeights(stats);
    });

    document.getElementById('setsHeader').addEventListener('click', async () => {
        const stats = await fetchWorkoutStats();
        displayTopSets(stats);
    });

    document.getElementById('lowestWeightsButton').addEventListener('click', async () => {
        const stats = await fetchWorkoutStats();
        displayBottomWeights(stats);
    });

    document.getElementById('lowestSetsButton').addEventListener('click', async () => {
        const stats = await fetchWorkoutStats();
        displayLowestSets(stats);
    });

    window.onload = async () => {
        const stats = await fetchWorkoutStats();
        displayTopWeights(stats); // Call to display the top 4 weights by default
    };
</script>
</body></body>

</html>
