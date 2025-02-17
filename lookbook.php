<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="navbar.css">
  <link rel="stylesheet" href="lookbook.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="icon" type="image/png" href="./images/boutique logo.png">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/fe29f9dc19.js" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/scrollreveal"></script>

  <title>LookBook Magazine</title>
</head>

<body>
  <?php include("./navbar.html") ?>
  <div class="flipbook-wrapper">

    <div class="flipbook">
      <div class="hard cover-page">
        Outfits Lookbook
        <small>~ Aria Boutique</small>
        <span class="instructions">
          <i class="fa-solid fa-arrow-rotate-left"></i>
          <small>Swipe or double click</small>
          <small> here to flip</small>
        </span>
      </div>
      <div class="hard"></div>
      <div>
        <small>Look At Some Amazing Outfits ❤️</small>
        <small>Gotta Catch 'Em All</small>
      </div>
      <div>
        <img src="./images/Suit.webp" alt="" />
        <small> Punjabi Suits </small>
      </div>
      <div>
        <img src="./images/Bridal.png" alt="" />
        <small> Bridal Outfits </small>
      </div>
      <div>
        <img src="./images/gown.png" alt="" />
        <small> Gowns </small>
      </div>
      <div>
        <img src="./images/kurti.png" alt="" />
        <small> Kurti Suits </small>
      </div>
      <div>
        <img src="./images/cordsets.webp" alt="" />
        <small> Cord Sets </small>
      </div>
      <div class="hard"></div>
      <div class="hard">Thank You <small>~ Aria boutique</small></div>

    </div>
  </div>

  <script src="jquery.js"></script>
  <script src="turn.js"></script>
  <script src="indexscript.js"></script>
  <script>
    $(".flipbook").turn();
  </script>
</body>

</html>