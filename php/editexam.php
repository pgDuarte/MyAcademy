<?php

require_once('../nusoap/lib/nusoap.php');


//Webservice server WSDL URL address:
$wsdl = "http://localhost/site/php/webService.php?wsdl";
 
//Create client object
$client = new nusoap_client($wsdl, 'wsdl');
 
$err = $client->getError();
if ($err) {
	// Display the error
	echo '<h2>Constructor error</h2>' . $err;
	// At this point, you know the call that follows will fail
    exit();
}




    $dbh = new PDO('mysql:host=127.0.0.1;dbname=engweb;charset=utf8', 'root','' , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));




/**************************************************************************************************************************************************************************
                                                            Header    - Info about User      
**************************************************************************************************************************************************************************/



if (strcmp($_REQUEST['examinationsfunction'], "listAllExaminationsforSelect")==0) {


    $userID = $_POST['id'];          // get data
    $examinations = $client->call('listAllExaminationsByUser', array('userID'=>$userID) );
 
    $nexaminations = count($examinations);
   
    $option="";
    
    for($i=0; $i<$nexaminations; $i++)
    { 
        $option = $option."<option value='".$examinations[$i]['idtheexam']."'>".$examinations[$i]['title']."</option>";
    }

   echo $option;
}


if (strcmp($_REQUEST['examinationsfunction'], "atributtes")==0) {


    $userID = $_POST['id']; 
    $idexam = $_POST['idexam'];  
              
    $examination = $client->call('listAllExaminationatributtes', array('userID'=>$userID, 'idexam'=>$idexam) );
 
   
   
  
    
    $code = "<div class=\"row\">
                                    <div class=\"col-lg-6\">
                                        <label>Institution</label>            
                                        <input class=\"form-control\" name=\"inst\" id=\"inst\" type=\"text\" value ='".$examination['inst']."' required=''/>                                  
                                    </div>
                                </div>
                                <br/>
                                <div class=\"row\">
                                    <div class=\"col-lg-2\">
                                        <label>Degree</label>            
                                        <select class=\"form-control\" name=\"type\" id=\"type\">;";
                        if($examination['type']=='msc')
                        {
                            $code = $code."    
                                            <option value=\"msc\" selected>MSc</option>
                                            <option value=\"phd\">PhD</option> ";
                        }else
                        {
                            $code = $code."    
                                            <option value=\"msc\" >MSc</option>
                                            <option value=\"phd\" selected>PhD</option> ";
                        }
                        $code = $code."                   
                                        </select>                                                
                                    </div>
                                    
                                    <label for=\"ansiDate\">Date</label>
                                    <div class=\"form-inline\">             
                                        <div class=\"form-group\"> 
                                            <input id=\"ansiDate\" class=\"form-control\" name=\"ansiDate\" type=\"date\" placeholder=\"dd-mm-aaaa\" value = \"".$examination['ansi']."\"required=\"\"/>
                                        </div>
                                        
                                        ";
                                        
                    if(!empty($examination['date']))
                    {
                     $code= $code."<div class=\"form-group\"> 
                                            <input class=\"form-control\" name=\"date\" id=\"date\" type=\"text\" value = \"".$examination['date']."\" placeholder=\"Ex: July 2013\" />
                                        </div>";
                    }else {
                    
                    $code= $code."<div class=\"form-group\"> 
                     <input class=\"form-control\" name=\"date\" id=\"date\" type=\"text\" placeholder=\"Ex: July 2013\" />
                     </div>";
                    }
                    
                    $code= $code." </div>
                      <div class=\"col-lg-6\">             
                          </div>     
                               </div> 
                                <br/>";
                               
                                

   echo $code;
}


