<?php
include_once('include/config.php');

function getDB() {
  $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME)
  OR die('Could not connect: '.mysqli_connect_error());
  return $conn;
}

function runQuery($db, $query) {
  $result = mysqli_query($db, $query) or die ("Bad Query: ". $mysqli -> error);
  return $result;
}
?>
