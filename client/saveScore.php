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

    // calculate statistics for user
    $maxScore = $score;
    $avgScore = 0;
    $totalGames = 0;
    $totalScore = 0;

    $sqlstmt = "SELECT score FROM scores WHERE userID = '$userId'";
    $result = runQuery($conn, $sqlstmt);
    while ($row = mysqli_fetch_array($result)){
        $totalGames = $totalGames + 1;
        $totalScore = $totalScore + $row[0];
        if($row[0] > $maxScore){
            $maxScore = $row[0];
        }
    }
    $avgScore = $totalScore/$totalGames;
    //update users table here
    $sqlstmt = "UPDATE users SET highestScore = ?, gamesPlayed = ?, averageScore = ? WHERE userID = ?";
    $stmtinsert = $conn->prepare($sqlstmt);
    $stmtinsert->bind_param("iiii", $maxScore, $totalGames, $avgScore, $userId);
    $stmtinsert->execute();
    $stmtinsert->close();
}
?>