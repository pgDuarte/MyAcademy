<?php

	$email= $_POST['email'];

	$dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb', 'root');
	$result = $dbh->query("SELECT idusers FROM users WHERE email = '" . $email . "'");

	$rows = $result->rowCount();

	if ($rows != 0) 
	{
		$res = $result->fetch()['idusers'];
		echo json_encode($res);
	}
	else {
		echo json_encode('-1');
	}

?>