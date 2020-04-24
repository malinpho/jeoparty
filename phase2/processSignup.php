<?php
include('functions.php');

$conn = getDB();

//initialize variables
$username = "";
$password = "";
$name = "";
$email = "";
$country = "";

$user_error = null;
$email_error = null;

if (isset($_POST['create'])) {
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $name = $_POST['name'];
  $email = $_POST['email'];
  $country = $_POST['country'];
  $countryID = null;

  // country input not null
  if (!empty($country)) {
    $result = runQuery($conn, "SELECT countryID FROM countries where countryName = '$country'");

    //if a valid country was submitted
    if ($result->num_rows > 0) {
      $row = mysqli_fetch_array($result);
      $countryID = $row['countryID'];
    }
  }

  //check if username is valid
  $sql_user = "SELECT * FROM users WHERE username = '$username'";
  $ans_user = runQuery($conn, $sql_user);

  //check if email is valid
  $sql_email = "SELECT * FROM users WHERE email = '$email'";
  $ans_email = runQuery($conn, $sql_email);

  if (mysqli_num_rows($ans_user) > 0) {
    $user_error = "Username is already taken!";
  } elseif (mysqli_num_rows($ans_email) > 0) {
    $email_error = "E-mail is already registered!";
  } else {
    //insert user into system
    $sqlstmt = "INSERT INTO users (username, password, name, email, countryID) VALUES (?,?,?,?,?)";
    $stmtinsert = $conn->prepare($sqlstmt);
    $stmtinsert->bind_param("ssssi",$username, $password, $name, $email, $countryID);
    $stmtinsert->execute();
    $stmtinsert->close();

    $success = "Sign up successful!";
  }

}

?>
