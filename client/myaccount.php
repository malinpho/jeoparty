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
   <link href="css/myaccount.css" rel="stylesheet">
   <link href="css/slickButton.css" rel="stylesheet">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" rel="stylesheet">

</head>
<body>
  <h1> My Account </h1>

	<div class="backImg">
		<div class="profile">
      <div class="leftsection">
  			<img src="images\test.png" class="profileImg"> <!-- use php to get image -->
  			<div class="profileText">
  				<h2><?php echo strtoupper($user['name']); ?> </h2> <!-- use php to get name -->
  				<h3> <?php echo $user['countryName']; ?> </h3> <!-- use php to get country -->
        </div>
        <button class="slickButton" id="loginButton" onclick="window.location.href = 'menu.html';" >Main Menu</button>
      </div>

      <div class="rightsection">
				<form id="accountForm" action="#">
					<table class="inputTable">
						<tr>
							<td>
								<label for="country" style="font-weight: bold;" >New Country</label><br>
								<input id="country" type="text" name="country" placeholder="type country">
							</td>
						</tr>
						<tr>
							<td>
								<label for="oldpassword" style="font-weight: bold;">Old Password</label><br>
								<input id="oldpassword" type="text" name="oldpassword" placeholder="Old Password">
							</td>
						</tr>
						<tr>
							<td>
								<label for="password" style="font-weight: bold;">New Password</label><br>
								<input id="password" type="text" name="password" placeholder="at least 6 characters">
							</td>
						</tr>
					</table>
					<table class="inputTable">
					<tr>
						<td class="saveButton">
							<button class="slickButton" id="loginButton" type="submit">Save changes</button>
						</td>
					</tr>
				</table>
				</form>
      </div>

		</div>
	</div>


</body>
</html>
