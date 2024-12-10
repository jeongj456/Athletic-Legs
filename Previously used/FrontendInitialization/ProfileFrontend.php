
<?php 
    include 'https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Navbar/navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
<link rel="stylesheet" href="../Navbar/navbar.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"><style>
/* Common styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background-color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    overflow-y: auto;
    flex-direction: column;
}

/* Header styles */
.athletic-legs-header {

    position: fixed;
    top: 0;
    left: 0;
    width: 100%;

    background-color: #004c75;
    text-align: center;
    padding: 22px 0; /* Increase padding to make the area bigger */
    font-size: 36px; /* Adjusted for mobile */
    font-weight: bold;
    color: white;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 20; /* Ensure the header is on top */
}

/* Profile header styles */
.profile-header-container {
    margin-top: 70px; /* Adjusted based on your header height */
    padding-top: 20px; /* Optional padding for spacing */
    width: 100%; /* Ensure full width */
}

.profile-header {
    margin: 0;
    font-size: 20px; /* Adjusted font size for mobile */
    color: #003B5C; /* Title color */
    text-align: center; /* Center the text */
    position: fixed; /* Keep it fixed to the viewport */
    top: 95px; /* Adjusted to prevent overlap */
    left: 50%;
    transform: translateX(-50%); /* Center horizontally */
    z-index: 21; /* Ensure the profile title is above the header */
}

@media (max-width: 768px) {
    .profile-header {
        top: 140px; /* Move further down on mobile */
        position: static; /* Allow it to scroll */
        transform: none; /* Remove centering transformation */
        left: 0; /* Align it to the left */
        font-size: 24px; /* Adjust for readability */
    }

}
/* Logout button styles */
.logout {
    position: fixed; /* Keep it fixed for larger screens */
    top: 100px;
    right: 70px;
    z-index: 1000;
    border: none;
    color: #A9D6E5; /* Light blue text */
    background-color: #004c75; /* Dark blue button */
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    text-decoration: none;
    border-radius: 5px;
}

.logout:hover {
    background-color: #005F73;
    color: white;
}

/* Logout button styles for mobile */
@media (max-width: 600px) {
    .logout {
    position: fixed; /* Keep it fixed for larger screens */
    top: 90px; /* Align with top dark blue area */
    right: 0; /* Stick to the right side */
    z-index: 1000;
    color: #A9D6E5; /* Light blue text */
    background-color: #004c75; /* Dark blue button */
    padding: 10px; /* Uniform padding */
    font-size: 16px; /* Font size */
    border-radius: 5px; /* Rounded corners */
    width: 120px; /* Set a fixed width */
    height: 40px; /* Set a fixed height */
    text-align: center; /* Center text */
    transition: opacity 0.0s ease; /* Smooth transition for visibility */
}


/* Hide the logout button when scrolled */
body.scrolled .logout {
    opacity: 0; /* Hide with opacity */
    pointer-events: none; /* Prevent interaction when hidden */
}  
  body.scrolled .logout {
        top: 0; /* Keep the logout button at the top */
    }

    .logout:hover {
        background-color: #005F73;
        color: white;
    }
}.container {
    width: 90%; /* Increase width to 90% for better display on PC */
    max-width: 800px; /* Optional: increase max width to 800px */
    background-color: #A9D6E5;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    position: relative;
    min-height: 500px;
    margin: 0 auto; /* Center container */
}

.profile-info {
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
    margin-bottom: 30px;
    margin-top: 20px; /* Reduced margin-top for desktop */
}

.form-container {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    width: 100%;
    margin-top: 20px;
}

.profile-pic {
    margin: 0; /* Remove any default margin */
    display: flex;
    flex-direction: column;
    align-items: center; /* Center items */
    justify-content: center; /* Center items vertically */
    margin-top: 20px; /* Adjust top margin for spacing */
    width: 100%; /* Full width to fill the container */
    min-height: 200px; /* Ensures there’s space for centering */
}

.profile-pic img {
    width: 200px;
    height: 200px;
    object-fit: cover;
}

/* New styles for mobile profile info */
@media (max-width: 768px) {
    .profile-info {
        flex-direction: column; /* Stack profile info vertically */
        align-items: flex-start; /* Align items to the start */
        margin-top: 10px; /* Adjust spacing */
    }

    .profile-info label {
        font-size: 16px; /* Adjust label font size */
        margin-bottom: 5px; /* Space between label and input */
    }

    .profile-info div {
        margin-bottom: 10px; /* Space between different profile info */
        color: #003B5C; /* Color for text */
        font-size: 18px; /* Adjust text size */
    }
}

#change-photo-btn {
    background-color: #D3D3D3;
    color: #000;
    padding: 8px 12px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
    text-align: center;
}

#change-photo-btn:hover {
    background-color: #B0B0B0;
}

.form-group {
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: flex-start;
}

