<?php

    header('Content-Type: text/html; charset=utf-8');
    
if (strcmp($_POST['type'], "pubsxml")==0) {
    
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    
    //preparar queries
    $query_pub = $dbh->prepare("INSERT INTO publications (idpublication, type, title, year, private, idusers) VALUES (:idpublication, :type, :title, :year, '0', :idusers)");
    $query_pubother = $dbh->prepare("INSERT INTO pubother (idpublication, name, value) VALUES (:idpublication, :name, :value)");
    $query_pubaut = $dbh->prepare("INSERT INTO pubaut (idpublication, idauthor, type) VALUES (:idpublication, :idauthor, :type)");
    $query_authors = $dbh -> prepare("INSERT INTO authors (idauthor, name) VALUES (:idauthor, :name)");
    $query_deliverables = $dbh -> prepare("INSERT INTO deliverables (type, url, description, idpublication) VALUES (:type, :url, :description, :idpublication)");

    // Header
    $iduser = $_POST['idusers'];    
    $zipname = $_FILES["zipfile"]["name"];
	$source = $_FILES["zipfile"]["tmp_name"];	
    
    //unzip file to a temp folder
    $unzip_path = "tempunzip/".$zipname;
    if(!is_dir("tempunzip/"))
    {
        mkdir("tempunzip/",0777,true);
    }
    
    
    if(move_uploaded_file($source, $unzip_path)) {
		$zip = new ZipArchive();
		$x = $zip->open($unzip_path);
		if ($x === true) {
			$zip->extractTo("temp/".$zipname); // change this to the correct site path
			$zip->close();
			unlink($unzip_path);
		}		
	} else {	
		echo "error";
		return;
	}
	
    $xml = simplexml_load_file("temp/".$zipname."/sip.xml");
    if(!$xml)
    {
        if(is_dir("temp/".$zipname))
        {
           delTree("temp/".$zipname);                     
        }        
        echo "error";
        return;
    }     
    
    if($xml->getName() != 'bibliography')
    {
        echo "error";
        return;
    }
    //insert authors and editors    
    foreach($xml as $pub)
    {
        foreach($pub->xpath('(editor|author)') as $author)
        {               
            $result = $dbh->query("SELECT * FROM authors WHERE idauthor = '".$author['id']."'");
            if(!$result->rowCount())
            {
                $query_authors->bindValue(":idauthor",$author['id'], PDO::PARAM_STR);
                $query_authors->bindValue(":name",$author, PDO::PARAM_STR);                
                $query_authors->execute();
            }
        }
    }   
    foreach($xml as $pub)
    {  
               
        $title = $pub->title;
        $type = $pub->getName();
        $year = $pub->year;        
        $idpub = $pub['id'];
        
        //verify idpub
        $result = $dbh->query("SELECT title FROM publications WHERE idpublication = '".$idpub."'");
        if(!$result->rowCount())
        {
            $query_pub->bindValue(":idpublication",$idpub, PDO::PARAM_STR);
            $query_pub->bindValue(":type",$type, PDO::PARAM_STR);
            $query_pub->bindValue(":title",$title, PDO::PARAM_STR);
            $query_pub->bindValue(":year",$year, PDO::PARAM_STR);                      
            $query_pub->bindValue(":idusers",$iduser, PDO::PARAM_STR);     
            $query_pub->execute();
            
            //insert authors and editors in pubaut
            foreach($pub->xpath('(editor|author)') as $author)
            {   
                $query_pubaut->bindValue(":idpublication",$idpub, PDO::PARAM_STR);
                $query_pubaut->bindValue(":idauthor",$author['id'], PDO::PARAM_STR);
                $query_pubaut->bindValue(":type",$author->getName(), PDO::PARAM_STR);                 
                $query_pubaut->execute(); 
            }

            foreach($pub->{'author-ref'} as $author)
            {           
                  
                $query_pubaut->bindValue(":idpublication",$idpub, PDO::PARAM_STR);
                $query_pubaut->bindValue(":idauthor",$author['authorid'], PDO::PARAM_STR);
                $query_pubaut->bindValue(":type","author", PDO::PARAM_STR);                 
                $query_pubaut->execute(); 
            }
            foreach($pub->{'editor-ref'} as $author)
            {                   
                $query_pubaut->bindValue(":idpublication",$idpub, PDO::PARAM_STR);
                $query_pubaut->bindValue(":idauthor",$author['authorid'], PDO::PARAM_STR);
                $query_pubaut->bindValue(":type","editor", PDO::PARAM_STR);                 
                $query_pubaut->execute(); 
            }
            
            //deliverables
            foreach($pub->deliverables->xpath('*') as $deliverables)
            {
                if(file_exists("temp/".$zipname."/".$deliverables['url'])){                
                    $resultado = $dbh->query("SELECT email FROM users WHERE idusers = ".$iduser);
                    $email = $resultado->fetch()['email'];
                    
                    $filename = end(explode('/',$deliverables['url']));
                    
                    $fName = iconv("utf-8", 'ISO-8859-1', $filename);                
                                                                                                          
                    $path = "users/".$email."/deliverables/".$type."/".$year."/";                  
                                               
                    if (!file_exists("../".$path.$fName))                
                    {
                        if (!is_dir("../".$path)) {
                            mkdir("../".$path,0777,true);
                        }
                        rename("temp/".$zipname."/".$deliverables['url'],"../".$path.$fName);                                                             
                    }
                    $query_deliverables->bindValue(":url",$path.$filename, PDO::PARAM_STR);
                }else
                {
                    $query_deliverables->bindValue(":url",$deliverables['url'], PDO::PARAM_STR);
                }
                
                $query_deliverables->bindValue(":type",$deliverables->getName(), PDO::PARAM_STR);                
                $query_deliverables->bindValue(":description",$deliverables, PDO::PARAM_STR);
                $query_deliverables->bindValue(":idpublication",$idpub, PDO::PARAM_STR);
                $query_deliverables->execute(); 
            }
            
            //pubothers
            foreach($pub->xpath("*[not((name(.)='editor')or(name(.)='editor-ref')or(name(.)='author')or(name(.)='author-ref')or(name(.)='year')or(name(.)='deliverables'))]") as $other)
            {
                $query_pubother->bindValue(":idpublication",$idpub, PDO::PARAM_STR);
                $query_pubother->bindValue(":name",$other->getName(), PDO::PARAM_STR);
                $query_pubother->bindValue(":value",$other, PDO::PARAM_STR);
                $query_pubother->execute();   
            }            
        }              
    }
        if(is_dir("temp/".$zipname))
        {
            delTree("temp/".$zipname);                             
        } 
        echo "success";    
}
//_________________________________________________________________________

