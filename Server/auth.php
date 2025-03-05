<?php
session_start();
include("./connection.php");

if (isset($_POST['login-btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // For debugging purposes
    echo "Email received: " . htmlspecialchars($email) . "<br>";
    echo "Password received: " . htmlspecialchars($password) . "<br>";

    // Database query code 
    $res1 = mysqLi_query($conn, "select * from users where email='$email' && password='$password'");

    if ($res1 && mysqli_num_rows($res1) > 0) {
        foreach ($res1 as $nres) {
            $_SESSION['name'] = $nres['name'];
            $_SESSION['user_img'] = $nres['user_pp'];
        }
        $_SESSION['uemail'] = $email;
        echo "success"; // This will be checked by the JavaScript on login page
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

    // Check if user already exists
    $check_user = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($check_user) > 0) {
        echo "exists";
    } else {
        // Insert new user
        $insert_query = "INSERT INTO users (name, email, phone, password) VALUES ('$fullname', '$email', '$phone', '$password')";

        if (mysqli_query($conn, $insert_query)) {
            $_SESSION['name'] = $fullname;
            $_SESSION['uemail'] = $email;
            $_SESSION['phone'] = $phone;
            echo "success";
        } else {
            echo "error";
        }
    }
} else {
    echo "error";
}



$api = new Api($key_id, $secret);

$$api->order->create(array('receipt' => '123', 'amount' => 100, 'currency' => 'INR', 'notes'=> array('key1'=> 'value3','key2'=> 'value2')));


?>