/* Updated for consistent label positioning */
.form-group label {
    font-size: 18px;
    color: #003B5C;
    width: 120px; /* Fixed width for labels */
}

.form-group input {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-top: 5px;
    width: calc(100% - 130px); /* Adjust width to account for label */
    text-align: center;
}

.button-container {
    display: flex;
    justify-content: flex-end;
    gap: 20px;
    margin-top: 10px;
}

/* Added for mobile screens */
@media (max-width: 600px) {
    .form-group {
        justify-content: flex-start; /* Align labels and inputs uniformly */
        flex-direction: row; /* Align label and input horizontally */
        width: 100%; /* Use full width on mobile */
    }

    .form-group label {
        width: 120px; /* Fixed width for labels to keep alignment consistent */
        margin-right: 10px; /* Space between label and input */
    }

    .form-group input {
        width: calc(100% - 130px); /* Adjust width to fit within the row */
        margin-top: 0; /* Remove top margin */
        text-align: left; /* Align text left for input */
    }

    .container {
        padding: 15px; /* Less padding for mobile */
    }
}

.edit-btn,
.save-btn,
.cancel-btn {
    background-color: #D3D3D3;
    color: #000;
    padding: 8px 12px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
    text-align: center;
}

.edit-btn:hover,
.save-btn:hover,
.cancel-btn:hover {
    background-color: #B0B0B0;
}

.save-btn,
.cancel-btn {
    display: none;
}

