<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register page</title>
    <link rel="stylesheet" href="registerstyle.css">
    <script src="https://kit.fontawesome.com/fe29f9dc19.js" crossorigin="anonymous"></script>
    <style>
        .error-message {
            color: #fff;
            background-color: rgba(255, 51, 51, 0.56);
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
        <form id="registerForm" onsubmit="handleSubmit(event)">
            <h1>Registration</h1>
            <div class="error-message" id="errorMessage"></div>

            <!----------------- full name ---------------->
            <div class="input-box">
                <div class="wide-input-field">
                    <input type="text" name="fullname" id="fullname" placeholder="Full name" required>
                    <i class="fa-solid fa-user"></i>
                </div>
            </div>

            <!----------------- email & phone number ---------------->
            <div class="input-box">
                <div class="input-field">
                    <input type="email" name="email" id="email" placeholder="E-mail" required>
                    <i class="fa-solid fa-envelope"></i>
                </div>

                <div class="input-field">
                    <input type="tel" name="phone" id="phone" placeholder="Phone Number" required>
                    <i class="fa-solid fa-phone"></i>
                </div>
            </div>

            <!----------------- password ---------------->
            <div class="input-box">
                <div class="input-field">
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <i class="fa-solid fa-lock"></i>
                </div>

                <div class="input-field">
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                    <i class="fa-solid fa-lock"></i>
                </div>
            </div>

            <!--------------------- checkbox & button--------------->
            <label><input type="checkbox" required>I hereby declare that the above information provided is true and correct</label>

            <button type="submit" class="btn">Register</button>
        </form>
    </div>

    <script>
        function handleSubmit(event) {
            event.preventDefault();
            
            if (!validateForm()) {
                return;
            }

            const form = event.target;
            const formData = new FormData(form);
            formData.append('register-btn', 'true');

            const errorMessage = document.getElementById('errorMessage');
            
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
                } else if (data.includes('exists')) {
                    // Show user exists error
                    errorMessage.style.display = 'block';
                    errorMessage.textContent = 'An account with this email already exists. Please login instead.';
                } else {
                    // Show general error message
                    errorMessage.style.display = 'block';
                    errorMessage.textContent = 'Registration failed. Please try again.';
                }
            })
            .catch(error => {
                errorMessage.style.display = 'block';
                errorMessage.textContent = 'An error occurred. Please try again.';
            });
        }

        function validateForm() {
            const fullname = document.getElementById('fullname').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;
            const password = document.getElementById('password').value;
            const confirm_password = document.getElementById('confirm_password').value;
            const errorMessage = document.getElementById('errorMessage');

            // Reset error message
            errorMessage.style.display = 'none';

            if (!fullname || !email || !phone || !password || !confirm_password) {
                errorMessage.textContent = 'Please fill in all fields';
                errorMessage.style.display = 'block';
                return false;
            }

            // Validate email format
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                errorMessage.textContent = 'Please enter a valid email address';
                errorMessage.style.display = 'block';
                return false;
            }

            // Validate phone number (basic validation)
            const phoneRegex = /^\d{10}$/;
            if (!phoneRegex.test(phone)) {
                errorMessage.textContent = 'Please enter a valid 10-digit phone number';
                errorMessage.style.display = 'block';
                return false;
            }

            // Validate password
            if (password.length < 6) {
                errorMessage.textContent = 'Password must be at least 6 characters long';
                errorMessage.style.display = 'block';
                return false;
            }

            if (password !== confirm_password) {
                errorMessage.textContent = 'Passwords do not match';
                errorMessage.style.display = 'block';
                return false;
            }

            return true;
        }
    </script>
</body>

</html>