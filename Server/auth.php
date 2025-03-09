<?php
session_start();
include("./connection.php");

if (isset($_POST['login-btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // For debugging purposes
    echo "Email received: " . htmlspecialchars($email) . "<br>";
    echo "Password received: " . htmlspecialchars($password) . "<br>";

    // Database query code with role check
    $res1 = mysqLi_query($conn, "SELECT * FROM users WHERE email='$email' && password='$password'");

    if ($res1 && mysqli_num_rows($res1) > 0) {
        $user = mysqli_fetch_assoc($res1);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['user_img'] = $user['user_pp'];
        $_SESSION['uemail'] = $email;
        $_SESSION['phone'] = $user['phone'];
        $_SESSION['role'] = $user['role'];

        // Check if user is admin
        if ($user['role'] === 'admin') {
            echo "admin"; // This will be handled by JavaScript to redirect to admin panel
        } else {
            echo "success"; // Regular user login success
        }
    } else {
        echo "error"; // This will be checked by the JavaScript on login page
    }
}
// Handle Registration
else if (isset($_POST['register-btn'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $role = 'user'; // Set default role as user

    // Check if user already exists
    $check_user = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($check_user) > 0) {
        echo "exists";
    } else {
        // Insert new user with role
        $insert_query = "INSERT INTO users (name, email, phone, password, role) VALUES ('$fullname', '$email', '$phone', '$password', '$role')";

        if (mysqli_query($conn, $insert_query)) {
            // Get the newly created user's ID
            $new_user_id = mysqli_insert_id($conn);
            
            // Store user data in session
            $_SESSION['user_id'] = $new_user_id;
            $_SESSION['name'] = $fullname;
            $_SESSION['uemail'] = $email;
            $_SESSION['phone'] = $phone;
            $_SESSION['role'] = $role;
            echo "success";
        } else {
            echo "error";
        }
    }
} else {
    echo "error";
}



// $api = new Api($key_id, $secret);

// $$api->order->create(array('receipt' => '123', 'amount' => 100, 'currency' => 'INR', 'notes'=> array('key1'=> 'value3','key2'=> 'value2')));


?>