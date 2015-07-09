<?php 

$email = $_POST["email"]; 



$dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb', 'root');

//fetch old pass
$result = $dbh->query("SELECT password FROM users WHERE email = \"" . $email . "\"");

if (($result->rowCount() != 0)) 
{
    $old = $result->fetch()['password'];
    //set new pass
	$new = "ma" . $old;
	$new_hash = md5($new);
	$dbh->query("UPDATE users SET password=\"" . $new_hash . "\" WHERE email = \"" . $email . "\"");
	//enviar email

	$message = "This an automated message sent to you by myAcademia.\nYour password has been reset to " . $new . ".\nPlease login and change it asap.\n\nBest regards,\nmyAcademia Support";

	mail($email, '[myAcademia] Your password has been reset', $message);

}
else {
	echo '<script language="javascript">';
	echo 'alert("User does not exist!")';
	echo '</script>';
	//header("Location: login.html");
}


?>