if (strcmp($_REQUEST['examinationsfunction'], "student")==0) {


    $userID = $_POST['id']; 
    $idexam = $_POST['idexam'];           // get data
    $student = $client->call('liststudentbyExam', array('idexam'=>$idexam ) );
 
    $nstudent = count($student);
   

    
    if($nstudent>0){
    
                          $code="
                                <div class='row'>
                                    <div class='col-lg-4'>
                                        <label for='name'>Name</label>
                                        <input id='name' name='name' class='form-control' type='text' value='".$student['name']."' required=''/>
                                    </div>
                                    <div class=\"col-lg-3\">
                                        <label for=\"number\">Number</label>";
                                        
                       if(!empty($student['studentNumber']))
                       {
                          $code=$code."<input id=\"number\" name=\"number\" class=\"form-control\" value='".$student['studentNumber']."' type=\"text\"/>";
                       }
                        else{
                            $code=$code."<input id=\"number\" name=\"number\" class=\"form-control\" type=\"text\"/>";
                            }
                            
                            $code=$code."</div></div>
                                <br/>
                                <a id=\"click\" >Click here to add more info about the student</a>
                                <br/>
                                
                                 <div id=\"program\">            
                                    <div class=\"row\">
                                        <div class=\"col-lg-4\">
                                            <label>Email</label>
                                ";
                                
                               if(!empty($student['email']))
                               {
                                  $code=$code."<input name=\"email\" id=\"email\" class=\"form-control\" value = '".$student['email']."' type=\"text\"/>";
                               }else {
                               $code=$code."<input name=\"email\" id=\"email\" class=\"form-control\" type=\"text\"/>";
                                }
                                
                                 $code=$code." </div>
                                  </div>
                                    <div class=\"row\">
                                        <div class=\"col-lg-4\">
                                            <label>Linkedin</label>";
                                            
                               if(!empty($student['linkedin']))
                               {
                                 $code=$code." <input name=\"linkedin\" id=\"linkedin\" class=\"form-control\" value='".$student['linkedin']."' type=\"text\"/>";
                                 
                               }else {
                                $code=$code." <input name=\"linkedin\" id=\"linkedin\" class=\"form-control\" type=\"text\"/>";
                                }
                                
                                $code=$code." </div>
                                    </div>
                                    
                                    <div class=\"row\">
                                        <div class=\"col-lg-7\">
                                            <label>Info about the course</label>";
                                            
                                           
                                
                                if(!empty($student['description']))
                                {
                                 $code=$code."<input name=\"description\" id=\"description\" class=\"form-control\" type=\"text\" value = '".$student['description']."' placeholder=\"ex: MIECOM - Universidade do Minho\"/>";
                                }else {
                                 $code=$code."<input name=\"description\" id=\"description\" class=\"form-control\" type=\"text\"  placeholder=\"ex: MIECOM - Universidade do Minho\"/>";
                                }
                                
                                 $code=$code."</div>
                                  </div>
                                  <div class=\"row\">
                                  <div class=\"col-lg-5\">
                                   <label>Website</label>   ";
                                 
                                 if(!empty($student['address'])){
                                        $code=$code."             
                                            <input name=\"address\" id=\"address\" class=\"form-control\" type=\"text\" value='".$student['address']."' placeholder=\"ex: mecom.eng.uminho.pt\"/>";
                                            }
                                            else {
                                              $code=$code."             
                                            <input name=\"address\" id=\"address\" class=\"form-control\" type=\"text\" placeholder=\"ex: mecom.eng.uminho.pt\"/>";
                                            }
                                            
                               $code=$code." </div>
                                    </div>
                                    
                                </div>
                                <br/>
                            ";
                            }

   echo $code;
}


if (strcmp($_REQUEST['examinationsfunction'], "document")==0) {


    $userID = $_POST['id'];  
    $idexam = $_POST['idexam'];         // get data
    
 
    $document = $client->call('liststudentbyExam', array('idexam'=>$idexam ) );
 
    $ndocument = count($document);

    
    if (!empty($document['title'])){
      $code="  
                           
                            <div class=\"row\">
                                <div class=\"col-lg-6\">
                                    <label for=\"filetitle\"> Title <a class=\"fa fa-eye\" id=\"viewfile\" href='".$document['doi']."' target= '_blank'></a> </label>
                                    <input type=\"text\" placeholder=\"Title\" id=\"filetitle\" name=\"filetitle\" value = '".$document['title']."' class=\"form-control\"/>
                                      
                                </div>
                            </div>
                               
                            
                            <br/>";
                            }
                            else if (empty($document['title'])) {
                               $code=" 
                               
                                <div class=\"row\">
                                <div class=\"col-lg-6\">
                                    <label for=\"filetitle\"></label>
                                    <input type=\"text\" placeholder=\"Title\" id=\"filetitle\" name=\"filetitle\"  class=\"form-control\"/>
                                </div>
                                </div>
                           
                            <br/>";
                            }

   echo $code;
}


