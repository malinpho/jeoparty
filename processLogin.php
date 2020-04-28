<?php
session_start();
include('functions.php');

$conn = getDB();

//initialize variables
$username = "";
$password = "";

$error = null;

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  //check if username exists
  $sql_user = "SELECT * FROM users WHERE username = '$username'";
  $ans_user = runQuery($conn, $sql_user);

  if (mysqli_num_rows($ans_user) == 0) {
    $error = "Username does not exist!";
  } else {
    //check if password is correct
    $result = mysqli_fetch_array($ans_user);

    if (password_verify($_POST['password'], $result['password'])) {
      session_start();
      $_SESSION['username'] = $username;
      // redirect
      header("Location: menu.php");
    } else {
      $error = "Username and password is invalid!";
    }
  }
}

?>