if (strcmp($_POST['type'], "examxml")==0) {
    
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    
    //preparar queries
    $query_theexam = $dbh->prepare("INSERT INTO theexam (inst, date, ansi, type, iddocument, idusers) VALUES (:inst, :date, :ansi, :type, :iddocument, :idusers)");
    $query_student = $dbh->prepare("INSERT INTO student (name, studentNumber, description, address , email, linkedin) VALUES (:name, :studentNumber, :description, :address, :email, :linkedin)");
    $query_document = $dbh->prepare("INSERT INTO document (title, idstudent, doi) VALUES (:title, :idstudent, :doi)");

    // Header
    $iduser = $_POST['idusers'];    
    $zipname = $_FILES["zipfile"]["name"];
	$source = $_FILES["zipfile"]["tmp_name"];	
    
    //unzip file to a temp folder
    $unzip_path = "tempunzip/".$zipname;
    if(!is_dir("tempunzip/"))
    {
        mkdir("tempunzip/",0777,true);
    }
    
    
    if(move_uploaded_file($source, $unzip_path)) {
		$zip = new ZipArchive();
		$x = $zip->open($unzip_path);
		if ($x === true) {
			$zip->extractTo("temp/".$zipname); // change this to the correct site path
			$zip->close();
			unlink($unzip_path);
		}		
	} else {	
		echo "error";
		return;
	}
	
    $xml = simplexml_load_file("temp/".$zipname."/sip.xml");
    if(!$xml)
    {
        if(is_dir("temp/".$zipname))
        {
           delTree("temp/".$zipname);                     
        }        
        echo "error";
        return;
    }     
    if($xml->getName() != 'theexams')
    {
        echo "error";
        return;
    }   
    
    foreach($xml->xpath('theexam') as $exam)
    {
          
        $student = $exam->student;
        $document = $exam->document;
        $type = $exam['type'];  
        
        $name = $student->name;
        if($student->number)$number = $student->number;
        else $number=NULL;        
         
        $result = $dbh->query("SELECT idstudent FROM student WHERE name = '".$name."' and studentNumber = '".$number."'");        
        if(!$result->rowCount())
        { 
            //insert student
            $query_student->bindValue(":name",$student->name, PDO::PARAM_STR);
            $query_student->bindValue(":studentNumber",($student->number) ? $student->number:NULL, PDO::PARAM_STR);
            $query_student->bindValue(":description",($student->program->desc) ? $student->program->desc:NULL, PDO::PARAM_STR);
            $query_student->bindValue(":address",($student->program->address) ? $student->program->address:NULL, PDO::PARAM_STR);
            $query_student->bindValue(":email",($student->email) ? $student->email:NULL, PDO::PARAM_STR);
            $query_student->bindValue(":linkedin",($student->linkedin) ? $student->linkedin:NULL, PDO::PARAM_STR);          
            $query_student->execute();
            $idstudent = $dbh->lastInsertId();
        }else
        {
            $idstudent = $resultado->fetch()['idstudent'];
        }
        
        //insert document
        if($document->doi)
        {
            $result = $dbh->query("SELECT * FROM document WHERE title='".$document->title."' and idstudent='".$idstudent."'");
            if(!$result->rowCount())
            {
                if(file_exists("temp/".$zipname."/".$document->doi)){                
                    $resultado = $dbh->query("SELECT email FROM users WHERE idusers = ".$iduser);
                    $email = $resultado->fetch()['email'];
                    
                    $filename = end(explode('/',$document->doi));
                    
                    $fName = iconv("utf-8", 'ISO-8859-1', $filename);                
                                                                                                          
                    $path = "thesis/".$type."/";                  
                                               
                    if (!file_exists("../".$path.$fName))                
                    {
                        if (!is_dir("../".$path)) {
                            mkdir("../".$path,0777,true);
                        }
                        rename("temp/".$zipname."/".$document->doi,"../".$path.$fName);                                                             
                    }
                    $query_document->bindValue(":doi",$path.$filename, PDO::PARAM_STR);
                }else
                {
                    $query_document->bindValue(":doi",$document->doi, PDO::PARAM_STR);
                }
                $query_document->bindValue(":title",$document->title, PDO::PARAM_STR);
                $query_document->bindValue(":idstudent",$idstudent, PDO::PARAM_STR);
                $query_document->execute();
                $iddocument = $dbh->lastInsertId();           
            }else
                $iddocument = $result->fetch()['iddocument'];                        
        }
        else
        {
            $query_document->bindValue(":doi",NULL, PDO::PARAM_STR);
            $query_document->bindValue(":title",$document->title, PDO::PARAM_STR);
            $query_document->bindValue(":idstudent",$idstudent, PDO::PARAM_STR);
            $query_document->execute();
            $iddocument = $dbh->lastInsertId();
        }

        //insert theexam
        $query_theexam->bindValue(":inst",$exam->inst, PDO::PARAM_STR);
        $query_theexam->bindValue(":date",$exam->date, PDO::PARAM_STR);   
        $query_theexam->bindValue(":ansi",($exam->date['ansi']) ? $exam->date['ansi']:NULL, PDO::PARAM_STR);
        $query_theexam->bindValue(":type",$type, PDO::PARAM_STR);
        $query_theexam->bindValue(":iddocument",$iddocument, PDO::PARAM_STR);
        $query_theexam->bindValue(":idusers",$iduser, PDO::PARAM_STR);
        $query_theexam->execute();           
    }
    
    if(is_dir("temp/".$zipname))
    {
        delTree("temp/".$zipname);                             
    } 
    echo "success"; 
          
}
//_________________________________________________________________________

