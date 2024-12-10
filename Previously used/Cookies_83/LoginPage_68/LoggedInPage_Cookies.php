<!DOCTYPE html>
<html lang="en">

<head>
    <title>Logged In Page (Post Cookies)</title>

    <!--Google Fonts Linking for Josefin Sans (Textfield Font)-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            background-color: #006CA1;
            margin: 0;
            padding: 0;
            font-family: "Josefin Sans", sans-serif;
        }

        .rest {
            margin-top: 80px;
            padding: 20px;
            text-align: center;
        }

        .heading {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            padding-top: 10px;
        }

        .title_text {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            text-align: center;
        }

        .title {
            font-weight: 600;
            color: white;
            margin: 0;
            font-size: 1.5rem;
        }

        .title2 {
            font-weight: 400;
            color: black;
            font-size: 1.5rem;
            margin: 0;
            padding-right: 80px;;
        }

        .heading_box {
            background-color: #FAE6E6;
            border-radius: 8px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 10;
            height: 60px;
            display: flex;
            align-items: center;
            padding-left: 20px;
            padding-right: 20px;
        }

        .hamburger {
            cursor: pointer;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 30px;
            margin-right: 15px;
        }

        .line {
            width: 25px;
            height: 3px;
            background-color: #000;
            margin: 3px 0;
        }

        .timer {
            background-color: #419D78;
            color: white;
            font-size: 1.2rem;
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }

        .username {
            font-weight: 600;
            color: white; /* Consistent with the timer text color */
            font-size: 1.5rem;
            margin: 0;
        }


    </style>
</head>

<body>

    <div class="heading_box">
        <div class="hamburger">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>

        <div class="title_text">
            <h2 class="title2">Profile Page Placeholder</h2>
        </div>
    </div>

    <?php
        session_start();
        if (!isset($_COOKIE['Authentication_Token'])) {
            header("Location: Login.php?error=Your%20Token%20Has%20Expired!");
            exit();
        }
    ?>

    <div class="rest">
        <h1 class="title">Thank You For Logging In!</h1>

        <div class="heading">
            <h1 class="title">You are currently logged in as: &nbsp;</h1>
            <span class="username">
                <?php echo htmlspecialchars($_SESSION['username']); ?>
            </span>
        </div>

        <div class="timer">Time Until Your Token Expires = <span id="timer"></span></div>
    </div>

    <script>
        document.getElementById('timer').innerHTML = 05 + ":" + 01;
        startTimer();

        function startTimer() {
            var presentTime = document.getElementById('timer').innerHTML;
            var timeArray = presentTime.split(/[:]+/);
            var m = timeArray[0];
            var s = checkSecond((timeArray[1] - 1));
            if (s == 59) {
                m = m - 1;
            }
            if (m < 0) {
                return;
            }
            document.getElementById('timer').innerHTML = m + ":" + s;
            setTimeout(startTimer, 1000);
        }

        function checkSecond(sec) {
            if (sec < 10 && sec >= 0) {
                sec = "0" + sec;
            }
            if (sec < 0) {
                sec = "59";
            }
            return sec;
        }
    </script>

</body>

</html>