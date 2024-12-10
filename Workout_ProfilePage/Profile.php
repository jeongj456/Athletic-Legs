<?php 
    include '../Navbar/navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Profile</title>
        <link rel="stylesheet" href="../Navbar/navbar.css">
        <link rel="stylesheet" href="Profile.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link href='https://fonts.googleapis.com/css?family=Josefin Sans' rel='stylesheet'>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>
        <input type="hidden" id="csrf_token" value="<?php session_start(); echo $_SESSION['csrf_token']; ?>">
        <div class="athletic-legs-header">
            <span class="header-title">Profile</span>
            <button class="logout" onclick="logout()">Log Out</button>
        </div> 
    <!-- </body> -->

   <div class="container">
    <div class="profile-info"> 
        <div class="profile-pic">
            <img id="profile-pic-display" src="https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_ProfilePage/dumbbell.png" alt="Profile Picture" />
            <button id="change-photo-btn" onclick="togglePhotoDropdown()" style="display: none;">Change Photo</button>
            <select id="photo-dropdown" style="display: none;" onchange="updatePhoto()">
                <option value="https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_ProfilePage/dumbbell.png">Dumbbell</option>
                <option value="https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_ProfilePage/jumping_jacks.png">Jump Rope</option>
                <option value="https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_ProfilePage/treadmill.png">Treadmill</option>
            </select>
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

    function toggleSidebar() {
        const sidebar = document.getElementById("sidebar");
        const menuIcon = document.getElementById("menu-icon");
        const closeMenu = document.getElementById("close-menu");

        sidebar.classList.toggle("active");
        menuIcon.style.display = sidebar.classList.contains("active") ? "none" : "block";
        closeMenu.style.display = sidebar.classList.contains("active") ? "block" : "none";
    }

    function enableEdit() {
        // document.getElementById("username").disabled = false;
        // document.getElementById("email").disabled = false;
        document.getElementById("name").disabled = false;
        document.getElementById("age").disabled = false;
        document.getElementById("change-photo-btn").style.display = "inline-block";
        document.querySelector(".edit-btn").style.display = "none";
        document.querySelector(".save-btn").style.display = "inline-block";
        document.querySelector(".cancel-btn").style.display = "inline-block";
    }

    function cancelEdit() {
        // document.getElementById("username").value = originalData.username;
        // document.getElementById("email").value = originalData.email;
        document.getElementById("name").value = originalData.name;
        document.getElementById("age").value = originalData.age;
        // document.getElementById("username").disabled = true;
        // document.getElementById("email").disabled = true;
        document.getElementById("name").disabled = true;
        document.getElementById("age").disabled = true;
        document.getElementById("profile-pic-display").src = originalPhotoUrl;
        preparePhotoOrder();
        photoIndex = 0;
        document.getElementById("change-photo-btn").style.display = "none";
        document.querySelector(".edit-btn").style.display = "inline-block";
        document.querySelector(".save-btn").style.display = "none";
        document.querySelector(".cancel-btn").style.display = "none";

        const dropdown = document.getElementById("photo-dropdown");
        dropdown.style.display = "none";
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
        const age = document.getElementById("age").value;

        if (age % 1 !== 0) {
            alert("Please enter a valid age.");
            return;
        }

        const parsedAge = parseInt(age, 10);

        if (!email.includes('@')) {
            alert("Invalid email. Email must contain an '@' symbol.");
            return;
        }

        // const nameRegex = /^[A-Za-z\s]+$/;
        // const nameRegex = /^[A-Za-z\s'-]+$/;
        const nameRegex = /^[A-Za-z0-9\s'-]+$/;
        if (!nameRegex.test(name)) {
            alert("Invalid name. (emojis, or most punctuation).");
            return;
        }

        // Ensures age between certain values
        if (isNaN(age) || age < 1 || age > 120) {
            alert("Please enter a valid age.");
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
        console.log("here");
        const csrf_token = document.getElementById("csrf_token").value;
        console.log(csrf_token);

        fetch('./Profilebackend.php', {
            headers: {
            "X-CSRF-Token": csrf_token,
            "Content-Type": "application/json"
            },
            method: 'POST',
            body: JSON.stringify(updatedData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Profile updated successfully!");
                originalData = updatedData;
                originalPhotoUrl = currentPhotoUrl;
                cancelEdit();

                const dropdown = document.getElementById("photo-dropdown");
                dropdown.style.display = "none";

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


    

    function togglePhotoDropdown() {
        const dropdown = document.getElementById("photo-dropdown");
        const currentPhoto = document.getElementById("profile-pic-display").src;

        // Set the dropdown's value to match the current photo
        dropdown.value = currentPhoto;

        // Toggle the dropdown visibility
        if (dropdown.style.display === "none") {
            dropdown.style.display = "block";
        } else {
            dropdown.style.display = "none";
        }
    }

    function updatePhoto() {
        const dropdown = document.getElementById("photo-dropdown");
        const selectedPhotoUrl = dropdown.value;
        document.getElementById("profile-pic-display").src = selectedPhotoUrl;
        currentPhotoUrl = selectedPhotoUrl; // Update the current photo URL
    }

</script>
</body>

</html>