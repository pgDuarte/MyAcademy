<?php

   print
      "<html>
       <head>
         <title>Insert Publications</title>
       </head>
       <body>
";


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
    
    
    if (strcmp($_REQUEST['supervisionsfunction'], "listAllSupervisionsforSelect")==0) {


    $userID = $_POST['id'];          // get data
    $supervisions = $client->call('listAllSupervisionsByUser', array('userID'=>$userID) );
 
    $nsupervisions = count($supervisions);
   
   
    $option="";
    
    for($i=0; $i<$nsupervisions; $i++)
    { 
        $option = $option."<option value='".$supervisions[$i]['idthesup']."'>".$supervisions[$i]['title']."</option>";
    }

   echo $option;
}

    
    // Listar os atributos para depois editar 
    
    if (strcmp($_REQUEST['supervisionsfunction'], "atributtes")==0) {

   
    $userID = $_POST['id'];   
    $idsup = $_POST['idsup'];          // get data
    $query = "select * from thesup where thesup.idthesup = '".$idsup."'";
 
    $supervisions = $client->call('lisSupByquery', array('userID'=>$userID,'query'=>$query) );
 
    $nsupervisions = count($supervisions);
   

    $option=" <div class='row' >
                                <div class='col-lg-8'>
                                    <label>Institution</label>            
                                    <input class='form-control' name='inst' id='inst' type='text' value ='".$supervisions[0]['inst']."' required=''/>                                  
                                </div>
                            </div>
                            <br/>
                            <div class='row'>
                                <div class='col-lg-3'>
                                    <label>Degree</label>            
                                    <select class='form-control' name='type' id='type'>";
                                    
                                if(strcmp($supervisions[0]['type'], "msc")==0)
                                {        
                                      $option=$option."<option value='msc' selected>MSc</option>";
                                }else  $option=$option."<option value='phd'>PhD</option>";                
                                    
              $option=$option." </select>                                                
                                </div>
                                
                                <div class='col-lg-3'>
                                    <label>Status</label>                     
                                    <select class='form-control' name='status' id='status' onchange='$('#endyeardiv').toggle();'>  ";
                               
                                if(strcmp($supervisions[0]['status'], "concluded")==0)  $option=$option." <option value='concluded' selected>Concluded</option>";
                                else  $option=$option." <option value='undergoing' selected>Undergoing</option>";
                                                 
              $option=$option." </select>                                   
                                </div>                                                                  
                            </div>
                            <br/>
                            
                            <div class='row'>
                                <div class='col-lg-3'>
                                    <label for='beginyear'>Begin year</label>            
                                    <div class='form-group'> 
                                        <input id='beginyear' class='form-control' name='beginyear' type='number' min='1966' max='2060' placeholder='ex: 2008' value = '".$supervisions[0]['beginyear']."'/>
                                    </div>            
                                </div>
                                
                                <div class='col-lg-3' id='endyeardiv'>
                                    <label for=''endyear'>End year</label>            
                                    <div class='form-group'> 
                                        <input id='endyear' class='form-control' name='endyear' type='number' min='1966' max='2060' placeholder='ex: 2014' value = '".$supervisions[0]['endyear']."' />
                                    </div>            
                                </div>   
                            </div>
                            
                        <!--    <div class='row'>
                                <div class='col-lg-4'>                                    
                                    <label for='keywordsselect'>Keywords</label>
                                    <select class='form-control' id='keywordsselect' multiple='multiple'>                                                                             
                                    </select>                                    
                                </div>
                            </div>-->
                            <br/> <!--            Co-supervisor           -->   ";
                            
                                     
                  $option=$option."
                            <br/>
                            <div id='cosupdiv'>
                                <legend class='text-left'>Co-Supervisor</legend>                            
                                <div class='row'>
                                    <div class='col-lg-4'>
                                        <label for='cosupname'>Name</label>
                                        <input id='cosupname' name='cosupname' class='form-control' type='text' value = '".$supervisions[0]['cosupname']."'/>
                                    </div>
                                </div>
                                
                                <div class='row'>
                                    <div class='col-lg-8'>
                                        <label for='cosupinst'>Institution</label>
                                        <input id='cosupinst' name='cosupinst' class='form-control' type='text' value = '".$supervisions[0]['cosupinst']."'/>
                                    </div>
                                </div>                                                                                                                
                            </div><br></br>";
                            
  
                
                
   
   echo $option;
}

    
    // Listar os atributos para depois editar 
    
    if (strcmp($_REQUEST['supervisionsfunction'], "students")==0) {
    
    $userID = $_POST['id'];   
    $idsup = $_POST['idsup'];          // get data
    $query = "select document.idstudent from thesup, document where thesup.idthesup = '".$idsup."' and thesup.iddocument = document.iddocument";
 
    $supervisions = $client->call('lisSupByquery', array('userID'=>$userID,'query'=>$query) );
    

    
    $query = "select * from student where idstudent = '".$supervisions[0]['idstudent']."';";
    
    $student = $client->call('lisSupByquery', array('userID'=>$userID,'query'=>$query) );
    
 
$option="";

    $option=$option."   <div class='row'>
                                <div class='col-lg-4'>
                                    <label for='name'>Name</label>
                                    <input id='name' name='name' class='form-control' type='text' required='' value = '".$student[0]['name']."'/>
                                </div>
                                <div class='col-lg-3'>
                                    <label for='number'>Number</label>
                                    <input id='number' name='number' class='form-control' type='text' value = '".$student[0]['studentNumber']."'/>
                                </div>
                            </div>
                            
                            <br/>
                           
                            <br/>
                            
                            <div id='program'>            
                                <div class='row'>
                                    <div class='col-lg-4'>
                                        <label>Email</label>
                                        <input name='email' id='email' class='form-control' type='text' value = '".$student[0]['email']."'/>
                                         <input type='hidden' value='".$student[0]['idstudent']."' name='idstudentx' id='idstudentx' /> 
                                    </div>
                                </div>
                                
                                <div class='row'>
                                    <div class='col-lg-4'>
                                        <label>Linkedin</label>
                                        <input name='linkedin' id='linkedin' class='form-control' type='text' value = '".$student[0]['linkedin']."'/>
                                    </div>
                                </div>
                                
                                <div class='row'>
                                    <div class='col-lg-7'>
                                        <label>Info about the course</label>
                                        <input name='description' id='description' class='form-control' type='text' placeholder='ex: MIECOM - Universidade do Minho' value = '".$student[0]['description']."'/>
                                    </div>
                                </div>
                                
                                <div class='row'>
                                    <div class='col-lg-5'>
                                        <label>Website</label>                
                                        <input name='address' id='address' class='form-control' type='text' placeholder='ex: mecom.eng.uminho.pt' value = '".$student[0]['address']."'/>
                                    </div>
                                </div>
                                
                            </div>";
                            
                            echo $option;

}

    // Listar os atributos para depois editar 
    
    if (strcmp($_REQUEST['supervisionsfunction'], "document")==0) {
    
    $userID = $_POST['id'];   
    $idsup = $_POST['idsup'];          // get data
   
 
    $query = "select iddocument from thesup where thesup.idthesup = '".$idsup."'";

    $thesup = $client->call('lisSupByquery', array('userID'=>$userID,'query'=>$query) );
    

    
    $query = "select * from document where document.iddocument = '".$thesup[0]['iddocument']."'";

    $document = $client->call('lisSupByquery', array('userID'=>$userID,'query'=>$query) );
    

 
    $option="";

    $option=$option."<label for='filetitle'>Title <a class=\"fa fa-eye\" id=\"viewfile\" href='".$document[0]['doi']."' target= '_blank'> -  ".$document[0]['doi']."<small></small></a> </label>
                                    
                                    <input type='text' placeholder='Title' id='filetitle' name='filetitle' class='form-control' value = '".$document[0]['title']."'/>
                                    <input type='hidden' value='".$document[0]['iddocument']."' name='documentx' /> ";
                            
    echo $option;

}

