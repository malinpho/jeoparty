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

function getPainting($conn, $paintingID) {

  $sql = "SELECT * FROM Paintings LEFT JOIN Artists ON Paintings.ArtistID = Artists.ArtistID LEFT JOIN Galleries ON Paintings.GalleryID = Galleries.GalleryID WHERE PaintingID = '$paintingID' ";
  $result = mysqli_query($conn, $sql) or die ("Bad Query: $sql");
  $row = mysqli_fetch_array($result);

  return $row;
}

function getFilterQuery($conn, $artist, $museum, $shape) {
  $finalQuery = "SELECT * FROM Paintings";
  $hasFilter = False;

  if(!empty($artist)){

    // get artist ID
    $artist = $_GET['artist'];
    $query = "SELECT ArtistID FROM Artists where TRIM(CONCAT(COALESCE(FirstName,''), ' ', COALESCE(LastName,''))) = '$artist'";
    $artistResult = runQuery($conn, $query);
    $row = mysqli_fetch_array($artistResult);
    $aID = $row['ArtistID'];

    // append Artist ID to query string
    $finalQuery .= " WHERE Paintings.ArtistID = '$aID'";
    $hasFilter = True;
  }

  if (!empty($museum)) {

    // get museum id
    $museum = $_GET['museum'];
    $query = "SELECT GalleryID FROM Galleries where GalleryName = '$museum'";
    $museumResult = runQuery($conn, $query);
    $row = mysqli_fetch_array($museumResult);
    $mID = $row['GalleryID'];

    // append phrase to query string
    if ($hasFilter == False) {
      $finalQuery .= " WHERE";
      $hasFilter = True;
    }
    else {
      $finalQuery .= " AND";
    };
    $finalQuery .= " GalleryID = '$mID'";
  }

  if (!empty($shape)) {

    // get shape ID
    $shape = $_GET['shape'];
    $query = "SELECT ShapeID FROM Shapes where ShapeName = '$shape'";
    $shapeResult = runQuery($conn, $query);
    $row = mysqli_fetch_array($shapeResult);
    $sID = $row['ShapeID'];

    // append phrase to query string
    if ($hasFilter == False) {
      $finalQuery .= " WHERE";
      $hasFilter = False;
    }
    else {
      $finalQuery .= " AND";
    };
    $finalQuery .= " ShapeID = '$sID'";
  }
  //append LIMIT
  $finalQuery .= " LIMIT 20";
  return $finalQuery;
}
?>
