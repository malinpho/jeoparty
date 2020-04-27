<?php
include('functions.php');

$conn = getDB();
$username = $_SESSION['username'];
//fetch user information
$sqlstmt = "SELECT * FROM users LEFT JOIN countries ON users.countryID = countries.countryID WHERE username = '$username' ";
$result = runQuery($conn, $sqlstmt);
$user = mysqli_fetch_array($result);

if (isset($_POST['score'])){
    $score = $_POST['score'];
    $userId = $user['userID'];
    // add score to game
    $sqlstmt = "INSERT INTO scores (userID, score) VALUES (?,?)";
    $stmtinsert = $conn->prepare($sqlstmt);
    $stmtinsert->bind_param("ii", $userId, $score);
    $stmtinsert->execute();
    $stmtinsert->close();
}
?>