<?php
include("processLogin.php");

$conn = getDB();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeoparty! - the Jeopardy Party Game</title>

   <link href="css/reset.css" rel="stylesheet">
   <link href="css/login.css" rel="stylesheet">
   <link href="css/slickButton.css" rel="stylesheet">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" rel="stylesheet">

</head>
<body>
	<div class=jeopardylogin>
		<h1>Login</h1>
		<div class="login-page">
			<div class="form">
				<form class="login-form" action="login.php" method="post">
					<input type="text" placeholder="username" name="username" value = "<?php echo $username; ?>"/>
					<input type="password" placeholder="password" name="password"/>
          <?php if (isset($error)): ?>
            <p class="errmessage"> <?php echo $error; ?> </p>
          <?php endif ?>
          <button class="slickButton" id="loginButton" type="submit" name="login" >Login</button>
          <button class="slickButton" id="slickButtonBackWhite" onclick="window.location.href = 'homepage.php'">Home</button>
				</form>

				<p class="message">Not registered? <a href="signup.php">Sign Up</a></p>
			</div>
		</div>


</body>
</html>
