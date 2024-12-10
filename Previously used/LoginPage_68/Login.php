<!DOCTYPE html>
<html lang="en"></html>

<head>
    <title>Login Page</title>

    <!--Google Fonts Linking for Josefin Sans (Textfield Font)-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>

        .heading_box {
            background-color: #FAE6E6;
            border-radius: 8px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            font-family: "Josefin Sans", sans-serif;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 10;
            height: 50px;
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
        }

        /* Hamburger Menu Styles */
        .hamburger {
            cursor: pointer;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 30px; /* Adjust height as necessary */
            margin-right: 10px; /* Space between hamburger and title */
            display: flex;
            justify-content: flex-start;
        }

        .line {
            width: 25px; /* Width of the lines */
            height: 4px; /* Height of the lines */
            background-color: #000; /* Color of the lines */
            margin: 3px 0; /* Space between lines */
        }







        .background_box {
            background-color: #bfdae6;
            padding: 20px;
            margin: 145px auto;
            border-radius: 10px;
            height: 400px;
            max-width: 800px;
            width: 80%;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2);
            /* position: fixed;
            left: 50%;
            transform: translateX(-50%); */
        }

        .title {
            font-family: "Josefin Sans", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
            font-weight: 600;
            color: #006CA1;
        }

        .title2 {
            font-family: "Josefin Sans", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
            font-weight: 400;
            color: black;
            
        }

        .input-fields {
            /* IMPORTANT */
            font-family: "Josefin Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 375;
            font-style: normal;

            background-color: #D9D9D9;
            border: 1px solid black;
            border-radius: 4px;

            padding: 4px;
            margin: 4px;
            /* width: 200px; */
            height: 25px;
            width: 100%;
        }

        .forgot {
            font-family: "Josefin Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 375;
            font-style: normal;

            background-color: #006CA1;
            color: white;
            opacity: 1;

            border: 1px solid #006CA1;
            border-radius: 8px;

            /* padding: 4px; */
            margin: 4px;
            /* width: 150px; */
            height: 28px;

            width: 100%;
            max-width: 150px;
        }

        .log {
            font-family: "Josefin Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 375;
            font-style: normal;

            background-color: #18bc44;
            color: white;
            opacity: 1;

            border: 1px solid #18bc44;
            border-radius: 8px;

            /* padding: 4px; */
            margin: 4px;
            /* width: 150px; */
            height: 28px;

            width: 100%;
            /* max-width: 150px; */
        }

        .sign {
            font-family: "Josefin Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 375;
            font-style: normal;

            background-color: #000000;
            color: white;
            opacity: 1;

            border: 1px solid #000000;
            border-radius: 8px;

            /* padding: 4px; */
            margin: 4px;
            /* width: 150px; */
            height: 28px;

            width: 100%;
            /* max-width: 150px; */
        }

        img {
            width: 250px;
            height: auto;
        }

        body {
            background-color: #006CA1;
            margin: 0;
            padding: 0;
            height: 500px;
        }

        .br {
            height: 10px;
        }

        .row1c2 {
            display: flex;
            justify-content: center;
        }
        .row2c2 {
            display: flex;
            justify-content: center;
            width: 100%
        }
        .row3c2 {
            display: flex;
            justify-content: center;
            width: 100%;
        }
        .row4c2 {
            display: flex;
            /* justify-content: center; */
            justify-content: flex-start;

        }
        .row5c2 {
            display: flex;
            justify-content: center;
            /* flex-grow: 4; */
        }
        .row6c2 {
            display: flex;
            justify-content: center;
            /* flex-grow: 4; */
        }


        .row1c1 {
            display: flex;
            justify-content: center;
        }

        .row2c1 {
            display: flex;
            justify-content: center;
        }

        .column1 {
            display: flex;
            justify-content: center;
            flex-direction: column;
            flex-grow: 1;
        }

        .column2 {
            display: flex;
            justify-content: center;
            flex-direction: column;
            flex-grow: 4;
            
        }

        .box {
            display: flex;
            justify-content: space-around;
            flex-direction: row;
        }

        .welcome_box {
            display: flex;
            justify-content: center;
            flex-direction: column;
            flex-grow: 1;
        }

        .login_box {
            display: flex;
            justify-content: center;
            flex-direction: column;
            flex-grow: 4;
        }



        
        @media screen and (max-width: 768px) {

            .hamburger {
                height: 25px; /* Adjust height for mobile */
            }

            .line {
                width: 20px; /* Adjust width for mobile */
                height: 3px; /* Adjust height for mobile */
            }



            .box {
                flex-direction: column;
                align-items: center;
            }

            .background_box {
                /* margin: 100px 10px; */
                padding: 20px;
                min-height: 100vh;
                box-sizing: border-box;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                margin: 80px auto;
                /* height: 400px; */
            }

            .title {
                font-size: 2.2em; 
                text-align: center;
            }

            img {
                width: 260px; 
                height: auto;
                margin-bottom: 20px;
            }

            .input-fields, .forgot, .log, .sign {
                font-size: 1.2em; 
                padding: 10px; 
                margin: 10px 0; 
            }

            .forgot {
                font-size: 1.2em; 
                height: 40px; 
                width: 100%; 
                max-width: 180px; 
                margin: 10px 0; 
                padding: 10px; 
                border-radius: 8px; 
            }

            .log, .sign {
                font-size: 1.2em; 
                height: 40px; 
                width: 100%; 
                /* max-width: 250px;  */
                margin: 10px 0; 
                padding: 10px; 
                border-radius: 8px; 
            }

            form {
                width: 100%;
                display: flex;
                flex-direction: column;
                /* align-items: center; */
            }

            /* .heading_box {
                height: 60px; 
            } */

            .background_box {
                background-color: #006CA1;
                box-shadow: none;
            }


            /* New styles for separate boxes */
            .welcome_box {
                background-color: #bfdae6;
                padding: 20px;
                border-radius: 10px;
                width: 100%;
                margin-bottom: 30px; /* Space between boxes */
                margin-top: 10px;
                box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
                /* margin: 145px auto; */
            }

            .login_box {
                background-color: #bfdae6;
                padding: 20px;
                padding-bottom: 60px;
                border-radius: 10px;
                width: 100%;
                box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
                /* height: 500px; */
                /* margin: 145px auto; */
                /* height: 450px; */
            }

            body {
            background-color: #006CA1;
            height: 900px;
            margin: 0;
            padding: 0;
            }

            .alert {
                margin-top: 220px;
                font-size: 1.2em; /* Adjust this to control text size */
                padding: 15px;    /* Adjust padding for smaller screens */
            }

            .alert2 {
                margin-top: 220px;
                font-size: 1.2em; /* Adjust this to control text size */
                padding: 15px;    /* Adjust padding for smaller screens */
            }
            
            .closebtn {
                font-size: 1.8em; /* Adjust the close button size */
            }
        
        }


        .alert {
            padding: 25px;
            background-color: #f44336;
            color: white;
            position: absolute;  /* Makes it float on top */
            top: 190px;           /* Adjusts its position to be 20px from the top */
            left: 50%;
            transform: translateX(-50%); /* Centers the alert box horizontally */
            z-index: 1000;       /* Ensures it overlaps other elements */
            width: 50%;          /* Set a width to fit the screen */
            max-width: 600px;    /* Ensures it doesn't stretch too wide */
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); /* Adds some shadow for visibility */
            font-family: "Josefin Sans", sans-serif;
            display: flex;
            align-items: center;
        }

        .alert2 {
            padding: 20px;
            background-color: #04AA6D;
            color: white;
            position: absolute;  /* Makes it float on top */
            top: 190px;           /* Adjusts its position to be 20px from the top */
            left: 50%;
            transform: translateX(-50%); /* Centers the alert box horizontally */
            z-index: 1000;       /* Ensures it overlaps other elements */
            width: 50%;          /* Set a width to fit the screen */
            max-width: 600px;    /* Ensures it doesn't stretch too wide */
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); /* Adds some shadow for visibility */
            font-family: "Josefin Sans", sans-serif;
            display: flex;
            align-items: center;
        }

        .closebtn {
            margin-right: 15px;  /* Adjusted margin to the right */
            color: white;
            font-weight: bold;
            float: left;  /* Align the close button to the left */
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
            font-family: Arial, sans-serif;
        }

        .closebtn:hover {
            color: black;
        }


    </style>

