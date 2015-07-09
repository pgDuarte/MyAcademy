<?php

    header('Content-Type: text/html; charset=utf-8');

if (strcmp($_POST['type'], "insertsup")==0) {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

  //preparar queries
    $query_thesup = $dbh->prepare("INSERT INTO thesup (inst, status, type, beginyear, endyear, cosupname, cosupinst, iddocument, idusers) VALUES (:inst, :status, :type, :beginyear, :endyear, :cosupname, :cosupinst, :iddocument, :idusers)");
    $query_student = $dbh->prepare("INSERT INTO student (name, studentNumber, description, address , email, linkedin) VALUES (:name, :studentNumber, :description, :address, :email, :linkedin)");
    $query_document = $dbh->prepare("INSERT INTO document (title, idstudent, doi) VALUES (:title, :idstudent, :doi)");
    
   
    // Header
    $iduser = $_POST['idusers'];
    $inst = $_POST['inst'];
    $type = $_POST['thetype'];
    $status = $_POST['status'];
    $beginyear = $_POST['beginyear'];
    $endyear = $_POST['endyear'];
    $cosupname = $_POST['cosupname'];
    $cosupinst = $_POST['cosupinst'];
    $name = $_POST['name'];
    $number = $_POST['number'];
    $desc = $_POST['description'];    
    $address = $_POST['address'];    
    $email = $_POST['email'];    
    $linkedin = $_POST['linkedin'];
    $filetitle = $_POST['filetitle'];        
    $doi = $_POST['doi'];    
    $keywords = $_POST['keywords']; 
    $iddocument = 0;              
    
    //verify 
    $result = $dbh->query("SELECT * FROM student WHERE name = '".$name."' and studentNumber = '".$number."'");        
    if(!$result->rowCount())
    {
        //insert student
        $query_student->bindValue(":name",$name, PDO::PARAM_STR);
        $query_student->bindValue(":studentNumber",($number != "") ? $number:NULL, PDO::PARAM_STR);
        $query_student->bindValue(":description",($desc != "") ? $desc:NULL, PDO::PARAM_STR);
        $query_student->bindValue(":address",($address != "") ? $address:NULL, PDO::PARAM_STR);
        $query_student->bindValue(":email",($email != "") ? $email:NULL, PDO::PARAM_STR);
        $query_student->bindValue(":linkedin",($linkedin != "") ? $linkedin:NULL, PDO::PARAM_STR);          
        $query_student->execute();
        $idstudent = $dbh->lastInsertId();        
    }else
    {   //if exists, updates students info        
        $resultado = $result->fetchAll();        
        $idstudent = $resultado[0]['idstudent'];
        
        if($resultado[0]['studentNumber'] == NULL && $number != "")
        {
            $dbh->query("UPDATE student SET studentNumber = '".$number."' WHERE idstudent='".$idstudent."'");
        }
        if($resultado[0]['description'] == NULL && $desc != "")
        {
            $dbh->query("UPDATE student SET description = '".$desc."' WHERE idstudent='".$idstudent."'");
        }
        if($resultado[0]['address'] == NULL && $address != "")
        {
            $dbh->query("UPDATE student SET address = '".$address."' WHERE idstudent='".$idstudent."'");
        }
        if($resultado[0]['email'] == NULL && $email != "")
        {
            $dbh->query("UPDATE student SET email = '".$email."' WHERE idstudent='".$idstudent."'");
        }
        if($resultado[0]['linkedin'] == NULL && $linkedin != "")
        {
            $dbh->query("UPDATE student SET linkedin = '".$linkedin."' WHERE idstudent='".$idstudent."'");
        }                
    }
    //insert document
    
    //upload or file link?
    if($doi != "")
    {
        $query_document->bindValue(":title",$filetitle, PDO::PARAM_STR);
        $query_document->bindValue(":idstudent",$idstudent, PDO::PARAM_STR);
        $query_document->bindValue(":doi",$doi, PDO::PARAM_STR);       
        $query_document->execute();
        $iddocument = $dbh->lastInsertId();
    }   
                
    //upload document
    else if(!empty($_FILES['file']) && $_FILES['file']['error'] != UPLOAD_ERR_NO_FILE)
    {
        $fName = iconv("utf-8", 'ISO-8859-1', $_FILES["file"]["name"]);                        
                                                                                        
        $path = "thesis/".$type."/";
        
        if ($_FILES["file"]["error"] > 0)
        {
            echo "Error: " . $_FILES["file"]["error"] . "<br/>";
        }        
        if (file_exists("../".$path.$fName ))
        {
            echo $_FILES["file"]["name"] . " already exists. ";
        }
        else
        {
            if (!is_dir("../".$path)) {
                mkdir("../".$path,0777,true);
            }
            move_uploaded_file($_FILES["file"]["tmp_name"],
            "../".$path.$fName);                              
        }
        
        $ext = end(explode(".", $fName));
        //insert deliverable
        $query_document->bindValue(":title",$filetitle, PDO::PARAM_STR);
        $query_document->bindValue(":idstudent",$idstudent, PDO::PARAM_STR);
        $query_document->bindValue(":doi",$path.$_FILES["file"]["name"], PDO::PARAM_STR);       
        $query_document->execute();
        $iddocument = $dbh->lastInsertId();                   
    }
       
    //insert thesup
    $query_thesup->bindValue(":inst",$inst, PDO::PARAM_STR);
    $query_thesup->bindValue(":beginyear",$beginyear != "" ? $beginyear:NULL, PDO::PARAM_STR);   
    $query_thesup->bindValue(":endyear",$endyear != "" ? $endyear:NULL, PDO::PARAM_STR);
    $query_thesup->bindValue(":type",$type, PDO::PARAM_STR);
    $query_thesup->bindValue(":status",$status, PDO::PARAM_STR);
    $query_thesup->bindValue(":cosupname",$cosupname != "" ? $cosupname:NULL, PDO::PARAM_STR);
    $query_thesup->bindValue(":cosupinst",$cosupinst != "" ? $cosupinst:NULL, PDO::PARAM_STR);
    $query_thesup->bindValue(":iddocument",$iddocument != 0 ? $iddocument:NULL, PDO::PARAM_STR);
    $query_thesup->bindValue(":idusers",$iduser, PDO::PARAM_STR);
    $query_thesup->execute();
    $idthesup = $dbh->lastInsertId();
    
    //keywords
    if($keywords != "")
    {
        $i=0;
        $keywords = explode(',',$keywords);
        $count = count($keywords);       
        while($i<$count)
        {
            $dbh->query("INSERT INTO supkeyword (idthesup, idkeywords) VALUES ('".$idthesup."',".$keywords[$i].")");
            $i++;
        }
    }
    
    echo "success";
}
?>