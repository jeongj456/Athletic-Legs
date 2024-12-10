<?php
// This is a comment I am making right now!

// This is the name of the branch I'm making.
echo "Sprint#1/DaShawn_PHP_File_Research_#18";
echo "<br>";
echo "<br>";

// Using Variables
$language = "PHP";
$word = "Learning";

echo phpversion(), "<br>";
echo "<br>";

echo "$word $language!";
//Line Break
echo "<br>";
echo "$language $word!";

// Making Some Calculation
// Minutes, Hours, Days, Weeks, Months, Year
$seasons = 365 * 24 * 60;
echo "<br>";
echo "<br>";
echo $seasons;

echo "<br>";
// echo strlen($seasons);

$insert = ",";
$space = 3;

$insertedString = substr_replace($seasons, $insert, $space, 0);
echo $insertedString, " Minutes";

echo "<br>";
echo "<br>";

?>
