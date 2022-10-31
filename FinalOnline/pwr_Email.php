<?php
include_once 'resource/session.php';
include_once 'resource/Database.php';

$email = isset($_POST['email']) ? trim($_POST['email']) : '';

$sql = "SELECT `id`, `email` FROM `users` WHERE `email` = :email";

//replace $pdo with $db
$statement = $db->prepare($sql);

$statement->bindValue(':email', $email);

$statement->execute();

//get result as an array
$userInfo = $statement->fetch(PDO::FETCH_ASSOC);

if(empty($userInfo)){
    echo 'That email address was not found in our system!';
    exit;
}

$userEmail = $userInfo['email'];
$userId = $userInfo['id'];

//Create a secure token for this forgot password request.
$token = openssl_random_pseudo_bytes(16);
$token = bin2hex($token);

//Insert the request information into password_reset_request table.
 
//The SQL statement.
$insertSql = "INSERT INTO password_reset_request
              (user_id, date_requested, token)
              VALUES
              (:user_id, :date_requested, :token)";


//Prepare INSERT SQL statement.
$statement = $db->prepare($insertSql);

//Execute the statement and insert the data.
$statement->execute(array(
    "user_id" => $userId,
    "date_requested" => date("Y-m-d H:i:s"),
    "token" => $token
));

//Get ID of inserted row
$passwordRequestId = $db->lastInsertId();

//Create link to the URL that will verify the
//forgot password request and allow the user to change their
//password.
$verifyScript = 'check_token.php';

//Make the link to send the user via email.
//maybe this will work if I ad localhost?
//now I will change this to the school domain https://tjitze.fc.school/
$linkToSend = "https://tjitze.fc.school/" . $verifyScript . '?uid=' . $userId . '&id=' . $passwordRequestId . '&t=' . $token;


//send email and a message to say that it has been send

//change this to send from server

//from needs to be changed? look into php.ini,
//@tjitze.fc.school
$from = "mylibrary@tjitze.fc.school";
$to = $userEmail;
$subject = "Password Reset";



//Deze link werkt maar de html in de email nog niet
//Maybe add <!DOCTYPE> and <body>?
$message = "<!DOCTYPE><html><body>Follow this link to change your password <a href=$linkToSend>Change password</a></body></html>";


//add declaration to the header <- this worked!
//A from is still needed so look into php.ini? Lets try an email from this server 
$headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: " . $from;


if(mail($to,$subject,$message, $headers)){
    echo "<p>Password reset Email has been sent, please follow the included link.</p>
    <a href='index.php'>Back to main page</a>";

    //echo "<br> <a href="index.php">Return to index</a>";
}else{
    echo "The email could not be sent.";
}


/*
if(mail()){
    echo "<p>Password reset Email has been sent, please follow the included link.</p>
    <a href='index.php'>Back to main page</a>";
}else{
    echo "The email could not be sent.";
    echo "<a href='index.php'>Back to main page</a>";
}*/


//show link for test
//echo "<a href=" . $linkToSend . ">Link to thing</a>";











?>