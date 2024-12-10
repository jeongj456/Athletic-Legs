<?php

    $db_server = "localhost";
    $db_name = "jjjeong_db";
    $db_user = "jjjeong";
    $db_pass = "50233699";
    $mysqli;

    try{
        //$mysqli = new mysqli($db_server, $db_user, $db_pass, $db_name);
	$mysqli = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
        echo"Connection Successful!";
        return $mysqli;
    }catch(mysqli_sql_exception){
        echo"Connection Unsuccessful :(";
    }

?>

