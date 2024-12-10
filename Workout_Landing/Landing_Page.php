<?php 
    include '../Navbar/navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Landing Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Navbar/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Josefin Sans' rel='stylesheet'>

    <style>
        /* General styles */
      
    /* General styles */
    * {
    font-family: 'Josefin Sans';
}
    body {
        margin: 0;
        padding: 0;
    }

    /* Header and menu styles */
    .top-of-page {
        justify-content: center;
        display: flex;
        align-items: center;        /*aligns the div elements to center of cross axis*/
        background-color: #004d75;
        height: 85px;
        text-align: center;
        font-size: 38px;
        font-weight: bold;
        color: white;
        font-family: 'Josefin Sans';
        position: fixed;
        width: 100%;
        top: 0;
    }
    .logout {
        position: absolute;
        top: 30px;
        right: 10px;
        transform: translateY(-50%);
        background-color: black;
        color: white; 
        padding: 10px 20px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    /* Hover effect for logout button */
    .logout:hover {
        background-color: white;
        color: black; 
    }


    .athletic-legs-header h1 {
        margin: 0;
        color: white;
        /* font-size: 36px; */
        text-align: center;
        flex: 1;
    }

    /* Log In button positioned under the header */
    button {
        background-color: #28a745;
        color: white;
        display: flex;
        flex-wrap: wrap;
        border: none;
        padding: 1% 1%;
        margin: 1%;
        font-size: 16px;
        cursor: pointer;
        border-radius: 10%;
    }

    .login-btn{
        display flex-direction: column;
        Margin-top: 100px;
    }

    button:hover {
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
        background-color: rgba(0, 108, 161);
        padding: 20px;
        border-radius: 8px;
        width: 40%; /* Adjusted to make it narrower */
        justify-content: space-between;
        margin: 150px auto;
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

        .athletic-legs-header h1{
            font-size: 26px;
        }
    }


    @media screen and (min-width: 768px) {
        .athletic-legs-header h1{
            font-size: 36px;
        }
    }
    </style>
</head>
<body>
    <div class="top-of-page">
        <header class="athletic-legs-header">
            <h1>Athletic Legs</h1>
            <button id="logout" class="logout" onclick="logout()">Log Out</button>
        </header>
    </div>

    <div class = "login-btn">
        <button  onclick ="window.location.href = 'https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Login/Login.php'">Login</button>
        <button  onclick ="window.location.href = 'https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Register/CreateAccount.php'">Register</button>
    </div>
    
    

    <div class="welcome-section">
        <!-- Left Section -->
        <div class="welcome-left">
            <h2>Welcome to Athletic Legs!</h2>
            <img src="https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Landing/Landingphoto.png" alt="Athletic Legs Logo" class="welcome-logo">
        </div>
        <!-- Right Section -->
        <div class="welcome-right">
            <p>From patrons who have never touched the gym once to rugged veterans. We bring you the tools to help you track, create and forge your fitness goals. From calorie counting to planning your workouts, we are here for you!</p>
        </div>
    </div>

    <script>
        // Variable to track authentication status
        let isAuthenticated = false;
        window.onload = display_button();

        // Check if user is logged in
        fetch('https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Landing/Landing_Page_backend.php', {
            method: 'GET',
            credentials: 'include' // Ensure cookies are sent with the request
        })
        .then(response => response.json())
        .then(data => {
            const loginBtn =  document.querySelectorAll('.login-btn');
            loginBtn.forEach(function(Btn) {
                if (data.authenticated) {
                    Btn.style.display = 'none';
                }
            });
            isAuthenticated = true;
        })
        .catch(err => console.error('Error checking login status:', err));
        



        function display_button(){
            const userId = getCookie('Authentication_Token');
            if (!userId){
                document.getElementById("menuToggle").style.display = 'none';
                document.getElementById("logout").style.display = 'none';
            }
        }
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(";").shift();
                return null;  // return null if cookie is not found
        }

        function logout() {
            const userId = getCookie('Authentication_Token');
            // Send a DELETE request to the backend to handle cookie deletion
            fetch('Landing_Page_backend.php', {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${userId}` // Include token in request
                }
            })
            .then(response => {
                console.log('Fetch response status:', response.status); // Log the response status
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Fetch response data:', data); // Log the response data
                if (data.success) {
                    // Redirect to the login page with cache bypass
                    window.location.href = 'https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Login/Login.php'           
                } else {
                    console.error("Logout failed: " + data.message);
                }
            })
            .catch(error => {
                console.error('Error during logout:', error);
            });
        }
    </script>
</body>
</html>
