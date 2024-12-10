<?php
include '../Navbar/navbar.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Workout Friends Page</title>
    <link rel="stylesheet" href="../Navbar/navbar.css">
    <link rel="stylesheet" href="Friends.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <!--Google Fonts Linking for Josefin Sans (Textfield Font)-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
</head>

<body>

    <div class="heading_box">
        <div class="title_text">
            Friends
        </div>
    </div>

    <div class="buttons">
        <button onclick="changeContent('ViewFriends')">View Friends</button>
        <button onclick="changeContent('AddFriends')">Search</button>
        <button onclick="changeContent('PendingRequests')">Pending Requests</button>
        <button onclick="changeContent('BlockedUsers')">Blocked</button>
    </div>

    <div id="contentContainer" class="content-container">
        <!-- <h2>Your Friends</h2>
            <p>This is the content displayed when you first load the page. You should just see your current friends.</p> -->
    </div>

    <br>

    <!-- Modal for confirming removing a friend -->
    <div id="confirmModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close-button">×</span>
            <p>Are you sure you want to remove your friend [USERNAME]?</p>
            <button id="confirmYes" class="modal-button">Yes</button>
            <button id="confirmNo" class="modal-button">No</button>
        </div>
    </div>

    <!-- Modal for viewing friend workouts -->
    <div id="confirmModal2" class="modal2" style="display: none;">
        <div class="modal-content2">
            <span class="close-button2">×</span>
            <h2>[USER_NAME] Workouts</h2>
            <p>Weight Workouts:</p>
            <table class="workout-table1">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Weight (lbs)</th>
                        <th>Reps</th>
                        <th>Sets</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>[Exercise Name]</td>
                        <td>[Weight]</td>
                        <td>[Reps]</td>
                        <td>[Sets]</td>
                        <td>[Date]</td>
                    </tr>
                </tbody>
            </table>

            <hr>

            <p>Cardio Workouts:</p>
            <table class="workout-table2">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Time (hrs)</th>
                        <th>Distance (mi)</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>[Exercise Name]</td>
                        <td>[Time]</td>
                        <td>[Distance]</td>
                        <td>[Date]</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>


    <script>

        document.addEventListener("DOMContentLoaded", () => {

            // Check if the required cookie is present
            const UserID = "Authentication_Token";

            // Function to get the value of a cookie by name
            function getCookie(name) {
                const value = `; ${document.cookie}`;
                const parts = value.split(`; ${name}=`);
                if (parts.length === 2) return parts.pop().split(";").shift();
            }

            // Check if the required cookie is missing
            if (!getCookie(UserID)) {
                alert("You have to be logged in to view your friends!");
                window.location.href = "https://se-prod.cse.buffalo.edu/CSE442/2024-Fall/cse-442m/Workout_Login/Login.php";
                return;
            }

            // Ensure that View Friends content is displayed on load
            changeContent("ViewFriends");

            // Event listener for dropdown toggling
            document.addEventListener("click", (e) => {
                // Check if the clicked element is an ellipsis icon
                if (e.target.classList.contains("ellipsis-icon")) {
                    // Close all open dropdowns
                    document.querySelectorAll(".dropdown-menu").forEach((menu) => {
                        menu.style.display = "none";
                    });

                    // Open the clicked dropdown
                    const dropdownMenu = e.target.nextElementSibling;
                    dropdownMenu.style.display = "block";
                } else {
                    // Close any open dropdowns if clicking outside
                    document.querySelectorAll(".dropdown-menu").forEach((menu) => {
                        menu.style.display = "none";
                    });
                }
            });
        });


        // Fucntion returns the name of the person logged in from their profile info to display
        async function fetchLoggedInName() {
            try {
                const response = await fetch("Friendsbackend.php?action=getLoggedInName");

                if (!response.ok) {
                    throw new Error("Failed to fetch logged-in name");
                }

                const data = await response.json();

                return data;
            } catch (error) {
                console.error("Error:", error);
                return "User"; // Default if there's an error
            }
        }

        // Function to remove a current friend
        async function removeCurrentFriend(friend) {
            try {
                const response = await fetch(`Friendsbackend.php?action=removeFriend&friendUser=${encodeURIComponent(friend.username)}`, {
                    method: "POST",
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new Error("Failed to remove friend");
                }
                // const modal = document.getElementById("confirmModal");
                // modal.style.display = "block";

                changeContent("ViewFriends");
                alert(`Removed friend ${friend.username}.`);
                // dropdownMenu.style.display = "none";

                // Optionally, remove the friend card from the DOM
                // friendCard.remove();
            } catch (error) {
                console.error("Error:", error);
                alert("There was an error removing the friend. Please try again.");
            }

        }


        // Function to view friends workouts weights
        async function viewFriendWorkouts(friend) {
            try {
                const response = await fetch(`Friendsbackend.php?action=viewWorkouts&friendUser=${encodeURIComponent(friend.username)}`, {
                    method: "POST",
                });

                const result = await response.json();
                console.log(result);
                return result;


                if (!response.ok) {
                    throw new Error("Failed to receive friend's workouts.");
                }
                // const modal = document.getElementById("confirmModal");
                // modal.style.display = "block";

                // changeContent("ViewFriends");
                // alert(`Removed friend ${friend.username}.`);
                // dropdownMenu.style.display = "none";

                // Optionally, remove the friend card from the DOM
                // friendCard.remove();
            } catch (error) {
                console.error("Error:", error);
                alert("There was an error getting your friends workouts. Please try again.");
            }

        }


        // Function to view friends workouts cardio
        async function viewFriendWorkoutsCardio(friend) {
            try {
                const response = await fetch(`Friendsbackend.php?action=viewWorkoutsCardio&friendUser=${encodeURIComponent(friend.username)}`, {
                    method: "POST",
                });

                const result = await response.json();
                console.log(result);
                return result;


                if (!response.ok) {
                    throw new Error("Failed to receive friend's workouts.");
                }
                // const modal = document.getElementById("confirmModal");
                // modal.style.display = "block";

                // changeContent("ViewFriends");
                // alert(`Removed friend ${friend.username}.`);
                // dropdownMenu.style.display = "none";

                // Optionally, remove the friend card from the DOM
                // friendCard.remove();
            } catch (error) {
                console.error("Error:", error);
                alert("There was an error getting your friends workouts. Please try again.");
            }

        }



        // Function to get content on View Friends Page (Profile Pic, Username, and Name from the friend)
        async function fetchAcceptedFriends(contentContainer) {
            try {
                const response = await fetch("Friendsbackend.php?action=getAcceptedFriends");

                if (!response.ok) {
                    throw new Error("Failed to fetch accepted friends");
                }

                const acceptedFriends = await response.json();

                const friendsGrid = document.createElement("div");
                friendsGrid.classList.add("friends-grid");
                contentContainer.appendChild(friendsGrid);

                if (acceptedFriends.length > 0) {
                    acceptedFriends.forEach(friend => {
                        const friendCard = document.createElement("div");
                        friendCard.classList.add("friend-card");

                        const profilePic = document.createElement("img");
                        profilePic.src = friend.profile_pic;
                        profilePic.alt = `${friend.username}'s profile picture`;
                        profilePic.classList.add("profile-pic");

                        const detailsContainer = document.createElement("div");
                        detailsContainer.classList.add("friend-details");

                        const nameText = document.createElement("p");
                        nameText.classList.add("friend-name");
                        nameText.textContent = friend.name;

                        const usernameContainer = document.createElement("div");
                        usernameContainer.classList.add("username-container");

                        const usernameText = document.createElement("p");
                        usernameText.classList.add("friend-username");
                        usernameText.textContent = `@${friend.username}`;

                        usernameContainer.appendChild(usernameText);
                        detailsContainer.appendChild(nameText);
                        detailsContainer.appendChild(usernameContainer);

                        // Ellipsis icon container with wrapper for better positioning
                        const actionsContainer = document.createElement("div");
                        actionsContainer.classList.add("actions-container");

                        const ellipsisIcon = document.createElement("i");
                        ellipsisIcon.classList.add("fas", "fa-ellipsis-v", "ellipsis-icon");

                        actionsContainer.appendChild(ellipsisIcon);

                        // Rest of your dropdown menu code remains the same
                        const dropdownMenu = document.createElement("div");
                        dropdownMenu.classList.add("dropdown-menu");

                        const viewWorkoutsOption = document.createElement("p");
                        viewWorkoutsOption.textContent = "View Workouts";

                        const removeFriendOption = document.createElement("p");
                        removeFriendOption.textContent = "Remove Friend";
                        removeFriendOption.style.color = "red";

                        const BlockOption = document.createElement("p");
                        BlockOption.textContent = "Block";
                        BlockOption.style.color = "red";

                        // BlockOption.addEventListener("click", () => blockUser(friend.username));

                        BlockOption.addEventListener("click", async () => {
                            // Show the modal
                            const modal = document.getElementById("confirmModal");
                            openModal();
                            // modal.style.display = "flex";

                            // Insert friend's username in the modal
                            modal.querySelector("p").textContent = `Are you sure you want to block ${friend.username}?`;

                            // Yes button
                            document.getElementById("confirmYes").onclick = async () => {
                                dropdownMenu.style.display = "none";
                                // modal.style.display = "none";
                                closeModal();
                                await blockUser(friend.username);
                                changeContent("ViewFriends");
                            };

                            // No button
                            document.getElementById("confirmNo").onclick = () => {
                                closeModal();
                                // modal.style.display = "none";
                            };

                            // Close modal when '×' button is clicked
                            document.querySelector(".close-button").onclick = () => {
                                closeModal();
                                // modal.style.display = "none";
                            };

                        });


                        removeFriendOption.addEventListener("click", async () => {
                            // Show the modal
                            const modal = document.getElementById("confirmModal");
                            openModal();
                            // modal.style.display = "flex";

                            // Insert friend's username in the modal
                            modal.querySelector("p").textContent = `Are you sure you want to remove your friend ${friend.username}?`;

                            // Yes button
                            document.getElementById("confirmYes").onclick = async () => {
                                dropdownMenu.style.display = "none";
                                // modal.style.display = "none";
                                closeModal();
                                await removeCurrentFriend(friend);
                            };

                            // No button
                            document.getElementById("confirmNo").onclick = () => {
                                closeModal();
                                // modal.style.display = "none";
                            };

                            // Close modal when '×' button is clicked
                            document.querySelector(".close-button").onclick = () => {
                                closeModal();
                                // modal.style.display = "none";
                            };

                        });






                        viewWorkoutsOption.addEventListener("click", async () => {

                            const modal = document.getElementById("confirmModal2");
                            modal.style.display = "flex"; // Show the modal

                            modal.querySelector("h2").textContent = `${friend.name}'s Workouts:`;

                            // Clear any existing content in the table body
                            // const tableBody = document.querySelector(".workout-table1 tbody");
                            // tableBody.innerHTML = "";

                            try {
                                const tableBody = document.querySelector(".workout-table1 tbody");
                                tableBody.innerHTML = "";
                                // Fetch workout data for the friend
                                const workouts = await viewFriendWorkouts(friend); // Assuming this returns the workout array
                                console.log(friend.username);
                                // console.log(workouts);

                                if (Array.isArray(workouts) && workouts.length > 0) {
                                    // Append each workout to the modal's table
                                    workouts.forEach(workout => {
                                        const row = document.createElement("tr");
                                        row.innerHTML = `
                                                <td>${workout.name}</td>
                                                <td>${workout.numbers[2]}</td>
                                                <td>${workout.numbers[1]}</td>
                                                <td>${workout.numbers[0]}</td>
                                                <td>${workout.date}</td>
                                            `;
                                        tableBody.appendChild(row);
                                    });
                                } else {
                                    // Display a message if no workouts are found
                                    const noDataRow = document.createElement("tr");
                                    noDataRow.innerHTML = `<td colspan="5">No workouts found.</td>`;
                                    tableBody.appendChild(noDataRow);
                                }
                            } catch (error) {
                                console.error("Error fetching workouts:", error);
                            }


                            try {
                                const tableBody = document.querySelector(".workout-table2 tbody");
                                tableBody.innerHTML = "";
                                // Fetch workout data for the friend
                                const workouts = await viewFriendWorkoutsCardio(friend); // Assuming this returns the workout array
                                console.log(friend.username);
                                // console.log(workouts);

                                if (Array.isArray(workouts) && workouts.length > 0) {
                                    // Append each workout to the modal's table
                                    workouts.forEach(workout => {
                                        const row = document.createElement("tr");
                                        row.innerHTML = `
                                                <td>${workout.name}</td>
                                                <td>${workout.numbers[0]}</td>
                                                <td>${workout.numbers[1]}</td>
                                                <td>${workout.date}</td>
                                            `;
                                        tableBody.appendChild(row);
                                    });
                                } else {
                                    // Display a message if no workouts are found
                                    const noDataRow = document.createElement("tr");
                                    noDataRow.innerHTML = `<td colspan="5">No workouts found.</td>`;
                                    tableBody.appendChild(noDataRow);
                                }
                            } catch (error) {
                                console.error("Error fetching workouts:", error);
                            }

                            // Close the modal when the '×' button is clicked
                            document.querySelector(".close-button2").onclick = () => {
                                modal.style.display = "none";
                            };
                        });





                        dropdownMenu.appendChild(viewWorkoutsOption);
                        dropdownMenu.appendChild(removeFriendOption);
                        dropdownMenu.appendChild(BlockOption);

                        friendCard.appendChild(profilePic);
                        friendCard.appendChild(detailsContainer);
                        friendCard.appendChild(ellipsisIcon);
                        friendCard.appendChild(dropdownMenu);

                        friendsGrid.appendChild(friendCard);
                    });
                } else {
                    const noFriends = document.createElement("p");
                    noFriends.textContent = "You don't have any friends yet, but head over to 'Search' to start connecting with others!";

                    contentContainer.appendChild(noFriends);
                }
            } catch (error) {
                console.error("Error:", error);
                alert("There was an error fetching your friends. Please try again.");
            }
        }


        // Function for the Accept and Reject button of Pending Request Page
        async function handleFriendRequest(username, responseAction) {
            try {
                const response = await fetch(`Friendsbackend.php?action=handleFriendRequest&username=${encodeURIComponent(username)}&responseAction=${encodeURIComponent(responseAction)}`, {
                    method: 'POST',
                });

                if (!response.ok) {
                    throw new Error("Failed to handle friend request");
                }

                const result = await response.json();

                // Update based on the response (remove the request from the list/ alert)
                if (result.success) {
                    if (responseAction === 'Accept' || responseAction === 'Reject') {
                        alert(`${responseAction}ed friend request from ${username}.`);
                        changeContent('PendingRequests');  // Re-fetch and display the pending requests
                    } else if (responseAction == 'cancel') {
                        alert(`Friend request to ${username} ${responseAction}ed.`);
                        changeContent('PendingRequests');  // Re-fetch and display the pending requests
                    }
                    // alert(`${responseAction}ed friend request from ${username}.`);
                    // changeContent('PendingRequests');  // Re-fetch and display the pending requests
                } else {
                    alert(result.error);
                }
            } catch (error) {
                console.error("Error:", error);
                alert("There was an error handling the friend request. Please try again.");
            }
        }



        async function unblockUser(username) {
            try {
                const response = await fetch(`Friendsbackend.php?action=unblockUser&username=${encodeURIComponent(username)}`, {
                    method: 'POST',
                });

                if (!response.ok) {
                    throw new Error("Failed to handle friend request");
                }

                const result = await response.json();

                // Update based on the response (remove the request from the list/ alert)
                if (result.success) {
                    alert(`Unblocked ${username}.`);
                    changeContent('BlockedUsers');  // Re-fetch and display the pending requests
                
                } else {
                    alert(result.error);
                }
            } catch (error) {
                console.error("Error:", error);
                alert("There was an error handling unblocking. Please try again.");
            }
        }


















        async function fetchPendingRequests(contentContainer) {
            try {
                const response = await fetch("Friendsbackend.php?action=getPendingRequests");
                if (!response.ok) {
                    throw new Error("Failed to fetch pending requests");
                }

                const pendingRequests = await response.json();

                if (pendingRequests.length > 0) {
                    pendingRequests.forEach(username => {
                        const requestContainer = document.createElement("div");
                        requestContainer.classList.add("result-container");

                        // Username section
                        const usernameWrapper = document.createElement("div");
                        usernameWrapper.classList.add("username-wrapper");

                        const userText = document.createElement("div"); // Changed to div for better wrapping
                        userText.style.display = "flex";
                        userText.style.flexWrap = "wrap";

                        const label = document.createElement("span");
                        label.textContent = "From: ";
                        label.classList.add("user-label");

                        const usernameSpan = document.createElement("span"); // Separate span for username
                        usernameSpan.textContent = username;
                        usernameSpan.style.wordBreak = "break-word";

                        userText.appendChild(label);
                        userText.appendChild(usernameSpan);
                        usernameWrapper.appendChild(userText);
                        requestContainer.appendChild(usernameWrapper);

                        // Button group
                        const buttonGroup = document.createElement("div");
                        buttonGroup.classList.add("button-group");

                        const acceptButton = document.createElement("button");
                        acceptButton.textContent = "Accept";
                        acceptButton.classList.add("friend-request-button");
                        acceptButton.addEventListener("click", () => handleFriendRequest(username, "Accept"));

                        const rejectButton = document.createElement("button");
                        rejectButton.textContent = "Reject";
                        rejectButton.style.backgroundColor = "black";
                        rejectButton.classList.add("friend-request-button");
                        rejectButton.addEventListener("click", () => handleFriendRequest(username, "Reject"));

                        buttonGroup.appendChild(acceptButton);
                        buttonGroup.appendChild(rejectButton);
                        requestContainer.appendChild(buttonGroup);

                        contentContainer.appendChild(requestContainer);
                        contentContainer.appendChild(document.createElement("hr"));
                    });
                } else {
                    const noRequests = document.createElement("p");
                    noRequests.textContent = "No incoming friend requests.";
                    noRequests.style.fontWeight = "bold";
                    contentContainer.appendChild(noRequests);
                    contentContainer.appendChild(document.createElement("hr"));
                }
            } catch (error) {
                console.error("Error:", error);
                alert("There was an error fetching pending requests. Please try again.");
            }
        }


        async function fetchBlockedUsers(contentContainer) {
            try {
                const response = await fetch("Friendsbackend.php?action=BlockedUsers");


                if (!response.ok) {
                    throw new Error("Failed to fetch pending requests");
                }

                const blockedUsers = await response.json();

                if (blockedUsers.length > 0) {
                    blockedUsers.forEach(username => {
                        const requestContainer = document.createElement("div");
                        requestContainer.classList.add("result-container");

                        const usernameWrapper = document.createElement("div");
                        usernameWrapper.classList.add("username-wrapper");

                        const userText = document.createElement("span");

                        const label = document.createElement("span");
                        label.textContent = "Blocked: ";
                        label.classList.add("user-label");

                        userText.appendChild(label);
                        userText.append(username);
                        usernameWrapper.appendChild(userText);

                        requestContainer.appendChild(usernameWrapper);

                        // Create a container for buttons to keep them close together
                        const buttonGroup = document.createElement("div");
                        buttonGroup.classList.add("button-group");

                        const unblockButton = document.createElement("button");
                        unblockButton.textContent = "Unblock";
                        unblockButton.classList.add("friend-request-button");

                        // acceptButton.addEventListener("click", () => handleFriendRequest(username, "Accept"));

                        unblockButton.addEventListener("click", () => unblockUser(username));

                        // unblockButton.addEventListener("click", async () => {

                        //     alert(`Unblocked ${username}.`);

                        // });

                        buttonGroup.appendChild(unblockButton);

                        requestContainer.appendChild(buttonGroup);

                        contentContainer.appendChild(requestContainer);
                        contentContainer.appendChild(document.createElement("hr"));
                    });
                } else {
                    const noRequests = document.createElement("p");
                    noRequests.textContent = "You have not blocked any accounts.";
                    noRequests.style.fontWeight = "bold";
                    contentContainer.appendChild(noRequests);
                    contentContainer.appendChild(document.createElement("hr"));
                }
            } catch (error) {
                console.error("Error:", error);
                alert("There was an error fetching pending requests. Please try again.");
            }
        }

        async function fetchPendingRequestsWAIT(contentContainer) {
            try {
                const response = await fetch("Friendsbackend.php?action=getPendingRequestsWAIT");
                if (!response.ok) {
                    throw new Error("Failed to fetch pending requests");
                }

                const pendingRequests_WAIT = await response.json();

                if (pendingRequests_WAIT.length > 0) {
                    pendingRequests_WAIT.forEach(username => {
                        const requestContainer = document.createElement("div");
                        requestContainer.classList.add("result-container");

                        // Username section
                        const usernameWrapper = document.createElement("div");
                        usernameWrapper.classList.add("username-wrapper");

                        const userText = document.createElement("div"); // Changed to div for better wrapping
                        userText.style.display = "flex";
                        userText.style.flexWrap = "wrap";

                        const label = document.createElement("span");
                        label.textContent = "To: ";
                        label.classList.add("user-label");

                        const usernameSpan = document.createElement("span"); // Separate span for username
                        usernameSpan.textContent = username;
                        usernameSpan.style.wordBreak = "break-word";

                        userText.appendChild(label);
                        userText.appendChild(usernameSpan);
                        usernameWrapper.appendChild(userText);
                        requestContainer.appendChild(usernameWrapper);

                        // Button group
                        const buttonGroup = document.createElement("div");
                        buttonGroup.classList.add("button-group");

                        const statuslabel = document.createElement("span");
                        statuslabel.textContent = "Awaiting Response...";
                        statuslabel.classList.add("response-label");

                        const cancelButton = document.createElement("button");
                        cancelButton.textContent = "Cancel Request";
                        cancelButton.style.backgroundColor = "black";
                        cancelButton.classList.add("friend-request-button");
                        cancelButton.addEventListener("click", () => handleFriendRequest(username, "cancel"));

                        buttonGroup.appendChild(statuslabel);
                        buttonGroup.appendChild(cancelButton);
                        requestContainer.appendChild(buttonGroup);

                        contentContainer.appendChild(requestContainer);
                        contentContainer.appendChild(document.createElement("hr"));
                    });
                } else {
                    const noRequests = document.createElement("p");
                    noRequests.textContent = "No outgoing friend requests.";
                    noRequests.style.fontWeight = "bold";
                    contentContainer.appendChild(noRequests);
                }
            } catch (error) {
                console.error("Error:", error);
                alert("There was an error fetching pending requests. Please try again.");
            }
        }


        // Function to handle logic for the Send Friend Request Button on Add Friends Section
        async function sendFriendRequest(username) {
            try {
                const response = await fetch(`Friendsbackend.php?action=sendFriendRequest&username=${encodeURIComponent(username)}`, {
                    method: "POST"
                });

                if (!response.ok) {
                    throw new Error("Failed to send friend request");
                }

                alert(`Friend request sent to ${username}.`);
                changeContent('AddFriends');
            } catch (error) {
                console.error("Error:", error);
                alert("There was an error sending the friend request. Please try again.");
            }
        }


        // Function to handle logic for the Block Button on Add Friends Section
        async function blockUser(username) {
            try {
                const response = await fetch(`Friendsbackend.php?action=blockUser&username=${encodeURIComponent(username)}`, {
                    method: "POST"
                });

                if (!response.ok) {
                    throw new Error("Failed to send friend request");
                }

                changeContent('AddFriends');
                alert(`Blocked ${username}.`);
                // changeContent('AddFriends');
            } catch (error) {
                console.error("Error:", error);
                alert("There was an error sending the friend request. Please try again.");
            }
        }


        // Function for searching based on user query
        async function fetchFriendSearchResults(query) {
            const response = await fetch(`Friendsbackend.php?action=searchUsers&query=${encodeURIComponent(query)}`);

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();
            return data;
        }


        // Function for searching based on user query
        async function searchUsers() {
            const query = document.getElementById("searchInput").value;
            const resultsDiv = document.getElementById("searchResults");
            resultsDiv.innerHTML = "";

            if (query === "") {
                resultsDiv.innerHTML = "<p>No users found.</p>";
                return;
            }

            const usernames = await fetchFriendSearchResults(query);

            if (usernames === null || usernames.length === 0) {
                resultsDiv.innerHTML = "<p>No users found.</p>";
                return;
            }

            usernames.forEach(user => {
                // Create main container
                const resultContainer = document.createElement("div");
                resultContainer.classList.add("result-container");

                // Create profile container
                const profileContainer = document.createElement("div");
                profileContainer.classList.add("profile-container");

                // Create profile picture
                const profilePic = document.createElement("img");
                profilePic.src = user.profile_pic;
                profilePic.alt = `${user.username}'s profile picture`;
                profilePic.classList.add("profile-pic");

                // Create username container and text
                const usernameContainer = document.createElement("div");
                usernameContainer.style.flex = "1";
                usernameContainer.style.minWidth = "0";

                const userText = document.createElement("span");
                userText.textContent = user.username;
                userText.classList.add("username-text");

                usernameContainer.appendChild(userText);

                // Add profile pic and username to profile container
                profileContainer.appendChild(profilePic);
                profileContainer.appendChild(usernameContainer);

                // Create button container
                const buttonContainer = document.createElement("div");
                buttonContainer.classList.add("button-container");

                // Create buttons and status labels
                if (user.status === "None") {
                    const friendRequestButton = document.createElement("button");
                    friendRequestButton.textContent = "Send Friend Request";
                    friendRequestButton.classList.add("friend-request-button");
                    friendRequestButton.addEventListener("click", () => sendFriendRequest(user.username));
                    buttonContainer.appendChild(friendRequestButton);
                } else if (user.status === "Accepted") {
                    const statusLabel = document.createElement("span");
                    statusLabel.textContent = "Currently Friends";
                    statusLabel.classList.add("response-label");
                    buttonContainer.appendChild(statusLabel);
                } else if (user.status === "Pending") {
                    const statusLabel = document.createElement("span");
                    statusLabel.textContent = "Friend Request Pending";
                    statusLabel.classList.add("response-label");
                    buttonContainer.appendChild(statusLabel);
                }

                // Create block button
                const blockButton = document.createElement("button");
                blockButton.textContent = "Block";
                blockButton.style.backgroundColor = "black";
                blockButton.classList.add("friend-request-button");
                blockButton.addEventListener("click", async () => {
                    const modal = document.getElementById("confirmModal");
                    openModal();
                    modal.querySelector("p").textContent = `Are you sure you want to block ${user.username}?`;

                    document.getElementById("confirmYes").onclick = async () => {
                        closeModal();
                        await blockUser(user.username);
                        changeContent("AddFriends");
                    };

                    document.getElementById("confirmNo").onclick = closeModal;
                    document.querySelector(".close-button").onclick = closeModal;
                });

                buttonContainer.appendChild(blockButton);

                // Assemble the result container
                resultContainer.appendChild(profileContainer);
                resultContainer.appendChild(buttonContainer);

                // Add to results
                resultsDiv.appendChild(resultContainer);
                resultsDiv.appendChild(document.createElement("hr"));
            });
        }

        // Function to change content and add/remove elements based on press of three buttons at the top
        async function changeContent(button) {
            const contentContainer = document.getElementById("contentContainer");

            // Clear existing content
            contentContainer.innerHTML = "";

            if (button === "ViewFriends") {
                const loggedInName = await fetchLoggedInName();

                // Create and append elements for "View Friends" section
                const heading = document.createElement("h2");
                heading.textContent = "Your Friends";
                contentContainer.appendChild(heading);

                const welcomeMessage = document.createElement("p");
                welcomeMessage.className = "welcome-message";
                welcomeMessage.innerHTML = `Hi, <strong>${loggedInName}</strong>! Here are your current friends:`;
                contentContainer.appendChild(welcomeMessage);

                fetchAcceptedFriends(contentContainer);

            } else if (button === "AddFriends") {

                const heading = document.createElement("h2");
                heading.textContent = "Search";

                const paragraph = document.createElement("p");
                paragraph.textContent = "Find Others on Athletic Legs:";

                const form = document.createElement("form");
                form.id = "searchForm";

                const input = document.createElement("input");
                input.type = "text";
                input.id = "searchInput";
                input.placeholder = "Search Athletic Legs...";
                input.required = true;

                const button = document.createElement("button");
                button.type = "button";
                button.id = "searchUsers";
                button.textContent = "Search";

                button.addEventListener("click", searchUsers);

                input.addEventListener("keydown", (event) => {
                    if (event.key === "Enter") {
                        event.preventDefault();
                        searchUsers();
                    }
                });

                form.appendChild(input);
                form.appendChild(button);

                const searchResults = document.createElement("div");
                searchResults.id = "searchResults";

                contentContainer.appendChild(heading);
                contentContainer.appendChild(paragraph);
                contentContainer.appendChild(form);
                contentContainer.appendChild(searchResults);

            } else if (button === "PendingRequests") {
                const heading = document.createElement("h2");
                heading.textContent = "Pending Friend Requests";
                contentContainer.appendChild(heading);

                const paragraph = document.createElement("p");
                paragraph.textContent = "View and respond to your incoming friend requests:";
                contentContainer.appendChild(paragraph);

                await fetchPendingRequests(contentContainer);

                const paragraphtwo = document.createElement("p");
                paragraphtwo.textContent = "View the status of your outgoing friend requests:";
                contentContainer.appendChild(paragraphtwo);

                fetchPendingRequestsWAIT(contentContainer);

            } else if (button === "BlockedUsers") {
                const heading = document.createElement("h2");
                heading.textContent = "Blocked Accounts";
                contentContainer.appendChild(heading);

                const paragraph = document.createElement("p");
                paragraph.textContent = "View your blocked accounts and unblock them:";
                contentContainer.appendChild(paragraph);

                await fetchBlockedUsers(contentContainer);

            }

        }

        // Function to open the modal
        function openModal() {
            document.getElementById("confirmModal").style.display = "flex";
        }


        // Function to close the modal
        function closeModal() {
            document.getElementById("confirmModal").style.display = "none";
        }


        // Event listener to close the modal when clicking outside the modal content
        window.onclick = function (event) {
            const modal = document.getElementById("confirmModal");
            if (event.target === modal) {
                closeModal();
            }
        };

        window.addEventListener("click", (event) => {
            const modal = document.getElementById("confirmModal2");
            if (event.target === modal) {
                modal.style.display = "none";
            }
        });




    </script>

</body>

</html>

</html>