if (strcmp($_POST['type'], "supxml")==0) {
    
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    
    //preparar queries
    $query_thesup = $dbh->prepare("INSERT INTO thesup (inst, status, type, beginyear, endyear, cosupname, cosupinst, iddocument, idusers) VALUES (:inst, :status, :type, :beginyear, :endyear, :cosupname, :cosupinst, :iddocument, :idusers)");
    $query_student = $dbh->prepare("INSERT INTO student (name, studentNumber, description, address , email, linkedin) VALUES (:name, :studentNumber, :description, :address, :email, :linkedin)");
    $query_document = $dbh->prepare("INSERT INTO document (title, idstudent, doi) VALUES (:title, :idstudent, :doi)");

    // Header
    $iduser = $_POST['idusers'];
    //$iduser = 2;
    $zipname = $_FILES["zipfile"]["name"];
	$source = $_FILES["zipfile"]["tmp_name"];	
    
    //unzip file to a temp folder
    $unzip_path = "tempunzip/".$zipname;
    if(!is_dir("tempunzip/"))
    {
        mkdir("tempunzip/",0777,true);
    }
    
    
    if(move_uploaded_file($source, $unzip_path)) {
		$zip = new ZipArchive();
		$x = $zip->open($unzip_path);
		if ($x === true) {
			$zip->extractTo("temp/".$zipname); // change this to the correct site path
			$zip->close();
			unlink($unzip_path);
		}		
	} else {	
		echo "error";
		return;
	}
	
    $xml = simplexml_load_file("temp/".$zipname."/sip.xml");
    if(!$xml)
    {
        if(is_dir("temp/".$zipname))
        {
           delTree("temp/".$zipname);                     
        }        
        echo "error";
        return;
    }
    if($xml->getName() != 'thesup')
    {
        echo "error";
        return;
    } 
    
    foreach($xml->xpath('the') as $sup)
    {  
        $student = $sup->student;
        $document = $sup->document;
        $type = $sup['type'];  
        
        $name = $student->name;
        if($student->number)$number = $student->number;
        else $number=NULL;
         
        $result = $dbh->query("SELECT idstudent FROM student WHERE name = '".$name."' and studentNumber = '".$number."'");        
        if(!$result->rowCount())
        { 
            //insert student
            $query_student->bindValue(":name",$student->name, PDO::PARAM_STR);
            $query_student->bindValue(":studentNumber",($student->number) ? $student->number:NULL, PDO::PARAM_STR);
            $query_student->bindValue(":description",($student->program->desc) ? $student->program->desc:NULL, PDO::PARAM_STR);
            $query_student->bindValue(":address",($student->program->address) ? $student->program->address:NULL, PDO::PARAM_STR);
            $query_student->bindValue(":email",($student->email) ? $student->email:NULL, PDO::PARAM_STR);
            $query_student->bindValue(":linkedin",($student->linkedin) ? $student->linkedin:NULL, PDO::PARAM_STR);          
            $query_student->execute();
            $idstudent = $dbh->lastInsertId();
        }else
        {
            $idstudent = $resultado->fetch()['idstudent'];
        }
        
        //insert document
        if($document->doi)
        {
            if(file_exists("temp/".$zipname."/".$document->doi)){                
                $resultado = $dbh->query("SELECT email FROM users WHERE idusers = ".$iduser);
                $email = $resultado->fetch()['email'];
                
                $filename = end(explode('/',$document->doi));
                
                $fName = iconv("utf-8", 'ISO-8859-1', $filename);                
                                                                                                      
                $path = "thesis/".$type."/";                  
                                           
                if (!file_exists("../".$path.$fName))                
                {
                    if (!is_dir("../".$path)) {
                        mkdir("../".$path,0777,true);
                    }
                    rename("temp/".$zipname."/".$document->doi,"../".$path.$fName);                                                             
                }
                $query_document->bindValue(":doi",$path.$filename, PDO::PARAM_STR);
            }else
            {
                $query_document->bindValue(":doi",$document->doi, PDO::PARAM_STR);
            }
        }
        else
            $query_document->bindValue(":doi",NULL, PDO::PARAM_STR);
            
        $query_document->bindValue(":title",$document->title, PDO::PARAM_STR);
        $query_document->bindValue(":idstudent",$idstudent, PDO::PARAM_STR);
        $query_document->execute();
        $iddocument = $dbh->lastInsertId();
        
        //insert cosup
        
        
        //insert thesup
        $query_thesup->bindValue(":inst",$sup->inst, PDO::PARAM_STR);
        $query_thesup->bindValue(":beginyear",($sup->beginyear) ? $sup->beginyear:NULL, PDO::PARAM_STR);   
        $query_thesup->bindValue(":endyear",($sup->endyear) ? $sup->endyear:NULL, PDO::PARAM_STR);
        $query_thesup->bindValue(":type",$type, PDO::PARAM_STR);
        $query_thesup->bindValue(":status",$sup['status'], PDO::PARAM_STR);
        $query_thesup->bindValue(":cosupname",($sup->cosup->name) ? $sup->cosup->name:NULL, PDO::PARAM_STR);
        $query_thesup->bindValue(":cosupinst",($sup->cosup->inst) ? $sup->cosup->inst:NULL, PDO::PARAM_STR);
        $query_thesup->bindValue(":iddocument",$iddocument, PDO::PARAM_STR);
        $query_thesup->bindValue(":idusers",$iduser, PDO::PARAM_STR);
        $query_thesup->execute();         
    }
    
    if(is_dir("temp/".$zipname))
    {
        delTree("temp/".$zipname);                             
    } 
        echo "success"; 
}