</head>

<body>

    <div class="heading_box">
        <div class="hamburger" onclick="toggleMenu()">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>

        <div class="title_text">
            <h2 class="title2"> Athletic Legs </h2>
        </div>

    </div>

        <div class="background_box">

            <div class = "box">

            <div class="welcome_box">
                <div class = "column1">
                    
                    <div class="row1c1">
                        <h1 class="title">Welcome to</h1>
                    </div>

                    <div class="row1c1">
                        <img src="al_logo.png" alt="Athletic Legs Pending Logo">
                    </div>

                </div>
            </div>

            <div class="login_box">
                    
                <div class = "column2">

                    <div class = "br"></div>
                    <div class = "br"></div>
                    <div class = "br"></div>

                    <div class = "row1c2">
                        <h1 class = "title">Log In</h1>
                    </div>

                    <div class = "br"></div>

                <?php
                if (isset($_GET['error'])) {
                    echo '<div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>' 
                        . htmlspecialchars($_GET['error']) . 
                    '</div>';
                }
                ?>

                <?php
                if (isset($_GET['corr'])) {
                    echo '<div class="alert2">
                        <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>' 
                        . htmlspecialchars($_GET['corr']) . 
                    '</div>';
                }
                ?>


                    <form method="POST" action="Verify_Account.php"> 
                    
                        <div class = "row2c2">
                            <input type = "text" placeholder="Enter Username" class = "input-fields" required name="username">
                        </div>


                        <div class = "br"></div>


                        <div class = "row3c2">
                            <input type = "password" placeholder="Enter Password" class = "input-fields" required name="password">
                        </div>


                        <div class = "br"></div>


                        <div class = "row4c2">
                            <input type = "button" class = "forgot" value = "Forgot Password?">
                        </div>


                        <div class = "br"></div>


                        <div class = "row5c2">
                            <input type = "Submit" class = "log" value = "Log In">
                        </div>


                        <div class = "br"></div>


                        <div class = "row6c2">
                            <input type = "button" class = "sign" value = "Sign Up" onclick="redirectToSignUp()">
                        </div>

                    </form>

                    <script>

                        function redirectToSignUp() {
                            window.location.href = "../CreateAccountPage_80/CreateAccount.php";
                        }

                        function toggleMenu() {
                            // Remove existing error message if it's already displayed
                            const existingAlert = document.querySelector('.alert');
                            if (existingAlert) {
                                existingAlert.remove();
                            }

                            // Create a new div element for the error message
                            const errorDiv = document.createElement('div');
                            errorDiv.className = 'alert';  // Use the same class for styling
        
                            // Add the error message content
                            errorDiv.innerHTML = `
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                            Please Login!
                            `;

                            // Append the errorDiv to the body (or another container if needed)
                            document.body.appendChild(errorDiv);
                        }

                    </script>
                </div>

            </div>

        </div>

</body>
</html>
