<?php
//Integer Varible
$Number1 = 10;
$Number2 = 9;
//Asigning multiple varibles
$Thing1 = $Thing2 = $Thing3 = "<br>Hello<br>";
//String Varible
$String = "T&J";
//Multiple ways to do varibles
echo "Hello World! $Number1 " . $String . "<br>";
//Basic arithmatic to display
echo "This is my arithmatic Test " . $Number1 + $Number2;
echo $Thing1 . $Thing2 . $Thing3;

function FirstFunction(){
    echo "<br> TestMy first funtion With a global varible = " . $GLOBALS['String'];
}

FirstFunction();

//Testing with associative arrays
$FirstArray = array("Name" => "Thomas Mehok", "Gym" => "Esporta", "Age" => 21);
echo "<br><br>This is my first Associative Array call => " . $FirstArray["Name"];

echo "<br><br>This is loop call on my array=> <br>";
function SecondFunction(){
    //Creating global varibles
    global $FirstArray;
    //For loop for an associative array
    foreach ($FirstArray as $x => $y){
        echo "<br>" . $x . " = " . $y;
    }
}
//Calling a function
SecondFunction();

//$SecondArray = array(FirstFuntion(), SecondFuntion());
//echo "<br><br>Proof I can call functions from an array which also prints an array => <br>" . $SecondArray[1]();
function myFunction(){
    echo "I come from a function";
}
$myarr = array("volvo","15", function(){ echo "<br><br>this is in a function in an ARRAY!!"; });
$myarr2 = array("volvo","15", "SecondFunction");


 $myarr[2]();

 echo "<br><br>I am testing calling a funtion from a string inside an array!!! => <br>";
 $myarr2[2]();

 echo "<img src='https://www.shutterstock.com/shutterstock/photos/2475756805/display_1500/stock-photo-dramatic-stormy-sky-heavy-rain-intense-lightning-bolts-moody-atmosphere-dynamic-composition-2475756805.jpg' alt='jogo'>";

 $ArrayTest1 = array(
    array("brand"=>"Ford", "model"=>"Mustang", "year"=>1964),
    array("brand"=>"bmw", "model"=>"Mustang", "year"=>1964)
 );

 echo $ArrayTest1[1]["brand"];


 

 function DataBase_Connect(): mysqli{
    //This is the test servers name
    $database_name = "tjmehok_db";
    //I belive this is the full name Matt gave us in his email
    $server_name = "localhost:3306";
    //The user name and password is how we sign into PHP admin
    $user_name   = "tjmehok";
    $password = "50407528";
    
    //This is the most important part
    //we are creating the mysqli class so it will eaisily connect everytime
    $connect = new mysqli($server_name, $user_name, $password, $database_name);

    //check the connection status
    //If the connection failed
    if($connect-> connect_error){
        die("Connection failed: " . mysqli_connect_error());
    } 
    return $connect;
    //If the connection succeded
}
 function TableDataOUT(): string{
    $DB = DataBase_Connect();

    $grabDataBase = $DB -> prepare("SELECT * FROM Workout_History ORDER BY Workout_Date");
    $grabDataBase -> execute();
    $DataResult = $grabDataBase -> get_result();
    $OutPut = $DataResult ->fetch_assoc();
    //This is going to be an array of string, Up to 10 entries with all of these sections their entries will be seperated by commas
    $ArrayOut = ["Date", "Name", "Weight", "total_reps", "total_sets"];

    $DB ->close();
    return 'hi';
}

TableDataOUT();

?>