if (strcmp($_REQUEST['supervisionsfunction'], "updateAttributessup")==0) {


    $query = $_POST['query'];  
    $idexam = $_POST['idsup'];         // get data
    

    $res = $dbh->query($query);
    
    if($res->rowCount()){
    echo " <div class=\"alert alert-success\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Update was realized with success..
        </div>";
        }else  {echo " <div class=\"alert alert-success\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Update was realized with success..
        </div>";}

}

if (strcmp($_REQUEST['supervisionsfunction'], "updateStudentsup")==0) {


    $query = $_POST['query'];  
   

    $res = $dbh->query($query);
    
    if($res->rowCount()){
    echo " <div class=\"alert alert-success\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Update was realized with success..
        </div>";
        }else  {echo " <div class=\"alert alert-success\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Update was realized with success..
        </div>";}

}


if (strcmp($_REQUEST['supervisionsfunction'], "updateDocumentsup")==0) {

   
    $idsup = $_POST['idsup'];   
    $filetitle = $_POST['filetitle'];  
    $doi = $_POST['doi'];  

    $queryiddocument = "select thesup.iddocument from thesup where thesup.idthesup = '".$idsup."';";
    
    $iddocument = $dbh->query($queryiddocument);
    $id = $iddocument->fetch(PDO::FETCH_ASSOC);
    
    $querytype = "select thesup.type from thesup where thesup.idthesup = '".$idsup."';";
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


    
    

?>