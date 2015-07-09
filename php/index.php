<?php

	$func= $_POST['func'];  

	switch ($func) {
	    case 0:
	        t_sorta();
	        break;
	    case 1:
	        t_sortt();
	        break;
	    case 2:
	        a_sorta();
	        break;
	    case 3:
	    	a_sortt();
	    	break;
	    case 4:
	    	c_sorta();
	    	break;
	    case 5:
	    	m_sorta();
	    	break;
	    case 6:
	    	m_sortt();
	    	break;
	    case 7:
	    	p_sorta();
	    	break;
	    case 8:
	    	p_sortt();
	    	break;
	    case 9:
	    	destroyer();
	    	break;
	    case 10:
	    	kw_search();
	    	break;

	}

	function destroyer() {
		session_start();
		session_destroy();
	}


	


	function m_sorta(){

		$j = 0;
		$priv= $_POST['priv'];  
		
		$dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb', 'root');
		if ($priv == 0) {
			$result = $dbh->query("SELECT publications.type, publications.title, publications.year, publications.idusers, deliverables.url FROM publications, deliverables WHERE publications.private = '0' AND publications.idpublication = deliverables.idpublication AND publications.type = 'msc' ORDER BY title");
		}else{
			$result = $dbh->query("SELECT publications.type, publications.title, publications.year, publications.idusers, deliverables.url FROM publications, deliverables WHERE publications.idpublication = deliverables.idpublication AND publications.type = 'msc' ORDER BY title");
		}
		


		$rows = $result->rowCount();

		if ($rows != 0) 
		{
			$res = $result->fetchAll();
		}
		else {
			echo 1;
		}

		for ($i=0; $i < $rows; $i++) { 
			$types[$j] = $res[$i][0];
			$titles[$j] = $res[$i][1];
			$years[$j] = $res[$i][2];
			$ids[$j] = $res[$i][3];
			$purls[$j] = $res[$i][4];
			$j++;
		}

		$users = split(":", udatabyID($ids));
		$names = json_decode($users[0]);
		$emails = json_decode($users[1]);
		$urls = json_decode($users[2]);
		
		echo json_encode(json_encode($titles) . ";" . json_encode($years) . ";" . json_encode($types) . ";" . json_encode($names) 
			. ";" . json_encode($urls) . ";" . json_encode($emails) . ";" . json_encode($purls));
	}

	function p_sorta(){

		$j = 0;
		$priv= $_POST['priv'];
		
		$dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb', 'root');
		if($priv == 0) {
			$result = $dbh->query("SELECT publications.type, publications.title, publications.year, publications.idusers, deliverables.url FROM publications, deliverables WHERE publications.private = '0' AND publications.idpublication = deliverables.idpublication AND publications.type= 'phd' ORDER BY title");
		}else{
			$result = $dbh->query("SELECT publications.type, publications.title, publications.year, publications.idusers, deliverables.url FROM publications, deliverables WHERE publications.idpublication = deliverables.idpublication AND publications.type= 'phd' ORDER BY title");			
		}

		$rows = $result->rowCount();

		if ($rows != 0) 
		{
			$res = $result->fetchAll();
		}
		else {
			echo 1;
		}

		for ($i=0; $i < $rows; $i++) { 
			$types[$j] = $res[$i][0];
			$titles[$j] = $res[$i][1];
			$years[$j] = $res[$i][2];
			$ids[$j] = $res[$i][3];
			$purls[$j] = $res[$i][4];
			$j++;
		}

		$users = split(":", udatabyID($ids));
		$names = json_decode($users[0]);
		$emails = json_decode($users[1]);
		$urls = json_decode($users[2]);
		
		echo json_encode(json_encode($titles) . ";" . json_encode($years) . ";" . json_encode($types) . ";" . json_encode($names) 
			. ";" . json_encode($urls) . ";" . json_encode($emails) . ";" . json_encode($purls));
	}





	function t_sorta(){

		$j = 0;
		$priv= $_POST['priv'];  

		
		$dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb', 'root');
		if ($priv == 0) {
			$result = $dbh->query("SELECT publications.type, publications.title, publications.year, publications.idusers, deliverables.url FROM publications, deliverables WHERE publications.private = '0' AND publications.idpublication = deliverables.idpublication ORDER BY title");
		}else{
			$result = $dbh->query("SELECT publications.type, publications.title, publications.year, publications.idusers, deliverables.url FROM publications, deliverables WHERE publications.idpublication = deliverables.idpublication ORDER BY title");
		}
		


		$rows = $result->rowCount();

		if ($rows != 0) 
		{
			$res = $result->fetchAll();
		}
		else {
			echo 1;
		}

		for ($i=0; $i < $rows; $i++) { 
			$types[$j] = $res[$i][0];
			$titles[$j] = $res[$i][1];
			$years[$j] = $res[$i][2];
			$ids[$j] = $res[$i][3];
			$purls[$j] = $res[$i][4];
			$j++;
		}

		$users = split(":", udatabyID($ids));
		$names = json_decode($users[0]);
		$emails = json_decode($users[1]);
		$urls = json_decode($users[2]);
		
		echo json_encode(json_encode($titles) . ";" . json_encode($years) . ";" . json_encode($types) . ";" . json_encode($names) 
			. ";" . json_encode($urls) . ";" . json_encode($emails) . ";" . json_encode($purls));
	}

	function m_sortt(){

		$j = 0;
		$priv= $_POST['priv'];
		
		$dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb', 'root');
		if ($priv == 0) {
			$result = $dbh->query("SELECT publications.type, publications.title, publications.year, publications.idusers, deliverables.url FROM publications, deliverables WHERE publications.private = '0' AND publications.idpublication = deliverables.idpublication AND publications.type = 'msc' ORDER BY publications.year DESC");
		}else{
			$result = $dbh->query("SELECT publications.type, publications.title, publications.year, publications.idusers, deliverables.url FROM publications, deliverables WHERE publications.idpublication = deliverables.idpublication AND publications.type = 'msc' ORDER BY publications.year DESC");
		}

	


		$rows = $result->rowCount();

		if ($rows != 0) 
		{
			$res = $result->fetchAll();
		}
		else {
			echo 1;
		}

		for ($i=0; $i < $rows; $i++) { 
			$types[$j] = $res[$i][0];
			$titles[$j] = $res[$i][1];
			$years[$j] = $res[$i][2];
			$ids[$j] = $res[$i][3];
			$purls[$j] = $res[$i][4];
			$j++;
		}

		$users = split(":", udatabyID($ids));
		$names = json_decode($users[0]);
		$emails = json_decode($users[1]);
		$urls = json_decode($users[2]);
		
		echo json_encode(json_encode($titles) . ";" . json_encode($years) . ";" . json_encode($types) . ";" . json_encode($names) 
			. ";" . json_encode($urls) . ";" . json_encode($emails) . ";" . json_encode($purls));
	}

	function p_sortt(){

		$j = 0;
		$priv= $_POST['priv'];
		
		$dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb', 'root');
		if ($priv == 0) {
			$result = $dbh->query("SELECT publications.type, publications.title, publications.year, publications.idusers, deliverables.url FROM publications, deliverables WHERE publications.private = '0' AND publications.idpublication = deliverables.idpublication AND publications.type = 'phd' ORDER BY publications.year DESC");
		}else{
			$result = $dbh->query("SELECT publications.type, publications.title, publications.year, publications.idusers, deliverables.url FROM publications, deliverables WHERE publications.idpublication = deliverables.idpublication AND publications.type = 'phd' ORDER BY publications.year DESC");
		}
		


		$rows = $result->rowCount();

		if ($rows != 0) 
		{
			$res = $result->fetchAll();
		}
		else {
			echo 1;
		}

		for ($i=0; $i < $rows; $i++) { 
			$types[$j] = $res[$i][0];
			$titles[$j] = $res[$i][1];
			$years[$j] = $res[$i][2];
			$ids[$j] = $res[$i][3];
			$purls[$j] = $res[$i][4];
			$j++;
		}

		$users = split(":", udatabyID($ids));
		$names = json_decode($users[0]);
		$emails = json_decode($users[1]);
		$urls = json_decode($users[2]);
		
		echo json_encode(json_encode($titles) . ";" . json_encode($years) . ";" . json_encode($types) . ";" . json_encode($names) 
			. ";" . json_encode($urls) . ";" . json_encode($emails) . ";" . json_encode($purls));
	}



	function t_sortt(){

		$j = 0;
		
		$priv= $_POST['priv'];  


		$dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb', 'root');

		if ($priv == 0) {
			$result = $dbh->query("SELECT publications.type, publications.title, publications.year, publications.idusers, deliverables.url FROM publications, deliverables WHERE publications.private = '0' AND publications.idpublication = deliverables.idpublication ORDER BY publications.year DESC");
		}else{
			$result = $dbh->query("SELECT publications.type, publications.title, publications.year, publications.idusers, deliverables.url FROM publications, deliverables WHERE publications.idpublication = deliverables.idpublication ORDER BY publications.year DESC");
		}
		


		$rows = $result->rowCount();

		if ($rows != 0) 
		{
			$res = $result->fetchAll();
		}
		else {
			echo 1;
		}

		for ($i=0; $i < $rows; $i++) { 
			$types[$j] = $res[$i][0];
			$titles[$j] = $res[$i][1];
			$years[$j] = $res[$i][2];
			$ids[$j] = $res[$i][3];
			$purls[$j] = $res[$i][4];
			$j++;
		}

		$users = split(":", udatabyID($ids));
		$names = json_decode($users[0]);
		$emails = json_decode($users[1]);
		$urls = json_decode($users[2]);
		
		echo json_encode(json_encode($titles) . ";" . json_encode($years) . ";" . json_encode($types) . ";" . json_encode($names) 
			. ";" . json_encode($urls) . ";" . json_encode($emails) . ";" . json_encode($purls));
	}


	//AUTHOR______________________________________

	function a_sorta(){

		$j = 0;
		
		$dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb', 'root');
		$result = $dbh->query("SELECT name, email, url FROM users ORDER BY name");

		$rows = $result->rowCount();

		if ($rows != 0) 
		{
			$res = $result->fetchAll();
		}
		else {
			echo 1;
		}

		for ($i=0; $i < $rows; $i++) { 
			$names[$j] = $res[$i][0];
			$emails[$j] = $res[$i][1];
			$urls[$j] = $res[$i][2];
			$j++;
		}

		echo json_encode(json_encode($names) . ":" . json_encode($urls) . ":" . json_encode($emails));
	}


	function a_sortt(){

		$j = 0;
		
		$dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb', 'root');
		$result = $dbh->query("SELECT name, email, url FROM users ORDER BY idusers DESC");

		$rows = $result->rowCount();

		if ($rows != 0) 
		{
			$res = $result->fetchAll();
		}
		else {
			echo 1;
		}

		for ($i=0; $i < $rows; $i++) { 
			$names[$j] = $res[$i][0];
			$emails[$j] = $res[$i][1];
			$urls[$j] = $res[$i][2];
			$j++;
		}

		echo json_encode(json_encode($names) . ":" . json_encode($urls) . ":" . json_encode($emails));
	}

	//COURSES______________________________________________

	function c_sorta(){

		$j = 0;
		$dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb', 'root');
		$result = $dbh->query("SELECT name, academicYear, courseYear, nStudents, uri, courseName, inst, idusers FROM discipline ORDER BY name");

		$rows = $result->rowCount();

		if ($rows != 0) 
		{
			$res = $result->fetchAll();
		}
		else {
			echo 1;
		}

		for ($i=0; $i < $rows; $i++) { 
			$names[$j] = $res[$i][0];
			$aYears[$j] = $res[$i][1];
			$cYears[$j] = $res[$i][2];
			$nStudents[$j] = $res[$i][3];
			$uris[$j] = $res[$i][4];
			$courses[$j] = $res[$i][5];
			$insts[$j] = $res[$i][6];
			$ids[$j] = $res[$i][7];
			$j++;
		}

		$users = split(":", udatabyID($ids));
		$unames = json_decode($users[0]);
		$emails = json_decode($users[1]);
		$urls = json_decode($users[2]);

		echo json_encode(json_encode($names) . ":" . json_encode($aYears) . ":" . json_encode($cYears) 
			. ":" . json_encode($nStudents) . ":" . json_encode($uris) . ":" . json_encode($courses) 
			. ":" . json_encode($insts) . ":" . json_encode($unames) . ":" . json_encode($emails));

	}


	function c_sortt(){

		$j = 0;
		$dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb', 'root');
		$result = $dbh->query("SELECT name, academicYear, courseYear, nStudents, uri, courseName, inst, idusers FROM discipline ORDER BY iddiscipline DESC");

		$rows = $result->rowCount();

		if ($rows != 0) 
		{
			$res = $result->fetchAll();
		}
		else {
			echo 1;
		}

		for ($i=0; $i < $rows; $i++) { 
			$names[$j] = $res[$i][0];
			$aYears[$j] = $res[$i][1];
			$cYears[$j] = $res[$i][2];
			$nStudents[$j] = $res[$i][3];
			$uris[$j] = $res[$i][4];
			$courses[$j] = $res[$i][5];
			$insts[$j] = $res[$i][6];
			$ids[$j] = $res[$i][7];
			$j++;
		}

		$users = split(":", udatabyID($ids));
		$unames = json_decode($users[0]);
		$emails = json_decode($users[1]);
		$urls = json_decode($users[2]);

		echo json_encode(json_encode($names) . ":" . json_encode($aYears) . ":" . json_encode($cYears) 
			. ":" . json_encode($nStudents) . ":" . json_encode($uris) . ":" . json_encode($courses) 
			. ":" . json_encode($insts) . ":" . json_encode($unames) . ":" . json_encode($emails));

	}



	//_______________________________________________

	function udatabyaID($array) {
		$dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb', 'root');
		$j = 0;

		for ($i=0; $i < count($array); $i++) { 
			$result = $dbh->query("SELECT name, email, url FROM users WHERE authors_idauthor = " . $array[$i]);
			$res = $result->fetch();
			$names[$j] = $res[0];
			$emails[$j] = $res[1];
			$urls[$j] = $res[2];
			$j++;
		}

		return json_encode($names) . ":" . json_encode($emails) . ":" . json_encode($urls);

	}


	function udatabyID($array) {
		$dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb', 'root');
		$j = 0;

		for ($i=0; $i < count($array); $i++) { 
			$result = $dbh->query("SELECT name, email, url FROM users WHERE idusers = " . $array[$i]);
			$res = $result->fetch();
			$names[$j] = $res[0];
			$emails[$j] = $res[1];
			$urls[$j] = $res[2];
			$j++;
		}

		return json_encode($names) . ":" . json_encode($emails) . ":" . json_encode($urls);

	}


	function kw_search(){

		$j = 0;
		$x = 0;
		$pubs = 0;
		$courses = 0;
		$code = "";
		$dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb', 'root');

		$search= $_POST['search'];
		$priv= $_POST['priv'];    

		if ($priv == 0) {
			$result = $dbh->query("SELECT publications.type, publications.title, publications.year, publications.idusers, deliverables.url FROM publications, deliverables, keywords, pubkeyword WHERE publications.private = '0' AND publications.idpublication = deliverables.idpublication AND keywords.name = '" . $search . "' AND keywords.idkeywords = pubkeyword.idkeywords AND pubkeyword.idpublication = publications.idpublication ORDER BY title");
		}else{
			$result = $dbh->query("SELECT publications.type, publications.title, publications.year, publications.idusers, deliverables.url FROM publications, deliverables, keywords, pubkeyword WHERE publications.idpublication = deliverables.idpublication AND keywords.name = '" . $search . "' AND keywords.idkeywords = pubkeyword.idkeywords AND pubkeyword.idpublication = publications.idpublication ORDER BY title");
		}
		

		$rows = $result->rowCount();

		if ($rows != 0) 
		{
			$pubs = 1;
			$res = $result->fetchAll();
			for ($i=0; $i < $rows; $i++) { 
				$types[$j] = $res[$i][0];
				$titles[$j] = $res[$i][1];
				$years[$j] = $res[$i][2];
				$ids[$j] = $res[$i][3];
				$purls[$j] = $res[$i][4];
				$j++;
			}

			$users = split(":", udatabyID($ids));
			$names = json_decode($users[0]);
			$emails = json_decode($users[1]);
			$urls = json_decode($users[2]);

			$code = json_encode($titles) . ";" . json_encode($years) . ";" . json_encode($types) . ";" . json_encode($names) 
			. ";" . json_encode($urls) . ";" . json_encode($emails) . ";" . json_encode($purls);
			
		}
		else {
			$x++;
		}

	
		$result = $dbh->query("SELECT discipline.name, discipline.academicYear, discipline.courseYear, discipline.nStudents, discipline.uri, discipline.courseName, discipline.inst, discipline.idusers FROM discipline, content, contentkeyword, keywords WHERE keywords.name = '" . $search . "' AND keywords.idkeywords = contentkeyword.idkeywords AND contentkeyword.idcontent = content.idcontent AND content.iddiscipline = discipline.iddiscipline ORDER BY name");
	
		$j = 0;
		$rows = $result->rowCount();

		if ($rows != 0) 
		{
			//disciplinas
			$courses = 1;
			$res = $result->fetchAll();
			for ($i=0; $i < $rows; $i++) { 
				$cnames[$j] = $res[$i][0];
				$caYears[$j] = $res[$i][1];
				$cYears[$j] = $res[$i][2];
				$cnStudents[$j] = $res[$i][3];
				$curis[$j] = $res[$i][4];
				$ccourses[$j] = $res[$i][5];
				$cinsts[$j] = $res[$i][6];
				$cids[$j] = $res[$i][7];
				$j++;
			}

			$cusers = split(":", udatabyID($cids));
			$cunames = json_decode($cusers[0]);
			$cemails = json_decode($cusers[1]);
			$curls = json_decode($cusers[2]);

			if ($x == 0) {
				$code = $code . "|";
			}

			$code = $code . json_encode($cnames) . ";" . json_encode($caYears) . ";" . json_encode($cYears) 
				. ";" . json_encode($cnStudents) . ";" . json_encode($curis) . ";" . json_encode($ccourses) 
				. ";" . json_encode($cinsts) . ";" . json_encode($cunames) . ";" . json_encode($cemails);


		}
		else {
			$x++;
		}

		if ($x == 2) {
			echo '1';
		}elseif($pubs == 1 && $courses == 1){
			echo("B" . json_encode($code));
		}elseif ($pubs == 1 && $courses == 0) {
			echo("P" . json_encode($code));
		}elseif ($pubs == 0 && $courses == 1) {
			echo("C" . json_encode($code));
		}
		
	}

?>