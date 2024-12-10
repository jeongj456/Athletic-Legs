<?php 
    include 'https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Navbar/navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athletic Legs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        /* General styles */
      
    /* General styles */
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #0078a0;
    }

    /* Header and menu styles */
    .top-of-page {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px 20px;
        background-color: #f3e7df;
    }

    .athletic-legs-header h1 {
        margin: 0;
        color: black;
        font-size: 36px;
        text-align: center;
        flex: 1;
    }

    .hamburger-menu {
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 1001;
        cursor: pointer;
    }

    .hamburger-menu i {
        font-size: 30px;
        color: #000;
    }

    .nav-menu {
        display: none;
        position: absolute;
        top: 50px;
        left: 20px;
        background-color: #333;
        padding: 10px;
        border-radius: 5px;
        width: 200px;
        z-index: 1001;
    }

    .nav-menu a {
        display: block;
        color: #fff;
        padding: 10px;
        text-decoration: none;
    }

    .nav-menu a:hover {
        background-color: #555;
    }

    /* Log In button positioned under the header */
    .login-btn {
        position: absolute;
        right: 20px;
        top: 70px;
        background-color: #28a745;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
    }

    .login-btn:hover {
        background-color: #218838;
    }

    /* Main content styles */
    .content {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .welcome-section {
        display: flex;
        align-items: center;
        background-color: #008dc8;
        padding: 20px;
        border-radius: 8px;
        width: 40%; /* Adjusted to make it narrower */
        justify-content: space-between;
        margin-top: -90px;
    }

    .welcome-left {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        flex: 1;
    }

    .welcome-left h2 {
        color: black;
        font-size: 36px;
        margin-bottom: 10px;
    }

    .welcome-logo {
        width: 180px; /* Slightly smaller logo for a narrow layout */
        height: auto;
        margin-bottom: 20px;
    }

    .welcome-right {
        max-width: 280px; /* Narrowing the text section */
        text-align: center;
        flex: 1;
    }

    .welcome-right p {
        color: black;
        font-size: 22px; /* Slightly smaller text */
        line-height: 1.5;
    }

    /* Responsive */
    @media screen and (max-width: 768px) {
        .welcome-section {
            flex-direction: column;
            text-align: center;
            width: 85%; /* Make it fill more of the screen on mobile */
        }

        .welcome-right {
            margin-top: 20px;
        }

        .login-btn {
            top: 90%;
        }
    }

    </style>
</head>
<body>
    <div class="top-of-page">
        <header class="athletic-legs-header">
            <h1>Athletic Legs</h1>
        </header>
        <div class="hamburger-menu">
            <i class="fa fa-bars" id="menuToggle"></i>
            <div class="nav-menu" id="navMenu">
                <a href="https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Initilization/Initilization_Page.php">Home</a>
                <a href="https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_ProfilePage/Profile.php">Profile</a>
                <a href="https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_PlannedWorkouts/PlannedWorkout.php">Planned Workout</a>
                <a href="https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_History/WorkoutHistory.php">Workout History</a>
                <a href="https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_MacroPage/Macros.php">Macronutrients</a>
            </div>
        </div>
        <button class="login-btn" onclick="window.location.href='https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Login/Login.php'">Log In</button>
    </div>

    <main class="content">
        <div class="welcome-section">
            <!-- Left Section -->
            <div class="welcome-left">
                <h2>Welcome to Athletic Legs!</h2>
                <img src="https://se-dev.cse.buffalo.edu/CSE442/2024-Fall/richiezh/Landingphoto.png" alt="Athletic Legs Logo" class="welcome-logo">
            </div>
            <!-- Right Section -->
            <div class="welcome-right">
                <p>From patrons who have never touched the gym once to rugged veterans. We bring you the tools to help you track, create and forge your fitness goals. From calorie counting to planning your workouts, we are here for you!</p>
            </div>
        </div>
    </main>

    <script>
        // Variable to track authentication status
        let isAuthenticated = false;

        // Check if user is logged in
        fetch('https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Initilization/Initilization_Pagebackend.php', {
            method: 'GET',
            credentials: 'include' // Ensure cookies are sent with the request
        })
        .then(response => response.json())
        .then(data => {
            const loginBtn = document.querySelector('.login-btn');
            if (data.authenticated) {
                loginBtn.style.display = 'none';
                isAuthenticated = true;
            }
        })
        .catch(err => console.error('Error checking login status:', err));

        // Toggle the menu only if user is authenticated
        document.querySelector('.hamburger-menu').addEventListener('click', function () {
            if (!isAuthenticated) {
                alert('Please sign in to access the menu.');
            } else {
                const menu = document.querySelector('.nav-menu');
                menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
            }
        });

        // Close the menu if clicked outside
        document.addEventListener('click', function (event) {
            const menu = document.querySelector('.nav-menu');
            const hamburger = document.querySelector('.hamburger-menu');

            if (!menu.contains(event.target) && !hamburger.contains(event.target)) {
                menu.style.display = 'none';
            }
        });
    </script>
</body>
</html>
