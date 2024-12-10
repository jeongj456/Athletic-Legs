<?php
#session_start();
# Connects to database
$db_server = "localhost";
$db_user = "jjjeong";
$db_pass = "50233699";
$db_name = "jjjeong_db";
$conn;


try{
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
}catch(mysqli_sql_exception){
    echo"Connection Unsuccessful :(";
}


$date = $_POST["date_consumed"];
$date2 = date("Y-m-d", strtotime($_POST["date_consumed"]));
$name = $_POST["food_name"];
$protein = $_POST["protein_content"];
$fat = $_POST["fat_content"];
$carbs = $_POST["carb_content"];

#echo "Date:" . $date . "Date2:" . $date2 . "Food:" . $name . "Protein:" . $protein . "Fat:" . $fat . "Carbs:" . $carbs;


$sql = "INSERT INTO nutrition (date, name, protein, fat, carbs) VALUES ('$date2', '$name', '$protein', '$fat', '$carbs')";
$query_run = mysqli_query($conn, $sql);

if(!$query_run){
  echo "Insertion Failed";
}
header("Location: https://se-dev.cse.buffalo.edu/CSE442/2024-Fall/jjjeong/40files/frontend.php");

exit();




/*
function getData(){
  global $conn;
  $result = $conn->query("SELECT * FROM nutrition ORDER BY id DESC");
  #while ($row = $result->fetch_assoc()) {
  #    echo "<tr><th>" . $row["id"] . "</th><th>". $row["date"] . "</th><th>" . $row["name"] . "</th><th>" . $row["protein"] . "</th><th>" . $row["fat"] . "</th><th>" . $row["carbs"]. "</th></tr>";
  #}
  return $result->fetch_all(MYSQLI_ASSOC);
}
$sq = "SELECT * FROM nutrition";
$result = $conn->query($sq);
if ($result->num_rows > 0) {
  echo"<table><tr><th>ID</th><th>Date</th><th>Name</th><th>Protein</th><th>Fat</th><th>Carbs</th></tr>";
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "<tr><th>" . $row["id"] . "</th><th>". $row["date"] . "</th><th>" . $row["name"] . "</th><th>" . $row["protein"] . "</th><th>" . $row["fat"] . "</th><th>" . $row["carbs"]. "</th></tr>";
  }
  echo "</table>";
} else {
  echo "0 results";
}
*/


?>