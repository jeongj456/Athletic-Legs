<form method="POST" action="">
    <label for="number1">Enter first number:</label>
    <input type="number" id="number1" name="number1" required>
    <br>
    <label for="number2">Enter second number:</label>
    <input type="number" id="number2" name="number2" required>
    <br><br>
    <input type="submit" value="Add Numbers">
</form>
<?php
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the two numbers from the form (they will only exist during the POST request)
    $a = isset($_POST['number1']) ? (int) $_POST['number1'] : 0;
    $b = isset($_POST['number2']) ? (int) $_POST['number2'] : 0;

    // Add the numbers together
    $c = $a + $b;

    // Display the result
    echo "<br>The sum of $a and $b is: $c<br>";
}
$a = 10;
$b = 10;
$c = $a + $b;

echo "<br>Hello World!<br>";
echo $c;
for ($i = 0; $i < 10; $i++) {
    echo "<br>" . $i;
}

function ThisIsAMapFunction()
{
    echo "<br>I am a function!";
    $map = array("hello" => "world!");
    echo "<br>I am made from an associative array (I'm basically a map). The expected output is world and the key is hello-> " . $map["hello"];
    echo "<img src='https://www.shutterstock.com/shutterstock/photos/2373537267/display_1500/stock-vector-jujutsu-kaisen-the-japanese-anime-character-of-gojo-satoru-october-2373537267.jpg' alt='jogo'>";
}
ThisIsAMapFunction();
?>