<?php 
    session_start();
    if (isset($_SESSION['username']) && !empty($_SESSION['username'])){
        header('Location: home.php');
    }
?>

<!DOCTYPE html>

<head>
    <title>ameeeda Employee Attendance System</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>
    <img class="logo" src="img/logo.jpg" alt="Logo">
    <div class="login-page">
        <div class=form>
            <form class="register-form" id="register-form" action="includes/signup.php" method="POST">
                <h1>Sign Up</h1>
                <input type="text" placeholder="従業員 ID" name="empid" required>
                <input type="text" placeholder="username" name="username" required>
                <input type="password" placeholder="password" name="password" required>
                <input type="password" placeholder="re-enter password" name="rptpassword" required>
                <button type="submit" name="signup-submit">Register</button>
                <p class="message">Already registered Employee? <a href="#" onclick="myFunction()">Login</a> </p>
            </form>

            <form class="login-form" id="login-form" action="includes/login.php" method="POST">
                <h1>Login</h1>
                <input type="text" placeholder="username" name="username" required>
                <input type="password" placeholder="password" name="password" required>
                <button type="submit" name="login-submit">Login</button>
                <p class="message">Not registered? <a href="#" onclick="myFunction()">Register</a> </p>
            </form>
        </div>
    </div>

    <script>
    $('.message a').click(function() {
        $('form').animate({
            height: "toggle"
        });
    })
    </script>
</body>

</html>