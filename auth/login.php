<?php
session_start();
include("../Server/connection.php")
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login page</title>
    <link rel="stylesheet" href="loginstyle.css">
    <script src="https://kit.fontawesome.com/fe29f9dc19.js" crossorigin="anonymous"></script>
    <style>
        .error-message {
            color:rgb(255, 255, 255);
            background-color: rgba(255, 51, 51, 0.31);
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            text-align: center;
            display: none;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <form id="loginForm" onsubmit="handleSubmit(event)">
            <h1>Login</h1>

            <div class="error-message" id="errorMessage"></div>

            <div class="input-box">
                <input type="text" name="email" id="email" placeholder="Username" required autocomplete="off">
                <i class="fa-solid fa-user"></i>
            </div>

            <div class="input-box">
                <input type="password" name="password" id="password" placeholder="password" required autocomplete="off">
                <i class="fa-solid fa-lock"></i>
            </div>

            <div class="remember-forget">
                <label><input type="checkbox" id="rememberMe">Remember Me</label>
                <a href="#">forgot Password</a>
            </div>

            <button type="submit" name="login-btn" class="btn">login</button>

            <div class="register-link">
                <p>Dont have an account? <a href="register.php">Register</a></p>
            </div>
        </form>
    </div>

    <script>
        // Function to handle form submission
        function handleSubmit(event) {
            event.preventDefault();
            handleRememberMe();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const errorMessage = document.getElementById('errorMessage');

            // Create form data
            const formData = new FormData();
            formData.append('email', email);
            formData.append('password', password);
            formData.append('login-btn', 'true');

            // Send AJAX request
            fetch('../Server/auth.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.includes('success')) {
                    // Redirect on success
                    window.location.href = '../index.php';
                } else {
                    // Show error message
                    errorMessage.style.display = 'block';
                    errorMessage.textContent = 'Incorrect Email or Password. Please try again.';
                }
            })
            .catch(error => {
                errorMessage.style.display = 'block';
                errorMessage.textContent = 'An error occurred. Please try again.';
            });
        }

        // Function to handle remember me functionality
        function handleRememberMe() {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const rememberMe = document.getElementById('rememberMe').checked;

            if (rememberMe) {
                localStorage.setItem('rememberedEmail', email);
                localStorage.setItem('rememberedPassword', password);
                localStorage.setItem('rememberMe', 'true');
            } else {
                localStorage.removeItem('rememberedEmail');
                localStorage.removeItem('rememberedPassword');
                localStorage.removeItem('rememberMe');
            }
        }

        // Function to check and fill saved credentials on page load
        window.onload = function() {
            const rememberedEmail = localStorage.getItem('rememberedEmail');
            const rememberedPassword = localStorage.getItem('rememberedPassword');
            const rememberMeStatus = localStorage.getItem('rememberMe');

            if (rememberMeStatus === 'true' && rememberedEmail && rememberedPassword) {
                document.getElementById('email').value = rememberedEmail;
                document.getElementById('password').value = rememberedPassword;
                document.getElementById('rememberMe').checked = true;
            }
        };
    </script>

</body>


</html>