<?php
	session_start();
	if(isset($_SESSION["myAcad_sess"])) {
    	echo json_encode($_SESSION['myAcad_sess']);
	}else{
		echo 1;
	}    
?>