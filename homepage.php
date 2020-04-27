<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeoparty! - the Jeopardy Party Game</title>

   <link href="css/reset.css" rel="stylesheet">
   <link href="css/slickButton.css" rel="stylesheet">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" rel="stylesheet">
   <link href="css/homepage.css" rel="stylesheet">
</head>
<body>
  <div class=jeopardytitle>
    <h1 class="animated jackInTheBox">Jeoparty!</h1>
  </div>

  <div>
    <button class="slickButton" onclick="window.location.href = 'login.php';"><span>Log In</span></button>
    <button class="slickButton" onclick="window.location.href = 'signup.php';"><span>Sign Up</span></button>
  </div>

</body>
</html>
