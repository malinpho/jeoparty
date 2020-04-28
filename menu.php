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
   <link href="css/menu.css" rel="stylesheet">
   <link href="css/slickButton.css" rel="stylesheet">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" rel="stylesheet">
   <script type="text/javascript" src="scripts/menu.js"> if (!window.console) console = {log: function() {}}; </script>


</head>
<body onload="addEvent()">
	<div class=jeopardymenu>
		<h1>Main Menu</h1>
	</div>

	<div class="menu">
		<button class="slickButton" onclick="window.location.href = 'myaccount.php';">My Account</button>
		<button class="slickButton" id="showModal" onclick="window.location.href = 'gamepage.php';">Start Game</button>
		<button class="slickButton" onclick="window.location.href = 'leaderboard.php';">Leaderboard</button>
		<div class="logout">
			<button class="slickButton" id="slickButtonLogout" onclick="window.location.href = 'logout.php';">Logout</button>
		</div>
	</div>
</body>
</html>
