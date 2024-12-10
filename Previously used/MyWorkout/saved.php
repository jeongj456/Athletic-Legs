<script>
document.getElementById("shareWorkoutBtn").addEventListener("click", function () {
            var sent_to = document.getElementById("sent_to").value;
            //Fetch for sending edits to the backend
            const workoutId = event.target.getAttribute('data-id');
            //workoutToEdit = workoutId; // Store the workout ID being edited
            workoutToShare = workoutId; // Store the workout ID being shared

            if (sent_to.trim() !== "") {
                var data = {
                    sent_to: sent_to
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

                        
                    } else {
                        alert("Error sharing workout: " + result.message);
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred while sharing the workout. Please try again.");
                });
            } else {
                alert("Please enter an email.");
            }
        });
        </script>