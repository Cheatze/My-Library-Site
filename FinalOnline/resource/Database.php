<?php

// $host = '?';
// dbname = tjitze_mylibrary
// password = ?

//acording to teams chat
//username: tjitze
//PassWord: @yN6kW#z!qu7

//phpmy: localhost:3306

 $username = 'tjitze';
 $dsn = 'mysql:host=localhost:3306; dbname=tjitze_mylibrary';
 $password = '@yN6kW#z!qu7';
// $dbname = 'test';

/*
$username = "tjitze_mylib";

database: tjitze_database
tabel: users

//tjitze_mylibrary

$password = "Ganondorf25";

*/


try{

    $db = new PDO($dsn, $username, $password);

    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    //echo "Connected? Good.";

}catch(PDOException $ex){

    echo "Connection failed." . "<br>" . $ex->getMessage();

}


?>