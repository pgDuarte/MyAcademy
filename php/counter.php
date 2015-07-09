<?php

	$dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb', 'root');

	$result = $dbh->query("SELECT COUNT(*) AS iddeliverable FROM deliverables");

	if (($result->rowCount() != 0)) 
	{
	    $count = $result->fetch()['iddeliverable'];
	}
	else {
		echo json_encode('0');
	}

	echo json_encode($count);

?>