<!DOCTYPE html>
<html>
    <head>
        <title>Signup</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    </head>
    <body>
        <h1>Signup</h1>

        <form action="signup_process.php" method="post" novalidate>
            <div class="email">
                <label for="email">Email</label>
                <input type="email" id="email" name="email">
            </div>

            <div class="username">

                <label for="name">Username</label>
                <input type="text" id="name" name="name">
            </div>

            <div class="password">

                <label for="password">Password</label>
                <input type="password" id="password" name="password">
            </div>


            <div class="password confirmation">
                <label for="password">Password Confirmation</label>
                <input type="password" id="password confirmation" name="password confirmation">
            </div>
            <button>Sign up</button>
        </form>
    </body>
</html>