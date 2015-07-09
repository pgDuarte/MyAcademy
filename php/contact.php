<?php 

$fname = $_POST["fname"]; 
$lname = $_POST["lname"];
$email = $_POST["email"]; 
$subject = $_POST["subject"];
$message = $_POST["message"];


//build email
$final_message = 'The user ' . $fname . ' ' . $lname . ' (email: ' . $email . ") sent the following message:\n\n " . $message;

echo $final_message;

mail('acspvz@gmail.com', '[myAcademia] Support: ' . $subject, $final_message);

header("Location: login.html");


?>