//_________________________________________________________________________

if (strcmp($_POST['type'], "teachxml")==0) {
    
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    
    //preparar queries
    $query_disciplines = $dbh->prepare("INSERT INTO discipline (name, academicYear, courseYear, nStudents, uri, inst, courseName, idusers) 
    VALUES (:name, :academicYear, :courseYear, :nStudents, :uri, :inst, :course, :idusers)");
    $query_content = $dbh->prepare("INSERT INTO content (name, description, file, iddiscipline, idusers) 
    VALUES (:name, :description, :file, :iddiscipline, :idusers)");

    // Header
    $iduser = $_POST['idusers'];
    //$iduser = 2;
    $zipname = $_FILES["zipfile"]["name"];
	$source = $_FILES["zipfile"]["tmp_name"];	
    
    //unzip file to a temp folder
    $unzip_path = "tempunzip/".$zipname;
    if(!is_dir("tempunzip/"))
    {
        mkdir("tempunzip/",0777,true);
    }
    
    
    if(move_uploaded_file($source, $unzip_path)) {
		$zip = new ZipArchive();
		$x = $zip->open($unzip_path);
		if ($x === true) {
			$zip->extractTo("temp/".$zipname); // change this to the correct site path
			$zip->close();
			unlink($unzip_path);
		}		
	} else {	
		echo "error";
		return;
	}
	
    $xml = simplexml_load_file("temp/".$zipname."/sip.xml");
    if(!$xml)
    {
        if(is_dir("temp/".$zipname))
        {
           delTree("temp/".$zipname);                     
        }        
        echo "error";
        return;
    }
    
    if($xml->getName() != 'teaching')
    {
        echo "error";
        return;
    } 
    
    foreach($xml->xpath('teach') as $teach)
    {
        if($teach->discipline)$discipline = $teach->discipline;
        else $discipline = NULL;
        if($teach->contents)$contents = $teach->contents;
        else $contents = NULL;
        
        if($discipline != NULL)
        {
            $result = $dbh->query("SELECT * FROM discipline WHERE name = '".$discipline->name."' and academicYear = '".$discipline->academicyear."' and idusers='".$iduser."'");
            if(!$result->rowCount())
            {
                if($discipline->doi){                                
                    $query_disciplines->bindValue(":uri",$discipline->doi, PDO::PARAM_STR);
                }else
                {
                    //create dir
                    $result = $dbh->query("SELECT email FROM users WHERE idusers='".$iduser."'");
                    $email = $result->fetch()['email'];
                    $year = explode("/", $discipline->academicyear);
                    if(count($year)>1)
                    {
                        $dir = "users/".$email."/teaching/".iconv("utf-8", 'ISO-8859-1', $discipline->name)."-".$year[0]."_".$year[1]."/";
                        $uri = "users/".$email."/teaching/".$discipline->name."-".$year[0]."_".$year[1]."/";
                    }else
                    {
                        $dir = "users/".$email."/teaching/".iconv("utf-8", 'ISO-8859-1', $discipline->name)."-".$academicYear."/";
                        $uri = "users/".$email."/teaching/".$discipline->name."-".$academicYear."/";
                    }
                    
                    if(!is_dir("../".$dir))
                    {
                        mkdir("../".$dir,0777,true);
                    }
                    $query_disciplines->bindValue(":uri",$uri, PDO::PARAM_STR);
                }
                
                        
                $query_disciplines->bindValue(":name",$discipline->name, PDO::PARAM_STR);
                $query_disciplines->bindValue(":academicYear",$discipline->academicyear, PDO::PARAM_STR);
                $query_disciplines->bindValue(":courseYear",($discipline->course->year) ? $discipline->course->year:NULL, PDO::PARAM_STR);
                $query_disciplines->bindValue(":nStudents",($discipline->nstudents) ? $discipline->nstudents:NULL, PDO::PARAM_STR);            
                $query_disciplines->bindValue(":inst",($discipline->inst) ? $discipline->inst:NULL, PDO::PARAM_STR);
                $query_disciplines->bindValue(":course",($discipline->course->name) ? $discipline->course->name:NULL, PDO::PARAM_STR);
                $query_disciplines->bindValue(":idusers",$iduser, PDO::PARAM_STR);            
                $query_disciplines->execute();
                $iddiscipline = $dbh->lastInsertId();
            }else
                $iddiscipline = $result->fetch()['iddiscipline'];           
        }
        
        if($contents != NULL)
        {
            foreach($contents->xpath('content') as $content){
            
                if(file_exists("temp/".$zipname."/".$content->file))
                {
                    $filename = end(explode('/',$content->file));
                    
                    $fName = iconv("utf-8", 'ISO-8859-1', $filename);
                    
                    if($iddiscipline == NULL)
                    {
                        $resultado = $dbh->query("SELECT email FROM users WHERE idusers = ".$iduser);
                        $email = $resultado->fetch()['email'];
                        $path = "users/".$email."/teaching/others/";
                    }else
                    {
                        if($uri != NULL){$path = $uri;}
                        else if($discipline->doi)
                            $path = $discipline->doi;
                            else
                                $path = NULL;                                                 
                    }
                    if (!file_exists("../".$path.$fName))
                    {
                        if (!is_dir("../".$path)) {
                            mkdir("../".$path,0777,true);
                        }
                        rename("temp/".$zipname."/".$content->file,"../".$path.$fName);
                    }                    
                    $query_content->bindValue(":file",$path.$filename, PDO::PARAM_STR);
                }else
                    $query_content->bindValue(":file",$content->file, PDO::PARAM_STR);
                                                                   
                $query_content->bindValue(":name",$content->name, PDO::PARAM_STR);
                $query_content->bindValue(":description",($content->desc) ? $content->desc:NULL, PDO::PARAM_STR);   
                $query_content->bindValue(":iddiscipline",($iddiscipline != NULL)? $iddiscipline:NULL, PDO::PARAM_STR);
                $query_content->bindValue(":idusers",$iduser, PDO::PARAM_STR);    
                $result = $query_content->execute();
            }
        }
        $uri = NULL;
        $iddiscipline = NULL;       
    }
    
    if(is_dir("temp/".$zipname))
    {
        delTree("temp/".$zipname);                             
    } 
        echo "success"; 
}

//funçao que remove 
 function delTree($dir) { 
   $files = array_diff(scandir($dir), array('.','..')); 
    foreach ($files as $file) { 
      (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
    } 
    return rmdir($dir); 
  } 

?>