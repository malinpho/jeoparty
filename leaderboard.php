<?php

include('functions.php');
$conn = getDB();

$username = $_SESSION['username'];

//fetch user information
$sqlstmt = "SELECT * FROM users LEFT JOIN countries ON users.countryID = countries.countryID ORDER BY averageScore DESC LIMIT 25";

$numRank = 1

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeoparty! - the Jeopardy Party Game</title>

   <link href="css/reset.css" rel="stylesheet">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
   <link href="css/slickButton.css" rel="stylesheet">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" rel="stylesheet">
   <link href="css/leaderboard.css" rel="stylesheet">

</head>
<body>
	<div class="backImg">
		<div class="leaderboard">

      <h1>Leaderboard</h1>

      <div class = "profile">
        <button class="slickButton" id="loginButton" onclick="window.location.href = 'menu.html';">Main Menu</button>
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Rank</th>
              <th scope="col">Username</th>
              <th scope="col">Average Score</th>
              <th scope="col">Games Played</th>
              <th scope="col">Country</th>
            </tr>
          </thead>

          <tbody>

            <?php
              $result = runQuery($conn, $sqlstmt);
              while($user = mysqli_fetch_array($result)):
            ?>

            <tr>
              <th scope="row"><?php echo $numRank?></th>
              <td><?php echo $user['username'];

                if ($username == $user['username']) {
                  echo ' (You)';
                };


              ?>
              </td>
              <td><?php echo $user['averageScore']?></td>
              <td><?php echo $user['gamesPlayed']?></td>
              <td><?php echo $user['countryName']?></td>
            </tr>

            <?php
              $numRank++;
              endwhile;
            ?>


          </tbody>
        </table>
      </div>
		</div>
	</div>

</body>
</html>
