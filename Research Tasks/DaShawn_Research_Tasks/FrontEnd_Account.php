<!DOCTYPE html>
<html lang="en"></html>

<head>

    <title>Account Creation</title>

    <!--Google Fointts Linking for Josefin Sans (Textfield Font)-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">   

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        /* Just some labeling for the colors in this file!
            Dark Blue for the backgound: #006CA1
            Pale Blue for the Create Account background box: #bfdae6
            Green for the "Create Your Account" button: #18bc44
            Grey for background of input fields: #D9D9D9
            Black: #000000
            Text Grey: #777777
        */



        @media (max-width: 600px) {
            .input-fields {
                width: 100%;
            }
            .window {
                flex-direction: column;
                align-items: center;
            }
            .submit {
                width: 100%; /* Makes the submit button full width on mobile */
            }
        }


        @media (max-width: 600px) {
            .title {
                font-size: 1.5rem;
            }
            .info-text {
                font-size: 12px;
            }   
            .submit {
                font-size: 14px;
            }
        }
        




        .background_box {
            /* background-color: #bfdae6;
            padding: 10px;
            /* border: 500px; */
            /* margin: 100px; */

            /* position: relative ;
            top: 0px; */

            background-color: #bfdae6;
            padding: 20px;
            margin: 20px auto;
            /* max-width: 90%; */
            border-radius: 10px;
            max-width: 800px; /* Sets the maximum width */
            width: 90%; /* Ensures it scales on smaller screens */

            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);


        }

        body {
            background-color: #006CA1;
            margin: 0;
            padding: 0;
        
        }


        /* .input-fields and ::placeholder used for making input fields look how they do! */
        .input-fields {
            /* IMPORTANT */
            background-color: #D9D9D9;
            border: 1px solid black;
            border-radius: 4px;

            padding: 4px;
            margin: 4px;
            width: 200px;
            height: 20px;
            
            
        }

        ::placeholder {
            font-family: "Josefin Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 375;
            font-style: normal;

            color: #777777;
            opacity: 1;
        }


        /* Create Account Text at the top of the page! */
        .title {
            font-family: "Josefin Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 600;
            font-style: normal;

            color:#006CA1;

        }

        /* Making Submit Button */
        .submit {
            font-family: "Josefin Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 375;
            font-style: normal;

            background-color: #18bc44;
            color: white;
            opacity: 1;

            border: 1px solid black;
            border-radius: 20px;

            /* padding: 4px; */
            margin: 4px;
            /* width: 150px; */
            height: 25px;

            width: 100%;
            max-width: 150px;


            
            
        }

        .info-text {
            font-family: "Josefin Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 375;
            font-style: normal;

            color: black;
            opacity: 1;
            font-size: 14px;

        }

        .window {
            display: flex;
            justify-content: space-around;
            /* flex-direction: column; */
        }
        .window1 {
            display: flex;
            /* justify-content: space-around; */
            flex-direction: column;
        }

        .profile-title {
            color: #FFAEAE;

            font-family: "Josefin Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 600;
            font-style: normal;

            display: flex;
            justify-content: space-around;
        }

        .other-profiles {
            padding:8px;
            background-color: #bfdae6;
            margin: 20px auto;

            font-family: "Josefin Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 375;
            font-style: normal;

            display: flex;
            /* justify-content: space-around; */
            flex-direction: column;
            max-width: 500px; /* Sets the maximum width */
            
            border-radius: 20px;
        }

        .display-profiles {


        }




    </style>

</head>

<body>


    <div class="background_box">

        <div class = "window">
            <h1 class = "title"> Create Your Account </h1>
        </div>

        <form action="BackEnd_Account.php" method="POST"> <!--Name, Age, Height, Weight, Email, Password, Submit Button-->

            <!-- <div class = "window">
                <div class = "window1">
                    <p class = "info-text">What should we call you?</p>
                </div>
                <div class = "window1">
                    <p class = "info-text" >How old are you?</p>
                </div>
            </div> -->

            <div class = "window">
                <div class = "window1">
                    <p class = "info-text">What should we call you?</p>
                    
                    <input type = "text" placeholder="Name" class = "input-fields" required name="name">
                </div>

                <div class = "window1">
                    <p class = "info-text" >How old are you?</p>
                    <input type = "number" min="1" max="100" placeholder="Age" class = "input-fields" required name="age"> 
                </div>
            </div>

            <div class = "window">
                <div class = "window1">
                    <!--Weight Should Be Entered in Pounds!-->
                    <p class = "info-text">How much do you weigh?</p>
                    <input type = "number" min="1" placeholder="Weight (In Pounds)" class = "input-fields" required name="weight"> 
                </div>
            </div>

            <div class = "window">
                
                <div class = "window1">
                    <p class = "info-text">How tall are you?</p>
                    <div class = "window">
                        <input type = "number"  min="1" placeholder="Feet" class = "input-fields" required name="feet"> 
                        <input type = "number"  min="0" placeholder="Inches" class = "input-fields" required name="inches"> 
                    </div>
                </div>
            </div>



            <div class = "window">
                <div class = "window1">
                    <p class = "info-text">Enter your email and password:</p>
                    <div class = "window">
                        <input type = "text" placeholder="Enter Email" class = "input-fields" required name="email"> 
                        <input type = "text" placeholder="Enter Password" class = "input-fields" required name="password"> 
                    </div>
                </div>
            </div>


            <br>
            <div class = "window">
                <input type = "Submit" class = "submit">
            </div>
        </form>

    </div>


        <div action="BackEnd_Account.php" method="GET">
            <h2 class = "profile-title">Other Profiles Like Yours:</h2>
            <div id="profileData"></div>

        </div>




    <script>


    function getProfileData() {
        fetch('BackEnd_Account.php', {
            method: 'GET',
        })
        .then(response => response.json()) // Parse JSON from the response
        .then(data => {
            const profileDataDiv = document.getElementById('profileData');

            // Check if there is any data returned
            if (data.length > 0) {
                data.forEach(profile => {
                    const profileEntry = document.createElement('div');
                    profileEntry.innerHTML = `
                        <div class = "display-profiles">
                            <div class = "other-profiles">
                                <p>Name: ${profile.Name}</p>
                                <p>Age: ${profile.Age}</p>
                                <p>Weight: ${profile.Weight} lbs</p>
                                <p>Height: ${profile['Height (ft)']} ft ${profile['Height (in)']} in</p>
                                <p>Email: ${profile.Email}</p>
                            </div>
                        </div>
                    `;
                    profileDataDiv.appendChild(profileEntry);
                });
            } else {
                profileDataDiv.innerHTML = '<p>No profile data found.</p>';
            }
        })
        .catch(error => console.error('Error fetching data:', error));
    }

    // Call the function to fetch data on page load
    window.onload = getProfileData;
    </script>


</body>
</html>