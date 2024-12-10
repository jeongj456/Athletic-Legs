<form method="POST" action="">
    <!-- Made for the first text prompt -->
    <label for="FirstName">Enter first name:</label>

    <!-- Creates the basic box where usert can input string values-->
    <input type="string" id="FirstName" name="FirstName" required>

    <!-- New line chatacters-->
    <br>

    <!-- Made for the second text prompt -->
    <label for="LastName">Enter last name:</label>

    <!-- Creates the basic box where usert can input string values-->
    <input type="string" id="LastName" name="LastName" required>

    <br><br>
    <!-- created a single click button that will execute code -->
    <input type="submit" value="Enter First and last name to database">
</form>

<?php
//Lets seperate connecting to the data base for good practice in the future
//mysqli is a data base class that is our return value

//Creating varibles to use
$firstName = "";
$lastName  = "";

$EntryFirstName = "";
$EntryLastName = "";
function TestServer_DataBase_Connect(): mysqli{
    //This is the test servers name
    $database_name = "cse442_2024_fall_team_m_db";
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


//echo "life line testing";

//Here we are going to handle multiple varibles and work on grabing and using database information
function dataIntoDataBase(){
    global $firstName;
    global $lastName;
    $FakeID = -69;
    //DataBase open
    $DB = TestServer_DataBase_Connect();

    $firstName = isset($_POST["FirstName"]) ? $_POST["FirstName"] : "";
    $lastName = isset($_POST["LastName"]) ? $_POST["LastName"] : "";

    //echo $firstName . $lastName;

    //Adding the first name and last name
    $submitDataBase = $DB -> prepare("INSERT INTO Test_table(FirstName, LastName, ID) VALUES (?,?,?)");
    $submitDataBase -> bind_param("ssi", $firstName, $lastName, $FakeID);

    if ($submitDataBase->execute()) { //If it executes correctly then print this out
        echo "<br>The values $firstName and $lastName have added to the database<br>";
    } else {
        echo "<br> Some shit fucked up";
    }

    //Adding in the ID
    $grabDataBase = $DB -> prepare("SELECT * FROM Test_table");
    $grabDataBase -> execute();
    //Getting those results
    $DataBaseResult = $grabDataBase -> get_result();
    
    $RowNumberID = $DataBaseResult  -> num_rows;

    $submitDataBase = $DB -> prepare("UPDATE Test_table set  ID = (?) WHERE ID =-69");
    $submitDataBase -> bind_param("i", $RowNumberID);
    $submitDataBase -> execute();

    $DB ->close();
}


function dataOutDataBase(){
    global $EntryFirstName;
    global $EntryLastName;

    //DataBase open
    $DB = TestServer_DataBase_Connect();

    $grabDataBase = $DB -> prepare("SELECT * FROM Test_table ORDER BY ID DESC LIMIT 1");
    $grabDataBase -> execute();
    $DataResult = $grabDataBase -> get_result();
    $OutPut = $DataResult ->fetch_assoc();
    echo $OutPut["FirstName"]." ".$OutPut["LastName"]." ".$OutPut["ID"];
     
    $DB ->close();

}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    dataIntoDataBase();
    echo "<br><br>CONGRATS, you have entered data into your first database <br><br>In your data base you entered ";
    dataOutDataBase();
}


?>