.hamburger-menu {
    position: fixed;
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
</style>

</head>
<body>
    <div class="athletic-legs-header">
        Athletic Legs

        
      </div>
   <div class="hamburger-menu">
    <i class="fa fa-bars" id="menuToggle"></i>
    <div class="nav-menu" id="navMenu">
        <a href="#">Home</a>
        <a href="https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_ProfilePage/Profile.php">Profile</a>
        <a href="https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_PlannedWorkouts/PlannedWorkout.php">Planned Workout</a>
        <a href="https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_History/WorkoutHistory.php">Workout History</a>
        <a href="https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_MacroPage/Macros.php">Macronutrients</a>
        <a href="https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Stats/WorkoutStats.php">My Stats</a>
    </div>
</div>   
 <div class="profile-header-container">
        <h1 class="profile-header">Profile Page</h1>
        <div class="logout">
            <button class="logout" style="color: #A9D6E5;" onclick="logout()">Log out</button>

        </div>
    </div>
   <div class="container">
    <div class="profile-info"> 
        <div class="profile-pic">
            <img id="profile-pic-display" src="https://se-dev.cse.buffalo.edu/CSE442/2024-Fall/richiezh/dumbbell.png" alt="Profile Picture" />
            <button id="change-photo-btn" onclick="changePhoto()" style="display: none;">Change Photo</button>
            <input type="file" id="profile-pic-upload" accept="image/*" style="display: none;" disabled>
        </div>

        <div class="form-container">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" value="" disabled required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" value="" disabled required>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" value="" disabled required>
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" value="" disabled required min="1" max="120">
            </div>
            <div class="button-container">
                <button class="edit-btn" onclick="enableEdit()">Edit</button>
                <button class="save-btn" onclick="saveChanges()">Save Changes</button>
                <button class="cancel-btn" onclick="cancelEdit()">Cancel</button>
            </div>
        </div>
    </div>

</div>
<script>
// Add this script to your page
window.addEventListener('scroll', function() {
    const scrollPosition = window.scrollY; // Get the current scroll position
    const logoutButton = document.querySelector('.logout'); // Select the logout button
    
    // Add or remove the class based on scroll position
    if (scrollPosition > 3) { // Adjust this value if needed
        document.body.classList.add('scrolled');
    } else {
        document.body.classList.remove('scrolled');
    }
});

    // Function to set a cookie
    function setCookie(name, value, days) {
        let expires = "";
        if (days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/; Secure; SameSite=Strict";
    }

    // Function to get a cookie by name
    function getCookie(name) {
        const nameEQ = name + "=";
        const ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i].trim();
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    // Retrieve userId from the cookie and set it
    let userId = getCookie('Authentication_Token');

    if (!userId) {
        console.error("No authentication token found in cookies");
        alert("Please log in to access your profile.");
        window.location.href = 'https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Login/Login.php'; // Redirect if not logged in
    } else {
        // Set userId cookie for userId retrieved (valid for 7 days)
        //setCookie('Authentication_Token', userId, 7);
    }

    let originalData = {};
    let currentPhotoIndex = -1;
    let photos = [
        'https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_ProfilePage/dumbbell.png',
        'https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_ProfilePage/jumping_jacks.png',
        'https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_ProfilePage/treadmill.png'
    ];
    let originalPhotoUrl = '';
    let currentPhotoUrl = '';

    // Fetch user profile on page load
    window.onload = function () {
        fetch(`Profilebackend.php?userId=${userId}`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${userId}`, // Use userId for Authorization
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            console.log("Response Status:", response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log("Fetched profile data:", data);
            if (data.error) {
                throw new Error(data.error);
            } else {
                originalData = data;

                document.getElementById("username").value = data.username;
                document.getElementById("email").value = data.email;
                document.getElementById("name").value = data.name;
                document.getElementById("age").value = data.age;

                // Update this line in the fetch response handling
                document.getElementById("profile-pic-display").src = data.profile_pic || 'https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_ProfilePage/dumbbell.png'; // Use your actual default image URL

                originalPhotoUrl = data.profile_pic;
                currentPhotoUrl = data.profile_pic;
                currentPhotoIndex = photos.indexOf(data.profile_pic);
                preparePhotoOrder();
            }
        })
        .catch(error => {
            console.error('Error fetching profile:', error);
            alert("An error occurred while fetching your profile. Please try again later.");
        });
    };

    function preparePhotoOrder() {
        photoOrder = photos.filter((_, index) => index !== currentPhotoIndex);
        photoIndex = 0;
    }

    // Hamburger menu toggle
    document.querySelector('.hamburger-menu').addEventListener('click', function () {
        const menu = document.querySelector('.nav-menu');
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    });

    function toggleSidebar() {
        const sidebar = document.getElementById("sidebar");
        const menuIcon = document.getElementById("menu-icon");
        const closeMenu = document.getElementById("close-menu");

        sidebar.classList.toggle("active");
        menuIcon.style.display = sidebar.classList.contains("active") ? "none" : "block";
        closeMenu.style.display = sidebar.classList.contains("active") ? "block" : "none";
    }


    function enableEdit() {
        document.getElementById("username").disabled = false;
        document.getElementById("email").disabled = false;
        document.getElementById("name").disabled = false;
        document.getElementById("age").disabled = false;

        document.getElementById("change-photo-btn").style.display = "inline-block";

        document.querySelector(".edit-btn").style.display = "none";
        document.querySelector(".save-btn").style.display = "inline-block";
        document.querySelector(".cancel-btn").style.display = "inline-block";
    }

    function cancelEdit() {
        document.getElementById("username").value = originalData.username;
        document.getElementById("email").value = originalData.email;
        document.getElementById("name").value = originalData.name;
        document.getElementById("age").value = originalData.age;

        document.getElementById("username").disabled = true;
        document.getElementById("email").disabled = true;
        document.getElementById("name").disabled = true;
        document.getElementById("age").disabled = true;

        document.getElementById("profile-pic-display").src = originalPhotoUrl;
        preparePhotoOrder();
        photoIndex = 0;
        document.getElementById("change-photo-btn").style.display = "none";

        document.querySelector(".edit-btn").style.display = "inline-block";
        document.querySelector(".save-btn").style.display = "none";
        document.querySelector(".cancel-btn").style.display = "none";
    }

    function changePhoto() {

        if (!photos || photos.length === 0) {
            console.error('Photo array is empty or not initialized');
            return;
        }

        if (currentPhotoIndex === -1) {
            console.error('Current photo index is invalid');
            return;
        }


        let nextPhotoIndex = (currentPhotoIndex + 1) % photos.length;
        const profilePicDisplay = document.getElementById("profile-pic-display");

        if (profilePicDisplay) {
            profilePicDisplay.src = photos[nextPhotoIndex];
            currentPhotoUrl = photos[nextPhotoIndex];
            currentPhotoIndex = nextPhotoIndex;

            console.log(`Profile picture updated to: ${photos[nextPhotoIndex]}`);
        } else {
            console.error('Profile picture display element not found');
        }
    }


   function logout() {
    // Send a DELETE request to the backend to handle cookie deletion
    fetch('Profilebackend.php', {
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


    function saveChanges() {
        const email = document.getElementById("email").value;
        const name = document.getElementById("name").value;


        if (!email.includes('@')) {
            alert("Invalid email. Email must contain an '@' symbol.");
            return;
        }


        const nameRegex = /^[A-Za-z\s]+$/;
        if (!nameRegex.test(name)) {
            alert("Invalid name. Name must contain only letters and spaces (no numbers, emojis, or punctuation).");
            return;
        }

        const updatedData = {

            userId: userId,

            username: document.getElementById("username").value,
            email: email,
            name: name,
            age: document.getElementById("age").value,

            profile_pic: currentPhotoUrl
        };


        fetch('Profilebackend.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(updatedData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Profile updated successfully!");

                originalData = updatedData;
                originalPhotoUrl = currentPhotoUrl;
                cancelEdit();

            } else {
                console.error("Error updating profile:", data.error);
                alert("Failed to update profile. Please try again.");
            }
        })
        .catch(error => {
            console.error('Error saving changes:', error);
            alert("An error occurred while saving changes. Please try again.");
        });
    }

</script>
</body>
</html>

