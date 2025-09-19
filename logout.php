<?php
session_start();
session_unset();   // Clear session variables
session_destroy(); // Destroy session

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fresh Fare</title>
    <link href="img/logo.png" rel="icon">
    <style>
        body {
            font-family: 'cambria', sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        .countdown {
            font-size: 24px;
            font-weight: bold;
            color:rgb(152, 219, 125);
        }
    </style>
</head>
<body>

    <h3>You have been logged out.</h3>
    <p>Redirecting to home page in <span class="countdown" id="countdown">3</span> seconds...</p>
    <p>If not redirected, <a href="./index">click here</a>.</p>

    <script>
        let countdown = 3; // seconds
        const countdownEl = document.getElementById('countdown');

        const interval = setInterval(() => {
            countdown--;
            countdownEl.textContent = countdown;

            if (countdown <= 0) {
                clearInterval(interval);
                window.location.href = './index';
            }
        }, 1000);
    </script>

</body>
</html>