if (strcmp($_REQUEST['examinationsfunction'], "updateAtributtes")==0) {


    $query = $_POST['query'];  
    $idexam = $_POST['idexam'];         // get data
    $keywords = $_POST['keywords'];
    
    $res = $dbh->query($query);
    
    if($keywords != "")
    {
        $dbh->query("DELETE FROM examkeyword` WHERE `idtheexam`='".$idexam."'");
        $i=0;
        $keywords = explode(',',$keywords);
        $count = count($keywords);       
        while($i<$count)
        {
            $dbh->query("INSERT INTO examkeyword (idtheexam, idkeywords) VALUES (".$idexam.",".$keywords[$i].")");
            $i++;
        }
    }
    
        echo " <div class=\"alert alert-warning\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Update was realized with success..
        </div>";

}

if (strcmp($_REQUEST['examinationsfunction'], "updatestudent")==0) {


    $iduser = $_POST['id'];  
    $idexam = $_POST['idexam'];   
    $name = $_POST['name'];  
    $email = $_POST['email'];  
    $linkedin = $_POST['linkedin'];  
    $description = $_POST['description'];  
    $address = $_POST['address'];  
    $number = $_POST['number'];  

    
    $query1 = "select student.idstudent from student, document, theexam where student.idstudent = document.idstudent and document.iddocument = theexam.iddocument and theexam.idtheexam = '".$idexam."';";
    $student = $dbh->query($query1);
    $id = $student->fetch(PDO::FETCH_ASSOC);
    
    $query2 = "UPDATE student SET name='".$name."', studentNumber='".$number."', description='".$number."', address='".$address."', email='".$email."', linkedin='".$linkedin."' where idstudent ='".$id['idstudent']."';";
    $res = $dbh->query($query2);
   
   echo " <div class=\"alert alert-warning\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Update was realized with success..
        </div>";  ;

}



if (strcmp($_REQUEST['examinationsfunction'], "listexamkeywordsbyexam")==0) {
     
    $idexam = $_POST['idexam'];          // get data
        
    $result = $client->call("listexamkeywordsbyexam", array('idexam'=>$idexam));	
    
    $count = count($result);
    $i=0;
    $select="";
    
    if($result[0]['idtheexam']!="")
    {
        while ($i < $count) {
            $select=$select.$result[$i]['idkeywords'];
            if($i+1 < $count)
            {
                $select=$select." ";
            }
            $i++;
        }
    }                    
    echo $select;    
}


if (strcmp($_REQUEST['examinationsfunction'], "updatedocumentbyExam")==0) {

   
    $idexam = $_POST['idexam'];   
    $filetitle = $_POST['filetitle'];  
    $doi = $_POST['doi'];  

    $queryiddocument = "select theexam.iddocument from theexam where theexam.idtheexam = '".$idexam."';";
    
    $iddocument = $dbh->query($queryiddocument);
    $id = $iddocument->fetch(PDO::FETCH_ASSOC);
    
    $querytype = "select theexam.type from theexam where theexam.idtheexam = '".$idexam."';";
    $restype = $dbh->query($querytype);
    $type = $restype->fetch(PDO::FETCH_ASSOC);
    
    
    if($doi != "")
    {
     $query2 = "UPDATE document SET title='".$filetitle."', doi='".$doi."' where iddocument ='".$id['iddocument']."';";
     $result = $dbh->query($query2);
    if($result->rowCount()){
    
    echo " <div class=\"alert alert-warning\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Update was realized with success..
        </div>";
          
        }
        else  echo " <div class=\"alert alert-warning\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Error!</strong> error in update doi..
        </div>"; 
    }
    

    //upload document
    else if(!empty($_FILES['file']) && $_FILES['file']['error'] != UPLOAD_ERR_NO_FILE)
    {
        $fName = iconv("utf-8", 'ISO-8859-1', $_FILES["file"]["name"]);                        
                                                                                        
        $path = "thesis/".$type['type']."/";
        
        if ($_FILES["file"]["error"] > 0)
        {
            echo "Error: " . $_FILES["file"]["error"] . "<br/>";
        }
 
        if (file_exists("../".$path.$fName ))
        {
            unlink("../".$path.$fName);
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
        
        $query2 = "UPDATE document SET title='".$filetitle."', doi='".$path.$_FILES["file"]["name"]."' where iddocument ='".$id['iddocument']."';";
        $result = $dbh->query($query2);
        
        if($result->rowCount()){
        
         echo " <div class=\"alert alert-warning\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Update was realized with success..
        </div>"; 
        } else {
        
        echo " <div class=\"alert alert-warning\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Error!</strong> error in uploading file..
        </div>";    
        }
                 
    }
    
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