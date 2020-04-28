
<?php
include("processSignup.php");

$conn = getDB();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeoparty! - the Jeopardy Party Game</title>

   <link href="css/reset.css" rel="stylesheet">
   <link href="css/signup.css" rel="stylesheet">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" rel="stylesheet">
   <link href="css/slickButton.css" rel="stylesheet">

</head>
<body>
	<div class=jeopardysignup>
		<h1>Sign-Up</h1>
		<div class="signuppage">
			<div class="form">
				<form class="signup-form" action="signup.php" method="post">
          <div>
  					<input type="text" name="username" placeholder="username" oninvalid="this.setCustomValidity('Please enter a username')" oninput="this.setCustomValidity('')" value="<?php echo $username; ?>" required>
            <?php if (isset($user_error)): ?>
              <p><?php echo $user_error; ?></p>
            <?php endif ?>
            <input type="password" name="password" pattern = "(?=.*\d)(?=.*[a-zA-z]).{6,20}$"name="password" placeholder="password" oninvalid="this.setCustomValidity('Passwords must be between 6 and 20 characters, contain at least one number and no special characters')" oninput="this.setCustomValidity('')" required>

  					<input type="text" name="name" placeholder="name" oninvalid="this.setCustomValidity('Please enter your name')" oninput="this.setCustomValidity('')" value = "<?php echo $name; ?>" required>

  					<input type="email" name="email" placeholder="email" oninput="this.setCustomValidity('')" value = "<?php echo $email; ?>" required>
            <?php if (isset($email_error)): ?>
              <p><?php echo $email_error; ?></p>
            <?php endif ?>
            <input type="text" name="country" list="countries" placeholder="country" value = "<?php echo $country; ?>">
        		<datalist id="countries">
                <?php
                  $result = runQuery($conn, "SELECT countryName FROM countries");
                  while($row = mysqli_fetch_array($result)) {
                      echo '<option value="'.$row['countryName'].'">';
                  };
                ?>
        		</datalist>
          </div>
          <?php if (isset($success)): ?>
            <p><?php echo $success; ?> Please <a href="login.php">log in.</a></p>
          <?php endif ?>
          <button class="slickButton" type="submit" name="create" id="loginButton">Sign-up</button>

				</form>
          <button class="slickButton" id="slickButtonBackWhite" onclick="window.location.href = 'homepage.php'">Home</button>
          <p class="message">Already have an account? <a href="login.php">Log In</a></p>
			</div>

		</div>
	</div>

</body>
</html>
