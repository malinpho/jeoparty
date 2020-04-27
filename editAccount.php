<?php

include('functions.php');

$conn = getDB();

$username = $_SESSION['username'];

if (isset($_POST['country'])) {

  //get inputted country
  $newCountry = $_POST['country'];

  //get country ID
  $result = runQuery($conn, "SELECT countryID FROM countries where countryName = '$newCountry'");

  //if a valid country was submitted
  if ($result->num_rows > 0) {
    $row = mysqli_fetch_array($result);
    $countryID = $row['countryID'];

    //update country
    $sql_country = "UPDATE users SET countryID = '$countryID' WHERE username = '$username'";
    $result = runQuery($conn, $sql_country);

    //$success = "Country updated successfully!";

  };

} elseif(isset($_POST['fileUpload'])){

  $name = $_FILES['file']['name'];
  $target_dir = "images/";
  $target_file = $target_dir . basename($_FILES["file"]["name"]);


  // Select file type
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  // Valid file extensions
  $extensions_arr = array("jpg","jpeg","png");

  // Check extension
  if(in_array($imageFileType,$extensions_arr) ){

    $name = basename($_FILES["file"]["name"], ".".$imageFileType) . $username . '.' .  $imageFileType;

    //get old file name

    $query = "SELECT * FROM users WHERE username = '$username'";

    $ans_img = runQuery($conn, $query);

    $prev_img = mysqli_fetch_array($ans_img)['imageFile'];

    if (is_null($prev_img) == FALSE) {
      // previously a file, delete it
      unlink($target_dir.$prev_img);
    }

     // Insert record
    $query = "UPDATE users SET imageFile = '$name' WHERE username = '$username'";

    $result = runQuery($conn, $query);

     // Upload file
    move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name);

  } else {

    //$success = "Invalid file type (must be .jpg, .jpeg, or .png)";

  }

}
?>
