<!DOCTYPE html>
<html lang="en"></html>

<head>
    <title>Forgot Password Page</title>

    <!--Google Fonts Linking for Josefin Sans (Textfield Font)-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>

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

        ..closebtn {
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

        .heading_box {
            background-color: #FAE6E6;
            border-radius: 8px;
            /* padding: 0px; */
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2);
            /* text-align: center; */
            width: 100%;
            font-family: "Josefin Sans", sans-serif;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 10;
            height: 50px;
            display: flex;
            justify-content: center;
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

        .sub_title {
            font-family: "Josefin Sans", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
            font-weight: 400;
            color: black;
            font-size: 1.5em;
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
            max-width: 450px;
            width: 100%;
        }

        .create {
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

            max-width: 465px;
            width: 100%;
            /* max-width: 150px; */
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

        .row1c1 {
            display: flex;
            justify-content: center;
        }

        .row1c2 {
            display: flex;
            justify-content: center;
        }

        .row2c1 {
            display: flex;
            justify-content: center;
        }

        .row3c1 {
            display: flex;
            justify-content: center;
        }

        .row4c1 {
            display: flex;
            justify-content: center;
        }

        .column1 {
            display: flex;
            justify-content: center;
            flex-direction: column;
            flex-grow: 1;
        }

        .box {
            display: flex;
            justify-content: space-around;
            flex-direction: row;
        }

        .alert {
            padding: 25px;
            background-color: #f44336;
            color: white;
            position: absolute;  /* Makes it float on top */
            top: 200px;           /* Adjusts its position to be 20px from the top */
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
            top: 200px;           /* Adjusts its position to be 20px from the top */
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
                min-height: 70vh;
                box-sizing: border-box;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                /* margin: 80px auto; */
                /* height: 400px; */
                padding-bottom: 500px;
                margin-top: 120px;
            }

            .title {
                font-size: 2.2em; 
                text-align: center;
            }

            .sub_title {
                /* font-size: 2.0em;  */
                font-size: 1.5em;
                text-align: center;
            }

            .input-fields, .create {
                font-size: 1.2em; 
                padding: 10px; 
                margin: 10px 0; 
            }

            .create {
                font-size: 1.2em; 
                height: 40px; 
                width: 100%; 
                /* max-width: 250px;  */
                margin: 10px 0; 
                padding: 10px; 
                border-radius: 8px; 
            }

            /* form {
                width: 100%;
                display: flex;
                flex-direction: column;
            } */

            /* .heading_box {
                height: 60px; 
            } */

            .background_box {
                background-color: #bfdae6;
                box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            }

            body {
            background-color: #006CA1;
            height: 650px;
            margin: 0;
            padding: 0;
            }

            .alert {
                /* margin-bottom;: 500px; */
                width: 62%;
                font-size: 1.2em; /* Adjust this to control text size */
                padding: 15px;   
            }

            .alert2 {
                /* margin-bottom;: 500px; */
                width: 60%;
                font-size: 1.2em; /* Adjust this to control text size */
                /* padding: 15px;   */
            }

            .closebtn {
                font-size: 1.8em; /* Adjust the close button size */
            }

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
      
            <div class = "column1">

                <div class = "br"></div>
                <div class = "br"></div>
                <div class = "br"></div>


                <div class = "row1c1">
                    <h1 class = "title">Reset Password</h1>
                </div>
                

                <div class = "row2c1">
                    <h1 class = "sub_title">Enter your new password</h1>
                </div>
                

                <div class = "br"></div>

                <?php
                session_start(); // Start the session to access session variables

                // Check for error messages
                // if (isset($_SESSION['error'])) {
                //     echo '<div class="alert">' . $_SESSION['error_message'] . '<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span></div>';
                //     unset($_SESSION['error_message']); // Clear the message after displaying
                // }


                if (isset($_GET['error'])) {
                    echo '<div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>' 
                        . htmlspecialchars($_GET['error']) . 
                    '</div>';
                }
                ?>


                <form action="Check_Code.php" method="POST"> 
                    
                    <div class = "br"></div>


                    <div class = "row3c1">
                        <input type = "password" placeholder="Enter One-Time Code" class = "input-fields" required name="code">
                    </div>

                    <div class = "br"></div>

                    <div class = "row2c1">
                        <input type = "password" placeholder="Enter New Password" class = "input-fields" required name="password">
                    </div>

                    <div class = "br"></div>
                    <div class = "br"></div>
                    <div class = "br"></div>
                    <!-- <div class = "br"></div> -->
                    <!-- <div class = "br"></div> -->


                    <div class = "row4c1">
                        <input type = "Submit" class = "create" value = "Reset Password">
                    </div>

                </form>

                <script>
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
                        Please Enter Your New Password!
                        `;

                        // Append the errorDiv to the body (or another container if needed)
                        document.body.appendChild(errorDiv);
                    }

                </script>

            </div>

        </div>

</body>
</html>