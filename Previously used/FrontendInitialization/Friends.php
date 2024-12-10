<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Friends</title>
  <link rel="stylesheet" href="../Navbar/navbar.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <style>
    /* General Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    /* Header Section */
.header-blue {
  background-color: #006b9f; /* Blue background */
  color: white;
  text-align: center;
  padding: 20px;
  font-size: 24px;
  font-weight: bold;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Hamburger Menu Icon */
.hamburger-menu {
  position: absolute;
  left: 20px; /* Align to the far left */
  cursor: pointer;
}

.hamburger-menu i {
  font-size: 30px;
  color: #fff; /* Make the icon white to match the header */
}

/* Navigation Menu (Hidden by Default) */
.nav-menu {
  display: none; /* Hidden by default */
  position: absolute;
  top: 60px; /* Adjusted to appear below the header */
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

.hamburger-menu .nav-menu {
    display: none;
  }
    /* Sidebar for Buttons */
    .sidebar {
      display: flex;
      flex-direction: column;
      margin-right: 20px;
    }

    /* Button Styles */
    .button {
      background-color: #006b9f; /* Blue background */
      color: white;
      padding: 10px;
      margin-bottom: 10px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
      text-align: left;
      width: 150px;
    }

    .button:hover {
      background-color: #005680;
    }

    /* Modal Styling */
    .modal, .view-friends-modal, .incoming-friends-modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
      z-index: 1002;
    }

    .modal-content, .view-friends-modal-content, .incoming-friends-modal-content {
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      width: 300px;
      text-align: center;
      position: relative;
    }

    .close-btn {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 20px;
      cursor: pointer;
      color: #0074A9;
    }
.your-friends-text {
  color: blue;
  font-size: 18px;
  text-align: center;
  margin-top: -140px;
}

  </style>
</head>
<body>
  <!-- Header Section -->
  <div class="header-blue">
    <span>Friends</span>
    <div class="hamburger-menu" onclick="toggleMenu()">
      <i class="fa fa-bars"></i>
    </div>
  </div>

   <!-- Hidden Navigation Menu -->
  <div class="nav-menu" id="navMenu">
    <a href="https://se-dev.cse.buffalo.edu/CSE442/2024-Fall/richiezh/Initilization_Page.php">Home</a>
    <a href="https://se-dev.cse.buffalo.edu/CSE442/2024-Fall/richiezh/Profile.php">Profile</a>
    <a href="https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_PlannedWorkouts/PlannedWorkout.php">Planned Workout</a>
    <a href="https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_History/WorkoutHistory.php">Workout History</a>
    <a href="https://se-dev.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_MacroPage/Macros.php">Macronutrients</a>
    <a href="https://se-dev.cse.buffalo.edu/CSE442/2024-Fall/richiezh/WorkoutStats.php">My Stats</a>
    <a href="https://se-dev.cse.buffalo.edu/CSE442/2024-Fall/richiezh/Friends.php">Friends</a>
  </div>
  <!-- Main Content Area -->
  <div class="container">
    <!-- Left Sidebar Buttons -->
    <div class="sidebar">
      <button class="button" onclick="openViewFriendsModal()">View Friends</button>
      <button class="button" onclick="openModal()">Add Friends</button>
      <button class="button" onclick="openFriendRequestsModal()">Incoming Friends</button>
    </div>

   <div class="content">
  
<p class="your-friends-text">Your Friends</p>
</div>  
    <!-- Friends list will be populated here -->
  </div>
</div>

  <!-- Modal for Adding Friends -->
  <div class="modal" id="addFriendModal">
    <div class="modal-content">
      <span class="close-btn" onclick="closeModal()">&times;</span>
      <h2>Enter Friend's Username</h2>
      <input type="text" id="friendUsername" placeholder="Username">
      <button class="button" onclick="addFriend()">Add Friend</button>
    </div>
  </div>

<!-- Modal for Viewing Friends -->
<div class="view-friends-modal" id="viewFriendsModal">
  <div class="view-friends-modal-content">
    <span class="close-btn" onclick="closeViewFriendsModal()">&times;</span>
    <h2>Your Friends</h2>
    <div id="modalFriendsList">
      <!-- Friends list will be populated here in the modal -->
    </div>
  </div>
</div>

  <!-- Modal for Incoming Friend Requests -->
  <div class="incoming-friends-modal" id="incomingFriendsModal">
    <div class="incoming-friends-modal-content">
      <span class="close-btn" onclick="closeFriendRequestsModal()">&times;</span>
      <h2>Incoming Friend Requests</h2>
      <div id="incomingRequestsList">
        <!-- Incoming requests will be populated here -->
      </div>
    </div>
  </div>

  <script>
 let currentUsername; // Store logged-in username
    function toggleMenu() {
      const navMenu = document.getElementById("navMenu");
      navMenu.style.display = navMenu.style.display === "block" ? "none" : "block";
    }

   
  // Open and close modal functions
  function openModal() { document.getElementById("addFriendModal").style.display = "flex"; loadFriends(); }
  function closeModal() { document.getElementById("addFriendModal").style.display = "none"; }
  function openViewFriendsModal() { document.getElementById("viewFriendsModal").style.display = "flex"; loadFriends(); }
  function closeViewFriendsModal() { document.getElementById("viewFriendsModal").style.display = "none"; }
  function openFriendRequestsModal() { document.getElementById("incomingFriendsModal").style.display = "flex"; loadIncomingRequests(); }
  function closeFriendRequestsModal() { document.getElementById("incomingFriendsModal").style.display = "none"; }

  function addFriend() {
    const username = document.getElementById("friendUsername").value.trim();
    if (username === currentUsername) {
      alert("You cannot send a friend request to yourself.");
      return;
    }

    fetch("Friendsbackend.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ action: "addFriend", username: username }),
    })
    .then(response => response.json())
    .then(data => {
      if (data.error) {
        alert(data.error);
      } else if (data.success) {
        alert("Friend request sent successfully!");
        closeModal();
      } else {
        alert("Unexpected response");
      }
    })
    .catch(error => {
      console.error("Error:", error);
    });
  }

  function loadIncomingRequests() {
    fetch("Friendsbackend.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ action: "getIncomingRequests" })
    })
    .then(response => response.json())
    .then(data => {
      const incomingRequestsList = document.getElementById("incomingRequestsList");
      incomingRequestsList.innerHTML = "";

      if (data.error) {
        alert(data.error);
      } else if (data.incomingRequests && data.incomingRequests.length > 0) {
        data.incomingRequests.forEach(request => {
          const requestElement = document.createElement("div");
          requestElement.className = "incoming-friend-request";
          requestElement.innerHTML = `
            <span>${request.username}</span>
            <button onclick="acceptFriendRequest('${request.id}')">Accept</button>
            <button onclick="rejectRequest('${request.id}')">Decline</button>
          `;
          incomingRequestsList.appendChild(requestElement);
        });
      } else {
        incomingRequestsList.innerHTML = "<p>No incoming friend requests.</p>";
      }
    })
    .catch(error => {
      console.error("Error loading incoming requests:", error);
    });
  }

  function acceptFriendRequest(requestId) {
    fetch("Friendsbackend.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ action: "acceptFriendRequest", requestId: requestId })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert("Friend request accepted.");
        loadIncomingRequests();
      } else {
        alert(data.error);
      }
    })
    .catch(error => {
      console.error("Error:", error);
    });
  }

  function rejectRequest(requestId) {
    fetch("Friendsbackend.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ action: "rejectFriendRequest", requestId: requestId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Friend request declined.");
            loadIncomingRequests(); // Reload requests after decline
        } else {
            alert(data.error);
        }
    })
    .catch(error => {
        console.error("Error rejecting friend request:", error);
    });
}
function loadFriends() {
  fetch("Friendsbackend.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ action: "getFriends" })
  })
  .then(response => response.json())
  .then(data => {
    const modalFriendsList = document.getElementById("modalFriendsList");

    if (modalFriendsList) {
      // Clear current content in the modal
      modalFriendsList.innerHTML = "";

      if (data.error) {
        alert(data.error);
      } else if (data.friends && data.friends.length > 0) {
        // Populate modal with friends
        data.friends.forEach(friend => {
          const friendElement = document.createElement("div");
          friendElement.textContent = friend.username;
          modalFriendsList.appendChild(friendElement);
        });
      } else {
        modalFriendsList.innerHTML = "<p>No friends found.</p>";
      }
    } else {
      console.error("Modal friends list element not found.");
    }
  })
  .catch(error => {
    console.error("Error loading friends:", error);
  });
}



  // Save current username upon loading the script
  window.onload = function() {
    currentUsername = "user"; // Replace with logic to get the actual username
    loadFriends(); // Load friends on startup
  }  </script>
</body>
</html>
