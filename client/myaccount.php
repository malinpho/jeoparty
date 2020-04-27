<?php

include('functions.php');


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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeoparty! - My Account</title>

   <link href="css/reset.css" rel="stylesheet">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
   <link href="css/myaccount.css" rel="stylesheet">
   <link href="css/slickButton.css" rel="stylesheet">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" rel="stylesheet">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
   <link rel="stylesheet" href="http://github.hubspot.com/odometer/themes/odometer-theme-default.css" />
   <script src="http://github.hubspot.com/odometer/odometer.js"></script>




</head>

<body>
  <h1 class= "title">My Account</h1>

  <div class = "whiteBox">

    <button class="slickButton" id="loginButton" onclick="window.location.href = 'menu.html';">Main Menu</button>

    <div class="container">
      <div class ="row">
        <div class ="col-5">
          <div class="row">
            <div class="col-12">
              <img src="images\test.jpg" class="profileImg">
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-light mt-3">Upload Photo</button>
            </div>
          </div>

          <h2><?php echo $user['name']; ?> </h2>
  				<h3> <?php echo $user['countryName']; ?> </h3>
        </div>
        <div class ="col-7">
          <ul class="nav nav-tabs mb-6" id="pills-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">User Stats</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Settings</a>
            </li>
          </ul>
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
              <div class="row">
                <div class="col-12">
                  <div class="page-header mt-4">
                    <h3>Average Score</h3>
                    <h2 id="odometerAvgScore" class="odometer"> 0 </h2>
                    <script> setTimeout(function(){
                      odometerAvgScore.innerHTML = <?php echo $user['averageScore']; ?>;
                    }, 100);
                   </script>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-6">
                  <div class="page-header">
                    <h5>Highest Score</h5>
                    <h3 id="odometerHighestScore" class="odometer"> 0 </h3>
                    <script> setTimeout(function(){
                      odometerHighestScore.innerHTML = <?php echo $user['highestScore']; ?>;
                    }, 100);
                   </script>
                  </div>
                </div>
                <div class="col-6">
                  <div class="page-header">
                    <h5>Games Played</h5>
                    <h3 id="odometerGamesPlayed" class="odometer"> 0 </h3>
                    <script> setTimeout(function(){
                      odometerGamesPlayed.innerHTML = <?php echo $user['gamesPlayed']; ?>;
                    }, 100);
                   </script>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
              <form class = "changeUsername">
                <div class="page-header mt-4">
                  <h5>Change Username</h5>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <input type="text" class="form-control" placeholder="<?php echo  $user['username'] ?>">
                  </div>
                  <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-primary float-right">Change Username</button>
                  </div>
                </div>
              </form>

              <form class = "changePassword">
                <div class="page-header">
                  <h5>Change Password</h5>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <input type="password" class="form-control" id="inputEmail4" placeholder="Old Password">
                  </div>
                  <div class="form-group col-md-6">
                    <input type="password" class="form-control" id="inputPassword4" placeholder="New Password">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                  </div>
                  <div class="form-group col-md-6">
                    <input type="password" class="form-control" id="inputPassword4" placeholder="Confirm New Password">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-primary float-right">Update Password</button>
                  </div>
                </div>

              </form>
              <form class = "changeCountry">
                <div class="page-header">
                  <h5>Change Country</h5>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <input type="text" class="form-control" list="countries" placeholder="<?php echo  $user['countryName'] ?>">
                		<datalist id="countries">
                        <?php
                          $countryResult = runQuery($conn, "SELECT countryName FROM countries");
                          while($row = mysqli_fetch_array($countryResult)) {
                              echo '<option value="'.$row['countryName'].'">';
                          };
                        ?>
                		</datalist>
                  </div>
                  <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-primary float-right">Update Country</button>
                  </div>
                </div>
              </form>

              <form class = "deleteAccount">
                <div class="form-row">
                  <div class="form-group col-md-12 text-center">
                    <button type="submit" class="btn btn-danger mt-5">Delete Account</button>
                  </div>
                </div>
              </form>


            </div>
          </div>


        </div>

      </div>
    </div>

  </div>




</body>
</html>
