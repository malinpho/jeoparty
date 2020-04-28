<?php

include('functions.php');

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
  header("Location: login.php");
}

$conn = getDB();
$username = $_SESSION['username'];
//fetch user information
$sqlstmt = "SELECT * FROM users LEFT JOIN countries ON users.countryID = countries.countryID WHERE username = '$username' ";
$result = runQuery($conn, $sqlstmt);
$user = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Jeoparty! - the Jeopardy Party Game</title>

  <link href="css/reset.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link href="css/gamepage.css" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link href="css/slickButton.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

</head>
<body onload="getCategories()">



  <div id="myModal" class="modal">
    <div class="modal-content">
      <input type="text" id="answerInput">
    </div>
  </div>

  <div id="gameModal" class="gameModal">
    <h3 id="gameModalContent" class="game-modal-content"></h3>
  </div>

  <div id="questionPrompt" class="overlay">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <div class="overlay-content" id="question"></div><br>
    <div class="overlay-content"></div>
  </div>

  <!-- jeopardy game screen -->

  <div class="container-fluid">
    <div class="row">
      <!-- game board -->
      <div class="col-10 p-0">

        <table id ="jeoparty" class="table table-fixed">

          <!--Table head-->
            <tr>
              <th id = "thjeop" scope = "col" class="category">
                <div class="categoryContent"></div>
                <div style="display: none;" class="categoryId">1</div>
              </th>
              <th id = "thjeop" scope = "col" class="category">
                <div class="categoryContent"></div>
                <div style="display: none;" class="categoryId">1</div>
              </th>
              <th id = "thjeop" scope = "col" class="category">
                <div class="categoryContent"></div>
                <div style="display: none;" class="categoryId">1</div>
              </th>
              <th id = "thjeop" scope = "col" class="category">
                <div class="categoryContent"></div>
                <div style="display: none;" class="categoryId">1</div>
              </th>
              <th id = "thjeop" scope = "col" class="category">
                <div class="categoryContent"></div>
                <div style="display: none;" class="categoryId">1</div>
              </th>
              <th id = "thjeop" scope = "col" class="category">
                <div class="categoryContent"></div>
                <div style="display: none;" class="categoryId">1</div>
              </th>
            </tr>

            <tr>
              <td id = "tdjeop" class="questionCard">
                $200
              </td>
              <td id = "tdjeop" class="questionCard">
                $200
              </td>
              <td id = "tdjeop" class="questionCard">
                $200
              </td>
              <td id = "tdjeop" class="questionCard">
                $200
              </td>
              <td id = "tdjeop" class="questionCard">
                $200
              </td>
              <td id = "tdjeop" class="questionCard">
                $200
              </td>
            </tr>

            <tr>
              <td id = "tdjeop" class="questionCard">
                $400
              </td>
              <td id = "tdjeop" class="questionCard">
                $400
              </td>
              <td id = "tdjeop" class="questionCard">
                $400
              </td>
              <td id = "tdjeop" class="questionCard">
                $400
              </td>
              <td id = "tdjeop" class="questionCard">
                $400
              </td>
              <td id = "tdjeop" class="questionCard">
                $400
              </td>
            </tr>

            <tr>
              <td id = "tdjeop" class="questionCard">
                $600
              </td>
              <td id = "tdjeop" class="questionCard">
                $600
              </td>
              <td id = "tdjeop" class="questionCard">
                $600
              </td>
              <td id = "tdjeop" class="questionCard">
                $600
              </td>
              <td id = "tdjeop" class="questionCard">
                $600
              </td>
              <td id = "tdjeop" class="questionCard">
                $600
              </td>
            </tr>

            <tr>
              <td id = "tdjeop" class="questionCard">
                $800
              </td>
              <td id = "tdjeop" class="questionCard">
                $800
              </td>
              <td id = "tdjeop" class="questionCard">
                $800
              </td>
              <td id = "tdjeop" class="questionCard">
                $800
              </td>
              <td id = "tdjeop" class="questionCard">
                $800
              </td>
              <td id = "tdjeop" class="questionCard">
                $800
              </td>
            </tr>

            <tr>
              <td id = "tdjeop" class="questionCard">
                $1000
              </td>
              <td id = "tdjeop" class="questionCard">
                $1000
              </td>
              <td id = "tdjeop" class="questionCard">
                $1000
              </td>
              <td id = "tdjeop" class="questionCard">
                $1000
              </td>
              <td id = "tdjeop" class="questionCard">
                $1000
              </td>
              <td id = "tdjeop" class="questionCard">
                $1000
              </td>
            </tr>

        </table>
<!--Table-->

      </div>

      <!-- score board and potentially chat -->

      <div class="col-2 p-0" id="rightSide">
        <table class="table table-sm table-dark table-curved mt-2">
          <thead>
            <tr>
              <th scope="col">Username</th>
              <th scope="col">Score</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="username">  <?php echo $user['username'];
                if ($username == $user['username']) {
                  echo ' (You)';
                };
              ?></td>
              <td class="score" id="currentScore">$0</td>
            </tr>
            <!-- <tr>
              <td class="username">  </td>
              <td class="score" id="currentScore">$300</td>
            </tr> -->
          </tbody>
        </table>

        <!-- game log -->

        <div class="d-md-flex">
          <div class="overflow-auto" id="gameLog" style="width: 100%; height: 50vh;">
            <p><?php echo $user['username'];?> is playing!</p>
          </div>
        </div>
        <div class="buttons">
          <button class="slickButton" id="slickButtonBack" onclick="window.location.href = 'menu.html';"><span>Exit Without Saving Score</span></button>

        </div>

        <div class="buttons">
          <button class="slickButton" id="slickButtonBack" onclick="saveScore()" ><span>Save Score and Exit</span></button>
        </div>


      </div>
      </div>
    </div>
  </div>


	<script src="scripts/game.js"></script>
</body>
</html>
