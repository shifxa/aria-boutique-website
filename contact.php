<?php
session_start();
// include("./connection.php")
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="./images/boutique logo.png">
    <script src="https://kit.fontawesome.com/fe29f9dc19.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://unpkg.com/scrollreveal"></script>
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="contact.css">
    <title>Contact </title>
    
    
</head>
<body>
    <!-- NAVBAR CODE STARTS HERE -->
    <?php include("./navbar.php") ?>
    <!-- NAVBAR CODE ENDS HERE -->

    <!-- CONTACT CODE STARTS HERE -->
        <div class="contact-wrapper">
            <h1>Contact Information</h1>
        
          <div class="contact-box">
            <div class="contact-items">
                <img src="https://img.icons8.com/color/48/google-maps.png" alt="Location Icon">
                <h2>Store Address</h2>
                <p>Louis Wadi  Aria Boutique Shop no 5, Thane, Maharashtra</p>
            </div>
           
               
            <div class="contact-items">
                <img src="https://img.icons8.com/color/48/whatsapp.png" alt="WhatsApp Icon">      
                <h2>WhatsApp Support</h2>
                <p>Need Assistance?Connect with us on WhatsApp at <a class="link"> +91 9321756424</a> for quick WhatsApp support</p>
            </div>
           
                
            <div class="contact-items">
                <img src="https://img.icons8.com/color/48/phone.png" alt="Call Icon">
                <h2>Call Support</h2>
                <p>Have a question? Call us at  <a class="link"> +91 9321756424</a> for immediate assistance. We're here to help!</p>
            </div>
            
                
            <div class="contact-items">
                <img src="https://img.icons8.com/color/48/gmail.png" alt="Email Icon">
                <h2>Email support</h2>
                <p>Got questions? Reach out to us via email at  <a class="link">khanshifa122004@gmail.com</a> We're here to help! </p>
            </div>
        </div>
             

        </div>

    <!-- FOOTER CODE STARTS HERE -->
    <?php include("./footer.html") ?>
    <!-- FOOTER CODE ENDS HERE -->
     
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
<script src="indexscript.js"></script>

</body>
</html>