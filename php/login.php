<?php

//check perm cookie
if(isset($_COOKIE["myAcad_perm"])) {
        
}else{
	$user = $_POST["username"]; 
	$pass = $_POST["password"]; 
	
	$hash_pass = md5($pass);

	$dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

	$result = $dbh->query("SELECT idusers, name, profile FROM users WHERE email = \"" . $user . "\" AND password = \"" . $hash_pass . "\"");

	if (($result->rowCount() != 0)) 
	{	    

    	session_start();

		$rs = $result->fetch();
		$_SESSION['myAcad_sess'] = $rs[0] . ":" . $rs[1] . ":" . $rs[2];
			
		echo '<script>window.location.replace("../index.html");</script>';	    
	}
	else {
		echo '<script language="javascript">';
		echo 'alert("Incorrect data. Try again.");';
		echo 'window.location.replace("../login.html");';
		echo '</script>';
		
	}
}


?>